#!/usr/bin/perl

$host = $ARGV[0];
$db = $ARGV[1];
$usr = $ARGV[2];
$pwd = $ARGV[3];

use DBI();

open(IN,"bsi_s3_books.xml") or die "can't open bsi_s3_books.xml\n";

my $dbh=DBI->connect("DBI:mysql:database=$db;host=$host","$usr","$pwd");

$line = <IN>;

while($line)
{
	if($line =~ /<s([0-9]+) title="(.*)" author="(.*)" page="(.*)" info="(.*)" type="(.*)" date="(.*)">/)
	{
		$authors = $3;
		$type = $6;
		$type_code = '5';
		
		if($authors ne '')
		{
			insert_authors($authors, $type_code);
			$type = '';
			$type_code = '';			
		}
	}
	$line = <IN>;
}

close(IN);
$dbh->disconnect();


sub insert_authors()
{
	my($authors, $type_code) = @_;
	my(@list,$i,$authorname);
	my($sth,$ref,$sth1);
	
	@list = split(/;/,$authors);
	for($i=0;$i<@list;$i++)
	{

		$authorname = $list[$i];
		$authorname =~ s/'/\\'/g;

		$sth = $dbh->prepare("select * from author where authorname='$authorname'");
		$sth->execute();
		$ref=$sth->fetchrow_hashref();
		if($sth->rows()==0)
		{
			$sth1=$dbh->prepare("insert into author values('$authorname','$type_code',null)");
			$sth1->execute();
			$sth1->finish();
		}
		else
		{
			$type = $ref->{'type'};
			$authid = $ref->{'authid'};
			
			if(!($type=~/$type_code/))
			{
				$type = $type . ";" . $type_code;
				$sth1=$dbh->prepare("update author set type='$type' where authid='$authid' and authorname='$authorname'");
				$sth1->execute();
				$sth1->finish();
			}
			
		}
		$sth->finish();	
	}
}
