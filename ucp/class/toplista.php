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

$kategoriak = Array(
				"penz_kp" => Array(
					"nev" => "Leggazdagabbak (KP)",
					"select" => Array("nev", "money"),
					"from" => "playerek",
					"orderby" => "money DESC",
					"extra" => "number_format",
					"extra2" => "Ft",
					"meret" => "50%",
					"nevek" => Array("Név", "Pénz"),
				),
				"penz_bank" => Array(
					"nev" => "Leggazdagabbak (Bank)",
					"select" => Array("nev", "bank"),
					"from" => "playerek",
					"orderby" => "bank DESC",
					"extra" => "number_format",
					"extra2" => "Ft",
					"meret" => "50%",
					"nevek" => Array("Név", "Pénz"),
				),
				"penz_sz_kp" => Array(
					"nev" => "Legszegényebbek (KP)",
					"select" => Array("nev", "money"),
					"from" => "playerek",
					"orderby" => "money ASC",
					"extra" => "number_format",
					"extra2" => "Ft",
					"meret" => "50%",
					"nevek" => Array("Név", "Pénz"),
				),
				"penz_sz_bank" => Array(
					"nev" => "Legszegényebbek (Bank)",
					"select" => Array("nev", "bank"),
					"from" => "playerek",
					"orderby" => "bank ASC",
					"extra" => "number_format",
					"extra2" => "Ft",
					"meret" => "50%",
					"nevek" => Array("Név", "Pénz"),
				),
				"aktiv_szint" => Array(
					"nev" => "Legaktívabbak (Szint)",
					"select" => Array("nev", "szint"),
					"from" => "playerek",
					"orderby" => "szint DESC, connectedtime DESC",
					"extra" => "",
					"extra2" => "",
					"meret" => "60%",
					"nevek" => Array("Név", "Szint"),
				),
				"aktiv_jo" => Array(
					"nev" => "Legaktívabbak (Játszott óra)",
					"select" => Array("nev", "connectedtime"),
					"from" => "playerek",
					"orderby" => "connectedtime DESC",
					"extra" => "number_format",
					"extra2" => "",
					"meret" => "60%",
					"nevek" => Array("Név", "J. Óra"),
				),
			);

if(isset($_GET["ajax"]))
{
	$adat = $_POST["adat"]; $darab = $_POST["darab"];
	$kat = explode(",",$adat); $db = count($kat);

	if(!is_numeric($darab)) exit;

	$where = "WHERE Clint!='1'";

	if($db == 1)
	{
		echo "<h3>" . $kategoriak[$adat]["nev"] . "</h3><br>";
		echo "<table width='40%' align='center'>";
		echo "<tr>
				<td class='cim' width='5%'>#</td>
				<td class='cim' width='".$kategoriak[$adat]["meret"]."'>".$kategoriak[$adat]["nevek"][0]."</td>
				<td class='cim'>".$kategoriak[$adat]["nevek"][1]."</td>
			  </tr>";
		$sql = mysql_query("SELECT ".implode(",", $kategoriak[$adat]["select"])." FROM ".$kategoriak[$adat]["from"]." $where ORDER BY ".$kategoriak[$adat]["orderby"]." LIMIT ".$darab);
		$a = 1;
		while($data = mysql_fetch_array($sql))
		{
			$data1 = $data[$kategoriak[$adat]["select"][0]];
			if($kategoriak[$adat]["extra"] == "number_format")
				$data2 = number_format($data[$kategoriak[$adat]["select"][1]], 0, ',', ',').$kategoriak[$adat]["extra2"];
			else $data2 = $data[$kategoriak[$adat]["select"][1]];

			if($jatekos["Karakterek"] > 0 && $jatekos["Karakter"][0]["Nev"] == $data1 || $jatekos["Karakterek"] > 1 && $jatekos["Karakter"][1]["Nev"] == $data1)
				echo "<tr class='kiemelt'><td>".$a."</td><td>".$data1."</td><td>".$data2."</td></tr>";
			else
				echo "<tr><td>".$a."</td><td>".$data1."</td><td>".$data2."</td></tr>";
			$a++;
		}
		echo "</table>";
	}
	elseif($db == 2)
	{
		echo "<table width='80%' align='center'>";
		echo "<tr><td width='48%' class='clear clearbg'>";

		####################[TÁBLA EGY]########################
		echo "<h3>" . $kategoriak[$kat[0]]["nev"] . "</h3><br>";
		echo "<table width='100%' align='center'>";
		echo "<tr>
				<td class='cim' width='5%'>#</td>
				<td class='cim' width='".$kategoriak[$kat[0]]["meret"]."'>".$kategoriak[$kat[0]]["nevek"][0]."</td>
				<td class='cim'>".$kategoriak[$kat[0]]["nevek"][1]."</td>
			  </tr>";
		$sql = mysql_query("SELECT ".implode(",", $kategoriak[$kat[0]]["select"])." FROM ".$kategoriak[$kat[0]]["from"]." $where ORDER BY ".$kategoriak[$kat[0]]["orderby"]." LIMIT ".$darab);
		$a = 1;
		while($data = mysql_fetch_array($sql))
		{
			$data1 = $data[$kategoriak[$kat[0]]["select"][0]];
			if($kategoriak[$kat[0]]["extra"] == "number_format")
				$data2 = number_format($data[$kategoriak[$kat[0]]["select"][1]], 0, ',', ',').$kategoriak[$kat[0]]["extra2"];
			else $data2 = $data[$kategoriak[$kat[0]]["select"][1]];

			if($jatekos["Karakterek"] > 0 && $jatekos["Karakter"][0]["Nev"] == $data1 || $jatekos["Karakterek"] > 1 && $jatekos["Karakter"][1]["Nev"] == $data1)
				echo "<tr class='kiemelt'><td>".$a."</td><td>".$data1."</td><td>".$data2."</td></tr>";
			else
				echo "<tr><td>".$a."</td><td>".$data1."</td><td>".$data2."</td></tr>";
			$a++;
		}

		echo "</table>";
		#########################################################

		echo "</td><td width='2%' class='clear clearbg'></td><td width='48%' class='clear clearbg'>";
		####################[TÁBLA KETTŐ]########################
		echo "<h3>" . $kategoriak[$kat[1]]["nev"] . "</h3><br>";
		echo "<table width='100%' align='center'>";
		echo "<tr>
				<td class='cim' width='5%'>#</td>
				<td class='cim' width='".$kategoriak[$kat[1]]["meret"]."'>".$kategoriak[$kat[1]]["nevek"][0]."</td>
				<td class='cim'>".$kategoriak[$kat[1]]["nevek"][1]."</td>
			  </tr>";
		$sql = mysql_query("SELECT ".implode(",", $kategoriak[$kat[1]]["select"])." FROM ".$kategoriak[$kat[1]]["from"]." $where ORDER BY ".$kategoriak[$kat[1]]["orderby"]." LIMIT ".$darab);
		$a = 1;
		while($data = mysql_fetch_array($sql))
		{
			$data1 = $data[$kategoriak[$kat[1]]["select"][0]];
			if($kategoriak[$kat[1]]["extra"] == "number_format")
				$data2 = number_format($data[$kategoriak[$kat[1]]["select"][1]], 0, ',', ',').$kategoriak[$kat[1]]["extra2"];
			else $data2 = $data[$kategoriak[$kat[1]]["select"][1]];

			if($jatekos["Karakterek"] > 0 && $jatekos["Karakter"][0]["Nev"] == $data1 || $jatekos["Karakterek"] > 1 && $jatekos["Karakter"][1]["Nev"] == $data1)
				echo "<tr class='kiemelt'><td>".$a."</td><td>".$data1."</td><td>".$data2."</td></tr>";
			else
				echo "<tr><td>".$a."</td><td>".$data1."</td><td>".$data2."</td></tr>";
			$a++;
		}

		echo "</table>";
		#########################################################
		echo"</td></tr>";

		echo "</table>";
	}

	elseif($db == 3)
	{
		echo "<table width='95%' align='center'>";
		echo "<tr><td width='32%' class='clear clearbg'>";

		####################[TÁBLA EGY]########################
		echo "<h3>" . $kategoriak[$kat[0]]["nev"] . "</h3><br>";
		echo "<table width='100%' align='center'>";
		echo "<tr>
				<td class='cim' width='5%'>#</td>
				<td class='cim' width='".$kategoriak[$kat[0]]["meret"]."'>".$kategoriak[$kat[0]]["nevek"][0]."</td>
				<td class='cim'>".$kategoriak[$kat[0]]["nevek"][1]."</td>
			  </tr>";
		$sql = mysql_query("SELECT ".implode(",", $kategoriak[$kat[0]]["select"])." FROM ".$kategoriak[$kat[0]]["from"]." $where ORDER BY ".$kategoriak[$kat[0]]["orderby"]." LIMIT ".$darab);
		$a = 1;
		while($data = mysql_fetch_array($sql))
		{
			$data1 = $data[$kategoriak[$kat[0]]["select"][0]];
			if($kategoriak[$kat[0]]["extra"] == "number_format")
				$data2 = number_format($data[$kategoriak[$kat[0]]["select"][1]], 0, ',', ',').$kategoriak[$kat[0]]["extra2"];
			else $data2 = $data[$kategoriak[$kat[0]]["select"][1]];

			if($jatekos["Karakterek"] > 0 && $jatekos["Karakter"][0]["Nev"] == $data1 || $jatekos["Karakterek"] > 1 && $jatekos["Karakter"][1]["Nev"] == $data1)
				echo "<tr class='kiemelt'><td>".$a."</td><td>".$data1."</td><td>".$data2."</td></tr>";
			else
				echo "<tr><td>".$a."</td><td>".$data1."</td><td>".$data2."</td></tr>";
			$a++;
		}

		echo "</table>";
		#########################################################

		echo "</td><td width='2%' class='clear clearbg'></td><td width='32%' class='clear clearbg'>";
		####################[TÁBLA KETTŐ]########################
		echo "<h3>" . $kategoriak[$kat[1]]["nev"] . "</h3><br>";
		echo "<table width='100%' align='center'>";
		echo "<tr>
				<td class='cim' width='5%'>#</td>
				<td class='cim' width='".$kategoriak[$kat[1]]["meret"]."'>".$kategoriak[$kat[1]]["nevek"][0]."</td>
				<td class='cim'>".$kategoriak[$kat[1]]["nevek"][1]."</td>
			  </tr>";
		$sql = mysql_query("SELECT ".implode(",", $kategoriak[$kat[1]]["select"])." FROM ".$kategoriak[$kat[1]]["from"]." $where ORDER BY ".$kategoriak[$kat[1]]["orderby"]." LIMIT ".$darab);
		$a = 1;
		while($data = mysql_fetch_array($sql))
		{
			$data1 = $data[$kategoriak[$kat[1]]["select"][0]];
			if($kategoriak[$kat[1]]["extra"] == "number_format")
				$data2 = number_format($data[$kategoriak[$kat[1]]["select"][1]], 0, ',', ',').$kategoriak[$kat[1]]["extra2"];
			else $data2 = $data[$kategoriak[$kat[1]]["select"][1]];

			if($jatekos["Karakterek"] > 0 && $jatekos["Karakter"][0]["Nev"] == $data1 || $jatekos["Karakterek"] > 1 && $jatekos["Karakter"][1]["Nev"] == $data1)
				echo "<tr class='kiemelt'><td>".$a."</td><td>".$data1."</td><td>".$data2."</td></tr>";
			else
				echo "<tr><td>".$a."</td><td>".$data1."</td><td>".$data2."</td></tr>";
			$a++;
		}

		echo "</table>";
		#########################################################
		echo "</td><td width='2%' class='clear clearbg'></td><td width='32%' class='clear clearbg'>";
		####################[TÁBLA HÁROM]########################
		echo "<h3>" . $kategoriak[$kat[2]]["nev"] . "</h3><br>";
		echo "<table width='100%' align='center'>";
		echo "<tr>
				<td class='cim' width='5%'>#</td>
				<td class='cim' width='".$kategoriak[$kat[2]]["meret"]."'>".$kategoriak[$kat[2]]["nevek"][0]."</td>
				<td class='cim'>".$kategoriak[$kat[2]]["nevek"][1]."</td>
			  </tr>";
		$sql = mysql_query("SELECT ".implode(",", $kategoriak[$kat[2]]["select"])." FROM ".$kategoriak[$kat[2]]["from"]." $where ORDER BY ".$kategoriak[$kat[2]]["orderby"]." LIMIT ".$darab);
		$a = 1;
		while($data = mysql_fetch_array($sql))
		{
			$data1 = $data[$kategoriak[$kat[2]]["select"][0]];
			if($kategoriak[$kat[2]]["extra"] == "number_format")
				$data2 = number_format($data[$kategoriak[$kat[2]]["select"][1]], 0, ',', ',').$kategoriak[$kat[2]]["extra2"];
			else $data2 = $data[$kategoriak[$kat[2]]["select"][1]];

			if($jatekos["Karakterek"] > 0 && $jatekos["Karakter"][0]["Nev"] == $data1 || $jatekos["Karakterek"] > 1 && $jatekos["Karakter"][1]["Nev"] == $data1)
				echo "<tr class='kiemelt'><td>".$a."</td><td>".$data1."</td><td>".$data2."</td></tr>";
			else
				echo "<tr><td>".$a."</td><td>".$data1."</td><td>".$data2."</td></tr>";
			$a++;
		}

		echo "</table>";
		#########################################################
		echo"</td></tr>";

		echo "</table>";
	}

	Lablec(false);
	exit;
}

Fejlec();


?>

<style type="text/css">

	table{
		border-spacing:0px; }
	.clear, .cleartr td, .cleartable tr td{
		border: none; }
	.clearbg{
		background-color: transparent; }
	.left{
		text-align: left; }
	img.link{
		cursor: crosshair; }
	img.link:hover{
		cursor: pointer; }
	td
	{
		border: 1px outset #888;
		padding: 2px;
		vertical-align: top;
		text-align:center;
		background-color: #202020;
	}
	.cim
	{
		border: 2px outset #333333;
		color:white;
		font-weight:bold;
		padding: 5px;
	}
	a.no
	{
		text-decoration:none;
		font-weight:bold;
	}
	tr.kiemelt td
	{
		color: yellow;
		font-weight: bold;
	}
</style>

<script type="text/javascript">
	var ajaxtoltes = false;
	var betoltve = false;
	var adatkesz = false;
	var kivalasztva = 0;
	var gombok = new Array("penz_kp", "penz_bank", "penz_sz_kp", "penz_sz_bank", "aktiv_szint", "aktiv_jo");
	var x;

	$(document).ready(Betolt);
	function Betolt()
	{
		for(x = 0; x < gombok.length; x++)
		{
			$("#"+gombok[x]).click(function(){klikk(this);});
		}
		$("#kuldes").click(function(){lekeres();});
	}

	function klikk(id)
	{
		//if(id.checked) kivalasztva++;
		//else kivalasztva--;
		kivalasztva = 0;
		for(x = 0; x < gombok.length; x++)
		{
			if($("#"+gombok[x]).attr("checked"))
				kivalasztva++;
		}
		if(kivalasztva > 3)
		{
			for(x = 0; x < gombok.length; x++)
			{
				if(kivalasztva > 3)
				{
					if($("#"+gombok[x]).attr("checked"))
					{
						$("#"+gombok[x]).attr("checked", false);
						kivalasztva--;
					}
				}
			}
		}
		if(kivalasztva == 3)
		{
			for(x = 0; x < gombok.length; x++)
			{
				if(!$("#"+gombok[x]).attr("checked"))
					$("#"+gombok[x]).attr("disabled", true);
			}
		}
		else if(kivalasztva <= 2)
		{
			for(x = 0; x < gombok.length; x++)
				$("#"+gombok[x]).attr("disabled", false);
		}

	}

	function lekeres()
	{
		var adatok = "darab=" + $("#darab").val() + "&adat=";
		kivalasztva = 0;
		for(x = 0; x < gombok.length; x++)
		{
			if($("#"+gombok[x]).attr("checked"))
			{
				kivalasztva++;
				if(kivalasztva > 1) adatok += ",";
				adatok += gombok[x];
			}
		}
		if(kivalasztva < 1 || kivalasztva > 3) return 1;

		if(!ajaxtoltes)
		{
			if(!betoltve)
			{
				$("#kuldes").toggle();
				$("#ajaxloader").toggle();

				AjaxLoad(adatok);
			}
			else
			{
				$("#kuldes").toggle();
				$("#ajaxloader").toggle();

				$("#lista").slideToggle(1000, function(){AjaxLoad(adatok);});
			}
		}
	}
	function AjaxLoad(adatok)
	{
		ajaxtoltes = true;
		$.ajax({
			type: "POST",
			url: "?ajax",
			data: adatok,
			success: function(msg)
			{
				if(!betoltve)
				{
					$("#lista").html(msg);
					$("#kuldes").toggle();
					$("#ajaxloader").toggle();
				}
				else
				{
					$("#lista").html(msg);
					$("#lista").slideToggle(1000, function(){
						$("#kuldes").toggle();
						$("#ajaxloader").toggle();
					});
				}
				ajaxtoltes = false;
				betoltve = true;
			}
		});
	}
</script>

<? if(isset($uzenet)) echo Felhivas($uzenet); ?>

<center><h1>Toplista</h1>

<table width="50%" align="center">
	<tr>
		<td width="100%" class="cim"><h2>Kategóriák</h2>
			<span class="left">
				- <input type="checkbox" id='penz_kp'> Leggazdagabbak (Készpénz)<br>
				- <input type="checkbox" id='penz_bank'> Leggazdagabbak (Bank)<br>
				- <input type="checkbox" id='penz_sz_kp'> Legszegényebbek (Készpénz)<br>
				- <input type="checkbox" id='penz_sz_bank'> Legszegényebbek (Bank)<br>
				- <input type="checkbox" id='aktiv_szint'> Legaktívabbak (Szint)<br>
				- <input type="checkbox" id='aktiv_jo'> Legaktívabbak (Játszott Óra)<br>
				<br>
				</span>
				<select id='darab'>
					<option value='10'>10</option>
					<option value='20'>20</option>
					<option value='30'>30</option>
					<option value='40'>40</option>
					<option value='50'>50</option>
					<option value='60'>60</option>
					<option value='70'>70</option>
					<option value='80'>80</option>
					<option value='90'>90</option>
					<option value='100'>100</option>
					<option value='125'>125</option>
					<option value='150'>150</option>
					<option value='175'>175</option>
					<option value='200'>200</option>
					<option value='250'>250</option>
				</select>db
				<button id='kuldes'>Lekérés</button>
				<div id='ajaxloader' style="display:none"><img src='img/ajax-loader.gif'></div>
		</td>
	</tr>
</table>
<br>
<div id='lista'>Nincs kiválasztva kategória</div>

</center>

<? Lablec(); ?>