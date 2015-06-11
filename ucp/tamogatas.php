<?php
msg("4", "A TÃ¡mogatÃ¡si rendszer ideiglenesen nem elÃ©rhetÅ‘!");

/*	echo'<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&hunsms\';">SMS <font style="font-weight: normal;  font-style: italic">(HUN)</font></div></td>
				<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&kulfsms\';">SMS <font style="font-weight: normal; font-style: italic">(International)</font></div></td>
				<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&utalas\';">BANK CARD</div></td>
			</tr>
		</table>';
	echo'<div style="padding-top: 20px;"></div>';
	if(isset($_GET['hunsms'])) {
	echo '<h1><font color="green"> MAGYAR</font> SMS TÃMOGATÃS CSOMAGOK</h1>
			<table border="0" style="padding-top: 20px;" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&bronz\';">Bronz 400 FT (+ÃFA)</div></td>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&ezust\';">EzÃ¼st 800 FT (+ÃFA)</div></td>
				</tr>
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&arany\';">Arany 1600 FT (+ÃFA)</div></td>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&gyemant\';">GyÃ©mÃ¡nt 4000 FT (+ÃFA)</div></td>
				</tr>
			</table>';
	}
	if(isset($_GET['kulfsms'])) {
		echo'<h1><font color="green"> KÅ°LFÃ–LDI</font> SMS TÃMOGATÃS CSOMAGOK</h1>
			<table border="0" style="padding-top: 20px;" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&romania\';">RomÃ¡nia (2 EUR + ÃFA)</div></td>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&ukrajna\';">Ukrajna (16 UAH ÃFA-val)</div></td>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&szlovakia\';">SzlovÃ¡kia (1 EUR + ÃFA)</div></td>
				</tr>
			</table>';
	}
	if(isset($_GET['romania'])) {
		echo'
		<div style="padding-top: 70px;">
			<h1>RomÃ¡niai sms tÃ¡mogatÃ¡s >>> 1000 prÃ©miumpont</h1>
			<table BORDER="0" style=" width: 600px;" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" style="background-image: url(img/iphone.png); background-repeat: no-repeat; width: 175px; height: 292px; padding-top: 55px;"><div style="padding-left: 15px; font-size: 10px;">1314<br><br>srv seelife <b>';
					if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
				
				echo '</b></div></td>
					<td valign="top" align="center" style=" width: 400px; padding-top: 20px; padding-right: 10px; padding-left: 10px;"><font color=white>RomÃ¡niÃ¡bÃ³l valÃ³ prÃ©miumpont rendelÃ©shez kÃ¼ld a <font color=red>srv seelife ';
	if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
	echo '</font> szót sms-ben a <font color=red>1314</font> telefonszámra.<br><b><font color=red>FONTOS!</font></b> Az SMS elküldésekor a karaktered nem lehet online, különben a rendszer nem írja automatikusan jóvá a prémiumpontokat!</font><br><img src="img/romania.gif"></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="padding-top: 10px;"><p><font color=red>A hibásan elküldött sms-ért nem vállalunk felelõsséget! (pl, rossz prefix, rossz telefonszám)</font><br> Az emelt díjas SMS szolgáltatást biztosítja:
V & Zs 98 Bt
aggregátor: www.szerverem.hu<br>
További információk: (52) 999 337 vagy info@szerverem.hu</p></td>
				</tr>
			</table>
		</div>	
	';
	}
	if(isset($_GET['ukrajna'])) {
		echo'
		<div style="padding-top: 70px;">
			<h1>Ukrajnai sms támogatás >>> 1000 prémiumpont</h1>
			<table BORDER="0" style=" width: 600px;" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" style="background-image: url(img/iphone.png); background-repeat: no-repeat; width: 175px; height: 292px; padding-top: 55px;"><div style="padding-left: 15px; font-size: 10px;">4449<br><br>srv seelife <b>';
					if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
				
				echo '</b></div></td>
					<td valign="top" align="center" style=" width: 400px; padding-top: 20px; padding-right: 10px; padding-left: 10px;"><font color=white>Ukrajnából való prémiumpont rendeléshez küld a <font color=red>srv seelife ';
	if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
	echo '</font> szót sms-ben a <font color=red>4449</font> telefonszámra.<br><b><font color=red>FONTOS!</font></b> Az SMS elküldésekor a karaktered nem lehet online, különben a rendszer nem írja automatikusan jóvá a prémiumpontokat!</font><br><img src="img/ukrajna.jpg"></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="padding-top: 10px;"><p><font color=red>A hibásan elküldött sms-ért nem vállalunk felelõsséget! (pl, rossz prefix, rossz telefonszám)</font><br> Az emelt díjas SMS szolgáltatást biztosítja:
V & Zs 98 Bt
aggregátor: www.szerverem.hu<br>
További információk: (52) 999 337 vagy info@szerverem.hu</p></td>
				</tr>
			</table>
		</div>	
	';
	}
	if(isset($_GET['szlovakia'])) {
		echo'
		<div style="padding-top: 70px;">
			<h1>Szlovákiai sms támogatás >>> 500 prémiumpont</h1>
			<table BORDER="0" style=" width: 600px;" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" style="background-image: url(img/iphone.png); background-repeat: no-repeat; width: 175px; height: 292px; padding-top: 55px;"><div style="padding-left: 15px; font-size: 10px;">7771<br><br>srv seelife <b>';
					if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
				
				echo '</b></div></td>
					<td valign="top" align="center" style=" width: 400px; padding-top: 20px; padding-right: 10px; padding-left: 10px;"><font color=white>Szlovákiából való prémiumpont rendeléshez küld a <font color=red>srv seelife ';
	if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
	echo '</font> szót sms-ben a <font color=red>7771</font> telefonszámra.<br><b><font color=red>FONTOS!</font></b> Az SMS elküldésekor a karaktered nem lehet online, különben a rendszer nem írja automatikusan jóvá a prémiumpontokat!</font><br><img src="img/szlovakia.jpg"></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="padding-top: 10px;"><p><font color=red>A hibásan elküldött sms-ért nem vállalunk felelõsséget! (pl, rossz prefix, rossz telefonszám)</font><br> Az emelt díjas SMS szolgáltatást biztosítja:
V & Zs 98 Bt
aggregátor: www.szerverem.hu<br>
További információk: (52) 999 337 vagy info@szerverem.hu</p></td>
				</tr>
			</table>
		</div>	
	';
	}
	if(isset($_GET['utalas'])) {
		echo'<h1>BANKI ÁTUTALÁS PRÉMIUM CSOMAGOK</h1>
			<table border="0" style="padding-top: 20px;" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&ubronz\';">BRONZ (1000FT)</div></td>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&uezust\';">EZÜST (2000FT)</div></td>
				</tr>
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&uarany\';">ARANY (3500FT)</div></td>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&ugyemant\';">GYÉMÁNT (5000FT)</div></td>
				</tr>
			</table>';
	} //Bronz 3000pp, ezüst 4000, arany 8000pp, gyémánt 16000
	if(isset($_GET['ubronz'])) {
		echo'<h1>BRONZ csomag</h1>';
		msg("2", "Utalásnál ennek megfelelõen kell kitölteni az utalási ûrlapot!");
			echo'<table border="1" style="width: 300px;" class="table_border" cellspacing="0" cellpadding="0">
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Név:</td>
					<td>Magyar Krisztián</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Bankszámlaszám:</td>
					<td>50800111-11212841</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Közlemény:</td>
					<td>';if(isset($sor['Nev'])) 
					{ 
						echo$sor['Nev']; 
					} else { 
						echo'IG_NEVED'; 
					}
				echo'</td>';
				echo'</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Utalandó összeg:</td>
					<td>1000 HUF</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Jutalom:</td>
					<td>3000 PrémiumPont</td>
				</tr>
			</table><div style="padding-top: 20px;"></div>';
			echo'<div style="padding-top: 20px;"></div>';
			echo'<font color="red">A hibás utalásokért nem vállalunk felelõsséget! (pl rossz számlaszám, stb..)</font><br>
				<font color="white">Amennyiben hibás közlemény stb.. adtál meg, még korrigálni tudjuk a hibát!<br>
				A banki átutalással megrendelt prémiumpontok 24 órán belül (munkanapokon) kerülnek jóváírásra, vagy bizonylat<br>
				bemutatása ellenében akár 5 órán belül!';
	}
	if(isset($_GET['uezust'])) {
		echo'<h1>EZÜST csomag</h1>';
			msg("2", "Utalásnál ennek megfelelõen kell kitölteni az utalási ûrlapot!");
			echo'<table border="1" style="width: 300px;" class="table_border" cellspacing="0" cellpadding="0">
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Név:</td>
					<td>Magyar Krisztián</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Bankszámlaszám:</td>
					<td>50800111-11212841</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Közlemény:</td>
					<td>';if(isset($sor['Nev'])) 
					{ 
						echo$sor['Nev']; 
					} else { 
						echo'IG_NEVED'; 
					}
				echo'</td>';
				echo'</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Utalandó összeg:</td>
					<td>2000 HUF</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Jutalom:</td>
					<td>4000 PrémiumPont</td>
				</tr>
			</table><div style="padding-top: 20px;"></div>';
			echo'<div style="padding-top: 20px;"></div>';
			echo'<font color="red">A hibás utalásokért nem vállalunk felelõsséget! (pl rossz számlaszám, stb..)</font><br>
				<font color="white">Amennyiben hibás közlemény stb.. adtál meg, még korrigálni tudjuk a hibát!<br>
				A banki átutalással megrendelt prémiumpontok 24 órán belül (munkanapokon) kerülnek jóváírásra, vagy bizonylat<br>
				bemutatása ellenében akár 5 órán belül!';
	}
	if(isset($_GET['uarany'])) {
		echo'<h1>ARANY csomag</h1>';
			msg("2", "Utalásnál ennek megfelelõen kell kitölteni az utalási ûrlapot!");
			echo'<table border="1" style="width: 300px;" class="table_border" cellspacing="0" cellpadding="0">
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Név:</td>
					<td>Magyar Krisztián</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Bankszámlaszám:</td>
					<td>50800111-11212841</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Közlemény:</td>
					<td>';if(isset($sor['Nev'])) 
					{ 
						echo$sor['Nev']; 
					} else { 
						echo'IG_NEVED'; 
					}
				echo'</td>';
				echo'</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Utalandó összeg:</td>
					<td>3500 HUF</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Jutalom:</td>
					<td>8000 PrémiumPont</td>
				</tr>
			</table><div style="padding-top: 20px;"></div>';
			echo'<div style="padding-top: 20px;"></div>';
			echo'<font color="red">A hibás utalásokért nem vállalunk felelõsséget! (pl rossz számlaszám, stb..)</font><br>
				<font color="white">Amennyiben hibás közlemény stb.. adtál meg, még korrigálni tudjuk a hibát!<br>
				A banki átutalással megrendelt prémiumpontok 24 órán belül (munkanapokon) kerülnek jóváírásra, vagy bizonylat<br>
				bemutatása ellenében akár 5 órán belül!';
	}
	if(isset($_GET['ugyemant'])) {
		echo'<h1>GYÉMÁNT csomag</h1>';
		msg("2", "Utalásnál ennek megfelelõen kell kitölteni az utalási ûrlapot!");
			echo'<table border="1" style="width: 300px;" class="table_border" cellspacing="0" cellpadding="0">
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Név:</td>
					<td>Magyar Krisztián</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Bankszámlaszám:</td>
					<td>50800111-11212841</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Közlemény:</td>
					<td>';if(isset($sor['Nev'])) 
					{ 
						echo$sor['Nev']; 
					} else { 
						echo'IG_NEVED'; 
					}
				echo'</td>';
				echo'</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Utalandó összeg:</td>
					<td>5000 HUF</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Jutalom:</td>
					<td>16000 PrémiumPont</td>
				</tr>
			</table><div style="padding-top: 20px;"></div>';
			echo'<div style="padding-top: 20px;"></div>';
			echo'<font color="red">A hibás utalásokért nem vállalunk felelõsséget! (pl rossz számlaszám, stb..)</font><br>
				<font color="white">Amennyiben hibás közlemény stb.. adtál meg, még korrigálni tudjuk a hibát!<br>
				A banki átutalással megrendelt prémiumpontok 24 órán belül (munkanapokon) kerülnek jóváírásra, vagy bizonylat<br>
				bemutatása ellenében akár 5 órán belül!';
	}
	if(isset($_GET['bronz'])){
	echo'
		<div style="padding-top: 70px;">
			<h1>Bronz csomag >>> 1500 PrémiumPont</h1>
			<table BORDER="0" style=" width: 600px;" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" style="background-image: url(img/iphone.png); background-repeat: no-repeat; width: 175px; height: 292px; padding-top: 55px;"><div style="padding-left: 20px;">06-90 888-112<br><br>seelife <b>';
					if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
				
				echo '</b></div></td>
					<td valign="top" align="center" style=" width: 400px; padding-top: 20px; padding-right: 10px; padding-left: 10px;"><font color=white>A bronz csomag megrendeléséhez küld a <font color=red>seelife ';
	if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
	echo '</font> szót sms-ben a <font color=red>06-90 888-112</font> telefonszámra.<br><b><font color=red>FONTOS!</font></b> Az SMS elküldésekor a karaktered nem lehet online, különben a rendszer nem írja automatikusan jóvá a prémiumpontokat!</font><br><img src="img/bronz_csomag.jpg"></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="padding-top: 10px;"><p><font color=red>A hibásan elküldött sms-ért nem vállalunk felelõsséget! (pl, rossz prefix, rossz telefonszám)</font><br> Az emelt díjas SMS szolgáltatást biztosítja:
V & Zs 98 Bt
aggregátor: www.szerverem.hu<br>
További információk: (52) 999 337 vagy info@szerverem.hu</p></td>
				</tr>
			</table>
		</div>	
	';
} else if(isset($_GET['ezust'])){
	echo'
		<div style="padding-top: 70px;">
			<h1>Ezüst csomag >>> 3500 PrémiumPont</h1>
			<table BORDER="0" style=" width: 600px;" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" style="background-image: url(img/iphone.png); background-repeat: no-repeat; width: 175px; height: 292px; padding-top: 55px;"><div style="padding-left: 20px;">06-90 888-380<br><br>seelife <b>';
					if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
				
				echo '</b></div></td>
					<td valign="top" align="center" style=" width: 400px; padding-top: 20px; padding-right: 10px; padding-left: 10px;"><font color=white>Az ezüst csomag megrendeléséhez küld a <font color=red>seelife ';
	if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
	echo '</font> szót sms-ben a <font color=red>06-90 888-380</font> telefonszámra.<br><b><font color=red>FONTOS!</font></b> Az SMS elküldésekor a karaktered nem lehet online, különben a rendszer nem írja automatikusan jóvá a prémiumpontokat!</font><br><img src="img/ezust_csomag.jpg"></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="padding-top: 10px;"><p><font color=red>A hibásan elküldött sms-ért nem vállalunk felelõsséget! (pl, rossz prefix, rossz telefonszám)</font><br> Az emelt díjas SMS szolgáltatást biztosítja:
V & Zs 98 Bt
aggregátor: www.szerverem.hu <br>
További információk: (52) 999 337 vagy info@szerverem.hu</p></td>
				</tr>
			</table>
		</div>	
	';
} else if(isset($_GET['arany'])) {
	echo'
		<div style="padding-top: 70px;">
			<h1>Arany csomag >>> 7500 PrémiumPont</h1>
			<table BORDER="0" style=" width: 600px;" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" style="background-image: url(img/iphone.png); background-repeat: no-repeat; width: 175px; height: 292px; padding-top: 55px;"><div style="padding-left: 20px;">06-90 888-405<br><br>seelife <b>';
					if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
				
				echo '</b></div></td>
					<td valign="top" align="center" style=" width: 400px; padding-top: 20px; padding-right: 10px; padding-left: 10px;"><font color=white>Az arany csomag megrendeléséhez küld a <font color=red>seelife ';
	if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
	echo '</font> szót sms-ben a <font color=red>06-90 888-405</font> telefonszámra.<br><b><font color=red>FONTOS!</font></b> Az SMS elküldésekor a karaktered nem lehet online, különben a rendszer nem írja automatikusan jóvá a prémiumpontokat!</font><br><img src="img/arany_csomag.jpg"></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="padding-top: 10px;"><p><font color=red>A hibásan elküldött sms-ért nem vállalunk felelõsséget! (pl, rossz prefix, rossz telefonszám)</font><br> Az emelt díjas SMS szolgáltatást biztosítja:
V & Zs 98 Bt
aggregátor: www.szerverem.hu <br>
További információk: (52) 999 337 vagy info@szerverem.hu</p></td>
				</tr>
			</table>
		</div>	
	';
} else if(isset($_GET['gyemant'])) {
	echo'
		<div style="padding-top: 70px;">
			<h1>Gyémánt csomag >>> 15000 PrémiumPont</h1>
			<table BORDER="0" style=" width: 600px;" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" style="background-image: url(img/iphone.png); background-repeat: no-repeat; width: 175px; height: 292px; padding-top: 55px;"><div style="padding-left: 20px;">06-90 649 648<br><br>seelife <b>';
					if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
				
				echo '</b></div></td>
					<td valign="top" align="center" style=" width: 400px; padding-top: 20px; padding-right: 10px; padding-left: 10px;"><font color=white>A gyémánt csomag megrendeléséhez küld a <font color=red>seelife ';
	if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
	echo '</font> szót sms-ben a <font color=red>06-90 649 648</font> telefonszámra.<br><b><font color=red>FONTOS!</font></b> Az SMS elküldésekor a karaktered nem lehet online, különben a rendszer nem írja automatikusan jóvá a prémiumpontokat!</font><br><img src="img/gyemant_csomag.jpg"></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="padding-top: 10px;"><p><font color=red>A hibásan elküldött sms-ért nem vállalunk felelõsséget! (pl, rossz prefix, rossz telefonszám)</font><br> Az emelt díjas SMS szolgáltatást biztosítja:
V & Zs 98 Bt
aggregátor: www.szerverem.hu <br>
További információk: (52) 999 337 vagy info@szerverem.hu</p></td>
				</tr>
			</table>
		</div>	
	';
};
	echo'<div style="padding-top:100px;"></div>
	<div style="color:red; font-size: 13px; font-weight: bold;"><h1>Figyelem!</h1>
Támogatás esetén a Támogató automatikusan tudomásul veszi,hogy:<br>
1.) A támogatás öncélú, önkéntes jellegû!<br>
2.) A támogatás NEM MENTESÍT a Szerver szabályzatának betartása alól!<br>
3.) A támogatás ellenében a Támogatót jutalom illeti meg.A jutalomról pontos tájékoztatást a támogatási panelen kaphat.<br>
4.) A támogatásra szánt összegek kizárólag a Szerverre fordítódnak, tehát a támogató az összeggel kizárólag a Szerver fejlesztését,és elõrehaladását segíti!<br>
5.) A Szerver nem vállal felelõsséget a támogató által hibásan elküldött támogatások után.<br>
6.) Támogatással kapcsolatos bõvebb információkért,segítségkérésért a <font color="white">benbydikk@gmail.com</font> címre írhatsz!</div>';*/
?>