<?

function mailConvert($mail) {
	return str_replace(array("@", "."), array(" kukac ", " pont "), $mail);
}

function SzokozKereses($szoveg)
{

	$szoveg = str_replace(" ", "_", $szoveg);
	
	
	$kereses=strpos($szoveg,"_");
	
	//az elej�r�l lev�lasztani a f�l�sleges _ vonalakat
	while ($kereses === 0) 
	{
		
		$szoveg=substr($szoveg, 1);
		$kereses=strpos($szoveg,"_");
	}
	
	//v�g�r�l lev�g�s
	
	
	$hossz=strlen($szoveg);
	
	$szovkeres=substr($szoveg, $hossz-1);
	
	$kereses=strpos($szovkeres,"_");
	
	
	
	while ($kereses === 0) 
	{
		$szoveg=substr($szoveg, 0, $hossz-1);
	  
		$hossz=strlen($szoveg);
		
		$szovkeres=substr($szoveg, $hossz-1);
		$kereses=strpos($szovkeres,"_");
		
	}



	return $szoveg;

}
function add_include_path($add) {
	$path = get_include_path();
	
	if(is_array($add)) {
		foreach($add as $p) {
			$path .= PATH_SEPARATOR . $p;
		}
	} else if(is_string($add)) {
		$path .= PATH_SEPARATOR . $add;
	} else return false;
	
	return set_include_path($path);
}

function loadClass($name)
{
	global $config;

	require_once($config["Path"]["class"] . "/$name.class.php");
}

function Ido( $unix )
{
	return date("Y-m-d H:i:s", $unix);
}

function StringToArray($szoveg, $darabolo = "&", $darabolo2 = "=")
{
	$array = Array();
	$s = explode("&",$szoveg);
	foreach($s as $k => $v){
		$v = explode("=", $v);
		$array[$v[0]] = $v[1];
	}
	return $array;
}

function JoCucc($link, $tipus)
{
	global $config;

	$ok = 0;
	if($tipus == "kep")
	{
		if(rendes_kep($link))
		{
			foreach($config["PK_Oldalak"]["kep"] as $oldal)
			{
				$x = strpos($link, $oldal);
				if($x > 5 && $x < 20)
				{
					$ok = 1;
					break;
				}
			}
		}
	}
	else
	{
		foreach($config["PK_Oldalak"]["video"] as $oldal)
		{
			$x = strpos($link, $oldal);
			if($x > 5 && $x < 15)
			{
				$ok = 1;
				break;
			}
		}
	}
	return $ok;
}

function Bannolva()
{
	global $jatekos;
	if($jatekos["Kivalasztva"] == 0)
	{
		$bancheck = mysql_query("SELECT ID FROM bans WHERE cim='".GetIP()."'");
		$db = mysql_num_rows($bancheck); mysql_free_result($bancheck); unset($bancheck);
		if($db > 0)
			return 1;
	}
	else
	{
		$bancheck = mysql_query("SELECT ID FROM bans WHERE cim='".$jatekos["Karakter"][$jatekos["Kivalasztva"]-1]["Nev"]."' OR cim='".GetIP()."'");
		$db = mysql_num_rows($bancheck); mysql_free_result($bancheck); unset($bancheck);
		if($db > 0)
			return 1;
	}
	return 0;
}

function Cim($szoveg, $meret = 95, $keret = true)
{
	return "<table class='".($keret ? "cimkeret" : "cim")."' width='".$meret."%'><tr><td>".$szoveg."</td></tr></table>";
}

function DatumFormat($ido, $tegnapelott_x = true, $tegnap_x = true, $ma_x = true)
{
	$time = time();
	$tegnapelott = date("Y-m-d", $time-172800);
	$tegnap = date("Y-m-d", $time-86400);
	$ma = date("Y-m-d");
	$holnap = date("Y-m-d", $time+86400);
	$holnaputan = date("Y-m-d", $time-172800);

	if(is_numeric($ido)) $ido = date("Y-m-d H:i:s", $ido);
	$dat_e = explode(" ", $ido);

	if($tegnapelott_x && $dat_e[0] == $tegnapelott) return "Tegnap előtt ".$dat_e[1];
	elseif($tegnap_x && $dat_e[0] == $tegnap) return "Tegnap ".$dat_e[1];
	elseif($ma_x && $dat_e[0] == $ma) return "Ma ".$dat_e[1];
	elseif($dat_e[0] == $holnap) return "Holnap ".$dat_e[1];
	elseif($dat_e[0] == $holnaputan) return "Holnap után ".$dat_e[1];
	else return $ido;
}

function SeeLOG($tipus, $log, $ki, $kinev, $olvasva = 0, $nincsip = 0)
{
	$adminlogok = Array("karelf", "karelut", "accelf", "accelut", "tarself", "tarselut", "ban", "unban", "kszerk", "tesztok", "tesztfail");
	if(in_array($tipus, $adminlogok)) $admin = 1; else $admin = 0;

	if($nincsip) $ip = "0.0.0.0"; else $ip = GetIP();

	//return mysql_query("INSERT INTO `log`(AID, ANev, Tipus, Log, Datum, Olvasva)
	//					VALUES('".$ki."', '".$kinev."', '".$tipus."', '".$log."', '".date("Y-m-d H:i:s")."', '".$olvasva."')");
	return mysql_query('INSERT INTO `log`(AID, ANev, Tipus, Log, Datum, Olvasva, IP, Admin)
						VALUES("'.$ki.'", "'.$kinev.'", "'.$tipus.'", "'.$log.'", "'.date("Y-m-d H:i:s").'", "'.$olvasva.'", "'.$ip.'", "'.$admin.'")');
}

function IsClint()
{
	global $jatekos;
	if($jatekos["Belepve"] && $jatekos["Nev"] == "Clint")
		return 1;
	return 0;
}
function IsTerno() //ideiglenes tesztekhez kiírásokhoz
{
	global $jatekos;
	if($jatekos["Belepve"] && $jatekos["Nev"] == "Terno")
		return 1;
	return 0;
}

function IsScripter()
{
	global $jatekos, $config;
	if($jatekos["Belepve"] && in_array($jatekos["Nev"], $config["Scripter"]))
		return 1;
	return 0;
}

function Error($link = "")
{
	global $config;
	if($link == "") $link = $config["Lap"];
	$_SERVER['REDIRECT_URL'] = $link . ".php";
	require_once("404.php");
	exit;
}

function CheckAdmin($link = false)
{
	global $config, $jatekos;
	if($link === false) $link = $config["Lap"];
	$ok = false;
	foreach($config["AdminTeruletek"] as $admin)
	{
		if($admin["link"] == $link)
		{
			if(is_array($admin["admin"]) && in_array($jatekos["Nev"], $admin["admin"]) ||
			  !is_array($admin["admin"]) && $admin["admin"] <= $jatekos["Admin"])
				$ok = true;
			break;
		}
	}
	return $ok;
}

function HibasRuha($ruha)
{
	global $config;
	if($ruha < 0 || $ruha > 299 || in_array($ruha, $config["HibasRuhak"]))
		return 1;
	else
		return 0;
}

function WebInfo()
{

	//$stats = explode(' ', substr(exec('uptime'), -14));
	$stat = exec('uptime');
	preg_match('/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/', $stat, $stats);

	$av = round((($stats[0] + $stats[1] + $stats[2]) / 3));

	echo "<b>M:</b> ".
		number_format(memory_get_usage() / 1024 / 1024, 2, '.', '') .
		", " .
		number_format(memory_get_usage(true) / 1024 / 1024, 2, '.', '') .
		" | <b>C:</b> ". $av;

}

function SendMail($cimzett, $cim, $uzenet, $kuldo, $kuldomail, $html = true, $charset = "UTF-8")
{
	global $config;
	
	if($kuldo == null) $kuldo = $config['SNev'];
	if($kuldomail == null) $kuldomail = 'noreply@' . $config['WNev'];
		
	if($html)
	{
		$szoveg = "
			<html>
			<head>
			  <title>". $cim ."</title>
			  <style type='text/css'>
			  a,a:visited{color:blue; text-decoration:none;}
			  a:hover{color:red; text-decoration:none;}
			  </style>
			</head>
			". $uzenet ."
			</html>
		";
	}
	else
		$szoveg = $uzenet;

	$headerek = 'MIME-Version: 1.0' . "\r\n";
	if($html) $headerek .= 'Content-type: text/html; charset=' . $charset . "\r\n";
	else $headerek .= 'Content-type: text/plain; charset=' . $charset . "\r\n";
	$headerek .= 'To: '. $cimzett . "\r\n";
	$headerek .= 'From: '.$kuldo.' <'.$kuldomail.'>' . "\r\n";
	$headerek .= 'Reply-To: '. $kuldomail . "\r\n";


	require_once("include/phpmailer/class.phpmailer.php");
	$mail=new PHPMailer();

	$mail->IsHTML($html);
	$mail->IsSMTP(true);
	$mail->Mailer     = "smtp";
	$mail->SMTPAuth   = true;
	$mail->SMTPDebug  = false;
	$mail->SMTPSecure = "ssl";
	$mail->Host       = "mail.szerverem.hu";
	$mail->Port       = 465;

	$mail->Username = "marcell@classrpg.net";
	$mail->Password = "Football15@";

	$mail->From = $kuldomail;
	$mail->FromName = $kuldo;
	$mail->Subject = $cim;
	$mail->Body = $szoveg;
	$mail->CharSet = 'UTF-8';
	//$mail->AltBody = "xxx";

	$mail->WordWrap = 70;
	$mail->AddAddress($cimzett);

	return $mail->Send();
	//mail($cimzett, $cim, $mail, $headerek);
}

function BizNev($biznev)
{
	$csere = Array("", "~R~", "~G~", "~B~", "~W~", "~Y~", "~P~", "~L~", "~N~", "~H~");
	$mire = Array("", "<font color='red'>", "<font color='green'>", "<font color='#1087ff'>", "<font color='white'>", "<font color='yellow'>", "<font color='#e608ff'>", "<font color='#555555'>", "<br>", "");

	$nev = str_replace($csere, $mire, strtoupper($biznev), $darab);
	for($x = 1; $x <= $darab; $x++) $nev .= "</font>";

	return $nev;
}

function Generator($darab, $spec = 0)
{
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	
	if($spec == 1)
		$chars .= "#&@.-=%!+$";
	
	$szoveg = "";
	for($x = 0; $x < $darab; $x++)
		$szoveg .= $chars[rand(0, strlen($chars)-1)];
	return $szoveg;
}

function Print_r2($valtozo)
{
	echo "<pre>";
	print_r($valtozo);
	echo "</pre>";
}

function FrakcioNeve($id)
{
	global $config;
	if($id < 1 || $id > count($config["Frakciok"]))
		return "Nincs";
	else
		return $config["Frakciok"][$id];
}

function Atiranyit($fajl) {
    if (!headers_sent())
        header('Location: '.$fajl);
    else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$fajl.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$fajl.'" />';
        echo '</noscript>';
    }
}

function SzovegAnalizalas($szoveg, $speckarakterek = null, $ekezet = true, $betuk = true, $szamok = true)
{
	if($speckarakterek == null) $speckarakterek = ".,-_+<>&@{}[]()?:! ";
	$engedelyezett = "";
	if($betuk) $engedelyezett .= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	if($ekezet) $engedelyezett .= "áéíóöőúüűÁÉÍÓÖŐÚÜŰ";
	if($szamok) $engedelyezett .= "0123456789";
	if(strlen($speckarakterek) > 0) $engedelyezett .= $speckarakterek;

	for($x = 0; $x < strlen($szoveg); $x++)
	{
		if(strpos($engedelyezett, $szoveg[$x]) === false)
			return 0;
	}
	return 1;

}

function Felhivas($szoveg, $hiba = 0)
{
	//return "<div class='felhivas'>".$szoveg."</div>";
	return '
		<div class="ui-widget">
			<div class="ui-state-'.($hiba ? "error" : "highlight").' ui-corner-all" style="padding: 0.7em;">
				<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
				<strong>'.$szoveg.'</strong></p>
			</div>
		</div>
	';
}

function ConnectMySQL()
{
	global $config, $ConnectedMySQL;

	if(!defined("TEST_SQL"))
	{
		$conn = @mysql_connect($config["SQL"]["Host"], $config["SQL"]["User"], $config["SQL"]["Pass"]);
		mysql_select_db($config["SQL"]["DB"]);
	}
	else
	{
		$conn = @mysql_connect($config["TestSQL"]["Host"], $config["TestSQL"]["User"], $config["TestSQL"]["Pass"]);
		mysql_select_db($config["TestSQL"]["DB"]);
		define("TEST_SQL_CONNECTED", true);
	}

	if(!$conn)
		return 0;

	mysql_query('set names utf8');
	mysql_query('set character set utf8');
	$ConnectedMySQL = true;
	return $conn;
}

function ConnectWebMySQL()
{
	global $config;

	$conn = @mysql_connect($config["WebSQL"]["Host"], $config["WebSQL"]["User"], $config["WebSQL"]["Pass"]);
	if(!$conn)
		return 0;

	mysql_select_db($config["WebSQL"]["DB"]);
	mysql_query('set names utf8');
	mysql_query('set character set utf8');

	return $conn;
}

function GetIP()
{
    if(!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    else
      $ip=$_SERVER['REMOTE_ADDR'];

    return $ip;
}

function Hiba($hiba, $fejlec = false, $data = true)
{
	if($fejlec) Fejlec();
	echo Felhivas($hiba);
	Lablec($data);
	exit;
}

function validDate($date, $nagyobbIdo = false)
{
	if( preg_match("/^201[2-9]\-[01][0-9]\-[0-3][0-9] [0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/", $date) )
	{
		$dates = explode(" ", $date);
		$dates = explode("-", $dates[0]);
		if(checkdate($dates[1], $dates[2], $dates[0]))
		{
			$time = strtotime($date);
			$timeNow = time();
			return (!$nagyobbIdo || $nagyobbIdo && $time > $timeNow ? $time : 0);
		}
	}
	
	return 0;
}

function toDate($unix)
{
	return (is_numeric($unix) && $unix > 0 ? date("Y-m-d H:i:s", $unix) : $unix);
}

function Fejlec($kell = "")
{
	global $config, $ConnectedMySQL, $jatekos, $SeeGlobal, $kapcsolat;
	
	if($kell != "")
	{
		if(!is_array($kell))
			$_fejlec_extra = Array($kell);
		else
			$_fejlec_extra = $kell;
	}
	else
		$_fejlec_extra = Array();

	require_once("include/fejlec.php");
	//echo file_get_contents("include/fejlec.php");
}

function AjaxExit($szoveg = null)
{
	Lablec(false, $szoveg, true);
}

function Lablec($data = true, $szoveg = null, $exit = false)
{
	global $config, $ConnectedMySQL, $jatekos, $SeeGlobal, $SzerverAdatok, $kapcsolat;
	if(!$data)
	{
		if($szoveg != null) echo $szoveg;
		if($ConnectedMySQL) mysql_close($kapcsolat);
		if($exit) exit;
	}
	else
		require_once("include/jobbresz.php");
	//echo file_get_contents("include/jobbresz.php");
}

function SeeEncode($string, $szerver = false)
{
	if($szerver)
		$pass = strtoupper(md5($string));
	else
		$pass = strrev(md5(strrev($string)));
	return $pass;
}

function RolePlayNev($nev)
{
//	if(strpos($nev, "_") === false || strpos($nev, "[") !== false || strpos($nev, "]") !== false)
//		return 0;

	$regexp = "/^([A-Z]+[a-z]*_)?[A-Z]+[a-z]*_[A-Z]+[a-z]*$/";
	$hossz = strlen($nev);

	if($hossz >= 5 && $hossz <= 20 && preg_match($regexp, $nev))
		return 1;
	else
		return 0;

	/*$alahuzas = 0;
	$hossz = strlen($nev);

	for($x = 0; $x < $hossz; $x++)
	{
		if($nev[$x] == "_")
		{
			if($x == 0 || $x == ($hossz - 1))
				return 0;
			else
				$alahuzas++;

			if($nev[$x + 1] == strtolower($nev[$x + 1]))
				return 0;
		}
		if($x == 0 && $nev[0] == strtolower($nev[0]))
			return 0;

		$ascii = ord($nev[$x]);
		if($ascii >= 65 && $ascii <= 90 || $ascii >= 97 && $ascii <= 122 || $ascii == ord('_'))
			$jobetu = 1;
		else
			$jobetu = 0;

		if($jobetu != 1)
			return 0;

	}
	if($alahuzas < 1 || $alahuzas > 2)
		return 0;
	return 1;*/
}

function rendes_kep($url)
{
    $curl = curl_init($url);

    //don't fetch the actual page, you only want to check the connection is ok
    curl_setopt($curl, CURLOPT_NOBODY, true);

    //do request
    $result = curl_exec($curl);

    $ret = false;

    //if request did not fail
    if($result !== false)
    {
        //if request was ok, check response code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$mime = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

		$elfogadott = array("image/jpeg", "image/png", "image/gif");
        if ($statusCode == 200 && in_array($mime, $elfogadott))
            $ret = true;
    }

    curl_close($curl);

    return $ret;
}

?>