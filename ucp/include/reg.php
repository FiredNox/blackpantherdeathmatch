<?php
echo "<h1>Regisztráció</h1><center>";
$mutat = true;
if(isset($_POST['reg']))
{
	$n = $_POST['nev'];
	$p1 = $_POST['pw1'];
	$p2 = $_POST['pw2'];
	$em = $_POST['email'];
	$hashpw = hash('whirlpool', $p1);
	$hashpw = SHA1($p1);
	if($n == "" || $p1 == "" || $p2 == "" || $em == "")
		msg("2","Minden mezõ kitöltése kötelezõ!");
	else if(VanIlyenFelhasznalo($n))
		msg("2","Ez a felhasználónév már használatban van!");
	else if(!ValodiEmail($em))
		msg("2", "A beírt E-mail cím nem valós!");
	else if($p1 != $p2)
		msg("2", "A beírt két jelszó nem egyezik!");
	else
	{
		$rs = mysql_query("SELECT * FROM `jatekosok` ORDER BY `UID` DESC LIMIT 1");
		$ms = mysql_fetch_assoc($rs);
		$idje = $ms['ID'];
		$idje += 1;
		$insert = mysql_query("INSERT INTO `jatekosok` (Felhasznalonev, Jelszo) VALUES ('".mysql_escape_string($n)."','".mysql_escape_string($hashpw)."')");

		msg("1", "Sikeres regisztráció! Most már bejelentkezhetsz az oldalsó mezõk segítségével!");
		$mutat = false;
	}
}
if($mutat == true)
{
	echo "<form method=post id=reg>
	<table>
	<tr><td>Felhasználónév: </td> <td><input type=text name=nev placeholder=Felhasználónév><br></td></tr>
	<tr><td>Jelszó: </td> <td><input type=password name=pw1 placeholder=Jelszó><br></td></tr>
	<tr><td>Jelszó megerõsítés: </td> <td><input type=password name=pw2 placeholder=Jelszó megismétlése><br></td></tr>
	<tr><td>Email cím: </td> <td><input type=text name=email placeholder=Email cím<br></td></tr></table>
	<input type=submit value=Regisztráció name=reg>
	</form>";
}
?>