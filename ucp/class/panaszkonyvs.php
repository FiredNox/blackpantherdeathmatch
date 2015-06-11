<?
require_once("include/main.php");

if(!$jatekos["Belepve"])
	Hiba("Nem vagy belépve", true);

if($jatekos["Kivalasztva"] == 0) Hiba("Nincs kiválasztva karakter!");

$kari = $jatekos["Karakter"][$jatekos["Kivalasztva"] - 1];

$a = $_GET["a"];

if(isset($_GET["ajax"]))
{
	if($a == "torles" && isset($_POST["id"]) && is_numeric($_POST["id"]) && $jatekos["Admin"] >= 3)
	{
		$sql = mysql_query("SELECT ID FROM panaszkonyv WHERE id='".$_POST["id"]."'");
		if(mysql_num_rows($sql) != 1)
			echo "Nincs ilyen panasz";
		else
		{
			$sql_d = mysql_query("DELETE FROM panaszkonyv WHERE id='".$_POST["id"]."'");
			if($sql_d)
				echo "ok";
			else
				echo "MySQL hiba";
		}
		mysql_free_result($sql);
	}
	elseif($a == "statuszvaltas" && isset($_POST["statusz"]) && isset($_POST["id"]) && is_numeric($_POST["id"]) && $jatekos["Admin"] >= 3)
	{
		if(!in_array($_POST["statusz"], Array("uj", "elbiralas", "zarva")))
			echo "Hiba: ".$_POST["statusz"];
		else
		{
			$sql_0 = mysql_query("SELECT Statusz FROM panaszkonyv WHERE ID='".$_POST["id"]."'");
			if(mysql_num_rows($sql_0) != 1)
				echo "A panasz időközben törölve lett...";
			else
			{
				$panasz = mysql_fetch_array($sql_0);
				if($panasz["Statusz"] == $_POST["statusz"])
					echo "Már ez a panasz státusza...";
				else
				{
					if($_POST["statusz"] != "zarva")
						$sql = mysql_query("UPDATE panaszkonyv SET Statusz='".$_POST["statusz"]."', Modositva='".date("Y-m-d H:i:s")."', Modositotta='".$kari["Nev"]."' WHERE id='".$_POST["id"]."'");
					else
						$sql = mysql_query("UPDATE panaszkonyv SET Statusz='".$_POST["statusz"]."', Modositva='".date("Y-m-d H:i:s")."', Modositotta='".$kari["Nev"]."', Zarta='".$kari["Nev"]."', Lezarva='".date("Y-m-d H:i:s")."' WHERE id='".$_POST["id"]."'");

					if($sql)
						echo "Sikeres státusz frissítés";
					else
						echo "MySQL Hiba";
				}
			}
			mysql_free_result($sql_0);
		}
	}
	elseif($a == "uj" || $a == "frissit" && isset($_POST["id"]) && is_numeric($_POST["id"]))
	{
		$kire = addslashes($_POST["kire"]);
		$oka = addslashes(str_replace("\n", "<br>", $_POST["oka"]));
		$mj = addslashes(str_replace("\n", "<br>", $_POST["megjegyzes"]));
		$log = addslashes(str_replace("\n", "<br>", $_POST["log"]));
		$biz = addslashes($_POST["bizonyitek"]);
		$biztip = addslashes($_POST["biztip"]);

		$osszesbiz = Array();

		if($biztip == "kepvideo" || $biztip == "mindketto")
		{
			$kepv1 = explode("|", $biz);
			foreach($kepv1 AS $kepv2)
			{
				$kepv3 = explode(";", $kepv2);
				if(count($kepv3) != 2) continue;

				if($kepv3[0] == "kep" && JoCucc($kepv3[1], "kep"))
					$osszesbiz[] = "kep;".$kepv3[1];
				elseif($kepv3[0] == "video" && JoCucc($kepv3[1], "video"))
					$osszesbiz[] = "video;".$kepv3[1];
			}
		}

		if(!isset($kire) || !isset($oka) || (!isset($log) && !isset($biz)) || !isset($biztip) ||
			$biztip != "kepvideo" && $biztip != "log" && $biztip != "mindketto")
			echo "Hiba";
		elseif(strlen($oka) < 30)
			echo "A panasz okát fejtsd ki bővebben!";
		elseif(($biztip == "log" || $biztip == "mindketto") && strlen($log) < 30)
			echo "Ennél hosszabb log kell...";
		elseif(($biztip == "kepvideo" || $biztip == "mindketto") && (count($osszesbiz) == 0))
			echo "Hibás bizonyítékok... Rendes képet / videót adj meg!";
		else
		{
			if($kire == "Ismeretlen") $ki = 0;
			else
			{
				$sql = mysql_query("SELECT ID FROM playerek WHERE nev='".$kire."'");
				if(mysql_num_rows($sql) != 1) $ki = -1;
				else
				{
					$player = mysql_fetch_array($sql);
					$ki = $player["ID"];
				}
				mysql_free_result($sql);
			}
			
			if($ki == -1)
				echo "Nincs ilyen játékos...";
			else
			{
				$ertekek = Array();

				if($a == "uj")
				{
					$ertekek["KID"] = $kari["ID"];
					$ertekek["KNev"] = $kari["Nev"];

					$ertekek["Statusz"] = "uj";
					$ertekek["Nyitva"] = date("Y-m-d H:i:s");
				}

				$ertekek["PID"] = $ki;
				$ertekek["PNev"] = $kire;

				$ertekek["Oka"] = $oka;
				$ertekek["Megjegyzes"] = $mj;

				$ertekek["Bizonyitek"] = $biztip;
				
				if($biztip == "kepvideo" || $biztip == "mindketto")
					$ertekek["BizKepVideo"] = implode("|", $osszesbiz);

				if($biztip == "log" || $biztip == "mindketto")
					$ertekek["BizLog"] = $log;

				if($a == "uj")
				{
					$names = Array(); $values = Array();
					foreach($ertekek AS $name => $value)
					{
						$names[] = $name;
						$values[] = "'".$value."'";
					}

					$query = "INSERT INTO panaszkonyv(".implode(",", $names).") VALUES(".implode(",", $values).")";
					$sql = mysql_query($query);
					
					$id = mysql_insert_id();
				}
				else
				{
					$set = Array();
					foreach($ertekek as $name => $value)
						$set[] = $name."='".$value."'";

					$id = $_POST["id"];

					$query = "UPDATE panaszkonyv SET ".implode(",", $set)." WHERE id='".$id."'";
					$sql = mysql_query($query);
				}

				if(!$sql)
					echo "MySQL hiba";
				else
					echo $id;
			}
		}

	}
	elseif($a == "ellenorzes")
	{
		if($_POST["tipus"] == "kep")
		{
			if(JoCucc($_POST["cim"], "kep"))
				echo "ok";
		}
		else
		{
			if(JoCucc($_POST["cim"], "video"))
				echo "ok";
		}
	}
	elseif($a == "keres")
	{
		$nev = $_GET["term"];

		$valasz = Array();

		if(!isset($_GET["mindegy"]))
			$where = "WHERE Nev LIKE '%".$nev."%' AND Nev != '".$kari["Nev"]."'";
		else
			$where = "WHERE Nev LIKE '%".$nev."%'";

		$sql = mysql_query("SELECT Nev FROM playerek ".$where." ORDER BY Nev ASC LIMIT 30");
		while($jatekos = mysql_fetch_array($sql))
			$valasz[] = $jatekos["Nev"];
		
		mysql_free_result($sql);

		echo json_encode($valasz);
	}
	Lablec(false, null, true);	
}

Fejlec();
?>

<style type="text/css"></style>
<script type="text/javascript" src="include/yoxview/yoxview-init.js"></script>
<script type="text/javascript">
	function PK_Torlese(id)
	{
		if(!confirm("Biztosan törölni akarod?")) return 1;

		$('#torol_'+id).css("display", "none");
		$.ajax({
			type: "POST",
			url: "?ajax&a=torles",
			data: "id="+id,
			success: function(msg){
				if(msg == "ok")
					window.location.reload(true);
				else
				{
					alert(msg);
					$('#torol_'+id).css("display", "inline");
				}
			}
		});
	}
</script>

<center>
	<h1>Panaszkönyv <sup style='color:red; font-size: 14px; font-weight: bold;'>BETA</sup></h1>
	<b>
		<a href='?a=fo'>Főoldal</a> - <a href='?a=osszes'>Összes panasz</a> - <a href='?a=uj' class='kiemelt'>Új panasz</a>
		<hr width="30%">
	</b>
</center>

<?

if(!isset($a) || $a == "fo")
{
	echo Cim("Az 5 legújabb panasz", 95, false);
	echo "<center><table width='95%' class='kozep'>
			<tr class='bold'>
				<td width='30%'>Nyitotta</td>
				<td width='30%'>Kire</td>
				<td width='30%'>Nyitva</td>
				<td width='10%'>Megnéz</td>
			</tr>";

	$sql = mysql_query("SELECT ID, KID, KNev, PNev, Nyitva FROM panaszkonyv WHERE Statusz = 'uj' ORDER BY Nyitva DESC LIMIT 5");
	if(mysql_num_rows($sql) != 0)
	{
		while($panasz = mysql_fetch_array($sql))
			echo "<tr class='kispadding'>
					<td>".$panasz["KNev"]."</td>
					<td>".$panasz["PNev"]."</td>
					<td>".DatumFormat($panasz["Nyitva"])."</td>
					<td style='padding-bottom: 0px'>
						<a href='?a=pk&id=".$panasz["ID"]."'><img src='img/nagyito.png' width='12'></a>
						".($panasz["Statusz"] == "uj" && $panasz["KID"] == $kari["ID"] || $panasz["Statusz"] != "zarva" && $jatekos["Admin"] >= 3 ?
							" <a href='?a=pk&id=".$panasz["ID"]."&szerkeszt'><img src='img/edit.png' width='14'></a>" : "")."
						".($jatekos["Admin"] >= 3 ?
							" <a href='javascript: void(0);' onclick='PK_Torlese(\"".$panasz["ID"]."\")'><img id='torol_".$panasz["ID"]."' src='img/torol.png' width='12'></a>" : "")."
					</td>
				  </tr>";
	}
	else
		echo "<tr><td colspan='4'>Nincs nyitva új panasz</td></tr>";

	mysql_free_result($sql);

	echo "</table></center>";

	echo "<br>";

	echo Cim("Az 5 utolsó lezárt panasz", 95, false);
	echo "<center><table width='95%' class='kozep'>
			<tr class='bold'>
				<td width='25%'>Nyitotta</td>
				<td width='25%'>Kire</td>
				<td width='20%'>Lezárva</td>
				<td width='20%'>Zárta</td>
				<td width='10%'>Megnéz</td>
			</tr>";

	$sql = mysql_query("SELECT ID, KNev, PNev, Lezarva, Zarta FROM panaszkonyv WHERE Statusz = 'zarva' ORDER BY Nyitva DESC LIMIT 5");
	if(mysql_num_rows($sql) != 0)
	{
		while($panasz = mysql_fetch_array($sql))
			echo "<tr class='kispadding'>
					<td>".$panasz["KNev"]."</td>
					<td>".$panasz["PNev"]."</td>
					<td>".DatumFormat($panasz["Lezarva"])."</td>
					<td>".$panasz["Zarta"]."</td>
					<td style='padding-bottom: 0px'>
						<a href='?a=pk&id=".$panasz["ID"]."'><img src='img/nagyito.png' width='12'></a>
						".($jatekos["Admin"] >= 3 ?
							" <a href='javascript: void(0);' onclick='PK_Torlese(\"".$panasz["ID"]."\")'><img id='torol_".$panasz["ID"]."' src='img/torol.png' width='12'></a>" : "")."
					</td>
				  </tr>";
	}
	else
		echo "<tr><td colspan='5'>Nincs nyitva új panasz</td></tr>";

	echo "</table></center>";
}
elseif($a == "osszes")
{
	echo "<br>";

	$sql = mysql_query("SELECT ID FROM panaszkonyv ".(isset($where) ? $where : ""));
	$num = mysql_num_rows($sql); mysql_free_result($sql);

	if($num == 0)
		Hiba("Nincs panasz");

	$peroldal = 10; // Bejegyzés per oldal
	$latni = 2; // A jelenlegi oldal körül hányat mutasson
	$elsok = 3; // Az első és utolsó oldalak közül hányat mutasson

	$oldalak = ceil($num / $peroldal);
	$p = $_GET["o"];
	if(!isset($p) || $p < 1 || $p > $oldalak) $p = 1;

	$extra = $extralinkhez;

	echo "<center>";

	for($x = 1; $x <= $oldalak; $x++)
	{
		if($x == 1) $szoveg = "Első";
		else if($x == $oldalak) $szoveg = "Utolsó";
		else $szoveg = $x;

		if($x <= $elsok || $x > ($oldalak - $elsok) || $x >= ($p - $latni) && $x <= ($p + $latni))
		{
			if($x != $p)
				$kiirat = " <a href='?a=osszes&o=".$x.(isset($extra) ? "&".$extra : "")."'>".$szoveg."</a>";
			else
				$kiirat = " <a class='no'>".$szoveg."</a>";
			if($x < $oldalak) $kiirat .= ", ";
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
	if($p > 1)
		echo "<a href='?a=osszes&o=".($p-1).(isset($extra) ? "&".$extra : "")."'><< Előző</a>";
	else
		echo "<a class='no'><< Előző</a>";
	echo " - ";
	if($p < $oldalak)
		echo "<a href='?a=osszes&o=".($p+1).(isset($extra) ? "&".$extra : "")."'>Következő >></a>";
	else
		echo "<a class='no'>Következő >></a>";

	$limit = Array("min" => (($p-1)*$peroldal),
				   "max" => $peroldal);

	echo "<br><br>";
	echo "Találatok: ".$num."db";
	echo "<br><br>";

	echo "<table width='95%' class='kozep'>
			<tr class='bold'>
				<td width='25%'>Nyitotta</td>
				<td width='25%'>Kire</td>
				<td width='25%'>Mikor</td>
				<td width='15%'>Státusz</td>
				<td width='10%'>Megnéz</td>
			</tr>";

	$sql = mysql_query("SELECT ID, KNev, PNev, Nyitva, Statusz FROM panaszkonyv ORDER BY Nyitva DESC, ID DESC LIMIT ".$limit["min"].",".$limit["max"]);
	while($panasz = mysql_fetch_array($sql))
	{
		switch($panasz["Statusz"])
		{
			case "uj": $statusz = "<b style='color: yellow'>Új</b>"; break;
			case "elbiralas": $statusz = "<b style='color: orange'>Elbírálás alatt</b>"; break;
			case "zarva": $statusz = "<b style='color: green'>Zárva</b>"; break;
			default: $statusz = "<i>Ismeretlen</i>";
		}
		echo "
		<tr class='kispadding'>
			<td>".$panasz["KNev"]."</td>
			<td>".$panasz["PNev"]."</td>
			<td>".$panasz["Nyitva"]."</td>
			<td>".$statusz."</td>
			<td style='padding-bottom: 0px'>
				<a href='?a=pk&id=".$panasz["ID"]."'><img src='img/nagyito.png' width='12'></a>
				".($panasz["Statusz"] == "uj" && $panasz["KID"] == $kari["ID"] || $panasz["Statusz"] != "zarva" && $jatekos["Admin"] >= 3 ?
					"<a href='?a=pk&id=".$panasz["ID"]."&szerkeszt'><img src='img/edit.png' width='14'></a>" : "")."
				".($jatekos["Admin"] >= 3 ?
					" <a href='javascript: void(0);' onclick='PK_Torlese(\"".$panasz["ID"]."\")'><img id='torol_".$panasz["ID"]."' src='img/torol.png' width='12'></a>" : "")."
			</td>
		</tr>
		";
	}mysql_free_result($sql);

	echo "</table></center>";
}
elseif($a == "pk" && isset($_GET["id"]) && is_numeric($_GET["id"]) && !isset($_GET["szerkeszt"]))
{
	$id = $_GET["id"];
	echo "<br>";

	$sql = mysql_query("SELECT * FROM panaszkonyv WHERE id='".$id."'");
	if(mysql_num_rows($sql) != 1)
		Hiba("Ez a panasz nem létezik");

	$panasz = mysql_fetch_array($sql); mysql_free_result($sql);

	//echo "<center><h2>".$panasz["KNev"]." => ".$panasz["PNev"]."</h2></center><br>";
	echo "<table width='100%' class='kispadding'><tr><td style='padding: 5px'>
			<span style='font-size: 12px'>";

	if(!$szerkeszt)
	{
		if($jatekos["Admin"] < 3)
		{
			echo "<b class='narancs'>Panasz státusza:</b>
					".($panasz["Statusz"] == "uj" ? "<b style='color: yellow'>Új</b>" :
						($panasz["Statusz"] == "elbiralas" ? "<b style='color: orange'>Elbírálás alatt</b>" : "")
					)."<br><br>";
		}
		else
		{
?>
<script type="text/javascript">

	function StatuszValtas(id)
	{
		$('#statusz').attr("disabled", "disabled");
		$.ajax({
			type: "POST",
			url: "?ajax&a=statuszvaltas",
			data: "id="+id+"&statusz="+$('#statusz').val(),
			success: function(msg){
				alert(msg);
				$('#statusz').removeAttr("disabled");
			}
		});
	}

</script>
<?
			echo "<b class='narancs'>Panasz státusza:</b>
					<select id='statusz' onchange='StatuszValtas(\"".$panasz["ID"]."\")'>
						<option value='uj'>Új</option>
						<option value='elbiralas' ".($panasz["Statusz"] == "elbiralas" ? "selected" : "").">Elbírálás alatt</option>
						<option value='zarva' ".($panasz["Statusz"] == "zarva" ? "selected" : "").">Zárva</option>
					</select>
					<br><br>";
		}
	}

	echo "<b class='narancs'>Panasz nyitója:</b><br>
			".$panasz["KNev"]."<br><br>";

	echo "<b class='narancs'>Panasz rá:</b><br>
			".$panasz["PNev"]."<br><br>";

	echo "<b class='narancs'>Oka:</b><br>
			".stripslashes($panasz["Oka"])."<br><br>";

	if($panasz["Bizonyitek"] == "kepvideo" || $panasz["Bizonyitek"] == "mindketto")
	{
		$bizonyitek_kep = "";
		$kepek = explode("|", $panasz["BizKepVideo"]);
		sort($kepek);

		$elso = 1;
		$kepekszama = 0;
		foreach($kepek as $kep)
		{
			if($elso != 1) $bizonyitek_kep .= "<br>";
			$elso = 0;

			$kep = explode(";", $kep);
			if($kep[0] == "kep")
			{
				$kepekszama++;
				$bizonyitek_kep .= "<b>[Kép]</b> <a class='yoxviewLink' href='".$kep[1]."'>Kép #".$kepekszama."</a>";
				// - <a href='javascript: void(0);' onclick='prompt(\"Jelöld ki a linket a CTRL + C kombináció használatával\", \"".$kep[1]."\");' style='font-size: 10px; font-weight: bold;'>LINK</a>
			}
			elseif($kep[0] == "video") $bizonyitek_kep .= "<b>[Videó]</b> <a href='".$kep[1]."' target='_BLANK'>".$kep[1]."</a>";
		}
	}

	if($panasz["Bizonyitek"] == "kepvideo" || $panasz["Bizonyitek"] == "mindketto")
	{
		//if($kepekszama > 0) $bizonyitek_kep = '<div class="thumbnails yoxview">' . $bizonyitek_kep . '</div>';

		echo "<b class='narancs'>Bizonyíték (kép / videó):</b><br>
				<div class='yoxview' style='display: inline'>".$bizonyitek_kep."</div><br><br>";
	}
	
	elseif($panasz["Bizonyitek"] == "log" || $panasz["Bizonyitek"] == "mindketto")
	echo "<b class='narancs'>Bizonyíték (log):</b><br>
			".stripslashes($panasz["BizLog"])."<br><br>";

	echo "<b class='narancs'>Megjegyzés:</b><br>
			".stripslashes($panasz["Megjegyzes"])."<br><br>";

	echo "</span></td></tr></table>";
}
elseif($a == "uj" || $a == "pk" && isset($_GET["szerkeszt"]) && isset($_GET["id"]) && is_numeric($_GET["id"]))
{

	$szerkeszt = 0;

	if(isset($_GET["szerkeszt"]))
	{
		$id = $_GET["id"];
		$sql = mysql_query("SELECT * FROM panaszkonyv WHERE ID='".$id."'");

		if(mysql_num_rows($sql) == 1)
		{
			$p = mysql_fetch_array($sql);
		}
		mysql_free_result($sql);

		if($p["KID"] == $kari["ID"] && $p["Statusz"] == "uj" || $jatekos["Admin"] >= 3 && $p["Statusz"] != "zarva")
			$szerkeszt = 1;
		elseif($p["Statusz"] == "zarva")
			Hiba("Ez a panasz már le lett zárva, nem szerkesztheted!");
		elseif($p["KID"] == $kari["ID"] && $p["Statusz"] == "elbiralas" && $jatekos["Admin"] < 3)
			Hiba("A panasz elbírálás alatt van, már nem szerkesztheted!");

	}

	$kepekszama = 0;
	$videokszama = 0;

	if($szerkeszt)
	{
		if($p["Bizonyitek"] == "kepvideo" || $p["Bizonyitek"] == "mindketto")
		{
			$bizonyitekok = explode("|", $p["BizKepVideo"]);
			$kepek = Array(); $videok = Array();

			foreach($bizonyitekok as $bizonyitek)
			{
				$biz_ex = explode(";", $bizonyitek);

				if($biz_ex[0] == "kep")
					$kepek[] = $biz_ex[1];
				elseif($biz_ex[0] == "video")
					$videok[] = $biz_ex[1];
			}

			$kepekszama = count($kepek);
			$videokszama = count($videok);
		}
	}
	?>
	<script type="text/javascript">
	var panaszra = "<?=($szerkeszt ? $p["PNev"] : "")?>";

	$(function() {
		$( "#pk_kire_valaszt" ).autocomplete({
			source: "panaszkonyv.php?ajax&a=keres<?=($szerkeszt && $p["KID"] != $kari["ID"] ? "&mindegy" : "")?>",
			delay: 500,
			minLength: 3,
			select: function( event, ui ) {
				$("#pk_kire").html(ui.item.value);
				panaszra = ui.item.value;
				ui.item.value = "";
			}
		});
	});

	function Ismeretlen()
	{
		if(!$('#ismeretlen').attr("checked"))
		{
			$("#pk_kire_valaszt").attr("disabled", "disabled");
			$("#pk_kire").html("<i>Ismeretlen</i>");
			panaszra = "Ismeretlen";
		}
		else
		{
			$("#pk_kire_valaszt").removeAttr("disabled");
			$("#pk_kire").html("<i>Nincs kiválasztva</i>");
			panaszra = "";
		}
	}

	var kepek = <?=$kepekszama?>;
	var videok = <?=$videokszama?>;
	var freezelve = 0;

	function Freeze(igen)
	{
		freezelve = igen;
		for(var kep = 1; kep <= 15; kep++)
		{
			if($("#pk_kep_"+kep))
			{
				if(igen) $("#pk_kep_"+kep).attr("disabled", "disabled");
				else $("#pk_kep_"+kep).removeAttr("disabled");
			}
		}
		for(var video = 1; video <= 5; video++)
		{
			if($("#pk_video_"+video))
			{
				if(igen) $("#pk_video_"+video).attr("disabled", "disabled");
				else $("#pk_video_"+video).removeAttr("disabled");
			}
		}
	}

	function Befejezes()
	{
		if(panaszra.length == "0")
		{
			alert("Hiba: Nincs kiválasztva, hogy kire raksz panaszt!");
			return 1;
		}

		var oka = $('#pk_oka').val();
		if(oka.length < 30)
		{
			alert("Hiba: A panasz okát minimum 30 karakterben fogalmazd meg!");
			return 1;
		}

		if($('#bizonyitek').val() == "0")
		{
			alert("Hiba: Bizonyíték is szükséges a panaszhoz!");
			return 1;
		}

		var helyesbizonyitek = 0;
		var bizonyitekok = Array();

		for(var kep = 1; kep <= 15; kep++)
		{
			if($("#pk_kep_"+kep) && $("#pk_kep_"+kep).hasClass("zold"))
			{
				helyesbizonyitek++;
				bizonyitekok.push( "kep;" + $("#pk_kep_"+kep).val() );
			}
		}

		for(var video = 1; video <= 15; video++)
		{
			if($("#pk_video_"+video) && $("#pk_video_"+video).hasClass("zold"))
			{
				helyesbizonyitek++;
				bizonyitekok.push( "video;" + $("#pk_video_"+video).val() );
			}
		}

		var bizonyitek = $('#bizonyitek').val();

		if(bizonyitek == "kepvideo" && helyesbizonyitek == 0)
		{
			alert("Hiba: Minimum 1 helyes kép / videónak kell lennie ahhoz, hogy panaszt nyithass");
			return 1;
		}
		if(bizonyitek == "log" && $('#pk_log').val().length < 30)
		{
			alert("Hiba: A LOGnak hosszabbnak kell lennie...");
			return 1;
		}
		if(bizonyitek == "mindketto" && ($('#pk_log').val().length < 30 || helyesbizonyitek == 0))
		{
			alert("Hiba: Legalább egy helyes kép / videó kell ÉS a logot is ki kell töltened!");
			return 1;
		}

		adatok = "<?=($szerkeszt ? "id=".$id."&" : "")?>kire="+panaszra+
				 "&oka="+oka+
				 "&megjegyzes="+$('#pk_megjegyzes').val()+
				 "&biztip="+bizonyitek;

		if(bizonyitek == "kepvideo" || bizonyitek == "mindketto")
			adatok = adatok + "&bizonyitek=" + implode("|", bizonyitekok);
		if(bizonyitek == "log" || bizonyitek == "mindketto")
			adatok = adatok + "&log=" + $('#pk_log').val();

		$('#vege').attr("disabled", "disabled");

		$.blockUI({
			css: { 
				border: 'none', 
				padding: '15px', 
				backgroundColor: '#000', 
				'-webkit-border-radius': '10px', 
				'-moz-border-radius': '10px', 
				//opacity: .9, 
				color: '#fff' 
			},
			message: "<h1>Kérlek várj...</h1>"
		}); 

		$.ajax({
			type: "POST",
			url: "?ajax&a=<?=($szerkeszt ? "frissit" : "uj")?>",
			data: adatok,
			success: function(msg){
				$('#vege').removeAttr("disabled");
				$.unblockUI();
				if(msg.length > 0 && msg.length <= 5 && IsNumeric(msg))
				{
					alert("Sikeres <?=($szerkeszt ? "frissítés" : "panasznyitás")?>");
					window.location = "?a=pk&id="+msg;
				}
				else
				{
					if(msg.length == 0)
						alert("Hiba történt, próbáld újra");
					else
						alert(msg);
				}
			}
		});

		return 1;
	}

	function URLCheck(id)
	{
		bontva = id.split("_");

		inputid = "#pk_"+bontva[1]+"_"+bontva[2];

		//$(inputid).attr("disabled", "disabled");
		Freeze(true);
		$(inputid).removeClass("zold narancs piros");
		$(inputid).addClass("narancs");

		$.ajax({
			type: "POST",
			url: "?ajax&a=ellenorzes",
			data: "tipus="+bontva[1]+"&id="+bontva[2]+"&cim="+$(inputid).val(),
			success: function(msg){
				if(msg == "ok")
				{
					//$(inputid).removeAttr("disabled");
					$(inputid).removeClass("zold narancs piros");
					$(inputid).addClass("zold");
				}
				else
				{
					//$(inputid).removeAttr("disabled");
					$(inputid).removeClass("zold narancs piros");
					$(inputid).addClass("piros");
				}
				Freeze(false);
			}
		});
	}

	function Bizonyitek_Uj()
	{
		if(freezelve) return 1;
		var ertek = $('#bizonyitek_uj').val();
		if(ertek == "kep")
		{
			if(kepek < 15)
			{
				kepek++;
				if($('#minuszikon_kep')) $('#minuszikon_kep').remove();
				$("#pk_kep").append("<div id='pk_kep_"+kepek+"_div' style='display: inline'><br>Kép #"+kepek+" <input type='text' size='75' id='pk_kep_"+kepek+"'> <img src='img/minus.gif' id='minuszikon_kep' onclick='Bizonyitek_Torol(\"kep\", \""+kepek+"\")'></div>");
				$("#pk_kep_"+kepek+"_div").bind("focusout", function() { URLCheck(this.id); } );
			}
			else alert("Maximum 15 kép engedélyezett");
		}
		else if(ertek == "video")
		{
			if(videok < 5)
			{
				videok++;
				if($('#minuszikon_video')) $('#minuszikon_video').remove();
				$("#pk_video").append("<div id='pk_video_"+videok+"_div' style='display: inline'><br>Videó #"+videok+" <input type='text' size='75' id='pk_video_"+videok+"'> <img src='img/minus.gif' id='minuszikon_video' onclick='Bizonyitek_Torol(\"video\", \""+videok+"\")'></div>");
				$("#pk_video_"+videok+"_div").bind("focusout", function() { URLCheck(this.id); } );
			}
			else alert("Maximum 5 videó engedélyezett");
		}
	}

	function Bizonyitek_Torol(tipus, id)
	{
		if(tipus == "kep")
		{
			if($("#pk_kep_"+id+"_div"))
			{
				$("#pk_kep_"+id+"_div").unbind("focusout");
				$("#pk_kep_"+id+"_div").remove();
				kepek--;

				if(kepek > 0)
					$("#pk_kep_"+kepek+"_div").append("<img src='img/minus.gif' id='minuszikon_kep' onclick='Bizonyitek_Torol(\"kep\", \""+kepek+"\")'>");
			}
		}
		else if(tipus == "video")
		{
			if($("#pk_video_"+id+"_div"))
			{
				$("#pk_video_"+id+"_div").unbind("focusout");
				$("#pk_video_"+id+"_div").remove();
				videok--;

				if(videok > 0)
					$("#pk_video_"+videok+"_div").append("<img src='img/minus.gif' id='minuszikon_video' onclick='Bizonyitek_Torol(\"video\", \""+videok+"\")'>");
			}
		}
	}

	function Bizonyitek()
	{
		var ertek = $('#bizonyitek').val();
		
		if(ertek == "kepvideo")
		{
			$("#kepvideok_uj").css("display", "inline");
			$("#kepvideok").css("display", "block");
			$("#pk_log_div").css("display", "none");
		}
		else if(ertek == "log")
		{
			$("#kepvideok_uj").css("display", "none");
			$("#kepvideok").css("display", "none");
			$("#pk_log_div").css("display", "block");
		}
		else if(ertek == "mindketto")
		{
			$("#kepvideok_uj").css("display", "inline");
			$("#kepvideok").css("display", "block");
			$("#pk_log_div").css("display", "block");
		}
		else
		{
			$("#kepvideok_uj").css("display", "none");
			$("#kepvideok").css("display", "none");
			$("#pk_log_div").css("display", "none");
		}
	}
	</script>
	<style type="text/css">
	.ui-autocomplete { max-height: 100px; overflow-y: auto; overflow-x: hidden; padding-right: 20px; }
	* html .ui-autocomplete { height: 100px; }
	</style>
	<?
	echo "<br>";

	echo "<table width='100%' class='kispadding'><tr><td style='padding: 5px'>
			<span style='font-size: 12px'>";

	echo "<b class='narancs'>Neved:</b><br>".$kari["Nev"]."<br><br>";

	echo "<b class='narancs'>Kire raksz panaszt?</b><br>
			<input type='checkbox' id='ismeretlen' onclick='Ismeretlen()' ".($szerkeszt && $p["PNev"] == "Ismeretlen" ? "" : "checked").">
			 <input type='text' id='pk_kire_valaszt' ".($szerkeszt && $p["PNev"] == "Ismeretlen" ? "disabled" : "")."> <b>Panasz rá:</b> <div id='pk_kire' style='display: inline'>".($szerkeszt ? ($p["PNev"] == "Ismeretlen" ? "<i>Ismeretlen</i>" : $p["PNev"]) : "<i>Nincs kiválasztva</i>")."</div>
			<br><br>";

	echo "<b class='narancs'>Oka</b><br>
			<textarea id='pk_oka' rows='10' cols='75'>".($szerkeszt ? $p["Oka"] : "")."</textarea><br><br>";

	$kepsites = Array(); $videosites = Array();

	foreach($config["PK_Oldalak"]["kep"] as $kepx)
		$kepsites[] = "<a href='http://".$kepx."' target='_BLANK'>".$kepx."</a>";

	foreach($config["PK_Oldalak"]["video"] as $videox)
		$videosites[] = "<a href='http://".$videox."' target='_BLANK'>".$videox."</a>";

	if($szerkeszt)
	{
		$kepekdiv = ""; $videokdiv = "";
		for($x = 0; $x < $kepekszama; $x++)
		{
			$y = $x+1;
			if($y == $kepekszama)
				$kepekdiv .= "<div id='pk_kep_".$y."_div' style='display: inline'><br>Kép #".$y." <input type='text' size='75' id='pk_kep_".$y."' value=".$kepek[$x]."> <img src='img/minus.gif' id='minuszikon_kep' onclick='Bizonyitek_Torol(\"kep\", \"".$y."\")'></div>";
			else
				$kepekdiv .= "<div id='pk_kep_".$y."_div' style='display: inline'><br>Kép #".$y." <input type='text' size='75' id='pk_kep_".$y."' value=".$kepek[$x]."></div>";

			$kepekdiv .= "<script>$('#pk_kep_".$y."_div').bind('focusout', function() { URLCheck(this.id); } );</script>";
		}

		for($x = 0; $x < $videokszama; $x++)
		{
			$y = $x+1;
			if($y == $videokszama)
				$videokdiv .= "<div id='pk_video_".$y."_div' style='display: inline'><br>Videó #".$y." <input type='text' size='75' id='pk_video_".$y."' value=".$videok[$x]."> <img src='img/minus.gif' id='minuszikon_kep' onclick='Bizonyitek_Torol(\"kep\", \"".$y."\")'></div>";
			else
				$videokdiv .= "<div id='pk_video_".$y."_div' style='display: inline'><br>Videó #".$y." <input type='text' size='75' id='pk_video_".$y."' value=".$videok[$x]."></div>";

			$videokdiv .= "<script>$('#pk_video_".$x."_div').bind('focusout', function() { URLCheck(this.id); } );</script>";
		}
	}

	echo "<b class='narancs'>Bizonyítékok?</b><br>

			<select id='bizonyitek' onchange='Bizonyitek()'>
				<option value='0'>=[ Válassz ]=</option>
				<option value='kepvideo' ".($szerkeszt && $p["Bizonyitek"] == "kepvideo" ? "selected" : "").">Kép / Videó</option>
				<option value='log' ".($szerkeszt && $p["Bizonyitek"] == "log" ? "selected" : "").">LOG</option>
				<option value='mindketto' ".($szerkeszt && $p["Bizonyitek"] == "mindketto" ? "selected" : "").">Kép / Videó és LOG</option>
			</select>
			
			<div style='display: ".($szerkeszt && ($p["Bizonyitek"] == "kepvideo" || $p["Bizonyitek"] == "mindketto") ? "inline" : "none")."' id='kepvideok_uj'>
					<select id='bizonyitek_uj'>
						<option value='0'>=[ Válassz ]=</option>
						<option value='kep'>Kép</option>
						<option value='video'>Videó</option>
					</select>
					<input type='button' value='Hozzáad' style='padding: 2px' onclick='Bizonyitek_Uj()'>
				<br>
			</div>
			
			<div id='kepvideok' style='display: ".($szerkeszt && ($p["Bizonyitek"] == "kepvideo" || $p["Bizonyitek"] == "mindketto") ? "inline" : "none")."'>
				<b style='color: #F44'>Csak DIREKT linket adj meg!<br>
				- Elfogadott képfeltöltő oldalak: ".implode(", ", $kepsites)."<br>
				- Efogadott videós oldalak: ".implode(", ", $videosites)."</b><br>
				<div id='pk_kep'>".($szerkeszt ? $kepekdiv : "")."</div>
				<div id='pk_video'>".($szerkeszt ? $videokdiv : "")."</div>
			</div>
			
			<div id='pk_log_div' style='display: none'>
				<br><textarea id='pk_log' rows='30' cols='75'>".($szerkeszt && ($p["Bizonyitek"] == "log" || $p["Bizonyitek"] == "mindketto") ? $p["BizLog"] : "")."</textarea>
			</div>
			<br><br>";

	echo "<b class='narancs'>Megjegyzés</b> (Nem kötelező)<br>
			<textarea id='pk_megjegyzes' rows='5' cols='75'></textarea><br><br>";

	echo "<input type='button' id='vege' onclick='Befejezes()' value='Panasz ".($szerkeszt ? "frissítése" : "nyitása")."'>";

	echo "</span></td></tr></table>";
}
?>

<? Lablec(); ?>