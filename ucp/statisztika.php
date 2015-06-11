<?php
echo "<h1>Statisztika</h1><center>";

echo "<h2><font color=white>Elérhető Játékosok</font></h2>";
echo "<table class=online width=600>
<tr><td>";
$ks = mysql_query("SELECT * FROM jatekosok WHERE `Elerheto` = '1'");
$ossz = mysql_query("SELECT * FROM playerek");
$mindenki = mysql_query("SELECT * FROM jatekosok");
$osszbann = mysql_query("SELECT * FROM jatekosok WHERE `kitiltva` = '1'");
$osszkapu = mysql_query("SELECT * FROM kapuk");
$osszterulet = mysql_query("SELECT * FROM teruletek");
$admins = mysql_query("SELECT * FROM kapcsolat WHERE `id`");
$hazak = mysql_query("SELECT * FROM hazak");
$jarmuvek = mysql_query("SELECT * FROM kocsik");
$bizek = mysql_query("SELECT * FROM bizek");
$osszhirdetes = mysql_query("SELECT * FROM hirdetesek");
$osszhirdetotabla = mysql_query("SELECT * FROM hirdetotablak");
if(!mysql_num_rows($ks)) echo "Nincs online játékos!</tr></td></table>";
else
{
	$db = mysql_num_rows($ks);
	$eddig = 0;
	while($a = mysql_fetch_assoc($ks))
	{
		$eddig++;
		if($eddig == $db) 
		{
			if($db == 1)
			{
				echo "<font color='white'>$a[Felhasznalonev]</font>";
			}
			else echo "<font color='white'> $a[Felhasznalonev],</font>";
		}
	}
	echo "</tr></td></table>";
}
	if(isset($_GET['szerver']))
	{
		echo "<br><h2><font color=white>Szerver Kimutatásai</font></h2>";
		echo '<div style="padding-top: 15px;"></div>';
		echo "<table class=t width=600>
		<tr>
			<td style='color: #ffffff;'><b>Elérhető Játékosok: </b> <font color=orange>".mysql_num_rows($ks)."</font> db</td>
			<td style='color: #ffffff;'><b>Összes Admin: </b> <font color=orange>".mysql_num_rows($admins)."</font> db</td>
			<td style='color: #ffffff;'><b>Összes Halál: </b> <font color=orange>".mysql_num_rows($ossz)."</font> db</td>
		</tr>
		<tr>
			<td style='color: #ffffff;'><b>Összes ház: </b> <font color=orange>".mysql_num_rows($hazak)."</font> db</td>
			<td style='color: #ffffff;'><b>Összes jármű: </b> <font color=orange>".mysql_num_rows($jarmuvek)."</font> db</td>
			<td style='color: #ffffff;'><b>Összes Gyilkosság: </b> <font color=orange>".mysql_num_rows($bizek)."</font> db</td>
		</tr>
		<tr>
			<td style='color: #ffffff;'><b>Összes Játékos: </b> <font color=orange>".mysql_num_rows($mindenki)."</font> db</td>
			<td style='color: #ffffff;'><b>Bannok száma: </b> <font color=orange>".mysql_num_rows($osszbann)."</font> db</td>
			<td style='color: #ffffff;'><b>Összes Achivment: </b> <font color=orange>".mysql_num_rows($osszkapu)."</font> db</td>
		</tr>
		<tr>
			<td style='color: #ffffff;'><b>Területek száma: </b> <font color=orange>".mysql_num_rows($osszterulet)."</font> db</td>
			<td style='color: #ffffff;'><b>Összes hirdetés: </b> <font color=orange>".mysql_num_rows($osszhirdetes)."</font> db</td>
			<td style='color: #ffffff;'><b>Összes Sebzés: </b> <font color=orange>".mysql_num_rows($osszhirdetotabla)."</font> db</td>
		</tr>
		</table>";
	}
	if(isset($_GET['sajat']))
	{
		echo "<br><br><h3>";
		echo "<br><h2><font color=white>$fsor[Felhasznalonev] Kimutatásai</font></h2>";
		$query = "select * from jatekosok";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
			$i = 0;
			while ($i < $num) {
				$hour = "<img src='img/hour.png'>";
				$money = "<img src='img/money.png'>";
				$skull = "<img src='img/skull.png'>";
				$pistol = "<img src='img/pistol.png'>";
				$active = "<img src='img/online.png'>";
				$inactiv = "<img src='img/offline.png'>";
				$eu = "<img src='img/euro.png'>";
				$star = "<img src='img/star.png'>";
				$isadmin = "<img src='img/admin.png'>";
				$isseged = "<img src='img/helper.png'>";
				$match = "<img src='img/match.png'>";
				$penzed = mysql_result($result, $i, "Coin");
				$gyilok = mysql_result($result, $i, "Gyilok");
				$halal = mysql_result($result, $i, "Halal");
				$aktiv = mysql_result($result, $i, "Elerheto");
				$admin = mysql_result($result, $i, "Admin");
				$seged = mysql_result($result, $i, "Seged");
				$meccs = mysql_result($result, $i, "Viadal");
				$euro = mysql_result($result, $i, "Euro");
				$csillag = mysql_result($result, $i, "Csillagok");
				$i++;
			}
		echo '<div style="padding-top: 15px;"></div>';
		echo "<table class=t width=400>
		<tr>";
			if($aktiv == 1)
			{
				echo "<td style='color: #ffffff;'>$active<b>Elérhető: </b> <font color=orange>Igen</td>";
			} else echo "<td style='color: #ffffff;'>$inactiv<b>Elérhető: </b> <font color=orange>Nem</td>";
			if($admin > 0)
			{
				echo "<td style='color: #ffffff;'>$isadmin<b>Admin: </b> <font color=orange>Igen</font></td>";
			} else echo "<td style='color: #ffffff;'>$isadmin<b>Admin: </b> <font color=orange>Nem</td>";
			if($seged == 1)
			{
				echo "<td style='color: #ffffff;'>$isseged<b>Segéd: </b> <font color=orange>Igen</font></td>";
			} else echo "<td style='color: #ffffff;'>$isseged<b>Segéd: </b> <font color=orange>Nem</font></td>";
			echo"
			
		</tr>
		<tr>
			<td style='color: #ffffff;'>$pistol<b>Ölések: </b> <font color=orange>$gyilok</font> db</td>
			<td style='color: #ffffff;'>$skull<b>Halálok: </b> <font color=orange>$halal</font> db</td>
			<td style='color: #ffffff;'>$match<b>Viadal: </b> <font color=orange>$meccs</font> db</td>
		</tr>
		<tr>
			<td style='color: #ffffff;'>$money<b>Coin: </b> <font color=orange>$penzed</font> &cent;</td>
			<td style='color: #ffffff;'>$star<b>Csillag: </b> <font color=orange>$csillag</font> db</td>
			<td style='color: #ffffff;'>$eu<b>Euro: </b> <font color=orange>$euro</font> &euro;</td>
		</tr>
		</table>";
	}
?>