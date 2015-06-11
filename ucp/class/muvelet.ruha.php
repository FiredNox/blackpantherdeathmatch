<?
require_once("include/main.php");

if(!$jatekos["Belepve"]) Hiba("Nem vagy belépve!", true);
//if($jatekos["Kivalasztva"] == 0) Hiba("Nincs karakter kiválasztva - Ezt a \"Karakter\" menüpontban teheted meg", true);
$kinfo = $jatekos["Karakter"][$jatekos["Kivalasztva"]-1];

if(isset($_GET["ajax"]))
{
	$muvelet = $_POST["muvelet"];
	$almuvelet = (isset($_POST["almuvelet"]) ? $_POST["almuvelet"] : "");

	if($muvelet == "jelszo")
	{
		if($almuvelet == "karakter")
		{
			$acc = $_POST["acc"];
			$kari = $_POST["kari"];
			if($jatekos["Kivalasztva"] == 0)
				echo "Nincs kiválasztva karakter!";
			elseif(!SzovegAnalizalas($acc, null, false) || !SzovegAnalizalas($kari, null, false))
				echo "Hibás jelszó - Engedélyezett karakterek: Angol ABC, Számok, Speciális karakterek: '.', '_', '[', ']'";
			else if(SeeEncode($acc) != $jatekos["Jelszo"])
				echo "A megadott jelszó hibás";
			else if($kinfo["Online"] != 0)
				echo "A karakter jelenleg Online, így addig nem tudsz jelszót váltani";
			else
			{
				$sql = @mysql_query("UPDATE playerek SET Pass='".SeeEncode($kari, true)."' WHERE ID='".$kinfo["ID"]."'");
				if($sql) echo "Sikeres jelszó módosítás a következő karakteren: ".$kinfo["Nev"];
				else echo "Hiba a MySQL kérés során";
				SeeLOG("jelszovaltas", "Sikeres jelszóváltás a <b class='kiemelt'>".$kinfo["Nev"]."</b> nevű karakteren!", $jatekos["ID"], $jatekos["Nev"], 1);
			}
		}
		elseif($almuvelet == "account")
		{
			$regijelszo = $_POST["regi"]; $jelszo = $_POST["uj"];

			if(strlen($regijelszo) < 3 || strlen($regijelszo) > 15 || strlen($jelszo) < 3 || strlen($jelszo) > 15)
				echo "Hibás jelszó - Minimum 3, maximum 15 karakter";
			elseif(!SzovegAnalizalas($regijelszo) || !SzovegAnalizalas($jelszo) || !SzovegAnalizalas($jelszo2))
				echo "Hibás jelszó - Engedélyezett karakterek: Magyar ABC, Számok, Speciális karakterek: '.', '_', '[', ']'";
			else
			{
				$sql = mysql_query("SELECT ID, Nev, Mail FROM accountok WHERE ID='".$jatekos["ID"]."' AND Jelszo='".SeeEncode($regijelszo)."'");
				if(mysql_num_rows($sql) != 1)
					echo "Hibás jelszó!";
				else
				{
					$account = mysql_fetch_array($sql); mysql_free_result($sql);
					$datum = date("Y-m-d H:i:s"); $kulcs = Generator(32);
					$sql = mysql_query("UPDATE accountok SET Jelszo='".SeeEncode($jelszo)."' WHERE ID='".$account["ID"]."'");

					$uzenet =	'Üdv, '.$account['Nev'].'!'.PHP_EOL.
						PHP_EOL.
						'Értesítünk róla, hogy a felhasználódon jelszót váltottak, ha te voltál az, hagyd figyelmen kívül ezt a levelet'.PHP_EOL.
						PHP_EOL.
						'IP Cím: '.GetIP().PHP_EOL.
						PHP_EOL.
						'Üdvözlettel,'.PHP_EOL.
						$config['SNev'] . ' AdminTeam'.PHP_EOL.
						PHP_EOL.
						PHP_EOL.
						'(Ez egy automatikus levél, ne válaszolj rá!)';

					if($sql)
					{
						echo "Sikeres jelszó módosítás a kezelőfelületi felhasználón!";
						SeeLOG("jelszovaltas", "Sikeres jelszóváltás a kezelőfelületi felhasználón!", $jatekos["ID"], $jatekos["Nev"], 1);
						SendMail($account["Mail"], "Értesítés: Jelszóváltás", $uzenet, null, null, false);
					}
					else echo 'Hiba a MySQL kérés során';
				}
			}
		}
	}
	elseif($muvelet == "penz")
	{
		$cimzett = str_replace(" ", "", addslashes($_POST["cimzett"]));
		$ossz = str_replace(" ", "", $_POST["ossz"]);
		$kozlemeny = $_POST["kozlemeny"];
		$koltseg = ($config["Settings"]["kezelesi_koltseg"] / 100) + 1;

		if($jatekos["Kivalasztva"] == 0)
			echo "Nincs kiválasztva karakter!";
		elseif(!is_numeric($ossz))
			echo "Számot írj be!";
		elseif($ossz < 10000 || $ossz >= 1000000000)
			echo "Minimum 10000Ft, maximum 999,999,999Ft!";
		elseif($kinfo["Online"] == "1")
			echo "Jelenleg Online vagy!";
		else
		{
			if($kinfo["Bank"] < ($ossz * $koltseg))
				echo "Nincs ennyi pénz a számládon";
			else
			{
				$res = mysql_query("SELECT ID, Nev, Online, Bankszamla FROM playerek WHERE Nev='".$cimzett."'");
				if(mysql_num_rows($res) != 1)
					echo "Nincs ilyen játékos";
				else
				{
					$player = mysql_fetch_array($res); mysql_free_result($res);

					$bszarr = explode(",", $player["Bankszamla"]);
					$bsz = $bszarr[1];

					$res = mysql_query("SELECT ID, Nev FROM accountok WHERE Karakter1='".$player["ID"]."' OR Karakter2='".$player["ID"]."'");
					
					if(mysql_num_rows($res) == 1)
					{
						$acc = mysql_fetch_array($res);
						$vanacc = true;
					}
					else $vanacc = false;
					mysql_free_result($res);

					if($player["ID"] == $kinfo["ID"])
						echo "Magadnak utalsz? -.-\"";
					elseif($player["Online"] == "1")
						echo "Ez a játékos jelenleg Online";
					else
					{
						
						$kezel =$ossz * $koltseg - $ossz;
						//echo "INSERT INTO cmd (cmd, e1) VALUES ('7', '$kezel')";
						mysql_query("INSERT INTO cmd (cmd, e1) VALUES ('7', '".$kezel."')");

						mysql_query("UPDATE playerek SET Bank = Bank + ".$ossz." WHERE ID='".$player["ID"]."'");
						mysql_query("UPDATE playerek SET Bank = Bank - ".($ossz * $koltseg)." WHERE ID='".$kinfo["ID"]."'");
						echo "Átutaltál ".number_format($ossz)."Ftot a ".$player["Nev"]." bankszámlájára (".$bsz.") Régi egyenleged: ".number_format($kinfo["Bank"], 0, ',', ',')."Ft, új: ".number_format(($kinfo["Bank"] - ($ossz * $koltseg)), 0, ',', ',')."Ft - Kezelési költség: ".($ossz * $koltseg - $ossz)."Ft Közlemény: ".$kozlemeny;
						
						
						

						SeeLOG("utalas", "<b class='kiemelt'>".$kinfo["Nev"]."</b> karakterről utalás történt ide: <b class='kiemelt'>".$bsz."</b> (".$player["Nev"].")! Az összeg ".number_format($ossz)."Ft Közlemény: ".$kozlemeny."! (kezelési költség: ".($ossz * $koltseg - $ossz)."Ft)", $jatekos["ID"], $jatekos["Nev"], 1);

						if($vanacc)
							SeeLOG("u_utalas", "<b class='kiemelt'>".$kinfo["Nev"]."</b> utalt ".number_format($ossz)."Ftot a karakteredre: <b class='kiemelt'>".$player["Nev"]."</b> Közlemény: ".$kozlemeny."!", $acc["ID"], $acc["Nev"], 0);
					}
				}
			}
		}
	}
	elseif($muvelet == "ruha")
	{
		$ruha = $_POST["ruha"];
		if($jatekos["Kivalasztva"] == 0)
				echo "Nincs kiválasztva karakter!";
		elseif(!in_array($ruha, $config["CivilRuhak"]) || in_array($ruha, $config["HibasRuhak"]))
			echo "Hiba";
		else
		{
			if($kinfo["Online"] == '1')
				echo "Jelenleg Online vagy!";
			elseif($kinfo["Bankszamla"][0] != '1')
				echo "Nincs bankszámlád, amiről fizethetnéd a ruhát";
			elseif($kinfo["Bank"] < 20000)
				echo "A ruha ára 20,000Ft, nincs ennyi pénz a számládon";
			else
			{
				mysql_query("UPDATE playerek SET Bank = Bank - 20000, Model='".$ruha."' WHERE ID='".$kinfo["ID"]."'");

				mysql_query("INSERT INTO cmd (cmd, e1) VALUES ('6', '20000')");
				echo "Megvetted a ruhát 20,000Ftért: <img src='img/skin/Skin_".$ruha.".png'>";
				SeeLOG("ruhavaltas", "Sikeres ruhaváltás (ruha: ".$ruha.") a <b class='kiemelt'>".$kinfo["Nev"]."</b> karakteren!", $jatekos["ID"], $jatekos["Nev"], 1);
			}
		}
	}
	Lablec(false, null, true);
}
Fejlec();

if(isset($uzenet)) echo Felhivas($uzenet);
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
	}
	td.clear{border: none;}
	.left
	{
		text-align: left;
	}
	.adat
	{
		font-weight:bold;
		text-align:left;
	}
	.adat_ertek
	{
		text-align:right;
	}
	.reg tr td
	{
		border: none;
	}
</style>

<script type="text/javascript">
	var effekt = false;
	var ajaxtoltes = false;
	var Ruha = <?=$kinfo["Model"]?>;
	var RuhaV = false;
	var SliderLoaded = false;

	function nyit(mit)
	{
		if(effekt) return 1;
		effekt = true;

		if(document.getElementById(mit+"_div").style.display != "none")
		{
			$("#"+mit+"_div").slideToggle(2000, function() { effekt = false; });
			document.getElementById(mit+"_img").src = "img/plus.gif";
		}
		else
		{
			$("#"+mit+"_div").slideToggle(2000, function() { effekt = false;
				if(mit == "ruha" && !SliderLoaded) { $('#coda-slider-1').codaSlider(); SliderLoaded = true; }
			});
			document.getElementById(mit+"_img").src = "img/minus.gif";
		}
	}
	function Indit(muvelet)
	{
		if(ajaxtoltes)
			return 1;

		if(muvelet == "accjelszo")
		{
			var regi = $("#regijelszo").val();
			var uj = $("#ujjelszo").val();
			var uj2 = $("#ujjelszo").val();

			if(regi.length < 1)
				alert("Nincs megadva account jelszó");
			else if(uj.length < 1)
				alert("Add meg az új jelszót");
			else if(uj != uj2)
				alert("Az új jelszavak nem egyeznek");
			else
			{
				ajaxtoltes = true;

				$("#account_statusz").html("<img src='img/ajax-loader.gif'>");

				var adatok = "regi="+regi+
							 "&uj="+uj+
							 "&muvelet=jelszo&almuvelet=account";

				$.ajax({
					type: "POST",
					url: "?ajax",
					data: adatok,
					success: function(msg){
						$("#account_statusz").html("<b>"+msg+"</b>");
						ajaxtoltes = false;
					}
				});
			}
		}
		else if(muvelet == "jelszo")
		{
			var acc = $("#accjelszo").val();
			var kari = $("#karijelszo").val();
			var kari2 = $("#karijelszo2").val();

			if(acc.length < 1)
				alert("Nincs megadva account jelszó");
			else if(kari.length < 1)
				alert("Add meg az új jelszót");
			else if(kari != kari2)
				alert("Az új jelszavak nem egyeznek");
			else
			{
				ajaxtoltes = true;

				$("#jelszo_statusz").html("<img src='img/ajax-loader.gif'>");

				var adatok = "acc="+acc+
							 "&kari="+kari+
							 "&muvelet=jelszo&almuvelet=karakter";

				$.ajax({
					type: "POST",
					url: "?ajax",
					data: adatok,
					success: function(msg){
						$("#jelszo_statusz").html("<b>"+msg+"</b>");
						ajaxtoltes = false;
					}
				});
			}
		}
		else if(muvelet == "penz")
		{
			var cimzett = $("#cimzett").val();
			var osszeg = $("#osszeg").val();
			var kozlemeny = $("#kozlemeny").val();

			if(cimzett.length < 1)
				alert("Nincs megadva bankszámla");
			else if(osszeg.length < 1)
				alert("Add meg az összeget!");
			else if(kozlemeny.length < 1)
				alert("Add meg miért küldöd!");
			else
			{
				ajaxtoltes = true;

				$("#penz_statusz").html("<img src='img/ajax-loader.gif'>");

				var adatok = "cimzett="+cimzett+
							 "&ossz="+osszeg+
							 "&kozlemeny="+kozlemeny+
							 "&muvelet=penz";

				$.ajax({
					type: "POST",
					url: "?ajax",
					data: adatok,
					success: function(msg){
						$("#penz_statusz").html("<b>"+msg+"</b>");
						ajaxtoltes = false;
					}
				});
			}
		}
		else if(muvelet == "ruha")
		{
			if(!RuhaV)
				alert("Előbb válassz ruhát!");
			else
			{
				ajaxtoltes = true;

				$("#ruha_statusz").html("<img src='img/ajax-loader.gif'>");

				var adatok = "ruha="+Ruha+
							 "&muvelet=ruha";

				$.ajax({
					type: "POST",
					url: "?ajax",
					data: adatok,
					success: function(msg){
						$("#ruha_statusz").html("<b>"+msg+"</b>");
						ajaxtoltes = false;
					}
				});
			}
		}
	}

	function Skin(id)
	{
		if(Ruha != -1)
		{
			$("#Ruha_"+Ruha).css("border", "0px");
			$("#Ruha_"+Ruha).css("padding", "3px");
		}

		$("#Ruha_"+id).css("border", "3px solid yellow");
		$("#Ruha_"+id).css("padding", "0px");
		Ruha = id;
		RuhaV = true;
	}
</script>

<center><h1>Műveletek</h1></center>

<table width="100%"><tr><td width="100%">

	<!-- ################################################################################################################### -->

	<h3><span class="kez" onclick="nyit('accjelszo')"><img src="img/plus.gif" id="accjelszo_img"> Jelszóváltás (Kezelőfelületen)</span></h3>
	<div id="accjelszo_div" style="display: none">

	<table class="clear" width="45%">
		<tr>
			<td class="clear">Régi jelszó</td>
			<td class="clear"><input type="password" id="regijelszo" maxlength="20" size="20"></td>

		</tr>
		<tr>

			<td class="clear">Új jelszó</td>
			<td class="clear"><input type="password" id="ujjelszo" maxlength="20" size="20"></td>

		</tr>
		<tr>

			<td class="clear">Új jelszó (ismétlés)</td>
			<td class="clear"><input type="password" id="ujjelszo2" maxlength="20" size="20"></td>
		</tr>
	</table>

	<input type="button" value="Váltás" style="padding:1px" onclick="Indit('accjelszo')">&nbsp;
	<div id='account_statusz' style='display:inline; font-size:10px; color:yellow;'></div>
	</div>

	<!-- ################################################################################################################### -->
	<br>

	<h3><span class="kez" onclick="nyit('jelszo')"><img src="img/plus.gif" id="jelszo_img"> Jelszóváltás (Karakteren)</span></h3>
	<div id="jelszo_div" style="display: none">

	<table class="clear" width="45%">
		<tr>
			<td class="clear">Kezelőfelületi jelszó</td>
			<td class="clear"><input type="password" id="accjelszo" maxlength="20" size="20"></td>

		</tr>
		<tr>

			<td class="clear">Új jelszó</td>
			<td class="clear"><input type="password" id="karijelszo" maxlength="20" size="20"></td>

		</tr>
		<tr>

			<td class="clear">Új jelszó (ismétlés)</td>
			<td class="clear"><input type="password" id="karijelszo2" maxlength="20" size="20"></td>
		</tr>
	</table>

	<input type="button" value="Váltás" style="padding:1px" onclick="Indit('jelszo')">&nbsp;
	<div id='jelszo_statusz' style='display:inline; font-size:10px; color:yellow;'></div>
	</div>

	<!-- ################################################################################################################### -->
	<br>

	<h3><span class="kez" onclick="nyit('penz')"><img src="img/plus.gif" id="penz_img"> Pénz utalás</span></h3>
	<div id="penz_div" style="display: none">

	<?
		$res = mysql_query("SELECT Bank, Bankszamla FROM playerek WHERE id='".$kinfo["ID"]."'");
		$data = mysql_fetch_array($res); mysql_free_result($res);
		$bankszamla = explode(",", $data["Bankszamla"]);
		if($data["Bank"] > 0 && $bankszamla[1] > 0)
		{
	?>
	<table class="clear" width="40%">
		<tr>
			<td class="clear">Játékos neve</td>
			<td class="clear"><input type="text" id="cimzett" maxlength="20" size="20"></td>
		</tr>
		<tr>

			<td class="clear">Összeg</td>
			<td class="clear"><input type="text" id="osszeg" maxlength="9" size="9"></td>
		</tr>
		<tr>

			<td class="clear">Közlemény(miért utalod)</td>
			<td class="clear"><input type="text" id="kozlemeny" maxlength="30" size="30"></td>
		</tr>
	</table>
	<?
		}else echo "Nincs bankszámlád, vagy nincs pénz a bankszámládon";
	?>

	<input type="button" value="Küldés" style="padding:1px" onclick="Indit('penz')">&nbsp;
	<div id='penz_statusz' style='display:inline; font-size:10px; color:yellow;'></div>
	</div>

	<!-- ################################################################################################################### -->
	<br>

	<h3><span class="kez" onclick="nyit('ruha')"><img src="img/plus.gif" id="ruha_img"> Ruhavásárlás</span></h3>
	<div id="ruha_div" style="display: none">

	<div class="coda-slider-wrapper">
		<div class="coda-slider preload" id="coda-slider-1">
			<!--<div class="panel">
				<div class="panel-wrapper">
					<h2 class="title">Panel 1</h2>
					<p></p>
				</div>
			</div>
			<div class="panel">
				<div class="panel-wrapper">
					<h2 class="title">Panel 2</h2>
					<p></p>
				</div>
			</div>-->
	<?
		$skin = 0;
		$megvan = 0;
		$darabok = 30;
		$szoveg = "";
		$indult = 0;
		while($skin < 300)
		{
			if(!in_array($skin, $config["CivilRuhak"])) {$skin++; continue; }
			if($megvan % $darabok == 0)
				$indult = $skin;
			
			$szoveg .= "<img src='img/skin/Skin_".$skin.".png' alt='".$skin."' title='ID: ".$skin."' onclick='Skin(\"".$skin."\")' id='Ruha_".$skin."' style='".($kinfo["Model"] == $skin ? "border:3px solid yellow" : "padding:3px")."'>";

			if($megvan % $darabok == ($darabok-1))
			{
				echo"<div class='panel'><div class='panel-wrapper'><h2 class='title'>".$indult."-".$skin."</h2>";
				echo $szoveg;
				echo "</div></div>";
				$szoveg = "";
			}
			$utolso = $skin;
			$skin++;
			$megvan++;
		}

		if($szoveg != "")
		{
			echo"<div class='panel'><div class='panel-wrapper'><h2 class='title'>".$indult."-".$utolso."</h2>";
			echo $szoveg;
			echo "</div></div>";
			unset($szoveg);
		}
	?>
		</div><!-- .coda-slider -->
	</div><!-- .coda-slider-wrapper -->

	<input type="button" value="Megvesz" style="padding:1px" onclick="Indit('ruha')">&nbsp;
	<div id='ruha_statusz' style='display:inline; font-size:10px; color:yellow;'>Egy ruha ára 20,000Ft</div>
	</div>

	<!-- ################################################################################################################### -->

</td></tr></table>

<? Lablec(); ?>