<?php
	msg("3", "K�rlek v�laszd ki mely r�szleg fejleszt�seit k�v�nod megtekinteni!");
	echo '<table border="0" cellspacing="0" cellpadding="0">	
			<tr>
				<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=fejlesztesek&szerver\';">Szerver</div></td>
				<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=fejlesztesek&ucp\';">UserCP</div></td>
			</tr>
		</table>';
	if(isset($_GET['szerver'])) {
		echo'<h1>Szerver fejleszt�sei verzi�sz�mmal!</h1>';
		echo'<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=fejlesztesek&v10\';">V1.0 Fejleszt�sei</div></td>
				</tr>
			</table>';
	} else if(isset($_GET['v10'])) {
		echo'<h1>v1.0-�s verzi�sz�mmal ell�tott fejleszt�sek a szerveren</h1>';
	} else if(isset($_GET['v12'])) {
		echo'<h1>V1.2-es verzi�sz�mmal ell�tott fejleszt�sek a szerveren</h1>';
	}
	
	
?>