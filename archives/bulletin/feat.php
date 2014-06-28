<?php $title = "Digital Archives"; ?>
<?php include('header.php'); ?>
	<div class="mainpage">
		<ul class="floatRight easyAccessmenu sticky">
			<li><h2>Nelumbo</h2></li>
			<li><a href="volumes.php" ><img src="../../php/images/lb3.png" alt="" /><span class="eamSpan">volumes</span><div class="clearfix"></div></a></li>
			<li><a href="articles.php" ><img src="../../php/images/lb5.png" alt="" /><span class="eamSpan">articles</span><div class="clearfix"></div></a></li>
			<li><a href="authors.php" ><img src="../../php/images/aut.png" alt="" /><span class="eamSpan">authors</span><div class="clearfix"></div></a></li>
			<li><a href="features.php" ><img src="../../php/images/lb4.png" alt="" /><span class="eamSpan">categories</span><div class="clearfix"></div></a></li>
			<li><a href="../search.php" ><img src="../../php/images/search.png" alt="" /><span class="eamSpan">search</span><div class="clearfix"></div></a></li>
		</ul>
		<div id="contentWrapper">
<?php

include("connect.php");
require_once("../common.php");

//~ $db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
//~ $rs = mysql_select_db($database,$db) or die("No Database");

$db = new mysqli('localhost', "$user", "$password", "$database");

if($db->connect_errno > 0){
    die('Not connected to database [' . $db->connect_error . ']');
}

if(isset($_GET['feature'])){$feat_name = $_GET['feature'];}else{$feat_name = '';}
if(isset($_GET['featid'])){$featid = $_GET['featid'];}else{$featid = '';}

$feat_name = entityReferenceReplace($feat_name);

if(!(isValidFeature($feat_name) && isValidFeatid($featid)))
{
	echo "<div class=\"textSmall\" style=\"width:750px;\">Invalid URL</div>";
	echo "	</div>
		</div>
	</div>
	<div class=\"footer_top\">
		&nbsp;
	</div>
	<div class=\"footer\">
		<div class=\"footer_inside\">
			<img src=\"../../php/images/painting_background.png\" style=\"float: right;margin: -250px 0 0 0px;\"  alt=\"\"/>
			<p>
				Botanical Survey of India<br />
				CGO Complex, 3rd MSO Building, Block F (5th &amp; 6th Floor),<br />
				DF Block, Sector I, Salt Lake City, Kolkata - 700 064<br />
			</p>
			<p>Phone: +91 33 23344963 (Director), +91 33 23218991; Fax: +91 33 23346040, +91 33 23215631</p>
			<p>&copy; 2014, Botanical Survey of India<br /></p>
		</div>
	</div>
	<script type=\"text/javascript\" src=\"../../php/js/sticky.js\"></script>
	</body>
	</html>";	
	exit(1);
}


$month_name = array("0"=>"","1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

echo "<div class=\"page_title\"><span class=\"bul_motif\"></span><h2>Category:&nbsp;$feat_name</h2></div>
			<div class=\"textSmall\" style=\"width:750px;\">
				<div class=\"treeview noMTop\">
					<ul class=\"ulNeedBullets\">";
					
$query1 = "select * from article_bulletin where featid='$featid' order by volume, part, page";

//~ $result1 = mysql_query($query1);
//~ $num_rows1 = mysql_num_rows($result1);

$result1 = $db->query($query1); 
$num_rows1 = $result1->num_rows;

if($num_rows1)
{
	for($i=1;$i<=$num_rows1;$i++)
	{
		//~ $row1=mysql_fetch_assoc($result1);
		$row1 = $result1->fetch_assoc();

		$titleid=$row1['titleid'];
		$title=$row1['title'];
		$featid=$row1['featid'];
		$page=$row1['page'];
		$authid=$row1['authid'];
		$volume=$row1['volume'];
		$part=$row1['part'];
		$year=$row1['year'];
		$month=$row1['month'];
		
		$title1=addslashes($title);
		
		$query3 = "select feat_name from feature_bulletin where featid='$featid'";
		
		//~ $result3 = mysql_query($query3);		
		$result3 = $db->query($query3); 
		
		//~ $row3=mysql_fetch_assoc($result3);
		$row3 = $result3->fetch_assoc();
		
		$feature=$row3['feat_name'];
		
		$result3->free();
		
		echo "<li>";
		echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"../../Volumes/bulletin/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\">$title</a></span><br />";
		echo "<span class=\"yearspan\"><a href=\"toc.php?vol=$volume&amp;part=$part\">Vol.&nbsp;".intval($volume)."&nbsp;(No. ".$part.")&nbsp;;&nbsp;" . $month_name{intval($month)}."&nbsp;".$year."</a></span>";

		if($authid != 0)
		{
			echo "<br />&mdash;";
			$aut = preg_split('/;/',$authid);

			$fl = 0;
			foreach ($aut as $aid)
			{
				$query2 = "select * from author where authid=$aid";
				
				//~ $result2 = mysql_query($query2);
				//~ $num_rows2 = mysql_num_rows($result2);
				$result2 = $db->query($query2); 
				$num_rows2 = $result2->num_rows;

				if($num_rows2)
				{
					//~ $row2=mysql_fetch_assoc($result2);
					$row2 = $result2->fetch_assoc();

					$authorname=$row2['authorname'];
					
					if($fl == 0)
					{
						echo "<span class=\"authorspan\"><a href=\"../auth.php?authid=$aid&amp;author=".urlencode($authorname)."\">$authorname</a></span>";
						$fl = 1;
					}
					else
					{
						echo "<span class=\"titlespan\">;&nbsp;</span><span class=\"authorspan\"><a href=\"../auth.php?authid=$aid&amp;author=".urlencode($authorname)."\">$authorname</a></span>";
					}
				}
				$result2->free();
			}
		}
		echo "<br /><span class=\"downloadspan\"><a href=\"../../Volumes/bulletin/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\" target=\"_blank\">Read article (DjVu)</a>";
		echo file_exists("../../Volumes_PDF/bulletin/$volume/$part/index.pdf") ? "&nbsp;|&nbsp;<a target=\"_blank\" href=\"../../Volumes_PDF/bulletin/$volume/$part/index.pdf\">Read article (PDF)</a>" : "";
		echo "</span>";

		echo "</li>\n";
	}
}
else
{
	echo "<li>No data in the database</li>";
}


$result1->free();
$db->close();
?>
				</ul>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<div class="footer_top">
	&nbsp;
</div>
<div class="footer">
	<div class="footer_inside">
		<img src="../../php/images/painting_background.png" style="float: right;margin: -250px 0 0 0px;"  alt=""/>
		<p>
			Botanical Survey of India<br />
			CGO Complex, 3rd MSO Building, Block F (5th &amp; 6th Floor),<br />
			DF Block, Sector I, Salt Lake City, Kolkata - 700 064<br />
		</p>
		<p>Phone: +91 33 23344963 (Director), +91 33 23218991; Fax: +91 33 23346040, +91 33 23215631</p>
		<p>&copy; 2014, Botanical Survey of India<br /></p>
	</div>
</div>
<script type="text/javascript" src="../../php/js/sticky.js"></script>
</body>

</html>
