<?
require_once("include/main.php");

if(!$jatekos['Admin']) exit;

$a = isset($_POST["a"]) ? $_POST["a"] : "";
$b = isset($_POST["b"]) ? $_POST["b"] : "";

$ret = array();

if($a == "load") {
	$ret["html"] = "";
	
	$ret["html"] .= "<select onChange='adminFrakciokezelo(\"change\", $(this).val())' class='center-block' style='margin-bottom: 10px'>";
	$ret["html"] .= "<option disabled selected>===[ Válassz frakciót ]===</option>";
	
	foreach($config["Frakciok"] as $id => $nev) {
		//if(in_array($id, $config["NemLetezoFrakciok"])) continue;
		
		$ret["html"] .= "<option value='$id'>$nev</option>";
	}
	
	$ret["html"] .= "</select>";
	
	$ret["html"] .= "<div id='admin-frakciokezelo-ajax'></div>";
} elseif($a == "fload" && is_numeric($b) && $b >= 1 && $b <= count($config["Frakciok"])) {
	
	require_once($config["Path"]["class"] . "/aktivitas.class.php");
	
	$id = $b;
	$nev = $config["Frakciok"][$id];
	
	$ret["html"] = "<h2 style='text-align: center; margin-top:10px;'>$nev <span class='link' onclick='adminFrakciokezelo(\"reload\")' style='font-size: 13px'>Újratölt</span></h2>";
	
	$ret["html"] .= "<center>Keresés: <input id='qm_frakcio_tag'>";
	$ret["html"] .= " <div id='qm_frakcio_tag_nev' style='display: inline'>Várakozás...</div> "; 
	$ret["html"] .= "<input type='button' onClick='adminFrakciokezelo(\"invite\")' value='Felvesz'>";
	$ret["html"] .= "<div id='qm_frakcio_tag_ac'></div></center><br><br>";
	
	$ret["html"] .= "<form id='qm_frakcio'>";
	$ret["html"] .= "<table width='95%' class='center tcenter'>";
	$ret["html"] .= "<tr class='cim nopadding'>
						<td width='20%'>Név</td>
						<td width='10%'>Rang</td>
						<td width='20%'>Utolsó belépés</td>
						<td width='10%'>Aktivitás</td>
						<td width='19%'>Tagság</td>
						<td width='7%'>Rang</td>
						<td width='7%'>Leader</td>
						<td width='7%'>Kirúg</td>
					</tr>";
	
	$db = $mysql -> query("SELECT ID, Nev, Rank, UtoljaraAktiv, Leader, Member, Online, Felvetel FROM playerek WHERE Member = '$id' ORDER BY Leader DESC, Rank DESC, Nev ASC", false);
	if(!$db)
		$ret["html"] .= "<tr><td colspan='5'><i>Nincs tagja a frakciónak</i></td></tr>";
	else
	{		
		while($player = $mysql -> object($db))
		{
			$leader = $player->Leader == $player->Member ? 1 : 0;
			$ret["html"] .= "<tr class='nopadding'>
							<td>" . $player -> Nev . "</td>
							<td>" . ($leader ? "LEADER" : $player -> Rank) . "</td>
							<td>" . ($player -> Online ? "<b style='color: cyan'>Online</b>" : $_stat -> UtoljaraAktiv($player -> UtoljaraAktiv)) . "</td>
							<td>" . $_stat -> ActivityIndex($player -> ID) . "</td>
							<td>" . date('Y-m-d H:i', $player -> Felvetel) . "</td>
							<td>
								<label style='display: block'>
									<input type='checkbox' name='qm_frakcio_rang[]' value='".$player -> ID."'>
									<input type='hidden' id='qm_frakcio_rang_".$player -> ID."' value='".$player->Rank."'>
								</label>
							</td>
							<td>
								<label style='display: block'>
									<input type='checkbox' name='qm_frakcio_leader[]' value='".$player -> ID."' ".($leader ? "checked" : "").">
								</label>
								<input type='hidden' id='qm_frakcio_leader_".$player -> ID."' value='$leader'>
							</td>
							<td><label style='display: block'><input type='checkbox' name='qm_frakcio_kirug[]' value='".$player -> ID."'></label></td>
						</tr>";
		}
	}
	
	$opts = "<option value='-1' disabled selected></option>";
	for($x = 0; $x <= 12; $x++) {
		$opts .= "<option value='$x'>$x</option>";
	}
	
	$ret["html"] .= "<tr>
		<td colspan='4' class='clear'></td>
		<td><select id='qm_frakcio_rang'>$opts</select></td>
		<td colspan='2'><input type='button' onClick='adminFrakciokezelo(\"manage\")' value='Mehet'></td>
	</tr>";
	
	$ret["html"] .= "</table>";
	$ret["html"] .= "</form>";
} elseif($a == "manage" && $b != "") {
	$rang = isset($b["rang"]) ? $b["rang"] : false;
	$leader = isset($b["leader"]) ? $b["leader"] : false;
	$kirug = isset($b["kirug"]) ? $b["kirug"] : false;
	
	$ret["msg"] = "";
	
	if($rang && isset($rang["ki"]) && isset($rang["rang"]) && count($rang["ki"]) && is_numeric($rang["rang"]) && $rang["rang"] >= 0 && $rang["rang"] < 99) {
		foreach($rang["ki"] as $p) {
			if(!is_numeric($p)) continue;
			
			$mysql -> query("SELECT Nev, Rank FROM playerek WHERE ID='$p' AND Online='0'");
			if($mysql -> num()) {
				$d = $mysql -> object();
				$res = $mysql -> update("playerek", array("Rank" => $rang["rang"]), "ID='$p'");
				
				if($res) {
					$ret["msg"] .= $d -> Nev ." rangja módosítva (". $d -> Rank ." > ". $rang["rang"] .")\n";
					SeeLOG("kszerk", "<b class='kiemelt'>".$jatekos["Nev"]."</b> módosította <b class='kiemelt'>".$d -> Nev."</b> rangját! (".$d->Rank." -> ".$rang['rang'].")", $jatekos["ID"], $jatekos["Nev"], 1);
				}
			}
		}
	}
	
	if($leader && count($leader)) {
		if(strlen($ret["msg"])) $ret["msg"] .= "\n";
		
		foreach($leader as $p => $l) {
			if(!is_numeric($p) || !is_numeric($l)) continue;
			
			$mysql -> query("SELECT Nev, Member FROM playerek WHERE ID='$p' AND Online='0'");
			if($mysql -> num()) {
				$d = $mysql -> object();
				
				$res = $mysql -> update("playerek", array("Leader" => ($l ? $d -> Member : 0)), "ID='$p'");
				
				if($res) {
					$ret["msg"] .= $d -> Nev ." ".($l ? "berakva frakcióleadernek" : "leadere elvéve")."\n";
					SeeLOG("kszerk", "<b class='kiemelt'>".$jatekos["Nev"]."</b> módosította <b class='kiemelt'>".$d -> Nev."</b> leaderét: ".($l ? $d -> Member : 0), $jatekos["ID"], $jatekos["Nev"], 1);
				}
			}
		}
	}
	
	if($kirug && count($kirug)) {
		if(strlen($ret["msg"])) $ret["msg"] .= "\n";
		
		foreach($kirug as $p) {
			if(!is_numeric($p)) continue;
			
			$mysql -> query("SELECT Nev FROM playerek WHERE ID='$p' AND Online='0'");
			if($mysql -> num()) {
				$d = $mysql -> object();
				
				$res = $mysql -> update("playerek", array("Leader" => 0, "Member" => 0, "Rank" => 0), "ID='$p'");
				
				if($res)
					$ret["msg"] .= $d -> Nev ." kirúgva a frakcióból\n";
			}
		}
	}
} elseif($a == "invite" && $b != "" && isset($b["nev"]) && isset($b["frakcio"]) && is_numeric($b["frakcio"])) {
	$nev = $mysql -> escape($b["nev"]);
	$frakcio = $b["frakcio"];
	
	$mysql -> query("SELECT Nev, Member, Online FROM playerek WHERE Nev='$nev'");
	if($mysql -> num()) {
		$d = $mysql -> object();
		
		if($d -> Online)
			$ret["status"] = "online";
		elseif($d -> Member && $d -> Member == $frakcio) {
			if($d -> Member == $frakcio)
				$ret["status"] = "already";
			/*else
				$ret["status"] = "other";*/
		} else {
			$ret["status"] = ($d -> Member ? "invitedfrom" : "invited");
			$mysql -> update("playerek", array("Member" => $frakcio, "Leader" => 0, "Rank" => 0), "Nev='$nev'");
		}
	}
}

die(json_encode($ret));
?>