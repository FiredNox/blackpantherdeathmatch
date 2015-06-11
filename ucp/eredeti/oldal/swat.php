<?php

if($sor['Swat'] == "0") {
	msg("2", "Nincs jogosultságod az oldal megtekintéséhez!");
} else {
	if(isset($_GET['kirug']))
	{
		if($_GET['kirug'] == "")
		{
			msg("2", "Nincs megadva ID!");
		} else {
			$kirugando = $_GET['kirug'];
			$ellenorzes_q = mysql_query("SELECT * FROM playerek WHERE ID='".mysql_escape_string($kirugando)."'");
			$ellenorzes = mysql_fetch_array($ellenorzes_q);
			if(!$ellenorzes)
			{
				msg("2", "Nincs ilyen játékos");
			} else {
				if($ellenorzes['Swat'] != '0')
				{
					$mysql_swat_elvesz = mysql_query("UPDATE playerek SET Swat='0' WHERE ID='".mysql_escape_string($kirugando)."'");
					$mysql_swat_elveszz = mysql_query("UPDATE playerek SET SwatRang='0' WHERE ID='".mysql_escape_string($kirugando)."'");
					msg("1", "Sikeresen kirúgtad ".$ellenorzes['Nev']." -t a swat-ból!");
				} else {
					msg("2", "Õ nem SWAT tag!");
				}
			}
		}
	}
	if(isset($_GET['felvesz']))
	{
		$felvetendo = $_POST['swat_felvesz'];
		$ellenorzess_q = mysql_query("SELECT * FROM playerek WHERE Nev='".mysql_escape_string($felvetendo)."'");
		$ellenorzess = mysql_fetch_array($ellenorzess_q);
		if($sor['SwatRang'] > '11') {
			if(!$ellenorzess)
			{
				msg("2", "Nincs ilyen játékos");
			} else {
				if($ellenorzess['Swat'] != '0')
				{
					msg("2", "Õ már SWAT tag!");
				} else {
					$mysql_swat_felvesz = mysql_query("UPDATE playerek SET Swat='1' WHERE Nev='".mysql_escape_string($felvetendo)."'");
					msg("1", "Sikeresen felvetted ".$ellenorzess['Nev']." -t a SWAT-ba!");
				}
			}
		} else {
			msg("2", "Nem vagy SWAT leader!");
		}
	}
	echo'<form method="POST" action="index.php?menu=swat&felvesz">
	<h1>Tag felvétele</h1>
	IG NÉV: <input type="text" name="swat_felvesz"> <input type="submit" name="felvesz" value="Felvétel">
	</form>
	<h1>SWAT - Tagok</h1>
	
	<table border="1" style=" width: 250px;" class="table_border" cellspacing="0" cellpadding="0">
		<tr>
			<td><img src="img/swat.jpg"></td>
		</tr>
		<tr style="height: 30px;">
			<td align=center><font color=white>Név</font></td>
		</tr>';
	$swat_q = mysql_query("SELECT * FROM playerek WHERE Swat != '0' ORDER BY `SwatRang` DESC");
	while($swat = mysql_fetch_array($swat_q))
	{
		echo'<tr class="frakciok_eger_ravisz_sav" style="height: 30px;" align=center">
				<td align=center><font color=white>'.$swat['Nev'].' ('.$swat['SwatRang'].')</font></td>';
			if($sor['SwatRang'] > '11') {
				echo'<td><a href="index.php?menu=swat&kirug='.$swat['ID'].'" style="font-size: 13px; padding-left: 5px;">Kirúgás</a></td>';
			}
			echo'</tr>';
	}
}
echo'</table>';

?>