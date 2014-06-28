<?php $title = "Digital Archives"; ?>
<?php include('header.php'); ?>
	<div class="mainpage">
		<ul class="floatRight easyAccessmenu sticky">
			<li><h2>Records</h2></li>
			<li><a href="volumes.php" ><img src="../../php/images/lb3.png" alt="" /><span class="eamSpan">volumes</span><div class="clearfix"></div></a></li>
			<li><a href="articles.php" ><img src="../../php/images/lb5.png" alt="" /><span class="eamSpan">articles</span><div class="clearfix"></div></a></li>
			<li><a href="authors.php" ><img src="../../php/images/aut.png" alt="" /><span class="eamSpan">authors</span><div class="clearfix"></div></a></li>
			<li><a href="../search.php" ><img src="../../php/images/search.png" alt="" /><span class="eamSpan">search</span><div class="clearfix"></div></a></li>
		</ul>
		<div id="contentWrapper">
			<h2 class="seriesIntroTitle">Records</h2>
			<div class="seriesIntro">
				<p>The project for a Botanical Survey of the Indian Empire having now taken shape, it is considered desirable that there should be some special channel through which the results of the Survey may be communicated to those interested in the progress of Botanical Science. It has therefore been decided to issue, under the title of "Records," such reports made by officers of the Survey as shall contain matter of botanical interest or of novelty. These Records will be published, not at fixed intervals, but from time to time as appropriate materials may be received.</p>
				<p class="fright it">(from Vol. 1, No. 1 published in 1893)</p>
			</div>
			<div class="page_title"><span class="rec_motif"></span><h2>Volumes</h2></div>
			<div class="textSmall" style="width:750px;">
				<div class="treeview noMTop">
					<div class="vcol1"><ul>
<?php

include("connect.php");

//~ $db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
//~ $rs = mysql_select_db($database,$db) or die("No Database");

$db = new mysqli('localhost', "$user", "$password", "$database");

if($db->connect_errno > 0){
    die('Not connected to database [' . $db->connect_error . ']');
}

$row_count = 10;

$query = "select distinct volume from article_records order by volume";

//~ $result = mysql_query($query);
//~ $num_rows = mysql_num_rows($result);

$result = $db->query($query); 
$num_rows = $result->num_rows;

$count = 0;
$col = 1;

if($num_rows)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		//~ $row=mysql_fetch_assoc($result);
		$row = $result->fetch_assoc();
		
		$volume=$row['volume'];

		$query1 = "select distinct year from article_records where volume='$volume'";
		
		//~ $result1 = mysql_query($query1);
		//~ $num_rows1 = mysql_num_rows($result1);
		
		$result1 = $db->query($query1); 
		$num_rows1 = $result1->num_rows;		

		//~ $row1=mysql_fetch_assoc($result1);
		$row1 = $result1->fetch_assoc();

		$year=$row1['year'];
		
		$result1->free();
		
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

$result->free();
$db->close();

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
