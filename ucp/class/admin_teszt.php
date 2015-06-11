<?
require_once("include/main.php");

if(!$jatekos["Belepve"] || !CheckAdmin() && !IsScripter())
	Error();

require_once("include/statinfo.php");

$c = (isset($_GET["c"]) && array_key_exists($_GET["c"], $quizcats) ? $_GET["c"] : 0);

$valasz_select = "<select id='valaszok'>";
$valasz_lehetoseg = "";
for($o = 1; $o <= 9; $o++)
{
	if($o > 1) $valasz_select .= "<option value='".$o."' ".($o == 3 ? "selected" : "").">".$o."</option>";
	$valasz_lehetoseg .= "<div id='quiz_d_".$o."' ".($o > 3 ? "style='display:none'" : "").">#".$o." <input type='text' id='quiz_v_".$o."' size='90'> <input type='checkbox' name='quiz' id='quiz_cb_".$o."'></div>";
}
$valasz_select .= "</select>";
$kategoriak = "<select id='kategoria'>";
foreach($quizcats as $id => $kategoria)
{
	if($c == $id)
		$kategoriak .= "<option value='".$id."' selected>".$kategoria["Nev"]."</option>";
	else
		$kategoriak .= "<option value='".$id."'>".$kategoria["Nev"]."</option>";
}
$kategoriak .= "</select>";

if(isset($_GET["ajax"]))
{
	$a = (isset($_GET["a"]) ? $_GET["a"] : '');
	if($a == "uj" && isset($_POST["c"]) && isset($_POST["q"]) && isset($_POST["an"]) && isset($_POST["m"]))
	{
		$c = addslashes($_POST["c"]);
		$q = addslashes($_POST["q"]);
		$an = addslashes($_POST["an"]);
		$m = addslashes($_POST["m"]);

		$x = 1;
		$v = Array();
		while($x <= $an)
		{
			if(!isset($_POST[$x]) || strlen($_POST[$x]) < 1 || strpos($_POST[$x], ";") !== false) break;
			$v[] = addslashes($_POST[$x]);
			$x++;
		}

		if(count($v) != $an) // Kilépés
		{
			echo "Hiba #1";
			Lablec(false, null, true);
		}
		
		// Mentés
		$query = mysql_query("INSERT INTO quiz(Kategoria, Kerdes, Valaszok, Helyes) VALUES('".$c."', '".$q."', '".implode(";", $v)."', '".$m."')");
		if($query)
			echo "ok";
		else
			echo "Hiba mentéskor";

	}
	elseif($a == "l" && $c)
	{
		echo"<h2><a href='javascript: void(0)' onclick='Betolt(\"l\", \"c=".$c."\")'>".$quizcats[$c]["Nev"]."</a></h2>";
		echo"<table width='100%' class='bold nopadding'><tr><td width='5%'>ID</td><td width='25%'>Kérdés</td><td width='65%'>Válaszok</td><td width='5%'>A</td></tr>";

		$query = mysql_query("SELECT * FROM quiz WHERE Kategoria='".$c."' ORDER BY Kerdes ASC");
		
		if(mysql_num_rows($query)) while($q = mysql_fetch_array($query))
		{
			echo "<tr><td>".$q["ID"]."</td><td><div id='kerdes_".$q["ID"]."' style='display: inline'>".$q["Kerdes"]."</div></td><td>";

			$a = explode(";", $q["Valaszok"]);
			$h = explode(",", $q["Helyes"]);
			//$a[ $q["Helyes"]-1 ] = "<b style='color:#3A3'>".$a[ $q["Helyes"]-1 ]."</b>";
			for($b = 0; $b < count($a); $b++)
			{
				if(in_array($b+1, $h))
					$a[$b] = "<b style='color:#3A3'>".$a[$b]."</b>";
			}

			echo implode(" <b style='font-size:20px; color:yellow;'>-</b> ", $a);

			echo "</td><td><img class='kez' src='img/edit.png' title='Szerkesztés' onclick='Szerkeszt(\"".$q["ID"]."\")'> <img class='kez' src='img/torol.png' title='Törlés' onclick='Torol(\"".$q["ID"]."\")'></td></tr>";
		}
		else echo "<tr><td colspan='4'>Nincs kérdés</td></tr>";

		echo"</table>";
	}
	elseif($a == "e" && isset($_POST["id"]) && is_numeric($id = $_POST["id"]))
	{
		if(isset($_POST["sz"]) && $_POST["sz"] == "sz" && isset($_POST["c"]) && isset($_POST["q"]) && isset($_POST["an"]) && isset($_POST["m"]))
		{
			$c = addslashes($_POST["c"]);
			$q = addslashes($_POST["q"]);
			$an = addslashes($_POST["an"]);
			$m = addslashes($_POST["m"]);

			$x = 1;
			$v = Array();
			while($x <= $an)
			{
				if(!isset($_POST[$x]) || strlen($_POST[$x]) < 1 || strpos($_POST[$x], ";") !== false) break;
				$v[] = addslashes($_POST[$x]);
				$x++;
			}

			if(count($v) != $an) // Kilépés
			{
				echo "Hiba #1";
				Lablec(false, null, true);
			}
			
			$exec = Array();
			$exec[] = "Kategoria='".$c."'";
			$exec[] = "Kerdes='".$q."'";
			$exec[] = "Valaszok='".implode(";", $v)."'";
			$exec[] = "Helyes='".$m."'";

			// Mentés
			$query = mysql_query("UPDATE quiz SET ".implode(", ", $exec)." WHERE ID='".$id."'");
			if($query)
				echo "ok";
			else
				echo "Hiba mentéskor";
		}
		else
		{
			$query = mysql_query("SELECT * FROM quiz WHERE ID='".$id."'");
			if(mysql_num_rows($query))
			{
				$q = mysql_fetch_array($query);
				$q["Valaszok"] = explode(";", $q["Valaszok"]);
				echo json_encode($q);
			}
			else echo "0";
		}
	}
	elseif($a == "t" && isset($_POST["id"]) && is_numeric($id = $_POST["id"]))
	{
		$query = mysql_query("DELETE FROM quiz WHERE ID='".$id."'");
		if($query)
			echo "ok";
		else
			echo "Hiba törléskor";
	}
	elseif($a == "d")
	{
		echo'<table width="30%"><tr class="nopadding bold"><td width="60%">Kategória</td><td width="40%">Kérdések</td></tr>';
		foreach($quizcats as $id => $kategoria)
		{
			$query = mysql_query("SELECT ID FROM quiz WHERE Kategoria='".$id."'");
			echo "<tr><td><a href='javascript: void(0)' onclick='Betolt(\"l\", \"c=".$id."\"); c = ".$id."'>".$kategoria["Nev"]."</a></td><td>".mysql_num_rows($query)."db</td></tr>";
		}
		echo'</table>';
	}
	/*AJAX*/ Lablec(false, null, true); /*AJAX*/
}

Fejlec();

echo'
<div id="dialog-quiz" title="Tesztkérdés" style="display: none">
	<p id="quiz-p">
		Kategória: '.$kategoriak.'<br><br>
		Kérdés: <input type="text" id="kerdes" size="60"><br><br>
		Válaszok: '.$valasz_select.'<br><br>
		'.$valasz_lehetoseg.'
	</p>
</div>
';

if(isset($uzenet)) echo Felhivas($uzenet);
?>

<script type="text/javascript">
var ajax = 0;
var c = 0;

$(document).ready(function() {
	Betolt("d");
	$('#valaszok').change( function(){
		Darabszam( $(this).val() );
	} );
});

function Betolt(oldal, extra)
{
	if(ajax) return alert("Egy kérés már futás alatt van");

	ajax = 1;

	data = "?ajax&a="+oldal;
	if(extra)
		data = data +"&"+ extra;

	$("#ajax").html("<center><b>Betöltés...</b></center>");
	$.ajax({
		type: "GET",
		url: data,
		success: function(msg){
			ajax = 0;
			$("#ajax").html(msg);
		}
	});
}

function Darabszam(most)
{
	var x = 1;
	while(x <= 9)
	{
		if(x <= most) $('#quiz_d_'+x).css("display", "block");
		else $('#quiz_d_'+x).css("display", "none");

		x++;
	}
}

function UjKerdes(indit)
{
	if(indit)
	{
		if(ajax) return alert("Egy kérés már futás alatt van");

		var c = $('#kategoria').val();
		var q = $('#kerdes').val();
		var an = $('#valaszok').val();
		var m = 0;

		var adat = Array();
		var helyes = Array();

		if(q.length < 10)
			return alert("Túl rövid kérdés...");

		if(c.indexOf('=') != -1 || c.indexOf('&') != -1) return alert("Hibás karakterek a kérdésben");

		adat.push("c="+c);
		adat.push("q="+q);
		adat.push("an="+an);

		var x = 1;
		var v = "";


		while( x <= an )
		{
			v = $('#quiz_v_'+x).val();
			if(v.length < 1)
				return alert("A "+x+". válasz hibás! Túl rövid válasz...");

			if(v.indexOf('=') != -1 || v.indexOf('&') != -1 || v.indexOf(';') != -1)
				return alert("Hibás karakterek a "+x+". válaszban!");
			
			adat.push(x+"="+v);

			if($('#quiz_cb_'+x).attr("checked"))
			{
				m++;
				helyes.push(x);
			}

			x++;
		}

		if(!m)
			return alert("Nincs helyes válasz megjelölve");

		adat.push("m="+implode(",", helyes));		

		ajax = 1;

		$.ajax({
			type: "POST",
			url: "?ajax&a=uj",
			data: implode("&", adat),
			success: function(msg){
				ajax = 0;
				if(msg == "ok")
				{
					Nullaz();

					alert("Sikeresen hozzáadva.");
					$( "#dialog-quiz" ).dialog( "close" );

					if(c) Betolt("l", "c="+c);
					else Betolt("d");
				}
				else
					alert(msg);
			}
		});

		return 1;
	}

	if($( "#dialog-quiz" ))
	{
		$(function() {
			$( "#dialog-quiz" ).dialog({
				resizable: true,
				minHeight: 400,
				height: 400,
				minWidth: 800,
				width: 800,
				modal: false,
				title: "Tesztkérdés",
				show: "fade",
				hide: "fade",
				position: ["top", 100],
				buttons: {
					"Hozzáad": function() {
						if(!ajax) UjKerdes(true);
					},
					"Mégse": function() {
						if(!ajax) $( this ).dialog( "close" );
					}
				}
			});
		});
	}
}
function Szerkeszt(id, indit)
{
	if(ajax) return alert("Egy kérés már futás alatt van");
	ajax = 1;

	if(indit)
	{
		var c = $('#kategoria').val();
		var q = $('#kerdes').val();
		var an = $('#valaszok').val();
		var m = 0;

		var adat = Array();
		
		var helyes = Array();

		if(q.length < 10)
			return alert("Túl rövid kérdés...");

		if(c.indexOf('=') != -1 || c.indexOf('&') != -1) return alert("Hibás karakterek a kérdésben");

		adat.push("id="+id);
		adat.push("sz=sz");

		adat.push("c="+c);
		adat.push("q="+q);
		adat.push("an="+an);

		var x = 1;
		var v = "";


		while( x <= an )
		{
			v = $('#quiz_v_'+x).val();
			if(v.length < 1)
				return alert("A "+x+". válasz hibás! Túl rövid válasz...");

			if(v.indexOf('=') != -1 || v.indexOf('&') != -1 || v.indexOf(';') != -1)
				return alert("Hibás karakterek a "+x+". válaszban!");
			
			adat.push(x+"="+v);

			if($('#quiz_cb_'+x).attr("checked"))
			{
				m++;
				helyes.push(x);
			}

			x++;
		}

		if(!m)
			return alert("Nincs helyes válasz megjelölve");

		adat.push("m="+implode(",",helyes));	

		ajax = 1;

		$.ajax({
			type: "POST",
			url: "?ajax&a=e",
			data: implode("&", adat),
			success: function(msg){
				ajax = 0;
				if(msg == "ok")
				{
					Nullaz();

					alert("Sikeresen frissítve.");
					$( "#dialog-quiz" ).dialog( "close" );

					if(c) Betolt("l", "c="+c);
					else Betolt("d");
				}
				else
					alert(msg);
			}
		});

		return 1;
	}

	$.ajax({
		type: "POST",
		url: "?ajax&a=e",
		data: "id="+id,
		success: function(msg){
			ajax = 0;
			adat = eval( jQuery.parseJSON( msg ) );
			
			$('#kategoria').val(adat["Kategoria"]);
			$('#kerdes').val(adat["Kerdes"]);

			var db = adat["Valaszok"].length;
			$('#valaszok').val(db);

			var x = 1;
			var helyes = adat["Helyes"].split(',');
			while(x <= 9)
			{
				if($('#quiz_cb_'+x).attr("checked"))
					$('#quiz_cb_'+x).removeAttr("checked");

				if(x <= db)
				{
					if(in_array(x, helyes))
						$('#quiz_cb_'+x).attr("checked", "checked");

					$('#quiz_d_'+x).css('display', 'block');
					$('#quiz_v_'+x).val(adat["Valaszok"][x-1]);
				}
				else
				{
					$('#quiz_d_'+x).css('display', 'none');
					$('#quiz_v_'+x).val('');
				}

				x++;
			}

			$(function() {
				$( "#dialog-quiz" ).dialog({
					resizable: true,
					minHeight: 400,
					height: 400,
					minWidth: 800,
					width: 800,
					modal: false,
					title: "Tesztkérdés",
					show: "fade",
					hide: "fade",
					position: ["top", 100],
					buttons: {
						"Mentés": function() {
							if(!ajax) Szerkeszt(id, true);
						},
						"Mégse": function() {
							if(!ajax) $( this ).dialog( "close" );
						}
					}
				});
			});

		}
	});
}
function Torol(id)
{
	if(ajax) return alert("Egy kérés már futás alatt van");

	if(!confirm("Biztosan törlöd a \""+$('#kerdes_'+id).html()+"\" nevű kérdést?", "Igen", "Nem"))
		return 1;

	ajax = 1;

	$.ajax({
		type: "POST",
		url: "?ajax&a=t",
		data: "id="+id,
		success: function(msg){
			ajax = 0;
			if(msg == "ok")
			{
				alert("Sikeresen törölve");
				if(c) Betolt("l", "c="+c);
				else Betolt("d");
			}
			else
				alert(msg);
		}
	});
}
function Nullaz()
{
	$('#kerdes').val('');
	for(x = 1; x < 9; x++)
	{
		$('#quiz_v_'+x).val('');
	}
}
</script>

<center><h1><a href='javascript: void(0);' onclick='Betolt("d")'>Tesztkérdések</a></h1>
<a href="javascript: void(0)" onclick="UjKerdes()">Új kérdés</a><br><br>

<div id="ajax"></div>

</center>
<? Lablec(); ?>