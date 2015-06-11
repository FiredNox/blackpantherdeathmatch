<?php 

$query = "SELECT * FROM stats;";
$result = mysql_query($query);
$num = mysql_num_rows($result);
//msg("2", "FIGYELEM! KARBANTARTÁS FOLYIK! NÉZZ VISSZA KÉSŐBB!");
//msg("2", "ATTENTION! MAINTENANCE GOING ON! COME BACK LATER!");
$i = 0;
while ($i < $num) {
	$serip = mysql_result($result, $i, "SAIP");
	$tsip = mysql_result($result, $i, "TSIP");
	echo "<img src='img/samp.png'><br><br>
	<h1><font color=orange><b>Grand Theft Auto: San Andreas Multiplayer<b><br></font>".$serip."</h1><br>
	<img src='img/ts.png'><br><br>
	<h1><b><font color=ligtblue>TeamSpeak 3</font><b><br><b>".$tsip."";
	$i++;
}
?>