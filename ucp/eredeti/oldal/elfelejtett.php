<?php
echo "<h1>Elfelejtett jelsz�</h1><center>";
if(isset($_GET['active_code']))
{
	if($_GET['active_code'] == "")
	{
		echo 'Hib�s param�ter';
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
			mail("noreply@see-rpg.hu","�j jelsz�","Kedves felhasznalonev!

A k�vetkez� linkre kattinva gener�lhatsz egy �j jelsz�t amennyiben elfelejtetted a jelszavad!

<a href='".$url."'>".$url."</a>

Amennyiben nem Te k�rted ki az �j jelsz�t hagyd figyelmen k�v�l ezt az emailt.
�dv�zlettel,
See Life Staff");
			echo 'Kik�ldt�k az E-mailt!<br>Lehet hogy a levet csak a SPAM mapp�ba tal�lod meg!';
		}
	} else {
		echo '<form action="index.php?menu=elfelejtett" method="POST">
				Add meg a felhaszn�l�neved: <input type="text" name="login_nev" size="15">
				<input type="submit" name="kuld" value="K�ld�s">
			</form>';
	}
}
?>