<?php
ini_set('display_errors','0');

function Lablec($van){
	if($van = 1){
		include("include/lab.php");
	}
}

function mailConvert($mail) {
	return str_replace(array("@", "."), array(" kukac ", " pont "), $mail);
}

function set_admin($name,$conn)
{
    $name = mysql_real_escape_string($name);
	$sql = "UPDATE `jatekosok` SET `Admin`='1' WHERE `Felhasznalonev`='" . $name ."'";
	$result = mysql_query($sql,$conn);
}

function unset_admin($name,$conn)
{
    $name = mysql_real_escape_string($name);
	$sql = "UPDATE `jatekosok` SET `Admin`='0' WHERE `Felhasznalonev`='" . $name ."'";
	$result = mysql_query($sql,$conn);
}

function mute($name,$conn)
{
	if(is_admin($name,$conn))return 0;
    $name = mysql_real_escape_string($name);
	$sql = "UPDATE `jatekosok` SET `Nemitva`='1' WHERE `Felhasznalonev`='" . $name ."'";
	$result = mysql_query($sql,$conn);
}

function unmute($name,$conn)
{
    $name = mysql_real_escape_string($name);
	$sql = "UPDATE `jatekosok` SET `Nemitva`='0' WHERE `Felhasznalonev`='" . $name ."'";
	$result = mysql_query($sql,$conn);
}

function is_muted($nick,$conn)
{
	$nick = mysql_real_escape_string($nick);
	$sql = "SELECT * FROM `jatekosok` WHERE `Felhasznalonev``='$nick' AND `Nemitva`='1'";
	$result = mysql_query($sql,$conn);
	$row = mysql_fetch_array($result);
	return mysql_num_rows($result);
}

if(get_magic_quotes_gpc())
{
	function stripslashes_array(&$arr)
	{
		foreach($arr as $k => &$v)
		{
			$nk = stripslashes($k);
			unset($arr[$k]);
			if (is_array($v))
				stripslashes_array($v);
			else
				$v = stripslashes($v);
			$arr[$nk] = &$v;
		}
	}

	stripslashes_array($_POST);
	stripslashes_array($_GET);
	stripslashes_array($_REQUEST);
	stripslashes_array($_COOKIE);
}
require("include/ms.php");
function msg($type, $msg)
{
	if($type=="1") // Ok
	{
		echo '<div class="msg msg-ok"><p><strong>'.$msg.'</strong></p></div>';
	} else if($type=="2"){ // No ok
		echo '<div class="msg msg-error"><p><strong>'.$msg.'</strong></p></div>';
	} else if($type=="3"){
		echo '<div class="msg msg-info"><p><strong>'.$msg.'</strong></p></div>';
	} else if($type=="4"){
		echo '<div class="msg msg-simple"><p><strong>'.$msg.'</strong></p></div>';
	}
}

if(isset($_GET['kijelentkezes']))
{
	unset($_COOKIE['user']);
	setcookie("user","-",time()-100);
	if(isset($_COOKIE['kivalasztott']))
	{
		setcookie("kivalasztott","-",time()-100);
	}
	header("Location: index.php");
}

if(isset($_COOKIE['user']))
{
	$user = $_COOKIE['user'];
	if(isset($user))
	{
		$usersorkereses = mysql_query("SELECT * FROM jatekosok WHERE `UID` = '".mysql_escape_string($user)."'");
		$fsor = mysql_fetch_assoc($usersorkereses);
	}
}
//$_COOKIE['kivalasztott'] = 2285;

if(isset($_COOKIE['kivalasztott']))
{
	$kivalasztott = $_COOKIE['kivalasztott'];
	if(isset($kivalasztott))
	{
		$kivalasztottsorkereses = mysql_query("SELECT * FROM jatekosok WHERE `UID` = '".mysql_escape_string($kivalasztott)."'");
		$sor = mysql_fetch_assoc($kivalasztottsorkereses);
	}
}
		
function gomb($szoveg, $link)
{
	echo '<div align="center">';
	echo '<table border="0" cellspacing="0" cellpadding="0" height="35">
			<tr style="cursor: pointer;"  onclick="window.location.href=\''.$link.'\';">
				<td style="width: 8px; font-size: 1px; background-image: url(img/gomb1.png);"></td>
				<td style="font-size: 16px; font-weight: bold; padding-right: 2px;  background-image: url(img/gomb2.png); padding-top: 1px;" class="gombocska">'.$szoveg.'</td>
				<td style="width: 26px; font-size: 1px; background-image: url(img/gomb3.png);"></td>
			</tr>
		</table>';
	echo '</div>';
}
function ucp_log($mi, $ignev, $szoveg)
{
	$datum = date("Y.m.d H:i");
	$mysql_log = mysql_query("INSERT INTO ucp_log (mi, ignev, szoveg, datum) VALUES ('$mi', '$ignev', '$szoveg','$datum')");
	if(!$mysql_log)
	{
		die('Hiba: '.mysql_error());
	}
}

function ListKep()
{
	echo "<img src='img/li.gif'>";
}
function IsFiredNox($k)
{
	$k = mysql_query("SELECT * FROM kapcsolat WHERE `nev` = 'FiredNox'");
	if(!mysql_num_rows($k)) return false;
	return true;
}

function IsScripter($k)
{
	$k = mysql_query("SELECT * FROM kapcsolat WHERE `Admin` = '5555'");
	if(!mysql_num_rows($k)) return false;
	return true;
}

function kihagy($mennyit)
{
	$mennyit = $m;
	for ($i = 0; $i <= $m; $i++) {echo "<br>";}
}
function VanIlyenFelhasznalo($n)
{
	$k = mysql_query("SELECT * FROM jatekosok WHERE `Felhasznalonev` = '".mysql_escape_string($n)."'");
	if(!mysql_num_rows($k)) return false;
	return true;
}

function RosszJelszo($n, $p)
{
	$k = mysql_query("SELECT * FROM jatekosok WHERE `Felhasznalonev` = '".mysql_escape_string($n)."' AND `Jelszo` = '".mysql_escape_string($p)."'");
	if(!mysql_num_rows($k)) return true;
	return false;
}

function VanIlyenKari($n)
{
	$k = mysql_query("SELECT * FROM jatekosok WHERE `Felhasznalonev` = '".mysql_escape_string($n)."'");
	if(!mysql_num_rows($k)) return false;
	return true;
}

function RosszPWKari($n, $p)
{
	$k = mysql_query("SELECT * FROM jatekosok WHERE `Felhasznalonev` = '".mysql_escape_string($n)."' AND `Jelszo` = '".mysql_escape_string($p)."'");
	if(!mysql_num_rows($k)) return true;
	return false;
}

function ValodiEmail($m)
{
	if(filter_var($m, FILTER_VALIDATE_EMAIL)) return true;
	return false;
}
function SzovegAnalizalas($szoveg, $speckarakterek = null, $ekezet = true, $betuk = true, $szamok = true)
{
	if($speckarakterek == null) $speckarakterek = ".,-_+<>&@{}[]()?:! ";
	$engedelyezett = "";
	if($betuk) $engedelyezett .= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	if($ekezet) $engedelyezett .= "ĂˇĂ©Ă­ĂłĂ¶Ĺ‘ĂşĂĽĹ±ĂĂ‰ĂŤĂ“Ă–ĹĂšĂśĹ°";
	if($szamok) $engedelyezett .= "0123456789";
	if(strlen($speckarakterek) > 0) $engedelyezett .= $speckarakterek;

	for($x = 0; $x < strlen($szoveg); $x++)
	{
		if(strpos($engedelyezett, $szoveg[$x]) === false)
			return 0;
	}
	return 1;
}

function IgenNem($mi)
{
	if($mi != 0) return "Igen";
	else return "Nem";
}

function VanNincs($mi)
{
	if($mi != 0) return "Van";
	else return "Nincs";
}

?>