<?PHP
	mysql_connect("80.249.163.44", "szerver", "Preyuf3QErEd9be4efAm") or die(mysql_error());
	mysql_select_db("samp");
	echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="500">
			<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
			<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Név</td>
			</tr>';
	$limit = 10;
	$sql = "select count(id) from playerek";
	$c = array_shift(mysql_fetch_row(mysql_query($sql)));
	$maxpage = ceil($c / $limit);
	$page = isset($_GET['page']) ? abs((int)$_GET['page']) : 1;
	if ($page <= 0)
	{
       	$page = 1;
	}
	else if ($page >= $maxpage)
	{
       	$page = $maxpage;
	}
	$offset = ($page-1) * $limit;
	$query = mysql_query("select * from playerek limit $offset, $limit ");
	while ($row = mysql_fetch_assoc($query))
	{
		echo'<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
				<td>'.$row['Nev'].'</td>
			</tr>';
	}
	$linklimit = 10;
	$linklimit2 = $linklimit / 2;
	$linkoffset = ($page > $linklimit2) ? $page - $linklimit / 2 : 0;
	$linkend = $linkoffset+$linklimit;
	if ($maxpage - $linklimit2 < $page)
	{
      		$linkoffset = $maxpage - $linklimit;
      		if ($linkoffset < 0)
      		{
             		$linkoffset = 0;
      		}
      		$linkend = $maxpage;
	}
	$style="text-align:center; margin-left:120px;";
	echo '<ul id="lapozo" style="'.$style.'">';
	if ($page > 1)
	{
      		//print "<a href='?menu=admin&proba&page=".($page-1)."'>Elõzõ</a>   ";
		$style = "list-style:none; float:left; margin-right:16px; padding:5px; border:solid 1px #dddddd;"; 
		echo '<li style="'.$style.'" id="'.($page-1).'">Elõzõ</li>';
	}
	for ($i=1+$linkoffset; $i <= $linkend and $i <= $maxpage; $i++)
	{
		$style = "list-style:none; float:left; margin-right:16px; padding:5px; border:solid 1px #dddddd;"; 
      		$style = ($i == $page) ? $style."color: black;" : $style."color: blue;";
      		//print "<a href='?page=$i' style='$style'>[$i.]</a>   ";
		echo '<li style="'.$style.'" id="'.$i.'">'.$i.'</li>';
	}
	if ($page < $maxpage)
	{	
      		//print "<a href='?menu=admin&proba&page=".($page+1)."'>Következõ</a>";
		$style = "list-style:none; float:left; margin-right:16px; padding:5px; border:solid 1px #dddddd;"; 
		echo '<li style="'.$style.'" id="'.($page+1).'">Következõ</li>';
	}
	print "</ul>";
	echo '<div style="padding-top: 35px;"></div></table>';

/* ez kell az adminban a 3*-nál

echo '<script>
			$(document).ready(function(){
  				$("button").click(function(){
    					$("#div1").load("oldal/proba.php?page=1");
  				});
				$("#lapozo li").click(function(){
					$("#div1").load("oldal/proba.php?page=3");
				});
				$("#div1").load("oldal/proba.php?page=2");
			});
			</script>';

		echo '<div id="div1">load</div> <button>proba</button>';
*/

?>