<?php
	// If nothing is get-ed, redirect to search page
	if(empty($_GET['author']) && empty($_GET['title']) && empty($_GET['text'])) {
		header('Location: search.php');
		exit(1);
	}
?>
<?php $title = "BSI Digital Archives"; ?>
<?php include('header.php'); ?>
	<div class="mainpage">
		<div class="mainWrapper">
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
	echo "</div></div>
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

if(isset($_GET['check']))
{
	$check=$_GET['check'];
	if(!(isValidCheck($check)))
	{
		echo "<div class=\"textSmall\" style=\"width:750px;\">Invalid URL</div>";
		echo "</div></div>
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
	
	if(isset($_GET['author'])){$author = $_GET['author'];}else{$author = '';}
	if(isset($_GET['text'])){$text = $_GET['text'];}else{$text = '';}
	if(isset($_GET['title'])){$title = $_GET['title'];}else{$title = '';}
	if(isset($_GET['searchform'])){$searchform = $_GET['searchform'];}else{$searchform = '';}
	if(isset($_GET['resetform'])){$resetform = $_GET['resetform'];}else{$resetform = '';}

	$text = entityReferenceReplace($text);
	$author = entityReferenceReplace($author);
	$title = entityReferenceReplace($title);
	$searchform = entityReferenceReplace($searchform);
	$resetform = entityReferenceReplace($resetform);

	$author = preg_replace("/[\t]+/", " ", $author);
	$author = preg_replace("/[ ]+/", " ", $author);
	$author = preg_replace("/^ /", "", $author);

	$title = preg_replace("/[\t]+/", " ", $title);
	$title = preg_replace("/[ ]+/", " ", $title);
	$title = preg_replace("/^ /", "", $title);

	$text = preg_replace("/[\t]+/", " ", $text);
	$text = preg_replace("/[ ]+/", " ", $text);
	$text = preg_replace("/^ /", "", $text);

	$text2 = $text;
	$text2d = $text;
	$text2d = preg_replace("/ /", "|", $text2d);

	if($title=='')
	{
		$title='[a-z]*';
	}
	if($author=='')
	{
		$author='[a-z]*';
	}
	
	$cfl = 0;

	$author = addslashes($author);
	$title = addslashes($title);


	if($text=='')
	{
		$iquery{"bul"}="(SELECT titleid, title, authid, authorname, page, 'type', featid from article_bulletin WHERE authorname REGEXP '$author' and title REGEXP '$title')";
		$iquery{"rec"}="(SELECT titleid, title, authid, authorname, page, 'type', featid from article_records WHERE authorname REGEXP '$author' and title REGEXP '$title')";
		$iquery{"fli"}="(SELECT book_id, title, authid, authorname, page, type, slno from fli_book_toc WHERE type='fli' and authorname REGEXP '$author' and title REGEXP '$title')";
		$iquery{"s1"}="(SELECT book_id, title, authid, authorname, page, type, slno from s1_book_toc WHERE type='s1' and authorname REGEXP '$author' and title REGEXP '$title')";
		$iquery{"s2"}="(SELECT book_id, title, authid, authorname, page, type, slno from s2_books_list WHERE type='s2' and authorname REGEXP '$author' and title REGEXP '$title')";
		$iquery{"s3"}="(SELECT book_id, title, authid, authorname, page, type, slno from s3_books_list WHERE type='s3' and authorname REGEXP '$author' and title REGEXP '$title')";
		$iquery{"s4"}="(SELECT book_id, title, authid, authorname, page, type, slno from s4_books_list WHERE type='s4' and authorname REGEXP '$author' and title REGEXP '$title')";
		$iquery{"vnv"}="(SELECT book_id, title, authid, authorname, page, type, slno from vnv_book_toc WHERE type='vnv' and authorname REGEXP '$author' and title REGEXP '$title')";
		
		$query = '';
		$mtf = '';
		for($ic=0;$ic<sizeof($check);$ic++)
		{
			if($check[$ic] != '')
			{
				$mtf = $mtf . "<span class=\"".$check[$ic]."_motif\">&nbsp;</span>\n";
				$query = $query . " UNION ALL " . $iquery{$check[$ic]};
			}
		}
		$query = preg_replace("/^ UNION ALL /", "", $query);
	}
	elseif($text!='')
	{
		$text = trim($text);
		if(preg_match("/^\"/", $text))
		{
			$stext = preg_replace("/\"/", "", $text);
			$dtext = $stext;
			$stext = '"' . $stext . '"';
		}
		elseif(preg_match("/\+/", $text))
		{
			$stext = preg_replace("/\+/", " +", $text);
			$dtext = preg_replace("/\+/", "|", $text);
			$stext = '+' . $stext;
		}
		elseif(preg_match("/\|/", $text))
		{
			$stext = preg_replace("/\|/", " ", $text);
			$dtext = $text;
		}
		else
		{
			$stext = $text;
			$dtext = $stext = preg_replace("/ /", "|", $text);
		}
		
		$stext = addslashes($stext);
		
		$iquery{"bul"}="(SELECT * FROM
							(SELECT * FROM
								(SELECT * FROM
									(SELECT titleid, title, authid, authorname, page, 'type', featid, cur_page, MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) AS relevance FROM searchtable_bulletin WHERE MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) ORDER BY relevance DESC)
								AS tb10 WHERE authorname REGEXP '$author')
							AS tb20 WHERE title REGEXP '$title')
						AS tb30 WHERE cur_page NOT REGEXP '[a-z]')";
						
		$iquery{"rec"}="(SELECT * FROM
							(SELECT * FROM
								(SELECT * FROM
									(SELECT titleid, title, authid, authorname, page, 'type', featid, cur_page, MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) AS relevance FROM searchtable_records WHERE MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) ORDER BY relevance DESC)
								AS tb10 WHERE authorname REGEXP '$author')
							AS tb20 WHERE title REGEXP '$title')
						AS tb30 WHERE cur_page NOT REGEXP '[a-z]')";

		$iquery{"fli"}="(SELECT * FROM
							(SELECT * FROM
								(SELECT * FROM
									(SELECT book_id, title, authid, authorname, page, type, slno, cur_page, MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) AS relevance FROM searchtable_fli WHERE MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) ORDER BY relevance DESC)
								AS tb10 WHERE authorname REGEXP '$author')
							AS tb20 WHERE title REGEXP '$title')
						AS tb30 WHERE cur_page NOT REGEXP '[a-z]')";

		$iquery{"s1"}="(SELECT * FROM
							(SELECT * FROM
								(SELECT * FROM
									(SELECT book_id, title, authid, authorname, page, type, slno, cur_page, MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) AS relevance FROM searchtable_s1 WHERE MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) ORDER BY relevance DESC)
								AS tb10 WHERE authorname REGEXP '$author')
							AS tb20 WHERE title REGEXP '$title')
						AS tb30 WHERE cur_page NOT REGEXP '[a-z]')";
		
		$iquery{"s2"}="(SELECT * FROM
							(SELECT * FROM
								(SELECT * FROM
									(SELECT book_id, title, authid, authorname, page, type, slno, cur_page, MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) AS relevance FROM searchtable_s2 WHERE MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) ORDER BY relevance DESC)
								AS tb10 WHERE authorname REGEXP '$author')
							AS tb20 WHERE title REGEXP '$title')
						AS tb30 WHERE cur_page NOT REGEXP '[a-z]')";
		
		$iquery{"s3"}="(SELECT * FROM
							(SELECT * FROM
								(SELECT * FROM
									(SELECT book_id, title, authid, authorname, page, type, slno, cur_page, MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) AS relevance FROM searchtable_s3 WHERE MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) ORDER BY relevance DESC)
								AS tb10 WHERE authorname REGEXP '$author')
							AS tb20 WHERE title REGEXP '$title')
						AS tb30 WHERE cur_page NOT REGEXP '[a-z]')";
					
		$iquery{"s4"}="(SELECT * FROM
							(SELECT * FROM
								(SELECT * FROM
									(SELECT book_id, title, authid, authorname, page, type, slno, cur_page, MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) AS relevance FROM searchtable_s4 WHERE MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) ORDER BY relevance DESC)
								AS tb10 WHERE authorname REGEXP '$author')
							AS tb20 WHERE title REGEXP '$title')
						AS tb30 WHERE cur_page NOT REGEXP '[a-z]')";
					
		$iquery{"vnv"}="(SELECT * FROM
							(SELECT * FROM
								(SELECT * FROM
									(SELECT book_id, title, authid, authorname, page, type, slno, cur_page, MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) AS relevance FROM searchtable_vnv WHERE MATCH (text) AGAINST ('$stext' IN BOOLEAN MODE) ORDER BY relevance DESC)
								AS tb10 WHERE authorname REGEXP '$author')
							AS tb20 WHERE title REGEXP '$title')
						AS tb30 WHERE cur_page NOT REGEXP '[a-z]')";
				
		$query = '';
		$mtf = '';
		for($ic=0;$ic<sizeof($check);$ic++)
		{
			if($check[$ic] != '')
			{
				$mtf = $mtf . "<span class=\"".$check[$ic]."_motif\">&nbsp;</span>\n";
				$query = $query . " UNION ALL " . $iquery{$check[$ic]};
			}
		}
		$query = preg_replace("/^ UNION ALL /", "", $query);
		
/*
		$query = $query . " ORDER by year,month,volume,part,cur_page";
*/
	}

	//~ $result = mysql_query($query);
	//~ $num_results = mysql_num_rows($result);
	
	$result = $db->query($query);
	$num_results = $result ? $result->num_rows : 0;
	
	echo "<div id=\"contentWrapper_longer\" style=\"width:680px;\">
			<div class=\"page_title\">
				<div class=\"col1 colL largeSpace\">
					<div class=\"section right\" id=\"sec11\">&nbsp;</div>
				</div>
				<h2>Search Results";
	echo ($num_results > 0) ? " - <span class=\"it\"><span id=\"searchCount\">$num_results</span> result(s)</span>" : "";
	echo "<span class=\"all_motifs\">$mtf</span>";
	echo "</h2>
			</div>
			<div class=\"textSmall minheight\">";
	$titleid[0]=0;
	$count = 1;
	$id = "0";
	if($num_results > 0)
	{
		echo "<ul class=\"newBookUl articlesByUl minheight_longer\">";
		for($i=1;$i<=$num_results;$i++)
		{
			//~ $row1 = mysql_fetch_assoc($result);
			$row1 = $result->fetch_assoc();

			if(isset($row1['titleid']))
			{
				$book_id = $row1['titleid'];
			}
			else
			{
				$book_id = $row1['book_id'];
			}
			
			$title = $row1['title'];
			$authid = $row1['authid'];
			$authorname = $row1['authorname'];
			$page = $row1['page'];
			$type = $row1['type'];
			
			if(isset($row1['featid']))
			{
				$slno = $row1['featid'];
			}
			else
			{
				$slno = $row1['slno'];
			}			
			
			if($type == "type")
			{
				$slno = $book_id;
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
			}
			
			$title = preg_replace('/!!(.*)!!/', "<i>$1</i>", $title);
			$title = preg_replace('/!/', "", $title);

			if($text != '')
			{
				$cur_page = $row1['cur_page'];
			}
			
			$title1=addslashes($title);
			
			if ($id != $slno)
			{
				if($id == 0)
				{
					echo "\n<li><span class=\"".$type."_motif motifFontBig mbottom\"></span>";
				}
				else
				{
					echo "</li>\n<li><span class=\"".$type."_motif motifFontBig mbottom\"></span>";
				}
				
				if(($type == "s2") || ($type == "s3") || ($type == "s4"))
				{
					$book_info = '';
					
					$query_aux = "select * from ".$type."_books_list where book_id='$book_id' and type='$type'";
					
					//~ $result_aux = mysql_query($query_aux);
					//~ $num_rows_aux = mysql_num_rows($result_aux);
					
					$result_aux = $db->query($query_aux); 
					$num_rows_aux = $result_aux->num_rows;

					//~ $row_aux=mysql_fetch_assoc($result_aux);
					$row_aux = $result_aux->fetch_assoc();

					$page_end = $row_aux['page_end'];
					$edition = $row_aux['edition'];
					$volume = $row_aux['volume'];
					$part = $row_aux['part'];
					$year = $row_aux['year'];
					$month = $row_aux['month'];
					
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
					
					echo "<p class=\"pnowrap\"><span class=\"titlespan\"><a href=\"".$type."/".$type."_books_toc.php?book_id=$book_id&amp;type=$type&amp;book_title=" . urlencode($title) . "\">$title</a></span>";
					echo "<br /><span class=\"bookspan sml\">$book_info</span>";
					print_author($authid,$db);
					echo "<span class=\"downloadspan\"><a href=\"".$type."/".$type."_books_toc.php?book_id=$book_id&amp;type=$type&amp;book_title=" . urlencode($title) . "\">View TOC</a>&nbsp;|&nbsp;<a target=\"_blank\" href=\"../Volumes/$type/$book_id/index.djvu?djvuopts&amp;page=1&amp;zoom=page\">Read Book (DjVu)</a>";
					echo file_exists("../Volumes_PDF/$type/$book_id/index.pdf") ? "&nbsp;|&nbsp;<a target=\"_blank\" href=\"../Volumes_PDF/$type/$book_id/index.pdf\">Read Book (PDF)</a>" : "";
					echo "</span>";
					$id = $slno;
					
					if($text != '')
					{
						echo "<br /><span class=\"downloadspan\">result(s) found at page no(s). </span>";
						echo "<span class=\"downloadspan\"><a href=\"../Volumes/$type/$book_id/index.djvu?djvuopts&amp;page=$cur_page.djvu&amp;zoom=page&amp;find=$dtext/r\" target=\"_blank\">".intval($cur_page)."</a> &nbsp;</span>";
						$id = $slno;
					}
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
					
					$btitle = $row_aux['title'];
					$slno = $row_aux['slno'];
					$edition = $row_aux['edition'];
					$volume = $row_aux['volume'];
					$part = $row_aux['part'];
					$dpage = $row_aux['page'];
					$dpage_end = $row_aux['page_end'];
					$month = $row_aux['month'];
					$year = $row_aux['year'];
					
					$btitle = preg_replace('/!!(.*)!!/', "<i>$1</i>", $btitle);
					$btitle = preg_replace('/!/', "", $btitle);
		
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

					echo "<p class=\"pnowrap\"><span class=\"titlespan\"><a target=\"_blank\" href=\"../Volumes/$type/$book_id/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\">$title</a></span>";
					echo "<span class=\"bookspan sml\">$stitle | $book_info</span>";
					print_author($authid,$db);
					echo "<span class=\"downloadspan\"><a href=\"".$type."/".$type."_books_toc.php?book_id=$book_id&amp;type=$type&amp;book_title=" . urlencode($btitle) . "\">View TOC</a>&nbsp;|&nbsp;<a target=\"_blank\" href=\"../Volumes/$type/$book_id/index.djvu?djvuopts&amp;page=1&amp;zoom=page\">Read Book (DjVu)</a>";
					echo file_exists("../Volumes_PDF/$type/$book_id/index.pdf") ? "&nbsp;|&nbsp;<a target=\"_blank\" href=\"../Volumes_PDF/$type/$book_id/index.pdf\">Read Book (PDF)</a>" : "";
					echo "</span>";
					$id = $slno;
					
					if($text != '')
					{
						echo "<br /><span class=\"downloadspan\">result(s) found at page no(s). </span>";
						echo "<span class=\"downloadspan\"><a href=\"../Volumes/$type/$book_id/index.djvu?djvuopts&amp;page=$cur_page.djvu&amp;zoom=page&amp;find=$dtext/r\" target=\"_blank\">".intval($cur_page)."</a> &nbsp;</span>";
						$id = $slno;
					}
					$result_aux->free();
				}
				elseif(($type == "bulletin") || ($type == "records"))
				{
					$titleid = $book_id;
					
					$query_aux = "select * from article_".$type." where titleid='$titleid'";

					//~ $result_aux = mysql_query($query_aux);
					$result_aux = $db->query($query_aux); 
					
					//~ $row_aux=mysql_fetch_assoc($result_aux);
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
					
					echo "<p class=\"pnowrap\"><span class=\"titlespan\"><a target=\"_blank\" href=\"../Volumes/$type/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\">$title</a></span>";
					echo "<br /><span class=\"bookspan sml\">$dtype&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$type/toc.php?vol=$volume&amp;part=$part\" target=\"_blank\">Vol.&nbsp;".intval($volume)."&nbsp;(p. ".$part.")&nbsp;;&nbsp;" . $month_name{intval($month)}."&nbsp;".$year."</a>";
					if($feature != "")
					{
						echo "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"$type/feat.php?feature=".urlencode($feature)."&amp;featid=$featid\">$feature</a>";
					}
					echo "</span>";
					print_author($authid,$db);
					echo "<span class=\"downloadspan\"><a href=\"$type/toc.php?vol=$volume&amp;part=$part\" target=\"_blank\">View TOC</a>&nbsp;|&nbsp;<a target=\"_blank\" href=\"../Volumes/$type/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\">Read article (DjVu)</a>";
					echo file_exists("../Volumes_PDF/$type/$volume/$part/index.pdf") ? "&nbsp;|&nbsp;<a target=\"_blank\" href=\"../Volumes_PDF/$type/$volume/$part/index.pdf\">Read article (PDF)</a>" : "";
					echo "</span>";
					
					if($text != '')
					{
						echo "<br /><span class=\"downloadspan\">result(s) found at page no(s). </span>";
						echo "<span class=\"downloadspan\"><a href=\"../Volumes/$type/$volume/$part/index.djvu?djvuopts&amp;page=$cur_page.djvu&amp;zoom=page&amp;find=$dtext/r\" target=\"_blank\">".intval($cur_page)."</a> &nbsp;</span>";
						$id = $titleid;
					}
					$result_aux->free();
				}
			}
			else
			{
				if($text != '')
				{
					if(($type == "bulletin") || ($type == "records"))
					{
						echo "<span class=\"downloadspan\"><a href=\"../Volumes/$type/$volume/$part/index.djvu?djvuopts&amp;page=$cur_page.djvu&amp;zoom=page&amp;find=$dtext/r\" target=\"_blank\">".intval($cur_page)."</a> &nbsp;</span>";
						$id = $titleid;
					}
					else
					{
						echo "<span class=\"downloadspan\"><a href=\"../Volumes/$type/$book_id/index.djvu?djvuopts&amp;page=$cur_page.djvu&amp;zoom=page&amp;find=$dtext/r\" target=\"_blank\">".intval($cur_page)."</a> &nbsp;</span>";
						$id = $slno;
					}
				}
			}
		}
		echo "</li></ul>";
	}
	else
	{
		echo"<span class=\"titlespan\">No results</span><br />";
		echo"<span class=\"authorspan\"><a href=\"search.php\">Go back and Search again</a></span>";
	}
	if($result){$result->free();}
}
else
{
	echo"<span class=\"titlespan\">Please slect at least one publication</span><br />";
	echo"<span class=\"authorspan\"><a href=\"search.php\">Go back and Search again</a></span>";
}
$db->close();
?>
				</div>
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

<?php

function print_author($authid,$db)
{
	if($authid != 0)
	{

		echo "&mdash;";
		$aut = preg_split('/;/',$authid);

		$fl = 0;
		foreach ($aut as $aid)
		{
			$query2 = "select * from author where authid=$aid";

			//~ $result2 = mysql_query($query2);
			//~ $num_rows2 = mysql_num_rows($result2);
			
			$result2 = $db->query($query2); 
			$num_rows2 = $result2 ? $result2->num_rows : 0;

			if($num_rows2 > 0)
			{
				//~ $row2=mysql_fetch_assoc($result2);
				$row2 = $result2->fetch_assoc();

				$authorname=$row2['authorname'];
				
				if($fl == 0)
				{
					echo "<span class=\"authorspan\"><a href=\"auth.php?authid=$aid&amp;author=".urlencode($authorname)."\">$authorname</a></span>";
					$fl = 1;
				}
				else
				{
					echo "<span class=\"titlespan\">;&nbsp;</span><span class=\"authorspan\"><a href=\"auth.php?authid=$aid&amp;author=".urlencode($authorname)."\">$authorname</a></span>";
				}
			}
			if($result2){$result2->free();}
		}
		echo "<br />";
	}
}

?>
