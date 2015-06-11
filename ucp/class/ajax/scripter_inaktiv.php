<?
define("MAIN_SKIP_CHECK", 1);
require_once("include/main.php");

$all = isset($_POST["all"]) ? $_POST["all"] : false;
$curr = isset($_POST["curr"]) ? $_POST["curr"] : false;
$ido = isset($_POST["ido"]) ? $_POST["ido"] : false;

$ret = array();

$max = 30;

if($all && is_numeric($all) && $curr && is_numeric($curr) && $ido && is_numeric($ido)) {

	$t30 = time() - 86400 * 30;
	$ti = $ido * 60;

	if($all == -1) {
		$mysql -> query("SELECT ID FROM playerek WHERE UtoljaraAktiv >= $t30");
		$all = $mysql -> num();

		$ret["stat"] = $all > 0 ? 0 : 2;

		if(file_exists("scripter_inaktiv.html"))
			unlink("scripter_inaktiv.html");
	}

	if($all) {

		if($curr < 0) $curr = 0;

		$pSQL = $mysql -> query("SELECT ID, Nev, UtoljaraAktiv, Szint FROM playerek WHERE UtoljaraAktiv >= $t30 ORDER BY ID ASC LIMIT $curr,$max");

		require_once($config["Path"]["class"] . "/aktivitas.class.php");

		if(!isset($fh))
			$fh = fopen("scripter_inaktiv.html", "a");

		while($max && $p = $mysql -> object($pSQL)) {
			$pid = $p -> ID;
			
			$akt = $_stat -> ActivityIndex($pid, $p -> UtoljaraAktiv, false, false);
				
			if($akt["Month"] < $ti) {
				
				$hSQL = $mysql -> query("SELECT ID FROM hazak WHERE TulajID = $pid"); $h = $mysql -> num($hSQL);
				$cSQL = $mysql -> query("SELECT ID FROM kocsik WHERE TulajID = $pid"); $c = $mysql -> num($cSQL);
				$bSQL = $mysql -> query("SELECT ID FROM bizek WHERE TulajID = $pid"); $b = $mysql -> num($bSQL);
				
				if($h || $c || $b) {
					if($akt["Month"] < 60)
						$ido = $akt["Month"] . "mp";
					else if($akt["Month"] < 3600)
						$ido = round($akt["Month"] / 60, 1) . "p";
					else
						$ido = round($akt["Month"] / 3600, 1) . "ó";
					
					$extra = "";
					
					if($h) $extra .= " - HÁZ";
					if($c) $extra .= " - KOCSI";
					if($b) $extra .= " - BIZNISZ";
	
					fwrite($fh, "<tr><td>". $p->Szint ." <a href='jatekosok".$config["Ext"]."?keres=" . $p -> Nev . "' target='_BLANK'>" . $p -> Nev . "</a>$extra</td><td>" . date("Y-m-d H:i", $p -> UtoljaraAktiv) . "</td><td>$ido</td></tr>");
				}
			}
				
			$curr++;
			$max--;
		}

		if(!isset($ret["stat"]))
			$ret["stat"] = $all > $curr ? 1 : 2;

	}

	if(isset($fh)) {
		fclose($fh);
	}

	$ret["all"] = $all;
	$ret["curr"] = $curr;
}

die(json_encode($ret));

?>