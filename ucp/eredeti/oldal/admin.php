<?php
if(isset($fsor))
{
if($sor['Admin'] > '0' OR $fsor['AAA'] > '0')
{
	if(isset($_GET['adminok'])) { $aloldalneve = '- Adminok'; }
	else if(isset($_GET['proba'])) { $aloldalneve = '- proba'; }
	else if(isset($_GET['adminsegedek'])) { $aloldalneve = '- Adminseg�dek'; }
	/*else if(isset($_GET['snm'])) { $aloldalneve = '- S&M'; }*/
	else if(isset($_GET['bannok'])) { $aloldalneve = '- Bannok'; }
	else if(isset($_GET['ban'])) { $aloldalneve = '- Bannol�s'; }
	else if(isset($_GET['adminjailek'])) { $aloldalneve = '- Adminjail'; }
	else if(isset($_GET['frakciok'])) { $aloldalneve = '- Frakci�k'; }
	else if(isset($_GET['premiumpont'])) { $aloldalneve = '- Pr�mium Pont'; }
	else if(isset($_GET['admin_frakciok'])) { $aloldalneve = '- Frakci�cska'; }
	else if(isset($_GET['playerkereses'])) { $aloldalneve = '- J�t�kos keres�se'; }
	else if(isset($_GET['kiragad'])) { $aloldalneve = '- Kiragad�s'; }
	else if(isset($_GET['bizniszek'])) { $aloldalneve = '- Bizniszek'; }
	else if(isset($_GET['hazak'])) { $aloldalneve = '- H�zak'; }
	else if(isset($_GET['nullazas'])) { $aloldalneve = '- Null�z�s - H�z'; }
	else if(isset($_GET['nullazass'])) { $aloldalneve = '- Null�z�s - Biznisz'; }
	//else if(isset($_GET['playerek'])) { $aloldalneve = '- J�t�kosok'; }
	else if(isset($_GET['player'])) { $aloldalneve = '- Player adatai'; }
	else if(isset($_GET['logok'])) { $aloldalneve = '- Logok'; }
	else if(isset($_GET['ucpfelhasznalok'])) { $aloldalneve = '- UCP Felhaszn�l�k'; }
	else if(isset($_GET['otletek'])) { $aloldalneve = '- �tletek'; }
	else { header("Location: index.php?menu=admin&adminok"); }
	echo "<h1>Admin r�szleg ".$aloldalneve."</h1>";
	if(isset($_GET['otletek']))
	{
		echo'<table border="1" class="table_border" cellspacing="0" cellpadding="0" style="width: 500px;">
				<tr>
					<td align="center" style="font-weight: bold; font-size: 14px; color: #ffffff;" style="width: 240px; height: 25px;">�tlet neve</td>
					<td align="center" style="font-weight: bold; font-size: 14px; color: #ffffff;" style="width: 240px; height: 25px;">R�szletek</td>
					<td align="center" style="font-weight: bold; font-size: 14px; color: #ffffff;" style="width: 20px; height: 25px;">IP C�M</td>
				</tr>';
			$otletek_q = mysql_query("SELECT * FROM otletek ORDER BY id DESC");
			while($otletek = mysql_fetch_array($otletek_q))
			{
				echo'<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
					<td>'.$otletek['otlet'].'</td>
					<td>'.$otletek['reszlet'].'</td>
					<td>'.$otletek['ip'].'</td>
				</tr>';
			}
			echo'</table>';
	}
	if(isset($_GET['logok']))
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-right: 5px;" align="center">
						<div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&logok&m=login\';">Bejelentkez�sek</div>
					</td>
					<td style="padding-right: 5px;" align="center">
						<div class="subnav_gomb_leader" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&logok&m=jelszovaltucp\';">Jelsz�v�lt�s UCP</div>
					</td>
					<td style="padding-left: 5px;" align="center">
						<div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&admin&logok&m=jelszovaltkarakter\';">Jelsz�v�lt�s karakter</div>
					</td>
				</tr>
				<tr>
					<td style="padding-right: 5px;" align="center">
						<div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&logok&m=ban\';">Bannol�s</div>
					</td>
					<td style="padding-right: 5px;" align="center">
						
					</td>
					<td style="padding-left: 5px;" align="center">
						<div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&admin&logok&m=unban\';">Unbannol�s</div>
					</td>
				</tr>
				<tr>
					<td style="padding-right: 5px;" align="center">
						<div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&logok&m=ajbe\';">Admijail be</div>
					</td>
					<td style="padding-right: 5px;" align="center">
						
					</td>
					<td style="padding-left: 5px;" align="center">
						<div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&admin&logok&m=ajki\';">Adminjail ki</div>
					</td>
				</tr>
				<tr>
					<td style="padding-right: 5px;" align="center">
						<div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&logok&m=asad\';">Adminseg�d ad</div>
					</td>
					<td style="padding-right: 5px;" align="center">
						
					</td>
					<td style="padding-left: 5px;" align="center">
						<div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&admin&logok&m=aselvesz\';">Adminseg�d elvesz</div>
					</td>
				</tr>
				<tr>
					<td style="padding-right: 5px;" align="center">
						<div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&logok&m=smfelvesz\';">S&M felvesz</div>
					</td>
					<td style="padding-right: 5px;" align="center">
						
					</td>
					<td style="padding-left: 5px;" align="center">
						<div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&admin&logok&m=smkirug\';">S&M kirug</div>
					</td>
				</tr>
				<tr>
					<td style="padding-right: 5px;" align="center">
						<div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&logok&m=adminad\';">Admin ad�s</div>
					</td>
					<td style="padding-right: 5px;" align="center">
						<div class="subnav_gomb_leader" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&logok&m=adminrang\';">Admin szint �ll�t�s</div>
					</td>
					<td style="padding-left: 5px;" align="center">
						<div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&admin&logok&m=adminelvesz\';">Admin elv�tel</div>
					</td>
				</tr>
			</table>';
		$datum_ma = date("Y.m.d.");
		$d_kezdet	= $datum_ma.' 00:01';
		$d_vege		= $datum_ma.' 23:59';
		//$mysql_maeddig = mysql_query("SELECT * FROM ucp_log WHERE mi='login' AND (datum > '{$d_kezdet}' AND datum < '{$d_vege}')");
		//$maeddig = mysql_num_rows($mysql_maeddig);
		if(isset($_GET['m']))
		{
			echo '<div style="padding-top: 30px;"></div>';
			echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="700">
					<tr>
						<td style="font-weight: bold; font-size: 14px; color: #ffffff;">IG N�v</td>
						<td style="font-weight: bold; font-size: 14px; color: #ffffff;">Sz�veg</td>
						<td style="font-weight: bold; font-size: 14px; color: #ffffff;" width="105">D�tum</td>
					</tr>';
			$log_betolt = mysql_query("SELECT * FROM ucp_log WHERE mi='{$_GET['m']}' ORDER BY datum DESC");
			if(!$log_betolt)
			{
				die('Hiba: '.mysql_error());
			}
			while($log_adatai = mysql_fetch_array($log_betolt))
			{
				echo '<tr>
						<td style="color: #ffffff; font-size: 13px;">'.$log_adatai['ignev'].'</td>
						<td style="color: #ffffff; font-size: 13px;">'.$log_adatai['szoveg'].'</td>
						<td style="color: #ffffff; font-size: 13px;">'.$log_adatai['datum'].'</td>
					</tr>';
			}
			echo '</table>';
		}
	}
	else if(isset($_GET['ucpfelhasznalok']))
	{
		echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="500">
				<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Felhaszn�l�n�v</td>
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Email c�m</td>
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Jelsz�v�lt�s</td>
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">T�rl�s</td>
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">T�lt�s</td>
				</tr>';
		$ufelh_q = mysql_query("SELECT * FROM ucpuserek");
		while($ufelh = mysql_fetch_array($ufelh_q))
		{
			echo '<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
					<td style="font-size: 13px; color: #ffffff;">'.$ufelh['Felhasznalonev'].'</td>
					<td style="font-size: 13px; color: #ffffff;">'.$ufelh['Email'].'</td>';
				if($sor['Admin'] > '1337')
				{
					echo'<td><a href="index.php?menu=admin&ujjelszo='.$ufelh['ID'].'" style="font-size: 13px; padding-left: 5px;">�j jelsz�</a></td>';
					echo'<td><a href="index.php?menu=admin&torol='.$ufelh['ID'].'" style="font-size: 13px; padding-left: 5px;">T�rl�s</a></td>';
					echo'<td><a href="index.php?menu=admin&tilt='.$ufelh['ID'].'" style="font-size: 13px; padding-left: 5px;">T�lt�s</a></td>';
				}
				echo'</tr>';
		}
		echo'</table>';
	}
	else if(isset($_GET['player']))
	{
		$player = $_GET['player'];
		
		$player_adatai_q = mysql_query("SELECT * FROM playerek WHERE ID='{$player}'");
		$player_adatai = mysql_fetch_array($player_adatai_q);
		msg("3", "Player adatai: ".$player_adatai['Nev']."!");
		echo '<br><h2><center>�ltal�nos adatok</center></h2>';
		$neme = "N�";
		if($player_adatai['Sex'] == 1) $neme = "F�rfi";
		$szarm = $player_adatai['Origin'];
		$rang = "-";
		if($player_adatai['Member'] > 0) $rang = $player_adatai['Rank'];
		$hazastars = "Nincs";
		if($player_adatai['Married'] > 0) $hazastars = $player_adatai['MarriedTo'];
		$bindok = "-";
		if($player_adatai['Jailed'] > 0) $bindok = $player_adatai['JailOK'];
		$bbezart = "-";
		if($player_adatai['Jailed'] > 0) $bbezart = $player_adatai['JailtAdta'];
		$bortone = $sor['Jailed'];
		$bido = "-";
		if($player_adatai['Jailed'] > 0) $bido = $player_adatai['JailTime'].' mp (~'.$player_adatai['JailTime']/60 .'perc)';
		$bizk = mysql_query("SELECT * FROM bizek WHERE ID='".mysql_escape_string($player_adatai['Bizz'])."'");
		$biz = mysql_fetch_assoc($bizk);
		$biznev = str_replace('~r~','<span style="color:red" />',$biz['Nev']);
		$biznev = str_replace('~b~','<span style="color:blue" />',$biznev);
		$biznev = str_replace('~w~','<span style="color:white" />',$biznev);
		$biznev = str_replace('~g~','<span style="color:#00FF00" />',$biznev);
		$biznev = str_replace('~y~','<span style="color:yellow" />',$biznev);
		$biznev = str_replace('~n~',' ',$biznev);
		$biznev = utf8_encode($biznev);
		if($player_adatai['Bizz'] == -1) $biznev = "Nincs";
		$elsohaz = "Nincs";
		$elsokocsi = "Nincs";
		$kaja = "Nincs";
		$uveg = "Nincs";
		$c4 = "<font color=red>Nincs</font>";
		$cigi = "Nincs";
		$kotszer = "Nincs";
		$cuccok = explode(",", $player_adatai['Cuccok']);
		
		$mati		= $cuccok['4'];
		$kokain		= $cuccok['5'];
		$heroin		= $cuccok['6'];
		$marihuana	= $cuccok['7'];
		if($player_adatai['Cigi'] > 0) $cigi = $player_adatai['Cigi'];
		if($player_adatai['C4'] != 0) $c4 = "<font color=green>Van</font>";
		if($player_adatai['Kotszer'] > 0) $kotszer = "$player_adatai[Kotszer]";
		if($player_adatai['House'] != -1) $elsohaz = "Van (See $player_adatai[House])";
		if($player_adatai['Kaja'] != 0) $kaja = "$player_adatai[Kaja]";
		if($player_adatai['Uveg'] != -1) $uveg = "$player_adatai[Uveg]";
		if($player_adatai['Kocsikulcs'] != -1) $elsokocsi = "Van ($player_adatai[Kocsikulcs])";
		$allapot = "<font color=red>Offline</font>";
		if($player_adatai['Online'] == 1) $allapot = "<font color=green><b>Online</b></font>";
		$utso = "Most";
		if($player_adatai['Online'] == 0) $utso = date("Y. m. d. G:i:s", $player_adatai['UtoljaraAktiv']);
		$telszam = "Nincs";
		if($player_adatai['Phone'] > 0) $telszam = $player_adatai['Phone'];
		$bszinfo = explode(",", $player_adatai['BankSzamla']);
		$pdata = $player_adatai['PremiumPont'];
		$bankszam = "-";
		$bankft = "-";
		$bankjelszo = "-";
		if($bszinfo[0] == 1) $bankszam = $bszinfo[1];
		if($bszinfo[0] == 1) $bankft = "$player_adatai[Bank] Ft";
		if($bszinfo[0] == 1) $bankjelszo = $bszinfo[2];
		echo "<table class='table_border' style=' height: 250px;' width=100% border='1'>
		<tr>
			<td align=center>N�v: <font color=white>$player_adatai[Nev]</font></td>
			<td align=center>Nem: <font color=white>$neme</font></td>
			<td align=center>Kor: <font color=white>$player_adatai[Age]</font></td>
			<td align=center>Sz�rmaz�s: <font color=white>$szarmazasok[$szarm]</font></td>
			<td align=center>Admin szint: <font color=white>$player_adatai[Admin]</font></td>
		</tr>
		<tr>
			<td align=center>Frakci�: <font color=white>".$fract[$player_adatai['Member']]."</font></td>
			<td align=center>Rang: <font color=white>$rang</td>
			<td align=center>Leader jog: <font color=white>".VanNincs($player_adatai['Leader'])."</font></td>
			<td align=center>F�munka: <font color=white>".$munkak[$player_adatai['Job1']]."</font></td>
			<td align=center>M�sodmunka: <font color=white>".$munkak[$player_adatai['Job2']]."</font></td>
		</tr>
		<tr>
			<td align=center>B�rt�nben: <font color=white>".IgenNem($player_adatai['Jailed'])." ($bnevek[$bortone])</font></td>
			<td align=center>Indok: <font color=white>$bindok</font></td>
			<td align=center>Bez�rt: <font color=white>$bbezart</font></td>
			<td align=center>Id�: <font color=white>$bido</font></td>
			<td align=center>J�tszott �r�k: <font color=white>$player_adatai[ConnectedTime]</font></td>
		</tr>
		<tr>
			<td align=center>H�z: <font color=white>$elsohaz</font></td>
			<td align=center>J�rm�: <font color=white>$elsokocsi</font></td>
			<td align=center>Biznisz: <font color=white>$biznev</font></td>
			<td align=center>Telefonsz�m: <font color=white>$telszam</font></td>
			<td align=center>�llapot: <font color=white>$allapot</font></td>
		</tr>
		<tr>
			<td align=center>K�szp�nz: <font color=white>$player_adatai[Money] Ft</font></td>
			<td align=center>Banksz�mla: <font color=white>".VanNincs($bszinfo[0])."</font></td>
			<td align=center>Egyenleg: <font color=white>$player_adatai[Bank] Ft</font></td>
			<td align=center>Sz�mlasz�m: <font color=white>$bankszam</font></td>
			<td align=center>Sz�mla jelsz�: <font color=white>$bankjelszo</font></td>
		</tr>
		<tr>
			<td align=center>Adminseg�d: <font color=white>".IgenNem($player_adatai['ASJog'])."</font></td>
			<td align=center>H�zast�rs: <font color=white>$hazastars</font></td>
			<td align=center>Szint: <font color=white>$player_adatai[Szint]</font></td>
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
	else if(isset($_GET['playerkereses']))
	{
		msg("3", "Player ig nev�nek vagy elej�ne be�r�s�val kilist�zza a tal�latokat");
		echo '<form action="index.php?menu=admin&playerkereses" method="POST">
				<div style="font-size: 15px; font-weight: bold;color: #ffffff;">J�t�kos IG neve:<input type="text" name="igneve"><br>
				<input type="submit" name="keres" value="Keres�s">
			</div></form>';
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$igneve = $_POST['igneve'];
			echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="600">
					<tr align="center">
						<td style="font-size: 14px; color: #ffffff; font-weight: bold;">SQL ID</td>
						<td style="font-size: 14px; color: #ffffff; font-weight: bold;">IG N�v</td>
						<td style="font-size: 14px; color: #ffffff; font-weight: bold;">Szint</td>
						<td style="font-size: 14px; color: #ffffff; font-weight: bold;">Tov�bb ...</td>
						<td style="font-size: 14px; color: #ffffff; font-weight: bold;">Kiragad�s</td>
					</tr>';
			$kereses_query = mysql_query("SELECT * FROM playerek WHERE Nev LIKE '%".$igneve."%'");
			while($kereses_fetch = mysql_fetch_array($kereses_query, MYSQL_ASSOC))
			{
				echo '<tr class="frakciok_eger_ravisz_sav" align="center">
						<td style="font-size: 14px; color: #ffffff;">'.$kereses_fetch['ID'].'</td>
						<td style="font-size: 14px; color: #ffffff;">'.$kereses_fetch['Nev'].'</td>
						<td style="font-size: 14px; color: #ffffff;">'.$kereses_fetch['Szint'].'</td>
						<td style="font-size: 14px; color: #ffffff;"><a href="index.php?menu=admin&player='.$kereses_fetch['ID'].'">Tov�bb ...</a></td>
						<td style="font-size: 14px; color: #ffffff;"><a href="index.php?menu=admin&kiragad='.$kereses_fetch['ID'].'">Kiragad�s</a></td>
					</tr>';
			}
			echo '</table>';
		}
	}
	else if(isset($_GET['bizniszek']))
	{
		$bizniszek_q = mysql_query("SELECT * FROM bizek ORDER BY `Kassza` DESC");
		
		echo'<table border="1" style="width: 600px;" class="table_border" cellspacing="0" cellpadding="0">
				<tr align=center style=" height: 25px;">
					<td>Biznisz neve</td>
					<td>Tulajdonos</td>
					<td>Kassza</td>
				</tr>';
			while($bizniszek = mysql_fetch_array($bizniszek_q))
			{
				echo'<tr  align=center style=" height: 25px; color:white;" class="frakciok_eger_ravisz_sav">
						<td>'.$bizniszek['Nev'].'</td>
						<td>'.$bizniszek['Tulaj'].'</td>
						<td>'.$bizniszek['Kassza'].' FT</td>';
						if($sor['Admin'] > '4443')
						{
							echo'<td><a href="index.php?menu=admin&nullazass='.$bizniszek['ID'].'" style="font-size: 13px; padding-left: 5px;">Null�z�s</a></td>';
						}
					echo'</tr>';
			}
		echo'</table>';
	}
	else if(isset($_GET['hazak']))
	{
		$hazak_q = mysql_query("SELECT * FROM hazak ORDER BY `Penz` DESC");
		
		echo'<table border="1" style="width: 600px;" class="table_border" cellspacing="0" cellpadding="0">
				<tr align=center style=" height: 25px;">
					<td>H�zsz�m</td>
					<td>Tulajdonos</td>
					<td>Benne l�v� �sszeg</td>
				</tr>';
			while($hazak = mysql_fetch_array($hazak_q))
			{
				echo'<tr  align=center style=" height: 25px; color:white;" class="frakciok_eger_ravisz_sav">
					<td>'.$hazak['ID'].'</td>
					<td>'.$hazak['Tulaj'].'</td>
					<td>'.$hazak['Penz'].'</td>
					';
					if($sor['Admin'] > '4443') 
					{
						echo'<td><a href="index.php?menu=admin&nullazas='.$hazak['ID'].'" style="font-size: 13px; padding-left: 5px;">Null�z�s</a></td>';
					}
				echo'</tr>';
			}
		echo'</table>';
	}
	else if(isset($_GET['nullazas']))
	{
		if($sor['Admin'] > '4443')
		{
			if($_GET['nullazas'] != '')
			{
				$nullazando_q = mysql_query("SELECT * FROM hazak WHERE ID='".mysql_escape_string($_GET['nullazas'])."'");
				$nullazando = mysql_fetch_array($nullazando_q);
				if(!$nullazando)
				{
					msg("2", "Nem l�tezik ilyen h�z!");
				} else {
					if($nullazando)
					{
						$mysql_nullazas = mysql_query("UPDATE hazak SET Penz='0', Cigi='0', Kaja='0', Kokain='0', Heroin='0', Marihuana='0', Material='0' WHERE ID='".mysql_escape_string($_GET['nullazas'])."'");
						msg("1", "Sikeresen null�ztad a ".$nullazando['ID']." sz�m� h�zat! Tulaj: ".$nullazando['Tulaj']."");
						if(!$mysql_nullazas)
						{
							die('Hiba: '.mysql_error());
						}
					}
				}
			}
		} else {
			msg("2", "Nincs jogosults�god ennek a m�veletnek az elv�gz�s�re!");
		}
	}
	else if(isset($_GET['kiragad']))
	{
		if($sor['Admin'] > '1')
		{
			if($_GET['kiragad'] != '')
			{
				$kiragadando_q = mysql_query("SELECT * FROM playerek WHERE ID='".mysql_escape_string($_GET['kiragad'])."'");
				$kiragadando = mysql_fetch_array($kiragadando_q);
				if(!$kiragadando)
				{
					msg("2", "Nem l�tezik ilyen j�t�kos!");
				} else {
					if($kiragadando)
					{
						$mysql_kiragad = mysql_query("UPDATE playerek SET Pos_x='1480.8008', Pos_y='-1742.2968', Pos_z='13.5469' WHERE ID='".mysql_escape_string($_GET['kiragad'])."'");
						msg("1", "Sikeresen kiragadtad ".$kiragadando['Nev']." nev� j�t�kost! A v�rosh�z�n fog spawnolni!");
						if(!$mysql_kiragad)
						{
							die('Hiba: '.mysql_error());
						}
					}
				}
			}
		} else {
			msg("2", "Nincs jogosults�god a m�velet elv�gz�s�hez!");
		}
	}
	else if(isset($_GET['nullazass']))
	{
		if($sor['Admin'] > '4443')
		{
			if($_GET['nullazass'] != '')
			{
				$nullazandoo_q = mysql_query("SELECT * FROM bizek WHERE ID='".mysql_escape_string($_GET['nullazass'])."'");
				$nullazandoo = mysql_fetch_array($nullazandoo_q);
				if(!$nullazandoo)
				{
					msg("2", "Nem l�tezik ez a biznisz!");
				} else {
					if($nullazandoo)
					{
						$mysql_nullazass = mysql_query("UPDATE bizek SET Kassza='0' WHERE ID='".mysql_escape_string($_GET['nullazass'])."'");
						msg("1", "Sikeresen null�ztad a ".$nullazandoo['ID']." sz�m� bizniszt! Tulaj: ".$nullazandoo['Tulaj']."");
						if(!$mysql_nullazass)
						{
							die('Hiba: '.mysql_error());
						}
					}
				}
			}
		} else {
			msg("2", "Nincs jogosults�god ennek a m�veletnek az elv�gz�s�hez!");
		}
	}
	else if(isset($_GET['ujjelszo']))
	{
		if($sor['Admin'] > '1337')
		{
			if($_GET['ujjelszo'] != '')
			{
				$jelszovalt_q = mysql_query("SELECT * FROM ucpuserek WHERE ID='".mysql_escape_string($_GET['ujjelszo'])."'");
				$jelszovalt = mysql_fetch_array($jelszovalt_q);
				if(!$jelszovalt)
				{
					msg("2", "Nem l�tezik a felhaszn�l� aminek jelsz�t szeretn�l v�ltani!");
				} else {
					if($jelszovalt)
					{
						$mysql_jelszovalt = mysql_query("UPDATE ucpuserek SET Jelszo='fd9d94340dbd72c11b37ebb0d2a19b4d05e00fd78e4e2ce8923b9ea3a54e900df181cfb112a8a73228d1f3551680e2ad9701a4fcfb248fa7fa77b95180628bb2' WHERE ID='".mysql_escape_String($_GET['ujjelszo'])."'");
						msg("1", "Sikeresen �t�rtad ".$jelszovalt['Felhasznalonev']." jelszav�t erre: 123456");
						if(!$mysql_jelszovalt)
						{
							die('Hiba: '.mysql_error());
						}
					}
				}
			}
		} else {
			msg("2", "Nincs jogosults�god ennek a m�veletnek az elv�gz�s�hez!");
		}
	}
	/*else if(isset($_GET['playerek']))
	{
		$playerek_q = mysql_query("SELECT * FROM playerek ORDER BY `Bank`");
		
		echo'<table border="1" style="width: 600px;" class="table_border" cellspacing="0" cellpadding="0">
				<tr align=center style=" height: 25px;">
					<td>N�v</td>
					<td>Szint</td>
					<td>J�tszott �ra</td>
					<td>Vagyon(bsz)</td>
				</tr>';
			while($playerek = mysql_fetch_array($playerek_q))
			{
				echo'<tr  align=center style=" height: 25px; color:white;" class="frakciok_eger_ravisz_sav">
					<td>'.$playerek['Nev'].'</td>
					<td>'.$playerek['Szint'].'</td>
					<td>'.$playerek['ConnectedTime'].'</td>
					<td>'.$playerek['Bank'].'</td>
				</tr>';
			}
		echo'</table>';
	}*/
	else if(isset($_GET['adminjailek']))
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&adminjailek&mind\';">�sszes</div>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb_leader" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&adminjailek&sajat\';">Saj�t</div></td>
					<td style="padding-left: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&admin&adminjailek&masok\';" title="Te bannodat m�s oldotta fel">M�sok vett�k ki</div></td>
				</tr>
				<tr>
					<td></td>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb_leader" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&adminjailek&berak\';">AdminJail-be rak�s</div></td>
					<td></td>
				</tr>
			</table>';
		echo '<div style="padding-top:20px;"></div>';
		if(isset($_GET['berak']))
		{
			if($sor['Admin'] > '1')
			{
				if($_SERVER["REQUEST_METHOD"] == "POST")
				{
					
					$ignev		=	$_POST['ignev'];
					$indok		=	$_POST['indok'];
					$ido2		=	$_POST['ido'];
					$tipus		=	$_POST['tipus'];
					$adta		=	$sor['Nev'];
					$vaneilyen_q = mysql_query("SELECT * FROM playerek WHERE Nev='".mysql_escape_string($ignev)."'");
					$vaneilyen = mysql_fetch_array($vaneilyen_q);
					if(!$vaneilyen)
					{
						msg("2", "Nincs ilyen nev� j�t�kos");
					} else {
						if($vaneilyen['Online'] == "1")
						{
							msg("2","Ez a j�t�kos jelenleg online.");
						} else {
							$ido = $ido2 * 60;
							$jailberak = mysql_query("UPDATE playerek SET Jailed='".mysql_escape_string($tipus)."', JailTime='".mysql_escape_string($ido)."', JailtAdta='".$adta."', JailOK='".mysql_escape_string($indok)."' WHERE Nev='".mysql_escape_string($ignev)."'");
							if(!$jailberak)
							{
								die('Bannol�si hiba: '.mysql_error());
							}
							ucp_log("ajbe","".$sor['Nev']."", "betette ".$ignev."-t");
							msg("1", "Sikeresen bebasztad jail-be ".$ignev." -t!");
						}
					}
				} else {
					echo '<form action="index.php?menu=admin&adminjailek&berak" method="POST">
							<div style="font-weight: bold; font-size: 13px; color: #ffffff;">IG n�v:<br> 
							<input type="text" name="ignev"><br>
							T�pus:<br>
							<select name="tipus">
								<option value="5">Sima</option>
								<option value="6">Irogat�s</option>
							</select><br>
							Indok:<br>
							<textarea name="indok" width="500" height="500"></textarea><br>
							Id� percbe:<br>
							<input type="text" name="ido"><br>
							<input type="submit" name="aj" value="Adminjailbe rak�s"></div>
						</form>';
				}
			} else { msg("2","Nincs hozz� jogosults�god!"); }
		}
		else if(isset($_GET['kivesz']))
		{
			if($_GET['kivesz'] == "")
			{
				msg("2", "Nincs megadva ID");
			} else {
				$kiveszid = $_GET['kivesz'];
				$ellenorzes_q = mysql_query("SELECT * FROM playerek WHERE ID='".mysql_escape_string($kiveszid)."'");
				$ellenorzes = mysql_fetch_array($ellenorzes_q);
				if(!$ellenorzes)
				{
					msg("2", "Nincs ilyen player");
				} else {
					if($ellenorzes['JailtAdta'] == $sor['Nev'])
					{
						if($ellenorzes['Jailed'] == "5" OR $ellenorzes['Jailed'] == "6")
						{
							if($ellenorzes['Online'] == "1")
							{
								msg("2","Ez a player Online");
							} else {
								$kivesz_q = mysql_query("UPDATE playerek SET Jailed='0' WHERE ID='".mysql_escape_string($kiveszid)."'");
								ucp_log("ajki","".$sor['Nev']."", "kivette ".$ellenorzes['Nev']."-t");
								msg("1","Ki lett v�ve ".$ellenorzes['Nev']." az AJ-b�l");
							}
						} else {
							msg("2", "� nincs AJ-be");
						}
					} else {
						if($_SERVER["REQUEST_METHOD"] == "POST")
						{
								if($ellenorzes['Jailed'] == "5" OR $ellenorzes['Jailed'] == "6")
								{
									if($ellenorzes['Online'] == "1")
									{
										msg("2","Ez a player Online");
									} else {
										$kivesz_q = mysql_query("UPDATE playerek SET Jailed='0' WHERE ID='".mysql_escape_string($kiveszid)."'");
										ucp_log("ajki","".$sor['Nev']."", "kivette ".$ellenorzes['Nev']."-t");
										msg("1","Ki lett v�ve ".$ellenorzes["Nev"]." az AJ-b�l");
										$username = $sor['Nev'];
										$kitid = $ellenorzes['Nev'];
										$kieid = $ellenorzes['JailtAdta'];
										$unjail_indok = mysql_query("INSERT INTO unjail_indok (ki, kit, kie) VALUES ('$username','$kitid','$kieid')");
									}
								} else {
									msg("2", "� nincs AJ-be");
								}
						} else {
							echo '<form action="index.php?menu=admin&adminjailek&kivesz='.$kiveszid.'" method="POST">
										<div style="font-size: 14px; color:#ffffff; font-weight: bold;">Indokold meg mi�rt akarod kivenni AJ-b�l azt, akit '.$ellenorzes['JailtAdta'].' rakott be?</div>
										<div style="font-size: 12px; color:#ffffff;">Unbannoland�: '.$ellenorzes['Nev'].'</div>
										<textarea name="indok" style="width: 450px; height: 300px; color: #ffffff; background: #000000;"></textarea><br>
										<input type="submit" name="indokkuld" value="Ok�, kiszedem">
									</form>';
							echo '<div style="padding-top: 30px;"></div>';
						}
					}
				}
			}
		}
		if(isset($_GET['mind']))
		{
			echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="700">
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
						<td style="font-size: 14px; font-weight: bold;color: #ffffff;">N�v</td>
						<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Id� (vissza)</td>
						<td style="font-size: 14px; font-weight: bold;color: #ffffff;">T�pus</td>
						<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Adta</td>
						<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Indok</td>
					</tr>';
			$ajailok_q = mysql_query("SELECT * FROM playerek WHERE Jailed='5' OR Jailed='6' ORDER BY JailTime ASC");
			while($ajailok = mysql_fetch_array($ajailok_q))
			{
				if($ajailok['JailTime'] > '0')
				{
					if($ajailok['Jailed'] == "5")
					{
						$tipus = 'Sima';
					} else if($ajailok['Jailed'] == "6") {
						$tipus = 'Irogat�s';
					}
					$idoperc = $ajailok['JailTime'] / 60;
					$idokerekitve = round($idoperc,0).' perc';
				} else {
					$idokerekitve = '<font color=red>Lej�rt</font>';
				}
				echo '<tr  style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
						<td style="font-size: 13px; color: #ffffff; padding-left: 3px; padding-right: 3px;">'.$ajailok['Nev'].'</td>
						<td style="font-size: 13px; color: #ffffff; padding-left: 3px; padding-right: 3px;" title="M�sodperc: '.$ajailok['JailTime'].'">'.$idokerekitve.'</td>
						<td style="font-size: 13px; color: #ffffff; padding-left: 3px; padding-right: 3px;">'.$tipus.'</td>
						<td style="font-size: 13px; color: #ffffff; padding-left: 3px; padding-right: 3px;">'.$ajailok['JailtAdta'].'</td>
						<td style="font-size: 13px; color: #ffffff; padding-left: 3px; padding-right: 3px;">'.$ajailok['JailOK'].'</td>';
				if($ajailok['JailtAdta'] == $sor['Nev'])
				{
					echo '<td style="font-size: 13px; color: #ffffff;"><a href="index.php?menu=admin&adminjailek&kivesz='.$ajailok['ID'].'">Kivesz</a></td>';
				} else if($sor['Admin'] > '2')
				{
					echo '<td style="font-size: 13px; color: #ffffff;"><a href="index.php?menu=admin&adminjailek&kivesz='.$ajailok['ID'].'">Kivesz</a></td>';
				}
					echo '</tr>';
			}
			echo '</table>';
		} else if(isset($_GET['sajat']))
		{
			echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="700">
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
						<td style="font-size: 14px; font-weight: bold;color: #ffffff;">N�v</td>
						<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Id� (vissza)</td>
						<td style="font-size: 14px; font-weight: bold;color: #ffffff;">T�pus</td>
						<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Adta</td>
						<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Indok</td>
					</tr>';
			$ajailok_q = mysql_query("SELECT * FROM playerek WHERE (Jailed='5' OR Jailed='6') AND JailtAdta='{$sor['Nev']}'");
			while($ajailok = mysql_fetch_array($ajailok_q))
			{
				
				if($ajailok['Jailed'] == "5")
				{
					$tipus = 'Sima';
				} else if($ajailok['Jailed'] == "6") {
					$tipus = 'Irogat�s';
				}
				$idoperc = $ajailok['JailTime'] / 60;
				$idokerekitve = round($idoperc,0).' perc';
				echo '<tr  style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
						<td style="font-size: 13px; color: #ffffff; padding-left: 3px; padding-right: 3px;">'.$ajailok['Nev'].'</td>
						<td style="font-size: 13px; color: #ffffff; padding-left: 3px; padding-right: 3px;" title="M�sodperc: '.$ajailok['JailTime'].'">'.$idokerekitve.'</td>
						<td style="font-size: 13px; color: #ffffff; padding-left: 3px; padding-right: 3px;">'.$tipus.'</td>
						<td style="font-size: 13px; color: #ffffff; padding-left: 3px; padding-right: 3px;">'.$ajailok['JailtAdta'].'</td>
						<td style="font-size: 13px; color: #ffffff; padding-left: 3px; padding-right: 3px;">'.$ajailok['JailOK'].'</td>';
				if($ajailok['JailtAdta'] == $sor['Nev'])
				{
					echo '<td style="font-size: 13px; color: #ffffff;"><a href="index.php?menu=admin&adminjailek&kivesz='.$ajailok['ID'].'">Kivesz</a></td>';
				} else if($sor['Admin'] > '2')
				{
					echo '<td style="font-size: 13px; color: #ffffff;"><a href="index.php?menu=admin&adminjailek&kivesz='.$ajailok['ID'].'">Kivesz</a></td>';
				}
					echo '</tr>';
			}
			echo '</table>';
		} else if(isset($_GET['masok']))
		{
			echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="700">
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
						<td style="font-size: 15px; color: #ffffff; font-weight: bold;">N�v</td>
						<td style="font-size: 15px; color: #ffffff; font-weight: bold;">Unjailezte</td>
						<td style="font-size: 15px; color: #ffffff; font-weight: bold;">Indok</td>
						<td style="font-size: 15px; color: #ffffff; font-weight: bold;">D�tum</td>
					</tr>';
			$unjail_mas_q = mysql_query("SELECT * FROM unjail_indok WHERE kie='{$sor['Nev']}' ORDER BY Datum ASC");
			while($unjail_mas = mysql_fetch_array($unjail_mas_q))
			{
				$datum = date("Y.m.d. H:i", $unjail_mas['datum']);
				echo '<tr  style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
						<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;">'.$unjail_mas['kit'].'</td>
						<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;">'.$unjail_mas['ki'].'</td>
						<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;">'.$unjail_mas['indok'].'</td>
						<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;">'.$datum.'</td>
					</tr>';
			}
			echo '</table>';
		} else {
			//header("Location: index.php?menu=admin&adminjailek&mind");
		}
	}
	else  if(isset($_GET['proba']))  //***
	{
		echo '<script>
			$(document).ready(function(){
  				$("#div1").load("oldal/proba.php?page=1");
				$("#filter input").keydown(function(){
   					$("#filter").css("background-color","yellow");
					clearTimeout(timer);
 				});
  				$("#filter input").keyup(function(){
    					$("#filter").css("background-color","pink");
					timer=setTimeout(function(){
						//alert($("#filter input").val());
						$("#div1").load("oldal/proba.php?page=1&filter="+$("#filter input").val());
        				},1000);
				});
				$("#lapozo li").live("click",function(){
					$("#div1").load("oldal/proba.php?page="+this.id+"&filter="+$("#filter input").val());
				});
			});
			</script>';
		echo '<div id="div1">load</div><div id="filter">Filter: <input type="text"></div>';
	}
	else  if(isset($_GET['adminok']))
	{
		echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="500">
				<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">N�v</td>
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Admin szint</td>
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">V�laszai</td>
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Utols� akt�v</td>
				</tr>';
		$adminok_q = mysql_query("SELECT * FROM playerek WHERE Admin>'0' ORDER BY Admin DESC");
		while($adminok = mysql_fetch_array($adminok_q))
		{	
			/*$utoljaraaktiv = $adminok['UtoljaraAktiv'];
			$maidatum = strtotime(date("Y-m-d H:i:s"));
			$mennyiis = $maidatum - $utoljaraaktiv;
			$mennyi = $mennyiis / 60 / 60;
			$mennyiegesz = round($mennyi,0);
			$utoljaraaktivtitle = date("Y.m.d. H:i", $utoljaraaktiv);
			if($mennyiegesz < '1')
			{
				$asder = '<div style="color: #00a7ff">Kevesebb, mint 1 �ra';
			} 
			else if ($mennyiegesz > '1' AND $mennyiegesz < '24')
			{
				$asder = '<div style="color: #00a7ff">'.$mennyiegesz.' �r�ja';
			} 
			else if ($mennyiegesz > '24')
			{
				$asder2 = $mennyiegesz / 24;
				$asder3 = round($asder2, 0);
				if($asder3 < '1' OR $asder3 == '1')
				{
					$asder = '<div style="color: #00a7ff">'.$asder3.' napja</div>';
				} else if($asder3 > '1' AND $asder3 < '6')
				{
					$asder = '<div style="color: #fffc00">'.$asder3.' napja</div>';
				} else if($asder3 > '4' AND $asder3 < '8')
				{
					$asder = '<div style="color: #ffba00">'.$asder3.' napja</div>';
				} else if($asder3 > '7')
				{
					$asder = '<div style="color: #ff0000">'.$asder3.' napja</div>';
				}
			}*/
			$utoljaraaktivtitle = date("Y.m.d. H:i", $adminok['UtoljaraAktiv']);
			if($adminok['Online'] == "1") { $asder = 'Jelenleg akt�v'; } else {
				$asder = $utoljaraaktivtitle;
			}
			/*if($adminok['TvIdo'] < 60)
			{
				$tvido = $adminok['TvIdo'].' mp';
			} else {
				$tvidoperc = $adminok['TvIdo'] / 60;
				$round = round($tvidoperc, 0);
				$tvido = $round.' perc';
			}*/
			echo '<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
					<td style="font-size: 13px; color: #ffffff;">'.$adminok['Nev'].'</td>
					<td style="font-size: 13px; color: #ffffff;">'.$adminok['Admin'].'</td>
					<td style="font-size: 13px; color: #ffffff;">'.$adminok['Valasz'].'</td>
					<td style="font-size: 13px; color: #ffffff;" title="'.$utoljaraaktivtitle.'">'.$asder.'</td>
				</tr>';
		}
		
		echo '</table>';
		echo '<div style="padding-top: 35px;"></div>';
		if($sor['Admin'] > '4443')
		{
		if(isset($_GET['adas']))
		{
			$adminid = $_POST['ignev'];
			$ujadminrang = $_POST['ujadminrang'];
			
			$ellenorzes_q = mysql_query("SELECT * FROM playerek WHERE Nev='".mysql_escape_string($adminid)."'");
			if(!$ellenorzes_q)
			{
				die('Hiba: '.mysql_error());
			}
			$ellenorzes = mysql_Fetch_array($ellenorzes_q);
			if($ellenorzes['Admin'] > 0)
			{
				msg("2","� m�r admin");
			} else {
				$mysql_adminadas = mysql_query("UPDATE playerek SET Admin='".mysql_escape_string($ujadminrang)."' WHERE Nev='".mysql_escape_string($adminid)."'");
				if(!$mysql_adminadas)
				{
					die('Hiba: '.mysql_error());
				}
				msg("1","Felvetted ".$adminid."-t adminnak! Rangja: ".$ujadminrang."");
				ucp_log("adminad","".$sor['Nev']."", "admint adott ".$adminid."-nek. Szint: ".$ujadminrang."");
			}
		} else if(isset($_GET['rang']))
		{
			$adminid = $_POST['ignev'];
			$ujadminrang = $_POST['ujadminrang'];
			
			$ellenorzes_q = mysql_query("SELECT * FROM playerek WHERE Nev='".mysql_escape_string($adminid)."'");
			if(!$ellenorzes_q)
			{
				die('Hiba: '.mysql_error());
			}
			$ellenorzes = mysql_Fetch_array($ellenorzes_q);
			if($ellenorzes['Admin'] < 1)
			{
				msg("2","� nem admin");
			} else {
				$mysql_adminadas = mysql_query("UPDATE playerek SET Admin='".mysql_escape_string($ujadminrang)."' WHERE Nev='".mysql_escape_string($adminid)."'");
				if(!$mysql_adminadas)
				{
					die('Hiba: '.mysql_error());
				}
				msg("1","".$adminid." �j rangja: ".$ujadminrang."");
				ucp_log("adminrang","".$sor['Nev']."", "adott ".$adminid."-nek ".$ujadminrang." admint");
			}
		} else if(isset($_GET['elvesz']))
		{
			$adminid = $_POST['ignev'];
			
			$ellenorzes_q = mysql_query("SELECT * FROM playerek WHERE Nev='".mysql_escape_string($adminid)."'");
			if(!$ellenorzes_q)
			{
				die('Hiba: '.mysql_error());
			}
			$ellenorzes = mysql_Fetch_array($ellenorzes_q);
			if($ellenorzes['Admin'] < 1)
			{
				msg("2","� nem admin");
			} else {
				$mysql_adminadas = mysql_query("UPDATE playerek SET Admin='0' WHERE Nev='".mysql_escape_string($adminid)."'");
				if(!$mysql_adminadas)
				{
					die('Hiba: '.mysql_error());
				}
				msg("1","".$adminid." m�r nem admin ... szeg�ny :(");
				ucp_log("adminelvesz","".$sor['Nev']."", "elvette ".$adminid." adminj�t!");
			}
		}
	
		echo '<div style="color: #ffffff;" align="center">';
		echo '<div style="font-weight: bold; font-size: 14px;">Admin felv�tele</div>';
		echo	'<form action="index.php?menu=admin&adminok&adas" method="POST">
					IG n�v:<input type="text" name="ignev"> <select name="ujadminrang">
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>1337</option>
					<option>1338</option>
					<option>1339</option>
					<option>4444</option>
					<option>5555</option>
					</select><input type="submit" name="felvesz" value="Admin felv�tele">
				</form>';
		echo '</div>';
		
		echo '<div style="padding-top: 15px; padding-bottom: 15px;"><hr></div>';
		
		echo '<div style="color: #ffffff;" align="center">';
		echo '<div style="font-weight: bold; font-size: 14px;">Admin rang v�lt�s</div>';
		echo	'<form action="index.php?menu=admin&adminok&rang" method="POST">
					IG n�v:<select name="ignev">';
			$admin_lista_q = mysql_query("SELECT * FROM playerek WHERE Admin > 0 ORDER BY Nev ASC");
			while($admin_lista = mysql_fetch_array($admin_lista_q))
			{
				echo '<option>'.$admin_lista['Nev'].'</option>';
			}
				echo '</select><select name="ujadminrang">
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>1337</option>
					<option>1338</option>
					<option>1339</option>
					<option>4444</option>
					<option>5555</option>
					</select><input type="submit" name="felvesz" value="Admin rang v�lt�s">
				</form>';
		echo '</div>';
		
		echo '<div style="padding-top: 15px; padding-bottom: 15px;"><hr></div>';
		
		echo '<div style="color: #ffffff;" align="center">';
		echo '<div style="font-weight: bold; font-size: 14px;">Admin elv�tel</div>';
		echo	'<form action="index.php?menu=admin&adminok&elvesz" method="POST">
					IG n�v:<select name="ignev">';
			$admin_lista_q = mysql_query("SELECT * FROM playerek WHERE Admin > 0 ORDER BY Nev ASC");
			while($admin_lista = mysql_fetch_array($admin_lista_q))
			{
				echo '<option>'.$admin_lista['Nev'].'</option>';
			}
				echo '</select> <input type="submit" name="felvesz" value="Admin elv�tele">
				</form>';
		echo '</div>';
	}
	} else if(isset($_GET['adminsegedek']))
	{
		
		echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="400">
				<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">N�v</td>
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">V�laszai</td>
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Utols� akt�v</td>
				</tr>';
		$adminok_q = mysql_query("SELECT * FROM playerek WHERE ASJog='1' ORDER BY Valasz DESC");
		while($adminok = mysql_fetch_array($adminok_q))
		{	
			$utoljaraaktiv = $adminok['UtoljaraAktiv'];
			$maidatum = strtotime(date("Y-m-d H:i:s"));
			$mennyiis = $maidatum - $utoljaraaktiv;
			$mennyi = $mennyiis / 60 / 60;
			$mennyiegesz = round($mennyi,0);
			if($mennyiegesz < '1')
			{
				$asder = '<div style="color: #00a7ff">Kevesebb, mint 1 �ra</div>';
			} 
			else if ($mennyiegesz > '1' AND $mennyiegesz < '24')
			{
				$asder = '<div style="color: #00a7ff">'.$mennyiegesz.' �r�ja</div>';
			} 
			else if ($mennyiegesz > '24')
			{
				$asder2 = $mennyiegesz / 24;
				$asder3 = round($asder2, 0);
				if($asder3 < '1' OR $asder3 == '1')
				{
					$asder = '<div style="color: #00a7ff">'.$asder3.' napja</div>';
				} else if($asder3 > '1' AND $asder3 < '6')
				{
					$asder = '<div style="color: #fffc00">'.$asder3.' napja</div>';
				} else if($asder3 > '4' AND $asder3 < '8')
				{
					$asder = '<div style="color: #ffba00">'.$asder3.' napja</div>';
				} else if($asder3 > '7')
				{
					$asder = '<div style="color: #ff0000">'.$asder3.' napja</div>';
				}
			}
			echo '<tr  style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
					<td style="font-size: 13px; color: #ffffff;">'.$adminok['Nev'].'</td>
					<td style="font-size: 13px; color: #ffffff;">'.$adminok['Valasz'].'</td>
					<td style="font-size: 13px; color: #ffffff;">'.$asder.'</td>
				</tr>';
		}
		
		echo '</table>';
		if($sor['Admin'] > '1337')
		{
		if(isset($_GET['adas']))
		{
			$adminid = $_POST['ignev'];
			
			$ellenorzes_q = mysql_query("SELECT * FROM playerek WHERE Nev='".mysql_escape_string($adminid)."'");
			if(!$ellenorzes_q)
			{
				die('Hiba: '.mysql_error());
			}
			$ellenorzes = mysql_Fetch_array($ellenorzes_q);
			if($ellenorzes['ASJog'] == '1')
			{
				msg("2","� m�r adminseg�d ....");
			} else {
				$mysql_adminadas = mysql_query("UPDATE playerek SET ASJog='1' WHERE Nev='".mysql_escape_string($adminid)."'");
				if(!$mysql_adminadas)
				{
					die('Hiba: '.mysql_error());
				}
				msg("2","Felvetted ".$adminid."-t adminseg�dnek!");
				msg("3","A list�n csak az oldal friss�t�se ut�n jelenik meg!");
				ucp_log("asad","".$sor['Nev']."", "adott ".$adminid."-nek AS-t!");
			}
		} else if(isset($_GET['elvesz']))
		{
			$adminid = $_POST['ignev'];
			
			$ellenorzes_q = mysql_query("SELECT * FROM playerek WHERE Nev='".mysql_escape_string($adminid)."'");
			if(!$ellenorzes_q)
			{
				die('Hiba: '.mysql_error());
			}
			$ellenorzes = mysql_Fetch_array($ellenorzes_q);
			if($ellenorzes['ASJog'] = '0')
			{
				msg("2","� nem adminseg�d!");
			} else {
				$mysql_adminadas = mysql_query("UPDATE playerek SET ASJog='0' WHERE Nev='".mysql_escape_string($adminid)."'");
				if(!$mysql_adminadas)
				{
					die('Hiba: '.mysql_error());
				}
				msg("1","".$adminid." m�r nem adminseg�d ... szeg�ny :( ");
				msg("3","Csak az oldal �jrat�lt�s�vel t�nik el a list�r�l!");
				ucp_log("aselvesz","".$sor['Nev']."", "elvette ".$adminid." AS-�t!");
			}
		}
		echo '<div style="color: #ffffff;" align="center">';
		echo '<div style="font-weight: bold; font-size: 14px;">Adminseg�d felv�tele</div>';
		echo	'<form action="index.php?menu=admin&adminsegedek&adas" method="POST">
					IG n�v:<input type="text" name="ignev"> <input type="submit" name="felvesz" value="Adminseg�d felv�tele">
				</form>';
		echo '</div>';
		
		echo '<div style="padding-top: 15px; padding-bottom: 15px;"><hr></div>';
		
		echo '<div style="color: #ffffff;" align="center">';
		echo '<div style="font-weight: bold; font-size: 14px;">Admin elv�tel</div>';
		echo	'<form action="index.php?menu=admin&adminsegedek&elvesz" method="POST">
					IG n�v:<select name="ignev">';
			$adminseged_lista_q = mysql_query("SELECT * FROM playerek WHERE ASJog='1' ORDER BY Nev ASC");
			while($adminseged_lista = mysql_fetch_array($adminseged_lista_q))
			{
				echo '<option>'.$adminseged_lista['Nev'].'</option>';
			}
				echo '</select> <input type="submit" name="felvesz" value="Adminseg�d elv�tele">
				</form>';
		echo '</div>';
	}
	} else if(isset($_GET['snm'])) {
		if($sor['SMRang'] > '3' AND $sor['Admin'] > '1337')
		{
		if(isset($_GET['kirug']))
		{
			$kirug = $_GET['kirug'];
			$ellenoriz_q = mysql_query("SELECT * FROM playerek WHERE SM='1' AND ID='".mysql_escape_string($kirug)."'");
			$ellenoriz = mysql_fetch_array($ellenoriz_q);
			if(!$ellenoriz)
			{
				msg("2","� nem S&M tag!");
			} else {
				$mysql_kirug = mysql_query("UPDATE playerek SET SM='0', SMRang='0' WHERE ID='".mysql_escape_string($kirug)."'");
				msg("1","Kir�gtad ".$ellenoriz['Nev']." -t az S&M-b�l!");
				ucp_log("smkirug","".$sor['Nev']."", "kitette ".$ellenoriz['Nev']." -t S&M-b�l!");
			}
		}
		if(isset($_GET['ujtag']))
		{
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{
				$ujtag = $_POST['ujtag'];
				
				$ellenorzes_q = mysql_query("SELECT * FROM playerek WHERE SM='1' AND Nev='".mysql_escape_string($ujtag)."'");
				$ellenorzes = mysql_fetch_array($ellenorzes_q);
				if(!$ellenorzes)
				{
					$felvesz = mysql_query("UPDATE playerek SET SM='1' WHERE Nev='".mysql_escape_string($ujtag)."'");
					msg("1","Felvetted ".$ujtag."-t az S&M-be!");
					ucp_log("smfelvesz","".$sor['Nev']."", "felvette ".$ujtag."-t az S&M-be!");
				} else {
					msg("2","".$ujtag." m�r S&M tag!");
				}
			}
		}
		
		
		echo '<div align="center" style="font-size: 14px; color: #ffffff; font-weight: bold;"><form action="index.php?menu=admin&snm&ujtag" method="POST">�j tag IG neve:<input type="text" name="ujtag" ><input type="submit" name="felvesz" value="Felvesz"></form></div>';
		}
		echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="400">
				<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">N�v</td>
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Rang</td>
					<td style="font-size: 14px; font-weight: bold;color: #ffffff;">Utols� akt�v</td>';
				if($sor['SMRang'] > '3' AND $sor['Admin'] > '1337')
				{
					echo '<td></td>';
				}
				echo '</tr>';
		
		$smok_q = mysql_query("SELECT * FROM playerek WHERE SM='1' ORDER BY SMRang DESC");
		while($sm = mysql_fetch_array($smok_q))
		{	
			/*$utoljaraaktiv = $sm['UtoljaraAktiv'];
			$maidatum = strtotime(date("Y-m-d H:i:s"));
			$mennyiis = $maidatum - $utoljaraaktiv;
			$mennyi = $mennyiis / 60 / 60;
			$mennyiegesz = round($mennyi,0);
			if($mennyiegesz < '1')
			{
				$asder = '<div style="color: #00a7ff">Kevesebb, mint 1 �ra';
			} 
			else if ($mennyiegesz > '1' AND $mennyiegesz < '24')
			{
				$asder = '<div style="color: #00a7ff">'.$mennyiegesz.' �r�ja';
			} 
			else if ($mennyiegesz > '24')
			{
				$asder2 = $mennyiegesz / 24;
				$asder3 = round($asder2, 0);
				if($asder3 < '1' OR $asder3 == '1')
				{
					$asder = '<div style="color: #00a7ff">'.$asder3.' napja</div>';
				} else if($asder3 > '1' AND $asder3 < '6')
				{
					$asder = '<div style="color: #fffc00">'.$asder3.' napja</div>';
				} else if($asder3 > '4' AND $asder3 < '8')
				{
					$asder = '<div style="color: #ffba00">'.$asder3.' napja</div>';
				} else if($asder3 > '7')
				{
					$asder = '<div style="color: #ff0000">'.$asder3.' napja</div>';
				}
			}*/
			if($sm['Online'] == "1")
			{
				$asder = 'Jelenleg akt�v';
			} else {
				$asder = date("Y.m.d. H:i", $sm['UtoljaraAktiv']);
			}
			echo '<tr  style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
					<td style="font-size: 13px; color: #ffffff;">'.$sm['Nev'].'</td>
					<td style="font-size: 13px; color: #ffffff;">'.$sm['SMRang'].'</td>
					<td style="font-size: 13px; color: #ffffff;">'.$asder.'</td>';
					if($sor['SMRang'] > '3' AND $sor['Admin'] > '1337')
					{
						echo '<td style="font-size:13px; color: #ffffff;"><a href="index.php?menu=admin&snm&kirug='.$sm['ID'].'">Kir�g</a></td>';
					}
				echo '</tr>';
		}
		
		echo '</table>';
	} else if(isset($_GET['bannok']))
	{
		if(!isset($_GET['mind']) OR !isset($_GET['sajat']) OR !isset($_GET['masok']))
		{
			
		}
		if(isset($_GET['unban']))
		{
			if(isset($_POST['unbanki']))
			{
				if($sor['Admin'] > "4")
				{
					$indok = $_POST['indok'];
					$unban = $_POST['unbanki'];
					$kie = $_POST['bannolta'];
					$unban_q = mysql_query("DELETE FROM bans WHERE Cim='".mysql_escape_string($unban)."'"); 
					$unban_indok = mysql_query("INSERT INTO unban_indok (ki, kit, kie, indok) VALUES ('$sor[Nev]','$unban','$kie', '$indok')");
					if(!$unban_indok)
					{
						die('Hiba: '.mysql_error());
					}
					ucp_log("unban","".$sor['Nev']."", "unbannolta ".$unban."-t!");
					msg("1", "".$unban." unbannolva!");
				} else {
					msg("2","Nincs hozz�f�r�sed");
				}
			} else {
			$unban = $_GET['unban'];
			$ellenorzes_q = mysql_query("SELECT * FROM bans WHERE Cim='".mysql_escape_string($unban)."'");
			$ellenorzes = mysql_fetch_array($ellenorzes_q);
			if(!$ellenorzes)
			{
				msg("2","Nincs ilyen N�v/IP bannolva!");
			} else {
					if($ellenorzes['Bannolta'] == $sor['Nev'])
					{ 
						if($sor['Admin'] > "1")
						{
							$unban_q = mysql_query("DELETE FROM bans WHERE Cim='".mysql_escape_string($unban)."'"); 
						ucp_log("unban","".$sor['Nev']."", "unbannolta ".$unban."-t!");
							msg("1", "".$unban." unbannolva!");
						} else {
							msg("2","Nincs hozz�f�r�sed");
						}
					} else {
						if($sor['Admin'] > "4")
						{
							echo '<form action="index.php?menu=admin&bannok&unban" method="POST">
									<div style="font-size: 14px; color:#ffffff; font-weight: bold;">Indokold meg mi�rt akarod unbannolni azt, akit '.$ellenorzes['Bannolta'].' bannolt?</div>
									<div style="font-size: 12px; color:#ffffff;">Unbannoland�: '.$unban.'</div>
									<textarea name="indok" style="width: 450px; height: 300px; color: #ffffff; background: #000000;"></textarea><br>
									<input type="hidden" name="unbanki" value="'.$unban.'">
									<input type="hidden" name="bannolta" value="'.$ellenorzes['Bannolta'].'">
									<input type="submit" name="indokkuld" value="Ok�, unbannolom">
								</form>';
							echo '<div style="padding-top: 30px;"></div>';
						} else {
							msg("2", "Nincs hozz�f�r�sed");
						}
					}
			}
			}
		}
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&bannok&mind\';">�sszes</div>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb_leader" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&bannok&sajat\';">Saj�t</div></td>
					<td style="padding-left: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&admin&bannok&masok\';" title="Te bannodat m�s oldotta fel">M�sok unbannolt�k</div></td>
				</tr>
				<tr>
					<td></td>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb_leader" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=admin&bannok&bannolas\';">Bannol�s</div></td>
					<td></td>
				</tr>
			</table>';
		echo '<div style="padding-top: 30px;"></div>';
		if(isset($_GET['bannolas']))
		{
			if($sor['Admin'] > '1')
			{
				if($_SERVER["REQUEST_METHOD"] == "POST")
				{
					
					$ignevip	=	$_POST['ignevip'];
					$indok		=	$_POST['indok'];
					$ido2		=	$_POST['ido'];
					$ipneve		=	$_POST['ipneve'];
					$bannolta	=	$sor['Nev'];
					$oroke		=	$_POST['oroke'];
					$ellenorzes_q = mysql_query("SELECT * FROM bans WHERE Cim='".mysql_escape_string($ignevip)."'");
					$ellenorzes = mysql_fetch_array($ellenorzes_q);
					if(!$ellenorzes)
					{
						
						if($ipneve == "ip")
						{
							$bannolas = mysql_query("INSERT INTO bans (Tipus, Cim, Ido, Orok, Bannolta, Oka) VALUES ('ip','$ignevip','$ido','$orok','$bannolta','$indok')");
							msg("1", "Sikeresen bannoltad a ".$ignevip."  IP-t!");
						} else if($ipneve == "nev") {
							
							$vaneilyen_q = mysql_query("SELECT * FROM playerek WHERE Nev='".mysql_escape_string($ignevip)."'");
							$vaneilyen = mysql_fetch_array($vaneilyen_q);
							if(!$vaneilyen)
							{
								msg("2", "Nincs ilyen nev� j�t�kos");
							} else {
								$online_e = mysql_query("SELECT * FROM playerek WHERE Nev='".mysql_escape_string($ignevip)."'");
								$online = mysql_fetch_array($online_e);
								if($online['Online'] == "1")
								{
									msg("2","Ez a j�t�kos jelenleg online.");
								} else {
									$ido3 = time();
									$ido = $ido2 + $ido3;
									$bannolas = mysql_query("INSERT INTO bans (Tipus, Cim, Ido, Orok, Bannolta, Oka, Datum) VALUES ('$ipneve','$ignevip','$ido','$oroke','$bannolta','$indok','$ido3')");
									if(!$bannolas)
									{
										die('Bannol�si hiba: '.mysql_error());
									}
									ucp_log("ban","".$sor['Nev']."", "bannolta ".$ignevip."-t!");
									msg("1", "Sikeresen bannoltad ".$ignevip." -t!");
								}
							}
						}
						
						
					} else {
						msg("2","� m�r bannolva van!");
					}
				} else {
					echo '<form action="index.php?menu=admin&bannok&bannolas" method="POST">
							<div style="font-weight: bold; font-size: 13px; color: #ffffff;">IG n�v vagy IP c�m:<br> 
							<input type="text" name="ignevip"><br>
							IP vagy N�v?<br>
							<select name="ipneve"><option value="nev">N�v</option><option value="ip">IP</option></select><br>
							Indok:<br>
							<textarea name="indok" width="500" height="500"></textarea><br>
							�r�k-e:<br>
							<select name="oroke"><option value="n">Nem</option><option value="i">Igen</option></select><br>
							Id� ( ha �r�k t�k mindegy ... ) m�sodpercbe:<br>
							<input type="text" name="ido"><br>
							<input type="submit" name="ban" value="Bannol�s"></div>
						</form>';
				}
			} else { msg("2","Nincs hozz� jogosults�god!"); }
		} 
		else if(isset($_GET['sajat']))
		{
			echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="700">
				<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
					<td style="font-size: 15px; color: #ffffff; font-weight: bold;">N�v / IP</td>
					<td style="font-size: 15px; color: #ffffff; font-weight: bold;">Id�</td>';
				echo '<td style="font-size: 15px; color: #ffffff; font-weight: bold;">Bannolva</td>';
					if($sor['Admin'] > '4')
					{
						echo '<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;"></td>';
					}
			echo '</tr>';
		
		$bannok_q = mysql_query("SELECT * FROM bans WHERE Bannolta='{$sor['Nev']}' ORDER BY Datum DESC");
		while($bannok = mysql_Fetch_array($bannok_q))
		{
			
		
			if($bannok['Orok'] == "i")
			{
				$idolejartitle = 'Ez �r�k';
				$idolejar = '�r�k';
			} else {
				$idolejartitle = date("Y.m.d. H:i", $bannok['Ido']);
				$szabadul = $bannok['Ido'];
				$maidatum = strtotime(date("Y-m-d H:i"));
				$mennyiis = $szabadul - $maidatum;
				$mennyi = $mennyiis / 60 / 60;
				$mennyiegesz = round($mennyi,0);
				if($szabadul < $maidatum)
				{
					$idolejar = '<div style="color: #ff0000;">Lej�rt</div>';
				}
				else if($mennyiegesz < '1')
				{
					$idolejar = '<div style="color: #00a6ff">Kevesebb, mint 1 �ra</div>';
				} 
				else if ($mennyiegesz > '1' AND $mennyiegesz < '24')
				{
					$idolejar = '<div style="color: #00a6ff">'.$mennyiegesz.' �ra</div>';
				} 
				else if ($mennyiegesz > '24' AND $mennyiegesz < '168' AND $mennyiegesz < '8760')
				{
					$asder2 = $mennyiegesz / 24;
					$asder3 = round($asder2, 0);
					$idolejar = '<div style="color: #fffc00">'.$asder3.' nap</div>';
				} else if($mennyiegesz > '168' AND $mennyiegesz < '8760')
				{
					$asder4 = $mennyiegesz / 168;
					$asder5 = round($asder4, 0);
					$idolejar = '<div style="Color: #ffae00;">'.$asder5.' h�t</div>';
				}
				else if($mennyiegesz > '8760')
				{
					$asder6 = $mennyiegesz / 8760;
					$asder7 = round($asder6, 0);
					$idolejar = '<div style="color: #ffae00;">'.$asder7.' �v</div>';
				}
			}
			$bannolvadatum = date("Y.m.d. H:i", $bannok['Datum']);
			echo '<tr  style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
					<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;" title="'.$bannok['Oka'].'">'.$bannok['Cim'].'</td>
					<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;" title="'.$idolejartitle.'">'.$idolejar.'</td>';
				echo '<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;">'.$bannolvadatum.'</td>';
						if($sor['Admin'] > '1')
						{
							echo '<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;"><a href="index.php?menu=admin&bannok&unban='.$bannok['Cim'].'">Unban</a></td>';
						}
					
				echo '</tr>';
		}
		echo '</table>';
		}
		else if(isset($_GET['masok']))
		{
			echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="700">
					<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
						<td style="font-size: 15px; color: #ffffff; font-weight: bold;">N�v / IP</td>
						<td style="font-size: 15px; color: #ffffff; font-weight: bold;">Unbannolta</td>
						<td style="font-size: 15px; color: #ffffff; font-weight: bold;">Indok</td>
						<td style="font-size: 15px; color: #ffffff; font-weight: bold;">D�tum</td>
					</tr>';
			$unbann_mas_q = mysql_query("SELECT * FROM unban_indok WHERE kie='{$sor['Nev']}' ORDER BY Datum ASC");
			while($unban_mas = mysql_fetch_array($unbann_mas_q))
			{
				$datum = date("Y.m.d. H:i", $unban_mas['datum']);
				echo '<tr  style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
						<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;">'.$unban_mas['kit'].'</td>
						<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;">'.$unban_mas['ki'].'</td>
						<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;">'.$unban_mas['indok'].'</td>
						<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;">'.$datum.'</td>
					</tr>';
			}
			echo '</table>';
		} else {
		echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="700">
				<tr style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
					<td style="font-size: 15px; color: #ffffff; font-weight: bold;">N�v / IP</td>
					<td style="font-size: 15px; color: #ffffff; font-weight: bold;">Id�</td>';
					echo '<td style="font-size: 15px; color: #ffffff; font-weight: bold;">Bannolta</td>';
				echo '<td style="font-size: 15px; color: #ffffff; font-weight: bold;">Bannolva</td>';
					if($sor['Admin'] > '4')
					{
						echo '<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;"></td>';
					}
			echo '</tr>';
		
		$bannok_q = mysql_query("SELECT * FROM bans ORDER BY Datum DESC");
		while($bannok = mysql_Fetch_array($bannok_q))
		{
			
		
			if($bannok['Orok'] == "i")
			{
				$idolejartitle = 'Ez �r�k';
				$idolejar = '�r�k';
			} else {
				$idolejartitle = date("Y.m.d. H:i", $bannok['Ido']);
				$szabadul = $bannok['Ido'];
				$maidatum = strtotime(date("Y-m-d H:i"));
				$mennyiis = $szabadul - $maidatum;
				$mennyi = $mennyiis / 60 / 60;
				$mennyiegesz = round($mennyi,0);
				if($szabadul < $maidatum)
				{
					$idolejar = '<div style="color: #ff0000;">Lej�rt</div>';
				}
				else if($mennyiegesz < '1' or $mennyiegesz == "1")
				{
					$idolejar = '<div style="color: #00a6ff">Kevesebb, mint 1 �ra</div>';
				} 
				else if ($mennyiegesz > '1' AND $mennyiegesz < '24')
				{
					$idolejar = '<div style="color: #00a6ff">'.$mennyiegesz.' �ra</div>';
				} 
				else if ($mennyiegesz > '24' AND $mennyiegesz < '168' AND $mennyiegesz < '8760')
				{
					$asder2 = $mennyiegesz / 24;
					$asder3 = round($asder2, 0);
					$idolejar = '<div style="color: #fffc00">'.$asder3.' nap</div>';
				} else if($mennyiegesz > '168' AND $mennyiegesz < '8760')
				{
					$asder4 = $mennyiegesz / 168;
					$asder5 = round($asder4, 0);
					$idolejar = '<div style="Color: #ffae00;">'.$asder5.' h�t</div>';
				}
				else if($mennyiegesz > '8760')
				{
					$asder6 = $mennyiegesz / 8760;
					$asder7 = round($asder6, 0);
					$idolejar = '<div style="color: #ffae00;">'.$asder7.' �v</div>';
				}
			}
			$bannolvadatum = date("Y.m.d. H:i", $bannok['Datum']);
			echo '<tr  style=" height: 30px;" class="frakciok_eger_ravisz_sav" align="center">
					<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;" title="'.$bannok['Oka'].'">'.$bannok['Cim'].'</td>
					<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;" title="'.$idolejartitle.'">'.$idolejar.'</td>';
					echo '<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;">'.$bannok['Bannolta'].'</td>';
				echo '<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;">'.$bannolvadatum.'</td>';
					if(isset($_GET['sajat']))
					{
						if($sor['Admin'] > '1')
						{
							echo '<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;"><a href="index.php?menu=admin&bannok&unban='.$bannok['Cim'].'">Unban</a></td>';
						}
					} else {
						if($sor['Admin'] > '4')
						{
							echo '<td style="font-size: 14px; color: #ffffff; padding-left: 4px; padding-right: 4px;"><a href="index.php?menu=admin&bannok&unban='.$bannok['Cim'].'">Unban</a></td>';
						}
					}
				echo '</tr>';
		}
		echo '</table>';
		}
	} else if(isset($_GET['frakciok']))
	{
		if($sor['Admin'] > '1336' OR $fsor['AAA'] > '0')
		{
			include("oldal/admin_frakciok.php");
		} else {
			msg("2","Nincs hozz�f�r�sed!");
		}
	} else if(isset($_GET['premiumpont']))
	{
	
	} else {
		
	}
} else {
	msg("2", "Ez a tartalom sz�modra nem �rhet� el!");
}
} else {
	msg("2", "Az oldal megtekint�s�hez be kell jelentkezned!");
}
?>