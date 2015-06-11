<style>
td, th {
font-size: 120%
}
</style>

<?php

	if(isset($_GET['headmaster'])) { $aloldalneve = '- Headmaster'; }
	else if(isset($_GET['alap'])) { $aloldalneve = '- Hiba Jelentés'; }
	else if(isset($_GET['scripterek'])) { $aloldalneve = '- Scripterek'; }
	else if(isset($_GET['foadminok'])) { $aloldalneve = '- Főadminok'; }
	else if(isset($_GET['adminok'])) { $aloldalneve = '- Adminok'; }
	echo "<h1>Kapcsolat ".$aloldalneve."</h1>";
?>	

<?php
	mysql_query("set names utf8");  
	if(isset($_GET['headmaster']))
	{
		echo "<br><h3>Üdv, kérlek csak nagyon indokoltan keress fel <font color=red>engem</font>. Amennyiben más nem tudja megoldani,
		szívesen segítek. Ilyen ügy lehetséges, hogy előfordul. Ezért kérem felesleges üzenettel ne bombázzatok,
		mert a valós problémák elvesznek a sok zagyvaság között.
		Jó szórakozást és élményekben gazdag játékot kívánok!<br>";
		echo "<br>Üdvözlettel, <font color=red>FiredNox</font><h3><br>";
		$query = "select * from kapcsolat where nev = 'FiredNox'";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);

		$i = 0;
		while ($i < $num) {
			$name = mysql_result($result, $i, "nev");
			$titulus = mysql_result($result, $i, "titulus");
			$pozicio = mysql_result($result, $i, "pozicio");
			$elerhetoseg = mysql_result($result, $i, "elerhetoseg");
			$hataskor = mysql_result($result, $i, "feladatkor");
			echo "<table border='2' style='width: 25%' class='table_border'>";			
			echo "<th><h3>Név</th>";
			echo "</tr>";
			echo "<td align='center'><font color=white><i><b>".$name."</td>";
			echo "</table>";
			echo "<br>";
			echo "<table border='2' style='width: 25%' class='table_border'>";			
			echo "<th><h3>Titulus</th>";
			echo "</tr>";
			echo "<td align='center'><font color=white><b>".$titulus."</td>";
			echo "</table>";
			echo "<br>";
			echo "<table border='2' style='width: 25%' class='table_border'>";			
			echo "<th><h3>Elérhetőség</th>";
			echo "</tr>";
			echo "<td align='center'><b><i>".$elerhetoseg."</td>";
			echo "</table>";
			echo "<br>";
			echo "<table border='2' style='width: 25%' class='table_border'>";			
			echo "<th><h3>Pozíció</th>";
			echo "</tr>";
			echo "<td align='center'><font color=red><b>".$pozicio."</td>";
			echo "</table>";
			$i++;
		}
		echo "</table>";
		echo "<br><br>";
		echo "<table border='4' style='width: 100%' class='table_border'>";
		echo "<tr align='center'>";
		echo "<th><h3>Amivel engem kereshetsz!</th>";
		echo "</tr>";
		echo "<td align='center'>".$hataskor."</td>";
		echo "</table>";
	}
	if(isset($_GET['scripterek']))
	{
		mysql_query("set names utf8");
		$query = "select * from kapcsolat where admin = 5555";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		echo "<table border='2' style='width: 100%'  class='table_border'>";
		echo "<tr align='center'>";
		echo "<th style='width: 20%'><h3>Név</th>";
		echo "<th style='width: 15%'><h3>Pozíció</th>";
		echo "<th style='width: 25%'><h3>Elérhetőség</th>";
		echo "<th style='width: 40%'><h3>Hatáskör";
		echo "</tr>";

		$i = 0;
		while ($i < $num) {
			$name = mysql_result($result, $i, "nev");
			$pozicio = mysql_result($result, $i, "pozicio");
			$elerhetoseg = mysql_result($result, $i, "elerhetoseg");
			$hataskor = mysql_result($result, $i, "feladatkor");
			echo "<tr align='center'>";
			echo "<td>".$name."</td>";
			echo "<td><font color=orange><b>".$pozicio."</font></td>";
			echo "<td align='center'>".$elerhetoseg."</td>";
			echo "<td align='center'>".$hataskor."</td>";
			echo "</tr>";
			$i++;
		}
		echo "</table>";
	}
	if(isset($_GET['foadminok']))
	{
		$query = "select * from kapcsolat where admin < 5555 and admin >=1337";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		echo "<table border='2' style='width: 100%' class='table_border'>";
		echo "<tr align='center'>";
		echo "<th><h3>Név</th>";
		echo "<th><h3>Pozíció</th>";
		echo "<th><h3>Elérhetőség</th>";
		echo "<th><h3>Hatáskör</th>";
		echo "</tr>";

		$i = 0;
		while ($i < $num) {
			$name = mysql_result($result, $i, "nev");
			$pozicio = mysql_result($result, $i, "pozicio");
			$elerhetoseg = mysql_result($result, $i, "elerhetoseg");
			$hataskor = mysql_result($result, $i, "feladatkor");
			echo "<tr align='center'>";
			echo "<td>".$name."</td>";
			echo "<td><font color=lightblue><b>".$pozicio."</font></td>";
			echo "<td align='center'>".$elerhetoseg."</td>";
			echo "<td align='center'>".$hataskor."</td>";
			echo "</tr>";
			$i++;
		}
		echo "</table>";
	}
	if(isset($_GET['adminok']))
	{
		$query = "select * from kapcsolat where admin < 1337 and admin > 0";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		echo "<table border='2' style='width: 100%' class='table_border'>";
		echo "<tr align='center'>";
		echo "<th><h3>Név</th>";
		echo "<th><h3>Pozíció</th>";
		echo "<th><h3>Elérhetőség</th>";
		echo "<th><h3>Hatáskör</th>";
		echo "</tr>";

		$i = 0;
		while ($i < $num) {
			$name = mysql_result($result, $i, "nev");
			$pozicio = mysql_result($result, $i, "pozicio");
			$elerhetoseg = mysql_result($result, $i, "elerhetoseg");
			$hataskor = mysql_result($result, $i, "feladatkor");
			echo "<tr align='center'>";
			echo "<td>".$name."</td>";
			echo "<td><font color=lime><b>".$pozicio."</font></td>";
			echo "<td align='center'>".$elerhetoseg."</td>";
			echo "<td align='center'>".$hataskor."</td>";
			echo "</tr>";
			$i++;
		}
		echo "</table>";
	}
	if(isset($_GET['segedek']))
	{
		echo "<br>";
		echo "<br>";
		$query = "select * from kapcsolat where seged = '2'";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		echo "<table border='2' style='width: 100%' class='table_border'>";
		echo "<tr align='center'>";
		echo "<th><h3>Név</th>";
		echo "<th><h3>Pozíció</th>";
		echo "<th><h3>Elérhetőség</th>";
		echo "<th><h3>Hatáskör</th>";
		echo "</tr>";

		$i = 0;
		while ($i < $num) {
			$name = mysql_result($result, $i, "nev");
			$pozicio = mysql_result($result, $i, "pozicio");
			$elerhetoseg = mysql_result($result, $i, "elerhetoseg");
			$hataskor = mysql_result($result, $i, "feladatkor");
			echo "<tr align='center'>";
			echo "<td>".$name."</td>";
			echo "<td><font color=#FFFACD><b>".$pozicio."</font></td>";
			echo "<td align='center'>".$elerhetoseg."</td>";
			echo "<td align='center'>".$hataskor."</td>";
			echo "</tr>";
			$i++;
		}
		echo "</table>";
	}
	if(isset($_GET['alap']))
	{
		echo "<br>";
		echo "<h3>Üdv, az alább látható lap kitöltésével jelezhetet számunkra az előforduló hibákat.<br>
		Amennnyiben belefér általában a következő frissítés alkalmával javítani is fogjuk.<br>
		<center><font color=red>Fontos!!</font> A talált hibákat senki másnak ne áruld el.<br>
		Ilyen esetben nincs elévülési idő, megszegése esetén akinek tovább adtad kapja a büntetést,<br>
		te magad pedig szintén, de a kétszeresét.<h3>";
		echo "<br>";
		include 'include/bugrep.php';
	}
?>