<?
require_once("include/main.php");
require_once("include/statinfo.php");
Fejlec();

$szerkeszt = 0;

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["a"]) && $jatekos["Admin"] >= 1337)
{
	$a = $_POST["a"]; $m = $_POST["m"]; $p = $_POST["p"];
	$h = addslashes(str_replace(" ", "", $_POST["h"]));
	$n = addslashes($_POST["n"]);

	if($a == "uj" && is_numeric($m) && is_numeric($p))
	{
		$use = explode(",", $h); sort($use); $h = implode(",", $use);
		$elozo = 0; $hiba = 0;

		for($x = 0; $x < count($use); $x++)
		{
			if($x > 0 && $use[$x] == $elozo) { $hiba = 1; break; }
			if($use[$x] < -1 || $use[$x] > count($config["Frakciok"])) { $hiba = 2; break; }
			if($use[$x] > 0 && in_array($use[$x], $config["NemLetezoFrakciok"])) { $hiba = 3; break; }
			if(!is_numeric($use[$x])) { $hiba = 4; break; }
			$elozo = $use[$x];
		}

		if($hiba == 1)
			$uzenet = "A használók között egy számot többször adtál meg";
		elseif($hiba == 2)
			$uzenet = "A használók között hibás számot adtál meg";
		elseif($hiba == 3)
			$uzenet = "A használók között egy olyan frakciót adtál meg, mely törölve van";
		elseif($hiba == 4)
			$uzenet = "A használók között csak számot adhatsz meg";
		elseif($m < 400 || $m > 611)
			$uzenet = "Hibás model";
		else
		{
			$sql = mysql_query("SELECT Model FROM jarmu_arak WHERE Model = '".$m."'");
			if(mysql_num_rows($sql))
				{$uzenet = "Ez a model már be van jegyezve"; mysql_free_result($sql);}
			else
			{
				mysql_query("INSERT INTO jarmu_arak(Model, Nev, Ara, Hasznalo) VALUES('".$m."', '".$n."', '".$p."', '".$h."'");
				$uzenet = "Model hozzáadva! Model: ".$m." | Név: ".$n." | Ára: ".$p."Ft | Használók: ".$h."";
			}
		}
	}
	elseif($a == "sz" && is_numeric($m) && is_numeric($p))
	{
		$use = explode(",", $h); sort($use); $h = implode(",", $use);
		$elozo = 0; $hiba = 0;

		for($x = 0; $x < count($use); $x++)
		{
			if($x > 0 && $use[$x] == $elozo) { $hiba = 1; break; }
			if($use[$x] < -1 || $use[$x] > count($config["Frakciok"])) { $hiba = 2; break; }
			if($use[$x] > 0 && in_array($use[$x], $config["NemLetezoFrakciok"])) { $hiba = 3; break; }
			if(!is_numeric($use[$x])) { $hiba = 4; break; }
			$elozo = $use[$x];
		}

		if($hiba == 1)
			$uzenet = "A használók között egy számot többször adtál meg";
		elseif($hiba == 2)
			$uzenet = "A használók között hibás számot adtál meg";
		elseif($hiba == 3)
			$uzenet = "A használók között egy olyan frakciót adtál meg, mely törölve van";
		elseif($hiba == 4)
			$uzenet = "A használók között csak számot adhatsz meg";
		elseif($m < 400 || $m > 611)
			$uzenet = "Hibás model";
		else
		{
			$sql = mysql_query("SELECT Model FROM jarmu_arak WHERE Model = '".$m."'");
			if(!mysql_num_rows($sql))
				{$uzenet = "Nincs ilyen model bejegyezve"; mysql_free_result($sql);}
			else
			{
				mysql_query("UPDATE jarmu_arak SET Nev = '".$n."', Ara = '".$p."', Hasznalo = '".$h."' WHERE Model='".$m."'");
				$uzenet = "Model frisítve! Model: ".$m." | Név: ".$n." | Ára: ".$p."Ft | Használók: ".$h."";
			}
		}
	}
}
if(isset($_GET["e"]) && is_numeric($_GET["e"]) && $jatekos["Admin"] >= 1337)
{
	$sql = mysql_query("SELECT * FROM jarmu_arak WHERE Model = '".$_GET["e"]."'");
	if(mysql_num_rows($sql))
	{
		$szerkeszt = 1;
		$sz = mysql_fetch_array($sql);
		mysql_free_result($sql);
	}
}

?>

<style type="text/css">
table.jarmuvek tr td { text-align: center; }</style>

<script type="text/javascript">
var open = false;
function Kep(kell, mihez)
{
	if(!mihez) for(var k = 400; k <= 611; k++)
	{
		$('#kep_'+k).css("display", (kell === true ? "inline" : "none"));
		$('#nokep_'+k).css("display", (kell === true ? "none" : "inline"));
	}
	else
	{
		$('#kep_'+mihez).css("display", (kell === true ? "inline" : "none"));
		$('#nokep_'+mihez).css("display", (kell === true ? "none" : "inline"));
	}
}
function nyit(mit)
{
	if(open) return 1;
	if(document.getElementById(mit+"_div").style.display != "none")
	{
		$("#"+mit+"_div").slideToggle(1000, function() { open = false; });
		document.getElementById(mit+"_img").src = "img/plus.gif";
		open = true;
	}
	else
	{
		$("#"+mit+"_div").slideToggle(1000, function() { open = false; });
		document.getElementById(mit+"_img").src = "img/minus.gif";
		open = true;
	}
}
</script>

<? if(isset($uzenet)) echo Felhivas($uzenet); ?>

<center><h1>Jármű lista</h1>

<? if($jatekos["Admin"] >= 1337) { ?>

<table width='75%' class='jarmuvek'><tr><td> <h3>Hozzáadás / Szerkesztés</h3><br>

<form method="POST"><input type="hidden" name="a" value='<?=($szerkeszt ? "sz" : "uj")?>'>
<?
if(!$szerkeszt)
{
	echo'Model: <select name="m">';
	for($m = 400; $m <= 611; $m++)
	{
		if($szerkeszt && $sz["Model"] == $m)
			echo "<option value='".$m."' selected>".$m."</option>";
		else
			echo "<option value='".$m."'>".$m."</option>";
	}
	echo'</select>';
}
else
	echo "<img src='img/car/".$sz["Model"].".jpg'><br><br>Model: <b>".$sz["Model"]."</b><input type='hidden' name='m' value='".$sz["Model"]."'><br>";
?><br>
Név: <input type="text" name="n" value='<?=($szerkeszt ? $sz["Nev"] : "Model neve")?>'><br>
Ára: <input type="text" name="p" value='<?=($szerkeszt ? $sz["Ara"] : "5000000")?>'><br>
Használhatja: <input type="text" name='h' value='<?=($szerkeszt ? $sz["Hasznalo"] : "0")?>'><br>
<font size='1'>Mj.: Ha mindenki: 0, ha senki: -1,<br>ellenkező esetben a frakció IDjei vesszővel elválasztva, pl.: 1,2,3</font><br>
<br>
<input type="submit" value="Go!"> <?=($szerkeszt ? "<a href='?'>Mégse</a>" : "")?>
</form>

</td></tr></table>

<br><br>

<span class="kez" onclick="nyit('frakciolista')"><img src="img/plus.gif" id="frakciolista_img"> Frakciók</span>
<div id="frakciolista_div" style="display:none">
<table><tr><td>ID</td><td>Név</td></tr>
<?
foreach($config["Frakciok"] as $fid => $fnev)
{
	if(in_array($fid, $config["NemLetezoFrakciok"]))
		echo "<tr class='nopadding'><td>".$fid."</td><td><font color='red'>".$fnev."</font></td></tr>";
	else
		echo "<tr class='nopadding'><td>".$fid."</td><td>".$fnev."</td></tr>";
}
?>
</table>
</div>
<br><br>

<? } ?>

<a href='javascript: void(0);' onclick='Kep(true)'>Képpel</a> - <a href='javascript: void(0);' onclick='Kep(false)'>Kép nélkül</a>

<br><br>

<table width='90%' class='jarmuvek'>
	<tr>
		<td width='10%'>Model</td>
		<td width='22%'>Név</td>
		<td width='18%'>Ára</td>
		<td width='20%'>Kép</td>
		<td width='20%'>Használhatja</td>
	</tr>
<?
$sql = mysql_query("SELECT Model, Nev, Ara, Hasznalo FROM jarmu_arak ORDER BY model ASC");
if(mysql_num_rows($sql))
{
	while($k = mysql_fetch_array($sql))
	{
		$model = $k["Model"];
		if($jatekos["Admin"] >= 1337)
			$model = "<a href='?e=".$k["Model"]."'>".$model."</a>";

		$use = explode(",", $k["Hasznalo"]);

		$veheto = $use[0] != -1 && $k['Ara'] > 0;

		if(!$veheto) $hasznalo = "";
		elseif($use[0] == 0) $hasznalo = "Bárki";
		else
		{
			$emberek = Array();
			foreach($use as $frakcio)
			{
				$emberek[] = $config["Frakciok"][$frakcio];
			}
			$hasznalo = implode(", ", $emberek);
		}
		echo "
		<tr>
			<td>".$model."</td>
			<td>".$k["Nev"]."</td>
			<td>".(!$veheto ? "<i style='font-size: 10px'>Nem vehető</i>" : "<b>".number_format($k["Ara"])."Ft</b>") ."</td>
			<td>
				<div id='kep_".$k["Model"]."' style='display: none'><img src='img/car/".$k["Model"].".jpg' onclick='Kep(false, ".$k["Model"].");'></div>
				<div id='nokep_".$k["Model"]."' style='display: inline' onclick='Kep(true, ".$k["Model"].");'>Mutasd</div>
			</td>
			<td>".$hasznalo."</td></tr>";
	}
	mysql_free_result($sql);
}
else
	echo "<tr><td colspan='5'>Nincs bejegyzett jármű</td></tr>";
?>
</table>
</center>

<? Lablec(); ?>