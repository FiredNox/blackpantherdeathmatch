<?
$_SERVER["SERVER_NAME"] = "ucp.classrpg.net";
require_once("config.php");
require_once("funkciok.php");
require_once("class/mysql.class.php");

set_time_limit(30);

$mysql = new MySQL();
if(!$mysql -> connected) exit("A szerver jelenleg nem elérhető, próbáld meg később.");

$ora = date("H");

/////////////////////////
//////// P I A C ////////
/////////////////////////

// Újratöltés
$mysql -> query("UPDATE piac_aruk SET Darab = Ujratoltes");

// Inaktívak törlése
$ido = date("Y-m-d H:i:s", time() - 3600);
$mysql -> query("DELETE FROM targyak WHERE Megveve < '".$ido."'");

/////////////////////////
/// A K T I V I T Á S ///
/////////////////////////
if($ora == 0)
{
	set_time_limit(300);

	$unix30 = time() - 30*86400;
	
	$day30 = date('Y-m-d', $unix30);
	$day7 = date('Y-m-d', time() - 7*86400);
	$day1 = date('Y-m-d', time() - 86400); 
	$day = date('Y-m-d');
	
	$query = [
	
		// törlés
		'DELETE FROM ig_activity_index;',
	
		// havi
		"INSERT INTO ig_activity_index(UID, Month, Added)
		(SELECT
			p.ID,
			a.Ido,
			CURRENT_DATE
		FROM playerek AS p LEFT JOIN ig_activity AS a ON (p.ID = a.UID)
		WHERE a.Datum >= '$day30' AND a.Datum < '$day7' AND p.UtoljaraAktiv > $unix30)
		ON DUPLICATE KEY UPDATE Month = Month + VALUES(Month)",
	
		// heti + maradék havi
		"INSERT INTO ig_activity_index(UID, Month, Week, Added)
		(SELECT
			p.ID,
			a.Ido,
		    a.Ido,
			CURRENT_DATE
		FROM playerek AS p LEFT JOIN ig_activity AS a ON (p.ID = a.UID)
		WHERE a.Datum >= '$day7' AND a.Datum < '$day' AND p.UtoljaraAktiv > $unix30)
		ON DUPLICATE KEY UPDATE Month = Month + VALUES(Month), Week = Week + VALUES(Week)"
		
	];

	foreach($query as $q)
	{
		$mysql -> query($q);
	}
	
	$legaktivabbak = [
		'Month' => [],
		'Week' => [],
		'Day' => []
	];
	
	// ------------------------- \\
	// legaktívabbak statisztika \\
	// ------------------------- \\
	
	// havi aktivitás
	$mysql -> query('
		SELECT playerek.ID, playerek.Nev, ig_activity_index.Month
		FROM playerek INNER JOIN ig_activity_index ON (playerek.ID = ig_activity_index.UID)
		ORDER BY ig_activity_index.Month DESC LIMIT 10
	');
	
	while($d = $mysql -> assoc())
		$legaktivabbak['Month'][] = [ $d['ID'], $d['Nev'], $d['Month'] ];
	
	// heti aktivitás
	$mysql -> query('
		SELECT playerek.ID, playerek.Nev, ig_activity_index.Week
		FROM playerek INNER JOIN ig_activity_index ON (playerek.ID = ig_activity_index.UID)
		ORDER BY ig_activity_index.Week DESC LIMIT 10
	');
	
	while($d = $mysql -> assoc())
		$legaktivabbak['Week'][] = [ $d['ID'], $d['Nev'], $d['Week'] ];
	
	// tegnapi aktivitás
	$mysql -> query("
		SELECT playerek.ID, playerek.Nev, ig_activity.Ido
		FROM playerek INNER JOIN ig_activity ON (playerek.ID = ig_activity.UID)
		WHERE Datum = '$day1'
		ORDER BY ig_activity.Ido DESC LIMIT 10
	");
	
	while($d = $mysql -> assoc())
		$legaktivabbak['Day'][] = [ $d['ID'], $d['Nev'], $d['Ido'] ];
	
	$mysql -> query('UPDATE server SET Ertek = "' . mysql_real_escape_string(json_encode($legaktivabbak)) . '" WHERE Nev="Aktivitas"');
}

if($ora == 0)
{
	// 3 napja be nem lépettek és a havi 1 órát el nem érők pénzének csökkentése 10 millió felett
	$mysql -> query('SELECT ID, Nev, Bank, UtoljaraAktiv FROM playerek WHERE Bank > 1111111 AND UtoljaraAktiv < ' . (time() - 86400*3) . ' AND Online = "0" ORDER BY Bank ASC');
	if($mysql -> num())
	{
		$osszlevonas = 0;
		$erintett = 0;
		$logs = '<table><tr><td>Név</td><td>Bankszámla</td><td>Levonás</td><td>Aktivitás (Havi)</td><td>Utolsó belépés</td></tr>';
		while($data = $mysql -> assoc())
		{
			$r = $mysql -> query('SELECT Month FROM ig_activity_index WHERE UID = ' . $data['ID'], false);
			if($mysql -> num($r))
				$index = $mysql -> assoc($r);
			else
				$index = null;

			if($index === null || $index['Month'] < 3600)
			{
				$levonas = round($data['Bank'] * 0.10);
				$osszlevonas += $levonas;
				$erintett ++;
				
				$mysql -> query('UPDATE playerek SET Bank = Bank - ' . $levonas . ' WHERE ID = "'. $data['ID'] .'"', false);
				
				$logs .=
					'<tr>
						<td>' . $data['Nev'] . '</td>
						<td>' . number_format($data['Bank']) . 'Ft</td>
						<td>' . number_format($levonas) . 'Ft</td>
						<td>' . ($index === null ? 0 : $index['Month']) . '</td>
						<td>' . date('Y-m-d H:i:s', $data['UtoljaraAktiv']) . '</td>
					</tr>'
				;
			}
		}
		
		$logs .= '</table>';
		
		$logs = '<h1>Összes levonás: ' . number_format($osszlevonas) . 'Ft (' . number_format($erintett) . 'db érintett játékos)</h1>'
				. '<h3>'.date('Y-m-d H:i').'</h3>'
				. $logs;
		
		$fh = fopen('/var/www/usercp/logs/activity_10/'.date('YmdHis').'.html', 'w');
		fwrite($fh, $logs);
		fclose($fh);
	}
}

echo "CRON feladat kesz";

?>