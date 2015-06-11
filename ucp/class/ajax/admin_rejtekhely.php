<?php
require_once('include/main.php');
if($jatekos['Admin'] < 1337) exit;

function KepGeneralas($d)
{
	$dir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR;
	
	$img = new Imagick($dir . '6000.jpg');
	
	$draw = new ImagickDraw();
	
	foreach($d['areas'] as $k => $area)
	{
		foreach($area as $ak => $av)
		{
			if(in_array($ak, array('MinY', 'MaxY')))
				$d['areas'][$k][$ak] = 6000 - ($av + 3000);
			else
				$d['areas'][$k][$ak] = 3000 + $av;
		}
		
		$area = $d['areas'][$k]; 
		
		// téglalap
		$draw -> setfillcolor('#ffffff'); //ff5500
		$draw -> setfillopacity(0.6);
		//$draw -> setstrokecolor('#ffffff');
		//$draw -> setstrokewidth(3);
		$draw -> setstrokeopacity(0.0);
		
		$draw -> rectangle($area['MinX'], $area['MinY'], $area['MaxX'], $area['MaxY']);
		
		// szöveg
		/*$draw -> setfillcolor('#ffffff');
		$draw -> setfillopacity(1.0);
		$draw -> settextalignment(2);
		$draw -> setfontfamily('Arial');
		$draw -> setfontsize(200);
		$draw -> settextantialias(true);
		$draw -> setstrokecolor('#883300');
		$draw -> setstrokewidth(10);
		$draw -> setstrokeopacity(1.0);
		
		$text = (string)($k+1);
		$fontprop = $img -> queryfontmetrics($draw, $text);

		$w = $area['MaxX'] - $area['MinX'];
		$h = $area['MaxY'] - $area['MinY'];
		
		//$fx = $area['MinX'] + $w/2;// - $fontprop['textWidth'] / 2;
		//$fy = $area['MinY'] + $h/2 + $fontprop['textHeight'] / 3;
		
		$fx = $area['MinX'] + $w/2;
		$fy = $area['MaxY'] - 20;
		
		$draw -> annotation($fx, $fy, $text);*/
	}
	
	$img -> drawimage($draw);
	$img -> writeimage($dir . 'terkep_rejtekhelyek.jpg');
}

$r = [];
$r['msg'] = 'Hiba';

if(isset($_POST['areas']) && is_array($_POST['areas']))
{
	$lines = '';
	$areas = [];
	foreach($_POST['areas'] as $area)
	{
		if(!is_array($area) || count($area) != 4
			|| !is_numeric($area['MinX']) || !is_numeric($area['MinY']) || !is_numeric($area['MaxX']) || !is_numeric($area['MaxY']))
			continue;
		
		$areas[] = $area;
		
		$lines .= implode(',', $area) . PHP_EOL;
	}
	
	$f = fopen($config['Mappa'].DIRECTORY_SEPARATOR.'scriptfiles'.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'terfigyelo_rejtekhely.cfg', 'w');
	fwrite($f, $lines);
	fclose($f);
	
	$r['msg'] = 'Sikeres mentés';
	
	KepGeneralas(['areas' => $areas]);
}

echo json_encode($r);
?>