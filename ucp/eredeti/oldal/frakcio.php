<?php
$frakcio_q = mysql_query("SELECT * FROM frakciok WHERE ID = '".mysql_escape_string($sor['Member'])."'");
$frakcio = mysql_fetch_array($frakcio_q);
$frakcio_neve = explode(",",$frakcio['Szervezetneve']);
if(isset($_GET['tagok'])) { $aloldalneve = '- Tagok'; }
else if(isset($_GET['szef'])) { $aloldalneve = '- Széf'; }
else if(isset($_GET['jarmuvek'])) { $aloldalneve = '- Jármûvek'; }
else if(isset($_GET['fizetes'])) { $aloldalneve = '- Fizetések'; }
else if(isset($_GET['tagfelvetel'])) { $aloldalneve = '- Tag felvétel'; }
else if(isset($_GET['kiruglista'])) { $aloldalneve = '- Kirúgási lista'; }
else if(isset($_GET['rangadaselvetel'])) { $aloldalneve = '- Rang átírás'; }
else if(isset($_GET['beallitasok'])) { $aloldalneve = '- Beállítások'; }
else { $aloldalneve = '- Információk'; }
echo "<h1>Frakció ".$aloldalneve."</h1>";
if($sor['Member'] < 1) echo "<font color=red>Nem vagy frakció tagja!</font>";
else
{
	echo '<div align="center">';
	
	if(isset($_GET['tagok']))
	{
		if(isset($_GET['kirug']))
		{
			if($sor['Leader'] == $sor['Member'])
			{
				if($_GET['kirug'] != '')
				{
					$kirugando_q = mysql_query("SELECT * FROM playerek WHERE ID='".mysql_escape_string($_GET['kirug'])."' AND Member = '".mysql_escape_string($sor['Leader'])."'");
					$kirugando = mysql_fetch_array($kirugando_q);
					if(!$kirugando)
					{
						msg("2","Vagy nincs ilyen player, vagy nem a frakciód tagja!");
					} else {
						if($kirugando['Leader'] == $sor['Leader'])
						{
							msg("2", "Leadert nem rúghatsz ki!");
						} else {
							if($kirugando['Online']  == "0")
							{
								$mysql_kirug = mysql_query("UPDATE playerek SET Member='0' WHERE ID='".mysql_escape_string($_GET['kirug'])."'");
								if(!$mysql_kirug)
								{
									die('Hiba: '.mysql_error());
								}
							/*$tiltveszos = explode(",", $kirugando['Tiltasok']);
							$ujtiltas = '1'.$tiltvesszos['1'].','.$tiltvesszos['2'].'';
							$mysql_tiltas = mysql_query("UPDATE playerek SET Tiltasok='{$ujtiltas}' WHERE ID='".mysql_escape_string($_GET['kirug'])."'");
							if(!$mysql_tiltas)
							{
		die('Hiba: '.mysql_error());
							}*/
								header("Location: index.php?menu=frakcio");
							} else {
								msg("2", "Õ jelenleg online! Nem tudod kirúgni!");
							}
						}
					}
				} else { msg("2","Nincs megadva ID!"); }
			} else { msg("2","Ehhez nincs jogosultságod!"); }
		}
		echo '<div style="padding-top: 30px;"></div>';
		echo '<table border="1" class="table_border" cellpadding="0" cellspacing="0" width="450">
			<tr>
				<td align="center" style="font-size: 15px; font-weight: bold; color: #ffffff;">Név</td>
				<td align="center" width="50" style="font-size: 15px; font-weight: bold; color: #ffffff;">Rang</td>
				<td align="center" width="150" style="font-size: 15px; font-weight: bold; color: #ffffff;">Utolsó belépés</td>';
			if($sor['Leader'] == $sor['Member'])
			{
				echo '<td></td>';
			}
		echo 	'</tr>';
		$k = mysql_query("SELECT * FROM playerek WHERE `Member` = '".mysql_escape_string($sor['Member'])."' ORDER BY `Rank` DESC");
		while($a = mysql_fetch_assoc($k))
		{
			/*if($a['Online'] == 0)
			{
				$utoljaraaktiv = $a['UtoljaraAktiv'];
				$maidatum = strtotime(date("Y-m-d H:i:s"));
				$mennyiis = $maidatum - $utoljaraaktiv;
				$mennyi = $mennyiis / 60 / 60;
				$mennyiegesz = round($mennyi,0);
				if($mennyiegesz < '1')
				{
					$asder = '<div style="color: #00a7ff">Kevesebb, mint 1 óra';
				} 
				else if ($mennyiegesz > '1' AND $mennyiegesz < '24')
				{
					$asder = '<div style="color: #00a7ff">'.$mennyiegesz.' órája';
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
			} else { $asder = '<div style="color: #00ff24;">Jelenleg aktív</div>'; }*/
			if($a['Online'] == "1")
			{
				$asder = 'Jelenleg aktív';
			} else {
				$asder = date("Y.m.d. H:i", $a['UtoljaraAktiv']);
			}
			echo '<tr class="frakciok_eger_ravisz_sav">';
			if($a['Leader'] == $a['Member'])
			{
				echo '<td align="center" style="font-size: 12px; color: #ffffff;">'.$a['Nev'].' (L)</td>';
			} else {
				echo '<td align="center" style="font-size: 12px; color: #ffffff;">'.$a['Nev'].'</td>';
			}
			echo '
				<td align="center" width="50" style="font-size: 12px; color: #ffffff;">'.$a['Rank'].'</td>';
				if(isset($asder))
				{
					echo '<td align="center" width="150" style="font-size: 12px; color: #ffffff;">'.$asder.'</td>';
				} else {
					echo '<td align="center" width="150" style="font-size: 12px; color: #ffffff;">Nincs adat</td>';
				}
			if($sor['Leader'] == $sor['Member'])
			{
				if($a['Leader'] != $sor['Leader'])
				{
					echo '<td><a href="index.php?menu=frakcio&tagok&kirug='.$a['ID'].'" style="font-size: 13px; padding-left: 5px;">Kirúgás</a></td>';
				}
			}
			echo '</tr>';
		}
		echo "</table>";
		
	} else if(isset($_GET['szef']))
	{
		
		$cuccok = explode(",",$frakcio['Cuccok']);
		echo '<div style="padding-top: 30px;">';
		echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="500">
			<tr>
				<td style="padding: 5px 5px 5px 5px; width: 140px;"><img src="img/szef/szef2.png"></td>
				<td>
					<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="100%">
<tr height="54">
	<td width="54"><img height="54" src="img/szef/penz.png"></td>
	<td align="center" style="font-size: 14px; color: #05e900;"><b>Pénz:</b> '.$cuccok['0'].' Ft</td>
</tr>
<tr height="55">
	<td width="54"><img height="54" src="img/szef/drog.png"></td>
	<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="font-size: 14px; color: #ffffff;" align="center"><b>Heroin:</b> '.$cuccok['2'].' g</td>
			</tr>
			<tr>
				<td style="font-size: 14px; color: #ffffff;"align="center"><b>Kokain:</b> '.$cuccok['3'].' g</td>
			</tr>
			<tr>
				<td style="font-size: 14px; color: #ffffff;" align="center"><b>Marihuana:</b> '.$cuccok['4'].' g</td>
			</tr>
		</table>
	</td>
</tr>
<tr height="54">
	<td width="54"><img height="54" src="img/szef/kaja.png"></td>
	<td align="center" style="font-size: 14px; color: #ffffff;"><b>Kaja:</b> '.$cuccok['5'].' db</td>
</tr>
					</table>
				</td>
			</tr>
		</table>';
		echo '</div>';
	} else if(isset($_GET['jarmuvek']))
	{
		echo '<div style="padding-top: 30px;"></div>';
		echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="700" style="color: #ffffff;">
			<tr align="center">
				<td style="font-size: 13px; font-weight: bold;">ID</td>
				<td style="font-size: 13px; font-weight: bold;">Típus</td>
				<td style="font-size: 13px; font-weight: bold;">PosX</td>
				<td style="font-size: 13px; font-weight: bold;">PosY</td>
				<td style="font-size: 13px; font-weight: bold;">PosZ</td>
				<td style="font-size: 13px; font-weight: bold;">Zárva</td>
				<td style="font-size: 13px; font-weight: bold;">Olajcsere (még km)</td>
				<td style="font-size: 13px; font-weight: bold;">Összes km</td>
				<td style="font-size: 13px; font-weight: bold;">Kerékbilincs</td>
			</tr>';
		$frakcio_kocsik_q = mysql_query("SELECT * FROM kocsik WHERE Frakcio='{$sor['Member']}'");
		while($frakcio_kocsik = mysql_fetch_array($frakcio_kocsik_q))
		{
			$modelidke = $frakcio_kocsik['Model'];
			if($frakcio_kocsik['Zarva']=='0'){$zarva = '<div style="color: #05e400;">Nyitva</div>'; } else { $zarva = '<div style="color: #ff0000;">Zárva</div>'; }
			if($frakcio_kocsik['KerekBilincs']=='0'){$KerekBilincs = '<div style="color: #05e400;">Nincs</div>'; } else { $KerekBilincs = '<div style="color: #ff0000;">Van</div>'; }
			$ezeroccaz = '1500';
			$km = $frakcio_kocsik['KM'];
			$olajcsere = $ezeroccaz - $km;
			echo '<tr align="center" class="frakciok_eger_ravisz_sav">
				<td style="font-size: 12px;">'.$frakcio_kocsik['Id'].'</td>
				<td style="font-size: 12px;">'; echo $kocsinevek[$modelidke-400]; echo '</td>
				<td style="font-size: 12px;">'.$frakcio_kocsik['LocX'].'</td>
				<td style="font-size: 12px;">'.$frakcio_kocsik['LocY'].'</td>
				<td style="font-size: 12px;">'.$frakcio_kocsik['LocZ'].'</td>
				<td style="font-size: 12px;">'.$zarva.'</td>
				<td style="font-size: 12px;">'.$olajcsere.' km</td>
				<td style="font-size: 12px;">'.$frakcio_kocsik['ALLKM'].' km</td>
				<td style="font-size: 12px;">'.$KerekBilincs.'</td>
			</tr>';
		}
	echo '</table>';
	} else if(isset($_GET['fizetes']))
	{
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			if($sor['Leader'] == $sor['Member'])
			{
				$setted = 0;
				$data = "";
				while(true)
				{
					if(!isset($_POST["".$setted.""]))
break;
					$data .= $_POST["".$setted.""] . ($setted != 19 ? "," : "");
					++$setted;
				}
				for(; $setted < 20; ++$setted)
					$data .=  $setted != 19 ? "0," : "0";
				$fizetes_u = mysql_query("UPDATE frakciok SET Fizetesek='{$data}' WHERE Id='{$sor['Leader']}'");
				msg("1", "Fizetések átírva");
			} else {
				msg("2", "Nincs jogosultságod!");
			}
		}
		echo '<div style="padding-top: 30px;"></div>';
		echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" style="color: #ffffff;">';
		$osszrang = $frakcio['OsszRang'];
		$egy = '1';
		$osszrangg = $egy + $osszrang;
		$fizetesek = explode(",",$frakcio['Fizetesek']);
		$rangneve = explode(",",$frakcio['Rangok']);
		if($sor['Leader'] == $sor['Member'])
		{
			echo '<form action="index.php?menu=frakcio&fizetes" method="POST">';
			for($f = 0; $f < $osszrangg; $f ++)
			{
				echo '<tr>
<td style="padding: 3px 5px 3px 5px; font-size: 14px; font-weight: bold;">'.$rangneve[$f].'</td>
<td style="padding: 3px 5px 3px 5px;"><input type="text" class="fizetes_input" name="'.$f.'" value="'.$fizetesek[$f].'"></td>
					</tr>';
			}
			echo '<tr>
					<td></td>
					<td><input type="submit" value="Mentés" name="ment"></td>
				</tr>
				</form>';
		} else {
			for($f = 0; $f < $osszrangg; $f ++)
			{
				echo '<tr>
<td style="padding: 3px 5px 3px 5px; font-size: 14px; font-weight: bold;">'.$rangneve[$f].'</td>
<td style="padding: 3px 5px 3px 5px; font-size: 14px;">'.$fizetesek[$f].'</td>
					</tr>';
			}
		}
		echo '</table>';
		echo '<div align="center" style="font-weight: bold; font-size: 10px; padding-top: 20px;">* A fizetések csak max. 15 perc múlva lépnek érvénybe a szerveren *</div>';
	} else if(isset($_GET['tagfelvetel']))
	{
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$ignev = $_POST['jatekosneve'];
			$jatekos_ellenorzese_q = mysql_query("SELECT * FROM playerek WHERE Nev='".mysql_escape_string($ignev)."'");
			$jatekos_ellenorzese = mysql_fetch_array($jatekos_ellenorzese_q);
			if(!$jatekos_ellenorzese)
			{
				msg("2", "Ilyen nevû játékos nem létezik!");
			} else {
				if($jatekos_ellenorzese['Member'] != '0')
				{
					msg("2", "Ez a játékos másik frakció tagja, így nem tudod felvenni!");
				} else {
					$eltiltas = explode(",",$jatekos_ellenorzese['Tiltasok']);
					if($eltiltas['0'] == '1')
					{
						msg("2", "Ez a játékos bizonyos ideig nem csatlakozhat frakcióhoz, így nem tudod felvenni!");
					} else {

						$frakciolimit = $frakcio['FrakcioLimit'];
						$tagok_szama_q = mysql_query("select COUNT(*) id FROM playerek WHERE Member='{$sor['Member']}'");
						$tagok_szama = mysql_result($tagok_szama_q,0);

						if($frakciolimit == $tagok_szama OR $frakciolimit < $tagok_szama)
						{
							msg("2", "Frakció megtelt!");
						} else {
							if($jatekos_ellenorzese['Online'] == "1")
							{
								msg("2", "Ez a játékos jelenleg online, így nem tudod felvenni!");
							} else {
								$mysql_felvetel = mysql_query("UPDATE playerek SET Member='{$sor['Leader']}' WHERE Nev='".mysql_escape_string($ignev)."'");
								$ucp_user_ellenorzes_q = mysql_query("SELECT * FROM ucpuserek WHERE Kari1='".mysql_escape_string($jatekos_ellenorzese['ID'])."' OR Kari2='".mysql_escape_string($jatekos_ellenorzese['ID'])."'");
								$ucp_user_ellenorzes = mysql_fetch_array($ucp_user_ellenorzes_q);
								if(!$ucp_user_ellenorzes) { msg("2","Ez a karakter egyik UCP felhaszálóhoz sincs társítva, így nem lehet felvenni itt!"); } else {
									if($ucp_user_ellenorzes['Kari1'] == $jatekos_ellenorzese['ID'])
									{
										$update_text = ''.$sor['Leader'].',1';
										$mysql_skinvalasztas = mysql_query("UPDATE ucpuserek SET F_skinvalaszt = '{$update_text}' WHERE Kari1='".mysql_escape_string($jatekos_ellenorzese['ID'])."'");
										if(!$mysql_skinvalasztas)
										{
											die('Hiba: '.mysql_error());
										}
									} else if($ucp_user_ellenorzes['Kari2'] == $jatekos_ellenorzese['ID'])
									{
										$update_text = ''.$sor['Leader'].',2';
										$mysql_skinvalasztas = mysql_query("UPDATE ucpuserek SET F_skinvalaszt = '{$update_text}' WHERE Kari2='".mysql_escape_string($jatekos_ellenorzese['ID'])."'");
										if(!$mysql_skinvalasztas)
										{
											die('Hiba: '.mysql_error());
										}
									}
								}
								msg("1", "Sikeresen felvetted ".$ignev." játékost a frakciódba!");
							}
						}
					}
				}
			}
		}
			echo '<div style="padding-top: 30px;"></div>';
			echo '<form action="index.php?menu=frakcio&tagfelvetel" method="POST"><div align="center" style="font-weight: bold; font-size: 15px;">
					Játékos neve (IG): <input type="text" name="jatekosneve" style="width: 100px;"><input type="submit" name="felvetel" value="Játékos felvétele">
				</div></form>';
		
	} else if(isset($_GET['kiruglista']))
	{
		if($sor['Leader'] == $sor['Member'])
		{
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{
				if(isset($_GET['megerosit']))
				{
					$p_users = $_POST['kirugando'];
					$N = count($p_users);
					$users='';
					for($i=0; $i < $N; $i++){
					  $users .= '<input type="hidden" name="users[]" value="'.$p_users[$i].'" />';
					}
					echo '<form action="index.php?menu=frakcio&kiruglista" method="POST">'.$users.'
					<div style="padding-top: 30px; font-size: 16px; color: #ffffff;">Biztos, hogy kirúgod õket/õt?</div>
					<input type="submit" value="Biztos, hogy kirúgom! KIRÚGÁS!" name="B44">
					</form>';
				} else {
					$p_users = $_POST['users'];
					$N = count($p_users);
					for($i=0; $i < $N; $i++){
						$ellenorzess = mysql_query("SELECT * FROM playerek WHERE id='".mysql_escape_string($p_users[$i])."'");
						$ellenorzes = mysql_fetch_array($ellenorzess);
						if($ellenorzes['Member'] == $sor['Leader'] AND $ellenorzes['Leader'] != $sor['Leader'])
						{
							if($ellenorzes['Online'] == "0")
							{
								$kirug_update = mysql_query("UPDATE playerek SET Member='0' WHERE ID='".mysql_escape_string($p_users[$i])."'");
								msg("1", "Kirúgva ".$ellenorzes['Nev']."!");
							} else {
								msg("2", "".$ellenorzes['Nev']." jelenleg online, nem tudod kirúgni.");
							}
						} else {
							msg("2", "".$ellenorzes['Nev']." kirúgása sikertelen, vagy nem a frakciód tagja vagy Leader!");
						}
					}
				}
			} else {
				echo '<div style="padding-top: 30px;"></div>';
				
					echo '<form action="index.php?menu=frakcio&kiruglista&megerosit" method="POST">';
			echo '<table border="1" class="table_border" cellpadding="0" cellspacing="0" width="365">
				<tr>';
				if($sor['Leader'] == $sor['Member'])
				{
					echo '<td></td>';
				}
				echo '<td align="center" style="font-size: 15px; font-weight: bold; color: #ffffff;">Név</td>
					<td align="center" width="50" style="font-size: 15px; font-weight: bold; color: #ffffff;">Rang</td>
					<td align="center" width="150" style="font-size: 15px; font-weight: bold; color: #ffffff;">Utolsó belépés</td>';
				
			echo 	'</tr>';
			
			$k = mysql_query("SELECT * FROM playerek WHERE `Member` = '".mysql_escape_string($sor['Member'])."' ORDER BY `Rank` DESC");
			while($a = mysql_fetch_assoc($k))
			{
				if($a['Online'] == 0)
				{
					$utoljaraaktiv = $a['UtoljaraAktiv'];
					$maidatum = strtotime(date("Y-m-d H:i:s"));
					$mennyiis = $maidatum - $utoljaraaktiv;
					$mennyi = $mennyiis / 60 / 60;
					$mennyiegesz = round($mennyi,0);
					if($mennyiegesz < '1')
					{
$asder = '<div style="color: #00a7ff">Kevesebb, mint 1 óra';
					} 
					else if ($mennyiegesz > '1' AND $mennyiegesz < '24')
					{
$asder = '<div style="color: #00a7ff">'.$mennyiegesz.' órája';
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
				} else { $asder = '<div style="color: #00ff24;">Jelenleg aktív</div>'; }
				echo '<tr class="frakciok_eger_ravisz_sav">';
				if($sor['Leader'] == $sor['Member'])
				{
					if($a['Leader'] != $sor['Leader'])
					{
$input = '<input type="checkbox" name="kirugando[]" value="'.$a['ID'].'" title="Kirugandó személy" />';
					} else {
$input = '';
					}
					echo '<td align="center">'.$input.'</td>';
				}
				echo '<td align="center" style="font-size: 12px; color: #ffffff;">'.$a['Nev'].'</td>
					<td align="center" width="50" style="font-size: 12px; color: #ffffff;">'.$a['Rank'].'</td>';
				if(isset($asder))
				{
					echo '<td align="center" width="150" style="font-size: 12px; color: #ffffff;">'.$asder.'</td>';
				} else {
					echo '<td align="center" width="150" style="font-size: 12px; color: #ffffff;">Nincs adat</td>';
				}
			
				echo '</tr>';
			}
			echo '<tr>
					<td><input type="submit" value="Kirúg" name="B1"></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>';
			echo "</table>";
			echo '</form>';
			}
		} else { Echo 'Enyje má no, öcsibogyó .. leaderek csak :) '; }
	} else if(isset($_GET['beallitasok']))
	{
		if($sor['Leader'] == $sor['Member'])
		{
			if(isset($_GET['szefminrang']))
			{
				$minrang = $_POST['minrang'];
				if(empty($minrang))
				{ msg("2","Meg kell adni a minimum rangot!"); }
				else {
					$minimumrang = mysql_query("UPDATE frakciok SET MinRang='".mysql_escape_string($minrang)."' WHERE Id='{$sor['Leader']}'");
					msg("1", "Sikeresen átírtad a széf minimum rangját!");
				}
			} else if(isset($_GET['jelvenykep']))
			{
				
					if($_FILES["file"]["size"] < 2097152)
					{
						if ($_FILES["file"]["error"] > 0)
						{
							echo "Hiba: " . $_FILES["file"]["error"] . "<br />";
						}
						else
						{
							$frakcio_nev = explode(",",$frakcio['Szervezetneve']);
							$frakcioneve = $frakcio_nev[0].'.png';
							$mappas = 'img/frakciokepek/'.$frakcioneve;
							if(file_exists($frakcioneve))
							{
								unlink($mappas);
								if(move_uploaded_file($_FILES["file"]["tmp_name"], $mappas))
								{
									msg("1", "Sikeresen frissítetted a frakció jelvényképét elõtte pedig töröltem az elõzõt.");
								} else {
									echo 'Hiba';
								}
							} else {
								if(move_uploaded_file($_FILES["file"]["tmp_name"], $mappas))
								{
									msg("1", "Sikeresen frissítetted a frakció jelvényképét elõtte pedig töröltem az elõzõt.");
								} else {
									echo 'Hiba';
								}
							}
						}
					} else { msg("2", "Max. 2 mb lehet ! "); }
			}
			echo'<form action="index.php?menu=frakcio&beallitasok&szefminrang" method="POST">
					<table border="1" class="table_border" cellspacing="0" cellpadding="0">
					 <tr>
					  <td style="font-size: 15px; color: #ffffff; padding-left: 10px; padding-right: 10px; font-weight: bold;">Széf minrang:</td>
					  <td style=" padding-left: 10px; padding-right: 10px;"><input type="text" name="minrang" value="'.$frakcio['MinRang'].'"></td>
					 </tr>
					 <tr>
						<td style="font-size: 15px; color: #ffffff; padding-left: 10px; padding-right: 10px; font-weight: bold;">Összes rang:</td>
						<td style=" padding-left: 10px; padding-right: 10px; font-size: 15px; color: #ffffff;">'.$frakcio['OsszRang'].'</td>
					 </tr>
					 <tr>
					  <td colspan="2" align="center"><input type="submit" name="mentes" value="Minimum Rang mentése"></td>
					 </tr>
					</table>
				</form>';
			echo '<div style="padding-top: 15px; padding-bottom: 15px;"></div>';
			echo '<form action="index.php?menu=frakcio&beallitasok&jelvenykep" method="POST" enctype="multipart/form-data">
					<table border="1" class="table_border" cellspacing="0" cellpadding="0">
						<tr>
							<td style="font-size: 15px; color: #ffffff; padding-left: 10px; padding-right: 10px; font-weight: bold;">Jelvénykép:</td>
							<td style="padding-left: 10px; padding-right: 10px;"><input type="file" name="file" size="20" id="file" /></td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input type="submit" name="tolt" value="Feltöltés"></td>
						<tr>
					</table>
				</form>';
		} else {
			msg("2", "Nem vagy Leader!");
		}
	} else if(isset($_GET['rangadaselvetel']))
	{
		if($sor['Leader'] == $sor['Member'])
		{
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{
				$playerid	=	$_POST['igneve'];
				$rang		=	$_POST['rang'];
				
				$ellenorzes_q = mysql_query("SELECT * FROM playerek WHERE ID='".mysql_escape_string($playerid)."'");
				$ellenorzes = mysql_fetch_array($ellenorzes_q);
				if($ellenorzes['Member'] == $sor['Member'])
				{
					if($ellenorzes['Online'] == "0")
					{
						$ujrang = mysql_query("UPDATE playerek SET Rank='{$rang}' WHERE ID='{$playerid}'");
						msg("1", "".$ellenorzes['Nev']." rang átírva ".$rang." -ra/re!");
					} else {
						msg("2", "".$ellenorzes['Nev']." jelenleg online, nem tudod a rangját állítani!");
					}
				} else {
					msg("2", "Õ nem a te frakciódba van!");
				}
			}
			$tagok_lista_q = mysql_query("SELECT * FROM playerek WHERE Member='{$sor['Leader']}' ORDER BY Nev ASC");
			echo '<div style="padding-top: 30px;" align="center">
					<form action="index.php?menu=frakcio&rangadaselvetel" method="POST">
<select name="igneve">';
	while($tagok_lista = mysql_fetch_array($tagok_lista_q))
	{
		echo '<option value="'.$tagok_lista['ID'].'">'.$tagok_lista['Nev'].' ('.$tagok_lista['Rank'].')</option>';
	}
			echo		'</select><br><select name="rang">';
			$f_maxrang = $frakcio['OsszRang'];
				for($fmr = 0; $fmr < $f_maxrang; $fmr++)
				{
					echo '<option>'.$fmr.'</option>';
				}
				echo '</select><br><input type="submit" name="rangadas" value="Rang megváltoztatása">';
			echo '</form></div>';
		} else { echo 'Öcsike, na, nem vagy te leader bácsi ...'; }
		} else {
				
				
				$tagok_szama_q = mysql_query("select COUNT(*) id FROM playerek WHERE Member='{$sor['Member']}'");
				$tagok_szama = mysql_result($tagok_szama_q,0);
				$jarmuvek_szama_q = mysql_query("select COUNT(*) id FROM kocsik WHERE Frakcio='{$sor['Member']}'");
				$jarmuvek_szama = mysql_result($jarmuvek_szama_q,0);
				$leaderek_szama_q = mysql_query("select COUNT(*) id FROM playerek WHERE Leader='{$sor['Member']}' AND Member='{$sor['Member']}'");
				$leaderek_szama = mysql_result($leaderek_szama_q,0);
				echo '<div style="padding-top: 30px;"></div>';
				echo '<table border="1" class="table_border" width="350">
<tr class="frakciok_eger_ravisz_sav">
	<td style="font-weight: bold; font-size: 15px; color: #ffffff;">Frakció neve</td>
	<td style="font-size: 15px; color: #ffffff;">'.$frakcio_neve['0'].'</td>
</tr>
<tr class="frakciok_eger_ravisz_sav">
	<td style="font-weight: bold; font-size: 15px; color: #ffffff;">Tagok száma</td>
	<td style="font-size: 15px; color: #ffffff;">'.$tagok_szama.' / '.$frakcio['FrakcioLimit'].'</td>
</tr>
<tr class="frakciok_eger_ravisz_sav">
	<td style="font-weight: bold; font-size: 15px; color: #ffffff;">Leaderek száma</td>
	<td style="font-size: 15px; color: #ffffff;">'.$leaderek_szama.'</td>
</tr>
<tr class="frakciok_eger_ravisz_sav">
	<td style="font-weight: bold; font-size: 15px; color: #ffffff;">Jármûvek száma</td>
	<td style="font-size: 15px; color: #ffffff;">'.$jarmuvek_szama.'</td>
</tr>
<tr class="frakciok_eger_ravisz_sav">
	<td style="font-weight: bold; font-size: 15px; color: #ffffff;">Széf min.rang</td>
	<td style="font-size: 15px; color: #ffffff;">'.$frakcio['MinRang'].'</td>
</tr>
					</table>';
					echo '<div style="padding-top: 30px;">';
				
			echo '</div>';
			}
			
			echo '</div>';
	$jelvenykep = 'img/frakciokepek/'.$frakcio_neve['0'].'.png';
if(file_exists($jelvenykep))
{
	echo '<img src="'.$jelvenykep.'" style="max-width: 400px;">';
}

}
?>