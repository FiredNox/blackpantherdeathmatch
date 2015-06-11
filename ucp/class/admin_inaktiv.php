<?
require_once("include/main.php");

if(!$jatekos["Belepve"] || $jatekos["Admin"] < 1)
	Error();

Fejlec();

$e = file_exists("scripter_inaktiv.html");
$t = filemtime("scripter_inaktiv.html");
$m = time() - 86400;

echo "<center><h1>Inaktivitási lista".(IsClint() ? " <a href='scripter_inaktiv".$config["Ext"]."'>E</a>" : "")."</h1>";

if($e && $t > $m)
	echo "<i>Generálva: <b>".date("Y-m-d H:i:s", $t)."</b></i><br><br>";

echo "<table width='75%' class='tcenter'><tr><td width='65%'>Név</td><td width='20%'>Utolsó belépés</td><td width='15%'>Havi aktivitás</td></tr>";

if($e) {
	if($t > $m) {
		echo file_get_contents("scripter_inaktiv.html");
	} else {
		echo "<tr><td colspan='3'>A jelenlegi inaktivitási lista elavult</td></tr>";
	}
} else
	echo "<tr><td colspan='3'>Jelenleg nincs generálva inaktivitási lista</td></tr>";

echo "</table></center>";

Lablec();
?>