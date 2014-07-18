<?php $title = "Digital Archives"; ?>
<?php include('header.php'); ?>
	<div class="mainpage">
		<ul class="floatRight easyAccessmenu searchRightMenu sticky">
			<li><h2></h2></li>
			<li class="gap_below"><a href="search.php" ><img src="../php/images/search.png" alt="" /><span class="eamSpan">Search</span><div class="clearfix"></div></a></li>
			<li><a href="bulletin/volumes.php" ><span class="bul_motif eam_motif"></span><span class="eamSpan">Nelumbo</span><div class="clearfix"></div></a></li>
			<li><a href="records/volumes.php" ><span class="rec_motif eam_motif"></span><span class="eamSpan">Records</span><div class="clearfix"></div></a></li>
			<li><a href="fli_books_list.php" ><span class="fli_motif eam_motif"></span><span class="eamSpan">Flora Of India</span><div class="clearfix"></div></a></li>
			<li><a href="s1_books_list.php" ><span class="s1_motif eam_motif"></span><span class="eamSpan">Fascicles (Series 1)</span><div class="clearfix"></div></a></li>
			<li><a href="s2_books_list.php" ><span class="s2_motif eam_motif"></span><span class="eamSpan">State Flora (Series 2)</span><div class="clearfix"></div></a></li>
			<li><a href="s3_books_list.php" ><span class="s3_motif eam_motif"></span><span class="eamSpan">District Flora (Series 3)</span><div class="clearfix"></div></a></li>
			<li><a href="s4_books_list.php" ><span class="s4_motif eam_motif"></span><span class="eamSpan">Miscellaneous (Series 4)</span><div class="clearfix"></div></a></li>
			<li><a href="vnv_books_list.php" ><span class="vnv_motif eam_motif"></span><span class="eamSpan">वनस्पति वाणि</span><div class="clearfix"></div></a></li>
		</ul>
<?php
include("fli/connect.php");
require_once("common.php");

//~ $db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
//~ $rs = mysql_select_db($database,$db) or die("No Database");

$db = @new mysqli('localhost', "$user", "$password", "$database");
if($db->connect_errno > 0)
{
	echo '<div class="textSmall" style="width:750px;">Not connected to the database [' . $db->connect_errno . ']</div>';
	echo "</div>
	</div>
	<div class=\"footer_top\">
		&nbsp;
	</div>
	<div class=\"footer\">
		<div class=\"footer_inside\">
			<img src=\"../php/images/painting_background.png\" style=\"float: right;margin: -250px 0 0 0px;\"  alt=\"\"/>
			<p>
				Botanical Survey of India<br />
				CGO Complex, 3rd MSO Building, Block F (5th &amp; 6th Floor),<br />
				DF Block, Sector I, Salt Lake City, Kolkata - 700 064<br />
			</p>
			<p>Phone: +91 33 23344963 (Director), +91 33 23218991; Fax: +91 33 23346040, +91 33 23215631</p>
			<p>&copy; 2014, Botanical Survey of India<br /></p>
		</div>
	</div>
	<script type=\"text/javascript\" src=\"../php/js/sticky.js\"></script>
	</body>
	</html>";	
	exit(1);
}

if(isset($_GET['authid'])){$authid = $_GET['authid'];}else{$authid = '';}
if(isset($_GET['author'])){$authorname = $_GET['author'];}else{$authorname = '';}

$authorname = entityReferenceReplace($authorname);

if(!(isValidAuthid($authid) && isValidAuthor($authorname)))
{
	echo "<div class=\"textSmall\" style=\"width:750px;\">Invalid URL</div>";
	echo "</div>
	</div>
	<div class=\"footer_top\">
		&nbsp;
	</div>
	<div class=\"footer\">
		<div class=\"footer_inside\">
			<img src=\"../php/images/painting_background.png\" style=\"float: right;margin: -250px 0 0 0px;\"  alt=\"\"/>
			<p>
				Botanical Survey of India<br />
				CGO Complex, 3rd MSO Building, Block F (5th &amp; 6th Floor),<br />
				DF Block, Sector I, Salt Lake City, Kolkata - 700 064<br />
			</p>
			<p>Phone: +91 33 23344963 (Director), +91 33 23218991; Fax: +91 33 23346040, +91 33 23215631</p>
			<p>&copy; 2014, Botanical Survey of India<br /></p>
		</div>
	</div>
	<script type=\"text/javascript\" src=\"../php/js/sticky.js\"></script>
	</body>

	</html>";	
	exit(1);
}

$month_name = array("0"=>"","1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

?>

		
		
		<div id="contentWrapper_longer">
			<div class="page_title">
				<div class="col1 colL largeSpace">
					<div class="section right" id="sec11">&nbsp;</div>
				</div>
				<h2>Bibliography of <?php echo $authorname; ?></h2>
			</div>
			<div class="textSmall minheight">
					<ul class="newBookUl articlesByUl">
<?php

$query = "(select 'type', titleid, title, page from article_bulletin where authid like '%$authid%') 
UNION ALL (select 'type', titleid, title, page from article_records where authid like '%$authid%') 
UNION ALL (select type, book_id, title, page from fli_book_toc where authid like '%$authid%') 
UNION ALL (select type, book_id, title, page from s1_book_toc where authid like '%$authid%') 
UNION ALL (select type, book_id, title, page from s2_books_list where authid like '%$authid%') 
UNION ALL (select type, book_id, title, page from s3_books_list where authid like '%$authid%') 
UNION ALL (select type, book_id, title, page from s4_books_list where authid like '%$authid%') 
UNION ALL (select type, book_id, title, page from vnv_book_toc where authid like '%$authid%') ";

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
		
		$type=$row['type'];
		$book_id=$row['titleid'];
		$title=$row['title'];
		$page=$row['page'];
		
		$title1=addslashes($title);
		$title = preg_replace('/!!(.*)!!/', "<i>$1</i>", $title);
		$title = preg_replace('/!/', "", $title);
		
		if(($type == "s2") || ($type == "s3") || ($type == "s4"))
		{
			$query_aux = "select * from ".$type."_books_list where book_id=$book_id and type='".$type."'";
			
			//~ $result_aux = mysql_query($query_aux);
			//~ $num_rows_aux = mysql_num_rows($result_aux);

			$result_aux = $db->query($query_aux); 
			$num_rows_aux = $result_aux->num_rows;
			
			//~ $row_aux=mysql_fetch_assoc($result_aux);
			$row_aux = $result_aux->fetch_assoc();

			$authid=$row_aux['authid'];
			$authorname=$row_aux['authorname'];
			$type=$row_aux['type'];
			$page=$row_aux['page'];
			
			$page_end=$row_aux['page_end'];
			$edition=$row_aux['edition'];
			$volume=$row_aux['volume'];
			$part=$row_aux['part'];
			$year=$row_aux['year'];
			$month=$row_aux['month'];
			$book_id=$row_aux['book_id'];
			
			$book_info = '';
			if($type == 's2')
			{
				$book_info = $book_info . "State Flora (Series 2) ";	
			}
			elseif($type == 's3')
			{
				$book_info = $book_info . "District Flora (Series 3) ";	
			}
			elseif($type == 's4')
			{
				$book_info = $book_info . "Miscellaneous (Series 4) ";	
			}

			if($edition != '00')
			{
				if (intval($edition) == 1)
				{
					$book_info = $book_info . " | First Edition";
				}
				if (intval($edition) == 2)
				{
					$book_info = $book_info . " | Second Edition";
				}
			}
			if($volume != '00')
			{
				$book_info = $book_info . " | Volume " . intval($volume);
			}
			if($part != '00')
			{
				$book_info = $book_info . " | Part " . intval($part);
			}
			if(intval($page) != 0)
			{
				$book_info = $book_info . " | pp " . intval($page) . " - " . intval($page_end);	
			}
			
			echo "<li>";
			echo "<span class=\"".$type."_motif motifFontBig mbottom\"></span>";
			echo "<p class=\"pnowrap\"><span class=\"titlespan\"><a href=\"".$type."/".$type."_books_toc.php?book_id=$book_id&amp;type=$type&amp;book_title=".urlencode($title)."\">$title</a></span>";
			echo "<br /><span class=\"bookspan sml\">$book_info</span>";
			echo "<span class=\"downloadspan\"><a href=\"".$type."/".$type."_books_toc.php?book_id=$book_id&amp;type=$type&amp;book_title=".urlencode($title)."\">View TOC</a>&nbsp;|&nbsp;<a target=\"_blank\" href=\"../Volumes/$type/$book_id/index.djvu?djvuopts&amp;page=1&amp;zoom=page\">Read Book (DjVu)</a>";
			echo file_exists("../Volumes_PDF/$type/$book_id/index.pdf") ? "&nbsp;|&nbsp;<a target=\"_blank\" href=\"../Volumes_PDF/$type/$book_id/index.pdf\">Read Book (PDF)</a>" : "";
			echo "</span>";
			echo "</li>\n";			
			$result_aux->free();
		}
		elseif(($type == "fli") || ($type == "s1") || ($type == "vnv"))
		{
			$book_info = "";
			
			$query_aux = "select * from ".$type."_books_list where book_id=$book_id and type='".$type."'";

			//~ $result_aux = mysql_query($query_aux);
			//~ $num_rows_aux = mysql_num_rows($result_aux);

			$result_aux = $db->query($query_aux); 
			$num_rows_aux = $result_aux->num_rows;

			//~ $row_aux=mysql_fetch_assoc($result_aux);
			$row_aux = $result_aux->fetch_assoc();
			
			$authid=$row_aux['authid'];
			$authorname=$row_aux['authorname'];
			
			$btitle = $row_aux['title'];
			$slno = $row_aux['slno'];
			$edition = $row_aux['edition'];
			$volume = $row_aux['volume'];
			$part = $row_aux['part'];
			$dpage = $row_aux['page'];
			$dpage_end = $row_aux['page_end'];
			$month = $row_aux['month'];
			$year = $row_aux['year'];

			$stitle = '';
			if($type == 'fli')
			{
				$stitle = "Flora of India ";	
			}
			elseif($type == 's1')
			{
				$stitle = "Fascicles (Series 1) ";	
			}
			elseif($type == 'vnv')
			{
				$stitle = "वनस्पति वाणि ";
				$btitle = '';
			}
			
			if($btitle != '')
			{
				$book_info = $book_info . " | " . $btitle;
			}
			if($edition != '00')
			{
				$book_info = $book_info . " | Edition " . intval($edition);
			}
			if($volume != '00')
			{
				if($type == 's1')
				{
					$book_info = $book_info . " | Fascicle " . intval($volume);
				}
				else
				{
					$book_info = $book_info . " | Volume " . intval($volume);
				}				
			}
			if($part != '00')
			{
				$book_info = $book_info . " | Part " . intval($part);
			}
			if(intval($dpage) != 0)
			{
				$book_info = $book_info . " | pp " . intval($dpage) . " - " . intval($dpage_end);	
			}
			if(intval($month) != 0)
			{
				$book_info = $book_info . " | " . $month_name{intval($month)} . " " . intval($year);	
			}

			$book_info = preg_replace("/^ /", "", $book_info);
			$book_info = preg_replace("/^\|/", "", $book_info);
			$book_info = preg_replace("/^ /", "", $book_info);

			echo "<li>";
			echo "<span class=\"".$type."_motif motifFontBig mbottom\"></span>";
			echo "<p class=\"pnowrap\"><span class=\"titlespan\"><a target=\"_blank\" href=\"../Volumes/$type/$book_id/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\">$title</a></span>";
			echo "<span class=\"bookspan sml\">$stitle | $book_info</span>";
			echo "<span class=\"downloadspan\"><a href=\"".$type."/".$type."_books_toc.php?book_id=$book_id&amp;type=$type&amp;book_title=".urlencode($btitle)."\">View TOC</a>&nbsp;|&nbsp;<a target=\"_blank\" href=\"../Volumes/$type/$book_id/index.djvu?djvuopts&amp;page=1&amp;zoom=page\">Read Book (DjVu)</a>";
			echo file_exists("../Volumes_PDF/$type/$book_id/index.pdf") ? "&nbsp;|&nbsp;<a target=\"_blank\" href=\"../Volumes_PDF/$type/$book_id/index.pdf\">Read Book (PDF)</a>" : "";
			echo "</span>";
			echo "</li>\n";
			$result_aux->free();
		}
		elseif(($type == "type"))
		{
			$titleid = $book_id;

			if(preg_match("/^bul/", $book_id))
			{
				$type = "bulletin";
				$dtype = "Nelumbo";
			}
			elseif(preg_match("/^rec/", $book_id))
			{
				$type = "records";
				$dtype = "Records";
			}
						
			$query_aux = "select * from article_".$type." where titleid='$titleid'";
			
			//~ $result_aux = mysql_query($query_aux);
			//~ $row_aux=mysql_fetch_assoc($result_aux);
			
			$result_aux = $db->query($query_aux); 
			$row_aux = $result_aux->fetch_assoc();

			$titleid=$row_aux['titleid'];
			$title=$row_aux['title'];
			$featid=$row_aux['featid'];
			$page=$row_aux['page'];
			$authid=$row_aux['authid'];
			$volume=$row_aux['volume'];
			$part=$row_aux['part'];
			$year=$row_aux['year'];
			$month=$row_aux['month'];
			
			$paper = $volume;	
			$title1=addslashes($title);
					
			$query3 = "select feat_name from feature_".$type." where featid='$featid'";

			//~ $result3 = mysql_query($query3);		
			$result3 = $db->query($query3); 
			
			//~ $row3=mysql_fetch_assoc($result3);
			$row3 = $result3->fetch_assoc();

			$feature=$row3['feat_name'];
			
			$result3->free();
					
			echo "<li>";
			echo "<span class=\"".$type."_motif motifFontBig mbottom\"></span>";
			echo "<p class=\"pnowrap\"><span class=\"titlespan\"><a target=\"_blank\" href=\"../Volumes/$type/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\">$title</a></span>";
			echo "<br /><span class=\"bookspan sml\">$dtype&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$type/toc.php?vol=$volume&amp;part=$part\" target=\"_blank\">Vol.&nbsp;".intval($volume)."&nbsp;(p. ".$part.")&nbsp;;&nbsp;" . $month_name{intval($month)}."&nbsp;".$year."</a>";
			if($feature != "")
			{
				echo "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$type/feat.php?feature=".urlencode($feature)."&amp;featid=$featid\">$feature</a>";
			}
			echo "</span>";
			echo "<span class=\"downloadspan\"><a href=\"$type/toc.php?vol=$volume&amp;part=$part\" target=\"_blank\">View TOC</a>&nbsp;|&nbsp;<a target=\"_blank\" href=\"../Volumes/$type/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\">Read article (DjVu)</a>";
			echo file_exists("../Volumes_PDF/$type/$volume/$part/index.pdf") ? "&nbsp;|&nbsp;<a target=\"_blank\" href=\"../Volumes_PDF/$type/$volume/$part/index.pdf\">Read article (PDF)</a>" : "";
			echo "</span>";
			echo "</li>\n";
			
			$result_aux->free();
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
			<div class="clearfix"></div>
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

