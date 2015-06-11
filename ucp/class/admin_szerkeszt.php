<?
require_once("include/main.php");

if(!$jatekos["Belepve"] || !CheckAdmin() && !IsScripter() && !$config['Amos'])
	Error();

	
	
	
if(isset($_GET["ajax"]))
{
	##########################################################################################################################################
	if(isset($_GET["torol"]))
	{
		$sql = mysql_query("SELECT ID, Online, Nev, Szint, ConnectedTime, Bank, Admin, ASJog, Age, Origin, Sex, Jailed, JailTime, JailOK, Member, Leader, ASTiltas, FrakcioTiltas, JogsiTiltas, Premium, LeaderTiltas, FegyverTiltas, AdminUzenet FROM playerek WHERE id='".$_POST["id"]."'");

		if(mysql_num_rows($sql) != 1)
			Lablec(false, "Nincs ilyen játékos", true);

		$kari = mysql_fetch_array($sql); mysql_free_result($sql);

		if($kari["Online"] == "1")
			Lablec(false, "Ez a játékos jelenleg Online, nem törölhető!", true);
		
		//Lablec(false, "Fejlesztés alatt!", true);

		


		$sql = mysql_query("INSERT INTO torolt_playerek Select * FROM playerek WHERE id='".$_POST["id"]."'");
		
		if($sql)
		{
			$uzenetek[] = "Karakter törölve: ".$kari["Nev"]."!";

			$adminlogok[] = "Karakter törölve (UID:".$kari["ID"]." = NÉV:".$kari["Nev"].")";

			$adminlogok[] = "Karakter törölve: ".$kari["Nev"]."!";
			
			echo implode("\n", $uzenetek);
			SeeLOG("kszerk", "<b class='kiemelt'>".$jatekos["LogNev"]."</b> törölte <b class='kiemelt'>".$kari["Nev"]."</b> karakterét. <b class='kiemelt'>Műveletek:</b> ".implode(", ", $adminlogok), $jatekos["ID"], $jatekos["LogNev"], 1);

			$sql = mysql_query("DELETE FROM playerek WHERE id='".$_POST["id"]."'");
		}
		else
			Lablec(false, "Hiba történt az adatok biztonsági mentésében! HIBA:".mysql_error(), true);
		
	}
	if(isset($_GET["kick"]))
	{
		$sql = mysql_query("SELECT ID, Online, Nev, Szint, ConnectedTime, Bank, Admin, ASJog, Age, Origin, Sex, Jailed, JailTime, JailOK, Member, Leader, ASTiltas, FrakcioTiltas, JogsiTiltas, Premium, LeaderTiltas, FegyverTiltas, AdminUzenet FROM playerek WHERE id='".$_POST["id"]."'");

		if(mysql_num_rows($sql) != 1)
			Lablec(false, "Nincs ilyen játékos", true);

		$kari = mysql_fetch_array($sql); mysql_free_result($sql);

		if($kari["Online"] != "1")
			Lablec(false, "Ez a játékos jelenleg NEM Online, nem kickelhető!", true);

		if(isset($_POST["id"]))
		{
			$sql = mysql_query("INSERT INTO cmd (cmd, e1, e2) VALUES ('5', '".$_POST["id"]."', '".$jatekos["LogNev"]."')");
			
			$unix = time();
			$banido = $unix+300;
			$sql = mysql_query("INSERT INTO bans(Cim, Ido, Orok, Bannolta, Oka, Datum) VALUES('".$kari["Nev"]."', '".$banido."', 'n', '".$jatekos["LogNev"]."', 'UCPKick: karakter szerkesztés.', '".$unix."')");

			$keresek[] = "Kick = '".$kari["Nev"]."'";
			$uzenetek[] = "Kick beküldve: ".$kari["Nev"]." és banolva 5 percre";
			$adminlogok[] = "Kickelés (UID:".$kari["ID"]." = NÉV:".$kari["Nev"].")";

			$adminlogok[] = "Kick beküldve, kick-elve: ".$kari["Nev"]." és banolva 5 percre!";
			
			echo implode("\n", $uzenetek);
			SeeLOG("kszerk", "<b class='kiemelt'>".$jatekos["LogNev"]."</b> szerkesztette <b class='kiemelt'>".$kari["Nev"]."</b> karakterét. <b class='kiemelt'>Műveletek:</b> ".implode(", ", $adminlogok), $jatekos["ID"], $jatekos["LogNev"], 1);

			/*if($sql)
				Lablec(false, "KICK beküldve!", true);
			else
				Lablec(false, "Hiba!", true);*/
		}
	}
	if(isset($_GET["ment"]))
	{
		if(!isset($_POST["id"]) || !is_numeric($_POST["id"]))
			Lablec(false, "Fuckkkkkkk babyyyyyyyy (Y)", true);

		require_once("include/statinfo.php");

		//$nevek = Array("jelszo", "nem", "kor", "szar", "jail", "bankszamla", "szszam", "bank", "penz", "muany", "cser", "mak", "can", "mati", "kok", "her", "mar");

		$sql = mysql_query("SELECT ID, Online, Nev, Szint, ConnectedTime, Bank, Admin, ASJog, Age, Origin, Sex, Jailed, JailTime, JailOK, Member, Leader, ASTiltas, FrakcioTiltas, JogsiTiltas, Premium, LeaderTiltas, FegyverTiltas, AdminUzenet FROM playerek WHERE id='".$_POST["id"]."'");

		if(mysql_num_rows($sql) != 1)
			Lablec(false, "Nincs ilyen játékos", true);

		$kari = mysql_fetch_array($sql); mysql_free_result($sql);
		if($kari["Online"] == "1")
			Lablec(false, "Ez a játékos jelenleg Online, nem szerkeszthető!", true);

		$keresek = Array();
		$uzenetek = Array();
		$adminlogok = Array();

		$kari["ASTiltas"] = explode("@", $kari["ASTiltas"]);
		$kari["FrakcioTiltas"] = explode("@", $kari["FrakcioTiltas"]);
		$kari["JogsiTiltas"] = explode("@", $kari["JogsiTiltas"]);
		$kari["Premium"] = explode(",", $kari["Premium"]);
		$kari["LeaderTiltas"] = explode("@", $kari["LeaderTiltas"]);
		$kari["FegyverTiltas"] = explode("@", $kari["FegyverTiltas"]);
		$kari["AdminUzenet"] = explode("@", $kari["AdminUzenet"]);
		
		if($jatekos["Admin"] >= 1337 && isset($_POST["ppont"]) && is_numeric($_POST["ppont"]) && $_POST["ppont"] >= 0)
		{
			$old = $kari["Premium"][1];
			$kari["Premium"][1] = $_POST["ppont"];
			$keresek[] = "Premium = '".implode(",", $kari["Premium"])."'";
			$uzenetek[] = "P.Pont megváltoztatva: ".$_POST["ppont"];
			$adminlogok[] = "ppontváltás (".$old." > ".$_POST["ppont"].")";
		}

		if($jatekos["Admin"] >= 1337 && isset($_POST["nev"]) && $_POST["nev"] != $kari["Nev"])
		{
			if(!RolePlayNev($_POST["nev"]))
				AjaxExit("Nem RolePlay név");

			if($mysql -> query_num("SELECT ID FROM playerek WHERE Nev='".$_POST['nev']."'")) {
				AjaxExit('A név foglalt: ' . $_POST['nev']);
			}
			
			$keresek[] = "Nev = '".$_POST["nev"]."'";
			$uzenetek[] = "Név megváltoztatva: ".$_POST["nev"];
			$adminlogok[] = "névváltás (".$kari["Nev"]." > ".$_POST["nev"].")";

			mysql_query('UPDATE bans SET Cim="'.$_POST['nev'].'" WHERE Cim="'.$kari['Nev'].'"');
			mysql_query("INSERT INTO nevvaltas(KID, AID, ANev, Regi, Uj, Elfogadva, Elbiralva, Datum)
			VALUES('".$kari["ID"]."', '".$jatekos["ID"]."', '".$jatekos["LogNev"]."', '".$kari["Nev"]."', '".$_POST["nev"]."', 'i', 'i', '".date("Y-m-d H:i:s")."')");
		}

		if(isset($_POST["admin"]) && is_numeric($_POST["admin"]))
		{
			if( $config['Amos'] ||
				$jatekos["Admin"] < 1337 ||
				$jatekos["Admin"] >= 1337 && $jatekos["Admin"] <= 1339 && $kari["Admin"] > 5 ||
				$jatekos["Admin"] < 5555 && $kari["Admin"] > 1339)
				Lablec(false, "Nincs elég jogosultságod az adminisztrátori jog módosításához", true);

			if( $jatekos["Admin"] < 1337 ||
				$jatekos["Admin"] < 1338 && $_POST["admin"] > 5 ||
				$jatekos["Admin"] < 1340 && $_POST["admin"] > 1339)
				Lablec(false, "Ekkora jogot nem adhatsz neki", true);

			$keresek[] = "Admin = '".$_POST["admin"]."'";
			$uzenetek[] = "Adminjog megváltoztatva: ".$_POST["admin"]."";
			$adminlogok[]  = "adminjog váltás (".$kari["Admin"]." > ".$_POST["admin"].")";
		}
		if(($jatekos["Admin"] >= 1340 ||  IsScripter() || $config['Amos']) && isset($_POST["user_data"]))
		{
			$keresekII = true;
			$filename = "/games/samp/teszt/scriptfiles/data/user/".$_POST["id"].".ini";
			file_put_contents($filename,$_POST["user_data"]);
			
			$uzenetek[] = "UserData megváltoztatva: scriptfiles/data/user/".$_POST["id"].".ini";

			$adminlogok[] = "UserData megváltoztatva: scriptfiles/data/user/".$_POST["id"].".ini";
		
		}
		if($jatekos["Admin"] >= 3 && isset($_POST["admin_uzenet"]) && is_numeric($_POST["admin_uzenet"]) && !is_float($_POST["admin_uzenet"]) && $_POST["admin_uzenet"] >= 0)
		{
			
			$keresek[] = "AdminUzenet = '".$_POST["admin_uzenet"]."@".$_POST["admin_uzenet_ok"]."'";
			$uzenetek[] = "Admin uzenet megváltoztatva: ".($_POST["admin_uzenet"] == 0 ? "üzenet törölve" : "Üzenet elküldve (tartalom: ".$_POST["admin_uzenet_ok"].")");

			$adminlogok[] = "AdminÜzenet megváltoztatva: ".($kari["AdminÜzenet"][0] == 0 ? "törölve" : "Üzenet elküldve (oka: ".$kari["AdminUzenet"][1].")") . " > " . ($_POST["admin_uzenet"] == 0 ? "uzenet torolve" : "uzenet kuldve (oka: ".$_POST["admin_uzenet_ok"].")");
		}
		if($jatekos["Admin"] >= 1337 || $config['Amos'] && isset($_POST["tilt_as"]) && is_numeric($_POST["tilt_as"]) && !is_float($_POST["tilt_as"]) && $_POST["tilt_as"] >= 0)
		{
			$keresek[] = "ASTiltas = '".$_POST["tilt_as"]."@".$_POST["tilt_as_ok"]."'";
			$uzenetek[] = "ASTiltás megváltoztatva: ".($_POST["tilt_as"] == 0 ? "tiltás levéve" : "örökre eltiltva (oka: ".$_POST["tilt_as_ok"].")");
			$adminlogok[] = "ASTiltás megváltoztatva: ".($kari["ASTiltas"][0] == 0 ? "nincs tiltva" : "eltiltva (oka: ".$kari["ASTiltas"][1].")") . " > " . ($_POST["tilt_as"] == 0 ? "tiltás levéve" : "örökre eltiltva (oka: ".$_POST["tilt_as_ok"].")");
		}

		if($jatekos["Admin"] >= 1337 && isset($_POST["tilt_frakcio"]) && is_numeric($_POST["tilt_frakcio"]) && !is_float($_POST["tilt_frakcio"]) && $_POST["tilt_frakcio"] >= 0)
		{
			$keresek[] = "FrakcioTiltas = '".$_POST["tilt_frakcio"]."@".$_POST["tilt_frakcio_ok"]."'";
			$uzenetek[] = "FrakcióTiltás megváltoztatva: ".$_POST["tilt_frakcio_ok"]."(".$_POST["tilt_frakcio"]."ó)";
			$adminlogok[] = "FrakcióTiltás megváltoztatva: ".$kari["FrakcioTiltas"][1]."(".$kari["FrakcioTiltas"][0]."ó) > ".$_POST["tilt_frakcio_ok"]."(".$_POST["tilt_frakcio"]."ó)";
		}
		//új LeaderTiltas
		if($jatekos["Admin"] >= 1337 || $config['Amos'] && isset($_POST["tilt_leader"]) && is_numeric($_POST["tilt_leader"]) && !is_float($_POST["tilt_leader"]) && $_POST["tilt_leader"] >= 0)
		{
		
			$keresek[] = "LeaderTiltas = '".$_POST["tilt_leader"]."@".$_POST["tilt_leader_ok"]."'";
			$uzenetek[] = "LeaderTiltás megváltoztatva: ".($_POST["tilt_leader"] == 0 ? "tiltás levéve" : "örökre eltiltva (oka: ".$_POST["tilt_leader_ok"].")");
			$adminlogok[] = "LeaderTiltás megváltoztatva: ".($kari["LeaderTiltas"][0] == 0 ? "nincs tiltva" : "eltiltva (oka: ".$kari["LeaderTiltas"][1].")") . " > " . ($_POST["tilt_leader"] == 0 ? "tiltás levéve" : "örökre eltiltva (oka: ".$_POST["tilt_leader_ok"].")");

		}
		//FegyverTiltas
		if($jatekos["Admin"] >= 1337 || $config['Amos'] && isset($_POST["tilt_fegyver"]) && is_numeric($_POST["tilt_fegyver"]) && !is_float($_POST["tilt_fegyver"]) && $_POST["tilt_fegyver"] >= 0)
		{
			$keresek[] = "FegyverTiltas = '".$_POST["tilt_fegyver"]."@".$_POST["tilt_fegyver_ok"]."'";
			$uzenetek[] = "FegyverTiltás megváltoztatva: ".$_POST["tilt_fegyver_ok"]."(".$_POST["tilt_fegyver"]."ó)";
			$adminlogok[] = "FegyverTiltás megváltoztatva: ".$kari["FegyverTiltas"][1]."(".$kari["FegyverTiltas"][0]."ó) > ".$_POST["tilt_fegyver_ok"]."(".$_POST["tilt_fegyver"]."ó)";
		}
		//vege
		if($jatekos["Admin"] >= 1337 || $config['Amos'] && isset($_POST["tilt_jogsi"]) && is_numeric($_POST["tilt_jogsi"]) && !is_float($_POST["tilt_jogsi"]) && $_POST["tilt_jogsi"] >= 0)
		{
			$keresek[] = "JogsiTiltas = '".$_POST["tilt_jogsi"]."@".$_POST["tilt_jogsi_ok"]."'";
			$uzenetek[] = "JogsiTiltás megváltoztatva: ".$_POST["tilt_jogsi_ok"]."(".$_POST["tilt_jogsi"]."ó)";
			$adminlogok[] = "JogsiTiltás megváltoztatva: ".$kari["JogsiTiltas"][1]."(".$kari["JogsiTiltas"][0]."ó) > ".$_POST["tilt_jogsi_ok"]."(".$_POST["tilt_jogsi"]."ó)";
		}
		if($jatekos["Admin"] >= 1337 || $config['Amos'] && isset($_POST["as"]) && ($_POST["as"] == 0 || $_POST["as"] == -1 || $vd = validDate($_POST["as"], true)))
		{
			if(!isset($vd)) $vd = $_POST["as"];

			$txtOld = ($kari["ASJog"] == -1 ? "örök" : ($kari["ASJog"] == 0 || $kari["ASJog"] < time() ? "nem" : toDate($vd)));
			$txtNew = ($_POST["as"] == 0 ? "nem" : ($_POST["as"] == -1 ? "örök" : toDate($vd)));

			$keresek[] = "ASJog = '".$vd."'";
			$uzenetek[] = "Adminsegéd megváltoztatva: $txtNew";
			$adminlogok[]  = "adminsegéd váltás ($txtOld > $txtNew)";
		}

		if(isset($_POST["jelszo"]) && $jatekos["Admin"] >= 5 || $config['Amos'])
		{
			if(strlen($_POST["jelszo"]) < 3 || strlen($_POST["jelszo"]) > 20 || !SzovegAnalizalas($_POST["jelszo"], "._[]", false))
				Lablec(false, "Hibás jelszó - Minimum 3, maximum 20 karakter! Engedélyezett karakterek: Angol ABC, Számok, Speciális karakterek: '.', '_', '[', ']'", true);

			$keresek[] = "Pass = '".SeeEncode($_POST["jelszo"], true)."'";
			$uzenetek[] = "Jelszó megváltoztatva: ".$_POST["jelszo"]."";
			$adminlogok[]  = "jelszóváltás";
		}

		if(isset($_POST["nem"]) && is_numeric($_POST["nem"]) && $jatekos["Admin"] >= 5 || $config['Amos'])
		{
			if($_POST["nem"] == "1") $nem = "Férfi"; else $nem = "Nő";

			$keresek[] = "Sex = '".$_POST["nem"]."'";
			$uzenetek[] = "Nem megváltoztatva: ".$nem;
			$adminlogok[] = "nemváltás (".($kari["Sex"] == "1" ? "Férfi" : "Nő")." > ".$nem.")";
		}

		if(isset($_POST["szint"]) && is_numeric($_POST["szint"]) && $jatekos["Admin"] >= 6 || $config['Amos'])
		{
			if($_POST["szint"] < 1 || $_POST["szint"] > 35)
				Lablec(false, "Hibás szint - Minimum 1, maximum 35", true);

			$keresek[] = "Szint = '".$_POST["szint"]."'";
			$uzenetek[] = "Szint megváltoztatva: ".$_POST["szint"];
			$adminlogok[] = "szintváltás (".$kari["Szint"]." > ".$_POST["szint"].")";
		}

		if(isset($_POST["ora"]) && is_numeric($_POST["ora"]) && $jatekos["Admin"] >= 6 || $config['Amos'])
		{
			if($_POST["szint"] < 0 || $_POST["szint"] > 9999)
				Lablec(false, "Hibás játszott óra - Minimum 0, maximum 9999", true);

			$keresek[] = "ConnectedTime = '".$_POST["ora"]."'";
			$uzenetek[] = "Játszott óra megváltoztatva: ".$_POST["ora"];
			$adminlogok[] = "j.ó.váltás (".$kari["ConnectedTime"]." > ".$_POST["ora"].")";
		}

		if(isset($_POST["bank"]) && is_numeric($_POST["bank"]) && $jatekos["Admin"] >= 6 || $config['Amos'])
		{
			$keresek[] = "Bank = '".$_POST["bank"]."'";
			$uzenetek[] = "Bank megváltoztatva: ".$_POST["bank"];
			$adminlogok[] = "bankpénzváltás (".$kari["Bank"]." > ".$_POST["bank"].")";
		}

		if(isset($_POST["kor"]) && is_numeric($_POST["kor"]) && $jatekos["Admin"] >= 5 || $config['Amos'])
		{
			$keresek[] = "Age = '".$_POST["kor"]."'";
			$uzenetek[] = "Kor megváltoztatva: ".$_POST["kor"];
			$adminlogok[] = "korváltás (".$kari["Age"]." > ".$_POST["kor"].")";
		}

		if(isset($_POST["ft"]) && is_numeric($_POST["ft"]) && $jatekos["Admin"] >= 6 || $config['Amos'])
		{
			$keresek[] = "Member = '".$_POST["ft"]."'";
			$uzenetek[] = "Tagság megváltoztatva: ".$_POST["ft"];
			$adminlogok[] = "tagságváltás (".$kari["Member"]." > ".$_POST["ft"].")";
		}

		if(isset($_POST["fl"]) && is_numeric($_POST["fl"]) && $jatekos["Admin"] >= 6 || $config['Amos'])
		{
			$keresek[] = "Leader = '".$_POST["fl"]."'";
			$uzenetek[] = "Leader megváltoztatva: ".$_POST["fl"];
			$adminlogok[] = "leaderváltás (".$kari["Leader"]." > ".$_POST["fl"].")";
		}

		if(isset($_POST["szar"]) && is_numeric($_POST["szar"]) && $jatekos["Admin"] >= 5 || $config['Amos'])
		{
			if($_POST["szar"] == "1") $szarm = "USA"; elseif($_POST["szar"] == "2") $szarm = "Európa"; else $szarm = "Ăzsia";
			if($kari["Origin"] == "1") $szarmvolt = "USA"; elseif($kari["Origin"] == "2") $szarmvolt = "Európa"; else $szarmvolt = "Ăzsia";

			$keresek[] = "Origin = '".$_POST["szar"]."'";
			$uzenetek[] = "Származás megváltoztatva: ".$szarm;
			$adminlogok[] = "származásváltás (".$szarmvolt." > ".$szarm.")";
		}

		if(isset($_POST["jail"]) && is_numeric($_POST["jail"]) && isset($_POST["jailido"]) && is_numeric($_POST["jailido"]) && isset($_POST["jailok"]) && $jatekos["Admin"] >= 3 || $config['Amos'])
		{
			if($kari["Jailed"] != "0") $jailvolt = $borton[$kari["Jailed"]]; else $jailvolt = "Nincs";
			if($_POST["jail"] != "0") $jail = $borton[$_POST["jail"]]; else $jail = "Nincs";
			
			if(!SzovegAnalizalas($_POST["jailok"]))
				Lablec(false, "<b>Hiba: Hibás karakterek a szövegben</b>", true);

			$keresek[] = "Jailed = '".$_POST["jail"]."'";
			$keresek[] = "JailTime = '".($_POST["jailido"]*60)."'";
			$keresek[] = "JailOK = '".addslashes(str_replace("|", "", $_POST["jailok"]))."'";
			$uzenetek[] = "Jail megváltoztatva: ".$jail." [Idő: ".$_POST["jailido"]."p | Oka: ".$_POST["jailok"]."]";
			$adminlogok[] = "jail (Régi: ".$jailvolt." [Idő: ".round($kari["JailTime"]/60)."p | Oka: ".$kari["JailOK"]."] ==> Új: ".$jail." [Idő: ".$_POST["jailido"]."p | Oka: ".$_POST["jailok"]."])";
		}

		/*if(isset($_POST["jailido"]) && is_numeric($_POST["jailido"]))
		{
			$keresek[] = "JailTime = '".$_POST["jailido"]."'";
			$uzenetek[] = "Jail idő megváltoztatva: ".$_POST["jailido"];
			$adminlogok[] = "jailidő (".$kari["JailTime"]."mp > ".$_POST["jailido"]."mp)";
		}*/

		if(!$keresekII)
		{
			if(count($keresek) < 1)
				Lablec(false, "Nem változtattál semmin! 1", true);
		}
		
		if(count($keresek) > 0)
		{
			$update = mysql_query("UPDATE playerek SET ".implode(",", $keresek)." WHERE ID='".$_POST["id"]."'");
			if(!$update)
				Lablec(false, "MySQL hiba!", true);
			else
			{
				echo implode("\n", $uzenetek);
				SeeLOG("kszerk", "<b class='kiemelt'>".$jatekos["LogNev"]."</b> szerkesztette <b class='kiemelt'>".$kari["Nev"]."</b> karakterét. <b class='kiemelt'>Műveletek:</b> ".implode(", ", $adminlogok), $jatekos["ID"], $jatekos["LogNev"], 1);
			}
		}
		else if($keresekII)
		{
			echo implode("\n", $uzenetek);
				SeeLOG("kszerk", "<b class='kiemelt'>".$jatekos["LogNev"]."</b> szerkesztette <b class='kiemelt'>".$kari["Nev"]."</b> karakterét. <b class='kiemelt'>Műveletek:</b> ".implode(", ", $adminlogok), $jatekos["ID"], $jatekos["LogNev"], 1);
	
		}
	}
##########################################################################################################################################
	elseif(isset($_GET["keres"]) && isset($_POST["data"]))
	{
		$data = $_POST["data"];
		if(strlen($data) < 3 || strlen($data) > 20)
			Lablec(false, "<b>Hiba: Minimum 3, maximum 20 karakter</b>", true);
		
		$data = SzokozKereses($data);
		if(!SzovegAnalizalas($data, "_ ", false))
			Lablec(false, "<b>Hiba: Hibás karakterek a szövegben</b>", true);

		$data = str_replace(" ", "", $data);

		################################################################################################################################
		##################################################### S Q L ####################################################################
		$mezok = "ID, Online, Szint, ConnectedTime, Bank, Admin, ASJog, Nev, Money, BankSzamla, Bank, Cuccok, Sex, Age, Origin,
				  Jailed, JailTime, JailOK, Leader, Member, ASTiltas, FrakcioTiltas, JogsiTiltas, Premium, LeaderTiltas, FegyverTiltas, AdminUzenet";
		################################################################################################################################

		
		$sql = mysql_query("SELECT $mezok FROM playerek WHERE Nev LIKE '%".$data."%'");
		$db = mysql_num_rows($sql);

		if($db > 1)
		{
			$sql2 = mysql_query("SELECT $mezok FROM playerek WHERE Nev = '".$data."'");
			if(mysql_num_rows($sql2) == 1)
			{
				mysql_free_result($sql);
				$sql = $sql2;
			}
			else
			{
				Lablec(false, "<b>Hiba: Több találat is van a keresett névre: \"".$data."\", kérlek pontosĂ­ts!</b>", true);
				mysql_free_result($sql);
				mysql_free_result($sql2);
			}
		}
		else if($db < 1)
			Lablec(false, "<b>Hiba: Nincs találat a keresett névre: \"".$data."\"</b>", true);

		$kari = mysql_fetch_array($sql); mysql_free_result($sql);

		if($kari["Online"] == "1")
		{
			/*echo "
			<form method=\"POST\" action=\"admin_szerkeszt.php\"/>
			<input type=\"hidden\" name=\"kicknev\" valuse=\"".$kari["ID"]."\" />
			<input type=\"submit\" name=\"kick\" value=\"Kickelés! ((még nincs kész))\" /> <br />";*/
			echo "<input type='button' onclick='Kick(\"".$kari["ID"]."\")' value='Kickelés'> 
			<br />";
			Lablec(false, "<b style='color:lightgreen'>Hiba: A játékos jelenleg Online</b>", true);
		
		}
		//$kari["Nev"] = str_replace("_", " ", $kari["Nev"]);
		$kari["ASTiltas"] = explode("@", $kari["ASTiltas"]);
		$kari["FrakcioTiltas"] = explode("@", $kari["FrakcioTiltas"]);
		$kari["JogsiTiltas"] = explode("@", $kari["JogsiTiltas"]);
		$kari["Premium"] = explode(",", $kari["Premium"]);
		$kari["LeaderTiltas"] = explode("@", $kari["LeaderTiltas"]);
		$kari["FegyverTiltas"] = explode("@", $kari["FegyverTiltas"]);
		$kari["AdminUzenet"] = explode("@", $kari["AdminUzenet"]);
		
		

		echo "<center><b>";
		echo "<font size='7'><b>".$kari["Nev"]."</b></font><br>";

		###########################################################
		###################### A L A P ############################
		###########################################################

		echo "<font size='3' class='left'><b> - Alap adatok</b></font>";
		echo "<table width='100%' border='0' class='cleartable'>";
		echo "<tr><td width='30%' class='cim'></td><td class='cim'></tr>";

		if($jatekos["Admin"] >= 6)
		echo # Név
		"<tr>
			<td>Név</td>
			<td class='left'><input type='checkbox' id='c_nev' onclick='Nyit(\"nev\")'>
			<input type='text' id='t_nev' value='".$kari["Nev"]."' disabled='true'></td>
		</tr>";

		if($jatekos["Admin"] >= 6)
		echo # Jelszó
		"<tr>
			<td>Jelszó</td>
			<td class='left'><input type='checkbox' id='c_jelszo' onclick='Nyit(\"jelszo\")'>
			<input type='text' id='t_jelszo' value='' disabled='true'></td>
		</tr>";

		if($jatekos["Admin"] >= 6)
		echo # Szint és játszott óra
		"<tr>
			<td>Szint és játszott óra</td>
			<td class='left'><input type='checkbox' id='c_szint' onclick='Nyit(\"szint\", \"ora\")'>
			Szint: <input type='text' id='t_szint' value='".$kari["Szint"]."' size='2' maxlength='2' disabled='true'> Játszott óra: <input type='text' id='t_ora' value='".$kari["ConnectedTime"]."' size='4' maxlength='4' disabled='true'></td>
		</tr>";
        
        if($jatekos["Admin"] >= 5)
		echo # Nem
		"<tr>
			<td>Nem</td>
			<td class='left'><input type='checkbox' id='c_nem' onclick='Nyit(\"nem\")'>
			<select id='t_nem' disabled='true'><option value='1'>Férfi</option><option value='2' ".($kari["Sex"] == '2' ? "selected" : "").">Nő</option></select></td>
		</tr>";
        
        if($jatekos["Admin"] >= 5)
        {
		    $ek = ""; for($k = 10; $k <= 50; $k++) $ek .= "<option value='".$k."' ".($k == $kari["Age"] ? "selected" : "").">".$k."</option>";
		    echo # életkor
		    "<tr>
			    <td>életkor</td>
			    <td class='left'><input type='checkbox' id='c_kor' onclick='Nyit(\"kor\")'>
			    <select id='t_kor' disabled='true'>".$ek."</select></td>
		    </tr>";
        }

        if($jatekos["Admin"] >= 5)
		echo # Származás
		"<tr>
			<td>Származás</td>
			<td class='left'><input type='checkbox' id='c_szar' onclick='Nyit(\"szar\")'>
			<select id='t_szar' disabled='true'>
				<option value='1'>USA</option>
				<option value='2' ".($kari["Origin"] == '2' ? "selected" : "").">Európa</option>
				<option value='3' ".($kari["Origin"] == '3' ? "selected" : "").">Ăzsia</option>
				</select></td>
		</tr>";

		if($jatekos["Admin"] >= 1337 && $kari["Admin"] <= 5 || $jatekos["Admin"] >= 1338 && $kari["Admin"] != 5555 || $jatekos["Admin"] == 5555)
		{echo # Admin
		"<tr>
			<td>Admin?</td>
			<td class='left'><input type='checkbox' id='c_admin' onclick='Nyit(\"admin\")'>
			<select id='t_admin' disabled='true'>
				<option value='0'>Nem</option>
				<option value='1' ".($kari["Admin"] == '1' ? "selected" : "").">1</option>
				<option value='2' ".($kari["Admin"] == '2' ? "selected" : "").">2</option>
				<option value='3' ".($kari["Admin"] == '3' ? "selected" : "").">3</option>
				<option value='4' ".($kari["Admin"] == '4' ? "selected" : "").">4</option>
				<option value='5' ".($kari["Admin"] == '5' ? "selected" : "").">5</option>
				<option value='6' ".($kari["Admin"] == '6' ? "selected" : "").">6</option>
				<option value='1337' ".($kari["Admin"] == '1337' ? "selected" : "").">1337</option>
				<option value='1338' ".($kari["Admin"] == '1338' ? "selected" : "").">1338</option>
				<option value='1339' ".($kari["Admin"] == '1339' ? "selected" : "").">1339</option>
				<option value='1340' ".($kari["Admin"] == '1340' ? "selected" : "").">1340</option>
				<option value='1350' ".($kari["Admin"] == '1350' ? "selected" : "").">1350</option>
				<option value='5555' ".($kari["Admin"] == '5555' ? "selected" : "").">5555</option>
				";

				/*if($jatekos["Admin"] >= 1340)
				{
					echo"
					<option value='6' ".($kari["Admin"] == '6' ? "selected" : "").">6</option>
					<option value='1337' ".($kari["Admin"] == '1337' ? "selected" : "").">1337</option>
					<option value='1338' ".($kari["Admin"] == '1338' ? "selected" : "").">1338</option>
					<option value='1339' ".($kari["Admin"] == '1339' ? "selected" : "").">1339</option>
					";

					if(IsClint())
					{
						echo "
							<option value='1340' ".($kari["Admin"] == '1340' ? "selected" : "").">1340</option>
							<option value='5555' ".($kari["Admin"] == '5555' ? "selected" : "").">5555</option>
						";
					}
				}*/

				echo"</select></td>
		</tr>";}

		if($jatekos["Admin"] >= 1337)
		echo # Adminsegéd
		"<tr>
			<td>Adminsegéd?</td>
			<td class='left'><input type='checkbox' id='c_as' onclick='Nyit(\"as\", \"as_o\", \"as_v\")'>
			<select id='t_as' disabled><option value='0'>Nem</option><option value='1' ".($kari["ASJog"] > 0 || $kari["ASJog"] == -1 ? "selected" : "").">Igen</option></select>
			<input type='checkbox' id='t_as_o' value='1' disabled ".($kari["ASJog"] == -1 ? "checked" : "")."> Örök 
			<input type='text' id='t_as_v' value='".($kari["ASJog"] > time() ? toDate($kari["ASJog"]) : "")."' disabled='true' size='17' maxlength='19'>
			<input type='hidden' id='t_as_h' value='".toDate($kari["ASJog"])."' disabled='true' size='17' maxlength='19'>
			</td>
		</tr>";

		echo "</table><br>";

		###########################################################
		####################### T A G S Ă G #######################
		###########################################################

		echo "<font size='3' class='left'><b> - Tagság</b></font>";
		echo "<table width='100%' border='0' class='cleartable'>";
		echo "<tr><td width='30%' class='cim'></td><td class='cim'></tr>";

        if($jatekos["Admin"] >= 1337)
        {
		    $ft = ""; $fl = "";
			for($k = 0; $k <= 21; $k++)
			{
				if(!in_array($k, $config["NemLetezoFrakciok"]))
					$ft .= "<option value='".$k."' ".($k == $kari["Member"] ? "selected" : "").">".($k == 0 ? "----" : $config["Frakciok"][$k])."</option>";
			}
			for($k = 0; $k <= 21; $k++)
			{
				if(!in_array($k, $config["NemLetezoFrakciok"]))
					$fl .= "<option value='".$k."' ".($k == $kari["Leader"] ? "selected" : "").">".($k == 0 ? "----" : $config["Frakciok"][$k])."</option>";
			}
		    echo # Frakció
		    "<tr>
			    <td>Frakció tag</td>
			    <td class='left'><input type='checkbox' id='c_ft' onclick='Nyit(\"ft\")'>
			    <select id='t_ft' disabled='true'>".$ft."</select></td>
		    </tr>";
		    echo # Frakció
		    "<tr>
			    <td>Frakció leader</td>
			    <td class='left'><input type='checkbox' id='c_fl' onclick='Nyit(\"fl\")'>
			    <select id='t_fl' disabled='true'>".$fl."</select></td>
		    </tr>";
        }

		echo "</table><br>";

		###########################################################
		################### E L T I L T Ă S O K ###################
		###########################################################

		echo "<font size='3' class='left'><b> - Eltiltások</b></font>";
		echo "<table width='100%' border='0' class='cleartable'>";
		echo "<tr><td width='30%' class='cim'></td><td class='cim'></tr>";

		if($jatekos["Admin"] >= 1337)
		echo # AS Tiltás
		"<tr>
			<td>Adminsegéd eltiltás</td>
			<td class='left'>
			<input type='checkbox' id='c_tilt_as' onclick='Nyit(\"tilt_as\", \"tilt_as_ok\")'>
			<select id='t_tilt_as' disabled><option value='0'>Nem</option><option value='1' ".($kari["ASTiltas"][0] != "0" ? "selected" : "").">Igen</option></select>
			 - Oka:
			<input type='text' id='t_tilt_as_ok' value='".$kari["ASTiltas"][1]."' size='30' maxlength='64' disabled>
			</td>
		</tr>";

		if($jatekos["Admin"] >= 1337)
		echo # Frakció Tiltás
		"<tr>
			<td>Frakció eltiltás</td>
			<td class='left'>
			<input type='checkbox' id='c_tilt_frakcio' onclick='Nyit(\"tilt_frakcio\", \"tilt_frakcio_ok\")'>
			Idő: <input type='text' id='t_tilt_frakcio' value='".$kari["FrakcioTiltas"][0]."' size='3' maxlength='3' disabled> óra - Oka:
			<input type='text' id='t_tilt_frakcio_ok' value='".$kari["FrakcioTiltas"][1]."' size='30' maxlength='64' disabled>
			</td>
		</tr>";

		if($jatekos["Admin"] >= 1337)
		echo # Jogsi Tiltás
		"<tr>
			<td>Jogsi eltiltás</td>
			<td class='left'>
			<input type='checkbox' id='c_tilt_jogsi' onclick='Nyit(\"tilt_jogsi\", \"tilt_jogsi_ok\")'>
			Idő: <input type='text' id='t_tilt_jogsi' value='".$kari["JogsiTiltas"][0]."' size='3' maxlength='3' disabled> óra - Oka:
			<input type='text' id='t_tilt_jogsi_ok' value='".$kari["JogsiTiltas"][1]."' size='30' maxlength='64' disabled>
			</td>
		</tr>";
		
		//ujresz
		if($jatekos["Admin"] >= 1337)
		echo # leader Tiltás
		"<tr>
			<td>Leader eltiltás</td>
			<td class='left'>
			<input type='checkbox' id='c_tilt_leader' onclick='Nyit(\"tilt_leader\", \"tilt_leader_ok\")'>
			<select id='t_tilt_leader' disabled><option value='0'>Nem</option><option value='1' ".($kari["LeaderTiltas"][0] != "0" ? "selected" : "").">Igen</option></select>
			 - Oka:
			<input type='text' id='t_tilt_leader_ok' value='".$kari["LeaderTiltas"][1]."' size='30' maxlength='64' disabled>
			</td>
		</tr>";
		
		if($jatekos["Admin"] >= 1337)
		echo # Fegyver Tiltás
		"<tr>
			<td>Fegyver eltiltás</td>
			<td class='left'>
			<input type='checkbox' id='c_tilt_fegyver' onclick='Nyit(\"tilt_fegyver\", \"tilt_fegyver_ok\")'>
			Idő: <input type='text' id='t_tilt_fegyver' value='".$kari["FegyverTiltas"][0]."' size='3' maxlength='3' disabled> óra - Oka:
			<input type='text' id='t_tilt_fegyver_ok' value='".$kari["FegyverTiltas"][1]."' size='30' maxlength='64' disabled>
			</td>
		</tr>";

		echo "</table><br>";
		
		###########################################################
		################ A D M I N  Ü Z E N E T ###################
		###########################################################
		echo "<font size='3' class='left'><b> - Admin uzenet</b></font>";
		echo "<table width='100%' border='0' class='cleartable'>";
		echo "<tr><td width='30%' class='cim'></td><td class='cim'></tr>";
		
		if($jatekos["Admin"] >= 3)
		echo # Admin üzenet
		"<tr>
			<td>Admin uzenet</td>
			<td class='left'>
			<input type='checkbox' id='c_admin_uzenet' onclick='Nyit(\"admin_uzenet\", \"admin_uzenet_ok\")'>
			<select id='t_admin_uzenet' disabled><option value='0'>Nem</option><option value='1' ".($kari["AdminUzenet"][0] != "0" ? "selected" : "").">Igen</option></select>
			 - Oka:
			
			</td>
			
		</tr>";
		
		echo "</table><br>";
		echo "<br><textarea id='t_admin_uzenet_ok' rows='5' cols='50' maxlength='139' disabled></textarea><br />
		TIPP: A doboz szélénél tovább NE írj mert IG sem fog látszani, ott nyomj egy enter-t<br />";		
		###########################################################
		####################### C U C C O K #######################
		###########################################################

		echo "<font size='3' class='left'><b> - Cuccok</b></font>";
		echo "<table width='100%' border='0' class='cleartable'>";
		echo "<tr><td width='30%' class='cim'></td><td class='cim'></tr>";

		if($jatekos["Admin"] >= 1337)
		echo # Pénz (bank)
		"<tr>
			<td>Pénz (Bank)</td>
			<td class='left'>
			<input type='checkbox' id='c_bank' onclick='Nyit(\"bank\")'>
			<input type='text' id='t_bank' value='".$kari["Bank"]."' disabled='true' size='11' maxlength='11'>
			</td>
		</tr>";

		if($jatekos["Admin"] >= 1340)
		echo # Prémium pont
		"<tr>
			<td>Prémium pont</td>
			<td class='left'>
			<input type='checkbox' id='c_ppont' onclick='Nyit(\"ppont\")'>
			<input type='text' id='t_ppont' value='".$kari["Premium"][1]."' disabled='true' size='2' maxlength='2'>
			</td>
		</tr>";

		echo "</table><br>";

		###########################################################
		######################### J A I L #########################
		###########################################################

		echo "<font size='3' class='left'><b> - Jail</b></font>";
		echo "<table width='100%' border='0' class='cleartable'>";
		echo "<tr><td width='30%' class='cim'></td><td class='cim'></tr>";

		echo # Jailban
		"<tr>
			<td>Jailban?</td>
			<td class='left'>
			<input type='checkbox' id='c_jail' onclick='Nyit(\"jail\", \"jailido\", \"jailok\")'>
				<select id='t_jail' disabled='true'>
					<option value='0'>Nincs</option>
					<option value='2' ".($kari["Jailed"] == '2' ? "selected" : "").">Börtön</option>
					<option value='3' ".($kari["Jailed"] == '3' ? "selected" : "").">Admin</option>
					<option value='6' ".($kari["Jailed"] == '6' ? "selected" : "").">Magánzárka</option>
					<option value='8' ".($kari["Jailed"] == '8' ? "selected" : "").">Extra Magánzárka</option>
				</select><input type='text' id='t_jailido' value='".round($kari["JailTime"] / 60)."' disabled='true' size='5' maxlength='5'> perc
				<br><input type='text' id='t_jailok' value='".$kari["JailOK"]."' disabled='true' size='55' maxlength='150'>
			</td>
		</tr>";

	
		echo "</table><br>";
		

		if($jatekos["Admin"] >= 1340)
		{
			echo "<font size='3' class='left'><b> - TÖRLÉS</b></font>";
			echo "<table width='100%' border='0' class='cleartable'>";
			echo "<tr><td width='30%' class='cim'></td><td class='cim'></tr>";
			echo "
			
			<tr>
				<td>Töröl?</td>
				<td class='left'>
					<input type='button' onclick='TorlesMegerosites(\"".$kari['Nev']."\", ".$kari['ID'].");' value='Karakter törlés'> 
			<br />
				</td>
			</tr>
			";
		}


		echo "</table><br>";

		###########################################################
		################# B A N K S Z Ă M L A #####################
		###########################################################

		/*echo "<font size='3' class='left'><b> - Bankszámla</b></font>";
		echo "<table width='100%' border='0' class='cleartable'>";
		echo "<tr><td width='30%' class='cim'></td><td class='cim'></tr>";

		$bankszamla = explode(",", $kari["BankSzamla"]);

		echo # Pénz (Bank)
		"<tr>
			<td>Van?</td>
			<td class='left'><input type='checkbox' id='c_bankszamla' onclick='Nyit(\"bankszamla\")'>
			<select id='t_bankszamla' disabled='true'><option value='0'>Nincs</option><option value='1' ".($bankszamla[0] == '1' ? "selected" : "").">Van</option></select></td>
		</tr>";

		echo # Számlaszám
		"<tr>
			<td>Számlaszám</td>
			<td class='left'><input type='checkbox' id='c_szszam' onclick='Nyit(\"szszam\")'>
			<input type='text' id='t_szszam' value='".$bankszamla[1]."' disabled='true' size='5' maxlength='5'></td>
		</tr>";
		echo # Pénz a bankban
		"<tr>
			<td>Pénz a bankban</td>
			<td class='left'><input type='checkbox' id='c_bank' onclick='Nyit(\"bank\")'>
			<input type='text' id='t_bank' value='".$kari["Bank"]."' disabled='true' size='9' maxlength='9'> Ft</td>
		</tr>";
		echo "</table><br>";

		###########################################################
		###################### C U C C O K ########################
		###########################################################

		echo "<font size='3' class='left'><b> - Cuccok</b></font>";
		echo "<table width='100%' border='0' class='cleartable'>";
		echo "<tr><td width='30%' class='cim'></td><td class='cim'></tr>";

		$cuccok = explode(",", $kari["Cuccok"]);

		echo # Pénz (KP)
		"<tr>
			<td>Készpénz</td>
			<td class='left'><input type='checkbox' id='c_penz' onclick='Nyit(\"penz\")'>
			<input type='text' id='t_penz' value='".$kari["Money"]."' disabled='true' size='7' maxlength='7'> Ft</td>
		</tr>";

		echo # Műanyag
		"<tr>
			<td>Műanyag</td>
			<td class='left'><input type='checkbox' id='c_muany' onclick='Nyit(\"muany\")'>
			<input type='text' id='t_muany' value='".$cuccok[0]."' disabled='true' size='2' maxlength='2'> db</td>
		</tr>";
		echo # Cserje
		"<tr>
			<td>Cserje</td>
			<td class='left'><input type='checkbox' id='c_cser' onclick='Nyit(\"cser\")'>
			<input type='text' id='t_cser' value='".$cuccok[1]."' disabled='true' size='2' maxlength='2'> db</td>
		</tr>";
		echo # Mák
		"<tr>
			<td>Mák</td>
			<td class='left'><input type='checkbox' id='c_mak' onclick='Nyit(\"mak\")'>
			<input type='text' id='t_mak' value='".$cuccok[2]."' disabled='true' size='2' maxlength='2'> db</td>
		</tr>";
		echo # Cannabis
		"<tr>
			<td>Cannabis</td>
			<td class='left'><input type='checkbox' id='c_can' onclick='Nyit(\"can\")'>
			<input type='text' id='t_can' value='".$cuccok[3]."' disabled='true' size='2' maxlength='2'> db</td>
		</tr>";

		echo # Mati
		"<tr>
			<td>Material</td>
			<td class='left'><input type='checkbox' id='c_mati' onclick='Nyit(\"mati\")'>
			<input type='text' id='t_mati' value='".$cuccok[4]."' disabled='true' size='6' maxlength='6'> db</td>
		</tr>";
		echo # Kokain
		"<tr>
			<td>Kokain</td>
			<td class='left'><input type='checkbox' id='c_kok' onclick='Nyit(\"kok\")'>
			<input type='text' id='t_kok' value='".$cuccok[5]."' disabled='true' size='6' maxlength='6'> g</td>
		</tr>";
		echo # Heroin
		"<tr>
			<td>Heroin</td>
			<td class='left'><input type='checkbox' id='c_her' onclick='Nyit(\"her\")'>
			<input type='text' id='t_her' value='".$cuccok[6]."' disabled='true' size='6' maxlength='6'> g</td>
		</tr>";
		echo # Marihuana
		"<tr>
			<td>Marihuana</td>
			<td class='left'><input type='checkbox' id='c_mar' onclick='Nyit(\"mar\")'>
			<input type='text' id='t_mar' value='".$cuccok[7]."' disabled='true' size='6' maxlength='6'> g</td>
		</tr>";
		echo "</table><br>";*/
		
		
		###########################################################
		###################### USER DATA ########################
		###########################################################
		
		
		if($jatekos["Admin"] >= 1340 || IsScripter())
		{
			echo "<font size='3' class='left'><b> - USER DATA</b></font>";
			echo "<br /> <br /> Csak akkor írhatod át ha tudod mi micsoda!<br /><br />  ";
			$files = "/games/samp/teszt/scriptfiles/data/user/".$kari["ID"].".ini";
			echo "FILE: scriptfiles/data/user/".$kari["ID"].".ini<br /> <br />";
			
			echo "Módósítási engedély: <input type='checkbox' id='c_user_data' onclick='Nyit(\"user_data\")'>";
			if(file_exists("$files"))
			{
				$adatok = file_get_contents ($files,true);
			
				echo "<br><textarea id='t_user_data' rows='20' cols='80' disabled>".$adatok."</textarea><br />";
			
			}
			else echo "NINCS ADAT FILE";
		}
		###########################################################
		###################### M E N T é S ########################
		###########################################################

		echo "<input type='button' onclick='Mentes(\"".$kari["ID"]."\")' value='Mentés'> <input type='button' onclick='Keres(\"".$data."\")' value='Újratölt'>";

		echo "</b></center><br>";
	}
##########################################################################################################################################
	Lablec(false);
	exit;
}

Fejlec("jquery.timepicker");

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
		text-align: lefts;}
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
	.cleartable {
		clear: left;
	}
</style>

<script type="text/javascript">
	var ajaxtoltes = false;
	function Nyit()
	{
		for( var v = 0; v < arguments.length; v++ )
		{
			if(Checked("c_"+arguments[0]))
				$("#t_"+arguments[v]).removeAttr("disabled");
			else
				$("#t_"+arguments[v]).attr("disabled", "disabled");
		}
	}

	function Init()
	{
		var elem = $("#t_as_v");
		if(eExist(elem))
		{
			elem.datetimepicker({
				onClose: function(dateText, inst){
					if(elem.val() != "")
						$("#t_as_h").val(dateText);
				},
				dateFormat: "yy-mm-dd",
				dayNamesShort: ['Va', 'Hé', 'Ke', 'Sze', 'CsĂĽ', 'Pé', 'Szo'],
				dayNamesMin: ['Va', 'Hé', 'Ke', 'Sze', 'CsĂĽ', 'Pé', 'Szo'],
				monthNames: ['Január', 'Február', 'Március', 'Ăprilis', 'Május', 'JĂşnius', 'JĂşlius', 'Augusztus', 'Szeptember', 'Október', 'November', 'December'],
				monthNamesShort: ['Jan', 'Feb', 'Már', 'Ăpr', 'Máj', 'JĂşn', 'JĂşl', 'Aug', 'Szep', 'Okt', 'Nov', 'Dec'],
				firstDay: 1
			});
		}
	}

	function Keres(elotoltes)
	{
		if(ajaxtoltes)
			return 1;

		ajaxtoltes = 1;
		$("#gomb").css("display", "none");
		$("#kep").css("display", "inline");

		if(elotoltes) nev = elotoltes;
		else nev = $("#nev").val();

		$("#ajax").slideToggle(500, function()
		{
			$.ajax({
				type: "POST",
				url: "?ajax&keres",
				data: "data="+nev,
				success: function(msg){
					ajaxtoltes = false;
					$("#ajax").html(msg);

					$("#ajax").slideToggle(500, function(){
						$("#gomb").css("display", "inline");
						$("#kep").css("display", "none");
						Init();
					});
				}
			});
		});
	}

	function Kick(id)
	{
		disableDiv("ajax");

		$.ajax({
			type: "POST",
			url: "?ajax&kick",
			data: "id="+id,
			success: function(msg){
				alert(msg);
				ajaxtoltes = false;
				enableDiv("ajax");
			}
		});
	}
	function TorlesMegerosites(nev, id)
	{
		if(nev.length < 3)
			return alert("hiba");

		var szoveg = "Törlöm őt: " + nev;

		var valasz = prompt("Erősítsd meg a törlést\nÍrd be a következő szöveget:\n\n\""+szoveg+"\"");
		if(!valasz || valasz != szoveg)
			return alert("A beírt szöveg nem egyezik a megadott szöveggel!");

		Torol(id);

	}
	function Torol(id)
	{
		disableDiv("ajax");

		$.ajax({
			type: "POST",
			url: "?ajax&torol",
			data: "id="+id,
			success: function(msg){
				alert(msg);
				ajaxtoltes = false;
				enableDiv("ajax");
				window.location.reload();
			}
		});
	}
	function Mentes(id)
	{
		var adatok_neve = Array("nev", "jelszo", "szint", "nem", "kor", "szar", "admin", "as", "jail", "bankszamla", "szszam", "bank", "penz", "muany", "cser", "mak", "can", "mati", "kok", "her", "mar", "ft", "fl", "tilt_as", "tilt_frakcio", "tilt_jogsi", "ppont", "tilt_leader", "tilt_fegyver", "admin_uzenet","user_data");

		var adatok = Array();
		var data = "";

		for(c = 0; c < adatok_neve.length; c++)
		{
			if(adatok_neve[c] == "jail" && Checked("c_"+adatok_neve[c]))
			{
				adatok.push(["jail", $("#t_jail").val()]);
				adatok.push(["jailido", $("#t_jailido").val()]);
				adatok.push(["jailok", $("#t_jailok").val()]);
			}
			else if(adatok_neve[c] == "szint" && Checked("c_"+adatok_neve[c]))
			{
				adatok.push(["szint", $("#t_szint").val()]);
				adatok.push(["ora", $("#t_ora").val()]);
			}
			else if(adatok_neve[c] == "as" && Checked("c_"+adatok_neve[c]))
			{
				if($("#t_as").val() == 1)
				{
					val = $("#t_as_h").val();

					if(Checked("t_as_o"))
						adatok.push(["as", "-1"]);
					else if( val.length == 19 )
					{
						if(time(val) > time())
							adatok.push(["as", val]);
						else
							adatok.push(["as", "0"]);
					}
					else
						adatok.push(["as", "0"]);
				}
				else
					adatok.push(["as", "0"]);
			}
			else if(adatok_neve[c] == "tilt_as" && Checked("c_"+adatok_neve[c]))
			{
				adatok.push(["tilt_as_ok", $("#t_tilt_as_ok").val()]);
				adatok.push(["tilt_as", $("#t_tilt_as").val()]);
			}
			else if(adatok_neve[c] == "admin_uzenet" && Checked("c_"+adatok_neve[c]))
			{
				adatok.push(["admin_uzenet_ok", $("#t_admin_uzenet_ok").val()]);
				adatok.push(["admin_uzenet", $("#t_admin_uzenet").val()]);
			}
			else if(adatok_neve[c] == "user_data" && Checked("c_"+adatok_neve[c]))
			{
				adatok.push(["user_data", $("#t_user_data").val()]);
				
			}
			else if(adatok_neve[c] == "tilt_frakcio" && Checked("c_"+adatok_neve[c]))
			{
				adatok.push(["tilt_frakcio_ok", $("#t_tilt_frakcio_ok").val()]);
				adatok.push(["tilt_frakcio", $("#t_tilt_frakcio").val()]);
			}
			
			else if(adatok_neve[c] == "tilt_leader" && Checked("c_"+adatok_neve[c]))
			{
				adatok.push(["tilt_leader_ok", $("#t_tilt_leader_ok").val()]);
				adatok.push(["tilt_leader", $("#t_tilt_leader").val()]);
			}
			else if(adatok_neve[c] == "tilt_fegyver" && Checked("c_"+adatok_neve[c]))
			{
				adatok.push(["tilt_fegyver_ok", $("#t_tilt_fegyver_ok").val()]);
				adatok.push(["tilt_fegyver", $("#t_tilt_fegyver").val()]);
			}
			else if(adatok_neve[c] == "tilt_jogsi" && Checked("c_"+adatok_neve[c]))
			{
				adatok.push(["tilt_jogsi_ok", $("#t_tilt_jogsi_ok").val()]);
				adatok.push(["tilt_jogsi", $("#t_tilt_jogsi").val()]);
			}
			else if($("#c_"+adatok_neve[c]) && Checked("c_"+adatok_neve[c]))
				adatok.push([adatok_neve[c], $("#t_"+adatok_neve[c]).val()]);
		}

		if(adatok.length < 1)
			return alert("Nem módósítasz semmit [2]...");

		for(b = 0; b < adatok.length; b++)
		{
			if(b > 0) data = data + "&";
			data = data + adatok[b][0] + "=" + adatok[b][1];
		}

		disableDiv("ajax");

		$.ajax({
			type: "POST",
			url: "?ajax&ment",
			data: "id="+id+"&"+data,
			success: function(msg){
				alert(msg);
				ajaxtoltes = false;
				enableDiv("ajax");
			}
		});
	}
</script>

<? if(isset($uzenet)) echo Felhivas($uzenet); ?>
<? echo "Log név: ".$jatekos["LogNev"]; ?>
<center><h1>Karakterek szerkesztése</h1>

<br>
<input type="text" size="20" maxlength="20" id="nev" onkeydown="if(event.keyCode == 13) document.getElementById('gomb').click()">
<input type="button" value="Keres" id="gomb" style="padding: 1px" onclick="Keres()">
<img src="img/ajax-loader.gif" id="kep" style="display:none">

<br><br>

<table align="center" width="100%"><tr><td>
	<div id="ajax">
		Kérlek válassz ki egy karaktert a szerkesztéshez
	</div>
</td></tr></table></center>

<!--#############################################################################################################-->
<!--#############################################################################################################-->
<!--#############################################################################################################-->

<br><table width="100%" align="center" border="1">
				<tr class="cleartr cim">
					<td width="80%" class="nopadding" style="padding-top: 3px">Esemény</td>
					<td width="20%" class="nopadding" style="padding-top: 3px">Időpont</td>
				</tr><tr class="cleartr"><td colspan="2" class="nopadding"><br></td></tr>
<?
$sql = mysql_query("SELECT Log, Datum FROM log WHERE tipus='kszerk' ORDER BY Datum DESC LIMIT 5");
while($log = mysql_fetch_array($sql))
{
	echo"<tr>
			<td class='bal'>".$log["Log"]."</td>
			<td class='jobb'>".DatumFormat($log["Datum"])."</td>
		 </tr>";
}
?>
</table>

<!--#############################################################################################################-->
<!--#############################################################################################################-->
<!--#############################################################################################################-->

<? Lablec(); ?>