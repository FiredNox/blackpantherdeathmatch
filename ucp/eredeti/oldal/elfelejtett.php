<?php
echo "<h1>Elfelejtett jelszó</h1><center>";
if(isset($_GET['active_code']))
{
	if($_GET['active_code'] == "")
	{
		echo 'Hibás paraméter';
	} else {
		$ellenorzes_q = mysql_query("SELECT * FROM ucpuserek WHERE Felhasznalonev='".mysql_escape_string($_GET['active_code'])."'");
	}
} else {
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$login_nev = $_POST['login_nev'];
		if($login_nev == "")
		{
			echo 'Megkell a neved!';
		} else {
			$mysql_update = mysql_query("UPDATE ucpuserek SET lostpass='1' WHERE Felhasznalonev='{$login_nev}'");
			$url = 'http://ucp.see-rpg.com/index.php?reg&active_code='.$login_nev.'';
			mail("noreply@see-rpg.hu","Új jelszó","Kedves felhasznalonev!

A következõ linkre kattinva generálhatsz egy új jelszót amennyiben elfelejtetted a jelszavad!

<a href='".$url."'>".$url."</a>

Amennyiben nem Te kérted ki az új jelszót hagyd figyelmen kívül ezt az emailt.
Üdvözlettel,
See Life Staff");
			echo 'Kiküldtük az E-mailt!<br>Lehet hogy a levet csak a SPAM mappába találod meg!';
		}
	} else {
		echo '<form action="index.php?menu=elfelejtett" method="POST">
				Add meg a felhasználóneved: <input type="text" name="login_nev" size="15">
				<input type="submit" name="kuld" value="Küldés">
			</form>';
	}
}
?>