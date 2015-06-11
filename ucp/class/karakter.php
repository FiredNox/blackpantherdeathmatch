<?
	require_once("include/main.php");
	require_once($config["Path"]["class"]."/aktivitas.class.php");

	if(!$jatekos["Belepve"]) Hiba("Nem vagy belépve!", true);

	if(isset($_GET["kivalaszt"]))
	{
		if($_GET["kivalaszt"] == 1 && $jatekos["Karakterek"] > 0)
		{
			setcookie($config["CookieName"]["karakter"], "1", time() + 2592000); // 30nap
			$uzenet = "Karakter <u>".$jatekos["Karakter"][0]["Nev"]."</u> kiválasztva";
			$jatekos["Kivalasztva"] = 1;
		}
		else if($_GET["kivalaszt"] == 2 && $jatekos["Karakterek"] > 1)
		{
			setcookie($config["CookieName"]["karakter"], "2", time() + 2592000); // 30nap
			$uzenet = "Karakter <u>".$jatekos["Karakter"][1]["Nev"]."</u> kiválasztva";
			$jatekos["Kivalasztva"] = 2;
		}
	}
	/*elseif(isset($_GET["torol"]))
	{
		if($_GET["torol"] == 1 && $jatekos["Karakterek"] > 0)
		{
			if($jatekos["Karakterek"] == 1)
				mysql_query("UPDATE accountok SET Karakterek='0', Karakter1='0' WHERE ID='".$jatekos["ID"]."'");
			else
				mysql_query("UPDATE accountok SET Karakterek='".($jatekos["Karakterek"] - 1)."', Karakter1='".$jatekos["Karakter"][1]["ID"]."', Karakter2='0' WHERE ID='".$jatekos["ID"]."'");
			header("Location: ?torolve");
		}
		else if($_GET["torol"] == 2 && $jatekos["Karakterek"] > 1)
		{
			mysql_query("UPDATE accountok SET Karakterek='".($jatekos["Karakterek"] - 1)."', Karakter2='0' WHERE ID='".$jatekos["ID"]."'");
			header("Location: ?torolve");
		}
	}*/
	Fejlec();
	//if(isset($_GET["torolve"])) $uzenet = "Karakter törölve";
?>
<style type="text/css">
	td.clear, .cleartable tr td{border: none;}
	.cleartable tr td{padding: 1px;}
	.left
	{
		text-align: left;
	}
	.right
	{
		float: right;
	}
	h3.karakter
	{
		color: white;
	}
	.karakterinfo
	{
		margin:20px;
	}
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
	}
</style>

<? if(isset($uzenet)) echo Felhivas($uzenet); ?>

<center><h1>Karaktereid</h1></center>

<center><table width="90%" align="center" class="vtop tcenter">
<tr><td width="48%" class="clear"><h2>Karakter 1.</h2></td><td width="2%" class="clear"></td><td width="48%" class="clear"><h2>Karakter 2.</h2></td></tr>
<tr>
	<td width="48%">
	<?
		if($jatekos["Karakterek"] > 0)
		{
			$sql = mysql_query("SELECT Szint, Member, Rank, Money, Bank, UtoljaraAktiv FROM playerek WHERE id = '".$jatekos["Karakter"][0]["ID"]."'");
			$karakter = mysql_fetch_array($sql);
			$sql2 = mysql_query("SELECT Month, Week FROM ig_activity_index WHERE UID = '".$jatekos["Karakter"][0]["ID"]."'");
			$karakter2 = mysql_fetch_array($sql2);
			//<h3 class='karakter'>Név: ".$jatekos["Karakter"][0]["Nev"]." <a href='?torol=1'><img height='12' src='img/torol.png' title='Karakter törlése a felhasználótól (Ez nem törli a karaktert!)'></a></h3>
			echo"
				<span class='left'>
				<b>Szint:</b> ".$karakter["Szint"]."<br>
				<b>Készpénz:</b> ".number_format($karakter["Money"], 0, ',', ',')."Ft<br>
				<b>Bank:</b> ".number_format($karakter["Bank"], 0, ',', ',')."Ft<br>
				<b>Frakció:</b> ".($karakter["Member"] == 0 ? "<i>Nincs</i>" : FrakcioNeve($karakter["Member"])." (Rang: ".$karakter["Rank"].")")."<br>
				<br><b>Státusz: ".($jatekos["Karakter"][0]["Online"] == 1 ? "<font color='cyan'>Online</font>" : "<font color='orange'>Offline</font>")."</b><br>
				<b>Aktivitás: (".(round($karakter2["Month"]) >= 30*60*30 ? (round($karakter2["Month"]) >= 30*3600*1 ? (round($karakter2["Month"]) >= 30*3600*2 ? (round($karakter2["Month"]) >= 30*3600*5 ? (round($karakter2["Month"]) >= 30*3600*7 ? "<font color='#fff'>".(round($karakter2["Month"]/3600))."</font>" : "<font color='#0ff'>".(round($karakter2["Month"]/3600))."</font>") : "<font color='#0f0'>".(round($karakter2["Month"]/3600))."</font>") : "<font color='#ff0'>".(round($karakter2["Month"]/3600))."</font>") : "<font color='orange'>".(round($karakter2["Month"]/3600))."</font>") : "<font color='#f33'>".(round($karakter2["Month"]/3600))."</font>")."
				 / ".(round($karakter2["Week"]) >= 7*60*30 ? (round($karakter2["Week"]) >= 7*3600*1 ? (round($karakter2["Week"]) >= 7*3600*2 ? (round($karakter2["Week"]) >= 7*3600*5 ? (round($karakter2["Week"]) >= 7*3600*7 ? "<font color='#fff'>".(round($karakter2["Week"]/3600))."</font>" : "<font color='#0ff'>".(round($karakter2["Week"]/3600))."</font>") : "<font color='#0f0'>".(round($karakter2["Week"]/3600))."</font>") : "<font color='#ff0'>".(round($karakter2["Week"]/3600))."</font>") : "<font color='orange'>".(round($karakter2["Week"]/3600))."</font>") : "<font color='#f33'>".(round($karakter2["Week"]/3600))."</font>").")


				</span>
				<span class='right'><font size='2'><b>".($jatekos["Kivalasztva"] != 1 ? "<a href='?kivalaszt=1'>Kiválasztás</a>" : "Kiválasztva")."</b></font><br><img src='img/skin/Skin_".$jatekos["Karakter"][0]["Model"].".png' height='75'></span>

			";

		}
		else
		{
			if($jatekos["Letrehozas"] != 0)
				echo "Egy karaktered admin elbírálás alatt van.<br>Név: <b style='color:white'>".$jatekos["Letrehozando"][0]."</b>";
			elseif($jatekos["Tarsitas"] != 0)
				echo "Egy karakter társítása admin elbírálás alatt van.<br>Név: <b style='color:white'>".$jatekos["Tarsitando"][0]."</b>";
			else
				echo"<a href='letrehozas".$config["Ext"]."'>Karakter létrehozása</a> - <a href='tarsitas".$config["Ext"]."'>Karakter társítása</a>";
		}
	?>
	

	</td><td width="2%" class="clear"></td><td width="48%">
	<?
		if($jatekos["Karakterek"] > 1)
		{
			$sql = mysql_query("SELECT Szint, Member, Rank, Money, Bank FROM playerek WHERE id = '".$jatekos["Karakter"][1]["ID"]."'");
			$karakter = mysql_fetch_array($sql);
			$sql2 = mysql_query("SELECT Month, Week FROM ig_activity_index WHERE UID = '".$jatekos["Karakter"][1]["ID"]."'");
			$karakter2 = mysql_fetch_array($sql2);
			//<h3 class='karakter'>Név: ".$jatekos["Karakter"][1]["Nev"]." <a href='?torol=2'><img src='img/torol.png' height='12' title='Karakter törlése a felhasználótól (Ez nem törli a karaktert!)'></a></h3>
			echo"
				<span class='left'>
				<b>Szint:</b> ".$karakter["Szint"]."<br>
				<b>Készpénz:</b> ".number_format($karakter["Money"], 0, ',', ',')."Ft<br>
				<b>Bank:</b> ".number_format($karakter["Bank"], 0, ',', ',')."Ft<br>
				<b>Frakció:</b> ".($karakter["Member"] == 0 ? "<i>Nincs</i>" : FrakcioNeve($karakter["Member"])." (Rang: ".$karakter["Rank"].")")."<br>
				<br><b>Státusz: ".($jatekos["Karakter"][1]["Online"] == 1 ? "<font color='green'>Online</font>" : "<font color='orange'>Offline</font>")."</b><br>
				<b>Aktivitás: (".(round($karakter2["Month"]) >= 30*60*30 ? (round($karakter2["Month"]) >= 30*3600*1 ? (round($karakter2["Month"]) >= 30*3600*2 ? (round($karakter2["Month"]) >= 30*3600*5 ? (round($karakter2["Month"]) >= 30*3600*7 ? "<font color='#fff'>".(round($karakter2["Month"]/3600))."</font>" : "<font color='#0ff'>".(round($karakter2["Month"]/3600))."</font>") : "<font color='#0f0'>".(round($karakter2["Month"]/3600))."</font>") : "<font color='#ff0'>".(round($karakter2["Month"]/3600))."</font>") : "<font color='orange'>".(round($karakter2["Month"]/3600))."</font>") : "<font color='#f33'>".(round($karakter2["Month"]/3600))."</font>")."
				 / ".(round($karakter2["Week"]) >= 7*60*30 ? (round($karakter2["Week"]) >= 7*3600*1 ? (round($karakter2["Week"]) >= 7*3600*2 ? (round($karakter2["Week"]) >= 7*3600*5 ? (round($karakter2["Week"]) >= 7*3600*7 ? "<font color='#fff'>".(round($karakter2["Week"]/3600))."</font>" : "<font color='#0ff'>".(round($karakter2["Week"]/3600))."</font>") : "<font color='#0f0'>".(round($karakter2["Week"]/3600))."</font>") : "<font color='#ff0'>".(round($karakter2["Week"]/3600))."</font>") : "<font color='orange'>".(round($karakter2["Week"]/3600))."</font>") : "<font color='#f33'>".(round($karakter2["Week"]/3600))."</font>").")
				
				
				</span>
				<span class='right'><font size='2'><b>".($jatekos["Kivalasztva"] != 2 ? "<a href='?kivalaszt=2'>Kiválasztás</a>" : "Kiválasztva")."</b></font><br><img src='img/skin/Skin_".$jatekos["Karakter"][1]["Model"].".png' height='75'></span>
			";
		}
		else
		{
			if($jatekos["Letrehozas"] != 0)
				echo "Egy karaktered admin elbírálás alatt van.<br>Név: <b style='color:white'>".$jatekos["Letrehozando"][0]."</b>";
			elseif($jatekos["Tarsitas"] != 0)
				echo "Egy karakter társítása admin elbírálás alatt van.<br>Név: <b style='color:white'>".$jatekos["Tarsitando"][0]."</b>";
			else
				echo"<a href='letrehozas".$config["Ext"]."'>Karakter létrehozása</a> - <a href='tarsitas".$config["Ext"]."'>Karakter társítása</a>";
		}
	?>
	</td>

</tr></table></center>

<br><br><hr width="100%"><br>
<?
if(false)
echo "<h1>Karakter információk".($jatekos["Kivalasztva"] != 0 ? ": ".$jatekos["Karakter"][$jatekos["Kivalasztva"] - 1]["Nev"] : "")."</h1>";
echo"<div class='karakterinfo'>";

if($jatekos["Kivalasztva"] == 0)
	echo "<i>Nincs karakter kiválasztva</i>";
else
{
	require_once("include/statinfo.php");
	$kivalasztva = $jatekos["Kivalasztva"] - 1;
	$id = $jatekos["Karakter"][$kivalasztva]["ID"];
	$sql = mysql_query("SELECT * FROM playerek WHERE id='".$id."'");
	$k = mysql_fetch_array($sql); mysql_free_result($sql);

	$sql = mysql_query("SELECT ID, Tipus, Penz, Cigi, Kaja, Kokain, Heroin, Marihuana, Material FROM hazak WHERE Eladva = '1' and TulajID = '".$jatekos["Karakter"][$kivalasztva]["ID"]."'");
	$hazak = mysql_num_rows($sql);

	$db = 1;
	while($d = mysql_fetch_array($sql))
	{
		$haz[$db] = $d;
		$db++;
	}

	mysql_free_result($sql);

	$sql = mysql_query("SELECT Model FROM kocsik WHERE Eladva = '1' and TulajID = '".$jatekos["Karakter"][$kivalasztva]["ID"]."'");
	$kocsik = mysql_num_rows($sql);

	$db = 1;
	while($d = mysql_fetch_array($sql))
	{
		$kocsi[$db] = $d;
		$db++;
	}

	mysql_free_result($sql);

	$sql = mysql_query("SELECT ID, Nev, Kassza, Extortion FROM bizek WHERE Eladva = '1' and TulajID = '".$jatekos["Karakter"][$kivalasztva]["ID"]."'");
	$bizek = mysql_num_rows($sql);
	if($bizek > 0) $biz = mysql_fetch_array($sql);
	mysql_free_result($sql);

	$sql = mysql_query("SELECT Ido, Orok, Oka, Bannolta FROM bans WHERE Cim = '".$jatekos["Karakter"][$kivalasztva]["Nev"]."'");
	$banned = mysql_num_rows($sql);
	if($banned == 1) $ban = mysql_fetch_array($sql);
	mysql_free_result($sql);

	?>
	<table width='100%' class='karakter_infok vtop'>
		<tr>
			<td width='34%' class='cim'>Személyes információk</td>
			<td width='2%' class='clear'></td>
			<td width='31%' class='cim'>Zseb tartalma</td>
			<td width='2%' class='clear'></td>
			<td width='31%' class='cim'>Egyéb</td>
		</tr>
	<?
	

	switch($k["Origin"])
	{
		case 1: $szarmazas = "USA"; break;
		case 2: $szarmazas = "Európa"; break;
		case 3: $szarmazas = "Ázsia"; break;
		default: $szarmazas = "Ismeretlen";
	}

	$db = -1; $hazinfo = "";
	while(++$db < $hazak)
		$hazinfo .= ($db ? "<br>" : "") . "Class u. ".$haz[$db+1]["ID"]." (".$haztipus[$haz[$db+1]["Tipus"]].")";

	if(!strlen($hazinfo)) $hazinfo = "Nincs";

	$db = -1; $kocsiinfo = "";
	while(++$db < $kocsik)
		$kocsiinfo .= ($db ? "<br>" : "") . $model[$kocsi[$db+1]["Model"]];

	if(!strlen($kocsiinfo)) $kocsiinfo = "Nincs";

	$csere = Array("", "~R~", "~G~", "~B~", "~W~", "~Y~", "~P~", "~L~", "~N~", "~H~");
	$mire = Array("", "<font color='red'>", "<font color='green'>", "<font color='#1087ff'>", "<font color='white'>", "<font color='yellow'>", "<font color='#e608ff'>", "<font color='#555555'>", "<br>", "");
	$biz["Nev"] = str_replace($csere, $mire, strtoupper($biz["Nev"]), $darab);
	for($x = 1; $x <= $darab; $x++) $biz["Nev"] .= "</font>";
	$k["Nev"] = str_replace("_", " ", $k["Nev"]);

	$bankszamla = explode(",", $k["BankSzamla"]);
	$engedely = explode(",", $k["Jogsik"]);
	$cuccok = explode(",", $k["Cuccok"]);
	$fegyver = explode(",", $k["KilepesFegyver"]);
	$tolteny = explode(",", $k["KilepesTolteny"]);
	$premium = explode(",", $k["Premium"]);
	
	if($k['PremiumIdo'] < time()) {
		$premium[0] = 0;
	}

	$tablak = Array(
		"1" => Array(
			Array("nev" => "Név",		"ertek" => $k["Nev"]),
			Array("nev" => "Nem",		"ertek" => ($k["Sex"] == 1 ? "Férfi" : "Nő")),
			Array("nev" => "Életkor",	"ertek" => $k["Age"]),
			Array("nev" => "Származás",	"ertek" => $szarmazas),
			Array("nev" => "Házastárs",	"ertek" => ($k["Married"] == "1" ? str_replace("_", " ", $k["MarriedTo"]) : "Nincs")),

			Array("nev" => "<br>", "ertek" => "formalitas"),

			Array("nev" => ($hazak > 1 ? "Házak" : "Ház"), "ertek" => $hazinfo),
			Array("nev" => ($kocsik > 1 ? "Kocsik" : "Kocsi"), "ertek" => $kocsiinfo),
			Array("nev" => "Biznisz", "ertek" => ($bizek == 1 ? $biz["Nev"] : "Nincs")),
			Array("nev" => "> Kassza", "ertek" => ($bizek == 1 ? number_format($biz["Kassza"], 0, ',', ',')."Ft" : "-")),
			Array("nev" => "> TársTulaj", "ertek" => ($bizek == 1 ? $biz["Extortion"] : "-")),

			Array("nev" => "<br>", "ertek" => "formalitas"),

			Array("nev" => "Főmunka", "ertek" => ($k["Job1"] == 0 ? "Nincs" : $munkak[$k["Job1"]])),
			Array("nev" => "Másodmunka", "ertek" => ($k["Job2"] == 0 ? "Nincs" : $munkak[$k["Job2"]])),
			Array("nev" => "Telefon", "ertek" => ($k["Phone"] == 0 ? "Nincs" : "Van (".$k["Phone"].")")),
			Array("nev" => "Fizetés", "ertek" => round($k["PayDay"] / 60)."perc / ".$k["Paycheck"]."Ft"),

			Array("nev" => "<br>", "ertek" => "formalitas"),

			Array("nev" => "Bankszámla", "ertek" => ($bankszamla[0] == "1" ? "Van" : "Nincs")),
			Array("nev" => "Számlaszám", "ertek" => ($bankszamla[0] == "1" ? $bankszamla[1] : "-")),
			Array("nev" => "Jelszó", "ertek" => ($bankszamla[0] == "1" ? "<a href='' onClick='alert(\"".$bankszamla[2]."\"); return false;'>[Mutat]</a>" : "-")),
			Array("nev" => "Pénz", "ertek" => ($bankszamla[0] == "1" ? number_format($k["Bank"], 0, ',', ',')."Ft" : "-")),

			Array("nev" => "<br>", "ertek" => "formalitas"),

		),
		"2" => Array(
			Array("nev" => "Készpénz", "ertek" => ($k["Money"] == 0 ? "Nincs" : number_format($k["Money"], 0, ',', ',')."Ft")),
			Array("nev" => "Lottó", "ertek" => ($k["Lotto"] == 0 ? "Nincs" : $k["Lotto"])),


			//Array("nev" => "<br><font color='white'>Cuccok</font>", "ertek" => "formalitas"),
			Array("nev" => "<br>", "ertek" => "formalitas"),

			Array("nev" => "Műanyag", "ertek" => ($cuccok[0] == 0 ? "Nincs" : $cuccok[0]."db")),
			Array("nev" => "Cserje", "ertek" => ($cuccok[1] == 0 ? "Nincs" : $cuccok[1]."db")),
			Array("nev" => "Mák", "ertek" => ($cuccok[2] == 0 ? "Nincs" : $cuccok[2]."db")),
			Array("nev" => "Cannabis", "ertek" => ($cuccok[3] == 0 ? "Nincs" : $cuccok[3]."db")),

			Array("nev" => "<br>", "ertek" => "formalitas"),

			Array("nev" => "Material", "ertek" => ($cuccok[4] == 0 ? "Nincs" : $cuccok[4]."db")),
			Array("nev" => "Kokain", "ertek" => ($cuccok[5] == 0 ? "Nincs" : $cuccok[5]."g")),
			Array("nev" => "Heroin", "ertek" => ($cuccok[6] == 0 ? "Nincs" : $cuccok[6]."g")),
			Array("nev" => "Marihuana", "ertek" => ($cuccok[7] == 0 ? "Nincs" : $cuccok[7]."g")),

			Array("nev" => "<br>", "ertek" => "formalitas"),

			Array("nev" => "Kötszer", "ertek" => ($k["Kotszer"] == 0 ? "Nincs" : $k["Kotszer"]."db")),
			Array("nev" => "Cigi", "ertek" => ($k["Cigi"] == 0 ? "Nincs" : $k["Cigi"]."db")),
			Array("nev" => "Szendvics", "ertek" => ($k["Kaja"] == 0 ? "Nincs" : $k["Kaja"]."db")),
			//Ryan ->
			Array("nev" => "<br><font color='white'>Tárgyak</font>", "ertek" => "formalitas"),

			Array("nev" => "Arany (Zseb)", "ertek" => ($k["Arany"] == 0 ? "Nincs" : $k["Arany"]."db")),
			Array("nev" => "Arany (Bank)", "ertek" => ($k["AranyBank"] == 0 ? "Nincs" : $k["AranyBank"]."db")),
			// Ryan
			Array("nev" => "<br><font color='white'>Engedélyek</font>", "ertek" => "formalitas"),

			Array("nev" => "Autó", "ertek" => ($engedely[0] == 0 ? "Nincs" : "Van (Még ".$engedely[0]." óráig)")),
			Array("nev" => "Motor", "ertek" => ($engedely[5] == 0 ? "Nincs" : "Van (Még ".$engedely[5]." óráig)")),
			Array("nev" => "Fegyver", "ertek" => ($engedely[4] == 0 ? "Nincs" : "Van (Még ".$engedely[4]." óráig)")),
			Array("nev" => "Kamion", "ertek" => ($engedely[6] == 0 ? "Nincs" : "Van (Még ".$engedely[6]." óráig)")),
			Array("nev" => "Hajó", "ertek" => ($engedely[2] == 0 ? "Nincs" : "Van (Még ".$engedely[2]." óráig)")),
			Array("nev" => "Repülő", "ertek" => ($engedely[1] == 0 ? "Nincs" : "Van (Még ".$engedely[1]." óráig)")),
			Array("nev" => "Halászat", "ertek" => ($engedely[3] == 0 ? "Nincs" : "Van (Még ".$engedely[3]." óráig)")),

			/*Array("nev" => "<br><font color='white'>Fegyverek</font>", "ertek" => "formalitas"),

			Array("nev" => "Slot 0", "ertek" => ($fegyver[0] == 0 ? "Ököl" : "Boxer")),
			Array("nev" => "Slot 1", "ertek" => ($fegyver[1] == 0 ? "-" : $fegyverek[$fegyver[1]])),
			Array("nev" => "Slot 2", "ertek" => ($fegyver[2] == 0 ? "-" : $fegyverek[$fegyver[2]]." (<b>".$tolteny[2]."</b>)")),
			Array("nev" => "Slot 3", "ertek" => ($fegyver[3] == 0 ? "-" : $fegyverek[$fegyver[3]]." (<b>".$tolteny[3]."</b>)")),
			Array("nev" => "Slot 4", "ertek" => ($fegyver[4] == 0 ? "-" : $fegyverek[$fegyver[4]]." (<b>".$tolteny[4]."</b>)")),
			Array("nev" => "Slot 5", "ertek" => ($fegyver[5] == 0 ? "-" : $fegyverek[$fegyver[5]]." (<b>".$tolteny[5]."</b>)")),
			Array("nev" => "Slot 6", "ertek" => ($fegyver[6] == 0 ? "-" : $fegyverek[$fegyver[6]]." (<b>".$tolteny[6]."</b>)")),
			Array("nev" => "Slot 7", "ertek" => ($fegyver[7] == 0 ? "-" : $fegyverek[$fegyver[7]]." (<b>".$tolteny[7]."</b>)")),
			Array("nev" => "Slot 8", "ertek" => ($fegyver[8] == 0 ? "-" : $fegyverek[$fegyver[8]]." (<b>".$tolteny[8]."</b>)")),
			Array("nev" => "Slot 9", "ertek" => ($fegyver[9] == 0 ? "-" : $fegyverek[$fegyver[9]]." (<b>".$tolteny[9]."</b>)")),
			Array("nev" => "Slot 10", "ertek" => ($fegyver[10] == 0 ? "-" : $fegyverek[$fegyver[10]])),
			Array("nev" => "Slot 11", "ertek" => ($fegyver[11] == 0 ? "-" : $fegyverek[$fegyver[11]])),*/
		),
		"3" => Array(
			Array("nev" => "Szint", "ertek" => $k["Szint"]),
			Array("nev" => "> Következő", "ertek" => (($k["Szint"]+1)*4 - $k["Respect"]) ." óra"),
			Array("nev" => "Játszott órák", "ertek" => $k["ConnectedTime"]." óra"),

			Array("nev" => "<br>", "ertek" => "formalitas"),

			Array("nev" => "Börtönben", "ertek" => ($k["Jailed"] == "0" ? "Nem" : $borton[$k["Jailed"]])),
			Array("nev" => "> Idő", "ertek" => ($k["Jailed"] == "0" ? "-" : $k["JailTime"]."mp (".round($k["JailTime"] / 60)."p)")),
				Array("nev" => "> Oka", "ertek" => ($k["JailOK"] == "" || $k["JailOK"] == "Nincs megadva" ? "-" : $k["JailOK"])),
			Array("nev" => "<br>", "ertek" => "formalitas"),
			
			Array("nev" => "Letartóztatva:", "ertek" => ($k["Arrested"] == "0" ? "Egyszer sem" : $k["Arrested"]." alkalommal")), // Ryan
			
			Array("nev" => "<br>", "ertek" => "formalitas"),

			Array('nev' => 'Kredit', 'ertek' => ($k['Kredit'] > 0 ? '<b style="color: yellow">'.$k['Kredit'].'</b>' : $k['Kredit'])),

			Array('nev' => '<br>', 'ertek' => 'formalitas'),

			Array("nev" => "Prémium", "ertek" => ($premium[0] == "0" ? "Nincs" : "<font color='white'><b>Van</b></font>")),
			Array("nev" => "> Csomag", "ertek" => ($premium[0] == "0" ? "-" : "<font color='gold'><b>".$premium[0]."Ft</b></font>")),
			Array("nev" => "> Aktív", "ertek" => ($premium[0] == "0" ? "-" : "<font color='gold'><b>".date("Y-m-d H:i:s", $k["PremiumIdo"])."</b></font>")),
			Array("nev" => "P. Pont", "ertek" => ($premium[1] == "0" ? "Nincs" : "<font color='gold'><b>".$premium[1]."db</b></font>")),

			Array("nev" => "<br>", "ertek" => "formalitas"),
			//RYAN
			
			//Array("nev" => "Adminsegéd", "ertek" => ($k["ASJog"] == "0" ? "Nem" : round(($k["ASJog"]-time())/3600-1);))), //Ezt ne piszkáld egyelőre. - Ryan
			Array("nev" => "AdminSegéd", "ertek" => ($k["ASJog"] == "0" ? "Nem" : "<font color='yellow'><b>".date("Y-m-d H:i:s", $k["ASJog"])."</b></font>")),

			Array("nev" => "Admin", "ertek" => ($k["Admin"] == "0" ? "Nem" : ($k["Admin"] == 6 ? "<font color='yellow'><b>Admin & Scripter</b></font>" : $k["Admin"] == 1340 ? "<font color='yellow'><b>Scripter</b></font>" : "<font color='yellow'><b>".$k["Admin"]."</b></font>"))),
			Array("nev" => "Válaszok", "ertek" => ($k["Valaszok"] == "0" ? "Nincs" : $k["Valaszok"]." darab")), // Ryan
			
			Array("nev" => "<br>", "ertek" => "formalitas"),
			//RYAN
			Array("nev" => "Önkéntes", "ertek" => ($k["Onkentes"] == "0" ? "Nem" : "<font color='yellow'><b>".date("Y-m-d H:i:s", $k["Onkentes"])."</b></font>")), // Ryan
			
			Array("nev" => "<br>", "ertek" => "formalitas"),

			Array("nev"	=> "Teszt", "ertek" => ($k["Tutorial"] < time() ? "Nincs kitöltve" : date("Y-m-d H:i:s", $k["Tutorial"]))),

			Array("nev" => "<br>", "ertek" => "formalitas"),

			Array("nev" => "Bannolva", "ertek" => ($banned == 0 ? "Nem" : "<font color='#FF4444'><b>Igen</b></font>")),
			Array("nev" => "> Lejár", "ertek" => ($banned == 0 ? "-" : "<font color='#FF4444'><b>".($ban["Orok"] == "i" ? "Soha (Örök ban)" : date("Y-m-d H:i:s", $ban["Ido"]))."</b></font>")),
			Array("nev" => "> Bannolt", "ertek" => ($banned == 0 ? "-" : "<font color='#FF4444'><b>".$ban["Bannolta"]."</b></font>")),
			Array("nev" => "> Oka", "ertek" => ($banned == 0 ? "-" : "<font color='#FF4444'><b>".$ban["Oka"]."</b></font>")),
			//RYAN
			Array("nev" => "<br><font color='white'>Tiltások</font>", "ertek" => "formalitas"),
			
			Array("nev" => "Fegyver", "ertek" => ($k["FegyverTiltas"] == "0@semmi" ? "Nem" : "<font color='#FF4444'><b>Igen</b></font>")),
			Array("nev" => "> Idő/Oka", "ertek" => ($k["FegyverTiltas"] == "0@semmi" ? "-" : "<font color='#FF4444'><b>".$k["FegyverTiltas"]."</b></font>")),
			
			Array("nev" => "<br>", "ertek" => "formalitas"),
			
			Array("nev" => "Frakció", "ertek" => ($k["FrakcioTiltas"] == "0@semmi" ? "Nem" : "<font color='#FF4444'><b>Igen</b></font>")),
			Array("nev" => "> Idő/Oka", "ertek" => ($k["FrakcioTiltas"] == "0@semmi" ? "-" : "<font color='#FF4444'><b>".$k["FrakcioTiltas"]."</b></font>")),
			
			Array("nev" => "<br>", "ertek" => "formalitas"),
			
			Array("nev" => "Jogsi", "ertek" => ($k["JogsiTiltas"] == "0@semmi" ? "Nem" : "<font color='#FF4444'><b>Igen</b></font>")),
			Array("nev" => "> Idő/Oka", "ertek" => ($k["JogsiTiltas"] == "0@semmi" ? "-" : "<font color='#FF4444'><b>".$k["JogsiTiltas"]."</b></font>")),
			
			Array("nev" => "<br>", "ertek" => "formalitas"),
			
			Array("nev" => "AdminSegéd", "ertek" => ($k["ASTiltas"] == "0@ures" ? "Nem" : "<font color='#FF4444'><b>Igen</b></font>")),
			Array("nev" => "> Oka", "ertek" => ($k["ASTiltas"] == "0@ures" ? "-" : "<font color='#FF4444'><b>".$k["ASTiltas"]."</b></font>")),
			
			Array("nev" => "<br>", "ertek" => "formalitas"),
			
			Array("nev" => "Leader", "ertek" => ($k["LeaderTiltas"] == "0@semmi" ? "Nem" : "<font color='#FF4444'><b>Igen</b></font>")),
			Array("nev" => "> Oka", "ertek" => ($k["LeaderTiltas"] == "0@semmi" ? "-" : "<font color='#FF4444'><b>".$k["LeaderTiltas"]."</b></font>")),
			
			Array("nev" => "<br>", "ertek" => "formalitas"),
			
			Array("nev" => "Report", "ertek" => ($k["ReportTiltas"] == "0@Nincs" ? "Nem" : "<font color='#FF4444'><b>Igen</b></font>")),
			Array("nev" => "> Oka", "ertek" => ($k["ReportTiltas"] == "0@Nincs" ? "-" : "<font color='#FF4444'><b>".$k["ReportTiltas"]."</b></font>")),
			//RYAN Vége
		)
	);
	unset($k);
	echo"
	<tr><td>

		<table width='100%' class='cleartable'><tr><td width='40%'></td><td></td></tr>
		";
		foreach($tablak[1] as $tabla)
		{
			if($tabla["ertek"] == "formalitas")
				echo "<tr><td colspan='2'><b>".$tabla["nev"]."</b></td></tr>";
			else
				echo "<tr><td><b>".$tabla["nev"]."</b>:</td><td>".$tabla["ertek"]."</td></tr>";
		}
		if($hazak > 0)
		{
			echo"<tr><td><b>Házszéf</b>:</td><td>
				<b>Pénz</b>: ".($haz[1]["Penz"] == 0 ? "Nincs" : number_format($haz[1]["Penz"], 0, ',', ',')."Ft")."<br>
				<b>Kaja</b>: ".($haz[1]["Kaja"] == 0 ? "Nincs" : $haz[1]["Kaja"]."db")."<br>
				<b>Cigi</b>: ".($haz[1]["Cigi"] == 0 ? "Nincs" : $haz[1]["Cigi"]."db")."<br>
				<br>
				<b>Kokain</b>: ".($haz[1]["Kokain"] == 0 ? "Nincs" : $haz[1]["Kokain"]."g")."<br>
				<b>Heroin</b>: ".($haz[1]["Heroin"] == 0 ? "Nincs" : $haz[1]["Heroin"]."g")."<br>
				<b>Marihuana</b>: ".($haz[1]["Marihuana"] == 0 ? "Nincs" : $haz[1]["Marihuana"]."g")."<br>
				<b>Material</b>: ".($haz[1]["Material"] == 0 ? "Nincs" : $haz[1]["Material"]."db")."<br>
			</td></tr>";
		}
		if($hazak > 1)
		{
			echo "<tr><td colspan='2'><b><br></b></td></tr>";
			echo"<tr><td><b>Házszéf (2)</b>:</td><td>
				<b>Pénz</b>: ".($haz[2]["Penz"] == 0 ? "Nincs" : number_format($haz[2]["Penz"], 0, ',', ',')."Ft")."<br>
				<b>Kaja</b>: ".($haz[2]["Kaja"] == 0 ? "Nincs" : $haz[2]["Kaja"]."db")."<br>
				<b>Cigi</b>: ".($haz[2]["Cigi"] == 0 ? "Nincs" : $haz[2]["Cigi"]."db")."<br>
				<br>
				<b>Kokain</b>: ".($haz[2]["Kokain"] == 0 ? "Nincs" : $haz[2]["Kokain"]."g")."<br>
				<b>Heroin</b>: ".($haz[2]["Heroin"] == 0 ? "Nincs" : $haz[2]["Heroin"]."g")."<br>
				<b>Marihuana</b>: ".($haz[2]["Marihuana"] == 0 ? "Nincs" : $haz[2]["Marihuana"]."g")."<br>
				<b>Material</b>: ".($haz[2]["Material"] == 0 ? "Nincs" : $haz[2]["Material"]."db")."<br>
			</td></tr>";
		}
		if($hazak > 2)
		{
			echo "<tr><td colspan='2'><b><br></b></td></tr>";
			echo"<tr><td><b>Házszéf (3)</b>:</td><td>
				<b>Pénz</b>: ".($haz[3]["Penz"] == 0 ? "Nincs" : number_format($haz[3]["Penz"], 0, ',', ',')."Ft")."<br>
				<b>Kaja</b>: ".($haz[3]["Kaja"] == 0 ? "Nincs" : $haz[3]["Kaja"]."db")."<br>
				<b>Cigi</b>: ".($haz[3]["Cigi"] == 0 ? "Nincs" : $haz[3]["Cigi"]."db")."<br>
				<br>
				<b>Kokain</b>: ".($haz[3]["Kokain"] == 0 ? "Nincs" : $haz[3]["Kokain"]."g")."<br>
				<b>Heroin</b>: ".($haz[3]["Heroin"] == 0 ? "Nincs" : $haz[3]["Heroin"]."g")."<br>
				<b>Marihuana</b>: ".($haz[3]["Marihuana"] == 0 ? "Nincs" : $haz[3]["Marihuana"]."g")."<br>
				<b>Material</b>: ".($haz[3]["Material"] == 0 ? "Nincs" : $haz[3]["Material"]."db")."<br>
			</td></tr>";
		}
		echo"
		</table>

	</td><td class='clear'></td><td>

		<table width='100%' class='cleartable'><tr><td width='40%'></td><td></td></tr>
		";
		foreach($tablak[2] as $tabla)
		{
			if($tabla["ertek"] == "formalitas")
				echo "<tr><td colspan='2'><b>".$tabla["nev"]."</b></td></tr>";
			else
				echo "<tr><td><b>".$tabla["nev"]."</b>:</td><td>".$tabla["ertek"]."</td></tr>";
		}
		echo"
		</table>

	</td><td class='clear'></td><td>

		<table width='100%' class='cleartable'><tr><td width='45%'></td><td></td></tr>
		";
		foreach($tablak[3] as $tabla)
		{
			if($tabla["ertek"] == "formalitas")
				echo "<tr><td colspan='2'><b>".$tabla["nev"]."</b></td></tr>";
			else
				echo "<tr><td><b>".$tabla["nev"]."</b>:</td><td>".$tabla["ertek"]."</td></tr>";
		}
		echo"
		</table>

	</td></tr>

	";

}
?>
</table>
</div>

<? Lablec(); ?>
