<?
require_once("include/main.php");
require_once("include/statinfo.php");

if(!$jatekos["Belepve"] || !IsScripter())
	Error();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["ajax"]) && isset($_GET["a"]))
{
	$a = $_GET["a"];

	if($a == "uj" && isset($_POST["Nev"]) && isset($_POST["Model"]) && isset($_POST["Tav"]) && isset($_POST["Speed"]) && isset($_POST["Pos"]) && isset($_POST["NPos"]) && isset($_POST["NRPos"]) && isset($_POST["ZPos"]) && isset($_POST["ZRPos"]) && isset($_POST["Use"]))
	{
		$qry = mysql_query("SELECT ID FROM kapuk WHERE Nev='".$_POST["Nev"]."'");
		if(mysql_num_rows($qry) != 0)
		{
			echo "Már létezik ilyen nevű kapu!";
			mysql_free_result($qry);
		}
		else
		{
			$qry = mysql_query("INSERT INTO kapuk(Nev, Model, Tav, Speed, Pos, NPos, NRPos, ZPos, ZRPos, Hasznalo) VALUES('".$_POST["Nev"]."', '".$_POST["Model"]."', '".$_POST["Tav"]."', '".$_POST["Speed"]."', '".$_POST["Pos"]."', '".$_POST["NPos"]."', '".$_POST["NRPos"]."', '".$_POST["ZPos"]."', '".$_POST["ZRPos"]."', '".$_POST["Use"]."')");
			if($qry)
			{
				$kapuid = mysql_insert_id();
				echo "Kapu hozzáadva ". $_POST["Nev"]." néven! ID: ".$kapuid;
				mysql_query("INSERT INTO cmd(cmd, e1) VALUES('".CMD_KAPU_BETOLT."', '".$kapuid."')");
			}
			else
			{
				echo "Hiba a kapu hozzáadásakor!<br>Adatok:<br><pre>";
				print_r($_POST);
				echo "</pre><br>Hiba: ". mysql_error();
			}
		}
	}

	Lablec(false, null, true);
}

Fejlec();

$keres = true;
?>

<style type="text/css"></style>

<script type="text/javascript">
	var open = false;
	var ajax = false;
	var datas = {
		"Nev"	:	"-",
		"Model"	:	"-",
		"Tav"	:	"-",
		"Speed"	:	"-",
		"Pos"	:	"-",
		"NPos"	:	"-",
		//"NRPos"	:	"-",
		"ZPos"	:	"-",
		//"ZRPos"	:	"-",
		"Use"	:	"-"
	};

	var check = {
		"Nev"	:	Array("^([\\w ]+)$",	1, 0),
		"Model"	:	Array("^(\\d{3,5})$",	1, 0),
		"Tav"	:	Array("^(\\d{1,2})$",	1, 0),
		"Speed"	:	Array("^(\\d{1,2})$",	1, 0),
		"Pos"	:	Array("(-?[0-9]+(?:\\.[0-9]+)?)", 3, 0),
		"NPos"	:	Array("(-?[0-9]+(?:\\.[0-9]+)?)", 6, 0),
		//"NRPos"	:	Array("(-?[0-9]+(?:\\.[0-9]+)?)", 3, 0),
		"ZPos"	:	Array("(-?[0-9]+(?:\\.[0-9]+)?)", 6, 0),
		//"ZRPos"	:	Array("(-?[0-9]+(?:\\.[0-9]+)?)", 3, 0),
		"Use"	:	Array("([0-9]+)", -1),
	};

	$(document).ready(function(){
		$.each(datas, function(nev, ertek)
		{
			$("#"+ nev ).bind("focusout", function(){ FocusOut( $(this).attr("id") ) });
		});
	});

	function nyit(mit)
	{
		if(open) return 1;
		if(document.getElementById(mit+"_div").style.display != "none")
		{
			$("#"+mit+"_div").slideToggle(1000, function() { open = false; });
			document.getElementById(mit+"_img").src = "img/plus.gif";
			open = true;
		}
		else
		{
			$("#"+mit+"_div").slideToggle(1000, function() { open = false; });
			document.getElementById(mit+"_img").src = "img/minus.gif";
			open = true;
		}
	}
	function FocusOut(id)
	{
		var obj = $("#"+id);
		var obj_x = $("#"+id+"_x");

		var reg = check[id];
		var patt = new RegExp( reg[0], "ig");
		var ert = $("#"+id).val();

		var e = Array();
		var d = 0;

		while(vege = patt.exec(ert))
		{
			e[d] = vege[1];
			d++;
			//alert("Pattern: "+patt+"\nEredmény: "+vege+"\nDump: "+dump(vege));
		}

		if(reg[1] == -1 && d >= 1 || d == reg[1])
		{
			obj.css("background-color", "#33AA33");
			if(d == 1 && reg[1] != -1)
			{
				datas[id] = e[0];
				obj_x.html(datas[id]);
			}
			else
			{
				datas[id] = e;
				obj_x.html( datas[id].join(",") );
			}
			check[id][2] = 1;
		}
		else
		{
			obj.css("background-color", "#AA3333");
			check[id][2] = 0;
		}
	}
	function Kuldes()
	{
		var hiba = 0;
		$.each(datas, function(nev, ertek)
		{
			FocusOut(nev);
			if(check[nev][2] == 0)
				hiba = 1;
		});
		if(hiba == 1)
		{
			alert("Hibás kitöltés");
			return 1;
		}
		if(ajax)
			return 1;
		ajax = true;

		var adat = Array();
		$.each(datas, function(nev, ertek)
		{
			if(isArray(ertek))
			{
				if(nev == "NPos")
				{
					adat.push("NPos="+ [ertek[0], ertek[1], ertek[2]].join(","));
					adat.push("NRPos="+ [ertek[3], ertek[4], ertek[5]].join(","));
				}
				else if(nev == "ZPos")
				{
					adat.push("ZPos="+ [ertek[0], ertek[1], ertek[2]].join(","));
					adat.push("ZRPos="+ [ertek[3], ertek[4], ertek[5]].join(","));
				}
				else
					adat.push(nev +"="+ ertek.join(","));
			}
			else
				adat.push(nev +"="+ ertek);
		});
		adat = adat.join("&");
		//alert(adat+"\n===============\n==============\n"+dump(adat));
	
		$.ajax({
			type: "POST",
			url: "?ajax&a=uj",
			data: adat,
			success: function(msg){
				ajax = false;
				$("#ajax").html(msg);
				$("#ajax").css("display", "block");
				nyit("hozzaad");
			}
		});
	}
</script>

<div class='ajax_msg' id='ajax' style='display: none'></div>

<center><h1>Kapurendszer</h1>
<br>
<span class="kez" onclick="nyit('hozzaad')"><img src="img/<?=(isset($keres) ? "minus" : "plus")?>.gif" id="hozzaad_img"> Hozzáadás / Módosítás</span>

<div id="hozzaad_div" style="display:<?=(isset($keres) ? "block" : "none")?>">

	<input type="text" id="Nev" size="20" value="Kapu neve">

	<br><br>

	<table>
		<tr><td>Model</td><td>Táv</td><td>Speed</td></tr>
		<tr>
			<td><input type="text" id="Model"	size="5" maxlength="5" value='971'>
			<br>e: <div id='Model_x'	style='display:inline;font-weight:bold;'>?</div></td>

			<td><input type="text" id="Tav"		size="2" maxlength="2" value='15'>
			<br>e: <div id='Tav_x'	style='display:inline;font-weight:bold;'>?</div></td>

			<td><input type="text" id="Speed"	size="2" maxlength="2" value='3'>
			<br>e: <div id='Speed_x'	style='display:inline;font-weight:bold;'>?</div></td>
		</tr>
	</table>

	<br><br>

	<table>
		<tr><td>Kapu közepe</td>		<td><input type="text" id="Pos"		size="75" value='0 0 0'>
		<br>Megadott: <div id='Pos_x'	style='display:inline;font-weight:bold;'>?</div></td></tr>

		<tr><td>Nyitási helyzet</td>	<td><input type="text" id="NPos"	size="75" value='0 0 0 0 0 0'>
		<br>Megadott: <div id='NPos_x'	style='display:inline;font-weight:bold;'>?</div></td></tr>

		<!--<tr><td>Nyitási szög</td>		<td><input type="text" id="NRPos"	size="50" value='0 0 0'>
		<br>Megadott: <div id='NRPos_x'	style='display:inline;font-weight:bold;'>?</div></td></tr>-->

		<tr><td>Zárási helyzet</td>		<td><input type="text" id="ZPos"	size="75" value='0 0 0 0 0 0'>
		<br>Megadott: <div id='ZPos_x'	style='display:inline;font-weight:bold;'>?</div></td></tr>

		<!--<tr><td>Zárási szög</td>		<td><input type="text" id="ZRPos"	size="50" value='0 0 0'>
		<br>Megadott: <div id='ZRPos_x'	style='display:inline;font-weight:bold;'>?</div></td></tr>-->

		<tr><td>Használók</td>			<td><input type="text" id="Use"		size="50" value='0'>
		<br>Megadott: <div id='Use_x'		style='display:inline;font-weight:bold;'>?</div>
			<br>[Formátum] 0,1,2,3
			<br>[Frakciók] 1..99
		</td></tr>
	</table>

	<br><br>

	<button onclick="Kuldes()">Küldés</button>

</div>
</center>

<? Lablec(); ?>