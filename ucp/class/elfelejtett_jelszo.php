<?
require_once("include/main.php");
Fejlec();
if($jatekos["Belepve"])
{
	echo Felhivas("Már beléptél");
	Lablec();
	exit;
}
$kod = $_GET["kod"];
if(isset($kod))
{
	if(SzovegAnalizalas($kod))
	{
		$sql = mysql_query("SELECT ID, Nev, Mail FROM accountok WHERE TitkosKulcs = '".$kod."'");
		if(mysql_num_rows($sql) == 1)
		{
			$ujjelszo = Generator(15);
			$account = mysql_fetch_array($sql);
			mysql_query("UPDATE accountok SET Jelszo='".SeeEncode($ujjelszo)."', TitkosKulcs='0' WHERE id='".$account["ID"]."'");
			$uzenet =	'Üdv, '.$account['Nev'].'!'.PHP_EOL.
						PHP_EOL.
						'Új jelszavad: '.$ujjelszo.PHP_EOL.
						PHP_EOL.
						'Üdvözlettel,'.PHP_EOL.
						$config['SNev'] . ' AdminTeam'.PHP_EOL.
						PHP_EOL.
						PHP_EOL.
						'(Ez egy rendszer által generált levél, ne válaszolj rá!)';
			if(!SendMail($account["Mail"], "Új jelszó", $uzenet, null, null, false))
				Hiba("Hiba az SMTP szervernél!");
			Hiba("Az új jelszó elküldve az E-Mail címedre");
		}
	}
}
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mehet"]) && $_POST["mehet"] == "igen")
{
	$nev = str_replace(" ", "", $_POST["nev"]); $mail = str_replace(" ", "", $_POST["mail"]);

	if(strlen($nev) < 3 || strlen($nev) > 20)
		$uzenet = "Hibás név - Minimum 3, maximum 20 karakter";
	elseif(strpos($mail, "@") === false || strpos($mail, ".") === false || strpos($mail, "'") !== false || strpos($mail, '"') !== false)
		$uzenet = "Hibás E-Mail cím";
	elseif(!SzovegAnalizalas($nev))
		$uzenet = "Hibás név - Engedélyezett karakterek: Angol ABC, Számok, Speciális karakterek: '.', '_', '[', ']'";
	else
	{
		$sql = mysql_query("SELECT ID, Nev, Mail FROM accountok WHERE nev='".$nev."' AND mail='".$mail."'");
		if(mysql_num_rows($sql) != 1)
			$uzenet = "Hibás felhasználónév vagy E-Mail cím";
		else
		{
			$account = mysql_fetch_array($sql); mysql_free_result($sql);
			$datum = date("Y-m-d H:i:s"); $kulcs = Generator(32);
			mysql_query("UPDATE accountok SET TitkosKulcs='".$kulcs."' WHERE ID='".$account["ID"]."'");
			$uzenet =	"Üdv, ".$account["Nev"]."!".PHP_EOL.
						PHP_EOL.
						"Ha nem te kérted az új jelszót (IP: ".GetIP()."), akkor hagyd figyelmen kívül ezt a levelet.".PHP_EOL.
						PHP_EOL.
						"Ha te kérted, akkor másold vágólapra (CTRL + C) az alábbi linket:".PHP_EOL.
						$config["URL"]."/elfelejtett_jelszo".$config["Ext"]."?kod=".$kulcs.PHP_EOL.
						PHP_EOL.
						"Majd nyiss meg egy böngészőt, és másold be a címsorba (CTRL + V)!".PHP_EOL.
						PHP_EOL.
						"Üdvözlettel,".PHP_EOL.
						"ClassRPG AdminTeam".PHP_EOL.
						PHP_EOL.
						PHP_EOL.
						"(Ez egy rendszer által generált levél, ne válaszolj rá!)";
			if(!SendMail($account["Mail"], "Elfelejtett jelszó", $uzenet, null, null, false))
				Hiba("Hiba az SMTP szervernél!");
			Atiranyit("elfelejtett_jelszo".$config["Ext"]."?kesz");
		}
	}
}
if(isset($_GET["kesz"]))
	echo Felhivas("Az E-Mail címedre küldtünk egy levelet, a további utasításokat ott megtalálod");
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
		vertical-align: top;
		text-align:center;
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
<center><h1>Elfelejtett jelszó</h1></center>

<center><table width=55% align=center><tr><td width="100%">

	<h2>Információk</h2><br>
	
		<form method="POST"><input type="hidden" name="mehet" value="igen">

			<table border=0 class="reg" width=100%>
				<tr><td width=50% class="adat">Felhasználónév</td>
				<td class="adat_ertek"><input type="text" name="nev" maxlength="20"></td></tr>

				<tr><td width=50% class="adat">E-Mail cím</td>
				<td class="adat_ertek"><input type="text" name="mail" maxlength="50"></td></tr>
			</table><br>

		<input type="submit" value="Mehet!">
	
	</form>

</td></tr></table></center>

<? Lablec(); ?>