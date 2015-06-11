<?
require_once("include/main.php");
require_once($config["Path"]["class"]."/aktivitas.class.php");

if($jatekos["AK"]["Leader"] > 0  && $jatekos["AK"]["Member"] > 0)
{
	$frakcio = ($jatekos["AK"]["Leader"] != 0 ? $jatekos["AK"]["Leader"] : $jatekos["AK"]["Member"]);

	if(isset($_GET["ajax"]))
	{
		$log = "Szef";
		$datum = $_POST["datum"];



		if($log != "SAMP")
			$fajl = $config["Mappa"] . "/scriptfiles/Log/".$log."/".$datum.".log";
		else
			$fajl = $config["Mappa"] . "/samp.ban";

		$mit = Array($fajl);
		
		

		$_POST["exp"] = "@.*\[".$frakcio.". frakció.*".$_POST["exp"].".*@iu";
		
		if(IsTerno())
			echo $_POST["exp"];
		
		for($f = 0; $f < count($mit); $f++)
		{
			$fajl = $mit[$f];
			$handle = @fopen($fajl, "r");
			if ($handle)
			{
				
				echo "<span class='left'><br><hr><br>$datum<br><br><br>";
				$tartalom = fread($handle, filesize($fajl));
				fclose($handle);
				preg_match_all($_POST["exp"], $tartalom, $talalatok);
				unset($tartalom);

				$db = 1;
				foreach($talalatok[0] AS $talalat)
				{
					if($talalat == "") continue;
					echo $talalat."<br>";
					if($db == 1000)
					{
						echo"<br><i>A többi találat nincs megjelenítve!</i>";
						break;
					}
					$db++;
				}

				unset($talalat);
				unset($talalatok);
				echo "</span>";
			
			}
			else
				echo "Fájl megnyitása sikertelen";
		}
		Lablec(false, null, true);
	}
}
Fejlec();

$mettol = "2014-08-10";

$tipusok = Array("","TANKOLÁS", "ingyenszerel","info","PÉNZ","kaja","alma","mati","heroint","kokaint","marihuanát","c4","ruha");

?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#keres_regexp1').keypress(function(event){ if(event.which == '13') Kereses(1); });
		
    });
	var ajaxtoltes = false;
	var extra = false;
	function SimaLOG()
	{
		log = $("#tipus").val();
		Lekeres(log);
	}
	function Lekeres(mit)
	{
		if(ajaxtoltes)
			return 1;

		log = mit;
		datum = $("#ido").val();

		$("#statusz").html("<img src='img/ajax-loader.gif'>");

		$.ajax({
			type: "POST",
			url: "?ajax",
			data: "log="+log+"&datum="+datum,
			success: function(msg){
				$("#statusz").html("<b>"+msg+"</b>");
				ajaxtoltes = false;
			}
		});
	}

    function Kereses(id)
    {
		
        if(ajaxtoltes)
            return 1;

		if(!extra)
		{
			log = $("#tipus").val();
			datum = $("#ido").val();
		}
		else
		{
			log = $("#tipus_"+id).val();
			datum = $("#ido_"+id).val();
		}
        regexp = $("#keres_regexp"+id).val();
		

		het = 0;
		if($('#het') && $('#het').attr("checked"))
			het = 1;

        $("#statusz").html("<img src='img/ajax-loader.gif'>");

        $.ajax({
            type: "POST",
            url: "?ajax&regexp",
            data: "exp="+regexp+"&log="+log+"&datum="+datum+"&het="+het,
            success: function(msg){
                $("#statusz").html("<b>"+msg+"</b>");
                ajaxtoltes = false;
            }
        });
    }

	function Extra()
	{
		if(!extra)
		{
			$('#extra_2').css("display", "inline");
			$('#extra_3').css("display", "inline");

			$('#tipus_1').css("display", "inline");
			$('#tipus_2').css("display", "inline");
			$('#tipus_3').css("display", "inline");

			$('#ido_1').css("display", "inline");
			$('#ido_2').css("display", "inline");
			$('#ido_3').css("display", "inline");
			extra = true;
		}
		else
		{
			$('#extra_2').css("display", "none");
			$('#extra_3').css("display", "none");

			$('#tipus_1').css("display", "none");
			$('#tipus_2').css("display", "none");
			$('#tipus_3').css("display", "none");

			$('#ido_1').css("display", "none");
			$('#ido_2').css("display", "none");
			$('#ido_3').css("display", "none");
			extra = false;
		}
	}
</script>

<style type="text/css">
	table{border-spacing:0px;}
	td{border: 2px outset #888;padding: 5px;vertical-align: middle;text-align:center;background-color: #202020;}
	td.clear, .cleartr td{border: none;}
	.left{text-align: left;}
	.cim{color:white;font-weight:bold;}
	.left li a{text-decoration:none;font-weight:bold;color:white;}
	.left li a:hover{color:yellow;}
	img.link{cursor: crosshair;}
	img.link:hover{cursor: pointer;}
</style>

<?

function SelectKiiras()
{
	global $tipusok, $mettol;
	
	
	$tipusSelect = '<select id="keres_regexp1" style="font-size: 10px;">';
	for($x = 0; $x < count($tipusok); $x++)
	{
		$tipusSelect .= "<option value='".$tipusok[$x]."'>".$tipusok[$x]."</option>";
	}
	$tipusSelect .= '</select>';
	
	$ma = date("Y-m-d"); $holnap = date("Y-m-d", time() + 86400); $most = $mettol; $time = strtotime($mettol . " 12:00:00");

	$idoSelect = '<select id="ido" style="font-size: 10px;">';
	while($most != $holnap)
	{
		$idoSelect .= "<option value='".$most."' ".($most == $ma ? "selected" : "").">".$most."</option>";

		$time += 86400;
		$most = date("Y-m-d", $time);
	}
	$idoSelect .= "</select>";

	return $tipusSelect.$idoSelect;
	
	
}

if(!$jatekos["Belepve"])
	Hiba("Nem vagy belépve");


$kivalasztva = $jatekos["Kivalasztva"];

if($kivalasztva == 0)
	Hiba("Nincs karakter kiválasztva - Ezt a Karakter lapon teheted meg");

$kivalasztva = $jatekos["Kivalasztva"] - 1;

if($jatekos["AK"]["Leader"] < 1  && $jatekos["AK"]["Member"] < 1) Hiba("Nem vagy szervezet tagja");
$frakcio = ($jatekos["AK"]["Leader"] != 0 ? $jatekos["AK"]["Leader"] : $jatekos["AK"]["Member"]);

$show = false;

$limit = $config["FrakcioLimit"][$frakcio];
$letszam = mysql_num_rows( mysql_query("SELECT ID, Nev, Leader, Rank, Online, Admin FROM playerek WHERE Leader='".$frakcio."' OR Member='".$frakcio."' ORDER BY Rank DESC, Nev ASC") );

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$muvelet = $_POST["muvelet"];
	if($muvelet == "felvetel")
	{
		$show = 1;
		$nev = str_replace(" ", "", $_POST["nev"]);
		if($letszam >= $limit)
			$uzenet = "A frakció tele van";
		elseif(strlen($nev) < 4 || strlen($nev) > 20)
			$uzenet = "Hibás név - Minimum 4, maximum 20 karakter";
		//elseif(!RolePlayNev($nev))
		//	$uzenet = "Hibás név - Nem RolePlay név!";
		elseif(!SzovegAnalizalas($nev))
			$uzenet = "Hibás név - Engedélyezett karakterek: Magyar ABC, Számok, Speciális karakterek: '.', '_', '[', ']'";
		else
		{
			$sql = mysql_query("SELECT ID, Nev, Leader, Member, Online FROM playerek WHERE nev LIKE '%".$nev."%'");
			$hiba = 1;
			if(mysql_num_rows($sql) == 0)
				$uzenet = "Nincs ilyen játékos";
			elseif(mysql_num_rows($sql) > 1)
			{
				$sql = mysql_query("SELECT ID, Nev, Leader, Member, Online FROM playerek WHERE nev = '".$nev."'");
				if(mysql_num_rows($sql) == 1)
					$hiba = 0;
				else
					$uzenet = "Több találat is van, pontosíts!";
			}
			else
				$hiba = 0;

			if($hiba == 0)
			{
				$player = mysql_fetch_array($sql);
				if($player["Online"] != 0)
					$uzenet = "Ez a játékos jelenleg Online! Jelenleg csak InGame tudod felvenni";
				elseif($player["Member"] == $frakcio)
					$uzenet = "Ez a játékos már a szervezeted tagja";
				elseif($player["Leader"] > 0  || $player["Member"] > 0)
					$uzenet = "Ez a játékos már egy másik szervezet tagja";
				else
				{
					mysql_query("UPDATE playerek SET Member='".$frakcio."', Rank='0', Skin = Model, Felvetel='".time()."' WHERE ID='".$player["ID"]."'");
					$uzenet = $player["Nev"] . " felvéve a szervezethez";
					$nev = "";
					$letszam++;
				}
			}
		}
	}
	elseif($muvelet == "kirug")
	{
		$nevek = $_POST["nevek"];
		if(count($nevek) > 0)
		{
			$szoveg = ""; $db = 0;
			foreach($nevek as $player)
			{
				if(is_numeric($player))
				{
					$p_sql = mysql_query("SELECT Nev FROM playerek WHERE ID='".$player."' AND Member='".$frakcio."'");
					if(mysql_num_rows($p_sql) == 1)
					{
						$p = mysql_fetch_array($p_sql); mysql_free_result($p_sql);
						mysql_query("UPDATE playerek SET Member='-1', Leader='0', Felvetel='0' WHERE ID='".$player."'");
						if($db > 0) $szoveg .= ", ";
						$db++;
						$szoveg .= $p["Nev"];
						$letszam--;
					}
				}
			}
			if($db > 0)
				echo Felhivas($db . " játékos kirúgva: ". $szoveg);
		}
	}
	elseif($muvelet == "rang")
	{
		$nev = $_POST["nev"]; $rang = $_POST["rang"];
		if(is_numeric($nev) && is_numeric($rang))
		{
			$sql = mysql_query("SELECT Nev, Rank FROM playerek WHERE ID='".$nev."'");
			if(mysql_num_rows($sql) == 1)
			{
				$player = mysql_fetch_array($sql); mysql_free_result($sql);
				if($player["Rank"] == $rang)
					$uzenet = "Minek adsz neki ugyanolyan rangot, mint amilyen most van?";
				else
				{
					mysql_query("UPDATE playerek SET Rank='".$rang."' WHERE ID='".$nev."'");
					$uzenet = $player["Nev"] . " régi rangja: <u>".$player["Rank"]."</u>, új rangja: <u>".$rang."</u>";
				}
			}
		}
	}
}
if(isset($uzenet)) echo Felhivas($uzenet);
?>
<style type="text/css">
	table
	{
		border-spacing:0px;
	}
	table.frakcio tr td
	{
		border: 2px outset #888;
		padding: 2px;
		vertical-align: top;
		text-align:center;
		vertical-align: middle;
	}
	tr.cim td
	{
		padding: 5px;
	}
	td.clear, table.clear tr td, tr.clear td{border: none;}
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
	td.cim
	{
		color:white;
		font-weight:bold;
		border-bottom: 2px solid grey;
	}
	tr.noborder td
	{
		border-top:none;
		border-bottom: 2px solid grey;
	}
</style>

<script type="text/javascript">
	function Klikk(felvetel)
	{
		if(felvetel)
		{
			document.getElementById("felvetel").style.display = "block";
			document.getElementById("rang").style.display = "none";
		}
		else
		{
			document.getElementById("felvetel").style.display = "none";
			document.getElementById("rang").style.display = "block";
		}
	}
</script>
<center>

	<h1><?=$config["Frakciok"][$frakcio]?></h1>

<?
	if($jatekos["Karakter"][$kivalasztva]["Leader"] == $frakcio)
	{
?>

	<table width=60% align=center><tr><td>
		<h2>LEADER</h2>
		<table width=100% class="clear" align=center>
			<tr>
				<td width="22%">
					<span class="left">
					<input type="radio" name="akcio" value="felvesz" onClick="Klikk(true)" <? echo ($show == 1 ? "checked" : ""); ?>> <b>Felvétel</b><br>
					<input type="radio" name="akcio" value="rang" onClick="Klikk(false)" <? echo ($show == 2 ? "checked" : ""); ?>> <b>Rang</b><br>
					</span>
				</td>
				<td width="78%">
					<div id="felvetel" style="display:<? echo ($show == 1 ? "block" : "none"); ?>">
						<? if( $letszam < $limit ) { ?>
						<form method="POST"><input type="hidden" name="muvelet" value="felvetel">
						<input type="text" name="nev" value="<? echo ($show == 1 ? $nev : "Neve"); ?>" onClick="if(this.value=='Neve')this.value='';">
						<input type="submit" value="Felvesz" style="padding:1px">
						<br><font size=1>Mj.: Elég ha a név egy részét írod be</font>
						</form>
						<? } else echo "A frakció tele van"; ?>
					</div>
					<div id="rang" style="display:<? echo ($show == 2 ? "block" : "none"); ?>">
						<?
							$sql = mysql_query("SELECT ID, Nev, Rank FROM playerek WHERE Member='".$frakcio."' AND Leader='0' AND Online!='1' ORDER BY Nev ASC");
							if(mysql_num_rows($sql) != 0)
							{
								echo '<form method="POST"><input type="hidden" name="muvelet" value="rang"><select name="nev">';
								while($p = mysql_fetch_array($sql))
									echo "<option value='".$p["ID"]."'>".$p["Nev"]." [".$p["Rank"]."]</option>";
								echo'
									</select>
									<select name="rang" style="text-align:center">
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>';
								if($frakcio == 9)
								{	
								echo '
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>';
								}
								if($frakcio == 1 || $frakcio == 2 || $frakcio == 3 || $frakcio == 5 || $frakcio == 14 || $frakcio == 20 || $frakcio == 12)
								{
									echo '
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
									';
								}
								echo'</select>
									<input type="submit" value="Rang adás" style="padding:1px">
									</form>
								';
							}
							else
								echo "Nincs tag";
							mysql_free_result($sql);
						?>
					</div>
				</td>
			</tr>

		</table>

	</td></tr></table>
	<br><br>

<? }

echo "Összesen <b>".$letszam."</b> tag van - Maximális létszám: <b>".$limit."</b><br><br>";
?>

	<form method="POST"><input type="hidden" name="muvelet" value="kirug">
	<table width="85%" align="center" class="frakcio">

		<tr class="cim">
			<td width="25%" class="cim">Név</td>
			<td width="10%" class="cim">Rang</td>
			<td width="20%" class="cim">Utolsó Belépés</td>
			<td width="9%"  class="cim" title="Aktivitás">Akt.</td>
			<td width="14%" class="cim" title="Bankszámlaszám">B.Számla</td>
			<td width="24%" class="cim" title="Felvetel">Tagság</td>
<?			if($frakcio == 9)
				echo "<td width='24%' class='news' title='news'>News</td>";
			if($frakcio == 10)
				echo "<td width='30%' class='news' title='taxi'>Hívás-KM</td>";
?>
			<td width="15%" class="cim">Kirúg</td>
		</tr>
<?
	$sql = mysql_query("SELECT ID, Nev, Leader, Rank, Online, Admin, UtoljaraAktiv, Bankszamla, Felvetel, Skillek, TaxiKm FROM playerek WHERE Leader='".$frakcio."' OR Member='".$frakcio."' ORDER BY Rank DESC, Nev ASC");
	$darab = 0;
	$ma = date("Y-m-d");
	$tegnap = date("Y-m-d", time()-86400);
	$tegnapelott = date("Y-m-d", time()-172800);
	$unix = time();
	while($player = mysql_fetch_array($sql))
	{
		if($player["ID"] != $jatekos["Karakter"][$kivalasztva]["ID"]) $darab++;
		
		$monthActivity = 0;
		if($player['UtoljaraAktiv'] >= (time() - 86400 * 30))
		{
			$mysql -> query('SELECT Month FROM ig_activity_index WHERE UID="'.$player['ID'].'"');
			if($mysql -> num())
			{
				$data = $mysql -> assoc();
				$monthActivity = $data['Month'];
			}
		}
		
		echo'<tr class="noborder '.($monthActivity >= (30 * 3600 * 7) ? 'uberActive' : ($monthActivity >= (30 * 3600 * 5) ? 'hyperActive' : '')).'">
		
			<td>'.$player["Nev"].'</td>
			<td>'.($player["Leader"] == $frakcio ? "<b>[L]".$player["Rank"]."</b>" : $player["Rank"]).'</td>
			<td>';
			
			if($player["Online"] == "1") echo '<b style="color:cyan">Online</b>';
			else
			{
				if($player["UtoljaraAktiv"] > 0)
				{
					$uo = date("Y-m-d H:i", $player["UtoljaraAktiv"]);
					$uo_e = explode(" ", $uo);
					$color = "#ff1515";
					if(($unix - $player["UtoljaraAktiv"]) < 86400) $color = "#0cf800";
					elseif(($unix - $player["UtoljaraAktiv"]) < 172800) $color = "#fff208";
					elseif(($unix - $player["UtoljaraAktiv"]) < 604800) $color = "#f86f00";

					if($uo_e[0] == $ma)
						echo "<b style='color:$color'>Ma ".$uo_e[1]."</b>";
					elseif($uo_e[0] == $tegnap)
						echo "<b style='color:$color'>Tegnap ".$uo_e[1]."</b>";
					elseif($uo_e[0] == $tegnapelott)
						echo "<b style='color:$color'>Tegnap előtt ".$uo_e[1]."</b>";
					else
						echo "<b style='color:$color'>".$uo."</b>";
				}
				else
					echo "<i>Még nem lépett be</i>";
					//echo "<i>~2010-08-19 17:00 előtt</i>";
			}

			echo'</td>
			<td> ';

			echo $_stat -> ActivityIndex($player["ID"], $player["UtoljaraAktiv"]);

			echo'</td>
			<td> ';

			$bsz = explode(",", $player["Bankszamla"]);
			if($bsz[0] == "1") echo $bsz[1];
			else echo "---";

			echo'</td>
			<td> ';
			
			$felvetel = $player["Felvetel"];
			
			if( $felvetel != 0) $felvetel = date("Y-m-d H:i",$felvetel);
			else $felvetel = "2013-05-22 előtt!";	
			echo $felvetel;
			echo'</td>
			<td> ';
			if($frakcio == 9)
			{
				$player["Skillek"] = explode(",", $player["Skillek"]);
				echo' 
				'.$player["Skillek"][7].'
				</td>
				<td> ';
			}
			if($frakcio == 10)
			{
				$player["TaxiKm"] = explode(",", $player["TaxiKm"]);
				echo' 
				'.$player["TaxiKm"][0].' - '.round($player["TaxiKm"][1]/1000,2).'
				</td>
				<td> ';
			
			}
			if($jatekos["Karakter"][$kivalasztva]["Leader"])
			{
			echo($player["Online"] == 0 && $player["ID"] != $jatekos["Karakter"][$kivalasztva]["ID"] && $player["Leader"] != $frakcio ||
				 $player["Online"] == 0 && $player["ID"] != $jatekos["Karakter"][$kivalasztva]["ID"] && $player["Leader"] == $frakcio && $jatekos["Admin"] > $player["Admin"] ? '<label for="'.$player["ID"].'_id"><center><input type="checkbox" name="nevek[]" id="'.$player["ID"].'_id" value="'.$player["ID"].'"></center></label>' : '');
			}
		echo'</td></tr>';
	}
	mysql_free_result($sql);
	if($darab > 0 && $jatekos["Karakter"][$kivalasztva]["Leader"] == $frakcio)
	{
		if($frakcio == 10 || $frakcio == 9)
		{
			echo'
				<tr class="clear">
					<td colspan="7" style="border: 0px"></td><td style="border: 0px"><input type="submit" style="padding:1px" value="Kirúg"></td>
				</tr>
			';
		
		}	
		else
		{
			echo'
				<tr class="clear">
					<td colspan="6" style="border: 0px"></td><td style="border: 0px"><input type="submit" style="padding:1px" value="Kirúg"></td>
				</tr>
			';
		}
	}
	
	
	
	
?>

	</table></form>

</center>
<?
//széf log 
	if($jatekos["Karakter"][$kivalasztva]["Leader"] == $frakcio)
	{
		?>
			<center><h1>SZÉF LOG</h1></center>

			<center><table width='100%' align='center'><tr><td width='100%'>
			
		<?
			
			echo '<a href="#lent">Le</a> ' . SelectKiiras();
		?>
			
			<input type="button" onclick="Kereses(1)" value="Megnéz" style="padding:0px">
		
			<div id='statusz' style='font-size:10px'></div><br>
				
			
		
			</td></tr></table><a href="#fent">Fel</a>

			</center>
		<?
	
	
	}

?>

<? Lablec(); ?>