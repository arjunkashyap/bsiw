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
		<div id="contentWrapper_longer">
			<div class="page_title"><div class="col1 colL largeSpace"><div class="section right" id="sec11">&nbsp;</div></div><h2>Search</h2></div>
			<div class="textSmall minheight" style="width:700px;">
				<div class="newBookUl articlesByUl">
					<form method="post" action="search-result.php">
					<table class="searchForm">
						<tr>
							<td class="left" style="text-align:right;" >In: &nbsp;</td>
							<td>
								<table class="select_table">
									<tr>
										<td><input type="checkbox" name="check[]" checked="checked" value="bul" id="bul"/> <label for="bul">Nelumbo</label></td>
										<td><input type="checkbox" name="check[]" checked="checked" value="rec" id="rec"/> <label for="rec">Records</label></td>
										<td><input type="checkbox" name="check[]" checked="checked" value="fli" id="fli"/> <label for="fli">Flora of India</label></td>
									</tr>
									<tr>
										<td><input type="checkbox" name="check[]" checked="checked" value="s1" id="s1"/> <label for="s1">Fascicles (Series 1)</label></td>
										<td><input type="checkbox" name="check[]" checked="checked" value="s2" id="s2"/> <label for="s2">State Flora (Series 2)</label></td>
										<td><input type="checkbox" name="check[]" checked="checked" value="s3" id="s3"/> <label for="s3">District Flora (Series 3)</label></td>
									</tr>
									<tr>
										<td><input type="checkbox" name="check[]" checked="checked" value="s4" id="s4"/> <label for="s4">Miscellaneous (Series 4)</label></td>
										<td colspan="2"><input type="checkbox" name="check[]" checked="checked" value="vnv" id="vnv"/> <label for="vnv">वनस्पति वाणि</label></td>
									</tr>
								</table>
							</td>
						</tr>
<?php

include("fli/connect.php");

//~ $db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
//~ $rs = mysql_select_db($database,$db) or die("No Database");

$db = new mysqli('localhost', "$user", "$password", "$database");

if($db->connect_errno > 0){
    die('Not connected to database [' . $db->connect_error . ']');
}

echo "<tr>
	<td style=\"text-align:right;\"><label for=\"autocomplete\" class=\"titlespan\">Author: &nbsp;</label></td>
	<td><input name=\"author\" type=\"text\" class=\"titlespan wide\" id=\"autocomplete\" />";
	
$query_ac = "select * from author where type regexp '1|2|3|4|5|6|7|8' order by authorname";

//~ $result_ac = mysql_query($query_ac);
//~ $num_rows_ac = mysql_num_rows($result_ac);

$result_ac = $db->query($query_ac); 
$num_rows_ac = $result_ac->num_rows;

echo "<script type=\"text/javascript\">$( \"#autocomplete\" ).autocomplete({source: [ ";

$source_ac = '';

if($num_rows_ac)
{
	for($i=1;$i<=$num_rows_ac;$i++)
	{
		//~ $row_ac=mysql_fetch_assoc($result_ac);
		$row_ac = $result_ac->fetch_assoc();
		
		$authorname=$row_ac['authorname'];

		$source_ac = $source_ac . ", ". "\"$authorname\"";
	}
	$source_ac = preg_replace("/^\, /", "", $source_ac);
}

echo "$source_ac ]});</script></td>";
echo "</tr>
<tr>
	<td style=\"text-align:right;\"><span class=\"titlespan\">Title: &nbsp;</span></td>
	<td><input name=\"title\" type=\"text\" class=\"titlespan wide\" id=\"textfield2\" /></td>
</tr>";

$result_ac->free();
$db->close();

?>

						<tr>
							<td style="text-align:right;"><span class="titlespan">Words: &nbsp;</span></td>
							<td><input name="text" type="text" class="titlespan wide" id="textfield3" /></td>
						</tr>
						<tr>
							<td class="left">&nbsp;</td>
							<td>
								<input name="button1" type="submit" class="btn" id="button_search" value="Search"/>
								<input name="button2" type="reset" class="btn" id="button_reset" value="Reset"/>
							</td>
						</tr>
					</table>
					</form>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
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
		<p>&copy; 2013, Botanical Survey of India<br /></p>
	</div>
</div>
</body>

</html>

