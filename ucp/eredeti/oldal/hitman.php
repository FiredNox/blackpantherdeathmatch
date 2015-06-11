<?php
	
if($sor['Hitman'] == "0"){
	msg("2","Nincs jogosultságod az oldal megtekintéséhez!");
} else {
	if(isset($_GET['kirug']))
	{
		if($_GET['kirug'] == "")
		{
			msg("2"," Nincs megadva ID!");
		} else {
			$kirugando = $_GET['kirug'];
			$ellenorzes_q = mysql_query("SELECT * FROM playerek WHERE ID='".mysql_escape_string($kirugando)."'");
			$ellenorzes = mysql_fetch_array($ellenorzes_q);
			if(!$ellenorzes)
			{
				msg("2", "Nincs ilyen játékos!");
			} else {
				if($ellenorzes['Hitman'] != '0')
				{
					$mysql_hitman_elvesz = mysql_query("UPDATE playerek SET Hitman='0' WHERE ID='".mysql_escape_string($kirugando)."'");
					msg("1", "Sikeresen kirúgtad ".$ellenorzes['HitmanNev']." -t/et (".$ellenorzes['Nev'].")!");
				} else {
					msg("2","Õ nem Hitman!");
				}
			}
		}
	}
	if(isset($_GET['felvesz']))
	{
		$felvetendo = $_POST['hitman_felvesz'];
		$ellenorzess_q = mysql_query("SELECT * FROM playerek WHERE Nev='".mysql_escape_string($felvetendo)."'");
		$ellenorzess = mysql_fetch_array($ellenorzess_q);
		if($sor['Hitman'] > '2') {
			if(!$ellenorzess)
			{
				msg("2", "Nincs ilyen játékos!");
			} else {
				if($ellenorzess['Hitman'] != '0')
				{
					msg("2","Õ már Hitman!");
				} else {
					$mysql_hitman_felvesz = mysql_query("UPDATE playerek SET Hitman='1' WHERE Nev='".mysql_escape_string($felvetendo)."'");
					msg("1", "Sikeresen felvetted ".$ellenorzess['Nev']." -t Hitman-nek!");
				}
			}
		} else {
			msg("2", "Nem vagy Director");
		}
	}
	echo'<form method="POST" action="index.php?menu=hitman&felvesz">
	<h1>Tag felvétele</h1>
	IG NÉV: <input type="text" name="hitman_felvesz"> <input type="submit" name="felvesz" value"Felvétel">
	</form>
	<h1>Hitman - Tagok</h1>
	
	<table border="1" style=" width: 250px;" class="table_border" cellspacing="0" cellpadding="0">
		<tr>
			<td><img src="img/hitman.jpg"></td>
		</tr>
		<tr style=" height: 30px;">
			<td align=center><font color=white><b>Név</b></font></td>
		</tr>';
	$hitman_q = mysql_query("SELECT * FROM playerek WHERE Hitman != '0'");
	while($hitman = mysql_fetch_array($hitman_q))
	{
		echo '<tr class="frakciok_eger_ravisz_sav" style=" height: 30px;" align=center>
				<td><font color=white>'.$hitman['HitmanNev'].'</font>  ( '.$hitman['Nev'].' )</td>';
			if($sor['Hitman'] > '2') {
				echo'<td><a href="index.php?menu=hitman&kirug='.$hitman['ID'].'" style="font-size: 13px; padding-left: 5px;">Kirúgás</a></td>';
			}
			echo'</tr>';
	}
}
echo '</table>';
?>