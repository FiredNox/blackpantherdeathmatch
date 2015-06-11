<?php 
require_once("include/main.php");

if(!$jatekos['Belepve'] || $jatekos['Admin'] < 1338 && !$config['Amos'])
	Error();

Fejlec();

$fhely = $config['Mappa'] . '/scriptfiles/Config/terfigyelo_rejtekhely.cfg';
if(file_exists($fhely) && ($d = file_get_contents($fhely)) != false)
{
	echo '<link rel="stylesheet" type="text/css" href="css/imgareaselect-animated.css"/>';
	echo '<script type="text/javascript" src="js/jQuery.imgareaselect.pack.js"></script>';
	
	echo '<script type="text/javascript" src="js/admin_rejtekhely.js"></script>';
	echo '<div id="rejtek_dialog"><img src="img/6000.jpg"></div>';
	
	$lines = explode("\n", trim($d));
	$db = count($lines);
	
	echo "Rejtekhelyek: {$db}db<br><br>";
	
	echo '<div id="rejtek_helyek" style="font-family: courier">';
	
	$id = 1;
	foreach($lines as $line)
	{
		$pos = explode(',', $line);
		
		if(count($pos) != 4)
			continue;
		
		echo "<div id='rejtek_{$id}'>
			<b>".str_replace(' ', '&nbsp;', sprintf("%2d", $id))."</b> -
			 MinX: <input type='text' size='10' value='{$pos[0]}'/>
			 MinY: <input type='text' size='10' value='{$pos[1]}'/>
			 MaxX: <input type='text' size='10' value='{$pos[2]}'/>
			 MaxY: <input type='text' size='10' value='{$pos[3]}'/>
			 <a href='javascript: void(0)'>Törlés</a>
		</div>";
			
		$id++;
	}
	
	echo '</div>';
	
	echo '<br><button id="rejtek_save">Mentés</button><button id="rejtek_new">Hozzáadás</button>';

	echo ' Státusz: <div id="ajax" style="font-weight: bold; display: inline;"></div>';
	
	echo '<br><img id="terkep" src="img/terkep_rejtekhelyek.jpg" style="width: 100%">';
}
else
	echo 'A fájl nem létezik';

Lablec();
?>