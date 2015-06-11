<?php

	echo'<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=egyeb&hirdetesek\';">HIRDETÉSEK</div></td>
			</tr>
		</table>';
	echo'<div style="padding-top: 20px;"></div>';
	
	if(isset($_GET['hirdetesek'])) {
		echo'<table border="1"  style="width: 650px;" class="table_border" cellspacing="0" cellpadding="0">
			<tr  align=center style=" height: 25px; color:white;" class="frakciok_eger_ravisz_sav">
				<td>Feladó</td>
				<td>Hirdetés</td>
				<td>Telefonszám</td>';
				/*if(isset($sor))
				{
					if($sor['Admin'] > '3')
					{
						echo'<td>Törlés...</td>';
					}
				}*/
			echo'</tr>';
		$limit = 25;
		
		$sql = "select count(id) from hirdetesek";
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
		$query = mysql_query("select * from hirdetesek limit $offset, $limit ");
		while($row = mysql_fetch_assoc($query))
		{
			echo'<tr  align=center style=" height: 25px; color:white;" class="frakciok_eger_ravisz_sav">
				<td>'.$row['hirdeto'].'</td>
				<td>'.$row['hirdetes'].'</td>
				<td>'.$row['telefonsz'].'</td>';
				/*if(isset($sor))
				{
					if($sor['Admin'] > '3')
					{
						echo'<td><a href="index.php?menu=egyeb&htorol='.$row['id'].'" style="font-size: 13px; padding-left: 5px;">Törlés...</a></td>';
					}
				}*/
				
			echo'</tr>';
		}
		
		$linklimit = 10;
		$linklimit2 = $linklimit / 2;
		$linkoffset = ($page > $linklimit2) ? $page - $linklimit / 2 : 0;
		$linkend = $linkoffset+$linklimit;
		
		if ($maxpage - $linklimit2 < $page)
		{
			$linkoffset = $maxpage - $linklimit;
			if($linkoffset < 0)
			{
				$linkoffset = 0;
			}
			$linkend = $maxpage;
		}
		if($page > 1)
		{
			print "<a href='?menu=egyeb&hirdetesek&page=".($page-1)."' class='subnav_gombb'>Elõzõ</a>   ";
		}
		for ($i=1+$linkoffset; $i <= $linkend and $i <= $maxpage; $i++)
		{
        		$style = ($i == $page) ? "color: black;" :  "color: white;";
        		print "<a href='?menu=egyeb&hirdetesek&page=$i' style='$style' class='subnav_gombb'>[$i.]</a>   ";
		}
		if ($page < $maxpage)
		{	
        		print "<a href='?menu=egyeb&hirdetesek&page=".($page+1)."' style='$style' class='subnav_gombb'>Következõ</a>";
		}
		echo '<script>
			$(document).ready(function(){
  				$("button").click(function(){
    					$("#div1").load("proba.txt");
  				});
			});
			</script>';
		echo '</table>';
	}
	/*if(isset($_GET['htorol']))
	{
		if($sor['Admin'] > '3')
		{
			$torolni_q = mysql_query("SELECT * FROM hirdetesek WHERE id='".mysql_escape_string($_GET['htorol'])."'");
			$torolni = mysql_fetch_array($torolni_q);
			if(!$torolni)
			{
				msg("2", "Nem létezik a hirdetés amit törölni szeretnél!");
			} else {
				if($torolni)
				{
					$mysql_torles = mysql_query("DELETE FROM hirdetesek WHERE id");
					msg("1", "Sikeresen törölted ".$torolni['hirdeto']." hirdetését!");
					if(!$mysql_torles)
					{
						die('Hiba: '.mysql_error());
					}
				}
			}
		} else {
			msg("2", "Nincs jogosultságod ennek a mûveletnek az elvégzéséhez!");
		}
	}*/

?>