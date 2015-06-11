<?
require_once("include/main.php");
Fejlec();

if(!$jatekos['Belepve'])
	Hiba('Nem vagy belépve');

?>

<style type="text/css">
a.kliensdl, a.kliensdl:visited {
	font-size: 50px;
}
a.kliensdl:hover {
	color: #ffaa33;
}
span.lepes {
	display: block;
}
span.lepes span {
	font-size: 15px;
	color: yellow;
}
div.problema {
	font-size: 13px;
	margin: 5px;
}
</style>

<script type="text/javascript"></script>

<center><a class="kliensdl" href="http://ucp.classrpg.net/egyeb/client/ClassRPG.exe">Letöltés</a></center><br><br>

<h1>Kliens</h1>
<!--<b>A klienshez a .NET keretrendszer legalább 3.5ös verziója szükséges - <a href='http://ucp.classrpg.net/egyeb/client/dotNetFx35setup.exe'>Letölthető ITT</a></b><br><br>-->

<b>A kliens célja, hogy a szerveren mindenki számára láthatóvá tegyünk<br>egyedi jármű, ruha és textúra módosításokat</b><br><br>
A kliens kizárólag a ClassRPG-n használható.<br>
A kliens teljesen vírusmentes. (<a href="https://www.virustotal.com/hu/file/8de5c82fd7613953bfa71dbcfcbdd2ce4b2aa85d2c8c4884c8d11125fa1f48dc/analysis/1378366814/" target="_BLANK">link</a>)


<h1>Részletes leírás az üzembe helyezésről</h1>
<span class="lepes"><span>1. lépés</span> Töltsd le a ClassRPG "segédklienst": <a href="http://ucp.classrpg.net/egyeb/client/ClassRPG.exe">letöltés</a></span>
<span class="lepes"><span>2. lépés</span> Az imént letöltött fájlt másold be a GTA San Andreas mappájába (ahol a gta_sa.exe, samp.exe található)</span>
<span class="lepes"><span>3. lépés</span> Indítsd el a ClassRPG.exe fájlt és jelentkezz be a karaktereddel (a kliensnek végig futnia kell, ameddig a szerveren játszol)</span>
<span class="lepes"><span>4. lépés</span> Csatlakozz a szerverre a szokásos módon, a SAMP kliensből</span>
<span class="lepes"><span>5. lépés</span> Élvezd a játékot!</span>

<h1>Problémák</h1>
<div class="problema">1) <b>Nem indul el a kliens</b><br>
- Hiányzik a .NET keretrendszer a gépedről. <a href='http://ucp.classrpg.net/egyeb/client/dotNetFx35setup.exe'>Letölthető ITT</a></div>
<div class="problema">2) <b>Nem telepíthető a .NET keretrendszer vagy a telepítő hibát jelez</b><br>
- Töröld le az előző keretrendszereket <a href='http://blogs.msdn.com/cfs-file.ashx/__key/CommunityServer-Components-PostAttachments/00-08-90-44-93/dotnetfx_5F00_cleanup_5F00_tool.zip'>ennek a segítségével</a>, majd utána próbáld újra a telepítést.</div>
<? Lablec(); ?>