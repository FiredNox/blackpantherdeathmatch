<?
require_once("include/main.php");
require_once("include/statinfo.php");

if(!$jatekos["Belepve"])
{
	Fejlec();
	echo Felhivas("Nem vagy belépve");
	Lablec();
	exit;
}

if($jatekos["Kivalasztva"] == 0) Hiba("Nincs karakter kiválasztva - Ezt a \"Karakter\" menüpontban teheted meg", true);

require_once($config["Path"]["class"] . "/aktivitas.class.php");

if(isset($_GET["ajax"]) && isset($_POST["id"]) && is_numeric($_POST["id"]))
{
	$id = $_POST["id"];
	if(isset($_GET["graf"]))
	{
		$_stat->Check($id, STAT_ACTIVITY);
		$_stat->Check($id, STAT_MUNKA);
		AjaxExit();
	}
	if(isset($id))
	{
		$sql = mysql_query("SELECT ID, Nev, Origin, Age, Sex, Married, MarriedTo, Job1, Job2, Member, ConnectedTime, Respect, Szint, Money, Bank, Bankszamla FROM playerek WHERE id='".$id."'");
		if(mysql_num_rows($sql) == 1)
		{
			$p = mysql_fetch_array($sql);

			$sql_x = mysql_query("SELECT ID, Tipus FROM hazak WHERE Eladva = '1' and TulajID = '".$p["ID"]."' ORDER BY ID ASC");
			$hazak = mysql_num_rows($sql_x);
			
			$db = 1; $haz = array();
			if($hazak) while($sqld = mysql_fetch_array($sql_x)) {
				$haz[$db] = $sqld;
				$db++;
			}
			
			mysql_free_result($sql_x);

			$sql_x = mysql_query("SELECT ID, Model FROM kocsik WHERE Eladva = '1' and TulajID = '".$p["ID"]."' ORDER BY ID ASC");
			$kocsik = mysql_num_rows($sql_x);
			
			$db = 1; $kocsi = array();
			if($kocsik) while($sqld = mysql_fetch_array($sql_x)) {
				$kocsi[$db] = $sqld;
				$db++;
			}
			
			mysql_free_result($sql_x);

			$sql_x = mysql_query("SELECT Nev FROM bizek WHERE Eladva = '1' and TulajID = '".$p["ID"]."' ORDER BY ID ASC");
			$bizek = mysql_num_rows($sql_x);
			
			$db = 1; $biz = array();
			if($bizek) while($sqld = mysql_fetch_array($sql_x)) {
				$biz[$db] = $sqld;
				$db++;
			}
			
			mysql_free_result($sql_x);

			$hazinfo = ""; $db = -1;
			
			if($hazak == 0)
				$hazinfo = "<i>Nincs</i>";
			else while(++$db < $hazak) {
				$hazinfo .= ($db ? "<br>" : "") . "Class u. ".$haz[$db+1]["ID"] . "(".$haztipus[$haz[$db+1]["Tipus"]].")";
			}

			$kocsiinfo = ""; $db = -1;
			
			if($kocsik == 0)
				$kocsiinfo = "<i>Nincs</i>";
			else while(++$db < $kocsik) {
				$kocsiinfo .= ($db ? "<br>" : "") . $model[$kocsi[$db+1]["Model"]] . "(" . $kocsi[$db+1]["ID"] . ")";
			}

			$bizinfo = ""; $db = -1;
			
			if($bizek == 0)
				$bizinfo = "<i>Nincs</i>";
			else while(++$db < $bizek) {
				$bizinfo .= ($db ? "<br>" : "") . BizNev($biz[$db+1]["Nev"]);
			}

			$bankinfo = explode(",", $p["Bankszamla"]);

			$adatok = Array(
				"1" => Array(
                    Array("a" => "UID", "b" => $p["ID"]),
					Array("a" => "Név (<a href='nevvaltasok".$config["Ext"]."?m=e&e=".$p["ID"]."' target='_BLANK'>többi</a>)", "b" => $p["Nev"]),
					Array("a" => "Nem", "b" => ($p["Sex"] == "1" ? "Fiú" : "Lány")),
					Array("a" => "Kor", "b" => $p["Age"]),
					Array("a" => "Származás", "b" => ($p["Origin"] == "1" ? "USA" : ($p["Origin"] == "2" ? "Európa" : "Ázsia"))),
					Array("a" => "Házastárs", "b" => ($p["Married"] == "1" ? $p["MarriedTo"] : "-")),
					Array("a" => "Aktivitás", "b" => "<a href='javascript: void(0);' onclick='Grafikon(\"".$p["ID"]."\")'>Grafikon</a>"),
				),
				"2" => Array(
					Array("a" => "Főmunka", "b" => ($p["Job1"] == "0" ? "<i>Nincs</i>" : $munkak[$p["Job1"]])),
					Array("a" => "Másodmunka", "b" => ($p["Job2"] == "0" ? "<i>Nincs</i>" : $munkak[$p["Job2"]])),
					Array("a" => "Szervezet", "b" => ($p["Member"] == "-1" ? "<i>Nincs</i>" : FrakcioNeve($p["Member"]))),
					Array("a" => "<br>", "b" => ""),
					Array("a" => "KP", "b" => ($p["Money"] == "0" ? "<i>Nincs</i>" : number_format($p["Money"], 0, ',', ',')."Ft")),
					Array("a" => "Bankszámla", "b" => ($bankinfo[0] == "0" ? "<i>Nincs</i>" : "Van: ".$bankinfo[1])),
					Array("a" => "Bank", "b" => ($p["Bank"] == "0" ? "<i>Nincs</i>" : number_format($p["Bank"], 0, ',', ',')."Ft")),
				),
				"3" => Array(
					Array("a" => "J. órák", "b" => $p["ConnectedTime"]." óra"),
					Array("a" => "Szint ".($p["Szint"]+1), "b" => "Még ".(($p["Szint"]+1) * 4 - $p["Respect"])." óra"),
					Array("a" => "<br>", "b" => ""),
					Array("a" => "Ház", "b" => $hazinfo),
					Array("a" => "Jármű", "b" => $kocsiinfo),
					Array("a" => "Biznisz", "b" => $bizinfo),
				),
			);
	?>
	<hr><center><table width="95%" align=center class="informaciok">
	<tr>
		<td width="30%" class="cim">Személyes információk</td>
			<td width="3%" class="clear"></td>
		<td width="30%" class="cim">Munka & Vagyon</td>
			<td width="3%" class="clear"></td>
		<td width="30%" class="cim">Egyéb</td>
	</tr>

	<tr><td>

		<table width="100%" class='informaciok_info'><tr><td width="40%"></td><td></td></tr>
		<?
			foreach($adatok["1"] as $adat)
				echo "<tr><td><b>".$adat["a"]."</b></td><td>".$adat["b"]."</td></tr>";
		?>
		</table>

	</td><td></td><td>

		<table width="100%" class='informaciok_info'><tr><td width="50%"></td><td></td></tr>
		<?
			foreach($adatok["2"] as $adat)
				echo "<tr><td><b>".$adat["a"]."</b></td><td>".$adat["b"]."</td></tr>";
		?>
		</table>

	</td><td></td><td>

		<table width="100%" class='informaciok_info'><tr><td width="35%"></td><td></td></tr>
		<?
			foreach($adatok["3"] as $adat)
				echo "<tr><td><b>".$adat["a"]."</b></td><td>".$adat["b"]."</td></tr>";
		?>
		</table>

	</td></tr>

	</table></center><br><hr>
	<?
		}
		mysql_free_result($sql);
	}
	Lablec(false);
	exit;
}

//start
Fejlec("dygraph");

$extra = array();
$nevek_arr = Array("keres", "admin", "adminjail", "banned", "r", "s");
for($x = 0; $x < count($nevek_arr); $x++)
{
	if(isset($_GET[$nevek_arr[$x]]))
		$extra[] = $nevek_arr[$x]."=".$_GET[$nevek_arr[$x]];
}
$extralinkhez = implode("&", $extra); unset($extra);

if(isset($_GET["o"]))
	$extralinkhezo = "o=".$_GET["o"].($extralinkhez != "" ? "&".$extralinkhez : "");
else
	$extralinkhezo = $extralinkhez;

if(isset($_GET["keres"]))
	$keres = $_GET["keres"];

$from = "FROM playerek";
$orderby = "ORDER BY nev";

if(isset($_GET["r"]))
{
	if($_GET["r"] == "lvl") $orderby = "ORDER BY Szint";
	else if($_GET["r"] == "online") $orderby = "ORDER BY Online Desc, UtoljaraAktiv";
}

if(isset($_GET["s"]) && $_GET["s"] == "cs")
	$orderby .= " DESC";
else
	$orderby .= " ASC";

if(isset($_GET["keres"]))
{
	$where_array = Array();
	$admin = $_GET["admin"];
	$adminjail = $_GET["adminjail"];
	$banned = $_GET["banned"];
	//$adminseged = $_GET["as"];
	//if($admin == "-1") unset($admin);

	if($admin == "0") $where_array[] = "admin='0'";
	elseif($admin == "1") $where_array[] = "admin>='1'";
	elseif($admin == "2") $where_array[] = "(ASJog='-1' OR ASJog>".time().")";

	if($adminjail == "1") $where_array[] = "(jailed='3' OR jailed='6' OR jailed='8')";
	if($banned == "1") $where_array[] = "nev = cim";
//	if($adminseged == "1") $where_array[] = "ASJog='-1' OR ASJog>UNIX_TIMESTAMP()";

	$_GET["keres"] = SzokozKereses($_GET["keres"]);
	
	if(!SzovegAnalizalas($_GET["keres"], "._"))
		$uzenet = "Hibás karakterek a szövegben!";
	elseif(strlen($_GET["keres"]) > 0 && strlen($_GET["keres"]) < 3 || strlen($_GET["keres"]) > 20)
		$uzenet = "Minimum 3, maximum 20 karakter!";
	elseif(strlen($_GET["keres"]) >= 3)
	{
		$keres = $_GET["keres"];
		$where_array[] = "nev LIKE '%".$keres."%'";
	}

	if($banned == "1")
		$from = "FROM playerek, bans";

	if(count($where_array) > 0)
		$where = "WHERE ". implode(" AND ", $where_array);
}

if(!isset($where) || strlen($where) == 0) $where = "WHERE Clint!='1'";


?>

<style type="text/css">
	.informaciok .cim
	{
		font-weight: bold;
		padding: 5px;
		font-size: 110%;
		vertical-align: top;
	}
	.informaciok_info tr td
	{
		text-align: left;
		vertical-align: top;
	}
	.informaciok, .informaciok td
	{
		border: none;
	}
	table{
		border-spacing:0px; }
	td.clear, .cleartr td, .cleartable tr td{
		border: none; }
	.adatok{
		padding: 5px; }
	.adatok hr{
		color:grey; }
	.left{
		text-align: left; }
	img.link{
		cursor: crosshair; }
	img.link:hover{
		cursor: pointer; }
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
		padding: 5px;
		border: none;
	}
	td
	{
		/*border: 2px outset #444;*/
		padding: 5px;
		vertical-align: middle;
		text-align:center;
		/*background-color: #202020;*/
	}
	.cleartr_jatekos td
	{
		border-top: none;
		border-left: none;
		border-right: none;
		border-bottom: none;
		padding: 0px;
	}
	.cim
	{
		color:white;
		font-weight:bold;
	}
	a.no
	{
		text-decoration:none;
		font-weight:bold;
	}

	.buntetes{
		font-weight: bold;
	}
</style>

<script type="text/javascript" src="include/dygraph-see.js"></script>
<script type="text/javascript">

	var kereses = false;
	var ajaxtoltes = false;
	var grafInited = false;
	
	function nyit(mit)
	{
		if(mit == "kereses")
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
	}
	function jatekos(id)
	{
		var div = document.getElementById("jatekos_"+id);
		if(div.style.display == "none")
		{
			if(ajaxtoltes)
				return 1;
			ajaxtoltes = true;
			//div.style.display = "block";
			$("#jatekos_"+id).html("<img src='img/ajax-loader.gif'>");
			$("#jatekos_"+id).slideToggle(1000);

			$.ajax({
				type: "POST",
				url: "?ajax",
				data: "id="+id,
				success: function(msg){
					$("#jatekos_"+id).html(msg);
					//div.style.display = "none";
					//$("#jatekos_"+id).slideToggle(1000);
					ajaxtoltes = false;
				}
			});
		}
		else
		{
			$("#jatekos_"+id).slideToggle(1000, function() { $("#jatekos_"+id).html(''); });
		}
	}

	function Grafikon(id)
	{
		if(ajaxtoltes) return 1;
		ajaxtoltes = 1;

		$("#act-dialog-load").css("display", "block");

		$(function() {
			$( "#act-dialog" ).dialog({
				resizable: false,
				height: 500,
				width: 710,
				modal: false,
				title: "Aktivitás",
				show: "fade",
				hide: "fade",
				position: ["top", 100],
				buttons: {
					"Bezár": function() {
						if(!ajaxtoltes) $( this ).dialog( "close" );
					}
				}
			});
		});

		$.ajax({
			type: "POST",
			url: "?ajax&graf",
			data: "id="+id,
			success: function(data){
				ajaxtoltes = 0;

				$("#act-dialog-load").css("display", "none");

				if(!grafInited)
				{
					grafInited = true;
					seeDygraphInit(id);
				}
				else
					seeDygraphChange(id);
			}
		});
	}
	$(function(){
		$("#radio").buttonset();
	});
</script>

<? if(isset($uzenet)) echo Felhivas($uzenet); ?>

<div id="act-dialog" title="Aktivitás" style="display: none;">
		<div id='radio'>
			<input type='radio' id='radio1' name='m' value='o' onclick="Valt('o')" checked><label for='radio1'>Aktivitás</label>
			<input type='radio' id='radio2' name='m' value='a' onclick="Valt('a')"><label for='radio2'>Admin</label>
		</div>

		<br><br>

		<div id="grafikon" style="border: 1px solid white;"></div>
		<p id='act-dialog-load'><i>Grafikon betöltése folyamatban...</i></p>
</div>

<center><h1>Játékosok</h1>

<span class="kez" onclick="nyit('kereses')"><img src="img/<?=(isset($keres) ? "minus" : "plus")?>.gif" id="kereses_img"> Keresés</span>

<div id="kereses_div" style="display:<?=(isset($keres) ? "block" : "none")?>">
	<form method="GET">
		<select name="admin" style="font-size:10px; text-align:center">
			<option value="-1">Játékosok & Adminok</option>
			<option value="0" <?=(isset($admin) && $admin == '0' ? "selected" : "")?>>Játékosok</option>
			<option value="1" <?=(isset($admin) && $admin == '1' ? "selected" : "")?>>Adminok</option>
			<option value="2" <?=(isset($admin) && $admin == '2' ? "selected" : "")?>>Adminsegédek</option>
		</select>
		<input type="text" name="keres" id="keres" <?=(isset($keres) ? "value='".$keres."'" : "")?>> <input type="submit" value="Keresés" style="padding:1px"><br>

		<!--<input type="checkbox" name="hitman" value="1" <?=(isset($adminseged) && $adminseged == '1' ? "checked" : "")?>> <b style="color:yellow">Adminsegéd</b>-->
		<input type="checkbox" name="adminjail" value="1" <?=(isset($adminjail) && $adminjail == '1' ? "checked" : "")?>> <b style="color:orange">Admin Börtön</b>
		<input type="checkbox" name="banned" value="1"" <?=(isset($banned) && $banned == '1' ? "checked" : "")?>> <b style="color:#FF3333">Kitiltva</b>

	</form>
</div>

<br><br>

<?
	$sql = mysql_query("SELECT Nev $from ".(isset($where) ? $where : ""));
	$num = mysql_num_rows($sql); mysql_free_result($sql);

	$sql_o = mysql_query("SELECT Nev $from ".(isset($where) ? $where . " AND Online='1'" : "WHERE Online='1'"));
	$num_o = mysql_num_rows($sql_o); mysql_free_result($sql_o);

	$peroldal = 30; // Bejegyzés per olda
	$latni = 2; // A jelenlegi oldal körül hányat mutasson
	$elsok = 3; // Az első és utolsó oldalak közül hányat mutasson

	$oldalak = ceil($num / $peroldal);
	if(isset($_GET["o"])) $p = $_GET["o"];
	if(!isset($p) || $p < 1 || $p > $oldalak) $p = 1;

	$extra = $extralinkhez;

	$pontok = Array(1 => false, 2 => false);

	for($x = 1; $x <= $oldalak; $x++)
	{
		if($x == 1) $szoveg = "Első";
		else if($x == $oldalak) $szoveg = "Utolsó";
		else $szoveg = $x;

		if($x <= $elsok || $x > ($oldalak - $elsok) || $x >= ($p - $latni) && $x <= ($p + $latni))
		{
			if($x != $p)
				$kiirat = " <a href='?o=".$x."&".$extra."'>".$szoveg."</a>";
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
		echo "<a href='?o=".($p-1)."&".$extra."'><< Előző</a>";
	else
		echo "<a class='no'><< Előző</a>";
	echo " - ";
	if($p < $oldalak)
		echo "<a href='?o=".($p+1)."&".$extra."'>Következő >></a>";
	else
		echo "<a class='no'>Következő >></a>";

	$limit = Array("min" => (($p-1)*$peroldal),
				   "max" => $peroldal);

	echo "<br><br>";
	echo "Találatok: ".$num."db, ebből online: ".$num_o."db<br><br>";

?>

<table width="100%" align=center>
	<tr>
	<?
		$extrainfo = ($extralinkhezo != "" ? $extralinkhezo."&" : "");

		if(!isset($_GET["s"])) $nevlink = "?".$extrainfo."s=cs";
		else if($extralinkhezo != "") $nevlink = "?".$extralinkhezo;
		else $nevlink = "jatekosok".$config["Ext"];

		if(!isset($_GET["r"]) || $_GET["r"] != "lvl") $szintlink = "?".$extrainfo."r=lvl";
		else if(!isset($_GET["s"])) $szintlink = "?".$extrainfo."r=lvl&s=cs";
		else if(isset($_GET["s"])) $szintlink = "?".$extrainfo."r=lvl";

		if(!isset($_GET["r"]) || $_GET["r"] != "online") $onlinelink = "?".$extrainfo."r=online";
		else if(!isset($_GET["s"])) $onlinelink = "?".$extrainfo."r=online&s=cs";
		else if(isset($_GET["s"])) $onlinelink = "?".$extrainfo."r=online";

		echo'
		<td width="25%" class="cim"><a href="'.$nevlink.'">Név</a></td>
		<td width="20%" class="cim">Felhasználó</td>
		<td width="10%" class="cim"><a href="'.$szintlink.'">Szint<a></td>
		<td width="20%" class="cim">Frakció</td>
		<td width="25%" class="cim"><a href="'.$onlinelink.'">Utolsó belépés<a></td>
		';
	?>
	</tr>
<?
	$tegnapelott = date("Y-m-d", time()-172800);
	$tegnap = date("Y-m-d", time()-86400);
	$ma = date("Y-m-d");

	$sql = mysql_query("SELECT playerek.ID, Nev, Member, Szint, Member, UtoljaraAktiv, Online, Admin, ASJog, Jailed, JailTime, JailOK $from ".(isset($where) ? $where : "")." $orderby LIMIT ".$limit["min"].",".$limit["max"]);
	if(mysql_num_rows($sql) == 0)
		echo "<tr><td colspan='5' class='clear'>Nincs találat</td></tr>";
	while($player = mysql_fetch_array($sql))
	{
		$a_sql = mysql_query("SELECT Nev FROM accountok WHERE Karakter1='".$player["ID"]."' OR Karakter2='".$player["ID"]."'");
		if(mysql_num_rows($a_sql) == 0) $acc = "---";
		else
		{
			$d = mysql_fetch_array($a_sql);
			$acc = $d["Nev"];
			unset($d);
		} mysql_free_result($a_sql);

		$buntetes = "";
		if($player["Jailed"] == '3' || $player["Jailed"] == '6' || $player["Jailed"] == '8')
		{
			if($player["Jailed"] == '3') $buntetes = "<img src='img/adminjail.png' class='buntetes' style='color: yellow' title='<b>".("AdminJail")."</b><br><b>Idő:</b> ".round($player["JailTime"] / 60)."perc<br><b>Oka:</b> ".($player["JailOK"] == "" || $player["JailOK"] == "Nincs megadva" ? "<i>Ismeretlen</i>" : $player["JailOK"])."'>";
			if($player["Jailed"] == '6') $buntetes = "<img src='img/maganzarka.png' class='buntetes' style='color: yellow' title='<b>".("Magánzárka")."</b><br><b>Idő:</b> ".round($player["JailTime"] / 60)."perc<br><b>Oka:</b> ".($player["JailOK"] == "" || $player["JailOK"] == "Nincs megadva" ? "<i>Ismeretlen</i>" : $player["JailOK"])."'>";
			if($player["Jailed"] == '8') $buntetes = "<img src='img/extrazarka.png' class='buntetes' style='color: yellow' title='<b>".("Extra Magánzárka")."</b><br><b>Idő:</b> ".round($player["JailTime"] / 60)."perc<br><b>Oka:</b> ".($player["JailOK"] == "" || $player["JailOK"] == "Nincs megadva" ? "<i>Ismeretlen</i>" : $player["JailOK"])."'>";

		}

		$asjog = "";
		if($player["ASJog"] == -1 || $player["ASJog"] > time())
			$asjog = "<b style='color: ".($player["ASJog"] == -1 ? "#5f5" : "yellow")."' title='Adminsegéd".($player["ASJog"] == -1 ? "" : " (".DatumFormat($player["ASJog"])."-ig)")."'>AS</b>";

		$a_ban = mysql_query("SELECT Ido, Orok, Bannolta, Oka, Datum FROM bans WHERE Cim='".$player["Nev"]."'");
		if(mysql_num_rows($a_ban) > 0)
		{
			$ban = mysql_fetch_array($a_ban);
			$buntetes .= " <img src='img/banned.png' class='buntetes' title='<b>Dátum:</b> ".DatumFormat(date("Y-m-d H:i:s", $ban["Datum"]))."<br><b>Bannolta:</b> ".$ban["Bannolta"]."<br><b>Lejár:</b> ".($ban["Orok"] == "i" ? "Soha (Örök ban)" : DatumFormat(date("Y-m-d", $ban["Ido"])))."<br><b>Oka:</b> ".$ban["Oka"]."' style='color: red'>";
		}
		mysql_free_result($a_ban);

		if($player["Admin"] >= 1 && $jatekos["Admin"] >= 1337)
		{
			/*if($player["Admin"] < 1337)
				$szint = ' ['.$player["Admin"].']';
			else
				$szint = '';*/
			
			$szint_title = ' title="Adminszint: ' . $player['Admin'] . '"';
		}
		else
		{
			$szint = "";
			$szint_title = "";
		}

		//szinek
			$szinezes = "";
		
		// speciális
	
		if ($player['ID'] == 	8181898) // Marci
			$szinezes = ' style="color: white"';
		else if($player['ID'] == 234) // terno
			$szinezes = ' style="color: #FF4500"';
		else if($player['ID'] == 8183364) // Krisztofer
			$szinezes = ' style="color: #4682B4"';
		else if($player['ID'] == 2326) // Amos
			$szinezes = ' style="color: #BDB76B"';//Scripter: #BDB76B Admin & Scripter: #4682B4
		else if($player['ID'] == 5637) // Dolph
			$szinezes = ' style="color: red"';
		else if($player['ID'] == 4038) // FFG
			$szinezes = ' style="color: red"';

		// rangok
		else if($player["Admin"] > 0 && $player["Admin"] < 6)
			$szinezes = " style='color: #00cc00'";
		else if($player["Admin"] == 6)
			$szinezes = " style='color: #22D694'";
		else if($player['Admin'] == 1338)
			$szinezes = ' style="color: yellow"';
		else if($player["Admin"] >= 1337 && $player["Admin"] <= 1338)
			$szinezes = " style='color:lightblue'";
		else if($player["Admin"] == 1339)
			$szinezes = " style='color:#ff5555'";
		else if($player["Admin"] == 1340)
			$szinezes = " style='color:orange'";
 		else if($player["Admin"] == 1350)	
			$szinezes = " style='color: BurlyWood'";
	
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

		echo "	<tr class='cleartr ".($monthActivity >= (30 * 3600 * 7) ? 'uberActive' : ($monthActivity >= (30 * 3600 * 5) ? 'hyperActive' : ''))."'>
					<td><span class='kez' onClick='jatekos(\"".$player["ID"]."\")'><b" . $szinezes . $szint_title . ">".$player["Nev"].(isset($szint) ? $szint : "")."</b></span> $buntetes$asjog</td>
					<td>".$acc."</td>
					<td>".$player["Szint"]."</td>
					<td>".($player["Member"] == "0" ? "<i>---</i>" : "<b>".FrakcioNeve($player["Member"])."</b>")."</td>
					<td>";
					if($player["Online"] == "1") echo "<b style='color:white'>Online</b>";
					elseif($player["UtoljaraAktiv"] == 0) echo "<i>-</i>";
					else
					{
						$dat = date("Y-m-d H:i", $player["UtoljaraAktiv"]);
						$dat_e = explode(" ", $dat);
						if($dat_e[0] == $tegnapelott) echo "Tegnap előtt ".$dat_e[1];
						elseif($dat_e[0] == $tegnap) echo "Tegnap ".$dat_e[1];
						elseif($dat_e[0] == $ma) echo "Ma ".$dat_e[1];
						else echo $dat;
					}

					if($player["UtoljaraAktiv"] >= (time() - 86400 * 30))
						echo " (". $_stat -> ActivityIndex($player["ID"]).")";
					//else
					//	echo " (". implode(" / ", $_stat -> ActivityIndex(0)) .")";

		echo"		</td>
				</tr>";
		echo"
		<tr class='cleartr_jatekos'>
			<td colspan='5'>
				<div class='adatok' style='display:none' id='jatekos_".$player["ID"]."'></div>
			</td>
		</tr>";
	}
	mysql_free_result($sql);
?>
</table></center>

<? Lablec(); ?>