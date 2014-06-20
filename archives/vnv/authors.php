<?php $title = "Digital Archives"; ?>
<?php include('header.php'); ?>
	<div class="mainpage">
		<ul class="floatRight easyAccessmenu sticky">
			<li><h2>वनस्पति वाणि</h2></li>
			<li><a href="../vnv_books_list.php" ><img src="../../php/images/lb1.png" alt="" /><span class="eamSpan">books</span><div class="clearfix"></div></a></li>
			<li><a href="../vnv/authors.php" ><img src="../../php/images/aut.png" alt="" /><span class="eamSpan">authors</span><div class="clearfix"></div></a></li>
			<li><a href="../search.php" ><img src="../../php/images/search.png" alt="" /><span class="eamSpan">search</span><div class="clearfix"></div></a></li>
		</ul>

		<div id="contentWrapper">
			<div class="page_title"><span class="vnv_motif"></span><h2>Authors <span class="it">(वनस्पति वाणि)</span></h2></div>
			<div class="textSmall" style="width:750px;">
				<div class="treeview noMTop">
					<ul class="ulNeedBullets">

<?php

include("connect.php");

$db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
$rs = mysql_select_db($database,$db) or die("No Database");

if(isset($_GET['letter']))
{
	$letter=$_GET['letter'];
	if($letter == '')
	{
		$letter = '';
	}
}
else
{
	$letter = '';
}


$query = "select * from author where type like '%$type_code%' order by authorname";
//$query = "select * from author where authorname like '$letter%' order by authorname";
$result = mysql_query($query);

$num_rows = mysql_num_rows($result);

if($num_rows)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		$row=mysql_fetch_assoc($result);

		$authid=$row['authid'];
		$authorname=$row['authorname'];

		echo "<li>";
		echo "<span class=\"authorspan big\"><a href=\"../auth.php?authid=$authid&amp;author=".urlencode($authorname)."\">$authorname</a></span>";
		echo "</li>\n";
	}
}
else
{
	echo "<li>Sorry! No author names were found to begin with the letter '$letter' in वनस्पति वाणि</li>";
}

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
		<p>&copy; 2013, Botanical Survey of India<br /></p>
	</div>
</div>
<script type="text/javascript" src="../../php/js/sticky.js"></script>
</body>

</html>
