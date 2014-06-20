#!/usr/bin/perl

$host = $ARGV[0];
$db = $ARGV[1];
$usr = $ARGV[2];
$pwd = $ARGV[3];

use DBI();

my $dbh=DBI->connect("DBI:mysql:database=$db;host=$host","$usr","$pwd");

$sth11=$dbh->prepare("CREATE TABLE ocr_s4(volume varchar(10),
part varchar(10),
cur_page varchar(10),
text varchar(5000)) ENGINE=MyISAM");

$sth11->execute();
$sth11->finish(); 
@volumes = `ls Text/s4`;

for($i1=0;$i1<@volumes;$i1++)
{
	print $volumes[$i1];
	chop($volumes[$i1]);

	@files = `ls Text/s4/$volumes[$i1]/`;
	
	for($i3=0;$i3<@files;$i3++)
	{
		chop($files[$i3]);
		if($files[$i3] =~ /\.txt/)
		{
			$vol = $volumes[$i1];
			$cur_page = $files[$i3];
			
			open(DATA,"Text/s4/$vol/$cur_page")or die ("cannot open Text/s4/$vol/$cur_page");
			
			$cur_page =~ s/\.txt//g;
			
			$line=<DATA>;
			$line =~ s/'/\\'/g;
			
			$iss = "00";
			$sth1=$dbh->prepare("insert into ocr_s4 values ('$vol','$iss','$cur_page','$line')");
			$sth1->execute();
			$sth1->finish();
			
			close(DATA);
		}
	}
}
