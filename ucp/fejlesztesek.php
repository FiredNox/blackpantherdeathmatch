<?php
	msg("3", "Kérlek válaszd ki mely részleg fejlesztéseit kívánod megtekinteni!");
	echo '<table border="0" cellspacing="0" cellpadding="0">	
			<tr>
				<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" 
				style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=fejlesztesek&szerver\';">Szerver</div></td>
				<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" 
				style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=fejlesztesek&ucp\';">UserCP</div></td>
			</tr>
		</table>';
		
	if(isset($_GET['szerver'])) {
		echo'<h1>Szerver fejlesztései verziószámmal!</h1>';
		echo'<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" 
					onclick="window.location.href=\'index.php?menu=fejlesztesek&Sv01\';">V0.1</div></td>
				</tr>
			</table>';
		
	} else if(isset($_GET['Sv01'])) {
			echo'<h1>v0.1-es verziószmmal ellátott fejlesztések a szerveren</h1>';
	} else if(isset($_GET['Sv02'])) {
			echo'<h1>V0.2-es verziószámmal ellátott fejlesztések a szerveren</h1>';
	}
	if(isset($_GET['ucp'])) {
		echo'<h1>UCP fejlesztései verziószámmal!</h1>';
		echo'<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" 
					onclick="window.location.href=\'index.php?menu=fejlesztesek&UCPv01\';">V0.1</div></td>
				</tr>
			</table>';
	} else if(isset($_GET['UCPv01'])) {
		echo'<h1>v0.1-es verziószmmal ellátott fejlesztések a szerveren</h1>';
	} else if(isset($_GET['UCPv02'])) {
		echo'<h1>V0.2-es verziószámmal ellátott fejlesztések a szerveren</h1>';
	}
?>