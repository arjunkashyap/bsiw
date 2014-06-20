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

$db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
$rs = mysql_select_db($database,$db) or die("No Database");

$volume=$_GET['vol'];
$year=$_GET['year'];

echo "<div class=\"page_title\"><span class=\"bul_motif\"></span><h2>Volume&nbsp;".intval($volume)."&nbsp;(".$year.")</h2></div>
			<div class=\"textSmall\" style=\"width:750px;\">
				<div class=\"treeview noMTop\">
					<div class=\"vcol1\"><ul>";

$row_count = 4;
$month_name = array("0"=>"","1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

$query = "select distinct part from article_bulletin where volume='$volume' order by part";
$result = mysql_query($query);

$num_rows = mysql_num_rows($result);

$count = 0;
$col = 1;

if($num_rows)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		$row=mysql_fetch_assoc($result);
		$part=$row['part'];
		
		$query11 = "select min(page) as minpage from article_bulletin where volume='$volume' and part='$part'";
		$result11 = mysql_query($query11);
		$num_rows11 = mysql_num_rows($result11);
		if($num_rows11)
		{
			$row11=mysql_fetch_assoc($result11);
			$page_start = $row11['minpage'];
			$page_start = intval($page_start);
		}

		$query12 = "select max(page_end) as maxpage from article_bulletin where volume='$volume' and part='$part'";
		$result12 = mysql_query($query12);
		$num_rows12 = mysql_num_rows($result12);
		if($num_rows12)
		{
			$row12=mysql_fetch_assoc($result12);
			$page_end = $row12['maxpage'];
			$page_end = intval($page_end);
		}

		if($page_start == '0')
		{
			$page_start = 1;
		}

		$query1 = "select distinct month from article_bulletin where volume='$volume' and part='$part' order by month";
		$result1 = mysql_query($query1);
		$num_rows1 = mysql_num_rows($result1);
		if($num_rows1)
		{
			$row1=mysql_fetch_assoc($result1);
			$month = $row1['month'];

			$count++;
			if($count > $row_count)
			{
				$col++;
				echo "</ul></div>\n
				<div class=\"vcol$col\"><ul>";
				$count = 1;
			}
			
			$dpart = preg_replace("/^0/", "", $part);
			$dpart = preg_replace("/\-0/", "-", $dpart);
			
			echo "<li class=\"gap_below_small\"><span class=\"yearspan\"><a href=\"toc.php?vol=$volume&amp;part=$part\">Part&nbsp;".$dpart;
			if(intval($month) != 0)
			{
				echo "&nbsp;(".$month_name{intval($month)}.")";
			}
			echo "<br /><span class=\"gap_left\">pp. $page_start-$page_end</span></a></span></li>";
		}
	}
}
?>
						</ul>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
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
		<p>&copy; 2013, Botanical Survey of India<br /></p>
	</div>
</div>
<script type="text/javascript" src="../../php/js/sticky.js"></script>
</body>

</html>
