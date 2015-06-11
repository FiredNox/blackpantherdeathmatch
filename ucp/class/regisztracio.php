<?
require_once("include/main.php");
Fejlec();
if($jatekos["Belepve"])
{
	echo Felhivas("Már beléptél");
	Lablec();
	exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["regisztracio"]) && $_POST["regisztracio"] == "igen")
{
	$nev = $_POST["nev"]; $jelszo = $_POST["jelszo"]; $jelszo2 = $_POST["jelszo2"]; $mail = $_POST["mail"];
	$nev = str_replace(" ", "", $nev);
	if(strlen($nev) < 3 || strlen($nev) > 20)
		$uzenet = "Hibás név - Minimum 3, maximum 20 karakter";
	elseif(strlen($jelszo) < 3 || strlen($jelszo) > 20)
		$uzenet = "Hibás jelszó - Minimum 3, maximum 20 karakter";
	elseif(strpos($mail, "@") === false || strpos($mail, ".") === false || strpos($mail, "'") !== false || strpos($mail, '"') !== false)
		$uzenet = "Hibás E-Mail cím";
	elseif(!SzovegAnalizalas($nev, null, false))
		$uzenet = "Hibás név - Engedélyezett karakterek: Angol ABC, Számok, Speciális karakterek: '.', '_', '[', ']'";
	elseif(!SzovegAnalizalas($jelszo, null, false))
		$uzenet = "Hibás jelszó - Engedélyezett karakterek: Angol ABC, Számok, Speciális karakterek: '.', '_', '[', ']'";
	elseif($jelszo != $jelszo2)
		$uzenet = "Hibás jelszó - A megadott jelszavak nem egyeznek";
	else
	{
		$sql = mysql_query("SELECT ID FROM accountok WHERE nev='".$nev."'");
		if(mysql_num_rows($sql) == 1)
			$uzenet = "Már létezik felhasználó ezzel a névvel";
		else
		{
			$sql_keres = mysql_query("SELECT ID FROM accountok WHERE mail='$mail'");
			if(mysql_num_rows($sql_keres)) {
				$uzenet = "Már regisztráltak ezzel az email címmel";
			} elseif($mysql -> query_num('SELECT ID FROM accountok WHERE Megerositve="0" AND IP="'.GetIP().'"')) {
				$uzenet = 'Egy regisztrációs kérelmed már elbírálás alatt van, kérlek várj türelemmel!';
			} else {
				$datum = date("Y-m-d H:i:s");
				mysql_query("INSERT INTO accountok(nev, jelszo, mail, ip, regisztralt, utoljaraaktiv, megerositve)
								VALUES('".$nev."', '".SeeEncode($jelszo)."', '".$mail."', '".GetIP()."', '".$datum."', '".$datum."', '0')");
				Atiranyit("regisztracio".$config["Ext"]."?kesz");
			}
		}
	}
}
if(isset($_GET["kesz"]))
	echo Felhivas("Sikeres regisztráció. Az admin megerősítés után be tudsz lépni.");
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
<center><h1>Account regisztráció</h1>

<font color="cyan"><b><font size="+1">FIGYELEM!</font></b><br>
Ez az "Account" (magyarul felhasználó) a karaktereid kezelésére szolgál, ezzel tudsz létrehozni / társítani karakter(eke)t.<br>
<b>Tehát ezzel nem tudsz belépni a játékba!</b></font><br><br>

<table width=55% align=center><tr><td width="100%">

	<h2>Információk</h2><br>
	
		<form method="POST"><input type="hidden" name="regisztracio" value="igen">

			<table border=0 class="reg" width=100%>
				<tr><td width=50% class="adat">Felhasználónév</td>
				<td class="adat_ertek"><input type="text" name="nev" maxlength="20"></td></tr>

				<tr><td width=50% class="adat">Jelszó</td>
				<td class="adat_ertek"><input type="password" name="jelszo" maxlength="20"></td></tr>

				<tr><td width=50% class="adat">Jelszó (ellenőrzés)</td>
				<td class="adat_ertek"><input type="password" name="jelszo2" maxlength="20"></td></tr>

				<tr><td width=50% class="adat">E-Mail cím</td>
				<td class="adat_ertek"><input type="text" name="mail" maxlength="50"></td></tr>
			</table><br>

		<input type="submit" value="Regisztrációs kérelem elküldése">
	
	</form>
	<br>
	<i>A regisztrációt az adminisztrátorok bírálják el</i>

</td></tr></table></center>

<? Lablec(); ?>