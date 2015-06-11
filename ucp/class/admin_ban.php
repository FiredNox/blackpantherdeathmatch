<?
require_once("include/main.php");

if(!$jatekos["Belepve"] || !CheckAdmin() && !IsScripter())
	Error();

Fejlec();

$a = $_GET["akcio"];
$m = $_POST["muvelet"];
$id = $_GET["id"];

$idok = Array("p", "o", "n", "h");

if(isset($a))
{
	if(isset($id) && is_numeric($id))
	{
		if($a == "torol")
		{
			$sql = mysql_query("SELECT Cim, Oka, Bannolta, Orok, Ido FROM bans WHERE ID='".$id."'");
			if(mysql_num_rows($sql))
			{
				$ban = mysql_fetch_array($sql); mysql_free_result($sql);
				mysql_query("DELETE FROM bans WHERE ID='".$id."'");
				echo Felhivas("Ban törölve: ".$ban["Cim"]);
				SeeLOG("unban", "<b class='kiemelt'>".$jatekos["LogNev"]."</b> törölt egy bant - <b class='kiemelt'>Név/IP:</b> ".$ban["Cim"]." - <b class='kiemelt'>Bannolta:</b> ".$ban["Bannolta"].", <b class='kiemelt'>Ok:</b> ".$ban["Oka"].", <b class='kiemelt'>Örök:</b> ".($ban["Orok"] == "i" ? "igen" : "nem (".date("Y-m-d H:i", $ban["Ido"])."ig)"), $jatekos["ID"], $jatekos["LogNev"], 1);
			}
		}
	}
}
if(isset($m))
{
	if($m == "kereses")
	{
		$_POST["keres"] = SzokozKereses($_POST["keres"]);
		if(!SzovegAnalizalas($_POST["keres"], "._-"))
			$uzenet = "Hibás karakterek a szövegben!";
		else
			$keres = $_POST["keres"];
	}
	elseif($m == "hozzaad")
	{
		$uzenet = array();
		$ido = $_POST["ido"]; $idotipus = $_POST["idotipus"]; $orok = $_POST["orok"]; $oka = $_POST["oka"];
		if(in_array($idotipus, $idok) || $orok == "i")
		{
			if($orok != "i" && $ido == "" || $orok != "i" && !is_numeric($ido) || $orok != "i" && $ido < 1)
				$uzenet[] = "Hibás idő";
			else
			{
				if(strlen($oka) < 5)
					$uzenet[] = "Az oknak minimum 5 karakter hosszúnak kell lennie!";
				elseif(!SzovegAnalizalas($oka))
					$uzenet[] = "Hibás karakterek a szövegben!";
				else for($c = 1; $c <= 10; $c++)
				{
					$cim = mysql_escape_string($_POST["cim".$c]);
					if(strlen($cim) < 5) continue;

					if(preg_match('@^[a-zA-Z_]{5,24}$@', $cim))
						$tipus = 1; // név
					else if(preg_match('@^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$@', $cim))
						$tipus = 2; // ip
					else if(preg_match('@^[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}$@', $cim))
						$tipus = 3; // cid
					else
						continue;
					
					$hibas = false;
					if($tipus == 1)
					{
						$sql2 = mysql_query("SELECT Nev FROM playerek WHERE Nev LIKE '%".$cim."%'");
						$num = mysql_num_rows($sql2);
						if($num > 1)
						{
							$sql2 = mysql_query("SELECT Nev FROM playerek WHERE Nev = '".$cim."'");
							$num = mysql_num_rows($sql2);
						}

						$hibas = true;
						if($num > 1)
							$uzenet[] = "Erre a névre több találat is van, kérlek pontosíts: ".$cim;
						elseif($num == 0)
							$uzenet[] = "Nincs ilyen játékos: ".$cim;
						else
						{
							$hibas = false;
							$p = mysql_fetch_array($sql2);
							$cim = $p["Nev"];
							unset($p);
						}
						mysql_free_result($sql2);
					}

					if(!$hibas)
					{
						$sql = mysql_query("SELECT ID FROM bans WHERE cim='".$cim."'");
						if(mysql_num_rows($sql) == 1)
							$uzenet[] = "Már van ilyen ban: ".$cim;
						else
						{
							$unix = time();

							$rido = $ido;
							if($idotipus == "p")
								$rido *= 60;
							elseif($idotipus == "o")
								$rido *= 3600;
							elseif($idotipus == "n")
								$rido *= 86400;
							else
								$rido *= 604800;

							if($orok == "i")
								$rido = 0;
							else
								$orok = "n";

							if($tipus == 1)
								$tipus = 'nev';
							elseif($tipus == 2)
								$tipus = 'ip';
							elseif($tipus == 3)
								$tipus = 'cid';
							
							$bannolta = "[web] ".$jatekos["LogNev"];
							mysql_query("INSERT INTO bans(Tipus, Cim, Ido, Orok, Bannolta, Oka, Datum) VALUES('".$tipus."', '".$cim."', '".($orok != "i" ? $unix+$rido : 0)."', '".$orok."', '".$bannolta."', '".$oka."', '".$unix."')");

							$uzenet[] = "Ban hozzáadva: ".$cim;

							SeeLOG("ban", "<b class='kiemelt'>".$jatekos["LogNev"]."</b> hozzáadott egy bant - <b class='kiemelt'>Név/IP:</b> ".$cim." - <b class='kiemelt'>Ok:</b> ".$oka.", <b class='kiemelt'>Örök:</b> ".($orok == "i" ? "igen" : "nem (".date("Y-m-d H:i", $unix+$rido)."ig)"), $jatekos["ID"], $jatekos["LogNev"], 1);
							


						}
						mysql_free_result($sql);
					}
				}
			}
		}

		unset($cim, $rido, $ido, $idotipus, $orok, $oka);
	}
}

?>

<style type="text/css">
	table
	{
		border-spacing:0px;
	}
	td
	{
		border: 2px outset #888;
		padding: 5px;
		vertical-align: middle;
		text-align:center;
		background-color: #202020;
	}
	td.clear, .cleartr td{border: none;}
	.left
	{
		text-align: left;
	}
	.cim
	{
		color:white;
		font-weight:bold;
	}
	img.link
	{
		cursor: crosshair;
	}
	img.link:hover
	{
		cursor: pointer;
	}
	a.no
	{
		text-decoration:none;
		font-weight:bold;
	}
</style>

<script type="text/javascript">
	var kereses = false;
	var hozzaadas = false;
	function Torol(id, nev)
	{
		if(confirm("Biztosan törlöd a következő bant?\nBan: "+nev))
		{
			if(window.location.href.indexOf("?") > 10)
				window.location.href = window.location.href+"&akcio=torol&id="+id;
			else
				window.location.href = window.location.href+"?akcio=torol&id="+id;
		}
	}
	function OrokCheckbox(checked)
	{
		if(checked)
		{
			document.getElementById("ido").disabled = true;
			document.getElementById("idotipus").disabled = true;
		}
		else
		{
			document.getElementById("ido").disabled = false;
			document.getElementById("idotipus").disabled = false;
		}
	}
	function nyit(mit)
	{
		if(mit == "hozzaadas")
		{
			//if(hozzaadas)
			if(document.getElementById("hozzaadas_div").style.display != "none")
			{
				$("#hozzaadas_div").slideToggle(1000);
				document.getElementById("hozzaadas_img").src = "img/plus.gif";
				//document.getElementById("hozzaadas_div").style.display = "none";
				//hozzaadas = false;
			}
			else
			{
				$("#hozzaadas_div").slideToggle(1000);
				document.getElementById("hozzaadas_img").src = "img/minus.gif";
				//document.getElementById("hozzaadas_div").style.display = "block";
				//hozzaadas = true;
			}
		}
		else if(mit == "kereses")
		{
			//if(kereses)
			if(document.getElementById("kereses_div").style.display != "none")
			{
				$("#kereses_div").slideToggle(1000);
				document.getElementById("kereses_img").src = "img/plus.gif";
				//document.getElementById("kereses_div").style.display = "none";
				//kereses = false;
			}
			else
			{
				$("#kereses_div").slideToggle(1000);
				document.getElementById("kereses_img").src = "img/minus.gif";
				//document.getElementById("kereses_div").style.display = "block";
				//kereses = true;
			}
		}
		else if(mit == "extrabannok")
		{
			if(document.getElementById("extrabannok_div").style.display != "none")
			{
				$("#extrabannok_div").slideToggle(1000);
				document.getElementById("extrabannok_img").src = "img/plus.gif";
			}
			else
			{
				$("#extrabannok_div").slideToggle(1000);
				document.getElementById("extrabannok_img").src = "img/minus.gif";
			}
		}
	}
</script>

<? if(isset($uzenet) && (is_string($uzenet) && $uzenet != "" || is_array($uzenet) && count($uzenet)))
	echo Felhivas((is_array($uzenet) ? implode("<br>", $uzenet) : $uzenet)); ?>

<center><a href='admin_ban<?=$config["Ext"]?>'><h1>Ban / UnBan</h1></a>

<!--#############################################################################################################-->
<!--#############################################################################################################-->
<!--#############################################################################################################-->

<table width="100%" align="center" border="1">
				<tr class="cleartr cim">
					<td width="80%" class="nopadding" style="padding-top: 3px">Esemény</td>
					<td width="20%" class="nopadding" style="padding-top: 3px">Időpont</td>
				</tr><tr class="cleartr"><td colspan="2" class="nopadding"><br></td></tr>
<?
$sql = mysql_query("SELECT Log, Datum, Tipus FROM log WHERE tipus='ban' OR tipus='unban' ORDER BY Datum DESC LIMIT 5");
while($log = mysql_fetch_array($sql))
{
	echo"<tr>
			<td class='bal'><img src='img/".($log["Tipus"] == "ban" ? "plus" : "minus").".gif'> ".$log["Log"]."</td>
			<td class='jobb'>".DatumFormat($log["Datum"])."</td>
		 </tr>";
}
?>
</table><br>

<!--#############################################################################################################-->
<!--#############################################################################################################-->
<!--#############################################################################################################-->

<span class="kez" onclick="nyit('hozzaadas')"><img src="img/<?=(isset($m) && $m == "hozzaad" ? "minus" : "plus")?>.gif" id="hozzaadas_img"> Hozzáadás</span>
<div id="hozzaadas_div" style="display:<?=(isset($m) && $m == "hozzaad" ? "block" : "none")?>">
<form method="POST"><input type="hidden" name="muvelet" value="hozzaad">

<center>
<table width="75%" align="center">

	<tr>
		<td width="30%"><b>Név(részlet) / IP</b></td>
		<td width="70%"><input type="text" name="cim1" maxlength="39" value="<?=(isset($cim) ? $cim : "")?>" style="width: 300px">
			<br><img src="img/plus.gif" id="extrabannok_img" onclick="nyit('extrabannok')">
			<div id="extrabannok_div" style="display: none">
				<input type="text" name="cim2" maxlength="39" value="">
				<br><input type="text" name="cim3" maxlength="39" value="">
				<br><input type="text" name="cim4" maxlength="39" value="">
				<br><input type="text" name="cim5" maxlength="39" value="">
				<br><input type="text" name="cim6" maxlength="39" value="">
				<br><input type="text" name="cim7" maxlength="39" value="">
				<br><input type="text" name="cim8" maxlength="39" value="">
				<br><input type="text" name="cim9" maxlength="39" value="">
				<br><input type="text" name="cim10" maxlength="39" value="">
			</div>
		</td>
	</tr>
	<tr>
		<td width="30%"><b>Idő</b></td>
		<td width="70%">
			<input type="text" name="ido" id="ido" maxlength="2" size="3" value="<?=(isset($ido) ? $ido : "")?>">
			<select name="idotipus" id="idotipus">
				<option value="p">Perc</option>
				<option value="o" <?=(isset($idotipus) && $idotipus == "o" ? "selected" : "")?>>Óra</option>
				<option value="n" <?=(isset($idotipus) && $idotipus == "n" ? "selected" : "")?>>Nap</option>
				<option value="h" <?=(isset($idotipus) && $idotipus == "h" ? "selected" : "")?>>Hét</option>
			</select>
			<br><input type="checkbox" name="orok" value="i" onClick="OrokCheckbox(this.checked)" <?=(isset($orok) && $orok == "i" ? "checked" : "")?>> <b>Örök</b>
		</td>
	</tr>
	<tr>
		<td width="30%"><b>Oka</b></td>
		<td width="70%"><input type="text" name="oka" maxlength="200" style="width: 300px" value="<?=(isset($oka) ? $oka : "")?>"></td>
	</tr>
	<tr>
		<td width="30%"><b>Hozzáad</b></td>
		<td width="70%"><input type="submit" value="Hozzáadás" style="padding:1px"></td>
	</tr>

</table>
</center>
</form>
</div>

<br><br>

<span class="kez" onclick="nyit('kereses')"><img src="img/<?=(isset($m) && $m == "kereses" ? "minus" : "plus")?>.gif" id="kereses_img"> Keresés</span>
<div id="kereses_div" style="display:<?=(isset($m) && $m == "kereses" ? "block" : "none")?>">
	<form method="POST"><input type="hidden" name="muvelet" value="kereses">
	<input type="text" name="keres" <?=(isset($m) && $m == "kereses" ? "value='".$keres."'" : "")?>> <input type="submit" value="Keresés" style="padding:1px">
	</form>
</div>

<br><br>

<?
	$sql = mysql_query("SELECT ID FROM bans".(isset($keres) ? " WHERE cim LIKE '%".$keres."%' OR Bannolta LIKE '%".$keres."%' OR Oka LIKE '%".$keres."%'" : ""));
	$num = mysql_num_rows($sql); mysql_free_result($sql);

	$peroldal = 30; // Bejegyzés per olda
	$latni = 2; // A jelenlegi oldal körül hányat mutasson
	$elsok = 3; // Az első és utolsó oldalak közül hányat mutasson

	$oldalak = ceil($num / $peroldal);
	$p = $_GET["o"];
	if(!isset($p) || $p < 1 || $p > $oldalak) $p = 1;

	for($x = 1; $x <= $oldalak; $x++)
	{
		if($x == 1) $szoveg = "Első";
		else if($x == $oldalak) $szoveg = "Utolsó";
		else $szoveg = $x;

		if($x <= $elsok || $x > ($oldalak - $elsok) || $x >= ($p - $latni) && $x <= ($p + $latni))
		{
			if($x != $p)
				$kiirat = " <a href='?o=".$x."'>".$szoveg."</a>";
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
//		if($x > 
	}
	echo "<br>";
	if($p > 1)
		echo "<a href='?o=".($p-1)."'><< Előző</a>";
	else
		echo "<a class='no'><< Előző</a>";
	echo " - ";
	if($p < $oldalak)
		echo "<a href='?o=".($p+1)."'>Következő >></a>";
	else
		echo "<a class='no'>Következő >></a>";

	$limit = Array("min" => (($p-1)*$peroldal),
				   "max" => $peroldal);

	echo "<br><br>";

?>

<table width="100%" align=center>
	<tr>
		<td width="20%" class="cim">IP / Karakter / CID</td>
		<td width="15%" class="cim">Időpont</td>
		<td width="20%" class="cim">Bannolta</td>
		<td width="25%" class="cim">Oka</td>
		<td width="15%" class="cim">Lejár</td>
		<td width="5%" class="cim">Admin</td>
	</tr>
<?
	$tegnapelott = date("Y-m-d", time()-172800);
	$tegnap = date("Y-m-d", time()-86400);
	$ma = date("Y-m-d");
	$holnap = date("Y-m-d", time()+86400);
	$holnaputan = date("Y-m-d", time()+172800);

	$sql = mysql_query("SELECT ID, Tipus, Cim, Datum, Bannolta, Oka, Ido FROM bans".(isset($keres) ? " WHERE cim LIKE '%".$keres."%' OR Bannolta LIKE '%".$keres."%' OR Oka LIKE '%".$keres."%'" : "")." ORDER BY Datum DESC, Cim ASC LIMIT ".$limit["min"].",".$limit["max"]);
	if(mysql_num_rows($sql) == 0)
		echo "<tr><td colspan='6' class='clear'>Nincs ban</td></tr>";
	while($ban = mysql_fetch_array($sql))
	{
		echo"	<tr class='cleartr'>
					<td ".($ban['Tipus']=='cid'?'style="font-size:8px"':'').">".$ban["Cim"]."</td>
					<td>";
					if($ban["Datum"] == 0) echo "<i>Ismeretlen</i>";
					else
					{
						$dat = date("Y-m-d H:i", $ban["Datum"]);
						$dat_e = explode(" ", $dat);
						if($dat_e[0] == $tegnapelott) echo "Tegnap előtt ".$dat_e[1];
						elseif($dat_e[0] == $tegnap) echo "Tegnap ".$dat_e[1];
						elseif($dat_e[0] == $ma) echo "Ma ".$dat_e[1];
						elseif($dat_e[0] == $holnap) echo "Holnap ".$dat_e[1];
						elseif($dat_e[0] == $holnaputan) echo "Holnap után ".$dat_e[1];
						else echo $dat;
					}

		echo "		</td>
					<td>".($ban["Bannolta"] == "Ismeretlen" ? "<i>Ismeretlen</i>" : $ban["Bannolta"])."</td>
					<td>".($ban["Oka"] == "---" ? "<i>Ismeretlen</i>" : $ban["Oka"])."</td>
					<td>";
					if($ban["Ido"] == 0) echo "<i>Soha</i>";
					else
					{
						$dat = date("Y-m-d H:i", $ban["Ido"]);
						$dat_e = explode(" ", $dat);
						if($dat_e[0] == $tegnapelott) echo "Tegnap előtt ".$dat_e[1];
						elseif($dat_e[0] == $tegnap) echo "Tegnap ".$dat_e[1];
						elseif($dat_e[0] == $ma) echo "Ma ".$dat_e[1];
						elseif($dat_e[0] == $holnap) echo "Holnap ".$dat_e[1];
						elseif($dat_e[0] == $holnaputan) echo "Holnap után ".$dat_e[1];
						else echo $dat;
					}
		echo"		</td>
					<td><img class='link' src='img/torol.png' height='15' onClick='Torol(\"".$ban["ID"]."\", \"".$ban["Cim"]."\")'></td>
				</tr>";
	}
?>
</table></center>

<? Lablec(); ?>