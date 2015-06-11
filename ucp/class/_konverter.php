<?
require_once('include/main.php');
if(!IsClint())
	Error();
?>
<div><a href="?j">Játékos</a>, <a href="?h">Ház</a>, <a href="?r">Raktár</a>, <a href="?fk">Frakciókocsi</a>, <a href="?mk">Munkakocsi</a></div>
<?
if(isset($_GET['j']))
{
	$f = isset($_GET['f']) ? $_GET['f'] : 0;

	$db = 0;
	$fromdate = time() - 180*86400;

	$sql = mysql_query("SELECT ID FROM playerek WHERE UtoljaraAktiv > $fromdate ORDER BY ID DESC LIMIT 1");
	$last = mysql_fetch_assoc($sql);
	$last = $last['ID'];

	$sql = mysql_query("SELECT ID, KilepesFegyver, KilepesLoszer FROM playerek WHERE ID > $f AND UtoljaraAktiv > $fromdate ORDER BY ID ASC LIMIT 300");
	while($data = mysql_fetch_array($sql))
	{
		$f = $data['ID'];

		if(strpos($data['KilepesLoszer'], ':') === false)
		{
			$weps = explode(",", $data['KilepesFegyver']);
			$amms = explode(",", $data['KilepesLoszer']);
			$to = min(count($weps), count($amms));

			$newweps = [];
			$newamms = [];

			for($i = 0; $i < $to; $i++)
			{
				$newweps[] = $weps[$i];
				$newamms[] = $weps[$i].':'.$amms[$i];
			}

			$newweps = implode(',', $newweps);
			$newamms = implode(',', $newamms);

			mysql_query("UPDATE playerek SET KilepesFegyver = '$newweps', KilepesLoszer = '$newamms' WHERE ID = '$f'");
		}
		$db++;
	}

	if($db)
		echo "<a href='?j&f=$f'>Tovább... ($f / $last --- ".($last - $f).")</a>";
}
else if(isset($_GET['h']))
{
	$f = isset($_GET['f']) ? $_GET['f'] : -1;

	$db = 0;

	$sql = mysql_query("SELECT ID FROM hazak ORDER BY ID DESC LIMIT 1");
	$last = mysql_fetch_assoc($sql);
	$last = $last['ID'];

	$sql = mysql_query("SELECT ID, Fegyverek, Loszerek FROM hazak WHERE ID > $f ORDER BY ID ASC LIMIT 100");
	while($data = mysql_fetch_array($sql))
	{
		$f = $data['ID'];

		if(strpos($data['Loszerek'], ':') === false)
		{
			$weps = explode(",", $data['Fegyverek']);
			$amms = explode(",", $data['Loszerek']);
			$to = min(count($weps), count($amms));

			$newweps = [];
			$newamms = [];

			for($i = 0; $i < $to; $i++)
			{
				$newweps[] = $weps[$i];
				$newamms[] = $weps[$i].':'.$amms[$i];
			}

			$newweps = implode(',', $newweps);
			$newamms = implode(',', $newamms);

			mysql_query("UPDATE hazak SET Fegyverek = '$newweps', Loszerek = '$newamms' WHERE ID = '$f'");
		}
		$db++;
	}

	if($db)
		echo "<a href='?h&f=$f'>Tovább... ($f / $last --- ".($last - $f).")</a>";
}
else if(isset($_GET['r']))
{
	$path = $config['Mappa'] . '/scriptfiles/Config/raktar.cfg';

	if(!file_exists($path))
		exit("Nem létezik: $path");

	$f = fopen($path, 'r');
	if(!$f)
		exit("Megnyitás sikertelen: $path");
	
	$data = fread($f, filesize($path));
	fclose($f);
	
	$lines = explode("\n", $data);
	
	$frakcio = 1;
	while($frakcio <= 21)
	{
		$fpath = $config['Mappa'] . '/scriptfiles/data/fegyverraktar/' . $frakcio . '.ini';
		echo '<div>' . $fpath . '</div>';
		
		if(file_exists($fpath))
			unlink($fpath);
		
		$wepsamms = explode(',', $lines[$frakcio-1]);
		$newweps = [];
		$newamms = [];
		for($i = 0; $i < count($wepsamms); $i++)
		{
			if($i < 50)
				$newweps[] = 'Weapon_' . $i . ' = ' . $wepsamms[$i];
			else
				$newamms[] = 'Ammo_' . ($i-50) . ' = ' . $wepsamms[$i-50] . ',' . $wepsamms[$i];
		} 
		
		$fp = fopen($fpath, 'w');
		
		foreach($newweps as $nwep)
		{
			fwrite($fp, $nwep . "\r\n");
		}
		
		foreach($newamms as $namm)
		{
			fwrite($fp, $namm . "\r\n");
		}
		
		fclose($fp);

		$frakcio++;
	}
}
else if(isset($_GET['fk']))
{
	$frakcio = 1;
	while($frakcio <= 21)
	{
		$fpath = $config['Mappa'] . '/scriptfiles/Config/FrakcioKocsi/' . $frakcio . '.cfg';
		echo '<div>' . $fpath . '</div>';
		
		if(file_exists($fpath))
		{
			$f = fopen($fpath, 'r');

			$lines = explode("\n", fread($f, filesize($fpath)));
			
			for($k = 0; $k < count($lines); $k++)
			{
				$data = explode(',', $lines[$k]);
				if(count($data) < 10 || $data[0] < 300)
					continue;
				
				$wdata = [];
				$wdata[] = 'Model = ' . $data[0];
				$wdata[] = 'Pos = ' . $data[1] . ',' . $data[2] . ',' . $data[3] . ',' . $data[4] . ',' . $data[8] . ',' . $data[7];
				$wdata[] = 'Szin = ' . $data[5] . ',' . $data[6];
				$wdata[] = 'Rang = ' . $data[9];
				$wdata[] = 'Matrica = ' . $data[13];
				$wdata[] = 'Kasztni = ' . $data[14];
				$wdata[] = 'Kerek = ' . $data[15];
				$wdata[] = 'Hidraulika = ' . $data[16];
				
				$fk = fopen($config['Mappa'] . '/scriptfiles/Config/FrakcioKocsi/' . $frakcio . '_' . $k . '.car', 'w');
				fwrite($fk, implode("\r\n", $wdata) . "\r\n");
				fclose($fk);
			}
			
			fclose($f);

			echo "OK";
		}
		else
			echo "Hiba";

		$frakcio++;
	}
}
else if(isset($_GET['mk']))
{
	$munka = 22;
	while($munka <= 30)
	{
		$fpath = $config['Mappa'] . '/scriptfiles/Config/MunkaKocsi/' . $munka . '.cfg';
		echo '<div>' . $fpath . '</div>';

		if(file_exists($fpath))
		{
			$f = fopen($fpath, 'r');

			$lines = explode("\n", fread($f, filesize($fpath)));
				
			for($k = 0; $k < count($lines); $k++)
			{
				$data = explode(',', $lines[$k]);
				if(count($data) < 5 || $data[0] < 300)
					continue;

				$wdata = [];
				$wdata[] = 'Model = ' . $data[0];
				$wdata[] = 'Pos = ' . $data[1] . ',' . $data[2] . ',' . $data[3] . ',' . $data[4] . ',' . $data[8] . ',' . $data[7];
				$wdata[] = 'Szin = ' . $data[5] . ',' . $data[6];

				$fk = fopen($config['Mappa'] . '/scriptfiles/Config/MunkaKocsi/' . $munka . '_' . $k . '.car', 'w');
				fwrite($fk, implode("\r\n", $wdata) . "\r\n");
				fclose($fk);
			}
				
			fclose($f);

			echo "OK";
		}
		else
			echo "Hiba";

		$munka++;
	}
}