<?php
echo "<h1>Statisztika</h1><center>";

echo "<h2><font color=white>Online j�t�kosok</font></h2>";
echo "<table class=online width=600>
<tr><td>";
$ks = mysql_query("SELECT * FROM playerek WHERE `Online` = '1'");
$ossz = mysql_query("SELECT * FROM playerek");
$osszucp = mysql_query("SELECT * FROM ucpuserek");
$osszbann = mysql_query("SELECT * FROM bans");
$osszkapu = mysql_query("SELECT * FROM kapuk");
$osszterulet = mysql_query("SELECT * FROM teruletek");
$admins = mysql_query("SELECT * FROM playerek WHERE `Admin` > 0");
$hazak = mysql_query("SELECT * FROM hazak");
$jarmuvek = mysql_query("SELECT * FROM kocsik");
$bizek = mysql_query("SELECT * FROM bizek");
$osszhirdetes = mysql_query("SELECT * FROM hirdetesek");
$osszhirdetotabla = mysql_query("SELECT * FROM hirdetotablak");
if(!mysql_num_rows($ks)) echo "Nincs online j�t�kos!</tr></td></table>";
else
{
	$db = mysql_num_rows($ks);
	$eddig = 0;
	while($a = mysql_fetch_assoc($ks))
	{
		$eddig++;
		if($eddig == $db) 
		{
			if($a["Member"] == "1" OR $a["Member"]=="2" OR $a["Member"]=="4" OR $a["Member"]=="5" OR $a["Member"]=="7" OR $a["Member"]=="9" OR $a["Member"]=="10" OR $a["Member"]=="14" OR $a["Member"]=="15" OR $a["Member"]=="16" OR $a["Member"]=="18" OR $a["Member"]=="19" OR $a["Member"]=="20" OR $a["Member"]=="22" OR $a["Member"]=="25" OR $a["Leader"]= "1" OR $a["Leader"]= "2" OR $a["Leader"]= "4" OR $a["Leader"]= "5" OR $a["Leader"]= "7" OR $a["Leader"]= "9" OR $a["Leader"]= "10" OR $a["Leader"]= "14" OR $a["Leader"]= "15" OR $a["Leader"]= "16" OR $a["Leader"]= "18" OR $a["Leader"]= "19" OR $a["Leader"]= "20" OR $a["Leader"]= "22" OR $a["Leader"]= "25")
			{
				echo "<font color='yellow'>$a[Nev]</font>";
			} else if($a["Member"] == "1" OR $a["Member"] == "2" OR $a["Member"] == "14" OR $a["Member"] == "15" OR $a["Member"] == "25" OR $a["Leader"] == "1" OR $a["Leader"] == "2" OR $a["Leader"] == "14" OR $a["Leader"] == "15" OR $a["Leader"] == "25")
			{
				echo "<font color='#00deff'>$a[Nev]</font>";
			} else if($a["Member"] == "0" OR $a["Leader"] == "0")
			{
				echo "<font color='#ffffff'>$a[Nev]</font>";
			} else if($a["Member"] == "3" OR $a["Member"] == "6" OR $a["Member"] == "11" OR $a["Member"] == "12" OR $a["Member"] == "13" OR $a["Member"] == "17" OR $a["Member"] == "21" OR $a["Member"] == "23" OR $a["Member"] == "24" OR $a["Leader"] == "3" OR $a["Leader"] == "6" OR $a["Leader"] == "11" OR $a["Leader"] == "12" OR $a["Leader"] == "13" OR $a["Leader"] == "17" OR $a["Leader"] == "21" OR $a["Leader"] == "23" OR $a["Leader"] == "24")
			{
				echo "<font color='#ff0000'>$a[Nev]</font>";
			}
			
		}
		else
		{
			if($a["Member"] == "1" OR $a["Member"]=="2" OR $a["Member"]=="4" OR $a["Member"]=="5" OR $a["Member"]=="7" OR $a["Member"]=="9" OR $a["Member"]=="10" OR $a["Member"]=="14" OR $a["Member"]=="15" OR $a["Member"]=="16" OR $a["Member"]=="18" OR $a["Member"]=="19" OR $a["Member"]=="20" OR $a["Member"]=="22" OR $a["Member"]=="25" OR $a["Leader"]= "1" OR $a["Leader"]= "2" OR $a["Leader"]= "4" OR $a["Leader"]= "5" OR $a["Leader"]= "7" OR $a["Leader"]= "9" OR $a["Leader"]= "10" OR $a["Leader"]= "14" OR $a["Leader"]= "15" OR $a["Leader"]= "16" OR $a["Leader"]= "18" OR $a["Leader"]= "19" OR $a["Leader"]= "20" OR $a["Leader"]= "22" OR $a["Leader"]= "25")
			{
				echo "<font color='yellow'>$a[Nev], </font>";
			} else if($a["Member"] == "1" OR $a["Member"] == "2" OR $a["Member"] == "14" OR $a["Member"] == "15" OR $a["Member"] == "25" OR $a["Leader"] == "1" OR $a["Leader"] == "2" OR $a["Leader"] == "14" OR $a["Leader"] == "15" OR $a["Leader"] == "25")
			{
				echo "<font color='#00deff'>$a[Nev], </font>";
			} else if($a["Member"] == "0" OR $a["Leader"] == "0")
			{
				echo "<font color='#ffffff'>$a[Nev], </font>";
			} else if($a["Member"] == "3" OR $a["Member"] == "6" OR $a["Member"] == "11" OR $a["Member"] == "12" OR $a["Member"] == "13" OR $a["Member"] == "17" OR $a["Member"] == "21" OR $a["Member"] == "23" OR $a["Member"] == "24" OR $a["Leader"] == "3" OR $a["Leader"] == "6" OR $a["Leader"] == "11" OR $a["Leader"] == "12" OR $a["Leader"] == "13" OR $a["Leader"] == "17" OR $a["Leader"] == "21" OR $a["Leader"] == "23" OR $a["Leader"] == "24")
			{
				echo "<font color='#ff0000'>$a[Nev], </font>";
			}
		}
	}
	echo "</tr></td></table>";
}
$legalis_frakciosok = mysql_query("SELECT * FROM playerek WHERE `Member` = '1' OR `Member` = '2' OR `Member` = '4' OR `Member` = '5' OR `Member` = '7' OR `Member` = '9' OR `Member` = '10' OR `Member` = '14' OR `Member` = '15' OR `Member` = '16' OR `Member` = '18' OR `Member` = '19' OR `Member` = '20' OR `Member` = '22' OR `Member` = '25' OR `Leader` = '1' OR `Leader` = '2' OR `Leader` = '4' OR `Leader` = '5' OR `Leader` = '7' OR `Leader` = '9' OR `Leader` = '10' OR `Leader` = '14' OR `Leader` = '15' OR `Leader` = '16' OR `Leader` = '18' OR `Leader` = '19' OR `Leader` = '20' OR `Leader` = '22' OR `Leader` = '25'");
$rendvedelmisek = mysql_query("SELECT * FROM playerek WHERE `Member` = '1' OR `Member` = '2' OR `Member` = '14' OR `Member` = '15' OR `Member` = '25' OR `Leader` = '1' OR `Leader` = '2' OR `Leader` = '14' OR `Leader` = '15' OR `Leader` = '25'");
$civil = mysql_query("SELECT * FROM playerek WHERE `Member` = '0' AND `Leader` = '0'");
$illegalis_frakciosok = mysql_query("SELECT * FROM playerek WHERE `Member` = '3' OR `Member` = '6' OR `Member` = '11' OR `Member` = '12' OR `Member` = '13' OR `Member` = '17' OR `Member` = '21' OR `Member` = '23' OR `Member` = '24' OR `Leader` = '3' OR `Leader` = '6' OR `Leader` = '11' OR `Leader` = '12' OR `Leader` = '13' OR `Leader` = '17' OR `Leader` = '21' OR `Leader` = '23' OR `Leader` = '24'");
echo '<div style="padding-top: 15px;"></div>';
echo "<h2><font color=white>Frakci� szerinti</font></h2>
<table class=t width=600>
<tr>
	<td style='color: #ffffff; background: #000000;'><b>Civilek:</b> ".mysql_num_rows($civil). "f�</td>
</tr>
<tr>
	<td style='color: yellow; background: #000000;'><b>Leg�lis frakci�sok:</b> ".mysql_num_rows($legalis_frakciosok). "f�</td>
</tr>
<tr>
	<td style='color: #00deff; background: #000000;'><b>Rendv�delmisek:</b> ".mysql_num_rows($rendvedelmisek). "f�</td>
</tr>
<tr>
	<td style='color: #ff0000; background: #000000;'><b>Illeg�lis frakci�sok:</b> ".mysql_num_rows($illegalis_frakciosok). "f�</td>
</tr>
</table>";
echo '<div style="padding-top: 15px;"></div>';
echo "<h2><font color=white>Egy�b statisztika</font></h2>
<table class=t width=600>
<tr>
	<td style='color: #ffffff;'><b>Online j�t�kosok:</b> ".mysql_num_rows($ks)." db</td>
	<td style='color: #ffffff;'><b>�sszes j�t�kos:</b> ".mysql_num_rows($ossz)." db</td>
	<td style='color: #ffffff;'><b>�sszes admin:</b> ".mysql_num_rows($admins)." db</td>
</tr>
<tr>
	<td style='color: #ffffff;'><b>�sszes h�z:</b> ".mysql_num_rows($hazak)." db</td>
	<td style='color: #ffffff;'><b>�sszes j�rm�:</b> ".mysql_num_rows($jarmuvek)." db</td>
	<td style='color: #ffffff;'><b>�sszes biznisz:</b> ".mysql_num_rows($bizek)." db</td>
</tr>
<tr>
	<td style='color: #ffffff;'><b>�sszes UCP felhaszn�l�:</b> ".mysql_num_rows($osszucp)." db</td>
	<td style='color: #ffffff;'><b>Bannok sz�ma:</b> ".mysql_num_rows($osszbann)." db</td>
	<td style='color: #ffffff;'><b>�sszes kapu:</b> ".mysql_num_rows($osszkapu)." db</td>
</tr>
<tr>
	<td style='color: #ffffff;'><b>Ter�letek sz�ma:</b> ".mysql_num_rows($osszterulet)." db</td>
	<td style='color: #ffffff;'><b>�sszes hirdet�s:</b> ".mysql_num_rows($osszhirdetes)." db</td>
	<td style='color: #ffffff;'><b>�sszes hirdet�t�bla:</b> ".mysql_num_rows($osszhirdetotabla)." db</td>
</tr>
</table>";
?>