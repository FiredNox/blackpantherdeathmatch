<?php
if(isset($_GET['fejlec']))
{
	if(isset($_GET['m']))
	{
		if($_GET['m'] == "")
		{
			msg("2","Ki kell választani az egyik fejlécet!");
		} else if($_GET['m'] == "0" OR $_GET['m'] == "1") {
			$fejlec = mysql_query("UPDATE ucpuserek SET Fejlec='{$_GET['m']}' WHERE Felhasznalonev = '{$fsor['Felhasznalonev']}'");
			msg("1", "Sikeresen megváltoztattad a fejlécet!");
			msg("3", "A fejléc a következõ frissítésnél kerül megjelenítésre!");
		} else {
			msg("2", "Hibás fejléc azonosító!");
		}
	} else {
		msg("3","Válaszd ki melyik fejlécet szeretnéd látni bejelentkezve!");
	}echo '<div style="padding-top: 20px;"></div>';
	echo '<a href="index.php?menu=muveletek&fejlec&m=0"><img src="img/header.jpg" width="700"></a>';
	echo '<div style="padding-top: 20px;"></div>';
	echo '<a href="index.php?menu=muveletek&fejlec&m=1"><img src="img/header2.jpg" width="700"></a>';

}
else if(isset($_GET['jelszovalt']))
{
	if(isset($_GET['karakter']))
	{
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$jelszo1	=	$_POST['jelszo1'];
			$jelszo2	=	$_POST['jelszo2'];
			$regi		=	$_POST['regijelszo'];
			if(empty($jelszo1) OR empty($jelszo2) OR empty($regi))
			{
				msg("2", "Minden mezõ kitöltése kötelezõ!");
			} else {
				$jelszohash = hash("whirlpool", $jelszo1);
				$jelszohash2 = hash("whirlpool", $jelszo2);
				$jelszohashregi = hash("whirlpool", $regi);
				$jelszohashnagy		=	strtoupper($jelszohash);
				$jelszohash2nagy	=	strtoupper($jelszohash2);
				$jelszohashreginagy	=	strtoupper($jelszohashregi);
				$ellenorzes_jelszo_q = mysql_query("SELECT * FROM playerek WHERE Nev='{$sor['Nev']}'");
				$ellenorzes_jelszo = mysql_fetch_array($ellenorzes_jelszo_q);
				
				if($ellenorzes_jelszo['Pass'] == $jelszohashreginagy)
				{
					if($jelszohashnagy == $jelszohash2nagy)
					{
						$ujjelszo = mysql_query("UPDATE playerek SET Pass='".mysql_escape_string($jelszohashnagy)."' WHERE Nev='{$sor['Nev']}'");
						ucp_log("jelszovaltkarakter","".$fsor['Felhasznalonev']."", "váltott ".$sor['Nev']." -en!");
						msg("1", "Sikeresen megváltoztattad a jelszavadat! [Karakter]");
					} else {
						msg("2", "A két új jelszó nem egyezik!");
					}
				} else {
					msg("2", "Hibás elõzõ jelszó!");
				}
			}
		}
	} else if(isset($_GET['ucp']))
	{
		$jelszo1	=	$_POST['jelszo1'];
		$jelszo2	=	$_POST['jelszo2'];
		$regi		=	$_POST['regijelszo'];
		if(empty($jelszo1) OR empty($jelszo2) OR empty($regi))
		{
			msg("2", "Minden mezõ kitöltése kötelezõ!");
		} else {
			$jelszohash = hash("whirlpool", $jelszo1);
			$jelszohash2 = hash("whirlpool", $jelszo2);
			$jelszohashregi = hash("whirlpool", $regi);
	
			$ellenorzes_jelszo_q = mysql_query("SELECT * FROM ucpuserek WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
			$ellenorzes_jelszo = mysql_fetch_array($ellenorzes_jelszo_q);
			
			if($ellenorzes_jelszo['Jelszo'] == $jelszohashregi)
			{
				if($jelszohash == $jelszohash2)
				{
					$ujjelszo = mysql_query("UPDATE ucpuserek SET Jelszo='".mysql_escape_string($jelszohash)."' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					ucp_log("jelszovaltucp","".$fsor['Felhasznalonev']."", "váltott UCP-n");
					msg("1", "Sikeresen megváltoztattad a jelszavadat! [UCP]");
				} else {
					msg("2", "A két új jelszó nem egyezik!");
				}
			} else {
				msg("2", "Hibás elõzõ jelszó!");
			}
		}
	}
	if(isset($sor['Nev']))
	{
		echo '<h1>Jelszóváltás a karakteren</h1>
		<form action="index.php?menu=muveletek&jelszovalt&karakter" method="POST">
				<div style="font-size: 14px; color: #ffffff; font-weight: bold;">
					<table border="1" style=" font-weight: bold; color: #ffffff; width: 500px;" cellspacing="0" cellpadding="0" class="table_border">
						<tr>
							<td>Karakter új jelszava:</td>
							<td><input type="password" name="jelszo1"> ('.$sor['Nev'].')</td>
						</tr>
						<tr>
							<td>Karakter új jelszó mégegyszer:</td> 
							<td><input type="password" name="jelszo2"></td>
						</tr>
						<tr>
							<td>Karakter régi jelszava:</td>
							<td><input type="password" name="regijelszo"></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="2"><input type="submit" name="ment" value="Mentés"></td>
						</tr>
					</table>
				</form>
				</div>';
		echo '<div style="padding-top: 15px; padding-bottom: 15px;"><hr></div>';
	}
	echo '<h1>Jelszóváltás az UCP felhasználón</h1>
		<form action="index.php?menu=muveletek&jelszovalt&ucp" method="POST">
			<div style="font-size: 14px; color: #ffffff; font-weight: bold;">
				<table border="1" style=" font-weight: bold; width: 500px; color: #ffffff;" cellspacing="0" cellpadding="0" class="table_border">
					<tr>
						<td>UCP új jelszava:</td>
						<td><input type="password" name="jelszo1"></td>
					</tr>
					<tr>
						<td>UCP új jelszó mégegyszer:</td>
						<td><input type="password" name="jelszo2"></td>
					</tr>
					<tr>
						<td>UCP régi jelszava:</td> 
						<td><input type="password" name="regijelszo"></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="ment" value="Mentés"></td>
					</tr>
				</table>
			</form>
			</div>';
} else { echo 'Fejlesztés alatt ... '; }
?>