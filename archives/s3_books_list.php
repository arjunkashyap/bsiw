<?php $title = "Digital Archives"; ?>
<?php include('header.php'); ?>
	<div class="mainpage">
		<ul class="floatRight easyAccessmenu sticky">
			<li><h2>District Flora (Series 3)</h2></li>
			<li><a href="s3_books_list.php" ><img src="../php/images/lb1.png" alt="" /><span class="eamSpan">Books</span><div class="clearfix"></div></a></li>
			<li><a href="s3/authors.php" ><img src="../php/images/aut.png" alt="" /><span class="eamSpan">Authors</span><div class="clearfix"></div></a></li>
			<li><a href="search.php" ><img src="../php/images/search.png" alt="" /><span class="eamSpan">Search</span><div class="clearfix"></div></a></li>
		</ul>
		<div id="contentWrapper">
			<div class="seriesIntro">
				<p>The district floras describe plant species of in those areas with generic and specific keys, followed with a  short descriptions, distribution,  localities and taxonomic citations. The works also include indices to species at the end. The families are usually arranged in accordance with Bentham and Hookers systems of classifications. Till now flora of 27 districts has been published in 35 volumes.</p>
			</div>
			<div class="page_title"><span class="s3_motif"></span><h2>District Flora (Series 3)</h2></div>
			<div class="textSmall" style="width:750px;">

<?php
include("s3/connect.php");


//~ $db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
//~ $rs = mysql_select_db($database,$db) or die("No Database");

$db = new mysqli('localhost', "$user", "$password", "$database");

if($db->connect_errno > 0){
    die('Not connected to database [' . $db->connect_error . ']');
}

$query = "select * from s3_books_list order by slno";

//~ $result = mysql_query($query);
//~ $num_rows = mysql_num_rows($result);

$result = $db->query($query); 
$num_rows = $result->num_rows;

if(!$num_rows){
	echo "No data in the Database"; 
}

$month_name = array("0"=>"","1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

?>

<ul class="newBookUl">
<?php while($row = $result->fetch_assoc()){ ?>
	<?php //print_r($row); ?>
	<li>
		<div class="bookImg">
			<a href="s3/s3_books_toc.php?book_id=<?php echo $row['book_id']; ?>&amp;type=s3&amp;book_title=<?php echo urlencode($row['title']); ?>" ><img src="covers/s3/<?php echo $row['book_id']; ?>_s.jpg" alt="" /></a>
		</div>
		<div class="bookDets">
			<div class="bookTitle"><a href="s3/s3_books_toc.php?book_id=<?php echo $row['book_id']; ?>&amp;type=s3&amp;book_title=<?php echo urlencode($row['title']); ?>" ><?php echo $row['title']; ?></a></div>
			<?php $explodedAuthors = array(); ?>
			<?php if($row['authid'] != "") { ?>
			<?php $explodedAuthors = explode(';',$row['authid']); ?>
			<?php } ?>
			<?php if(count($explodedAuthors) > 0) { ?>
				<div class="bookAuthors">
					<?php foreach($explodedAuthors as $auth) { ?>
						<?php $query2 = "select * from author where authid=$auth LIMIT 1"; ?>
						<?php $result2 = $db->query($query2); ?>
						<?php while($aRow = $result2->fetch_assoc()) { ?>
							<a href="auth.php?authid=<?php echo $aRow['authid']; ?>&amp;author=<?php echo urlencode($aRow['authorname']); ?>" ><?php echo $aRow['authorname']; ?></a>
						<?php } $result2->free(); ?>
					<?php } ?>
				</div>
			<?php } ?>
			<div class="bookSecondLine">
				<?php if($row['edition'] > 0) { ?>
					<span>Edition <?php echo intval($row['edition']); ?></span>
				<?php } ?>
				<?php if($row['volume'] > 0) { ?>
					<span>Volume <?php echo intval($row['volume']); ?></span>
				<?php } ?>
				<?php if($row['part'] > 0) { ?>
					<span>Part <?php echo intval($row['part']); ?></span>
				<?php } ?>
				<?php if($row['page'] > 0) { ?>
					<span>pp <?php echo intval($row['page']); ?> - <?php echo intval($row['page_end']); ?></span>
				<?php } ?>
				<?php if($row['month'] > 0) { ?>
					<span><?php echo $month_name{intval($row['month'])}; ?> <?php echo $row['year']; ?></span>
				<?php } ?>
			</div>			
			<div class="bookButtons">
				<?php echo "<span class=\"downloadspan\"><a href=\"".$row['type']."/".$row['type']."_books_toc.php?book_id=".$row['book_id']."&amp;type=".$row['type']."&amp;book_title=".urlencode($row['title'])."\">View TOC</a>&nbsp;|&nbsp;<a href=\"../Volumes/".$row['type']."/".$row['book_id']."/index.djvu?djvuopts&amp;page=1&amp;zoom=page\" target=\"_blank\">Read Book (DjVu)</a>";
				echo file_exists("../Volumes_PDF/".$row['type']."/".$row['book_id']."/index.pdf") ? "&nbsp;|&nbsp;<a target=\"_blank\" href=\"../Volumes_PDF/".$row['type']."/".$row['book_id']."/index.pdf\">Read Book (PDF)</a>" : "";
				echo "</span>"; ?>
			</div>
		</div>
	</li>
<?php } ?>
</ul>

<?php

$result->free();
$db->close();

?>
			</div>
		</div>
	</div>
</div>
<div class="footer_top">
	&nbsp;
</div>
<div class="footer">
	<div class="footer_inside">
		<img src="../php/images/painting_background.png" style="float: right;margin: -250px 0 0 0px;"  alt=""/>
		<p>
			Botanical Survey of India<br />
			CGO Complex, 3rd MSO Building, Block F (5th &amp; 6th Floor),<br />
			DF Block, Sector I, Salt Lake City, Kolkata - 700 064<br />
		</p>
		<p>Phone: +91 33 23344963 (Director), +91 33 23218991; Fax: +91 33 23346040, +91 33 23215631</p>
		<p>&copy; 2014, Botanical Survey of India<br /></p>
	</div>
</div>
<script type="text/javascript" src="../php/js/sticky.js"></script>
</body>

</html>
