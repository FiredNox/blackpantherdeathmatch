<?

$auth = $_GET['auth']; //auth lekérése :D
require_once("include/main.php");
Fejlec();

if ($jatekos["Belepve"]) { //session lekérés, mindjárt megnézem itt hogy van :D
//$row_k = mysql_query("SELECT * FROM felhasznalok WHERE id='".$_SESSION['atmeneti']['id']."'") or die(mysql_error());
//$row = mysql_fetch_assoc($row_k);


$sms = array(
	'nevek' => array(),
	'arak' => array(),
	'pont' => array()
);

foreach($config['Kredit']['SMS']['Csomagok'] as $csomag) {
	$sms['nevek'][$csomag['Nev']] = $csomag['Szin'];
	$sms['arak'][] = $csomag['Ara'];
	$sms['pont'][] = $csomag['Kredit'];
	
	$js['sms'][] = $csomag['Ara'];
	$js['smsT'][] = $csomag['Szam'];
}

if(isset($_POST['smsmbevaltas'])) {
if($_POST['smskod1'] && $_POST['smskod2'] && $_POST['smskod3']) {
$code = mysql_real_escape_string($_POST['smskod1']. "-".$_POST['smskod2']. "-" . $_POST['smskod3']);
echo $code;
mysql_select_db("clstest2");
mysql_query("SELECT * FROM `sms` WHERE 1");

$row_k = mysql_query("SELECT * FROM sms WHERE code='".$code."'") or die(mysql_error());
$row_s = mysql_num_rows($row_k); 
if ($row_s > 0) {
$row = mysql_fetch_assoc($row_k);
if($row['code'] == $code) {
if($row['activator'] == "-") {
$now = date("Y-m-d H:i:s");
mysql_query("DELETE FROM sms WHERE code='".$code."'");
mysql_query("INSERT INTO `sms` (number, activator, generated, code, activated) VALUES ('".$number."','".$jatekos['Nev']."','".$row['generated']."','".$code."','".$now."')") or die(mysql_error());
//többi query ide

echo '<h1 style="color:green;">A kódodat sikeresen felhasználtad! Jó játékot!</h1>';
} else {
echo '<h1 style="color:red;">Ezt a kódot már aktiválták!</h1>';
}
} else {
echo '<h1 style="color:red;">Hibás sms kód / telefonszám</h1>'; 
}
} else {
echo '<h1 style="color:red;">Nincs ilyen kód!</h1>';}
} else {
echo '<h1 style="color:red;">Tölts ki minden mezőt!</h1>';
}
}
echo '<center><a href="?p=tamogatas&o=kodjaim"><b style="color:yellow;">SMS kódjaim</b></a> | <a href="?p=tamogatas&type=sms&bevaltas=sms"><b style="color:yellow;">SMS kód beváltás</b></a></center>';
if($_GET['bevaltas'] == "sms") {
$tszam = (strlen($_GET['tszam']) > 1) ? $_GET['tszam'] : '';
$tcode = (strlen($_GET['tcode']) > 1) ? $_GET['tcode'] : '';
echo'<center><form method="POST"><table border="1" cellpadding="1" cellspacing="1" style="width: 500px;">
	<tbody>
		<tr>
			<td>SMS -ben kapott kód</td>
			<td><input size="4" maxlength="4" type="text" name="smskod1" /> - <input size="4" maxlength="4" type="text" name="smskod2" /> - <input size="4" maxlength="4" type="text" name="smskod3" /></td>
		</tr>
	</tbody>
</table>
<input type="submit" name="smsmbevaltas" /></form></center>';
} else {
if($_GET['o'] == "kodjaim") {
echo '<center>
<h1>SMS kódjaid</h1>';
mysql_select_db("clstest2");
$row_k = mysql_query("SELECT * FROM sms WHERE vevo='".$_SESSION['atmeneti']['id']."'" ) or die(mysql_error());
if (mysql_num_rows($row_k) > 0) {
echo '<center><table border="1" cellpadding="1" cellspacing="1" style="width: 500px;">
	<tbody>
		<tr>
			<td>Telefonszam</td>
			<td>SMS kod</td>
			<td>Bevaltotta</td>
			<td>Tipus</td>
			<td>Bevaltas</td>
		</tr>';
		
		$fajta = "Ismeretlen.";
		while($admin = mysql_fetch_array($row_k)){ 
 		if($admin['kat'] == 160) { $fajta = "Bronz"; } else if($admin['kat'] == 252) { $fajta = "Ezüst"; } else if($admin['kat'] == 400) { $fajta = "Arany"; } else if($admin['kat'] == 4000) { $fajta = "Gyémánt"; }
		echo '<tr>
		
			<td>'.$admin['number'].'</td>
			<td><b style="color:yellow;">'.$admin['code'].'</b></td>
			<td>'.$admin['activator'].'</td>
			<td>'.$fajta.'</td>
			<td><a href="?p=tamogatas&type=sms&bevaltas=sms&tszam='.$admin['number'].'&tcode='.$admin['code'].'"><b style="color:yellow">Aktiválás</b></a></td>';

}
echo '</tr></tbody></table></center>';
} else {
echo '<b stlye="color:red;"> Még nincs a nevedre szóló kód.</b>';
}

} else 
if($_GET['type'] == "sms") {

	echo '<table class="tcenter" style="margin-bottom: 20px; width: 80%;"><tr>';
	$w = 100/ count($sms["nevek"]);
	foreach($sms["nevek"] as $n => $c) {
		echo "<td width='$w%'><b style='color: $c'>$n</b></td>";
	}
	
	echo "</tr><tr>";
	
	foreach($sms["arak"] as $p){
		$rp = $p * 1.27;
		echo "<td width='$w%'><b>{$p}Ft + áfa</b> (<span class='realprice'>{$rp}Ft</span>)</td>";
	}
	
	echo "</tr><tr>";
	
	foreach($sms["pont"] as $p){
		$rp = $p * 1.27;
		echo "<td width='$w%'>{$p} kredit</td>";
	}

	echo "</tr><tr>";
	
	foreach($sms["arak"] as $i => $p){
		echo "<td width='$w%'><button class='tamButton' value='$i'>Támogatás</button></td>";
	}
	
	echo '</tr></table>
	
	<div id="ts_bef" style="font-size: 125%; /*min-height: 75px;"></div>
	<br><!-- <hr> --><br>
	
	<center>
		<div align=center style="background-color:#FFFFFF; padding-top: 5px; padding-bottom:5px; border: solid; border-width: 1px; border-color: #616473; font-size:12px; color: #202020; width:600px;">
		A szolgáltatás csak a <font color="#E20074" style="background-color: #FFFFFF"><b>T</b></font><font color="#666666" style="background-color: #FFFFFF">-<b>Mobile</b> </font>, a <font color="#3D3D3D" style="background-color: #FFFFFF"><b style="color: blue">TELENOR</b></font> és a <font color="#FFFFFF" style="background-color: #FF0000"><b>&nbsp;vodafone&nbsp;</b></font> magyarországi hálózatából érhető el.
		</div>

		<br><b style="color: #f55">Kód:</b> A kódot válasz SMSben fogod megkapni.<br>

		<br><b style="color: #f55">Bármilyen nemű támogatás NEM MENTESÍT a szabályzat betartása alól!</b><br>
	
		<br>Az emelt díjas SMS szolgáltatást a V & Zs 98 Bt biztosítja (<a href="http://szerverem.hu">szerverem.hu</a>)
		<br>Aggregátor: szerverem.hu | További információk: (52) 999 337 vagy <span class="marked"><?php echo mailConvert("info@szerverem.hu"); ?></span>
		<br>Ügyfélszolgálati telefonszám: (52) 999 337
		<br><br><b>Hibás SMS esetén, ha hibaüzenetet kapsz vissza, de az adatok korrektek (üzenet, telefonszám),<br> akkor írj egy E-Mailt az <span class="marked"><?php echo mailConvert("info@classrpg.net"); ?></span> címre</b>
	
		<br><br><b style="color:white">Az elrontott SMSeket nem tudjuk javítani!</b>
	
		<br><br><b style="color:white">Az SMS nem téríthető vissza semmilyen esetben, így ha szabálytalankodsz bárhol, bármilyen formában
		<br>és emiatt büntetést / tiltást / törlést kapsz a szerverről, abban az esetben nem tudunk segíteni!</b>
	
	</center>'; 
echo '
<h1>Megrendeléshez küldd a <b style="color:red">classreborn '.$_SESSION['atmeneti']['id'].'</b> szót a <br/><b style="color:red">0690 444 154</b> -es telefonszámra</h1></center>';
if($_GET['csomag'] == "bronz") {
} else if($_GET['csomag'] == "silver") {

//echo '<h2>Támogatásod: '+tam.sms[i]+'Ft</h2>A támogatás befejezéséhez küld el a <span class="marked">classrpg</span> szót a <span id="f_tel" class="marked">'+tam.smsT[i]+'</span> telefonszámra.<br>A válasz SMSben kapott kódot a Támogatás lapon a Beváltás képre kattintva válthatod be.';

} else if($_GET['csomag'] == "gold") {

} else if($_GET['csomag'] == "platina") {

}
} else { 
echo '
	<center><a href="?p=tamogatas&type=sms"><img src="./design_files/d_sms.png" height="150" id="t_sms" class="kez"></a></center>'; } 
}
} else {
	Fejlec();
	echo Felhivas("Nem vagy belépve");
	exit;
}
Lablec();
?>