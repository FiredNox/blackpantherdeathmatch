<?
require_once("include/main.php");

if(!$jatekos["Belepve"] || !IsScripter())
	Error();

$mit =  Array("á", "Á", "é", "É", "í", "Í", "ö", "Ö", "ó", "Ó", "ő", "Ő", "ú", "Ú" ,"ü", "Ü", "ű", "Ű");
$mire = Array("",  "",  "ž", "‡", "˘", "‹", "¨", "‘", "¦", "Ź", "§", "“", "Ş", "“", "¬", "•", "«", "·");

function Forditas($a)
{
	global $mit, $mire;
	return str_replace($mit, $mire, $a);
}

if(isset($_GET["ajax"]) && isset($_POST["szoveg"]))
{
	echo Forditas($_POST["szoveg"]);
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

	$.ajax({
		type: "POST",
		url: "?ajax",
		data: "szoveg="+encodeURIComponent(adat),
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

<center><h1>Ékezet konvertálás</h1>

<table width="50%"><tr><td>

Info: A SAMPban a GameText és TextDrawban nem jeleníthető meg ékezet, csak különleges speciális karakterrel. Ezért készítettem egy konvertert, amivel bárki  átkonvertálhatja magának az ékezetes szövegét. Létezik SAMPban rá erre külön funkció, de a funkcióhívás csak feleslegesen terheli a szervert, így a már előre átkonvertált karaktert azonnal, konvertálás nélkül tudja feldolgozni a szerver, felesleges hívások nélkül.<br><br>

[Ékezetes] - <a href='javascript: void(0)' onclick='Kijelol("ekezet")'>Kijelöl</a><br>
<textarea id='ekezet' cols='60' rows='8'>Ékezetes szöveged</textarea>
<br><br>

[Konvertált] - <a href='javascript: void(0)' onclick='Kijelol("kesz")'>Kijelöl</a><br>
<textarea id='kesz' cols='60' rows='8'></textarea>
<br><br>

<button onclick='Konvertal()' id='gomb'>Konvertálás</button>

</td></tr></table>

</center>

<? Lablec(); ?>