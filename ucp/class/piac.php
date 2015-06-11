<?
require_once("include/main.php");

if(isset($_GET["a"])) $a = $_GET["a"];

/*AJAX*/if(isset($_GET["ajax"])){/*AJAX*/

if($a == "aruk")
{
	$sql_piac = mysql_query("SELECT * FROM piac_aruk ORDER BY nev");
	if(mysql_num_rows($sql) == 0)
		Hiba("Jelenleg nincs eladó áru - nézz vissza később", false, false);

	$adatok = mysql_fetch_array(mysql_query("SELECT Premium, PremiumIdo, Bank FROM playerek WHERE ID='".$jatekos["AK"]["ID"]."'"));
	if($adatok["PremiumIdo"] > time())
	{
		$pont = explode(",", "Premium");
		$pont = $pont[1];
	}
	else {$pont = 0;}

	$penz = $adatok["Bank"];

	echo "<center>";
	while($aru = mysql_fetch_array($sql_piac))
	{
		$sql = mysql_query("SELECT ID FROM targyak WHERE Tipus='".$aru["Tipus"]."' AND KID='".$jatekos["AK"]["ID"]."'");
		if(mysql_num_rows($sql) != 0) $van = true;
		else $van = false;

		mysql_free_result($sql);

		echo "<table width='70%' align='center'><tr><td class='arucim piac".($aru["Darab"] == 0 ? "_no" : ($van ? "_van" : ""))." clear'>";
		echo "<span class='arufont'>".$aru["Nev"]."</span><br><br>";

		echo "<b>Készlet</b>: ".($aru["Darab"] > 0 ? $aru["Darab"]."db" : "<i>elfogyott</i>")." <b>(</b>Feltöltés ".date("H:00", time()+3600)."kor: +".$aru["Ujratoltes"]."<b>)</b><br>";
		//echo "<b>Készlet feltöltése</b>: ".date("H:00", time()+3600)."kor<br>";

		echo "<b>Ára</b>: ".number_format($aru["Ara"])." ".($aru["AraT"] == "penz" ? "Ft" : "PrémiumPont")."<br>";

		echo "<br>";

		if($aru["AraT"] == "penz" && $aru["Ara"] > $penz || $aru["AraT"] == "premium" && $aru["Ara"] > $pont)
			echo "<i>Ezt nem tudod kifizetni<br>Szükséged van még ".($aru["AraT"] == "penz" ? ($aru["Ara"] - $penz)."Ftra" : ($aru["Ara"] - $pont)."pontra")."</i>";
		elseif($aru["Darab"] == 0)
			echo "<i style='font-weight: bold; color: #AA0; font-size: 20px;'>Elfogyott</i>";
		elseif($van)
			echo "<i style='font-weight: bold; color: #060; font-size: 20px;'>Már van ilyened</i>";
		else
			echo "<button class='style' onclick='Megvesz(\"".$aru["Tipus"]."\")'>Megvesz</button><script type='text/javascript'>$('button.style').button();</script>";

		echo"</td></tr></table><br>";
	}
	mysql_free_result($sql_piac);
	echo "</center>";
}
elseif($a == "megvesz")
{
	$mit = addslashes($_POST["mit"]);
	$sql = mysql_query("SELECT * FROM piac_aruk WHERE tipus='".$mit."'");
	if(mysql_num_rows($sql) != 1)
		echo "Ez az áru valószínüleg törlődött...";
	else
	{
		$aru = mysql_fetch_array($sql);
		if($aru["Darab"] < 1)
			echo "Sajnos ez elfogyott... Várj, amíg újratöltődik";
        elseif($aru["AraT"] == "penz" && $jatekos["AK"]["Bank"] < $aru["Ara"])
            echo "Nincs elég pénzed hozzá!";
		else
		{
            mysql_query("UPDATE playerek SET Bank = '".($jatekos["AK"]["Bank"] - $aru["Ara"])."' WHERE ID='".$jatekos["AK"]["ID"]."'");
			mysql_query("UPDATE piac_aruk SET Darab = Darab - 1 WHERE tipus='".$mit."'");

            if($aru["Tipus"] == "nevt") $aru["Tipus"] = "nev";

			$ad = mysql_query("INSERT INTO targyak (KID, Tipus, Nev, Megveve) VALUES('".$jatekos["AK"]["ID"]."', '".$aru["Tipus"]."', '".$aru["Nev"]."', '".date("Y-m-d H:i:s")."')");

			if($ad) echo "Sikeresen vettél egy ".$aru["Nev"]."-t";
			else echo "MySQL hiba";
		}
	}
	mysql_free_result($sql);
}
elseif($a == "cuccok")
{
	$targy_sql = mysql_query("SELECT * FROM targyak WHERE KID='".$jatekos["AK"]["ID"]."'");
	if(mysql_num_rows($targy_sql) == 0)
		Hiba("Nincs tárgyad", false, false);
	else
	{
		echo'
		<div id="dialog-ujnev" title="Névváltás" style="display: none">
			<p>
				<b>Jelenlegi neved:</b> '.$jatekos["AK"]["Nev"].'<br><br>
				<label for="ujnev">Új név </label>
				<input type="text" name="ujnev" id="ujnev" class="text ui-widget-content ui-corner-all">
			</p>
		</div>
		';
		echo "<center><table width='50%'>";
		echo "<tr>
				<td width='70%' style='font-weight: bold; color: white;'>Név</td>
				<td width='30%' style='font-weight: bold; color: white;'>Művelet</td>
			  </tr>";

		while($targy = mysql_fetch_array($targy_sql))
		{
			//<img src='img/elfogad.png' title='Aktiválás' height='15'>
			//<img src='img/torol.png' title='Törlés' height='15'>
			echo"
			<tr class='kispadding'>
				<td><font class='arufont_kicsi' color='#AAAA00'>".$targy["Nev"]."</font></td>
				<td>
					<a href='javascript: void(0)' onclick='Akcio(\"aktival\", \"".$targy["ID"]."\", \"".$targy["Tipus"]."\")'>
						Aktivál
					</a><!--
					 - <a href='javascript: void(0)' onclick='Akcio(\"torol\", \"".$targy["ID"]."\", \"".$targy["Tipus"]."\")'>
						Törlés
					</a>-->
				</td>
			</tr>";
		}

		echo "</table></center>";
	}
	mysql_free_result($targy_sql);
}
elseif($a == "nevvaltas")
{
	$ujnev = addslashes($_POST["ujnev"]);
	if(!RolePlayNev($ujnev))
		echo "Ez nem RolePlay név! Válassz rendes nevet!";
	elseif(strpos(strtolower($ujnev), "eastwood") !== false || strpos(strtolower($ujnev), "clint_") !== false)
		echo "Ez a név nem vehető fel, válassz másik nevet!";
	else
	{
		$sql = mysql_query("SELECT ID FROM playerek WHERE Nev='".$ujnev."'");
		if(mysql_num_rows($sql) != 0)
			echo "Ez a név foglalt! Válassz másik nevet!";
		else
		{
			$sql2 = mysql_query("SELECT nev FROM targyak WHERE KID='".$jatekos["AK"]["ID"]."' AND tipus='nev'");
			if(mysql_num_rows($sql2) == 0)
				echo "Nincs névváltási engedélyed... Előbb vegyél egyet!";
			else
			{
				$sql3 = mysql_query("SELECT Uj FROM nevvaltas WHERE KID='".$jatekos["AK"]["ID"]."' AND elbiralva='n'");
				if(mysql_num_rows($sql3) != 0)
					echo "Már küldtél be egy névváltási kérelmet! Amíg ezt nem bírálják el, addig nem kérhetsz újat";
				else
				{
					mysql_query("DELETE FROM targyak WHERE KID='".$jatekos["AK"]["ID"]."' AND tipus='nev' LIMIT 1");
					$sql4 = mysql_query("INSERT INTO nevvaltas(KID, Regi, Uj, Datum, AID, ANev) VALUES('".$jatekos["AK"]["ID"]."', '".$jatekos["AK"]["Nev"]."', '".$ujnev."', '".date("Y-m-d H:i:s")."', '".$jatekos["ID"]."', '".$jatekos["Nev"]."')");
					if($sql4)
						echo "ok"; //echo "Sikeres kérelem. Az admin elbírálás után az új neved ".$ujnev." lesz!";
					else
						echo "MySQL Hiba";
				}
				mysql_free_result($sql3);
			}
			mysql_free_result($sql2);
		}
		mysql_free_result($sql);
	}
}

/*AJAX*/ Lablec(false, null, true); } /*AJAX*/


Fejlec();

if($jatekos["AK"] == -1) Hiba("Nincs karakter kiválasztva");
if($jatekos["AK"]["Online"] == 1) Hiba("Jelenleg Online vagy");
?>

<style type="text/css">
td.arucim
{
	text-align: center;
	vertical-align: middle;

	width: 270px;
	height: 180px;

	color: black;
}

td.piac{ background: url("img/piac/alap.png") no-repeat top center; }
td.piac_no{ background: url("img/piac/fekete.png") no-repeat top center; }
td.piac_van{ background: url("img/piac/zold.png") no-repeat top center; }

.arufont{ font: italic bold 17px "Algerian"; }
.arufont_kicsi{ font: italic bold 15px "Algerian"; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	Betolt("aruk");
});

var ajax = 0;

function Nevvaltas()
{
	if(ajax) return 1;

	var ujnev = $("#ujnev").val();
	if(ujnev.length < 8) { alert("Minimum 8 karakterből kell állnia az új nevednek!"); return 1; }

	ajax = 1;

	$.ajax({
		type: "POST",
		url: "?ajax&a=nevvaltas",
		data: "ujnev="+ujnev,
		success: function(msg){
			ajax = 0;
			if(msg == "ok")
			{
				alert("Sikeres kérelem. Az admin elbírálás után az új neved "+ujnev+" lesz!");
				$( "#dialog-ujnev" ).dialog( "close" );
				Betolt("cuccok");
			}
			else
				alert(msg);
		}
	});
}

function Akcio(muvelet, id, tipus)
{
	if(muvelet == "aktival" && $( "#dialog-ujnev" ))
	{
		$(function() {
			$( "#dialog-ujnev" ).dialog({
				resizable: false,
				height: 160,
				width: 300,
				modal: false,
				title: "Névváltás",
				show: "fade",
				hide: "fade",
				position: ["top", 100],
				buttons: {
					"Névváltás": function() {
						if(!ajax) Nevvaltas();
					},
					"Mégse": function() {
						if(!ajax) $( this ).dialog( "close" );
					}
				}
			});
		});
	}
}

function Betolt(oldal)
{
	ajax = 1;
	$("#ajax").html("<center><b>Betöltés...</b></center>");
	$.ajax({
		type: "POST",
		url: "?ajax&a="+oldal,
		success: function(msg){
			ajax = 0;
			$("#ajax").html(msg);
		}
	});
}

function Megvesz(mit)
{
	if(ajax) return 1;
	ajax = 1;
	$.ajax({
		type: "POST",
		url: "?ajax&a=megvesz",
		data: "mit="+mit,
		success: function(msg){
			ajax = 0;
			Betolt("aruk");
			alert(msg);
		}
	});
}
</script>

<center>
	<h1>Piac</h1>
	<b>
		<a href='javascript: void(0);' onclick="Betolt('aruk')">Áruk</a> - <a href='javascript: void(0);' onclick="Betolt('cuccok')">Cuccaid / Felhasználás</a>
		<hr width="25%">
	</b>
</center><br>

<div id='ajax' style='display: inline'></div>

<? Lablec(); ?>