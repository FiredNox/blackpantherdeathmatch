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
	$mysql -> query("DELETE FROM ig_activity_index");

echo "CRON feladat kesz";

?>