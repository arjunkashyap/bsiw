<?php $title = "Digital Archives"; ?>
<?php include('header.php'); ?>
	<div class="mainpage">
		<ul class="floatRight easyAccessmenu sticky">
			<li><h2>Nelumbo</h2></li>
			<li><a href="volumes.php" ><img src="../../php/images/lb3.png" alt="" /><span class="eamSpan">Volumes</span><div class="clearfix"></div></a></li>
			<li><a href="articles.php" ><img src="../../php/images/lb5.png" alt="" /><span class="eamSpan">Articles</span><div class="clearfix"></div></a></li>
			<li><a href="authors.php" ><img src="../../php/images/aut.png" alt="" /><span class="eamSpan">Authors</span><div class="clearfix"></div></a></li>
			<li><a href="features.php" ><img src="../../php/images/lb4.png" alt="" /><span class="eamSpan">Categories</span><div class="clearfix"></div></a></li>
			<li><a href="../search.php" ><img src="../../php/images/search.png" alt="" /><span class="eamSpan">Search</span><div class="clearfix"></div></a></li>
		</ul>
		<div id="contentWrapper">
			<div class="page_title"><span class="bul_motif"></span><h2>Categories</h2></div>
			<div class="textSmall" style="width:750px;">
				<div class="treeview noMTop">
					<ul class="ulNeedBullets">
<?php

include("connect.php");

//~ $db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
//~ $rs = mysql_select_db($database,$db) or die("No Database");

$db = @new mysqli('localhost', "$user", "$password", "$database");
if($db->connect_errno > 0)
{
	echo '<li>Not connected to the database [' . $db->connect_errno . ']</li>';
	echo "				</ul>
						</div>
					</div>
					<div class=\"clearfix\"></div>
				</div>
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

$query = "select * from feature_bulletin order by feat_name";

//~ $result = mysql_query($query);
//~ $num_rows = mysql_num_rows($result);

$result = $db->query($query);
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		//~ $row=mysql_fetch_assoc($result);
		$row = $result->fetch_assoc();
		
		$feat_name=$row['feat_name'];
		$featid=$row['featid'];

		if($feat_name != "")
		{
			echo "<li>";
			echo "<span class=\"featurespan big\"><a href=\"feat.php?feature=" . urlencode($feat_name) . "&amp;featid=$featid\">$feat_name</a></span>";
			echo "</li>\n";
		}
	}
}
else
{
	echo "<li>No data in the database</li>";
}

if($result){$result->free();}
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
