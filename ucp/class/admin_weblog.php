<?
require_once("include/main.php");

if(!$jatekos["Belepve"] || !CheckAdmin() && !IsScripter())
	Error();

$darab = 20;

if(isset($_GET["ajax"]))
{
	$plusz = array("accelf", "tarself", "karelf", "ban", "nevelf", "tesztok");
	$minusz = array("accelut", "tarselut", "karelut", "unban", "nevelut", "tarstor", "tesztfail");

	if(isset($_POST["o"])) $o = addslashes($_POST["o"]);
	if(isset($_POST["keres"])) $keres = addslashes($_POST["keres"]);
	if(isset($_POST["tipusok"])) $tipusok = addslashes($_POST["tipusok"]);

	if(!isset($o))
		$from = 0;
	else
		$from = ($o - 1) * $darab;

	$where = "Admin='1'";
	if(isset($keres) && strlen($keres) >= 3 || isset($tipusok))
	{
		$where = "";

		if(isset($keres))
			$where .= "Log LIKE '%".$keres."%'";

		if(isset($tipusok))
		{
			$exp = explode(",", $tipusok);
			$ad = Array();

			for($x = 0; $x < count($exp); $x++)
				$ad []= "Tipus='".$exp[$x]."'";

			if($where != "")
				$where .= " AND (".implode(" OR ", $ad).")";
			else
				$where .= implode(" OR ", $ad);
		}
	}
		$sql = mysql_query("SELECT ID FROM log WHERE ".$where);
		$num = mysql_num_rows($sql); mysql_free_result($sql);

		$peroldal = $darab; // Bejegyzés per olda
		$latni = 2; // A jelenlegi oldal körül hányat mutasson
		$elsok = 3; // Az első és utolsó oldalak közül hányat mutasson

		$oldalak = ceil($num / $peroldal);
		$p = $o;
		if(!isset($p) || $p < 1 || $p > $oldalak) $p = 1;

		for($x = 1; $x <= $oldalak; $x++)
		{
			if($x == 1) $szoveg = "Első";
			else if($x == $oldalak) $szoveg = "Utolsó";
			else $szoveg = $x;

			if($x <= $elsok || $x > ($oldalak - $elsok) || $x >= ($p - $latni) && $x <= ($p + $latni))
			{
				if($x != $p)
					$kiirat = " <a href='javascript: void(0)' onclick='Toltes(\"".$x."\")'>".$szoveg."</a>";
				else
					$kiirat = " <a class='no'>".$szoveg."</a>";
				if($x < $oldalak) $kiirat .= " ";
				echo $kiirat;
			}
			else
			{
				if($x < $p && !$pontok[1])
				{
					$pontok[1] = true;
					echo " ... ";
				}
				else if($x > $p && !$pontok[2])
				{
					$pontok[2] = true;
					echo " ... ";
				}
			}
		}
		echo "<br>";

		if($oldalak > 1)
		{
			if($p > 1)
				echo "<a href='javascript: void(0)' onclick='Toltes(\"".($p-1)."\")'><< Előző</a>";
			else
				echo "<a class='no'><< Előző</a>";
			echo " - ";
			if($p < $oldalak)
				echo "<a href='javascript: void(0)' onclick='Toltes(\"".($p+1)."\")'>Következő >></a>";
			else
				echo "<a class='no'>Következő >></a>";
		}
		echo "<br><br>";

	$res = mysql_query("SELECT * FROM log WHERE ".$where." ORDER BY Datum DESC LIMIT ".$from.", ".$darab);
	if(mysql_num_rows($res) == 0)
		echo "Nem történt semmi";
	else
	{
		echo'
			<table width="100%" align="center" border="1">
				<tr class="cleartr cim">
					<td width="80%" class="nopadding" style="padding-top: 3px">Esemény</td>
					<td width="20%" class="nopadding" style="padding-top: 3px">Időpont</td>
				</tr><tr class="cleartr"><td colspan="2" class="nopadding"><br></td></tr>';

		while($log = mysql_fetch_array($res))
		{
			if(in_array($log["Tipus"], $plusz))
				$log["Log"] = "<img src='img/plus.gif'> ".$log["Log"];
			elseif(in_array($log["Tipus"], $minusz))
				$log["Log"] = "<img src='img/minus.gif'> ".$log["Log"];

			echo"<tr id='tr_".$log["ID"]."' ".($log["Olvasva"] == '0' ? "class='uj'" : "").">
					<td class='bal' title='".$log["IP"]."'>".$log["Log"]."</td>
					<td class='jobb'>".DatumFormat($log["Datum"])."</td>
				</tr>";
		}
		mysql_free_result($res);

		echo'</table>';
	}
	Lablec(false, null, true);
}
Fejlec();
if(isset($uzenet)) echo Felhivas($uzenet);
?>
<style type="text/css">
	table{ border-spacing:0px; }
	td
	{
		border: 2px outset #888;
		padding: 3px;
		vertical-align: top;
		text-align:center;
		background-color: #222222;
		/*color: white;*/
		font-weight: bold;
	}
	td.clear, .cleartr td, .cleartable tr td{ border: none; }
	.left{ text-align: left; }
	.adat
	{
		font-weight:bold;
		text-align:left;
	}
	.kozep
	{
		border-left: 2px solid #888;
		border-right: 2px solid #888;
	}
	tr.uj td
	{
		background-color: darkorange;
		color: black;
		font-weight: bold;
	}
	tr.cim td{ color: white; font-size: 125%;}
	.nopadding{ padding: 0px; }
	.link{
		cursor: crosshair; }
	.link:hover{
		cursor: pointer; }
	.padding { padding: 3px; }
	a.no
	{
		text-decoration:none;
		font-weight:bold;
	}
</style>

<script type="text/javascript">
var tolt = false;
var oldal = 1;
$(document).ready(
	function(){
		Toltes(1);
	}
);

var checks = Array("accelf", "accelut", "ban", "jelszovaltas", "karelf", "karelut", "kszerk", "ruhavaltas", "tarself", "tarselut", "unban", "utalas", "nevelf", "nevelut", "tarstor", "kontroll", "tesztok", "tesztfail");

function CheckAll(akcio)
{
	for(x = 0; x < checks.length; x++)
	{
		if(!$("#"+checks[x])) continue;

		if(akcio == "torol")
			$("#"+checks[x]).removeAttr("checked");
		else if(akcio == "jelol")
			$("#"+checks[x]).attr("checked", "checked");
		else if(akcio == "megfordit")
		{
			if($("#"+checks[x]).attr("checked") != "")
				$("#"+checks[x]).removeAttr("checked");
			else
				$("#"+checks[x]).attr("checked", "checked");
		}
	}
}

function IsNumeric(sText)
{
	var ValidChars = "0123456789."; var IsNumber=true; var Char;
	for	(i = 0; i < sText.length && IsNumber == true; i++) { Char = sText.charAt(i); if(ValidChars.indexOf(Char) == -1){IsNumber = false;}}
	return IsNumber;
}

function Toltes(id)
{
	if(tolt) return 1;
	if(!id || !IsNumeric(id) || id < 1 || id > 9999)
	{
		$("#log").html("Hiba történt");
		return 1;
	}

	var tipusok = "";
	for(x = 0; x < checks.length; x++)
	{
		if(!$("#"+checks[x]) || $("#"+checks[x]).attr("checked") != "checked") continue;
		if(tipusok != "") tipusok = tipusok + ",";
		tipusok = tipusok + checks[x];
	}

	$("#log").html("<img src='img/ajax-loader.gif'>");

	adatok = "o="+id;
	if($("#keres").val() != "") adatok = adatok + "&keres=" + $("#keres").val();
	if(tipusok.length != 0) adatok = adatok + "&tipusok=" + tipusok;

	$.ajax({
		type: "POST",
		url: "?ajax",
		data: adatok,
		success: function(msg){
			$("#log").html(msg);
			oldal = id;
			tolt = false;
		}
	});
}
</script>

<center><h1>Weblog</h1></center>

<center><table width="98%" align="center"><tr><td width="100%" style="background-color: transparent; border: none; text-align: center;">

<input type="text" id="keres"><br><br>

<center><table width="75%" class="clear">
<tr>
	<td width="66%" colspan="2">Admin</td>
	<td width="33%">Játékos</td>
</tr>
<tr class="balra">
	<td width="33%">
		<input type="checkbox" id="accelf" checked> <img src='img/plus.gif'> Account<br>
		<input type="checkbox" id="accelut" checked> <img src='img/minus.gif'> Account<br>
		<input type="checkbox" id="karelf" checked> <img src='img/plus.gif'> Karakter<br>
		<input type="checkbox" id="karelut" checked> <img src='img/minus.gif'> Karakter<br>
		<input type="checkbox" id="tarself" checked> <img src='img/plus.gif'> Társítás<br>
		<input type="checkbox" id="tarselut" checked> <img src='img/minus.gif'> Társítás<br>
	</td>

	<td width="33%">
        <input type="checkbox" id="nevelf" checked> <img src='img/plus.gif'> Névváltás<br>
        <input type="checkbox" id="nevelut" checked> <img src='img/minus.gif'> Névváltás<br>
		<input type="checkbox" id="ban" checked> <img src='img/plus.gif'> Ban<br>
		<input type="checkbox" id="unban" checked> <img src='img/minus.gif'> Ban<br>
        <input type="checkbox" id="tarstor" checked> <img src='img/minus.gif'> Társítás törlés<br>
		<input type="checkbox" id="kszerk" checked> K. Szerkesztés<br>
        <input type="checkbox" id="kontroll" checked> Szerver kontroll<br>
	</td>

	<td width="33%">
		<input type="checkbox" id="jelszovaltas"> Jelszóváltás<br>
		<input type="checkbox" id="ruhavaltas"> Ruhaváltás<br>
		<input type="checkbox" id="utalas"> Utalás<br>
        <input type="checkbox" id="tesztok"> <img src='img/plus.gif'> Tesztkitöltés<br>
        <input type="checkbox" id="tesztfail"> <img src='img/minus.gif'> Tesztkitöltés<br>
	</td>

</tr>
<tr>
	<td colspan="3">
		<a href="javascript: void(0)" onclick="CheckAll('jelol')">Mindet kijelöl</a> - <a href="javascript: void(0)" onclick="CheckAll('torol')">Kijelölés törlése</a> - <a href="javascript: void(0)" onclick="CheckAll('megfordit')">Kijelölés megfordítása</a>
	</td>
</tr>

</table></center>

<br>
<input type="button" onclick="Toltes(1)" value="Keresés">
<br>

<br><div id='log'></div>

</td></tr></table></center>

<? Lablec(); ?>