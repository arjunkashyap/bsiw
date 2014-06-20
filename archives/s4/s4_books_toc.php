<?php $title = "Digital Archives"; ?>
<?php include('header.php'); ?>
	<div class="mainpage">
		<ul class="floatRight easyAccessmenu sticky">
			<li><h2>Miscellaneous (Series 4)</h2></li>
			<li><a href="../s4_books_list.php" ><img src="../../php/images/lb1.png" alt="" /><span class="eamSpan">Books</span><div class="clearfix"></div></a></li>
			<li><a href="../s4/authors.php" ><img src="../../php/images/aut.png" alt="" /><span class="eamSpan">Authors</span><div class="clearfix"></div></a></li>
			<li><a href="../search.php" ><img src="../../php/images/search.png" alt="" /><span class="eamSpan">Search</span><div class="clearfix"></div></a></li>
		</ul>

<?php

include("connect.php");

$book_id = $_GET['book_id'];
$type = $_GET['type'];
$book_title = $_GET['book_title'];

$db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
$rs = mysql_select_db($database,$db) or die("No Database");

$query = "select * from s4_book_toc where book_id=$book_id and type='$type' order by slno";
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);

$stack = array();
$p_stack = array();
$first = 1;

$li_id = 0;
$ul_id = 0;

$plus_link = "<img class=\"bpointer\" title=\"Expand\" src=\"../images/plus.gif\" alt=\"Expand or Collapse\" onclick=\"display_block_inside(this)\" />";
//$plus_link = "<a href=\"#\" onclick=\"display_block(this)\"><img src=\"plus.gif\" alt=\"\"></a>";
$bullet = "<img class=\"bpointer\" src=\"../images/bullet_1.gif\" alt=\"Point\" />";

//~ $plus_link = "+";
//~ $bullet = ".";


$query_aux = "select * from s4_books_list where book_id=$book_id and type='s4'";
$result_aux = mysql_query($query_aux);
$num_rows_aux = mysql_num_rows($result_aux);
$row_aux=mysql_fetch_assoc($result_aux);

$edition = $row_aux['edition'];
$volume = $row_aux['volume'];
$part = $row_aux['part'];
$authorname = $row_aux['authorname'];
$page = $row_aux['page'];
$page_end = $row_aux['page_end'];
$type = $row_aux['type'];

$anames = preg_replace("/;/", ",&nbsp;&nbsp;", $authorname);
$anames = preg_split("/;/", $authorname);

$daname = '';

if(sizeof($anames) > 1)
{
	for($i=0; $i<(sizeof($anames) - 1); $i++)
	{
		$daname = $daname . ",&nbsp;&nbsp;" . $anames[$i];
	}
	$daname = preg_replace("/^,&nbsp;&nbsp;/", "", $daname);
	$daname = $daname . "&nbsp;&nbsp;and&nbsp;&nbsp;" . $anames[sizeof($anames) - 1];
}
else
{
	$daname = $authorname;
}

?>
		<div id="contentWrapper">
			<div class="page_title"><span class="s4_motif"></span><h2><?php echo $book_title; ?></h2><a target="_blank" href="<?php echo "../../Volumes/$type/$book_id/index.djvu?djvuopts&amp;page=1&amp;zoom=page"?>" title="Read the book"><img src="../covers/s4/<?php echo $book_id; ?>_l.jpg" alt="" style="float:right;margin-top:-20px;margin-right:10px" /></a></div>
			<div class="textSmall" style="width:750px;">
				<div class="page_author"><span class="bookAuthors"><?php echo $daname; ?></span></div>
				<div class="page_other">

<?php

$book_info = '';
		
if($edition != '00')
{
	$book_info = $book_info . "Edition " . intval($edition);
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

if($type == 's4')
{
	$book_info = $book_info . " | Miscellaneous (Series 4) ";	
}

$book_info = preg_replace("/^ /", "", $book_info);
$book_info = preg_replace("/^\|/", "", $book_info);
$book_info = preg_replace("/^ /", "", $book_info);

echo "$book_info</div>";
if($num_rows)
{
	echo "<div class=\"treeview noMTop\">";
	for($i=1;$i<=$num_rows;$i++)
	{
		$row=mysql_fetch_assoc($result);
		
		$level = $row['level'];
		$title = $row['title'];
		$page = $row['page'];
		$type = $row['type'];
		$slno = $row['slno'];
		
		if(($title == "Systematic Index")||($title == "Systematic List of Species")||($title == "Systematic Description of Species")||($title == "Systematic Contents")||($title == "Systematic Account")||($title == "Systematic List"))
		{
			$title = "<span class=\"featurespan\"><a href=\"s4_si.php?book_id=$book_id&amp;type=$type&amp;book_title=$book_title\">$title</a></span>";
		}
		else
		{
			if($page == '')
			{
				$title = "<span class=\"titlespan\"><a href=\"#\">$title</a></span>";
			}
			else
			{
				$title = "<span class=\"titlespan\"><a target=\"_blank\" href=\"../../Volumes/$type/$book_id/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\">$title</a></span>";
			}
		}
		$title = preg_replace('/!!(.*)!!/', "<i>$1</i>", $title);
		if($first)
		{
			array_push($stack,$level);
			$ul_id++;
			echo "<ul class=\"ulNoBullets\" id=\"ul_id$ul_id\">\n";
			array_push($p_stack,$ul_id);
			$li_id++;
			//echo "<li>$title(" . $stack[sizeof($stack)-1] . ")\n";
			//echo "<li>$title\n";
			$deffer = display_tabs($level) . "<li id=\"li_id$li_id\">:rep:$title";
			$first = 0;
		}
		elseif($level > $stack[sizeof($stack)-1])
		{
			//$parent_id = "ul_id" . $p_stack[sizeof($p_stack)-1];
			//$alt_link = $plus_link;
			//$alt_link = preg_replace('/#/',"#$parent_id",$alt_link);
			$deffer = preg_replace('/:rep:/',"$plus_link",$deffer);
			echo $deffer;			

			$ul_id++;			
			$li_id++;			
			array_push($stack,$level);
			array_push($p_stack,$ul_id);
			//echo "<ul>\n\t<li>$title(" . display_stack($stack) . ")\n";
			//echo "<ul>\n\t<li>$title\n";
			$deffer = "\n" . display_tabs(($level-1)) . "<ul class=\"dnone\" style=\"display:none;\" id=\"ul_id$ul_id\">\n";
			$deffer = $deffer . display_tabs($level) ."<li id=\"li_id$li_id\">:rep:$title";
		}
		elseif($level < $stack[sizeof($stack)-1])
		{
			$deffer = preg_replace('/:rep:/',"$bullet",$deffer);
			echo $deffer;
			
			for($k=sizeof($stack)-1;(($k>=0) && ($level != $stack[$k]));$k--)
			{
				echo "</li>\n". display_tabs($level) ."</ul>\n";
				$top = array_pop($stack);
				$top1 = array_pop($p_stack);
			}
			$li_id++;
			//echo "</li>\n<li>$title(" . display_stack($stack) . ")\n";
			$deffer = display_tabs($level) . "</li>\n";
			$deffer = $deffer . display_tabs($level) ."<li id=\"li_id$li_id\">:rep:$title";
		}
		elseif($level == $stack[sizeof($stack)-1])
		{
			$deffer = preg_replace('/:rep:/',"$bullet",$deffer);
			echo $deffer;
			$li_id++;
			//echo "</li>\n<li>$title(" . display_stack($stack) . ")\n";
			//echo "</li>\n<li>$title\n";
			$deffer = "</li>\n";
			$deffer = $deffer . display_tabs($level) ."<li id=\"li_id$li_id\">:rep:$title";
		}
	}

	$deffer = preg_replace('/:rep:/',"$bullet",$deffer);
	echo $deffer;

	for($i=0;$i<sizeof($stack);$i++)
	{
		echo "</li>\n". display_tabs($level) ."</ul>\n";
	}

	echo "</div>";
}
else
{
	echo "No data in the database";
}

function display_stack($stack)
{
	for($j=0;$j<sizeof($stack);$j++)
	{
		$disp_array = $disp_array . $stack[$j] . ",";
	}
	return $disp_array;
}

function display_tabs($num)
{
	$str_tabs = "";
	
	if($num != 0)
	{
		for($tab=1;$tab<=$num;$tab++)
		{
			$str_tabs = $str_tabs . "\t";
		}
	}
	
	return $str_tabs;
}

mysql_close($db);
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
