<?
require_once("include/main.php");

if(!$jatekos["Belepve"])
	Error();

function Forditas($a)
{
	$uj = ""; $volt = false;
	for($x = 0; $x < strlen($a); $x++)
	{
		if(ord($a[$x]) == 10)
		{
			if(!$volt)
				$volt = true;
			else
				continue;
		}
		else
			$volt = false;

		$uj .= $a[$x];
	}
	return $uj;
	//return str_replace("\n\n", "\n", $a);
}

function ForditasRegExp($kesz, $sor1 = -1, $sor2 = -1)
{
	if(isset($_POST["s1"])) $sor1 = $_POST["s1"];
	if(isset($_POST["s2"])) $sor2 = $_POST["s2"];

	$mit = '@(\n)[\n]+@';
	$mire = '$1';
	$kesz = preg_replace($mit, $mire, $kesz);
	
	if($sor1 != -1) $x1 = '[color='.$sor1.']$1[/color]'; else $x1 = '$1';
	if($sor2 != -1) $x2 = '[color='.$sor2.']$3[/color]'; else $x2 = '$3';

	$mit = '@(.*)(\n|$)(.*)(\n|$){0,1}@';
	$mire = $x1.'$2'.$x2.'$4';
	$kesz = preg_replace($mit, $mire, $kesz);

	$kesz = str_replace(Array('[color='.$sor1.'][/color]', '[color='.$sor2.'][/color]'), '', $kesz);

	return $kesz;
}

if(isset($_GET["ajax"]) && isset($_POST["szoveg"]))
{
	echo ForditasRegExp($_POST["szoveg"]);
	/*AJAX*/ Lablec(false, null, true); /*AJAX*/
}

Fejlec();

?>

<style type="text/css"></style>

<script type="text/javascript">
var ajax = 0;
function Konvertal()
{
	if(ajax) return 1;
	ajax = 1;

	var adat = $('#ekezet').val();
	if(!adat.length)
		return alert("Nincs megadva szöveg");

	$('#gomb').css("display", "none");

	var adatkuldes = "szoveg="+encodeURIComponent(adat);

	if($('#s1').attr("checked") == "checked" && $('#s1v').val().length) adatkuldes += "&s1=" + $('#s1v').val();
	if($('#s2').attr("checked") == "checked" && $('#s2v').val().length) adatkuldes += "&s2=" + $('#s2v').val();

	$.ajax({
		type: "POST",
		url: "?ajax",
		data: adatkuldes,
		success: function(msg){
			ajax = 0;
			$('#kesz').val(msg);
			$('#gomb').css("display", "inline");
		}
	});
}
function Kijelol(mit)
{
	$('#'+mit).select();
}
</script>

<center><h1>Chat konvertálás</h1>

<table width="50%"><tr><td>

Info: Itt a chatlogodat tudod átkonvertálni úgy, hogy ez kiszedi a felesleges sortöréseket a szövegből,<br>
és/vagy az átláthatóság érdekében színezni a páratlan és páros sorokat<br><br>

<input type='checkbox' id='s1'> Páratlan sorok: <input type='text' id='s1v' style='padding: 1px' size='7' maxlength='7'><br>
<input type='checkbox' id='s2'> Páros sorok: <input type='text' id='s2v' style='padding: 1px' size='7' maxlength='7'><br>
pl.: white, #33FF33, stb...<br>

<br><br>

[Chatlogod] - <a href='javascript: void(0)' onclick='Kijelol("ekezet")'>Kijelöl</a><br>
<textarea id='ekezet' style='width: 600px; height: 200px'></textarea>
<br><br>

[Konvertált] - <a href='javascript: void(0)' onclick='Kijelol("kesz")'>Kijelöl</a><br>
<textarea id='kesz' style='width: 600px; height: 200px'></textarea>
<br><br>

<button onclick='Konvertal()' id='gomb'>Konvertálás</button>

</td></tr></table>

</center>

<? Lablec(); ?>