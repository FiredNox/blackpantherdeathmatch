<?php
echo "<h1>Regisztr�ci�</h1><center>";
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
		msg("2","Minden mez� kit�lt�se k�telez�!");
	else if(VanIlyenFelhasznalo($n))
		msg("2","Ez a felhaszn�l�n�v m�r haszn�latban van!");
	else if(!ValodiEmail($em))
		msg("2", "A be�rt E-mail c�m nem val�s!");
	else if($p1 != $p2)
		msg("2", "A be�rt k�t jelsz� nem egyezik!");
	else
	{
		$rs = mysql_query("SELECT * FROM `jatekosok` ORDER BY `UID` DESC LIMIT 1");
		$ms = mysql_fetch_assoc($rs);
		$idje = $ms['ID'];
		$idje += 1;
		$insert = mysql_query("INSERT INTO `jatekosok` (Felhasznalonev, Jelszo) VALUES ('".mysql_escape_string($n)."','".mysql_escape_string($hashpw)."')");

		msg("1", "Sikeres regisztr�ci�! Most m�r bejelentkezhetsz az oldals� mez�k seg�ts�g�vel!");
		$mutat = false;
	}
}
if($mutat == true)
{
	echo "<form method=post id=reg>
	<table>
	<tr><td>Felhaszn�l�n�v: </td> <td><input type=text name=nev placeholder=Felhaszn�l�n�v><br></td></tr>
	<tr><td>Jelsz�: </td> <td><input type=password name=pw1 placeholder=Jelsz�><br></td></tr>
	<tr><td>Jelsz� meger�s�t�s: </td> <td><input type=password name=pw2 placeholder=Jelsz� megism�tl�se><br></td></tr>
	<tr><td>Email c�m: </td> <td><input type=text name=email placeholder=Email c�m<br></td></tr></table>
	<input type=submit value=Regisztr�ci� name=reg>
	</form>";
}
?>