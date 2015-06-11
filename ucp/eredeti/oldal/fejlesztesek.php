<?php
	msg("3", "Kérlek válaszd ki mely részleg fejlesztéseit kívánod megtekinteni!");
	echo '<table border="0" cellspacing="0" cellpadding="0">	
			<tr>
				<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=fejlesztesek&szerver\';">Szerver</div></td>
				<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=fejlesztesek&ucp\';">UserCP</div></td>
			</tr>
		</table>';
	if(isset($_GET['szerver'])) {
		echo'<h1>Szerver fejlesztései verziószámmal!</h1>';
		echo'<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=fejlesztesek&v10\';">V1.0 Fejlesztései</div></td>
				</tr>
			</table>';
	} else if(isset($_GET['v10'])) {
		echo'<h1>v1.0-ás verziószámmal ellátott fejlesztések a szerveren</h1>';
	} else if(isset($_GET['v12'])) {
		echo'<h1>V1.2-es verziószámmal ellátott fejlesztések a szerveren</h1>';
	}
	
	
?>