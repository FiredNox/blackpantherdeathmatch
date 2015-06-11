<style type="text/css">
body
{
	background-color: #202020;
	color: white;
}
a, a:visited
{
	color: yellow;
}
a:hover
{
	color: lightblue;
	font-weight: bold;
}
</style>

<?php
if(isset($_GET["o"]) && is_numeric($_GET["o"]) && $_GET["o"] >= 2 && $_GET["o"] < 100)
	$o = $_GET["o"];
else
	$o = 1;

$fajlok = 0;
if ($handle = opendir('.')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && strpos($file, ".jpg") !== false)
			$fajlok++;
    }
    closedir($handle);
}

$peroldal = 9;
$persor = 3;

$oldalak = floor($fajlok / $peroldal);
$db = 0;
$mettol = ($o-1) * $peroldal + 1;
$meddig = $o * $peroldal;
$kepmeret = 350;
echo "<center>";

if($o == 1)
	echo "<< Előző oldal";
else
	echo "<a href='?o=".($o-1)."'><< Előző oldal</a>";

echo " | ";

if($o == $oldalak)
	echo "Következő oldal >>";
else
	echo "<a href='?o=".($o+1)."'>Következő oldal >></a>";

echo "<br><br>";

for($x = 1; $x <= $oldalak; $x++)
{
	if($x > 1) echo ", ";
	echo ($x != $o ? "<a href='?o=".$x."'>".$x."</a>" : $x);
}

echo "<br><br>";

$fileok = Array();

/*if ($handle = opendir('.')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && strpos($file, ".jpg") !== false) {
			$db++;
			if($db < $mettol) continue;
			if($db > $meddig) break;
            //echo $file."<br><img src='".$file."' width='400'>";
			echo "<img src='".$file."' width='".$kepmeret."'>";
			if($db % $persor == 0) echo "<br>";
        }
    }
    closedir($handle);
}*/

if ($handle = opendir('.')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && strpos($file, ".jpg") !== false) {
			$fileok[] = $file;
        }
    }
    closedir($handle);
}

sort($fileok);

foreach($fileok AS $file)
{
	$db++;
	if($db < $mettol) continue;
	if($db > $meddig) break;
	echo "<img src='".$file."' width='".$kepmeret."' title='".$file."'>";
	if($db % $persor == 0) echo "<br>";
}

echo "<br><br>";

for($x = 1; $x <= $oldalak; $x++)
{
	if($x > 1) echo ", ";
	echo ($x != $o ? "<a href='?o=".$x."'>".$x."</a>" : $x);
}

echo "<br><br>";

if($o == 1)
	echo "<< Előző oldal";
else
	echo "<a href='?o=".($o-1)."'><< Előző oldal</a>";

echo " | ";

if($o == $oldalak)
	echo "Következő oldal >>";
else
	echo "<a href='?o=".($o+1)."'>Következő oldal >></a>";

echo "</center>";
?>