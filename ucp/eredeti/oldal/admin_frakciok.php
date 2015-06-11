<?php
if(isset($_GET['id']))
{
	$frakcio_id = $_GET['id'];
	if(isset($_GET['kirug']))
	{
		
			if($_GET['kirug'] != '')
			{
				$kirugando_q = mysql_query("SELECT * FROM playerek WHERE ID='".mysql_escape_string($_GET['kirug'])."' AND Member = '".mysql_escape_string($frakcio_id)."'");
				$kirugando = mysql_fetch_array($kirugando_q);
				if(!$kirugando)
				{
					echo 'Vagy nincs ilyen player, vagy nem a frakciód tagja';
				} else {
						$mysql_kirug = mysql_query("UPDATE playerek SET Member='0', Leader='0' WHERE ID='".mysql_escape_string($_GET['kirug'])."'");
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
						
						header("Location: index.php?menu=admin&frakciok&id=$frakcio_id&tagok");
				}
			} else { echo 'Meg kell adni egy ID-t ... '; }
		}
	if(isset($_GET['tagok'])) { $aloldalneve = '- Tagok'; }
	else if(isset($_GET['szef'])) { $aloldalneve = '- Széf'; }
	else if(isset($_GET['jarmuvek'])) { $aloldalneve = '- Jármûvek'; }
	else if(isset($_GET['fizetes'])) { $aloldalneve = '- Fizetések'; }
	else if(isset($_GET['tagfelvetel'])) { $aloldalneve = '- Tag felvétel'; }
	else if(isset($_GET['kiruglista'])) { $aloldalneve = '- Kirúgási lista'; }
	else if(isset($_GET['rangadaselvetel'])) { $aloldalneve = '- Rang átírás'; }
	else { $aloldalneve = '- Információk'; }
	echo "<h1>Frakció ".$aloldalneve."</h1>";
	
		echo '<div align="center">';
		
		if(isset($_GET['tagok']))
		{
			echo '<div style="padding-top: 30px;"></div>';
			echo '<table border="1" class="table_border" cellpadding="0" cellspacing="0" width="365">
				<tr>
					<td align="center" style="font-size: 15px; font-weight: bold; color: #ffffff;">Név</td>
					<td align="center" width="50" style="font-size: 15px; font-weight: bold; color: #ffffff;">Rang</td>
					<td align="center" width="150" style="font-size: 15px; font-weight: bold; color: #ffffff;">Utolsó belépés</td>';
				
					echo '<td></td>';
			echo 	'</tr>';
			$k = mysql_query("SELECT * FROM playerek WHERE `Member` = '".mysql_escape_string($frakcio_id)."' ORDER BY `Rank` DESC");
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
				echo '<tr class="frakciok_eger_ravisz_sav">
					<td align="center" style="font-size: 12px; color: #ffffff;">'.$a['Nev'].'</td>
					<td align="center" width="50" style="font-size: 12px; color: #ffffff;">'.$a['Rank'].'</td>';
					if(isset($asder))
					{
						echo '<td align="center" width="150" style="font-size: 12px; color: #ffffff;">'.$asder.'</td>';
					} else {
						echo '<td align="center" width="150" style="font-size: 12px; color: #ffffff;">Nincs adat</td>';
					}
				
						echo '<td><a href="index.php?menu=admin&frakciok&id='.$_GET['id'].'	&kirug='.$a['ID'].'" style="font-size: 13px; padding-left: 5px;">Kirúgás</a></td>';
					
				echo '</tr>';
			}
			echo "</table>";
			
		} else if(isset($_GET['szef']))
		{
			$frakcio_szef_q = mysql_query("SELECT * FROM frakciok WHERE ID = '".mysql_escape_string($frakcio_id)."'");
			$frakcio_szef = mysql_fetch_array($frakcio_szef_q);
			$cuccok = explode(",",$frakcio_szef['Cuccok']);
			echo '<div style="padding-top: 30px;">';
			echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" width="500">
				<tr>
					<td style="padding: 5px 5px 5px 5px; width: 170px;"><img src="img/szef/szef_icon.png"></td>
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
			$frakcio_kocsik_q = mysql_query("SELECT * FROM kocsik WHERE Frakcio='{$frakcio_id}'");
			while($frakcio_kocsik = mysql_fetch_array($frakcio_kocsik_q))
			{
				$modelidke = $frakcio_kocsik['Model'];
				if($frakcio_kocsik['Zarva']=='0'){$zarva = '<div style="color: #05e400;">Nyitva</div>'; } else { $zarva = '<div style="color: #ff0000;">Zárva</div>'; }
				if($frakcio_kocsik['KerekBilincs']=='0'){$KerekBilincs = '<div style="color: #05e400;">Nincs</div>'; } else { $KerekBilincs = '<div style="color: #ff0000;">Van</div>'; }
				$ezeroccaz = '1500';
				$km = $frakcio_kocsik['KM'];
				$olajcsere = $ezeroccaz - $km;
				echo '<tr align="center">
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
					$fizetes_u = mysql_query("UPDATE frakciok SET Fizetesek='{$data}' WHERE Id='{$frakcio_id}'");
					echo 'Fizetések átírva';
				
			}
			echo '<div style="padding-top: 30px;"></div>';
			echo '<table border="1" class="table_border" cellspacing="0" cellpadding="0" style="color: #ffffff;">';
			$frakcio_fizetes_q = mysql_query("SELECT * FROM frakciok WHERE Id='{$frakcio_id}'");
			$frakcio_fizetes = mysql_fetch_array($frakcio_fizetes_q);
			$osszrang = $frakcio_fizetes['OsszRang'];
			$egy = '1';
			$osszrangg = $egy + $osszrang;
			$fizetesek = explode(",",$frakcio_fizetes['Fizetesek']);
			$rangneve = explode(",",$frakcio_fizetes['Rangok']);
			
				echo '<form action="index.php?menu=admin&frakciok&id='.$frakcio_id.'&fizetes" method="POST">';
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
					echo 'Ilyen nevû játékos nem létezik!';
				} else {
					if($jatekos_ellenorzese['Member'] != '0')
					{
						echo 'Sajnálom de ez a játékos már egy másik frakció tagja, így nem tudod felvenni';
					} else {
						$eltiltas = explode(",",$jatekos_ellenorzese['Tiltasok']);
						if($eltiltas['0'] == '1')
						{
							echo 'Sajnálom, de a játékos bizonyos ideig nem csatlakozhat frakcióhoz, így nem tudod felvenni';
						} else {
							$frakciolimit_q = mysql_query("SELECT * FROM frakciok WHERE Id='{$frakcio_id}'");
							$frakciolimitt = mysql_fetch_array($frakciolimit_q);
							$frakciolimit = $frakciolimitt['FrakcioLimit'];
							$tagok_szama_q = mysql_query("select COUNT(*) id FROM playerek WHERE Member='{$frakcio_id}'");
							$tagok_szama = mysql_result($tagok_szama_q,0);

							if($frakciolimit == $tagok_szama OR $frakciolimit > $tagok_szama)
							{
								echo 'A frakciód megtelt!';
							} else {
								$mysql_felvetel = mysql_query("UPDATE playerek SET Member='{$frakcio_id}' WHERE Nev='".mysql_escape_string($ignev)."'");
								echo 'Sikeresen felvetted '.$ignev.' játékost a frakciódba!';
							}
						}
					}
				}
			}
				echo '<div style="padding-top: 30px;"></div>';
				echo '<form action="index.php?menu=admin&frakciok&id='.$frakcio_id.'&tagfelvetel" method="POST"><div align="center" style="font-weight: bold; font-size: 15px;">
						Játékos neve (IG): <input type="text" name="jatekosneve" style="width: 100px;"><input type="submit" name="felvetel" value="Játékos felvétele">
					</div></form>';
			
		} else if(isset($_GET['kiruglista']))
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
						echo '<form action="index.php?menu=admin&frakciok&id='.$frakcio_id.'&kiruglista" method="POST">'.$users.'
						<div style="padding-top: 30px; font-size: 16px; color: #ffffff;">Biztos, hogy kirúgod õket/õt?</div>
						<input type="submit" value="Biztos, hogy kirúgom! KIRÚGÁS!" name="B44">
						</form>';
					} else {
						$p_users = $_POST['users'];
						$N = count($p_users);
						for($i=0; $i < $N; $i++){
	$ellenorzess = mysql_query("SELECT * FROM playerek WHERE id='".mysql_escape_string($p_users[$i])."'");
	$ellenorzes = mysql_fetch_array($ellenorzess);
	if($ellenorzes['Member'] == $frakcio_id)
	{
		$kirug_update = mysql_query("UPDATE playerek SET Member='0', Leader='0' WHERE ID='".mysql_escape_string($p_users[$i])."'");
		echo 'Kirúgva: '.$ellenorzes['Nev'].'.<br>';
	} else {
		echo ''.$ellenorzes['Nev'].' kirúgása sikertelen, vagy nem frakciód tagja vagy Leader!';
	}
						}
					}
				} else {
					echo '<div style="padding-top: 30px;"></div>';
					
						echo '<form action="index.php?menu=admin&frakciok&id='.$frakcio_id.'&kiruglista&megerosit" method="POST">';
				echo '<table border="1" class="table_border" cellpadding="0" cellspacing="0" width="365">
					<tr>';
					
						echo '<td></td>';
					
					echo '<td align="center" style="font-size: 15px; font-weight: bold; color: #ffffff;">Név</td>
						<td align="center" width="50" style="font-size: 15px; font-weight: bold; color: #ffffff;">Rang</td>
						<td align="center" width="150" style="font-size: 15px; font-weight: bold; color: #ffffff;">Utolsó belépés</td>';
					
				echo 	'</tr>';
				
				$k = mysql_query("SELECT * FROM playerek WHERE `Member` = '".mysql_escape_string($frakcio_id)."' ORDER BY `Rank` DESC");
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
					
						
	$input = '<input type="checkbox" name="kirugando[]" value="'.$a['ID'].'" title="Kirugandó személy" />';
						
						echo '<td align="center">'.$input.'</td>';
					
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
		} else if(isset($_GET['rangadaselvetel']))
		{
			
				if($_SERVER["REQUEST_METHOD"] == "POST")
				{
					$playerid	=	$_POST['igneve'];
					$rang		=	$_POST['rang'];
					
					$ellenorzes_q = mysql_query("SELECT * FROM playerek WHERE ID='".mysql_escape_string($playerid)."'");
					$ellenorzes = mysql_fetch_array($ellenorzes_q);
					if($ellenorzes['Member'] == $frakcio_id)
					{
						$ujrang = mysql_query("UPDATE playerek SET Rank='{$rang}' WHERE ID='{$playerid}'");
						echo ''.$ellenorzes['Nev'].' rangja átírva '.$rang.' -ra/re!';
					} else {
						echo 'Õ nem a te frakciódba van!';
					}
				}
				$tagok_lista_q = mysql_query("SELECT * FROM playerek WHERE Member='{$frakcio_id}' ORDER BY Nev ASC");
				echo '<div style="padding-top: 30px;" align="center">
						<form action="index.php?menu=admin&frakciok&id='.$frakcio_id.'&rangadaselvetel" method="POST">
	<select name="igneve">';
		while($tagok_lista = mysql_fetch_array($tagok_lista_q))
		{
			echo '<option value="'.$tagok_lista['ID'].'">'.$tagok_lista['Nev'].' ('.$tagok_lista['Rank'].')</option>';
		}
				echo		'</select><br><select name="rang">';
				$frakcio_maxrang_q = mysql_query("SELECT * FROM frakciok WHERE Id='{$frakcio_id}'");
				$frakcio_maxrang = mysql_fetch_array($frakcio_maxrang_q);
				$f_maxrang = $frakcio_maxrang['OsszRang'];
					for($fmr = 0; $fmr < $f_maxrang; $fmr++)
					{
						echo '<option>'.$fmr.'</option>';
					}
					echo '</select><br><input type="submit" name="rangadas" value="Rang megváltoztatása">';
				echo '</form></div>';
			
			} else {
					$frakcio_adatok_q = mysql_query("SELECT * FROM frakciok WHERE Id='{$frakcio_id}'");
					$frakcio_adatok = mysql_fetch_array($frakcio_adatok_q);
					$frakcio_neve = explode(",",$frakcio_adatok['Szervezetneve']);
					$tagok_szama_q = mysql_query("select COUNT(*) id FROM playerek WHERE Member='{$frakcio_id}'");
					$tagok_szama = mysql_result($tagok_szama_q,0);
					$jarmuvek_szama_q = mysql_query("select COUNT(*) id FROM kocsik WHERE Frakcio='{$frakcio_id}'");
					$jarmuvek_szama = mysql_result($jarmuvek_szama_q,0);
					$leaderek_szama_q = mysql_query("select COUNT(*) id FROM playerek WHERE Leader='{$frakcio_id}'");
					$leaderek_szama = mysql_result($leaderek_szama_q,0);
					echo '<div style="padding-top: 30px;"></div>';
					echo '<table border="1" class="table_border" width="350">
	<tr>
		<td style="font-weight: bold; font-size: 15px; color: #ffffff;">Frakció neve</td>
		<td style="font-size: 15px; color: #ffffff;">'.$frakcio_neve['0'].'</td>
	</tr>
	<tr>
		<td style="font-weight: bold; font-size: 15px; color: #ffffff;">Tagok száma</td>
		<td style="font-size: 15px; color: #ffffff;">'.$tagok_szama.' / '.$frakcio_adatok['FrakcioLimit'].'</td>
	</tr>
	<tr>
		<td style="font-weight: bold; font-size: 15px; color: #ffffff;">Leaderek száma</td>
		<td style="font-size: 15px; color: #ffffff;">'.$leaderek_szama.'</td>
	</tr>
	<tr>
		<td style="font-weight: bold; font-size: 15px; color: #ffffff;">Jármûvek száma</td>
		<td style="font-size: 15px; color: #ffffff;">'.$jarmuvek_szama.'</td>
	</tr>
	<tr>
		<td style="font-weight: bold; font-size: 15px; color: #ffffff;">Széf min.rang</td>
		<td style="font-size: 15px; color: #ffffff;">'.$frakcio_adatok['MinRang'].'</td>
	</tr>
						</table>';
				}
				
				echo '</div>';
		
} else {
	echo '<div align="center">';
	$frakcio_lista_q = mysql_query("SELECT * FROM frakciok ORDER BY id ASC");
	while($frakcio_lista = mysql_fetch_array($frakcio_lista_q))
	{
		$frakcioid = $frakcio_lista['id'];
		echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&frakciok&id='.$frakcioid.'\';">'.$fract[$frakcioid].'</div>';
	}
	echo '</div>';
}
?>