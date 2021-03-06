#!/usr/bin/perl

$host = $ARGV[0];
$db = $ARGV[1];
$usr = $ARGV[2];
$pwd = $ARGV[3];

use DBI();

open(IN,"bsi_bulletin.xml") or die "can't open bsi_bulletin.xml\n";

my $dbh=DBI->connect("DBI:mysql:database=$db;host=$host","$usr","$pwd");

$sth11=$dbh->prepare("CREATE TABLE feature_bulletin(feat_name varchar(200), featid int(6) auto_increment, primary key(featid))auto_increment=10001 ENGINE=MyISAM;");
$sth11->execute();
$sth11->finish(); 

$line = <IN>;

while($line)
{
	if($line =~ /<feature>(.*)<\/feature>/)
	{
		$feat_name = $1;
		insert_feature($feat_name);		
	}
	$line = <IN>;
}

close(IN);
$dbh->disconnect();


sub insert_feature()
{
	my($feat_name) = @_;

	$feat_name =~ s/'/\\'/g;
	
	my($sth,$ref,$sth1);
	$sth = $dbh->prepare("select featid from feature_bulletin where feat_name='$feat_name'");
	$sth->execute();
	$ref=$sth->fetchrow_hashref();
	if($sth->rows()==0)
	{
		$sth1=$dbh->prepare("insert into feature_bulletin values('$feat_name',null)");
		$sth1->execute();
		$sth1->finish();
	}
	$sth->finish();	
}
