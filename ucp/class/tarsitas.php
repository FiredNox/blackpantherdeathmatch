<?
require_once("include/main.php");
Fejlec();
if(isset($_GET["kesz"]))
	Hiba("Sikeres társításási kérelem. Az admin megerősítés után a karaktered információi megjelennek a Karakter oldalon.");
if(!$jatekos["Belepve"]) Hiba("Nem vagy belépve");
if($jatekos["Karakterek"] == 2) Hiba("Már van két karaktered!");
if($jatekos["Letrehozas"] != 0) Hiba("Egy karakter létrehozása már folyamatban van! Várd meg amíg elbírálják!");
if($jatekos["Tarsitas"] != 0) Hiba("Egy karakter társítása már folyamatban van! Várd meg amíg elbírálják!");
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tarsitas"]) && $_POST["tarsitas"] == "igen")
{
	$nev = str_replace(" ", "", $_POST["nev"]);
	$jelszo = $_POST["jelszo"];
	if(strlen($nev) < 5 || strlen($nev) > 20)
		$uzenet = "Hibás név - Minimum 5, maximum 20 karakter";
	elseif(!RolePlayNev($nev))
		$uzenet = "Hibás név - Nem RolePlay név!";
	elseif(strlen($jelszo) < 3 || strlen($jelszo) > 20)
		$uzenet = "Hibás jelszó - Minimum 3, maximum 20 karakter";
	elseif(!SzovegAnalizalas($nev))
		$uzenet = "Hibás név - Engedélyezett karakterek: Magyar ABC, Számok, Speciális karakterek: '.', '_', '[', ']'";
	elseif(!SzovegAnalizalas($jelszo))
		$uzenet = "Hibás jelszó - Engedélyezett karakterek: Magyar ABC, Számok, Speciális karakterek: '.', '_', '[', ']'";
	else
	{
		$sql = mysql_query("SELECT ID FROM playerek WHERE nev='".$nev."' AND pass='".strtoupper(md5($jelszo))."'");
		if(mysql_num_rows($sql) == 0)
			$uzenet = "Nem létezik ilyen karakter, vagy hibás a megadott jelszó";
		else
		{
			$dat = mysql_fetch_array($sql);
			$sql = mysql_query("SELECT id FROM accountok WHERE Tarsitas = '1' AND Tarsitando LIKE '".$dat["ID"].",%' OR Karakter1 = '".$dat["ID"]."' OR Karakter2 = '".$dat["ID"]."'");
			if(mysql_num_rows($sql) != 0) $uzenet = "Ez a karakter más felhasználóhoz tartozik, vagy társítás alatt van";
			else
			{
				$datum = date("Y-m-d H:i:s");
				$tarsitando = $nev . "," . $dat["ID"] . "," . GetIP();
				mysql_query("UPDATE accountok SET Tarsitas='1', Tarsitando='".$tarsitando."', TarsitasIdo='".$datum."' WHERE id='".$jatekos["ID"]."'");
				Atiranyit("tarsitas".$config["Ext"]."?kesz");
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
<center><h1>Karakter társítás</h1></center>

<center><table width=55% align=center><tr><td width="100%">

	<h2>Információk</h2><br>
	
		<form method="POST"><input type="hidden" name="tarsitas" value="igen">

			<table border=0 class="reg" width=100%>
				<tr><td width=50% class="adat">Karakter neve</td>
				<td class="adat_ertek"><input type="text" name="nev" maxlength="21" value="<? echo (isset($nev) ? $nev : "Vezeteknev_Keresztnev"); ?>"></td></tr>

				<tr><td width=50% class="adat">Karakter jelszava</td>
				<td class="adat_ertek"><input type="password" <? echo (isset($jelszo) ? "value='$jelszo'" : ""); ?> name="jelszo" maxlength="20"></td></tr>
			</table><br>

		<input type="submit" value="Társítási kérelem elküldése">
	
	</form>
	<br>
	<i>A társítást az adminisztrátorok bírálják el</i>

</td></tr></table></center>

<? Lablec(); ?>