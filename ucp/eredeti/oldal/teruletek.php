<?php

$terulet_q = mysql_query("SELECT * FROM teruletek");
	/*if($sor['Member'] != "3" OR $sor['Member'] != "11" OR $sor['Member'] != "12" OR $sor['Member'] != "13" OR $sor['Member'] != "17" OR $sor['Member'] != "19"){
		msg("2","Nincs jogosultságod az oldal megtekintéséhez!");
	} else {*/
	echo'<h1>Területek</h1>
	
	<table border="1" style=" width: 250px;" class="table_border" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="2"><img src="img/lsterkep.jpg"></td>
		</tr>
		<tr style="height: 30px;" align=center>
			<td><font color=white><b><u>Terület neve</u></b></font></td>
			<td><font color=white><b><u>Birtokolja</u></b></font></td>
		</tr>';
	while($terulet = mysql_fetch_array($terulet_q))
	{
		echo '<tr style="height: 30px;" align=center class="frakciok_eger_ravisz_sav">
				<td><font color=white>'.$terulet['Nev'].'</font> </td>
				<td>'.$fract[$terulet['Tulaj']].'</td>
			</tr>';
	}
/*}*/
echo '</table>';
?>