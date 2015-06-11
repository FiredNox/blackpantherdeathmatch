<?
require_once("include/main.php");
require_once("include/statinfo.php");

if(isset($_POST["alp"]) && isset($_POST["rleiras"])  && isset($_POST["leiras"]) &&  isset($_POST["id"]))
{
	$datum=time();
	$sqlt = mysql_query("UPDATE `parancsok` SET `alp`='".$_POST["alp"]."',`leiras`='".$_POST["leiras"]."', `modosito`='".$jatekos["LogNev"]."', `mdatum`='".$datum."', `rleiras`='".$_POST["rleiras"]."' WHERE id = '".$_POST["id"]."'");



	

}

if(isset($_GET["ajax"]) && isset($_POST["id"]))
{
	$id = $_POST["id"];
	

	if(isset($id))
	{
		$sql = mysql_query("SELECT * FROM parancsok WHERE id = '".$id."'");	

		
		if(mysql_num_rows($sql) == 1)
		{
			$p = mysql_fetch_array($sql);
			$parancs = $p["parancsok"];
			$alp = $p["alp"];
			$rleiras = $p["rleiras"];
			$leiras = $p["leiras"];
			$id = $p["id"];
			
			
			$adatok = Array(
				"1" => Array(
					Array("a" => "Beküldte", "b" => $p["keszito"]),
					Array("a" => "Dátum", "b" => date("Y-m-d H:i:s", $p[datum])),
					Array("a" => "Utolsó módósító", "b" => $p["modosito"]),
					Array("a" => "Dátum", "b" => date("Y-m-d H:i:s", $p[mdatum])),
					
				),
				"2" => Array(
					Array("a" => "Alparancsai", "b" => $p["alp"]),
				),
				"3" => Array(
					Array("a" => "Teljes leírás", "b" => $p["leiras"]),
					
				),
			);
	?>
	<hr><center><table width="95%" align=center class="informaciok">
	<tr>
		<td width="30%" class="cim">Szerkesztői adatok</td>
			<td width="3%" class="clear"></td>
		<td width="30%" class="cim">Alparancsok</td>
			<td width="3%" class="clear"></td>
		<td width="30%" class="cim">Leírás</td>
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
				echo "<tr><td> </td><td>".$adat["b"]."</td></tr>";
		?>
		</table>

	</td><td></td><td>

		<table width="100%" class='informaciok_info'><tr><td width="35%"></td><td></td></tr>
		<?
			foreach($adatok["3"] as $adat)
				echo "<tr><td> </td><td>".$adat["b"]."</td></tr>";
		?>
		</table>

	</td></tr>

	</table>
	
	
	<? 
	
	if( $jatekos["Admin"] >= 1)
		{
		
		?>
		<a href="#" data-reveal-id="modalisAblak">A parancs szerkesztése</a><br>
		<hr>
			<div id="modalisAblak" class="reveal-modal">
		
			  <h2 style="color: maroon">A " <? echo $parancs ?>" bejegyzés szerkesztése!!!</h2>
			  <p style="color: slateblue">
			  <form method="POST">
				  <table id="felvitel" width='500' height='10' border='5'  border-spacing="5" cellspacing="10" align='center'>
				  <tr>
					<th scope="col">Megnvezés</th>
					<th scope="col">Bevitel</th>
				  </tr>
				   <tr>
						<td>
							Alparancsai:
						</td>
						<td>
							<input type="hidden" name="id" value="<? echo $id ?>">
							<textarea name='alp' id='leiras' cols='45' rows='5'><? echo $alp ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							Rövid leírása:
						</td>
						<td>
							<input type='text' name='rleiras' value = "<? echo $rleiras ?>">
						</td>
					</tr>	
					<tr>
						<td>
							Teljes leírása:
						</td>
						<td>
							<textarea name='leiras' id='leiras' cols='45' rows='5'><? echo $leiras ?></textarea>
							
						</td>
					</tr>	
					</table>
				<center><input type="submit" value="Beküldés" style="padding:1px"></center>
				</form>
			  </p>
			  <a class="close-reveal-modal">x</a>
			</div>
		<?
		}
		else
			echo "<hr>"
		?>
	
	</center><br><br>
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




$from = "FROM parancsok";
$orderby = "ORDER BY datum";


if(isset($_GET["s"]) && $_GET["s"] == "cs")
	$orderby .= " DESC";
else
	$orderby .= " ASC";



if(isset($_GET["keres"]))
{
	$where = "";
	

	if(strlen($_GET["keres"]) > 0 && strlen($_GET["keres"]) < 2 || strlen($_GET["keres"]) > 20)
		$uzenet = "Minimum 2, maximum 20 karakter!";
	elseif(strlen($_GET["keres"]) >= 3)
	{
		$keres = $_GET["keres"];
		 
		$where = "WHERE parancsok LIKE '%".$keres."%' OR kategoria LIKE '%".$keres."%' OR alp LIKE '%".$keres."%' OR other LIKE '%".$keres."%'";
	}

}



?>
<link rel="stylesheet" type="text/css" href="css/reveal.css" />
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
<script type="text/javascript" src="js/jquery.reveal.js"></script>
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
	function Szerkeszt(id)
	{
		var div = document.getElementById("Szerkeszt"+id);
		if(div.style.display == "none")
		{
			if(ajaxtoltes)
				return 1;
			ajaxtoltes = true;
			//div.style.display = "block";
			$("#Szerkeszt_"+id).html("<img src='img/ajax-loader.gif'>");
			$("#Szerkeszt_"+id).slideToggle(1000);

			$.ajax({
				type: "POST",
				url: "?ajax",
				data: "id="+id,
				success: function(msg){
					$("#Szerkeszt_"+id).html(msg);
					//div.style.display = "none";
					//$("#jatekos_"+id).slideToggle(1000);
					ajaxtoltes = false;
				}
			});
		}
		else
		{
			$("#Szerkeszt_"+id).slideToggle(1000, function() { $("#Szerkeszt_"+id).html(''); });
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

	$(function(){
		$("#radio").buttonset();
	});
	
	
	
	$(document).ready(function(){
	  $('#pelda').click(function(e){
		e.preventDefault();
		$('#modalisAblak').reveal({
		  animation: 'fade',
		  closeonbackgroundclick: false
		});
	  });
	});
	
</script>

<? if(isset($uzenet)) echo Felhivas($uzenet); ?>


<center><h1>Parancs adatbázis V2</h1>

<span class="kez" onclick="nyit('kereses')"><img src="img/<?=(isset($keres) ? "minus" : "plus")?>.gif" id="kereses_img"> Keresés</span>

<div id="kereses_div" style="display:<?=(isset($keres) ? "block" : "none")?>">
	<form method="GET">
		<input type="text" name="keres" id="keres" <?=(isset($keres) ? "value='".$keres."'" : "")?>> <input type="submit" value="Keresés" style="padding:1px"><br>


	</form>
</div>

<br><br>

<?
	$sql = mysql_query("SELECT * $from ".(isset($where) ? $where : ""));
	
	$num = mysql_num_rows($sql); mysql_free_result($sql);


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
	echo "Találatok: ".$num."db,<br><br>";

?>

<table width="100%" align=center>
	<tr>
	<?
		$extrainfo = ($extralinkhezo != "" ? $extralinkhezo."&" : "");

		if(!isset($_GET["s"])) $nevlink = "?".$extrainfo."s=cs";
		else if($extralinkhezo != "") $nevlink = "?".$extralinkhezo;
		else $nevlink = "jatekosok".$config["Ext"];


		echo'
		
		<td width="20%" class="cim"><a href="'.$nevlink.'">Parancs</a></td>
		<td width="20%" class="cim">Rövid leírás</td>
		<td width="20%" class="cim">Módósítva</td>
		';
	?>
	</tr>
<?
	

	$sql = mysql_query("SELECT * $from ".(isset($where) ? $where : "")." $orderby LIMIT ".$limit["min"].",".$limit["max"]);
	
	if(mysql_num_rows($sql) == 0)
		echo "<tr><td colspan='5' class='clear'>Nincs találat</td></tr>";
	while($adat = mysql_fetch_array($sql))
	{
		
	
		$datum = date("Y-m-d H:i", $adat["mdatum"]);
		echo "	<tr class='cleartr_jatekos'>
					<td><span class='kez' onClick='jatekos(\"".$adat["id"]."\")'>".$adat["parancsok"]."</span></td>
					<td>".$adat["rleiras"]."</td>
					<td>".$datum."</td>";
				

		echo"		</td>
				</tr>";
		echo"
		<tr class='cleartr_jatekos'>
			<td colspan='5'>
				<div class='adatok' style='display:none' id='jatekos_".$adat["parancsok"]."'></div>
			</td>
		</tr>";

	echo"
		<tr class='cleartr_jatekos'>
			<td colspan='5'>
				<div class='adatok' style='display:none' id='jatekos_".$adat["id"]."'></div>
			</td>
		</tr>";

	}
	mysql_free_result($sql);
?>
</table></center>

<? Lablec(); ?>