<?php
if(!isset($_GET['tarsit']) && !isset($_GET['kivalaszt']) && !isset($_GET['letrehoz']) && !isset($_GET['letarsit']) && !isset($_GET['kocsi']) && !isset($_GET['haz']) && !isset($_GET['biznisz']) && !isset($_GET['ruhatar']) && !isset($_GET['frakcioskinvaltas']) && !isset($_GET['bankszamla']) && !isset($_GET['telefon']) && !isset($_GET['utalas']) && !isset($_GET['feltolt']))
{
	echo '<h1>Karakterek</h1>';

	echo "<table width=100%>
	<tr>
	<td width=49%>
	<table  class='table_border' width='378' height='109' style='background-color: #043348;' border='1'>
	";
	if($fsor['Kari1'] == -1) {
		echo '<tr align="center"><td><div style="font-size: 14px; color: #ffffff; font-weight: bold;">Nincs karakter t�rs�tva ide!</div></td></tr>';
	}
	else
	{
		$fkereses = mysql_query("SELECT * FROM playerek WHERE `ID` = '".mysql_escape_string($fsor['Kari1'])."'");
		$fasor = mysql_fetch_assoc($fkereses);
		$neme = "N�";
		if($fasor['Sex'] == 1) $neme = "F�rfi";
		echo '<tr><td width="66" align="center"><img src=skinek/Skin_'.$fasor['Model'].'.png></td>
		<td style="font-size: 15px;">';
		echo "<b><font color=yellow>N�v:</font></b> <font color=white>$fasor[Nev]<br>
		<b><font color=yellow>Nem:</font></b> <font color=white>$neme<br>
		<b><font color=yellow>Kor:</font></b> <font color=white>$fasor[Age]<br>
		<b><font color=yellow>Frakci�:</font></b> <font color=white>".$fract[$fasor['Member']]."<br>
		<b><font color=yellow>F�munka:</font></b> <font color=white>".$munkak[$fasor['Job1']]."<br>
		<b><font color=yellow>M�sodmunka:</font></b> <font color=white>".$munkak[$fasor['Job2']]."<br>";

	}
	echo '</table>
	<table width="378" height="21" class="table_border" border="1">
		<tr>';
		if($fsor['Kari1'] != -1)
		{
			if(isset($kivalasztott))
			{
				if($kivalasztott == $fasor['ID'])
				{
					echo '<td class="karakter_kis_bg_alatt_1_" align="center">Kiv�lasztva</td>
						<td class="karakter_kis_bg_alatt_2" align="center" onclick="window.location.href=\'index.php?menu=karakterek&letarsit='.$fasor['ID'].'\';" style="cursor: pointer;">Let�rs�t�s</td>';
				} else {
					echo '<td class="karakter_kis_bg_alatt_1" align="center" onclick="window.location.href=\'index.php?menu=karakterek&kivalaszt='.$fasor['ID'].'\';" style="cursor:pointer;">Kiv�laszt</td>
						<td class="karakter_kis_bg_alatt_2" align="center" onclick="window.location.href=\'index.php?menu=karakterek&letarsit='.$fasor['ID'].'\';" style="cursor: pointer;">Let�rs�t�s</td>';
				}
			} else {
				echo '<td class="karakter_kis_bg_alatt_1" align="center" onclick="window.location.href=\'index.php?menu=karakterek&kivalaszt='.$fasor['ID'].'\';" style="cursor:pointer;">Kiv�laszt</td>
					<td class="karakter_kis_bg_alatt_2" align="center" onclick="window.location.href=\'index.php?menu=karakterek&letarsit='.$fasor['ID'].'\';" style="cursor: pointer;">Let�rs�t�s</td>';
			}
		} else {
			echo '<td class="karakter_kis_bg_alatt_1" align="center" onclick="window.location.href=\'index.php?menu=karakterek&letrehoz\';" style="cursor:pointer;">Karakter l�trehoz�s</td>';
			echo '<td class="karakter_kis_bg_alatt_2" align="center" onclick="window.location.href=\'index.php?menu=karakterek&tarsit\';" style="cursor:pointer;">T�rs�t�s</td>';
		}
	echo '</tr>
		</table>
	</td>
	<td width=2%>
	</td>
	<td width=49%>
	<table width="378" height="109" class="table_border" border="1" style="background-color: #043348;">
	';
	if($fsor['Kari2'] == -1) {
		echo '<tr align="center"><td><div style="font-size: 14px; color: #ffffff; font-weight: bold;">Nincs karakter t�rs�tva ide!</div></td></tr>';
	}
	else
	{
		$fkereses = mysql_query("SELECT * FROM playerek WHERE `ID` = '".mysql_escape_string($fsor['Kari2'])."'");
		$fasor = mysql_fetch_assoc($fkereses);
		$neme = "N�";
		if($fasor['Sex'] == 1) $neme = "F�rfi";
		echo '<tr><td width="66" align=center><img src=skinek/Skin_'.$fasor['Model'].'.png></td>
		<td style="font-size: 15px;">';
		echo "<b><font color=yellow>N�v:</font></b> <font color=white>$fasor[Nev]<br>
		<b><font color=yellow>Nem:</font></b> <font color=white>$neme<br>
		<b><font color=yellow>Kor:</font></b> <font color=white>$fasor[Age]<br>
		<b><font color=yellow>Frakci�:</font></b> <font color=white>".$fract[$fasor['Member']]."<br>
		<b><font color=yellow>F�munka:</font></b> <font color=white>".$munkak[$fasor['Job1']]."<br>
		<b><font color=yellow>M�sodmunka:</font></b> <font color=white>".$munkak[$fasor['Job2']]."<br>";

	}
	echo '</table>
	<table width="378" height="21" border="1" class="table_border">
		<tr>';
		if($fsor['Kari2'] != -1)
		{
			if(isset($kivalasztott))
			{
				if($kivalasztott == $fasor['ID'])
				{
					echo '<td class="karakter_kis_bg_alatt_1_" align="center">Kiv�lasztva</td>
<td class="karakter_kis_bg_alatt_2" align="center" onclick="window.location.href=\'index.php?menu=karakterek&letarsit='.$fasor['ID'].'\';" style="cursor: pointer;">Let�rs�t�s</td>';
				} else {
					echo '<td class="karakter_kis_bg_alatt_1" align="center" onclick="window.location.href=\'index.php?menu=karakterek&kivalaszt='.$fasor['ID'].'\';" style="cursor:pointer;">Kiv�laszt</td>
<td class="karakter_kis_bg_alatt_2" align="center" onclick="window.location.href=\'index.php?menu=karakterek&letarsit='.$fasor['ID'].'\';" style="cursor: pointer;">Let�rs�t�s</td>';
				}
			} else {
				echo '<td class="karakter_kis_bg_alatt_1" align="center" onclick="window.location.href=\'index.php?menu=karakterek&kivalaszt='.$fasor['ID'].'\';" style="cursor:pointer;">Kiv�laszt</td>
					<td class="karakter_kis_bg_alatt_2" align="center" onclick="window.location.href=\'index.php?menu=karakterek&letarsit='.$fasor['ID'].'\';" style="cursor: pointer;">Let�rs�t�s</td>';
			}
		} else {
			echo '<td class="karakter_kis_bg_alatt_1" align="center" onclick="window.location.href=\'index.php?menu=karakterek&letrehoz\';" style="cursor:pointer;">Karakter l�trehoz�s</td>';
			echo '<td class="karakter_kis_bg_alatt_2" align="center" onclick="window.location.href=\'index.php?menu=karakterek&tarsit\';" style="cursor:pointer;">T�rs�t�s</td>';
		}

	echo '</tr>
	</table>';
	echo "
	</td>
	</tr>
	</table>";
	if(isset($kivalasztott))
	{
		echo '<br><h2><center>�ltal�nos adatok</center></h2>';
		$neme = "N�";
		if($sor['Sex'] == 1) $neme = "F�rfi";
		$szarm = $sor['Origin'];
		$rang = "-";
		if($sor['Member'] > 0) $rang = $sor['Rank'];
		$hazastars = "Nincs";
		if($sor['Married'] > 0) $hazastars = $sor['MarriedTo'];
		$bindok = "-";
		if($sor['Jailed'] > 0) $bindok = $sor['JailOK'];
		$bbezart = "-";
		if($sor['Jailed'] > 0) $bbezart = $sor['JailtAdta'];
		$bortone = $sor['Jailed'];
		$bido = "-";
		if($sor['Jailed'] > 0) $bido = $sor['JailTime'].' mp (~'.$sor['JailTime']/60 .'perc)';
		$bizk = mysql_query("SELECT * FROM bizek WHERE ID='".mysql_escape_string($sor['Bizz'])."'");
		$biz = mysql_fetch_assoc($bizk);
		$biznev = str_replace('~r~','<span style="color:red" />',$biz['Nev']);
		$biznev = str_replace('~b~','<span style="color:blue" />',$biznev);
		$biznev = str_replace('~w~','<span style="color:white" />',$biznev);
		$biznev = str_replace('~g~','<span style="color:#00FF00" />',$biznev);
		$biznev = str_replace('~y~','<span style="color:yellow" />',$biznev);
		$biznev = str_replace('~n~',' ',$biznev);
		$biznev = utf8_encode($biznev);
		if($sor['Bizz'] == -1) $biznev = "Nincs";
		$elsohaz = "Nincs";
		$elsokocsi = "Nincs";
		$kaja = "Nincs";
		$uveg = "Nincs";
		$c4 = "<font color=red>Nincs</font>";
		$cigi = "Nincs";
		$kotszer = "Nincs";
		$cuccok = explode(",", $sor['Cuccok']);

		$mati		= $cuccok['4'];
		$kokain		= $cuccok['5'];
		$heroin		= $cuccok['6'];
		$marihuana	= $cuccok['7'];
		if($sor['Cigi'] > 0) $cigi = $sor['Cigi'];
		if($sor['C4'] != 0) $c4 = "<font color=green>Van</font>";
		if($sor['Kotszer'] > 0) $kotszer = "$sor[Kotszer]";
		if($sor['House'] != -1) $elsohaz = "Van (Replay $sor[House])";
		if($sor['Kaja'] != 0) $kaja = "$sor[Kaja]";
		if($sor['Uveg'] != -1) $uveg = "$sor[Uveg]";
		if($sor['Kocsikulcs'] != -1) $elsokocsi = "Van ($sor[Kocsikulcs])";
		$allapot = "<font color=red>Offline</font>";
		if($sor['Online'] == 1) $allapot = "<font color=green><b>Online</b></font>";
		$utso = "Most";
		if($sor['Online'] == 0) $utso = date("Y. m. d. G:i:s", $sor['UtoljaraAktiv']);
		$telszam = "Nincs";
		if($sor['Phone'] > 0) $telszam = $sor['Phone'];
		$bszinfo = explode(",", $sor['BankSzamla']);
		$pdata = $sor['PremiumPont'];
		//$pdata = explode(",", $sor['Premium']);
		$bankszam = "-";
		$bankft = "-";
		$bankjelszo = "-";
		if($bszinfo[0] == 1) $bankszam = $bszinfo[1];
		if($bszinfo[0] == 1) $bankft = "$sor[Bank] Ft";
		if($bszinfo[0] == 1) $bankjelszo = $bszinfo[2];
		echo "<table class='table_border' style=' height: 250px;' width=100% border='1'>
		<tr>
			<td align=center>N�v: <font color=white>$sor[Nev]</font></td>
			<td align=center>Nem: <font color=white>$neme</font></td>
			<td align=center>Kor: <font color=white>$sor[Age]</font></td>
			<td align=center>Sz�rmaz�s: <font color=white>$szarmazasok[$szarm]</font></td>
			<td align=center>Admin szint: <font color=white>$sor[Admin]</font></td>
		</tr>
		<tr>
			<td align=center>Frakci�: <font color=white>".$fract[$sor['Member']]."</font></td>
			<td align=center>Rang: <font color=white>$rang</td>
			<td align=center>Leader jog: <font color=white>".VanNincs($sor['Leader'])."</font></td>
			<td align=center>F�munka: <font color=white>".$munkak[$sor['Job1']]."</font></td>
			<td align=center>M�sodmunka: <font color=white>".$munkak[$sor['Job2']]."</font></td>
		</tr>
		<tr>
			<td align=center>B�rt�nben: <font color=white>".IgenNem($sor['Jailed'])." ($bnevek[$bortone])</font></td>
			<td align=center>Indok: <font color=white>$bindok</font></td>
			<td align=center>Bez�rt: <font color=white>$bbezart</font></td>
			<td align=center>Id�: <font color=white>$bido</font></td>
			<td align=center>J�tszott �r�k: <font color=white>$sor[ConnectedTime]</font></td>
		</tr>
		<tr>
			<td align=center>H�z: <font color=white>$elsohaz</font></td>
			<td align=center>J�rm�: <font color=white>$elsokocsi</font></td>
			<td align=center>Biznisz: <font color=white>$biznev</font></td>
			<td align=center>Telefonsz�m: <font color=white>$telszam</font></td>
			<td align=center>�llapot: <font color=white>$allapot</font></td>
		</tr>
		<tr>
			<td align=center>K�szp�nz: <font color=white>$sor[Money] Ft</font></td>
			<td align=center>Banksz�mla: <font color=white>".VanNincs($bszinfo[0])."</font></td>
			<td align=center>Egyenleg: <font color=white>$sor[Bank] Ft</font></td>
			<td align=center>Sz�mlasz�m: <font color=white>$bankszam</font></td>
			<td align=center>Sz�mla jelsz�: <font color=white>$bankjelszo</font></td>
		</tr>
		<tr>
			<td align=center>Adminseg�d: <font color=white>".IgenNem($sor['ASJog'])."</font></td>
			<td align=center>H�zast�rs: <font color=white>$hazastars</font></td>
			<td align=center>Szint: <font color=white>$sor[Szint]</font></td>
			<td align=center>Utols� akt�vs�g: <font color=white>$utso</font></td>
			<td align=center>Pr�miumpont: <font color=white>".$pdata."db</font></td>
		</tr>
		</table><br><h2><center>Zseb tartalma</center></h2>
		<table class='table_border' style=' height: 50px;' width=100% border='1'>
			<tr>
				<td align=center>Kokain: 500 / $kokain</td>
				<td align=center>Heroin: 500 / $heroin</td>
				<td align=center>Marihuana: 500 / $marihuana</td>
				<td align=center>Cigi: $cigi</td>
			</tr>
			<tr>
				<td align=center>Kaja: 5 / $kaja</td>
				<td align=center>�veg: 5 / $uveg</td>
				<td align=center>C4: $c4</td>
				<td align=center>K�tszer: $kotszer (db)</td>
			</tr>
		</table>";
	}
}
else
{
	if(isset($_GET['frakcioskinvaltas']))
	{
		include("oldal/frakcioskinvaltas.php");
	}
	else if(isset($_GET['letarsit']))
	{
		echo 'Teszt';
		$letarsitid = $_GET['letarsit'];
		if($fsor['Kari1'] == $letarsitid)
		{
			$update = mysql_query("UPDATE ucpuserek SET Kari1 = '-1' WHERE `ID` = '".mysql_escape_string($user)."'");
			
			setcookie("feltoltes_ok", "0", time()-100);
			header("Location: index.php?menu=karakterek");
		} else if($fsor['Kari2'] == $letarsitid)
		{
			$update = mysql_query("UPDATE ucpuserek SET Kari2 = '-1' WHERE `ID` = '".mysql_escape_string($user)."'");
			setcookie("feltoltes_ok", "0", time()-100);
			header("Location: index.php?menu=karakterek");
		} else {
			echo 'Ez nem a te karaktered!';
		}
	}
	else if(isset($_GET['letrehoz']))
	{
		echo '<h1>Karakter l�trehoz�sa</h1>';
		if($fsor['Kari1'] != -1 && $fsor['Kari2'] != -1) echo "<font color=red>Maximum 2 karaktered lehet!</font>";
		else {
			$mutat = true;
			if(isset($_POST['letrehoz']))
			{
				$nev		=	$_POST['nev'];
				$jelszo		=	$_POST['pw'];
				$age		=	$_POST['age'];
				$origin		=	$_POST['origin'];
				$sex		=	$_POST['sex'];
				$kkeres = mysql_query("SELECT * FROM playerek Nev='".mysql_escape_string($nev)."'");
				$ks = mysql_fetch_assoc($kkeres);
				$tk = mysql_query("SELECT * FROM ucpuserek WHERE Kari1='".mysql_escape_string($ks[ID])."' OR Kari2='".mysql_escape_string($ks[ID])."'");
				$hash = hash('whirlpool', $jelszo);
				if($jelszo == "" || $nev == "")
					echo "<font color=red>Minden mez� kit�lt�se k�telez�!</font></br>";
				else if(VanIlyenKari($nev))
					echo "<font color=red>Van ilyen karakter m�r!</font><br>";
				else
				{
					$kari_mentes = mysql_query("INSERT INTO playerek (Nev, Pass, Age, Origin, Sex) VALUES ('".mysql_escape_string($nev)."','".mysql_escape_string($hash)."','".mysql_escape_string($age)."','".mysql_escape_string($origin)."','".mysql_escape_string($sex)."')");
					$uj_id = mysql_insert_id();
					if($fsor['Kari1'] == -1) mysql_query("UPDATE ucpuserek SET `Kari1` = '".mysql_escape_string($uj_id)."' WHERE `ID` = '".mysql_escape_string($user)."'");
					else if($fsor['Kari2'] == -1) mysql_query("UPDATE ucpuserek SET `Kari2` = '".mysql_escape_string($uj_id)."' WHERE `ID` = '".mysql_escape_string($user)."'");
					else echo "<font color=red>Az adatokat nem siker�lt elk�ldeni az adatb�zisnak.</font><br>";
					echo "<font color=green>Karakter $nev l�trehozva �s t�rs�tva!</font>";
				}
			}
			if($mutat == true)
			{
				echo "<center><form method=post id=letrehoz>
				<table>
				<tr><td>Karakter neve:</td> <td><input type=text name=nev placeholder='Karaktern�v'></td></tr><br>
				<tr><td>Jelszava:</td> <td><input type=password name=pw placeholder=Jelsz�></td></tr><br>
				<tr><td>Karakter kora:</td> <td><select name=age>";
				for($i = 18; $i < 60; $i++)
				{
					echo "<option>".$i."</option>";
				}
				echo "</td></tr><br>
				<tr><td>Karakter sz�rmaz�sa:</td> <td><select name=origin><option value=1>USA</option><option value=2>Eur�pa</option><option value=3>�zsia</option></select></td></tr><br>
				<tr><td>Karakter neme:</td> <td><select name=sex><option value=1>F�rfi</option><option value=2>N�</option></select></td></tr></table>
				<input type=submit name=letrehoz value='Karakter l�trehoz�sa'></form>";
			}
		}
	}
	else if(isset($_GET['tarsit']))
	{
		echo '<h1>Karakter t�rs�t�sa</h1>';
		if($fsor['Kari1'] != -1 && $fsor['Kari2'] != -1) echo "<font color=red>Maximum 2 karaktert t�rs�thatsz a felhaszn�l�dhoz!</font>";
		else
		{
			$mutat = true;
			if(isset($_POST['tarsit']))
			{
				$n = $_POST['nev'];
				$p = $_POST['pw'];
				$kkeres = mysql_query("SELECT * FROM playerek WHERE `Nev` = '".mysql_escape_string($n)."'");
				$ks = mysql_fetch_assoc($kkeres);
				$tk = mysql_query("SELECT * FROM ucpuserek WHERE `Kari1` = '".mysql_escape_string($ks[ID])."' OR `Kari2` = '".mysql_escape_string($ks[ID])."'");
				$hash = hash('whirlpool', $p);
				if($p == "" || $n == "")
					echo "<font color=red>Minden mez� kit�lt�se k�telez�!</font><br>";
				else if(!VanIlyenKari($n) || RosszPWKari($n, $hash))
					echo "<font color=red>Hib�s karaktern�v, vagy jelsz�!</font><br>";
				else if(mysql_num_rows($tk))
					echo "<font color=red>Ez a karakter m�r t�rs�tva van egy felhaszn�l�hoz!</font><br>";
				else
				{
					if($fsor['Kari1'] == -1) mysql_query("UPDATE ucpuserek SET `Kari1` = '".mysql_escape_string($ks[ID])."' WHERE `ID` = '".mysql_escape_string($user)."'");
					else if($fsor['Kari2'] == -1) mysql_query("UPDATE ucpuserek SET `Kari2` = '".mysql_escape_string($ks[ID])."' WHERE `ID` = '".mysql_escape_string($user)."'");
					else echo "<font color=red>Az adatokat nem siker�lt elk�ldeni az adatb�zisnak.</font><br>";
					header("Location: index.php?menu=karakterek");
				}
			}
			if($mutat == true)
			{
				echo "<center><form method=post id=tarsit>
				<table>
				<tr><td>Karakter neve:</td> <td><input type=text name=nev placeholder='Karaktern�v'></td></tr><br>
				<tr><td>Jelszava:</td> <td><input type=password name=pw placeholder=Jelsz�></td></tr></table><br>
				<input type=submit name=tarsit value='Karakter t�rs�t�sa'></form>";
			}
		}
	}
	else if(isset($_GET['kivalaszt']))
	{
		$k = $_GET['kivalaszt'];
		if($fsor['Kari1'] == $k || $fsor['Kari2'] == $k)
		{
			setcookie("kivalasztott", $k, time()+31536000);
			header("Location: index.php?menu=karakterek");
		}
	}
	else if(isset($_GET['biznisz'])) {
		$bizem_q = mysql_query("SELECT * FROM bizek WHERE ID='{$sor['Bizz']}'");
		$bizem = mysql_fetch_array($bizem_q);

		if($sor['Bizz'] == '-1' OR $sor['Bizz'] == '255')
		{
			msg("2", "Nincs bizniszed!");
		} else {
			echo'<table border="1" style="width: 250px;" class="table_border" cellspacing="0" cellpadding="0">
				<tr style="height: 30px;" align="center">
					<td>Biznisz neve</td>
					<td>Kassza</td>
				</tr>
				<tr style="height: 30px; color:white;" align="center">
					<td>'.$bizem['Nev'].'</td>
					<td>'.$bizem['Kassza'].'</td>
				</tr>
			</table>';
		}
	}
	else if(isset($_GET['kocsi'])) {
		$kocsim_q = mysql_query("SELECT * FROM kocsik WHERE Id='{$sor['Kocsikulcs']}'");
		$kocsim = mysql_fetch_array($kocsim_q);
		if($kocsim['EMP'] == "0")
		{
			$emp = '<font color=red>Nincs</font>';
		} else {
			$emp = '<font color=green>Van</font>';
		}
		if($kocsim['BRendszer'] == "0")
		{
			$br = '<font color=red>Nincs</font>';
		} else {
			$br = '<font color=green>Van</font>';
		}
		if($kocsim['BRendszerAktiv'] == "0")
		{
			$braktiv = '<font color=red>Nem</font>';
		} else {
			$braktiv = '<font color=green>Igen</font>';
		}
		if($kocsim['Zarva'] == "0")
		{
			$zarva = '<font color=red>Nem</font>';
		} else {
			$zarva = '<font color=green>Igen</font>';
		}
		$rendszam = explode(",", $kocsim['Regisztracio']);
		if($rendszam['1'] == "0")
		{
			$rendszam = '<font color=red>Nincs</font>';
		} else {
			$rendszam = $rendszam['0'];
		}
		if($kocsim['Hidraulika'] == "0")
		{
			$hidraulika = '<font color=red>Nincs</font>';
		} else {
			$hidraulika = '<font color=green>Van</font>';
		}
		if($kocsim['Potkerek'] == "0")
		{
			$potkerek = '<font color=red>Nincs</font>';
		} else {
			$potkerek = '<font color=green>Van</font>';
		}
		$brpw = "-";
		if($kocsim['BRendszerKod'] > 0) $brpw = $kocsim['BRendszerKod'];
		if($sor['Kocsikulcs'] == '-1')
		{
			echo'<table border="1" style=" width: 256px; height: 256px;" class="table_border" cellspacing="0" cellpadding="0">
					<tr>
<td><img src="img/jarmuvek/nincskocsi.png"></td>
					</tr>
					<tr style="height: 30px;">
<td align=center>Szerezz be egy kocsit m�g ma!</td>
					</tr>
				</table>';
		} else {
			echo'
				<table style=" width: 204px;" border="1" style=" height: 200px;" class="table_border" cellspacing="0" cellpadding="0" width=100%>
					<tr>
<td><img src="img/jarmuvek/'.$kocsim['Model'].'.jpg"></td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>EMP: '.$emp.'</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>Biztons�gi rendszer: '.$br.'</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>Biztons�gi rendszer pw: '.$brpw.'</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>Biztons�gi rendszer akt�v: '.$braktiv.'</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>Z�rva: '.$zarva.'</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>Hidraulika: '.$hidraulika.'</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>Rendsz�m: '.$rendszam.'</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>P�tker�k: '.$potkerek.' </td>
					</tr>
				</table>
			';
		}
	}
	else if(isset($_GET['bankszamla'])) {
		if($sor['Admin'] < '1') {
			msg("2", "Ez az oldal jelenleg fejleszt�s alatt �ll! N�zz vissza k�s�bb!");
		} else {
			$bsz_q = mysql_query("SELECT * FROM playerek WHERE ID='{$sor['Bank']}'");
			$bsz = mysql_fetch_array($bsz_q);
			$bszz = explode(",",$sor['BankSzamla']);

			echo'<table border="1" style="width: 250px; color: #FFFFFF;" class="table_border" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="2"><img src="img/bank.png"></td>
				</tr>
				<tr class="frakciok_eger_ravisz_sav" style="height: 30px;" align=center">
					<td align=center><b>Banksz�mlasz�m:</b></td>
					<td align=center>'.$bszz['1'].'</td>
				</tr>
				<tr class="frakciok_eger_ravisz_sav" style="height: 30px;" align=center">
					<td align=center><b>Sz�mlaJelsz�:</b></td>
					<td align=center>'.$bszz['2'].'</td>
				</tr>
				<tr class="frakciok_eger_ravisz_sav" style="height: 30px;" align=center">
					<td align=center><b>�sszeg:</b></td>
					<td align=center>'.$sor['Bank'].'</td>
				</tr>
				<tr style="height: 50px;" align=center">
					<td colspan="2" align=center><div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=karakterek&utalas\';">Utal�s</div></td>
				</tr>
			</table>';
		}
	}
	/*else if(isset($_GET['utalas'])) {
		if($sor['Admin'] < '1') {
			msg("2", "Ez az oldal jelenleg fejleszt�s alatt �ll! N�zz vissza k�s�bb!");
		} else {
			msg("1", "Mivel admin vagy l�tod az oldalt! Viszont m�g fejleszt�s alatt �ll By Divikeeh&Josh!");
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{
				$szamlaszam	=	$_POST['szamlaszam'];
				$osszeg		=	$_POST['osszeg'];
				$kozlemeny	=	$_POST['kozlemeny'];
				$jelszo		=	$_POST['jelszo'];
				if(empty($szamlaszam) OR empty($osszeg) OR empty($kozlemeny) OR empty($jelszo))
				{
					msg("2","Minden mez� kit�lt�se k�telez�!");
				} else {
					$bsz_e_q_ize = '1,'.$szamlaszam.','.*;
					$bsz_e_q = mysql_query("SELECT * FROM playerek WHERE BankSzamla='{$bsz_e_q_ize}'");
					if(!$bsz_e_q)
					{
						die('Hiba:' mysql_error());
					}
					$bsz_e = mysql_fetch_array($bsz_e_q);
					if(!$bsz_e)
					{
						msg("2","Szop�s");
					} else {
						msg("1",'Aha any�d a z�ld');
					}
				}
			}
			echo'<form>
				<table border="1" style="width: 300px; height: 250px; color: #FFFFFF;" class="table_border" cellspacing="0" cellpadding="0">
					<tr>
						<td colspan="2" align=center><img src="img/bank.png"></td>
					</tr>
					<tr class="frakciok_eger_ravisz_sav" style="height: 30px;" align=center">
						<td align=center>Szamlasz�m: </td>
						<td align=center><input type=text name=szamlaszam placeholder="Szamlaszam"></td>
					</tr>
					<tr class="frakciok_eger_ravisz_sav" style="height: 30px;" align=center">
						<td align=center>�sszeg: </td>
						<td align=center><input type=text name=osszeg placeholder="Osszeg"></td>
					</tr>
					<tr class="frakciok_eger_ravisz_sav" style="height: 30px;" align=center">
						<td align=center>K�zlem�ny: </td>
						<td align=center><input type=text name=kozlemeny placeholder="K�zlem�ny"></td>
					</tr>
					<tr class="frakciok_eger_ravisz_sav" style="height: 30px;" align=center">
						<td align=center>Karaktered jelszava: </td>
						<td align=center><input type=text name=jelszo placeholder="Karaktered jelszava"></td>
					</tr>
					<tr style="height: 30px;" align="center">
						<td align="center" colspan="2">
							<input type="submit" name="utal" value="Utal�s">
						</td>
					</tr>
				</table>
			</form>';
		}
	}*/
	else if(isset($_GET['telefon'])) {
		if($sor['Phone'] > '0') {
			echo'<table border="0" style="color: #000000; width: 160px; height: 292px; background-image:url(\'img/iphone.png\');" cellspacing="0" cellpadding="0">
				<tr styhel="height: 92px;">
					<td valign="top" style="padding-top: 53px; padding-left: 15px;">Telefonsz�mod: <font style="font-size:10px;">'.$sor['Phone'].'</font></td>
				</tr>
				<tr style="height: 15px;">
					<td valign="top" style="padding-top 10px; padding-left: 20px; font-size: 10px;">Az �n aktu�lis egyenlege:</div></td>
				</tr>
				<tr style="height: 15px;">
					<td valign="top" align="center">'.$sor['TeloEgyenleg'].'FT</td>
				</tr>
				<tr style="height: 170px;">
					<td valign="top" align="center" style="padding-top: 3px;"><div class="telefon_gomb" onclick="window.location.href=\'index.php?menu=karakterek&feltolt\';">Felt�lt�s</div></td>
				</tr>
			</table>';
		} else {
			msg("2", "Sajn�lom, de te nem rendelkezel telefonk�sz�l�kkel! Ezt az oldalt csak akkor �rheted el ha m�r v�s�rolt�l telefont!");
		}
	}
	else if(isset($_GET['feltolt'])) {
		if($sor['Phone'] > '0') {
			msg("3", "A gomb megnyom�s�val a rendszer automatikusan levonja a kezedb�l a felt�lt� k�rtya �r�t!");
			echo'
			<table border="0" cellspacing="0" cellpadding="0" style="width: 500px;">
				<tr align="center">
					<td><div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=karakterek&feltolt&1\';">1600-as felt�lt� k�rtya</div></td>
					<td><div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=karakterek&feltolt&2\';">3200-as felt�lt� k�rtya</div></td>
				</tr>
				<tr style="height: 10px;">
					<td></td>
					<td></td>
				</tr>
				<tr align="center">
					<td><div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=karakterek&feltolt&3\';">5200-as felt�lt� k�rtya</div></td>
					<td><div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=karakterek&feltolt&4\';">7600-as felt�lt� k�rtya</div></td>
				</tr>
			</table>';
		} if(isset($_GET['1'])) {
			$penzelvetel = $sor['Money']-1600;
			$mysql_mentess = mysql_query("UPDATE playerek SET Money='{$penzelvetel}' WHERE ID='{$sor['ID']}'");
			$egyenleg = $sor['TeloEgyenleg']+1600;
			$mysql_mentes = mysql_query("UPDATE playerek SET TeloEgyenleg='{$egyenleg}' WHERE ID='{$sor['ID']}'");
			msg("1", "Sikeresen felt�lt�tted a telefonod egyenleg�t 1600ft-al!");
		} else if(isset($_GET['2'])) {
			$penzelvetel = $sor['Money']-3200;
			$mysql_mentess = mysql_query("UPDATE playerek SET Money='{$penzelvetel}' WHERE ID='{$sor['ID']}'");
			$egyenleg = $sor['TeloEgyenleg']+3200;
			$mysql_mentes = mysql_query("UPDATE playerek SET TeloEgyenleg='{$egyenleg}' WHERE ID='{$sor['ID']}'");
			msg("1", "Sikeresen felt�lt�tted a telefonod egyenleg�t 3200ft-al!");
		} else if(isset($_GET['3'])) {
			$penzelvetel = $sor['Money']-5200;
			$mysql_mentess = mysql_query("UPDATE playerek SET Money='{$penzelvetel}' WHERE ID='{$sor['ID']}'");
			$egyenleg = $sor['TeloEgyenleg']+5200;
			$mysql_mentes = mysql_query("UPDATE playerek SET TeloEgyenleg='{$egyenleg}' WHERE ID='{$sor['ID']}'");
			msg("1", "Sikeresen felt�lt�tted a telefonod egyenleg�t 5200ft-al!");
		} else if(isset($_GET['4'])) {
			$penzelvetel = $sor['Money']-7600;
			$mysql_mentess = mysql_query("UPDATE playerek SET Money='{$penzelvetel}' WHERE ID='{$sor['ID']}'");
			$egyenleg = $sor['TeloEgyenleg']+7600;
			$mysql_mentes = mysql_query("UPDATE playerek SET TeloEgyenleg='{$egyenleg}' WHERE ID='{$sor['ID']}'");
			msg("1", "Sikeresen felt�lt�tted a telefonod egyenleg�t 7600ft-al!");
		}
	}
	else if(isset($_GET['haz'])) {
		$hazam_q = mysql_query("SELECT * FROM hazak WHERE ID='{$sor['House']}'");
		$hazam = mysql_fetch_array($hazam_q);

		if($sor['House'] == '-1')
		{
			echo'<table border="1" style=" width: 250px; height: 250px;" class="table_border" cellspacing="0" cellpadding="0">
					<tr>
<td><img src="img/hazak/nincshaz.png"></td>
					</tr>
					<tr style="height: 30px;">
<td align=center>Szerezz be egy h�zat m�g ma!</td>
					</tr>
				</table>';
		} else {
			echo'
				<table border="1" style=" width: 200px; height: 200px;" class="table_border" cellspacing="0" cellpadding="0" width=100%>
					<tr>
<td colspan="5"><img style=" height: 200px;" src="img/hazak/'.$hazam['Belso'].'.jpg"></td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>B�relhet�: '.IgenNem($hazam['Kiado']).'</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>P�nz: '.($hazam['Penz']).' FT</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>Cigi: '.($hazam['Cigi']).' db</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>Kaja: '.($hazam['Kaja']).' db</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>Gy�gyszer: '.($hazam['Gyogyszer']).' db</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>Kokain: '.($hazam['Kokain']).' g</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>Heroin: '.($hazam['Heroin']).' g</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>Marihuana: '.($hazam['Marihuana']).' g</td>
					</tr>
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav">
<td align=center>Material: '.($hazam['Material']).' db</td>
					</tr>
				</table>
			';
		}
	} else if(isset($_GET['ruhatar']))
	{
		if(isset($_GET['valt']))
		{
			if($_GET['valt'] == "") { msg("2","Nincs megadva skin id"); }
			else {
				$skin = $_GET['valt'];
				if($skin == "1" OR $skin == "14" OR $skin == "15" OR $skin == "16" OR $skin == "18" OR $skin == "19" OR $skin == "21" OR $skin == "22" OR $skin == "23" OR $skin == "24" OR $skin == "26" OR $skin == "27" OR $skin == "28" OR $skin == "32" OR $skin == "34" OR $skin == "35" OR $skin == "36" OR $skin == "37" OR $skin == "43" OR $skin == "44" OR $skin == "45" OR $skin == "49" OR $skin == "51" OR $skin == "52" OR $skin == "58" OR $skin == "60" OR $skin == "62" OR $skin == "66" OR $skin == "67" OR $skin == "68" OR $skin == "72" OR $skin == "78" OR $skin == "79" OR $skin == "80" OR $skin == "81" OR $skin == "82" OR $skin == "83" OR $skin == "84" OR $skin == "94" OR $skin == "95" OR $skin == "96" OR $skin == "97" OR $skin == "100" OR $skin == "101" OR $skin == "128" OR $skin == "132" OR $skin == "133" OR $skin == "134" OR $skin == "135" OR $skin == "136" OR $skin == "137" OR $skin == "143" OR $skin == "144" OR $skin == "146" OR $skin == "153" OR $skin == "154" OR $skin == "155" OR $skin == "156" OR $skin == "158" OR $skin == "159" OR $skin == "160" OR $skin == "162" OR $skin == "167" OR $skin == "168" OR $skin == "170" OR $skin == "176" OR $skin == "179" OR $skin == "180" OR $skin == "181" OR $skin == "182" OR $skin == "183" OR $skin == "186" OR $skin == "200" OR $skin == "202" OR $skin == "203" OR $skin == "204" OR $skin == "206" OR $skin == "209" OR $skin == "212" OR $skin == "213" OR $skin == "220" OR $skin == "221" OR $skin == "227" OR $skin == "230" OR $skin == "234" OR $skin == "235" OR $skin == "236" OR $skin == "239" OR $skin == "247" OR $skin == "248" OR $skin == "249" OR $skin == "250" OR $skin == "252" OR $skin == "258" OR $skin == "259" OR $skin == "260" OR $skin == "261" OR $skin == "263" OR $skin == "264" OR $skin == "268" OR $skin == "291" OR $skin == "297" OR $skin == "10" OR $skin == "12" OR $skin == "31" OR $skin == "38" OR $skin == "39" OR $skin == "40" OR $skin == "41" OR $skin == "53" OR $skin == "54" OR $skin == "55" OR $skin == "56" OR $skin == "63" OR $skin == "64" OR $skin == "75" OR $skin == "76" OR $skin == "77" OR $skin == "87" OR $skin == "88" OR $skin == "89" OR $skin == "90" OR $skin == "92" OR $skin == "129" OR $skin == "130" OR $skin == "131" OR $skin == "138" OR $skin == "139" OR $skin == "140" OR $skin == "145" OR $skin == "151" OR $skin == "152" OR $skin == "157" OR $skin == "169" OR $skin == "178" OR $skin == "190" OR $skin == "192" OR $skin == "194" OR $skin == "196" OR $skin == "197" OR $skin == "198" OR $skin == "199" OR $skin == "201" OR $skin == "205" OR $skin == "207" OR $skin == "211" OR $skin == "214" OR $skin == "215" OR $skin == "218" OR $skin == "219" OR $skin == "224" OR $skin == "225" OR $skin == "226" OR $skin == "231" OR $skin == "232" OR $skin == "237" OR $skin == "238" OR $skin == "243" OR $skin == "244" OR $skin == "245" OR $skin == "246" OR $skin == "251" OR $skin == "256" OR $skin == "257" OR $skin == "263" OR $skin == "298")
				{
					if(isset($_GET['kp']) OR isset($_GET['bsz']))
					{
if(isset($_GET['kp']))
{
	if($sor['Money'] < 18001)
	{
		msg("2","Nincs el�g p�nz a kezedbe. �r: 18.000Ft");
	} else {
		$vegosszeg = $sor['Money'] - 18000;
		$penz_levon = mysql_query("UPDATE playerek SET Money='{$vegosszeg}' WHERE Nev='{$sor['Nev']}'");
		if(!$penz_levon)
		{
			die('Hiba: '.mysql_error());
		}
		$uj_skin = mysql_query("UPDATE playerek SET Model='{$skin}' WHERE Nev='{$sor['Nev']}'");
		if(!$uj_skin)
		{
			die('Hiba: '.mysql_error());
		}
		setcookie("ujskin","1", time()+31536000);
		header("Location: index.php?menu=karakterek&ruhatar");
	}
} else if(isset($_GET['bsz']))
{
	if($sor['Bank'] < 18001)
	{
		msg("2","Nincs el�g p�nz a bankba. �r: 18.000Ft");
	} else {
		$vegosszeg = $sor['Bank'] - 18000;
		$penz_levon = mysql_query("UPDATE playerek SET Bank='{$vegosszeg}' WHERE Nev='{$sor['Nev']}'");
		if(!$penz_levon)
		{
			die('Hiba: '.mysql_error());
		}
		$uj_skin = mysql_query("UPDATE playerek SET Model='{$skin}' WHERE Nev='{$sor['Nev']}'");
		if(!$uj_skin)
		{
			die('Hiba: '.mysql_error());
		}
		setcookie("ujskin","1",time()+31536000);
		header("Location: index.php?menu=karakterek&ruhatar");
	}
}
					} else {
msg("2","Nincs kiv�lasztva fizet�si eszk�z");
					}
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			}
		}
		msg("3","Egy �j skin �ra: <b>18.000Ft</b>");
		echo '<img src="img/binco.jpg">';
		echo '<div style="padding-top: 20px;"></div>';
		if(isset($_COOKIE['ujskin']))
		{
			if($_COOKIE['ujskin'] == "1")
			{
				msg("1","Sikeresen v�ltott�l ruh�t!");
				setcookie("ujskin","1",time()-100);
			}
		}
		$darab = '0';
		echo '<table border="0" cellpadding="0" cellspacing="0" width="650">';
		echo '<tr>';
		for($skin = 1; $skin < 297; $skin++)
		{

			if($sor['Sex'] == "1")
			{
				if($skin == "1" OR $skin == "14" OR $skin == "15" OR $skin == "16" OR $skin == "18" OR $skin == "19" OR $skin == "21" OR $skin == "22" OR $skin == "23" OR $skin == "24" OR $skin == "26" OR $skin == "27" OR $skin == "28" OR $skin == "32" OR $skin == "34" OR $skin == "35" OR $skin == "36" OR $skin == "37" OR $skin == "43" OR $skin == "44" OR $skin == "45" OR $skin == "49" OR $skin == "51" OR $skin == "52" OR $skin == "58" OR $skin == "60" OR $skin == "62" OR $skin == "66" OR $skin == "67" OR $skin == "68" OR $skin == "72" OR $skin == "78" OR $skin == "79" OR $skin == "80" OR $skin == "81" OR $skin == "82" OR $skin == "83" OR $skin == "84" OR $skin == "94" OR $skin == "95" OR $skin == "96" OR $skin == "97" OR $skin == "100" OR $skin == "101" OR $skin == "128" OR $skin == "132" OR $skin == "133" OR $skin == "134" OR $skin == "135" OR $skin == "136" OR $skin == "137" OR $skin == "143" OR $skin == "144" OR $skin == "146" OR $skin == "153" OR $skin == "154" OR $skin == "155" OR $skin == "156" OR $skin == "158" OR $skin == "159" OR $skin == "160" OR $skin == "162" OR $skin == "167" OR $skin == "168" OR $skin == "170" OR $skin == "176" OR $skin == "179" OR $skin == "180" OR $skin == "181" OR $skin == "182" OR $skin == "183" OR $skin == "186" OR $skin == "200" OR $skin == "202" OR $skin == "203" OR $skin == "204" OR $skin == "206" OR $skin == "209" OR $skin == "212" OR $skin == "213" OR $skin == "220" OR $skin == "221" OR $skin == "227" OR $skin == "230" OR $skin == "234" OR $skin == "235" OR $skin == "236" OR $skin == "239" OR $skin == "247" OR $skin == "248" OR $skin == "249" OR $skin == "250" OR $skin == "252" OR $skin == "258" OR $skin == "259" OR $skin == "260" OR $skin == "261" OR $skin == "263" OR $skin == "264" OR $skin == "268" OR $skin == "291" OR $skin == "297")
				{
					echo '<td style="padding-bottom: 5px;"><img title="'.$skin.'" src="skinek/Skin_'.$skin.'.png"><br>
<table border="0" width="55" cellspacing="0" cellpadding="0">
	<tr>
		<td style="font-size: 12px; background: #000; font-weight: bold;" class="bg_light" align="center" width="50%" title="Banksz�ml�r�l vonja le"><a href="index.php?menu=karakterek&ruhatar&valt='.$skin.'&bsz">BSZ</a></td>
		<td style="font-size: 12px; background: #000; font-weight: bold;" class="bg_light" align="center" width="50%" title="K�zb�l vonja le"><a href="index.php?menu=karakterek&ruhatar&valt='.$skin.'&kp">KP</a></td>
	</tr>
</table>
					</td>';
					if($darab == "10")
					{
echo '</tr><tr>';
$darab = '0';
					} else {
$darab++;
					}
				}
			} else if($sor['Sex'] == "2")
			{
				if($skin == "10" OR $skin == "12" OR $skin == "31" OR $skin == "38" OR $skin == "39" OR $skin == "40" OR $skin == "41" OR $skin == "53" OR $skin == "54" OR $skin == "55" OR $skin == "56" OR $skin == "63" OR $skin == "64" OR $skin == "75" OR $skin == "76" OR $skin == "77" OR $skin == "87" OR $skin == "88" OR $skin == "89" OR $skin == "90" OR $skin == "92" OR $skin == "129" OR $skin == "130" OR $skin == "131" OR $skin == "138" OR $skin == "139" OR $skin == "140" OR $skin == "145" OR $skin == "151" OR $skin == "152" OR $skin == "157" OR $skin == "169" OR $skin == "178" OR $skin == "190" OR $skin == "192" OR $skin == "194" OR $skin == "196" OR $skin == "197" OR $skin == "198" OR $skin == "199" OR $skin == "201" OR $skin == "205" OR $skin == "207" OR $skin == "211" OR $skin == "214" OR $skin == "215" OR $skin == "218" OR $skin == "219" OR $skin == "224" OR $skin == "225" OR $skin == "226" OR $skin == "231" OR $skin == "232" OR $skin == "237" OR $skin == "238" OR $skin == "243" OR $skin == "244" OR $skin == "245" OR $skin == "246" OR $skin == "251" OR $skin == "256" OR $skin == "257" OR $skin == "263" OR $skin == "298")
				{
					echo '<td style="padding-bottom: 5px;"><img title="'.$skin.'" src="skinek/Skin_'.$skin.'.png"><br>
<table border="0" width="55" cellspacing="0" cellpadding="0">
	<tr>
		<td style="font-size: 12px; background: #000; font-weight: bold;" class="bg_light" align="center" width="50%" title="Banksz�ml�r�l vonja le"><a href="index.php?menu=karakterek&ruhatar&valt='.$skin.'&bsz">BSZ</a></td>
		<td style="font-size: 12px; background: #000; font-weight: bold;" class="bg_light" align="center" width="50%" title="K�zb�l vonja le"><a href="index.php?menu=karakterek&ruhatar&valt='.$skin.'&kp">KP</a></td>
	</tr>
</table>
					</td>';
					if($darab == "10")
					{
echo '</tr><tr>';
$darab = '0';
					} else {
$darab++;
					}
				}
			}
		}
		echo '</tr>';
		echo '</table>';
	}
}?>