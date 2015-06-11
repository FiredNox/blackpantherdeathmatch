<?php
session_start();

define("MAIN_BETOLTVE", "1");
if(!defined("CONFIG_BETOLTVE")) require_once("include/config.php");

require_once("include/funkciok.php");
require_once($config["Path"]["class"]."/mysql.class.php");

set_time_limit(10);

$mysql = new MySQL();
if(!$mysql -> connected) exit("A szerver jelenleg nem elérhető, próbáld meg később.");

$SeeGlobal = Array();

if(!defined("MAIN_SKIP_CHECK")) {

$jatekos = Array("Belepve" => false, "Nev", "ID", "Jelszo", "Karakterek" => 0, "Karakter" => Array(), "Admin" => 0, "Kivalasztva" => 0, "Letrehozas" => 0, "Letrehozando", "Bannolva" => false);
//if(isset($_COOKIE[$config["CookieName"]["name"]]))
	
if(isset($_SESSION['LoginData']['ID']))
{
	//$id = $_COOKIE[$config["CookieName"]["name"]];
	//$pass = $_COOKIE[$config["CookieName"]["pass"]];
	$id = $_SESSION['LoginData']['ID'];
	$pass = $_SESSION['LoginData']['Pass'];
	
	if($id == 1 && !$_SESSION['LoginData']['Clint']) {
		unset($_SESSION['LoginData']);
		exit;
	}
	
	$jatekos["Jelszo"] = $pass;

	$sql = mysql_query("SELECT * FROM accountok WHERE id = '".$id."' and jelszo = '".$pass."'");
	if(mysql_num_rows($sql) == 1)
	{
		$data_a = mysql_fetch_array($sql); mysql_free_result($sql);
		mysql_query("UPDATE accountok SET UtoljaraAktiv='".date("Y-m-d H:i:s")."', UtoljaraLatott='".$config["Lap"]."' WHERE ID='".$data_a["ID"]."'");
		$jatekos["Belepve"] = true;
		$jatekos["Nev"] = $data_a["Nev"];
		$jatekos["Mail"] = $data_a["Mail"];
		$jatekos["ID"] = $data_a["ID"];
		$jatekos["Letrehozas"] = $data_a["Letrehozas"];
		$jatekos["Tarsitas"] = $data_a["Tarsitas"];
		$jatekos["Teszt"] = $data_a["Teszt"];
		$jatekos["CInfo"] = strlen($data_a["CInfo"]);
		if($jatekos["Letrehozas"] != 0) $jatekos["Letrehozando"] = explode(",", $data_a["Letrehozando"]);
		if($jatekos["Tarsitas"] != 0) $jatekos["Tarsitando"] = explode(",", $data_a["Tarsitando"]);

		if($data_a["Karakter1"] == 0 && $data_a["Karakter2"] > 0)
		{
			$data_a["Karakter1"] = $data_a["Karakter2"];
			mysql_query("UPDATE accountok SET Karakter1 = '".$data_a["Karakter2"]."', Karakter2='0' WHERE id='".$data_a["ID"]."'");
		}

		if($data_a["Karakterek"] == 0 && $data_a["Karakter1"] > 0 ||
		   $data_a["Karakterek"] == 0 && $data_a["Karakter2"] > 0 ||
		   $data_a["Karakterek"] == 1 && $data_a["Karakter1"] > 0 && $data_a["Karakter2"] > 0)
		{
			$data_a["Karakterek"] = 0;
			if($data_a["Karakter1"] > 0) $data_a["Karakterek"]++;
			if($data_a["Karakter2"] > 0) $data_a["Karakterek"]++;
		}

		if($data_a["Karakterek"] > 0)
		{
			if(isset($_extramezok))
			{
				$_extramezok_t = $_extramezok;
			
				if(is_array($_extramezok))
					$_extramezok = implode(",", $_extramezok);
				else
					$_extramezok_t = Array($_extramezok);
				
				if($_extramezok != '')
					$_extramezok = ',' . $_extramezok;
			}
			else
				$_extramezok = "";
			
			if($data_a["Karakter1"] > 0)
			{

				$sql = mysql_query("SELECT Nev, Pass, Admin, Online, Leader, Member, Swat, SwatRang, SSS, Model, Bank, Bankszamla, Szint, Respect, Tutorial, Autoker, Szerelo, Hitman $_extramezok FROM playerek WHERE ID = '".$data_a["Karakter1"]."'");
				if(mysql_num_rows($sql) == 1)
				{
					$data_k = mysql_fetch_array($sql);
					$jatekos["Karakter"][0]["ID"] = $data_a["Karakter1"];
					$jatekos["Karakter"][0]["Nev"] = $data_k["Nev"];
					$jatekos["Karakter"][0]["Jelszo"] = $data_k["Pass"];
					$jatekos["Karakter"][0]["Online"] = $data_k["Online"];
					$jatekos["Karakter"][0]["Member"] = $data_k["Member"];
					$jatekos["Karakter"][0]["Leader"] = $data_k["Leader"];
					$jatekos["Karakter"][0]["SSS"] = $data_k["SSS"];
					$jatekos["Karakter"][0]["Autoker"] = $data_k["Autoker"];
					$jatekos["Karakter"][0]["Szerelo"] = $data_k["Szerelo"];
					$jatekos["Karakter"][0]["Swat"] = $data_k["Swat"];
					$jatekos["Karakter"][0]["SwatRang"] = $data_k["SwatRang"];
					$jatekos["Karakter"][0]["Model"] = $data_k["Model"];
					$jatekos["Karakter"][0]["Bank"] = $data_k["Bank"];
					$jatekos["Karakter"][0]["Bankszamla"] = explode(",", $data_k["Bankszamla"]);
					$jatekos["Karakter"][0]["Szint"] = $data_k["Szint"];
					$jatekos["Karakter"][0]["Respect"] = $data_k["Respect"];
					$jatekos["Karakter"][0]["Tutorial"] = $data_k["Tutorial"];
					$jatekos["Karakter"][0]["Hitman"] = $data_k["Hitman"];

					
					if($data_k["Admin"] > 0)
						$jatekos["LogNev"] = $data_k["Nev"];

					if($_extramezok != "")
					{
						foreach($_extramezok_t as $mezo)
							$jatekos["Karakter"][0][$mezo] = $data_k[$mezo];
					}

					$jatekos["Karakterek"] = 1;
					if(is_numeric($data_k["Admin"]) && $data_k["Admin"] > $jatekos["Admin"]) $jatekos["Admin"] = $data_k["Admin"];
				}
			}
			if($data_a["Karakter2"] > 0)
			{
				$sql = mysql_query("SELECT Nev, Pass, Admin, Online, Leader, Member, Swat, SwatRang, SSS, Model, Bank, Bankszamla, Szint, Respect, Tutorial, Autoker, Szerelo, Hitman $_extramezok FROM playerek WHERE ID = '".$data_a["Karakter2"]."'");
				if(mysql_num_rows($sql) == 1)
				{
					$data_k = mysql_fetch_array($sql);
					$jatekos["Karakter"][1]["ID"] = $data_a["Karakter2"];
					$jatekos["Karakter"][1]["Nev"] = $data_k["Nev"];
					$jatekos["Karakter"][1]["Jelszo"] = $data_k["Pass"];
					$jatekos["Karakter"][1]["Online"] = $data_k["Online"];
					$jatekos["Karakter"][1]["Member"] = $data_k["Member"];
					$jatekos["Karakter"][1]["Leader"] = $data_k["Leader"];
					$jatekos["Karakter"][1]["SSS"] = $data_k["SSS"];
					$jatekos["Karakter"][1]["Autoker"] = $data_k["Autoker"];
					$jatekos["Karakter"][1]["Szerelo"] = $data_k["Szerelo"];
					$jatekos["Karakter"][1]["Swat"] = $data_k["Swat"];
					$jatekos["Karakter"][1]["SwatRang"] = $data_k["SwatRang"];
					$jatekos["Karakter"][1]["Model"] = $data_k["Model"];
					$jatekos["Karakter"][1]["Bank"] = $data_k["Bank"];
					$jatekos["Karakter"][1]["Bankszamla"] = explode(",", $data_k["Bankszamla"]);
					$jatekos["Karakter"][1]["Szint"] = $data_k["Szint"];
					$jatekos["Karakter"][1]["Respect"] = $data_k["Respect"];
					$jatekos["Karakter"][1]["Tutorial"] = $data_k["Tutorial"];
					$jatekos["Karakter"][1]["Hitman"] = $data_k["Hitman"];
					

					if($data_k["Admin"] > 0)
						$jatekos["LogNev"]  = $data_k["Nev"];

					if($_extramezok != "")
					{
						foreach($_extramezok_t as $mezo)
							$jatekos["Karakter"][1][$mezo] = $data_k[$mezo];
					}

					$jatekos["Karakterek"] = 2;
					if(is_numeric($data_k["Admin"]) && $data_k["Admin"] > $jatekos["Admin"]) $jatekos["Admin"] = $data_k["Admin"];
				}
			}
            if(isset($_COOKIE[$config["CookieName"]["karakter"]]))
            {
			    if($_COOKIE[$config["CookieName"]["karakter"]] == 1 && $jatekos["Karakterek"] > 0)
				    $jatekos["Kivalasztva"] = 1;
			    elseif($_COOKIE[$config["CookieName"]["karakter"]] == 2 && $jatekos["Karakterek"] > 1)
				    $jatekos["Kivalasztva"] = 2;
            }
		}
		if($jatekos["Karakterek"] != $data_a["Karakterek"])
		{
			if($jatekos["Karakterek"] == 0)
				mysql_query("UPDATE accountok SET Karakterek = '0', Karakter1 = '0', Karakter2 = '0' WHERE ID='".$data_a["ID"]."'");
			elseif($jatekos["Karakterek"] == 1)
				mysql_query("UPDATE accountok SET Karakterek = '1', Karakter1 = '".$jatekos["Karakter"][0]["ID"]."', Karakter2 = '0' WHERE ID='".$data_a["ID"]."'");
			elseif($jatekos["Karakterek"] == 2)
				mysql_query("UPDATE accountok SET Karakterek = '2', Karakter1 = '".$jatekos["Karakter"][0]["ID"]."', Karakter2 = '".$jatekos["Karakter"][1]["ID"]."' WHERE ID='".$data_a["ID"]."'");
		}
		if(Bannolva())
			$jatekos["Bannolva"] = true;

		if($jatekos["Kivalasztva"] != 0) $jatekos["AK"] = $jatekos["Karakter"][$jatekos["Kivalasztva"] - 1];
		else $jatekos["AK"] = -1;
	}
	unset($nev, $pass, $data_a, $data_k);
}

/*if(IsClint() || defined("MINDEN_HIBA"))
{
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}*/

if($jatekos["Admin"] && !$jatekos["CInfo"] && $config["Lap"] != "kapcsolat")
{
	echo "Töltsd ki a kapcsolat oldalon a Segítség oszlopot, azaz, hogy miben tudsz segíteni. Link: <a href='kapcsolat".$config['Ext']."'>KATT</a>";
	exit;
}

}
?>