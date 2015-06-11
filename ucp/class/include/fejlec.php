<?



function Engedely($tipus)
{
	global $jatekos, $config;
	if(	$tipus == "any" ||
		$tipus == "clint" && IsClint() ||
		$tipus == "login" && $jatekos["Belepve"] ||
		$tipus == "nologin" && !$jatekos["Belepve"] ||
		$tipus == "admin" && $jatekos["Belepve"] && $jatekos["Admin"] >= 1 ||
		$tipus == "scripter" && $jatekos["Belepve"] && in_array($jatekos["Nev"], $config["Scripter"]) ||
		$tipus == "select" && $jatekos["Belepve"] && $jatekos["AK"] != -1 ||
		$tipus == "member" && $jatekos["Belepve"] && $jatekos["AK"] != -1 && $jatekos["AK"]["Member"] != '0' ||
		$tipus == "swat" && $jatekos["Belepve"] && $jatekos["AK"] != -1 && $jatekos["AK"]["Swat"] == "1" ||
		$tipus == "sss" && $jatekos["Belepve"] && $jatekos["AK"] != -1 && $jatekos["AK"]["SSS"] != "0" ||
		$tipus == "autoker" && $jatekos["Belepve"] && $jatekos["AK"] != -1 && $jatekos["AK"]["Autoker"] != "0" ||
		$tipus == "szerelo" && $jatekos["Belepve"] && $jatekos["AK"] != -1 && $jatekos["AK"]["Szerelo"] != "0" ||
		$tipus == "hitman" && $jatekos["Belepve"] && $jatekos["AK"] != -1 && $jatekos["AK"]["Hitman"] >= "1"
	)
		return 1;
	return 0;
}

$ora = date("H");

$uzenet = "";
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["akcionev"]))
{
	$akcio = $_POST["akcionev"];
	if($akcio == "belepes")
	{
		$nev = $_POST["nev"]; $jelszo = $_POST["jelszo"];
		$nev = str_replace(" ", "", $nev);

		if(strtolower($nev) == "clint")
		{
			if(GetIP() != "194.149.62.5" && GetIP() != "127.0.0.1")
			{
				SeeLOG("clint", "<b class='kiemelt'>".GetIP()."</b> be akart lépni a ".$nev." accountba", 1, "Clint", 0);
				header("Location: http://google.hu");
				exit;
			} else {
				$_SESSION['LoginData']['Clint'] = 1;
			}
		}

		$SeeGlobal["felhasznalonev"] = $nev;

		if(strlen($nev) < 3 || strlen($nev) > 20)
			$uzenet = "Hibás név - Minimum 3, maximum 20 karakter";
		elseif(strlen($jelszo) < 3 || strlen($jelszo) > 20)
			$uzenet = "Hibás jelszó - Minimum 3, maximum 20 karakter";
		elseif(!SzovegAnalizalas($nev))
			$uzenet = "Hibás név - Engedélyezett karakterek: Angol ABC, Számok, Speciális karakterek: '.', '_', '[', ']'";
		elseif(!SzovegAnalizalas($jelszo))
			$uzenet = "Hibás jelszó - Engedélyezett karakterek: Angol ABC, Számok, Speciális karakterek: '.', '_', '[', ']'";
		else
		{
			$pass = SeeEncode($jelszo);
			
			$sql = mysql_query("SELECT ID, Megerositve FROM accountok WHERE nev='".$nev."' AND jelszo = '".SeeEncode($jelszo)."'");
			if(mysql_num_rows($sql) == 0)
				$uzenet = "Hibás felhasználónév vagy jelszó";
			else
			{
				$data_a = mysql_fetch_array($sql);
				if($data_a["Megerositve"] != 1)
					$uzenet = "Az adminisztrátor még nem erősítette meg a regisztrációdat!";
				else
				{
					$ido = 60*60*24*30;
					mysql_query("UPDATE accountok SET IP = '".GetIP()."', UtoljaraAktiv='".date("Y-m-d H:i:s")."' WHERE id='".$data_a["ID"]."'");
					$_SESSION['LoginData']['ID'] = $data_a['ID'];
					$_SESSION['LoginData']['Pass'] = $pass;
					if(isset($_POST["megjegyez"]) && $_POST["megjegyez"] == "igen")
						$_SESSION['LoginData']['Jegyez'] = "true";

					//setcookie($config["CookieName"]["name"], $data_a["ID"], (isset($_POST["megjegyez"]) == "igen" ? (time() + $ido) : 0));
					//setcookie($config["CookieName"]["pass"], SeeEncode($jelszo), (isset($_POST["megjegyez"]) ? (time() + $ido) : 0));
					header("Location: fooldal".$config["Ext"]);
				}
			}
		}
	}
}
if(isset($_GET["kilepes"]) && $jatekos["Belepve"])
{
	//setcookie($config["CookieName"]["name"], '', time()-3600);
	//setcookie($config["CookieName"]["pass"], '', time()-3600);
	unset($_SESSION['LoginData']);
	setcookie($config["CookieName"]["karakter"], '', time()-3600);
	header("Location: fooldal".$config["Ext"]);
}

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="description"/>
<meta name="keywords" content="keywords"/>
<meta name="author" content="author"/>
<?
if($_SESSION['LoginData']['Jegyez'])
	echo "<meta HTTP-EQUIV='refresh' content='900; url=fooldal.php'>";
?>
<script type="text/javascript">var Ext = "<?=$config["Ext"]?>";</script>

<link rel="stylesheet" type="text/css" href="include/default.css" media="screen"/>
<script type="text/javascript" src="js/usercp.js"></script>
<script type="text/javascript" src="include/usercp.js"></script>

<link type="text/css" href="include/ui-darkness/jquery-ui.css" rel="stylesheet" />
<script type="text/javascript" src="include/jQuery.js"></script>
<script type="text/javascript" src="include/jQuery-ui.js"></script>
<script type="text/javascript" src="include/jQuery.blockUI.js"></script>

<script src="include/jQuery.scrollTo.js" type="text/javascript"></script>
<script src="include/jQuery.localscroll.js" type="text/javascript" charset="utf-8"></script>
<script src="include/jQuery.serialScroll.js" type="text/javascript" charset="utf-8"></script>
<script src="include/jQuery.clickOut.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="include/coda-slider.css" media="screen"/>
<script type="text/javascript" src="include/jQuery.coda-slider.js" charset="utf-8"></script>

<?
####################
## Extra fejlécek ##
####################

if(in_array("dygraph", $_fejlec_extra)){echo'<script type="text/javascript" src="include/dygraph.js"></script>';define("DYGRAPH_LOADED", true);}
if(in_array("jquery.timepicker", $_fejlec_extra))
{
	echo'<link type="text/css" href="include/jQuery-ui-timepicker.css" rel="stylesheet" />
		 <script type="text/javascript" src="include/jQuery-ui-timepicker.js"></script>';
}

####################
?>
<script type="text/javascript" src="include/jQuery.easing.js"></script>
<script type="text/javascript" src="include/tooltip.min.js"></script>
<script type="text/javascript" src="include/tooltip.slide.min.js"></script>
<script type="text/javascript" src="include/tooltip.dynamic.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	$("[title]").tooltip({
	   offset: [10, 2],
	   effect: 'slide'
	}).dynamic({ bottom: { direction: 'down', bounce: true } });
});
</script>

<link rel="stylesheet" media="screen" href="include/menu.css" />
<script src="include/menu.js"></script>

<title><?=$config["Nev"]?></title>
</head>

<body>

<div class="container">

	<div class="header" align="center">

		<? 
			$veletlen = rand(1,4);
		?>
		<a href="fooldal<?=$config["Ext"]?>" name="fent"><span><img src="img/Kep_<? echo $veletlen ?>.png" width="100%"></span></a>
		
	</div>

		<ul class="fomenu">

		<?
			foreach($config["Menuk"] as $menu)
			{
				if(Engedely($menu["login"]))
				{
					echo '<li>';

					if($menu["link"] != "no")
						echo '<a href="'.$menu["link"].$config["Ext"].'" '.(isset($menu["egyeb"]) ? $menu["egyeb"] : "").'>'.$menu["nev"].'</a>';
					else
						echo '<a href="javascript: void(0);" '.(isset($menu["egyeb"]) ? $menu["egyeb"] : "").'>'.$menu["nev"].'</a>';

					if(isset($menu["almenu"]))
					{
						$almenuk = "";

						foreach($menu["almenu"] as $almenu)
						{
							if(
								isset($almenu["admin"]) && (
									!is_array($almenu["admin"]) && $almenu["admin"] > $jatekos["Admin"] ||
									is_array($almenu["admin"]) && !in_array($jatekos["Nev"], $almenu["admin"])
								) ||
								isset($almenu["login"]) && !Engedely($almenu["login"])
							  )
							continue;

							$almenuk .= '<li><a href="'.$almenu["link"].$config["Ext"].'" '.(isset($almenu["egyeb"]) ? $almenu["egyeb"] : "").'>'.$almenu["nev"].'</a></li>';
						}

						if($almenuk != "")
							echo '<ul class="almenu">'.$almenuk.'</ul>';

						unset($almenuk);
					}
						echo'</li>
					';
				}
			}

		?>

		</ul>

	<div class="main">
		<div class="left">
			<div class="content">
<?
	if(strlen($uzenet) > 0)
		echo Felhivas($uzenet);

	if($jatekos["Belepve"] && $config["Lap"] != "log")
	{
		$sql = mysql_query("SELECT ID FROM log WHERE AID='".$jatekos["ID"]."' AND Olvasva='0' AND Admin='0'");
		if(mysql_num_rows($sql) != 0)
		{?>

	<script type="text/javascript">
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );

		$( "#dialog-confirm" ).dialog({
			resizable: false,
			height: 140,
			width: 300,
			modal: false,
			title: "Új esemény",
			show: "explode",
			hide: "explode",
			position: ["top", 25],
			buttons: {
				"Igen": function() {
					$( this ).dialog( "close" );
					setTimeout('window.location = "<? echo $config["URL"]."/log".$config["Ext"]; ?>"', 500);
				},
				"Nem": function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
	</script>

	<div id="dialog-confirm" title="Új esemény">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
	Történt valami, amíg nem voltál itt.<br>
	El szeretnéd olvasni most?</p>
	</div>

		<?}mysql_free_result($sql);
	}

	if($jatekos["Belepve"])
	{
		$tiltottLinkek = Array(
			"frakcio", "frakcio_swat", "frakcio_sss", "muvelet", "panaszkonyv", "piac", "admin_ban", "letrehozas", "tarsitas", "regisztracio"
		);

		if($jatekos["Bannolva"] && in_array($config["Lap"], $tiltottLinkek) && !IsClint() && !IsTerno())
			Hiba("Sajnálom, de mivel bannolva vagy, így nincs jogosultságod a lap megtekintéséhez");

		if($jatekos["Karakterek"] >= 1 && $jatekos["Karakter"][0]["Respect"] >= ($jatekos["Karakter"][0]["Szint"]+1) * 4 && $jatekos["Karakter"][0]["Tutorial"] < ($time = time()))
			Felhivas("A ".$jatekos["Karakter"][0]["Nev"]." nevű karaktered szintet lépne, de nem tud, mivel nem töltötted ki a tesztet, ezt <a href='quiz".$config["Ext"]."'>ide</a> kattintva megteheted");

		if($jatekos["Karakterek"] >= 2 && $jatekos["Karakter"][1]["Respect"] >= ($jatekos["Karakter"][1]["Szint"]+1) * 4 && $jatekos["Karakter"][1]["Tutorial"] < $time)
			Felhivas("A ".$jatekos["Karakter"][1]["Nev"]." nevű karaktered szintet lépne, de nem tud, mivel nem töltötted ki a tesztet, ezt <a href='quiz".$config["Ext"]."'>ide</a> kattintva megteheted");

		/*foreach($config["Menuk"] as $menu)
		{
			if($menu["link"] == $config["Lap"])
			{
				if(in_array($menu["login"], Array(1, 5, 54, 55)))
					Hiba("Sajnálom, de mivel bannolva vagy, így nincs jogosultságod a lap megtekintéséhez");
				break;
			}
		}*/
	}

	echo"<noscript><center><p class='border-radius' style='font-weight: bold; color: #ff0; font-size: 14px; padding: 5px; border: 3px solid #999; width: 80%; background-color: #444;'>A böngésződben nincs engedélyezve a JavaScript, engedélyezd,
	<br>vagy a kezelőfelület számos része használhatatlan lesz!<br><br>
	JavaScript nélkül a <a href='quiz".$config["Ext"]."'>Teszt kitöltése</a> menüpont is használhatatlan!<br><br>
	Nem tudod, hogyan kell aktiválni? <a href='http://www.enable-javascript.com/hu/' target='_BLANK'>Kattints ide</a></p></center></noscript>";
?>