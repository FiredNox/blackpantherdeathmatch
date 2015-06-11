<?php

require_once('include/main.php');

Fejlec();

function egyenlet($tagok)
{
	$osszeg = 15000000;
	return $osszeg - $osszeg * (100 / (100 + $tagok*$tagok * 0.25));
}

?>
<div style="text-align: center;">
	<div style="text-align: center; width: 33%; display: inline-block;">
		<table style="width: 75%; margin: 5px auto;">
			<tr class="cim"><td>Létszám</td><td>Összeg</td></tr>

			<?php for($t = 1; $t <= 20; $t++)
			{
				echo '<tr><td>' . $t . '</td><td>' . number_format(egyenlet($t)) . ' Ft</td></tr>';
			}?>

		</table>
	</div>
	<div style="text-align: center; width: 33%; display: inline-block;">
		<table style="width: 75%; margin: 5px auto;">
			<tr class="cim"><td>Létszám</td><td>Összeg</td></tr>

			<?php for($t = 21; $t <= 40; $t++)
			{
				echo '<tr><td>' . $t . '</td><td>' . number_format(egyenlet($t)) . ' Ft</td></tr>';
			}?>

		</table>
	</div>
	<div style="text-align: center; width: 33%; display: inline-block;">
		<table style="width: 75%; margin: 5px auto;">
			<tr class="cim"><td>Létszám</td><td>Összeg</td></tr>

			<?php for($t = 41; $t <= 60; $t++)
			{
				echo '<tr><td>' . $t . '</td><td>' . number_format(egyenlet($t)) . ' Ft</td></tr>';
			}?>

		</table>
	</div>
</div>

<?php
Lablec();
?>