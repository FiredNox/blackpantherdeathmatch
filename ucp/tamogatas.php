<?php
msg("4", "A Támogatási rendszer ideiglenesen nem elérhető!");

/*	echo'<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&hunsms\';">SMS <font style="font-weight: normal;  font-style: italic">(HUN)</font></div></td>
				<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&kulfsms\';">SMS <font style="font-weight: normal; font-style: italic">(International)</font></div></td>
				<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&utalas\';">BANK CARD</div></td>
			</tr>
		</table>';
	echo'<div style="padding-top: 20px;"></div>';
	if(isset($_GET['hunsms'])) {
	echo '<h1><font color="green"> MAGYAR</font> SMS TÁMOGATÁS CSOMAGOK</h1>
			<table border="0" style="padding-top: 20px;" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&bronz\';">Bronz 400 FT (+ÁFA)</div></td>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&ezust\';">Ezüst 800 FT (+ÁFA)</div></td>
				</tr>
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&arany\';">Arany 1600 FT (+ÁFA)</div></td>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&gyemant\';">Gyémánt 4000 FT (+ÁFA)</div></td>
				</tr>
			</table>';
	}
	if(isset($_GET['kulfsms'])) {
		echo'<h1><font color="green"> KŰLFÖLDI</font> SMS TÁMOGATÁS CSOMAGOK</h1>
			<table border="0" style="padding-top: 20px;" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&romania\';">Románia (2 EUR + ÁFA)</div></td>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&ukrajna\';">Ukrajna (16 UAH ÁFA-val)</div></td>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&szlovakia\';">Szlovákia (1 EUR + ÁFA)</div></td>
				</tr>
			</table>';
	}
	if(isset($_GET['romania'])) {
		echo'
		<div style="padding-top: 70px;">
			<h1>Romániai sms támogatás >>> 1000 prémiumpont</h1>
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
					<td valign="top" align="center" style=" width: 400px; padding-top: 20px; padding-right: 10px; padding-left: 10px;"><font color=white>Romániából való prémiumpont rendeléshez küld a <font color=red>srv seelife ';
	if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
	echo '</font> sz�t sms-ben a <font color=red>1314</font> telefonsz�mra.<br><b><font color=red>FONTOS!</font></b> Az SMS elk�ld�sekor a karaktered nem lehet online, k�l�nben a rendszer nem �rja automatikusan j�v� a pr�miumpontokat!</font><br><img src="img/romania.gif"></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="padding-top: 10px;"><p><font color=red>A hib�san elk�ld�tt sms-�rt nem v�llalunk felel�ss�get! (pl, rossz prefix, rossz telefonsz�m)</font><br> Az emelt d�jas SMS szolg�ltat�st biztos�tja:
V & Zs 98 Bt
aggreg�tor: www.szerverem.hu<br>
Tov�bbi inform�ci�k: (52) 999 337 vagy info@szerverem.hu</p></td>
				</tr>
			</table>
		</div>	
	';
	}
	if(isset($_GET['ukrajna'])) {
		echo'
		<div style="padding-top: 70px;">
			<h1>Ukrajnai sms t�mogat�s >>> 1000 pr�miumpont</h1>
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
					<td valign="top" align="center" style=" width: 400px; padding-top: 20px; padding-right: 10px; padding-left: 10px;"><font color=white>Ukrajn�b�l val� pr�miumpont rendel�shez k�ld a <font color=red>srv seelife ';
	if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
	echo '</font> sz�t sms-ben a <font color=red>4449</font> telefonsz�mra.<br><b><font color=red>FONTOS!</font></b> Az SMS elk�ld�sekor a karaktered nem lehet online, k�l�nben a rendszer nem �rja automatikusan j�v� a pr�miumpontokat!</font><br><img src="img/ukrajna.jpg"></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="padding-top: 10px;"><p><font color=red>A hib�san elk�ld�tt sms-�rt nem v�llalunk felel�ss�get! (pl, rossz prefix, rossz telefonsz�m)</font><br> Az emelt d�jas SMS szolg�ltat�st biztos�tja:
V & Zs 98 Bt
aggreg�tor: www.szerverem.hu<br>
Tov�bbi inform�ci�k: (52) 999 337 vagy info@szerverem.hu</p></td>
				</tr>
			</table>
		</div>	
	';
	}
	if(isset($_GET['szlovakia'])) {
		echo'
		<div style="padding-top: 70px;">
			<h1>Szlov�kiai sms t�mogat�s >>> 500 pr�miumpont</h1>
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
					<td valign="top" align="center" style=" width: 400px; padding-top: 20px; padding-right: 10px; padding-left: 10px;"><font color=white>Szlov�ki�b�l val� pr�miumpont rendel�shez k�ld a <font color=red>srv seelife ';
	if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
	echo '</font> sz�t sms-ben a <font color=red>7771</font> telefonsz�mra.<br><b><font color=red>FONTOS!</font></b> Az SMS elk�ld�sekor a karaktered nem lehet online, k�l�nben a rendszer nem �rja automatikusan j�v� a pr�miumpontokat!</font><br><img src="img/szlovakia.jpg"></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="padding-top: 10px;"><p><font color=red>A hib�san elk�ld�tt sms-�rt nem v�llalunk felel�ss�get! (pl, rossz prefix, rossz telefonsz�m)</font><br> Az emelt d�jas SMS szolg�ltat�st biztos�tja:
V & Zs 98 Bt
aggreg�tor: www.szerverem.hu<br>
Tov�bbi inform�ci�k: (52) 999 337 vagy info@szerverem.hu</p></td>
				</tr>
			</table>
		</div>	
	';
	}
	if(isset($_GET['utalas'])) {
		echo'<h1>BANKI �TUTAL�S PR�MIUM CSOMAGOK</h1>
			<table border="0" style="padding-top: 20px;" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&ubronz\';">BRONZ (1000FT)</div></td>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&uezust\';">EZ�ST (2000FT)</div></td>
				</tr>
				<tr>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&uarany\';">ARANY (3500FT)</div></td>
					<td style="padding-right: 5px;" align="center"><div class="subnav_gomb" style="font-weight: bold;" onclick="window.location.href=\'index.php?menu=tamogatas&ugyemant\';">GY�M�NT (5000FT)</div></td>
				</tr>
			</table>';
	} //Bronz 3000pp, ez�st 4000, arany 8000pp, gy�m�nt 16000
	if(isset($_GET['ubronz'])) {
		echo'<h1>BRONZ csomag</h1>';
		msg("2", "Utal�sn�l ennek megfelel�en kell kit�lteni az utal�si �rlapot!");
			echo'<table border="1" style="width: 300px;" class="table_border" cellspacing="0" cellpadding="0">
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>N�v:</td>
					<td>Magyar Kriszti�n</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Banksz�mlasz�m:</td>
					<td>50800111-11212841</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>K�zlem�ny:</td>
					<td>';if(isset($sor['Nev'])) 
					{ 
						echo$sor['Nev']; 
					} else { 
						echo'IG_NEVED'; 
					}
				echo'</td>';
				echo'</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Utaland� �sszeg:</td>
					<td>1000 HUF</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Jutalom:</td>
					<td>3000 Pr�miumPont</td>
				</tr>
			</table><div style="padding-top: 20px;"></div>';
			echo'<div style="padding-top: 20px;"></div>';
			echo'<font color="red">A hib�s utal�sok�rt nem v�llalunk felel�ss�get! (pl rossz sz�mlasz�m, stb..)</font><br>
				<font color="white">Amennyiben hib�s k�zlem�ny stb.. adt�l meg, m�g korrig�lni tudjuk a hib�t!<br>
				A banki �tutal�ssal megrendelt pr�miumpontok 24 �r�n bel�l (munkanapokon) ker�lnek j�v��r�sra, vagy bizonylat<br>
				bemutat�sa ellen�ben ak�r 5 �r�n bel�l!';
	}
	if(isset($_GET['uezust'])) {
		echo'<h1>EZ�ST csomag</h1>';
			msg("2", "Utal�sn�l ennek megfelel�en kell kit�lteni az utal�si �rlapot!");
			echo'<table border="1" style="width: 300px;" class="table_border" cellspacing="0" cellpadding="0">
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>N�v:</td>
					<td>Magyar Kriszti�n</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Banksz�mlasz�m:</td>
					<td>50800111-11212841</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>K�zlem�ny:</td>
					<td>';if(isset($sor['Nev'])) 
					{ 
						echo$sor['Nev']; 
					} else { 
						echo'IG_NEVED'; 
					}
				echo'</td>';
				echo'</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Utaland� �sszeg:</td>
					<td>2000 HUF</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Jutalom:</td>
					<td>4000 Pr�miumPont</td>
				</tr>
			</table><div style="padding-top: 20px;"></div>';
			echo'<div style="padding-top: 20px;"></div>';
			echo'<font color="red">A hib�s utal�sok�rt nem v�llalunk felel�ss�get! (pl rossz sz�mlasz�m, stb..)</font><br>
				<font color="white">Amennyiben hib�s k�zlem�ny stb.. adt�l meg, m�g korrig�lni tudjuk a hib�t!<br>
				A banki �tutal�ssal megrendelt pr�miumpontok 24 �r�n bel�l (munkanapokon) ker�lnek j�v��r�sra, vagy bizonylat<br>
				bemutat�sa ellen�ben ak�r 5 �r�n bel�l!';
	}
	if(isset($_GET['uarany'])) {
		echo'<h1>ARANY csomag</h1>';
			msg("2", "Utal�sn�l ennek megfelel�en kell kit�lteni az utal�si �rlapot!");
			echo'<table border="1" style="width: 300px;" class="table_border" cellspacing="0" cellpadding="0">
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>N�v:</td>
					<td>Magyar Kriszti�n</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Banksz�mlasz�m:</td>
					<td>50800111-11212841</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>K�zlem�ny:</td>
					<td>';if(isset($sor['Nev'])) 
					{ 
						echo$sor['Nev']; 
					} else { 
						echo'IG_NEVED'; 
					}
				echo'</td>';
				echo'</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Utaland� �sszeg:</td>
					<td>3500 HUF</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Jutalom:</td>
					<td>8000 Pr�miumPont</td>
				</tr>
			</table><div style="padding-top: 20px;"></div>';
			echo'<div style="padding-top: 20px;"></div>';
			echo'<font color="red">A hib�s utal�sok�rt nem v�llalunk felel�ss�get! (pl rossz sz�mlasz�m, stb..)</font><br>
				<font color="white">Amennyiben hib�s k�zlem�ny stb.. adt�l meg, m�g korrig�lni tudjuk a hib�t!<br>
				A banki �tutal�ssal megrendelt pr�miumpontok 24 �r�n bel�l (munkanapokon) ker�lnek j�v��r�sra, vagy bizonylat<br>
				bemutat�sa ellen�ben ak�r 5 �r�n bel�l!';
	}
	if(isset($_GET['ugyemant'])) {
		echo'<h1>GY�M�NT csomag</h1>';
		msg("2", "Utal�sn�l ennek megfelel�en kell kit�lteni az utal�si �rlapot!");
			echo'<table border="1" style="width: 300px;" class="table_border" cellspacing="0" cellpadding="0">
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>N�v:</td>
					<td>Magyar Kriszti�n</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Banksz�mlasz�m:</td>
					<td>50800111-11212841</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>K�zlem�ny:</td>
					<td>';if(isset($sor['Nev'])) 
					{ 
						echo$sor['Nev']; 
					} else { 
						echo'IG_NEVED'; 
					}
				echo'</td>';
				echo'</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Utaland� �sszeg:</td>
					<td>5000 HUF</td>
				</tr>
				<tr style="height: 30px; font-size: 14px; color: #FFFFFF;" align="center">
					<td>Jutalom:</td>
					<td>16000 Pr�miumPont</td>
				</tr>
			</table><div style="padding-top: 20px;"></div>';
			echo'<div style="padding-top: 20px;"></div>';
			echo'<font color="red">A hib�s utal�sok�rt nem v�llalunk felel�ss�get! (pl rossz sz�mlasz�m, stb..)</font><br>
				<font color="white">Amennyiben hib�s k�zlem�ny stb.. adt�l meg, m�g korrig�lni tudjuk a hib�t!<br>
				A banki �tutal�ssal megrendelt pr�miumpontok 24 �r�n bel�l (munkanapokon) ker�lnek j�v��r�sra, vagy bizonylat<br>
				bemutat�sa ellen�ben ak�r 5 �r�n bel�l!';
	}
	if(isset($_GET['bronz'])){
	echo'
		<div style="padding-top: 70px;">
			<h1>Bronz csomag >>> 1500 Pr�miumPont</h1>
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
					<td valign="top" align="center" style=" width: 400px; padding-top: 20px; padding-right: 10px; padding-left: 10px;"><font color=white>A bronz csomag megrendel�s�hez k�ld a <font color=red>seelife ';
	if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
	echo '</font> sz�t sms-ben a <font color=red>06-90 888-112</font> telefonsz�mra.<br><b><font color=red>FONTOS!</font></b> Az SMS elk�ld�sekor a karaktered nem lehet online, k�l�nben a rendszer nem �rja automatikusan j�v� a pr�miumpontokat!</font><br><img src="img/bronz_csomag.jpg"></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="padding-top: 10px;"><p><font color=red>A hib�san elk�ld�tt sms-�rt nem v�llalunk felel�ss�get! (pl, rossz prefix, rossz telefonsz�m)</font><br> Az emelt d�jas SMS szolg�ltat�st biztos�tja:
V & Zs 98 Bt
aggreg�tor: www.szerverem.hu<br>
Tov�bbi inform�ci�k: (52) 999 337 vagy info@szerverem.hu</p></td>
				</tr>
			</table>
		</div>	
	';
} else if(isset($_GET['ezust'])){
	echo'
		<div style="padding-top: 70px;">
			<h1>Ez�st csomag >>> 3500 Pr�miumPont</h1>
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
					<td valign="top" align="center" style=" width: 400px; padding-top: 20px; padding-right: 10px; padding-left: 10px;"><font color=white>Az ez�st csomag megrendel�s�hez k�ld a <font color=red>seelife ';
	if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
	echo '</font> sz�t sms-ben a <font color=red>06-90 888-380</font> telefonsz�mra.<br><b><font color=red>FONTOS!</font></b> Az SMS elk�ld�sekor a karaktered nem lehet online, k�l�nben a rendszer nem �rja automatikusan j�v� a pr�miumpontokat!</font><br><img src="img/ezust_csomag.jpg"></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="padding-top: 10px;"><p><font color=red>A hib�san elk�ld�tt sms-�rt nem v�llalunk felel�ss�get! (pl, rossz prefix, rossz telefonsz�m)</font><br> Az emelt d�jas SMS szolg�ltat�st biztos�tja:
V & Zs 98 Bt
aggreg�tor: www.szerverem.hu <br>
Tov�bbi inform�ci�k: (52) 999 337 vagy info@szerverem.hu</p></td>
				</tr>
			</table>
		</div>	
	';
} else if(isset($_GET['arany'])) {
	echo'
		<div style="padding-top: 70px;">
			<h1>Arany csomag >>> 7500 Pr�miumPont</h1>
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
					<td valign="top" align="center" style=" width: 400px; padding-top: 20px; padding-right: 10px; padding-left: 10px;"><font color=white>Az arany csomag megrendel�s�hez k�ld a <font color=red>seelife ';
	if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
	echo '</font> sz�t sms-ben a <font color=red>06-90 888-405</font> telefonsz�mra.<br><b><font color=red>FONTOS!</font></b> Az SMS elk�ld�sekor a karaktered nem lehet online, k�l�nben a rendszer nem �rja automatikusan j�v� a pr�miumpontokat!</font><br><img src="img/arany_csomag.jpg"></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="padding-top: 10px;"><p><font color=red>A hib�san elk�ld�tt sms-�rt nem v�llalunk felel�ss�get! (pl, rossz prefix, rossz telefonsz�m)</font><br> Az emelt d�jas SMS szolg�ltat�st biztos�tja:
V & Zs 98 Bt
aggreg�tor: www.szerverem.hu <br>
Tov�bbi inform�ci�k: (52) 999 337 vagy info@szerverem.hu</p></td>
				</tr>
			</table>
		</div>	
	';
} else if(isset($_GET['gyemant'])) {
	echo'
		<div style="padding-top: 70px;">
			<h1>Gy�m�nt csomag >>> 15000 Pr�miumPont</h1>
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
					<td valign="top" align="center" style=" width: 400px; padding-top: 20px; padding-right: 10px; padding-left: 10px;"><font color=white>A gy�m�nt csomag megrendel�s�hez k�ld a <font color=red>seelife ';
	if(isset($sor['Nev'])) 
	{ 
		echo$sor['Nev']; 
	} else { 
		echo'IG_NEVED'; 
	}
	echo '</font> sz�t sms-ben a <font color=red>06-90 649 648</font> telefonsz�mra.<br><b><font color=red>FONTOS!</font></b> Az SMS elk�ld�sekor a karaktered nem lehet online, k�l�nben a rendszer nem �rja automatikusan j�v� a pr�miumpontokat!</font><br><img src="img/gyemant_csomag.jpg"></td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="padding-top: 10px;"><p><font color=red>A hib�san elk�ld�tt sms-�rt nem v�llalunk felel�ss�get! (pl, rossz prefix, rossz telefonsz�m)</font><br> Az emelt d�jas SMS szolg�ltat�st biztos�tja:
V & Zs 98 Bt
aggreg�tor: www.szerverem.hu <br>
Tov�bbi inform�ci�k: (52) 999 337 vagy info@szerverem.hu</p></td>
				</tr>
			</table>
		</div>	
	';
};
	echo'<div style="padding-top:100px;"></div>
	<div style="color:red; font-size: 13px; font-weight: bold;"><h1>Figyelem!</h1>
T�mogat�s eset�n a T�mogat� automatikusan tudom�sul veszi,hogy:<br>
1.) A t�mogat�s �nc�l�, �nk�ntes jelleg�!<br>
2.) A t�mogat�s NEM MENTES�T a Szerver szab�lyzat�nak betart�sa al�l!<br>
3.) A t�mogat�s ellen�ben a T�mogat�t jutalom illeti meg.A jutalomr�l pontos t�j�koztat�st a t�mogat�si panelen kaphat.<br>
4.) A t�mogat�sra sz�nt �sszegek kiz�r�lag a Szerverre ford�t�dnak, teh�t a t�mogat� az �sszeggel kiz�r�lag a Szerver fejleszt�s�t,�s el�rehalad�s�t seg�ti!<br>
5.) A Szerver nem v�llal felel�ss�get a t�mogat� �ltal hib�san elk�ld�tt t�mogat�sok ut�n.<br>
6.) T�mogat�ssal kapcsolatos b�vebb inform�ci�k�rt,seg�ts�gk�r�s�rt a <font color="white">benbydikk@gmail.com</font> c�mre �rhatsz!</div>';*/
?>