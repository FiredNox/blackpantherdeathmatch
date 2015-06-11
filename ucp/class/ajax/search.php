<?
define("MAIN_SKIP_CHECK", 1);
require_once("include/main.php");

$t = isset($_POST["t"]) ? $_POST["t"] : false;
$w = isset($_POST["w"]) ? $mysql -> escape($_POST["w"]) : false;

$ret = array();
$ret["status"] = "unknown";

if($t && $w) {
	if($t == "karakter" && strlen($w) >= 3 && strlen($w) <= 24) {
		$mysql -> query("SELECT Nev FROM playerek WHERE Nev LIKE '%$w%' ORDER BY Nev ASC LIMIT 11");
		
		$num = $mysql -> num();
		
		if($num > 10)
			$ret["status"] = "many";
		else if($num == 0)
			$ret["status"] = "not";
		else {
			$ret["status"] = "ok";
			$ret["found"] = array();
			
			while($d = $mysql -> object()) {
				$ret["found"][] = $d -> Nev;
			}
		}
	}
}

die(json_encode($ret));

?>