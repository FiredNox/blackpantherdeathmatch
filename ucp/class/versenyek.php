<?
require_once("include/main.php");

set_time_limit(60);

function urites($dir) { 
  if (is_dir($dir)) { 
    $objects = scandir($dir); 
    foreach ($objects as $object) { 
      if ($object != "." && $object != "..") { 
        if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
      } 
    } 
    reset($objects); 
  }
}

function StringToPos($pos)
{
	global $p;
	$pos = explode(",", $pos);
	$pos[0] = (3000 + $pos[0]) / $p;
	$pos[1] = (3000 - $pos[1]) / $p;
	return $pos;
}

function imageboldline($resource, $x1, $y1, $x2, $y2, $Color, $BoldNess=2) 
{
    $x1 -= ($buf=ceil(($BoldNess-1) /2));
    $x2 -= $buf;
    for($i=0;$i < $BoldNess;++$i)
        imageline($resource, $x1 +$i, $y1, $x2 +$i, $y2, $Color);
}

Fejlec();

$meretek = Array("600" => 1, "1200" => 2, "3000" => 3);
if(isset($_GET["keszit"]) && $jatekos["Nev"] == "Clint")
{
	ini_set('memory_limit', '64M');
	if(isset($_GET["snev"]))
	{
		$id = $_GET["snev"];
		foreach($meretek as $kepmeret)
		{
			if(file_exists("img/".$kepmeret.".jpg"))
				unlink("img/".$kepmeret.".jpg");
		}
	}
	else urites("img/verseny");

	if(!isset($id)) $sql_res = mysql_query("SELECT * FROM versenyek ORDER BY nev");
	else $sql_res = mysql_query("SELECT * FROM versenyek WHERE SNev='".$id."'");

	while($verseny = mysql_fetch_array($sql_res))
	{
		echo $verseny["Nev"]." generálása...<br>";
		foreach($meretek as $kepmeret => $vonalmeret){
		//$ujx = 600;
		//$ujy = 600;
		//$uj = imagecreatetruecolor($ujx, $ujy);

		$im		=	imagecreatefromjpeg("img/".$kepmeret.".jpg");

		$fekete	=	imagecolorallocate($im, 0, 0, 0);
		$kek	=	imagecolorallocate($im, 200, 200, 255);
		$zold	=	imagecolorallocate($im, 0, 255, 0);
		$piros	=	imagecolorallocate($im, 255, 0, 0);

		$feher	=	imagecolorallocate($im, 255, 255, 255);
		$sarga	=	imagecolorallocate($im, 255, 255, 0);

		$width	=	imagesx($im);
		$height	=	imagesy($im);
		$p		=	6000 / $width;

		$mx = 100 / $p;
		$my = 50 / $p;

		$szin_utvonal = $piros;
		$szin_cp_1 = imagecolorallocate($im, 200, 200, 255);
		$szin_cp_2 = imagecolorallocate($im, 255, 200, 200);
		$szin_cp_3 = imagecolorallocate($im, 200, 255, 200);

		$meret = 100 / $p / 1.33;
		$betu = "include/font/arialbd.ttf";

		$cp_db = $verseny["Checkpointok"];
		$start = StringToPos($verseny["Start"]);
		$cel = StringToPos($verseny["Cel"]);
		if($cp_db > 0) for($cp = $cp_db-1; $cp >= 0; $cp--)
		{
			$pos = StringToPos($verseny["CK".$cp]);
			if($cp == 0)
			{
				if($cp_db == 1)
				{
					imageboldline($im, $start[0], $start[1], $pos[0], $pos[1], $szin_utvonal, $vonalmeret);
					imageboldline($im, $pos[0], $pos[1], $cel[0], $cel[1], $szin_utvonal, $vonalmeret);
				}
				else
					imageboldline($im, $start[0], $start[1], $pos[0], $pos[1], $szin_utvonal, $vonalmeret);
			}
			else if($cp == ($cp_db-1))
			{
				$pose = StringToPos($verseny["CK".($cp-1)]);
				imageboldline($im, $pose[0], $pose[1], $pos[0], $pos[1], $szin_utvonal, $vonalmeret);
				imageboldline($im, $pos[0], $pos[1], $cel[0], $cel[1], $szin_utvonal, $vonalmeret);
			}
			else
			{
				$pose = StringToPos($verseny["CK".($cp-1)]);
				imageboldline($im, $pose[0], $pose[1], $pos[0], $pos[1], $szin_utvonal, $vonalmeret);
			}
		}
		else
			imageboldline($im, $start[0], $start[1], $cel[0], $cel[1], $szin_utvonal, $vonalmeret);

		//imagefilledrectangle($im, $x - $mx - 15/$p, $y - $my - 50/$p, $x - $mx + 240/$p, $y - $my + 30/$p, $fekete);
		//imagestring($im, 5, $x-$mx, $y-$my-45/$p, "START", $zold);
		//imagettftext($im, $meret, 0, $x-$mx, $y-$my+20/$p, $szin, $betu, "START");

		//imagettftext($im, $meret, 0, $start[0]-$mx-150/$p, $start[1]-$my+20/$p, $zold, $betu, "START");
		imagettftext($im, $meret, 0, $start[0]-$mx-160/$p, $start[1]-$my+10/$p, $sarga, $betu, "START");

		//imagefilledrectangle($im, $x2 - $mx + 30/$p, $y2 - $my - 45/$p, $x2 - $mx + 145/$p, $y2 - $my + 30/$p, $fekete);
		//imagestring($im, 5, $x2-$mx+45/$p, $y2-$my-45/$p, "CP", $zold);
		//imagettftext($im, $meret, 0, $x2-$mx+50/$p, $y2-$my+20/$p, $szin, $betu, "CP");
		//imagettftext($im, $meret, 0, $x2-$mx+50/$p, $y2-$my+20/$p, $szin_cp, $betu, "1");
		if($cp_db > 0) for($cp = 0; $cp < $cp_db; $cp++)
		{
			$pos = StringToPos($verseny["CK".$cp]);
			//imagettftext($im, $meret * 0.8, 0, $pos[0]-$mx+100/$p, $pos[1]-$my+20/$p, $sarga, $betu, "(".($cp+1).")");
			imagettftext($im, $meret * 0.2 + ($cp * $meret * 0.01), 0, $pos[0]-$mx+90/$p, $pos[1]-$my+40/$p, ($cp % 3 == 0 ? $szin_cp_1 : ($cp % 3 == 1 ? $szin_cp_2 : $szin_cp_3)), $betu, "".($cp+1)."");
		}

		//imagefilledrectangle($im, $x3 - $mx + 15/$p, $y3 - $my - 50/$p, $x3 - $mx + 170/$p, $y3 - $my + 30/$p, $fekete);
		//imagestring($im, 5, $x3-$mx+30/$p, $y3-$my-45/$p, "CEL", $zold);
		//imagettftext($im, $meret, 0, $x3-$mx+50/$p, $y3-$my+20/$p, $szin, $betu, "CEL");
		//imagettftext($im, $meret, 0, $cel[0]-$mx-70/$p, $cel[1]-$my+200/$p, $zold, $betu, "CEL");
		imagettftext($im, $meret, 0, $cel[0]-$mx-80/$p, $cel[1]-$my+190/$p, $sarga, $betu, "CEL");

		//imagecopyresampled($uj, $im, 0, 0, 0, 0, $ujx, $ujy, $width, $height);

		imagejpeg($im, "img/verseny/".$verseny["SNev"]."_".$kepmeret.".jpg", 100);
		//imagejpeg($uj, "img/teljesterkep_x.jpg", 100);
		//imagedestroy($uj);
		imagedestroy($im);
	}} mysql_free_result($sql_res);
}

?>

<style type="text/css">
	table{
		border-spacing:0px; }
	td.clear, .cleartr td, .cleartable tr td{
		border: none; }
	.adatok{
		padding: 5px; }
	.adatok hr{
		color:grey; }
	.left{
		text-align: left; }
	img.link{
		cursor: crosshair; }
	img.link:hover{
		cursor: pointer; }
	table.karakter_infok tr td
	{
		text-align:left;
	}
	table.karakter_infok tr td.cim
	{
		font-weight:bold;
		font-size: 125%;
		color:white;
		text-align:center;
		padding: 5px;
		border: none;
	}
	td
	{
		border: 2px outset #444;
		padding: 1px;
		vertical-align: middle;
		text-align:center;
		background-color: #202020;
	}
	.cleartr_jatekos td
	{
		border-top: none;
		border-left: none;
		padding: 0px;
	}
	.cim
	{
		color:white;
		font-weight:bold;
	}
	a.no
	{
		text-decoration:none;
		font-weight:bold;
	}
	.bal, .jobb
	{
		padding: 3px;
	}
</style>

<script type="text/javascript">
function Nyit(mit)
{
	if($("#"+mit).css("display") == "none")
	{
		$("#"+mit).css("display", "inline");
		$("#kep_"+mit).attr("src", "img/minus.gif");
	}
	else
	{
		$("#"+mit).css("display", "none");
		$("#kep_"+mit).attr("src", "img/plus.gif");
	}
}
</script>

<? if(isset($uzenet)) echo Felhivas($uzenet);
echo '<center><h1><a href="versenyek'.$config["Ext"].'">Versenyek</a>'.($jatekos["Nev"] == "Clint" ? " - <a href='?keszit'>Készít</a>" : "").'</h1></center>';

if(!isset($_GET["keszit"])){ $sql_res = mysql_query("SELECT Nev, SNev, Checkpointok FROM versenyek ORDER BY nev"); while($verseny = mysql_fetch_array($sql_res))
{
	echo "<h2><span class='kez' onclick='Nyit(\"".$verseny["SNev"]."\")'><img src='img/plus.gif' id='kep_".$verseny["SNev"]."'> ".$verseny["Nev"]." ".($jatekos["Nev"] == "Clint" ? "(<b style='color: yellow'>".$verseny["Checkpointok"]."</b> CP)" : "")."</span></h2>";
	echo "<div style='display: none' id='".$verseny["SNev"]."'>Méretek: <a href='img/verseny/".$verseny["SNev"]."_600.jpg' target='_BLANK'>600x600</a>, <a href='img/verseny/".$verseny["SNev"]."_1200.jpg' target='_BLANK'>1200x1200</a>, <a href='img/verseny/".$verseny["SNev"]."_3000.jpg' target='_BLANK'>3000x3000</a> ".($jatekos["Admin"] >= 1337 ? "Azonosító: <b>".$verseny["SNev"]."</b>" : "")." ".($jatekos["Nev"] == "Clint" ? "<a href='?keszit&snev=".$verseny["SNev"]."'>Generál</a>" : "")."<br>";
	echo "<img src='img/verseny/".$verseny["SNev"]."_600.jpg'><br><br></div>";
}mysql_free_result($sql_res);}

?>

<? Lablec(); ?>