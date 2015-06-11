<?
require_once("include/main.php");
Fejlec();
if(isset($_GET["kesz"]))
	Hiba("Sikeres regisztráció. Az admin megerősítés után a karaktered információi megjelennek a Karakter oldalon.");

if(!$jatekos["Belepve"])
	Hiba("Nem vagy belépve");

if($jatekos["Karakterek"] == 2)
	Hiba("Már van két karaktered!");

if($jatekos["Letrehozas"] != 0)
	Hiba("Egy karakter létrehozása már folyamatban van! Várd meg amíg elbírálják!");

if($jatekos["Tarsitas"] != 0)
	Hiba("Egy karakter társítása már folyamatban van! Várd meg amíg elbírálják!");

//if($jatekos["Teszt"] < time())
//	Hiba("Új karakter létrehozásához szükséges kitölteni a tesztet. Ezt <a href='quiz".$config["Ext"]."'>ide</a> kattintva megteheted.");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["regisztracio"]) && $_POST["regisztracio"] == "igen")
{
	$nev = str_replace(" ", "", $_POST["nev"]);
	$nem = $_POST["nem"]; $szarmazas = $_POST["szarmazas"]; $kor = $_POST["kor"]; $jelszo = $_POST["jelszo"]; $jelszo2 = $_POST["jelszo2"];
	if(strlen($nev) < 8 || strlen($nev) > 20)
		$uzenet = "Hibás név - Minimum 8, maximum 20 karakter";
	elseif(!RolePlayNev($nev))
		$uzenet = "Hibás név - Nem RolePlay név!";
	elseif(strpos(strtolower($nev), "eastwood") !== false || strpos(strtolower($nev), "clint_") !== false)
		$uzenet = "Ez a név nem vehető fel, válassz másik nevet!";
	elseif(strlen($jelszo) < 3 || strlen($jelszo) > 20)
		$uzenet = "Hibás jelszó - Minimum 3, maximum 20 karakter";
	elseif(!is_numeric($kor))
		$uzenet = "Ejj ejj...";
	elseif(!SzovegAnalizalas($nev))
		$uzenet = "Hibás név - Engedélyezett karakterek: Angol ABC, Számok, Speciális karakterek: '.', '_', '[', ']'";
	elseif(!SzovegAnalizalas($jelszo))
		$uzenet = "Hibás jelszó - Engedélyezett karakterek: Angol ABC, Számok, Speciális karakterek: '.', '_', '[', ']'";
	elseif($jelszo != $jelszo2)
		$uzenet = "Hibás jelszó - A megadott jelszavak nem egyeznek";
	else
	{
		$sql = mysql_query("SELECT id FROM playerek WHERE nev='".$nev."'");
		if(mysql_num_rows($sql) == 1)
			$uzenet = "Már létezik játékos ezzel a névvel";
		else
		{
			$sql = mysql_query("SELECT id FROM accountok WHERE Letrehozas='1' AND Letrehozando LIKE '".$nev.",%'");
			if(mysql_num_rows($sql) != 0) $uzenet = "Ez a karakter már regisztráció alatt van";
			else
			{
				$datum = date("Y-m-d H:i:s");
				$letrehozando = $nev . "," . strtoupper(md5($jelszo)) . "," . $nem . "," . $szarmazas . "," . $kor . "," . GetIP();
				mysql_query("UPDATE accountok SET Letrehozas='1', Letrehozando='".$letrehozando."', LetrehozasIdo='".$datum."' WHERE id='".$jatekos["ID"]."'");
				Atiranyit("letrehozas".$config["Ext"]."?kesz");
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
<center><h1>Karakter regisztráció</h1></center>

<center><table width=55% align=center><tr><td width="100%">

	<h2>Információk</h2><br>
	
		<form method="POST"><input type="hidden" name="regisztracio" value="igen">

			<table border=0 class="reg" width=100%>
				<tr><td width=50% class="adat">Karakter neve</td>
				<td class="adat_ertek"><input type="text" name="nev" maxlength="21" value="<? echo (isset($nev) ? $nev : "Vezeteknev_Keresztnev"); ?>"></td></tr>

				<tr><td width=50% class="adat">Karakter neme</td>
				<td class="adat_ertek" style="text-align:left; padding-left:25px;">
					<span>
						<input type="radio" name="nem" <? echo ($nem == "no" ? "" : "checked='true'") ?> value="ferfi">Férfi<br>
						<input type="radio" name="nem" <? echo ($nem == "no" ? "checked='true'" : "") ?> value="no">Nő
					</span>
				</td></tr>

				<tr><td width=50% class="adat">Karakter származása<br>(Kontinens)</td>
				<td class="adat_ertek" style="text-align:left; padding-left:25px;">
					<span>
						<input type="radio" name="szarmazas" <? echo (!isset($szarmazas) || $szarmazas == "europa" ? "checked='true'" : "") ?> value="europa">Európa<br>
						<input type="radio" name="szarmazas" <? echo ($szarmazas == "usa" ? "checked='true'" : "") ?>value="usa">USA<br>
						<input type="radio" name="szarmazas" <? echo ($szarmazas == "azsia" ? "checked='true'" : "") ?>value="azsia">Ázsia
					</span>
				</td></tr>

				<tr><td width=50% class="adat">Karakter kora</td>
				<td class="adat_ertek" style="text-align:left; padding-left:25px;">
					<span>
						<select name="kor">
							<?
								$szarmazas = "";
								for($x = 10; $x <= 50; $x++)
									$szarmazas .= "<option value='$x' ".($x == 15 ? "selected" : ($kor == $x ? "selected" : "")).">$x</option>";
								echo $szarmazas;
							?>
						</select>
					</span>
				</td></tr>

				<tr><td width=50% class="adat">Jelszó</td>
				<td class="adat_ertek"><input type="password" <? echo (isset($jelszo) ? "value='$jelszo'" : ""); ?> name="jelszo" maxlength="20"></td></tr>

				<tr><td width=50% class="adat">Jelszó (ellenőrzés)</td>
				<td class="adat_ertek"><input type="password" <? echo (isset($jelszo2) ? "value='$jelszo2'" : ""); ?> name="jelszo2" maxlength="20"></td></tr>
			</table><br>

		<input type="submit" value="Regisztrációs kérelem elküldése">
	
	</form>
	<br>
	<i>A regisztrációt az adminisztrátorok bírálják el</i>

</td></tr></table></center>

<? Lablec(); ?>