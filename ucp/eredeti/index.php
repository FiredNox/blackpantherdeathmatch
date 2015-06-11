<?php
$fatal_msg = '<font color=red>FIGYELEM! KARBANTARTÁS FOLYIK!!!</font>';
if(isset($fatal_msg))
{
	if($fatal_msg != "")
	{
		echo '<div align="center">';
		echo '<div class="fatal_msg fatal_msg-ok"><p><strong>'.$fatal_msg.'</strong> <i>By: SilentZone</i></p></div>';
		echo '</div>';
		
	}
}
ini_set('display_errors','0');
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
session_start();
//mysql_connect("localhost", "root", "");
//mysql_select_db("hellrpg");
mysql_connect("s2.fps-system.eu", "brucp", "asd123") or die(mysql_error());
mysql_select_db("bluespot");
date_default_timezone_set('Europe/Budapest');
function msg($type, $msg)
{
	if($type=="1") // Ok
	{
		echo '<div class="msg msg-ok"><p><strong>'.$msg.'</strong></p></div>';
	} else if($type=="2"){ // No ok
		echo '<div class="msg msg-error"><p><strong>'.$msg.'</strong></p></div>';
	} else {
		echo '<div class="msg msg-info"><p><strong>'.$msg.'</strong></p></div>';
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
		$usersorkereses = mysql_query("SELECT * FROM ucpuserek WHERE `ID` = '".mysql_escape_string($user)."'");
		$fsor = mysql_fetch_assoc($usersorkereses);
		if($fsor['F_skinvalaszt'] != '0')
		{
			if(!isset($_GET['menu']))
			{
				if($_GET['menu'] != 'karakterek')
				{
					header("Location: index.php?menu=karakterek&frakcioskinvaltas");
				}
			}
		}
	}
}
//$_COOKIE['kivalasztott'] = 2285;

if(isset($_COOKIE['kivalasztott']))
{
	$kivalasztott = $_COOKIE['kivalasztott'];
	if(isset($kivalasztott))
	{
		$kivalasztottsorkereses = mysql_query("SELECT * FROM playerek WHERE `ID` = '".mysql_escape_string($kivalasztott)."'");
		$sor = mysql_fetch_assoc($kivalasztottsorkereses);
	}
}

/*Közösségi gombok*/
echo"
<div class='social-buttons'>
	<a id='facebook-btn' href='https://www.facebook.com/pages/Replay-GF/567266753366201?bookmark_t=page' target='_blank'>
		<span class='social-icon'><span class='social-text'>Kövess minket a Facebook-on!</span></span>
	</a>
	<a id='twitter-btn' href='' target='_blank'>
		<span class='social-icon'><span class='social-text'>Kövess minket a Twitter-en!</span></span>
	</a>
	<a id='google-btn' href='' target='_blank'>
		<span class='social-icon'><span class='social-text'>Kövess minket a Google+-on!</span></span>
	</a>
	<a id='rss-btn' href='' target='_blank'>
		<span class='social-icon'><span class='social-text'>Kövess minket Youtube-on!</span></span>
	</a>
</div>";
		
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

function VanIlyenFelhasznalo($n)
{
	$k = mysql_query("SELECT * FROM ucpuserek WHERE `Felhasznalonev` = '".mysql_escape_string($n)."'");
	if(!mysql_num_rows($k)) return false;
	return true;
}

function RosszJelszo($n, $p)
{
	$k = mysql_query("SELECT * FROM ucpuserek WHERE `Felhasznalonev` = '".mysql_escape_string($n)."' AND `Jelszo` = '".mysql_escape_string($p)."'");
	if(!mysql_num_rows($k)) return true;
	return false;
}

function VanIlyenKari($n)
{
	$k = mysql_query("SELECT * FROM playerek WHERE `Nev` = '".mysql_escape_string($n)."'");
	if(!mysql_num_rows($k)) return false;
	return true;
}

function RosszPWKari($n, $p)
{
	$k = mysql_query("SELECT * FROM playerek WHERE `Nev` = '".mysql_escape_string($n)."' AND `Pass` = '".mysql_escape_string($p)."'");
	if(!mysql_num_rows($k)) return true;
	return false;
}

function ValodiEmail($m)
{
	if(filter_var($m, FILTER_VALIDATE_EMAIL)) return true;
	return false;
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

$bnevek = array(0 => "-", "RCPD", "Fegyenctelep", "NAV", "FBI", "Admin", "Admin 2");

$szarmazasok = array(0 => "Európa", "USA", "Európa", "Ázsia");

$munkak = array(0 => 
	"Nincs",
	"Detektív",
	"Ügyvéd",
	"Prostituált",
	"Drog díler",
	"Autótolvaj",
	"---",
	"Testõr",
	"Fegyverkereskedõ",
	"---", 
	"Úttisztító",
	"Boxoló",
	"Busz Sofõr",
	"Újságos",
	"Hacker",
	"Kamionos",
	"Farmer",
	"Funyíró",
	"Építész",
	"Páncélkészítõ",
	"Kukás",
	"Betöro",
	"Pizzafutár",
	"Favágó",
	"Targoncás");

$fract = array(0 => 'Nincs', 
					'Rendõrség', 
					'FBI', 
					'<font color=purple>Ballas</font>', 
					'OMSZ', 
					'Seima Berezovsky', 
					'Faust Maffia', 
					'Önkormányzat', 
					'Bratva', 
					'Riporter', 
					'T.A.X.I.', 
					'<font color=yellow>Los Santos Vagos</font>', 
					'Bloods', 
					'<font color=lightblue>Los Surenos</font>',
					'D.N.I.',
					'La Mana Nera', 
					'Oktatók', 
					'<font color=green>Grove Street Families</font>', 
					'Autószerelõk', 
					'Los XVIII', 
					'N.A.V.', 
					'La Cosa Nostra', 
					'Tûzoltóság',
					'Yakuza', 
					'Mexikói Maffia', 
					'SWAT (fõ)');
$kocsinevek = array(0 => "Landstalker","Bravura","Buffalo","Linerunner","Perennial","Sentinel","Dumper","Firetruck","Trashmaster",
        "Stretch","Manana","Infernus","Voodoo","Pony","Mule","Cheetah","Ambulance","Leviathan","Moonbeam",
        "Esperanto","Taxi","Washington","Bobcat","Whoopee","BFInjection","Hunter","Premier","Enforcer",
        "Securicar","Banshee","Predator","Bus","Rhino","Barracks","Hotknife","Trailer","Previon","Coach",
        "Cabbie","Stallion","Rumpo","RCBandit","Romero","Packer","Monster0","Admiral","Squalo","Seasparrow",
        "Pizzaboy","Tram","Trailer","Turismo","Speeder","Reefer","Tropic","Flatbed","Yankee","Caddy","Solair",
        "Berkley'sRCVan","Skimmer","PCJ-600","Faggio","Freeway","RCBaron","RCRaider","Glendale","Oceanic",
        "Sanchez","Sparrow","Patriot","Quad","Coastguard","Dinghy","Hermes","Sabre","Rustler","ZR350","Walton",
        "Regina","Comet","BMX","Burrito","Camper","Marquis","Baggage","Dozer","Maverick","NewsChopper","Rancher",
        "FBIRancher","Virgo","Greenwood","Jetmax","Hotring0","Sandking","BlistaCompact","Police Maverick",
        "Boxvillde","Benson","Mesa","RCGoblin","HotringA","HotringB","Bloodring","Rancher",
        "SuperGT","Elegant","Journey","Bike","Mountain","Beagle","Cropduster","Stunt","Tanker","Roadtrain",
        "Nebula","Majestic","Buccaneer","Shamal","Hydra","FCR-900","NRG-500","HPV1000","Cement","TowTruck",
        "Fortune","Cadrona","FBITruck","Willard","Forklift","Tractor","Combine","Feltzer","Remington","Slamvan",
        "Blade","Freight","Streak","Dodgem","Vincent","Bullet","Clover","Sadler","Firetruck","Hustler","Intruder",
        "Primo","Cargobob","Tampa","Sunrise","Merit","Utility","Nevada","Yosemite","Windsor","MonsterA","MonsterB",
        "Uranus","Jester","Sultan","Stratium","Elegy","Raindance","RCTiger","Flash","Tahoma","Savanna","Bandito",
        "FreightFlat","StreakCarriage","Kart","Mower","Dune","Sweeper","Broadway","Tornado","AT400","DFT30",
        "Huntley","Stafford","BF400","NewsVan","Tug","PetrolTrailer","Emperor","Wayfarer","Euros","Hotdog","Club",
        "FreightBox","Trailer","Andromada","Dodo","RCCam","Launch","LSPD","SFPD","SFPD",
        "Ranger","Picador","SWAT","Alpha","Phoenix","Glendale","Sadler","Luggage","Luggage","Stairs",
        "Boxville","Tiller","UtilityTrailer","Stratum");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-2"/>
<meta name="description" content="description"/>
<meta name="keywords" content="keywords"/> 
<meta name="author" content="author"/> 
<link rel="stylesheet" type="text/css" href="default.css?version=100" media="screen"/>
<title>User Control Panel</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">
</script>
</head>

<!-- default margin = default layout -->
<body>
<div align="center">
<div style="width: 1088px;">
<div class="container">
	<div class="header"></div>
	<div class="nav">
		<a href="index.php"><font color=white>Fõoldal</font></a>
		<?php
		if(isset($user)) 
		{
			echo '<a href="index.php?menu=karakterek"><font color=white>Karakterek</font></a>';
			/*echo '<a href="index.php?menu=log"><font color=white>Log</font></a>
			<a href="index.php?menu=muveletek"><font color=white>Mûveletek</font></a>';*/
		}
		echo '
		<a href="index.php?menu=statisztika"><font color=white>Statisztika</font></a>';
		if(!isset($user))
		{
			echo '<a href="index.php?menu=reg"><font color=white>Regisztráció</font></a>';
		}
		if(isset($user))
		{
			if(isset($_COOKIE['kivalasztott']))
			{
				if($sor['Member'] != "0")
				{
					echo '<a href="index.php?menu=frakcio"><font color=white>Frakció</font></a>';
				}
			}
			if(isset($_COOKIE['kivalasztott']))
			{
				if($sor['Hitman'] > '0')
				{
					echo '<a href="index.php?menu=hitman"><font color=white>Hitman</font></a>';
				}
			}
			if(isset($_COOKIE['kivalasztott']))
			{
				if($sor['Swat'] > '0')
				{
					echo'<a href="index.php?menu=swat"><font color=white>SWAT</font></a>';
				}
			}
			if(isset($_COOKIE['kivalasztott']))
			{
				if($sor['nid'] > '0')
				{
					echo'<a href="index.php?menu=nid"><font color=white>NID</font></a>';
				}
			}
			if(isset($sor['Nev']))
			{
				if($sor['Member'] == "3" OR $sor['Member'] == "11" OR $sor['Member'] == "12" OR $sor['Member'] == "13" OR $sor['Member'] == "17" OR $sor['Member'] == "19")
				{
					echo '<a href="index.php?menu=teruletek"><font color=white>Területek</font></a>';
				}
			}
			if(isset($kivalasztott))
			{	if($sor['Admin'] > '0' OR $fsor['AAA'] > '0')
				{
					echo '<a href="index.php?menu=admin"><font color=white>Admin</font></a>';
				}
			}
			/*if(isset($user))
			{
				echo '<a href="index.php?menu=tamogatas"><font color=yellow>Támogatás</font></a>';
			}*/
			/*echo '
			<a href="index.php?menu=jatekosok"><font color=white>Játékosok</font></a>
			<a href="index.php?menu=frakcio"><font color=white>Frakció</font></a>';
			if(isset($sor))
			{
				if($sor['Admin'] > 0) echo '<a href="index.php?menu=admin"><font color=#1BE035>Admin</font></a>';
			}
			echo '<a href="index.php?menu=tamogatas"><font color=yellow>Támogatás</font></a>
			<a href="index.php?menu=kapcsolat"><font color=yellow>Kapcsolat</font></a>
			<a href="index.php?menu=egyeb"><font color=white>Egyéb</font></a>';*/
		}
		/*echo '<a href="index.php?menu=tamogatas"><font color=yellow>Támogatás</font></a>';*/
		echo '<a href="index.php?menu=kapcsolat"><font color=red>Admin STAFF</font></a>';
		/*echo '<a href="index.php?menu=egyeb">Egyéb</a>';*/
		
		?>
		<div class="clearer"><span></span></div>
	</div>

	<div class="main">
	
		<div class="left">

			<div class="content">

				<?php
				
				if(isset($_POST['login']))
				{
					echo "<h1>Bejelentkezés</h1>";
					$hash = hash('whirlpool', $_POST['jelszo']);
					if($_POST['felhasznalo'] == "" || $_POST['jelszo'] == "")
						msg("2", "Minden mezõ kitöltése kötelezõ!");
					else if(!VanIlyenFelhasznalo($_POST['felhasznalo']) || RosszJelszo($_POST['felhasznalo'], $hash))
						msg("2", "Hibás felhasználónév / jelszó!");
					else
					{
						$getfsor_q = mysql_query("SELECT * FROM ucpuserek WHERE `Felhasznalonev` = '".mysql_escape_string($_POST[felhasznalo])."'");
						$getfsor = mysql_fetch_array($getfsor_q);
						if(isset($_POST['emlekezz']))
						{
							setcookie("user",$getfsor['ID'],time()+31536000);
							if($getfsor['Kari1'] != '-1')
							{
								setcookie("kivalasztott", $getfsor['Kari1'], time()+31536000);
							}
							$ip = $_SERVER['REMOTE_ADDR'];
							ucp_log("login","".$_POST['felhasznalo']."", "belépett ".$ip."-vel!");
							header("Location: index.php");
						} else {
							setcookie("user",$getfsor['ID'],time()+1800);
							if($getfsor['Kari1'] != '-1')
							{
								setcookie("kivalasztott", $getfsor['Kari1'], time()+1800);
							}
							$ip = $_SERVER['REMOTE_ADDR'];
							ucp_log("login","".$_POST['felhasznalo']."", "belépett ".$ip."-vel!");
							header("Location: index.php");
						}
					}
				}
				else
				{
					if(isset($_GET['menu']))
					{
					if($_GET['menu'] == "kapcsolat")
					{
						include("oldal/kapcsolat.php");
					}
					else if($_GET['menu'] == "egyeb")
					{
						include("oldal/egyeb.php");
					}
					else if($_GET['menu'] == "muveletek")
					{
						include("oldal/muveletek.php");
					}
					else if($_GET['menu'] == "statisztika")
					{
						include("oldal/statisztika.php");
					}
					else if($_GET['menu'] == "karakterek" && isset($user))
					{
						include("oldal/karakterek.php");
					}
					else if($_GET['menu'] == "admin")
					{
						include("oldal/admin.php");
					}
					else if($_GET['menu'] == "frakcio" && isset($user) && isset($kivalasztott))
					{
						include("oldal/frakcio.php");
					}
					else if($_GET['menu'] == "teruletek" && isset($user) && isset($kivalasztott))
					{
						include("oldal/teruletek.php");
					}
					else if($_GET['menu'] == "hitman" && isset($user) && isset($kivalasztott))
					{
						include("oldal/hitman.php");
					}
					else if($_GET['menu'] == "swat" && isset($user) && isset($kivalasztott))
					{
						include("oldal/swat.php");
					}
					else if($_GET['menu'] == "nid" && isset($user) && isset($kivalasztott))
					{
						include("oldal/nid.php");
					}
					else if($_GET['menu'] == "tamogatas")
					{
						include("oldal/tamogatas.php");
					}
					else if(!isset($_GET['menu']))
					{
						include("oldal/main.php");
					}
					else if($_GET['menu'] == "reg" && !isset($user))
					{
						include("oldal/reg.php");
					}
					else if($_GET['menu'] == "elfelejtett" && !isset($user))
					{
						include("oldal/elfelejtett.php");
					}
					else
					{
						echo "<h1><font color=red><b>HIBA</b></font></h1><center>";
						echo "<img src='http://www.darklandrecordings.com/files/error.png'><br>
						<font size=6 color=red><b>A kért oldal nem található!</b></font>";
					}
				} else {
					include("oldal/main.php");
				}
				}
				
				?>
				
			</div>

		</div>

		<div class="right">

			<div class="subnav">

				<?php
				if(!isset($user))
				{
					?>
					<center><font size=4>Bejelentkezés</font><br><br>
					<form method=post id=login>
					<input type=name name=felhasznalo placeholder=Felhasználónév><br>
					<input type=password name=jelszo placeholder=Jelszó><br>
					Jegyezzen meg <input type=checkbox name=emlekezz value="1"><br>
					<input type=submit name=login value=Bejelentkezés>
					</form>
					<a href="index.php?menu=reg">Regisztráció</a><br>
					<a href="index.php?menu=elfelejtett">Elfelejtett jelszó</a>
					<?php
				}
				else
				{
					if(isset($kivalasztott))
					{
						$neme = "Nõ";
						if($sor['Sex'] == 1) $neme = "Férfi";
						$kinfo = "<img src='skinek/Skin_$sor[Model].png'><br><b><font color=yellow>Kiválasztott karakter:</font></b> <font color=white>$sor[Nev]</font><br>
						<b><font color=yellow>Neme:</font></b> <font color=white>$neme</font><br>
						<b><font color=yellow>Kor:</font></b> <font color=white>$sor[Age]</font><br>
						<b><font color=yellow>Frakció:</font></b> <font color=white>".$fract[$sor['Member']]."</font><br>
						<b><font color=yellow>Fõmunka:</font></b> <font color=white>".$munkak[$sor['Job1']]."</font><br>
						<b><font color=yellow>Másodmunka:</font></b> <font color=white>".$munkak[$sor['Job2']]."</font><br>";
						
					}
					else $kinfo = "<b><font color=yellow>Kiválasztott karakter:</font></b> <font color=white>Nem található kiválasztott karakter! <br>Karakter kiválasztásához kattints <a href=index.php?menu=karakterek>ide</a>!";
					echo "<center><b><font color=yellow size=3>Üdvözöllek, $fsor[Felhasznalonev]!</font><br><br><hr><br>
					$kinfo</font><br>
					<div class='subnav_gomb_leader' onclick='window.location.href=\"index.php?menu=muveletek&jelszovalt\";'>Jelszóváltás</div><br>
					<div class='subnav_gomb_leader' onclick='window.location.href=\"index.php?kijelentkezes\";'>Kijelentkezés</div>";
				}
				?>
			</div>
			<?php 
			if(isset($_GET['menu']))
			{
				if($_GET['menu'] == "admin")
				{
					if(isset($_GET['frakciok']))
					{
						if(isset($_GET['id']))
						{
							echo '<div style="padding-top:20px;"></div>
								<div class="subnav" style="border-top: 1px solid #02afd8;">
									<div align="center" style="color: #ff0000; font-size: 15px">'.$fract[$_GET['id']].'</div>
									<div align="center" style="color: #ffffff; font-size: 12px;">Adminnal választva</div>
									<br><br><hr><br>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&frakciok&id='.$_GET['id'].'\';">Információk</div>
									<div style="padding-top: 5px;"></div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&frakciok&id='.$_GET['id'].'&tagok\';">Frakció tagok</div>
									<div style="padding-top: 5px;"></div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&frakciok&id='.$_GET['id'].'&szef\';">Frakció széf</div>
									<div style="padding-top: 5px;"></div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&frakciok&id='.$_GET['id'].'\';">Fegyverraktár</div>
									<div style="padding-top: 5px;"></div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&frakciok&id='.$_GET['id'].'&jarmuvek\';">Frakció jármûvek</div>
									<div style="padding-top: 5px;"></div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&frakciok&id='.$_GET['id'].'&fizetes\';">Frakció fizetések</div>
									<div style="padding-top: 15px;"></div>
									<br><hr><br>
									<div class="subnav_gomb_leader" onclick="window.location.href=\'index.php?menu=admin&frakciok&id='.$_GET['id'].'&tagfelvetel\';">Tag felvétel</div>
									<div class="subnav_gomb_leader" onclick="window.location.href=\'index.php?menu=admin&frakciok&id='.$_GET['id'].'&kiruglista\';">Tag kirúgás</div>
									<div class="subnav_gomb_leader" onclick="window.location.href=\'index.php?menu=admin&frakciok&id='.$_GET['id'].'&rangadaselvetel\';">Rangok állítása</div>
								</div>';
									
						}
					}
				}
			}
			if(isset($kivalasztott))
			{
				if($sor['Member'] != "0")
				{
					if(isset($_GET['menu']))
					{
						if($_GET['menu'] == "frakcio")
						{
							echo '<div style="padding-top:20px;"></div>
								<div class="subnav" style="border-top: 1px solid #02afd8;">
									<div align="center" style="color: #ffff00; font-size: 15px">'.$fract[$sor['Member']].'</div>
									<br><br><hr><br>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=frakcio\';">Információk</div>
									<div style="padding-top: 5px;"></div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=frakcio&tagok\';">Frakció tagok</div>
									<div style="padding-top: 5px;"></div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=frakcio&szef\';">Frakció széf</div>
									<div style="padding-top: 5px;"></div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=frakcio\';">Fegyverraktár</div>
									<div style="padding-top: 5px;"></div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=frakcio&jarmuvek\';">Frakció jármûvek</div>
									<div style="padding-top: 5px;"></div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=frakcio&fizetes\';">Frakció fizetések</div>
									<div style="padding-top: 5px;"></div>';
							if($sor['Leader'] == $sor['Member'])
							{
								echo '<br><hr><br>';
								echo '<div class="subnav_gomb_leader" onclick="window.location.href=\'index.php?menu=frakcio&tagfelvetel\';">Tag felvétel</div>
									<div class="subnav_gomb_leader" onclick="window.location.href=\'index.php?menu=frakcio&kiruglista\';">Tag kirúgás</div>
									<div class="subnav_gomb_leader" onclick="window.location.href=\'index.php?menu=frakcio&rangadaselvetel\';">Rangok állítása</div>
									<div class="subnav_gomb_leader" onclick="window.location.href=\'index.php?menu=frakcio&beallitasok\';">Beállítások</div>';
							}
							echo '</div>';
						}
					}
				}
				if(isset($_GET['menu']))
				{
					if($_GET['menu'] == "karakterek")
					{
						echo '<div style="padding-top: 20px;"></div>
								<div class="subnav" style="border-top: 1px solid #02afd8;">
									<div align="center" style="color: #ffff00; font-size: 15px;">Karakter kezelés</div>
									<br><hr><br><br>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=karakterek&kocsi\';">Kocsi</div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=karakterek&haz\';">Ház</div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=karakterek&biznisz\';">Biznisz</div>
									<div style="padding-top: 5px; padding-bottom: 5px;"><hr></div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=karakterek&ruhatar\';">Ruhabolt</div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=karakterek&bankszamla\';">Bankszámla</div>
									<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=karakterek&telefon\';">Telefon</div>
								</div>';
					}
				}
				if(isset($_GET['menu']))
				{
					if($_GET['menu'] == "admin")
					{
						if($sor['Admin'] > '0' OR $fsor['AAA'] > '0')
						{
							echo '<div style="padding-top:20px;"></div>
									<div class="subnav" style="border-top: 1px solid #02afd8;">
										<div align="center" style="color: #ffff00; font-size: 15px">Admin ('.$sor['Admin'].')</div>
										<br><br><hr><br>
										<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&adminok\';">Adminok</div>
										<div style="padding-top: 5px;"></div>
										<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&adminsegedek\';">Adminsegédek</div>
										<div style="padding-top: 5px;"></div>';
										if($sor['Admin'] > '1337' OR $fsor['AAA'] > '0')
										{
											echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&snm\';">S&M</div>
											<div style="padding-top: 5px;"></div>';
										}
									echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&bannok\';">Banlista</div>
										<div style="padding-top: 5px;"></div>';
										if($sor['Admin'] > '1336' OR $fsor['AAA'] > '0')
										{
											echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&frakciok\';">Frakciók</div>
											<div style="padding-top: 5px;"></div>';
										}
										if($sor['Admin'] > '0' OR $fsor['AAA'] > '0')
										{
											echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&playerkereses\';">Játékos keresés</div>
											<div style="padding-top: 5px;"></div>';
										}
										if($sor['Admin'] > '1336' OR $fsor['AAA'] > '0')
										{
											echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&bizniszek\';">Bizniszek</div>
											<div style="padding-top: 5px;"></div>';
										}
										/*if($sor['Admin'] > '1336')
										{
											echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&playerek\';">Játékosok</div>
											<div style="padding-top: 5px;"></div>';
										}*/
										if($sor['Admin'] > '1336' OR $fsor['AAA'] > '0')
										{
											echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&hazak\';">Házak</div>
											<div style=2padding-top: 5px;"></div>';
										}
										
										if($sor['Admin'] > '0' OR $fsor['AAA'] > '0')
										{
											echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&adminjailek\';">Adminjailok</div>
											<div style="padding-top: 5px;"></div>';
											echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&logok\';">Naplózások</div>
											<div style="padding-top: 5px;"></div>';
										}
							echo '</div>';
						}
					}
				}
			}?></div>

		<div class="clearer"><span></span></div>

	</div>

	<div class="footer">
	
			<div class="bottom">
				
				<span class="left"> Minden jog fenntartva &copy; 2014 </span>

				<span class="right">User Control Panel - By SilentZone</span>

				<div class="clearer"><span></span></div>

			</div>

	</div>

</div>
</div>
</div>
</body>

</html>