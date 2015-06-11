<?php
require_once('include/main.php');
Fejlec();

if(isset($_GET['ok'])) {
	echo '<center><h1>Támogatás</h1>';
	echo '<b>Köszönjük támogatásodat, amint feldolgozásra kerül, kapni fogsz egy emailt, benne a kódoddal</b>';
	echo '</center>';
	Lablec();
	exit();
} elseif(isset($_GET['cancel'])) {
	echo '<center><h1>Támogatás</h1>';
	echo '<b>Támogatásod megszakítva</b>';
	echo '</center>';
	Lablec();
	exit();
}

//if(!$jatekos["Belepve"])
//	Error();

$js = array(
	'sms' => array(),
	'smsT' => array(),
	'pp' => array($config['Kredit']['PayPal']['Min'], $config['Kredit']['PayPal']['Max']),
	'ppb' => array()
);

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

$paypal = array(
	'min' => $config['Kredit']['PayPal']['Min'],
	'max' => $config['Kredit']['PayPal']['Max'],
	'nevek' => array(),
	'bonus' => array()
);

foreach($config['Kredit']['PayPal']['Csomagok'] as $csomag) {
	$paypal['nevek'][$csomag['Nev']] = $csomag['Szin'];
	$paypal['bonus'][] = array($csomag['Min'], $csomag['Bonus']);
	
	if($csomag['Bonus'] > 0)
		$js['ppb'][] = array($csomag['Min'], $csomag['Bonus']);
}

echo '<script>var tam = ' . json_encode($js) . ';</script>';
?>

<script type="text/javascript" src="js/tamogatas.js"></script>
<style type="text/css">

div.tamogatas span.leiras { font-size: 15px; }
div.tamogatas h2 { font-size: 25px; }
div.tmenu { margin-bottom: 10px; display: inline-block; }

</style>

<center><h1>Támogatás</h1>

<div id="m_sms" class="tmenu link">SMS</div>
 | <div id="m_paypal" class="tmenu link">PayPal</div>
 | <div id="m_bevalt" class="tmenu link">Beváltás</div>

<div id="p_type" style="display: none">
	<img src="img/d_sms.png" height="150" id="t_sms" class="kez">
	<img src="img/d_paypal.png" height="150" id="t_paypal" class="kez">
	<img src="img/d_bevalt.png" height="150" id="t_bevalt" class="kez">
</div>

<div id="p_sms" style="display: none">
	<?php if($config['Tamogatas']): ?>
	<h2>SMS támogatás</h2>
	Az SMS támogatás menete egyszerű,<br>
	csupán el kell küldened egy szót a megfelelő telefonszámra,<br>
	majd a válaszban kapott kódot beváltva máris érvényesítheted a támogatásodat.<br>
	<br>
	
	<table class="tcenter" style="margin-bottom: 20px; width: 80%;"><tr>
	<?php
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
	
	?>
	</tr></table>
	
	<div id="ts_bef" style="font-size: 125%; /*min-height: 75px;*/"></div>
	
	<br><!-- <hr> --><br>
	
	<center>
		<div align=center style="background-color:#FFFFFF; padding-top: 5px; padding-bottom:5px; border: solid; border-width: 1px; border-color: #616473; font-size:12px; color: #202020; width:600px;">
		A szolgáltatás csak a <font color="#E20074" style="background-color: #FFFFFF"><b>T</b></font><font color="#666666" style="background-color: #FFFFFF">-<b>Mobile</b> </font>, a <font color="#3D3D3D" style="background-color: #FFFFFF"><b style='color: blue'>TELENOR</b></font> és a <font color="#FFFFFF" style="background-color: #FF0000"><b>&nbsp;vodafone&nbsp;</b></font> magyarországi hálózatából érhető el.
		</div>

		<br><b style='color: #f55'>Kód:</b> A kódot válasz SMSben fogod megkapni.<br>

		<br><b style='color: #f55'>Bármilyen nemű támogatás NEM MENTESÍT a szabályzat betartása alól!</b><br>
	
		<br>Az emelt díjas SMS szolgáltatást a V & Zs 98 Bt biztosítja (<a href='http://szerverem.hu'>szerverem.hu</a>)
		<br>Aggregátor: szerverem.hu | További információk: (52) 999 337 vagy <span class="marked"><?php echo mailConvert("info@szerverem.hu"); ?></span>
		<br>Ügyfélszolgálati telefonszám: (52) 999 337
		<br><br><b>Hibás SMS esetén, ha hibaüzenetet kapsz vissza, de az adatok korrektek (üzenet, telefonszám),<br> akkor írj egy E-Mailt az <span class="marked"><?php echo mailConvert("info@classrpg.net"); ?></span> címre</b>
	
		<br><br><b style='color:white'>Az elrontott SMSeket nem tudjuk javítani!</b>
	
		<br><br><b style='color:white'>Az SMS nem téríthető vissza semmilyen esetben, így ha szabálytalankodsz bárhol, bármilyen formában
		<br>és emiatt büntetést / tiltást / törlést kapsz a szerverről, abban az esetben nem tudunk segíteni!</b>
	
	</center>
	<?php else: ?>
		<i>A támogatás jelenleg szünetel</i>
	<?php endif ?>
</div>

<div id="p_paypal" style="display: none">
	<?php if($config['Tamogatas']): ?>
	<h2>PayPal támogatás</h2>
	A PayPal egy internetes bank, melyen keresztül lehetőséged van többféle módon<br>
	is támogatni minket, többek között banki átutalással és bankkártyával is.<br>
	<br>
	<a href="http://<?=$config["WNev"]?>">PayPal támogatáshoz útmutató</a><br>
	<br>
	
	<table class="tcenter" style="margin-bottom: 20px; width: 85%;"><tr>
	
	<?php
		$w = 85 / count($sms["nevek"]);
		
		echo "<td width='15%' class='clear'></td>";
		foreach($sms["nevek"] as $n => $c) {
			echo "<td width='$w%'><b style='color: $c'>$n</b></td>";
		}
		
		echo "</tr><tr>";
		
		$db = count($paypal["nevek"]);
		
		echo "<td><b>Összeg (Ft)</b></td>";
		for($x = 0; $x < $db; $x++) {
			$bonus = $paypal["bonus"][$x];
			$min = ($bonus[0] == 0 ? $paypal['min'] : $bonus[0]);
			$max = ($x == ($db-1) ? $paypal['max'] : $paypal['bonus'][$x+1][0] - 1);

			echo "<td width='$w%'>{$min} - {$max}</td>";
		}
		
		echo "</tr><tr>";
		
		echo "<td><b>Bónusz (%)</b></td>";
		for($x = 0; $x < $db; $x++) {
			$bonus = $paypal["bonus"][$x][1];
		
			echo "<td width='$w%'>".($bonus ? "+$bonus%" : "")."</td>";
		}

	?>
	
	</tr></table>
	
	<br>
	
	<div style="width: 500px">
		<div id="p_paypal_price_c"></div>
		<span style="float: left">1,000Ft</span>
		<span style="float: right">15,000Ft</span>
	</div>
	
	<div id="tp_bef" style="clear: both">
		<h2>Támogatásod: <span id="p_paypal_price"></span>Ft</h2>
		<h3><b style='color: yellow'>Kredit:</b> <span id="p_paypal_reward"></span></h3>
		<br>
		<div id="tp_bef_a">
			A támogatás befejezéséhez kattints az alábbi gombra:<br><br>
			<input type="button" id="start_paypal" value="Támogatás">
		</div>
	</div>

	<br><br><b style='color: #f55'>Kód:</b> A kódot a PayPal email címedre fogjuk elküldeni.<br>
	<br><b style='color: #f55'>Bármilyen nemű támogatás NEM MENTESÍT a szabályzat betartása alól!</b><br>

	<br><b style='color:white'>Az elrontott támogatásokat nem tudjuk javítani!</b>

	<br><br><b style='color:white'>Az támogatás nem téríthető vissza semmilyen esetben, így ha szabálytalankodsz bárhol, bármilyen formában
	<br>és emiatt büntetést / tiltást / törlést kapsz a szerverről, abban az esetben nem tudunk segíteni!</b>
	
	<?php else: ?>
		<i>A támogatás jelenleg szünetel</i>
	<?php endif ?>
</div>

<div id="p_bevalt" style="display: none">
<?php if($jatekos['Karakterek']) {?>
	<div id="b_types" style="margin-bottom: 10px">
		<input type="radio" id="b_sms" name="b_type" checked="checked"><label for="b_sms">SMS</label>
		<input type="radio" id="b_paypal" name="b_type"><label for="b_paypal">PayPal</label>
	</div>
	
	<input type="text" id="b_kod_a" size="4" maxlength="4">
	 - <input type="text" id="b_kod_b" size="4" maxlength="4">
	 - <input type="text" id="b_kod_c" size="4" maxlength="4">
	 
	<br><br>
	 
	<div id="b_sms_v">Telefonszám: 
		<select id="b_sms_number_k"><option>20</option><option>30</option><option>70</option></select>
		<input type="text" id="b_sms_number_s" size="7" maxlength="7">
	</div>
	<div id="b_paypal_v" style="display: none">PayPal cím: <input type="text" id="b_paypal_address" value="nev@szolgaltato.com"></div>
	
	<br>
	
	Karakter: <select id="b_paypal_k">
	<?php
		echo '<option value="0">'.$jatekos['Karakter'][0]['Nev'].'</option>';
		if($jatekos['Karakterek'] >= 2)
			echo '<option value="1">'.$jatekos['Karakter'][1]['Nev'].'</option>';
	?>
	</select>
	
	<br><br>
	 
	<input type="button" id="b_start" value="Beváltás">
<?php } else { ?>
	A felhasználódon nincs egy karakter sem
<?php } ?>
</div>

</center>

<? Lablec(); ?>