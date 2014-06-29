<?php $title = "Digital Archives"; ?>
<?php include('header.php'); ?>
	<div class="mainpage">
		<div id="contentWrapper" style="margin-top:1em;">
			<div class="col1 colL largeSpace"><div class="section right" id="sec11">&nbsp;</div></div><h2>Botanical Survey of India - Digital archives</h2>
			<div class="archivesCards">
				<div class="card">
					<a href="bulletin/volumes.php" >
						<img src="../php/images/archives/bul.jpg" alt="" />
						<div class="cardTitle arcBul">
							<span>Bulletin of the BSI<br />Nelumbo</span>
						</div>
					</a>
				</div>
				<div class="card">
					<a href="records/volumes.php" >
						<img src="../php/images/archives/rec.jpg" alt="" />
						<div class="cardTitle arcRec">
							<span>Records<br />of the BSI</span>
						</div>
					</a>
				</div>
				<div class="card">
					<a href="fli_books_list.php" >
						<img src="../php/images/archives/fli.jpg" alt="" />
						<div class="cardTitle arcFli">
							<span>Flora of<br />India</span>
						</div>
					</a>
				</div>
				<div class="card">
					<a href="s1_books_list.php">
						<img src="../php/images/archives/s1.jpg" alt="" />
						<div class="cardTitle arcS1">
							<span>Fascicles<br />(Series 1)</span>
						</div>
					</a>
				</div>
				<div class="card">
					<a href="s2_books_list.php">
						<img src="../php/images/archives/s2.jpg" alt="" />
						<div class="cardTitle arcS2">
							<span>State Flora<br />(Series 2)</span>
						</div>
					</a>
				</div>
				<div class="card">
					<a href="s3_books_list.php">
						<img src="../php/images/archives/s3.jpg" alt="" />
						<div class="cardTitle arcS3">
							<span>District Flora<br />(Series 3)</span>
						</div>
					</a>
				</div>
				<div class="card">
					<a href="s4_books_list.php">
						<img src="../php/images/archives/s4.jpg" alt="" />
						<div class="cardTitle arcS4">
							<span>Miscellaneous<br />(Series 4)</span>
						</div>
					</a>
				</div>
				<div class="card">
					<a href="vnv_books_list.php">
						<img src="../php/images/archives/vnv.jpg" alt="" />
						<div class="cardTitle arcvnv">
							<span>वनस्पति<br />वाणि</span>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div id="contentWrapper1">
			<div class="col1 colL largeSpace"><div class="section right" id="sec12">&nbsp;</div></div><h2>Search</h2>
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
	<td><input name=\"author\" type=\"text\" class=\"titlespan wide\" id=\"autocomplete\" maxlength=\"150\"/>";
	
$query_ac = "select * from author where type regexp '4|5|6' order by authorname";

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
	<td style=\"text-align:right;\"><label for=\"textfield2\" class=\"titlespan\">Title: &nbsp;</span></td>
	<td><input name=\"title\" type=\"text\" class=\"titlespan wide\" id=\"textfield2\" maxlength=\"150\"/></td>
</tr>";

$result_ac->free();
$db->close();

?>
						<tr>
							<td style="text-align:right;"><label for="textfield3" class="titlespan">Words: &nbsp;</label></td>
							<td><input name="text" type="text" class="titlespan wide" id="textfield3" maxlength="150"/></td>
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
		<div style="clear:both;"></div>
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
