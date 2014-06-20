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
			<h2 class="seriesIntroTitle">Nelumbo</h2>
			<div class="seriesIntro">
				<p>The first issue of the in-house journal of the Botanical Survey of India, the 'Bulletin ofthe Botanical Survey of India', initiated to facilitate publications of the researchers and botanists of the Survey, universities and other research institutes, appeared in 1959 under the editorship of Fr. H. Santapau, the then, Director of the Survey. The journal went on for 50 years publishing research articles concerning taxonomy and allied fields with contributions coming from the scientists of the Survey and also from other institutions. The Survey being the only national organization exclusively mandated for taxonomy, the name NELUMBO, the genus to which the national flower belongs to (Nelumbo nucifera), was felt appropriate.</p>
			</div>
			<div class="page_title"><span class="bul_motif"></span><h2>Volumes</h2></div>
			<div class="textSmall" style="width:750px;">
				<div class="treeview noMTop">
					<div class="vcol1"><ul>
<?php

include("connect.php");

$db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
$rs = mysql_select_db($database,$db) or die("No Database");

$row_count = 15;

$query = "select distinct volume from article_bulletin order by volume";
$result = mysql_query($query);

$num_rows = mysql_num_rows($result);

$count = 0;
$col = 1;

if($num_rows)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		$row=mysql_fetch_assoc($result);
		$volume=$row['volume'];

		$query1 = "select distinct year from article_bulletin where volume='$volume'";
		$result1 = mysql_query($query1);
		$num_rows1 = mysql_num_rows($result1);
		if($num_rows1)
		{
			for($i1=1;$i1<=$num_rows1;$i1++)
			{
				$row1=mysql_fetch_assoc($result1);

				if($i1==1)
				{
					$year=$row1['year'];
				}
				else if($i1==2)
				{
					$year2 = $row1['year'];
					$year21 = preg_split('//',$year2);
					$year=$year."-".$year21[3].$year21[4];
				}
			}
			$count++;
			$volume_int = intval($volume);
			if($count > $row_count)
			{
				$col++;
				echo "</ul></div>\n
				<div class=\"vcol$col\"><ul>";
				$count = 1;
			}
			echo "<li><span class=\"yearspan\"><a href=\"part.php?vol=$volume&amp;year=$year\">Volume $volume_int ($year)</a></span></li>";
		}
	}
}

?>
						</ul>
					</div>
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
		<p>&copy; 2013, Botanical Survey of India<br /></p>
	</div>
</div>
<script type="text/javascript" src="../../php/js/sticky.js"></script>
</body>

</html>
