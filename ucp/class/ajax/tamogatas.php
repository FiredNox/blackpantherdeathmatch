<?php
$a = isset($_POST['a']) ? $_POST['a'] : false;
$data = isset($_POST['data']) ? $_POST['data'] : false;

if(!$a) die;

//define('MAIN_SKIP_CHECK', 1);
$_extramezok = array('Kredit');
require_once("include/main.php");

$ret = array();

require_once($config["Path"]["class"] . "/donate.class.php");

$deltaurl = 'http://ucp.classrpg.net/delta/';
function DoButton($method, $data)
{
	if($method !== 'generate' || !isset($data['amount']))
		return FALSE;

	$params = array();
	$params[] = 'button';
	$params[] = 'method=' . $method;
	foreach($data as $key => $value)
		$params[] = $key . '=' . $value;

	global $deltaurl;
	$url = $deltaurl . '?' . implode('&', $params);
	$json = file_get_contents($url);
	$data = json_decode($json, TRUE);
	if($data === NULL || !isset($data['success']) || $data['success'] !== TRUE || !isset($data['code']))
		return FALSE;

	return $data['code'];
}

if($a == 'paypal_generate' && is_numeric($data['price']) && $data['price'] >= 1000 && $data['price'] <= 15000 && $data['price'] % 100 == 0)
{
	$buttonCode = DoButton('generate', array('amount' => $data['price']));
	if($buttonCode === FALSE)
		die(json_encode(array('success' => FALSE, 'error' => 1001)));
	
	$ret['success'] = TRUE;
	$ret['buttonCode'] = $buttonCode;
}
else if($a == 'bevalt' && $data && isset($data['type'], $data['kod'], $data['address'], $data['karakter']) && $jatekos['Karakterek'] >= ($data['karakter']+1))
{
	$type = $data['type'];
	$kod = $mysql -> escape($data['kod']);
	$address = $mysql -> escape($data['address']);
	$karakter = ($data['karakter'] == 0 ? 0 : 1);
	
	if($jatekos['Karakter'][$karakter]['Online']) {
		$ret['msg'] = 'A karakter jelenleg online, előbb lépj ki a játékból';
	} else {
		$smsdata = array(
			'type' => $type,
			'address' => $address,
			'code' => $kod,
		);

		if($sret = $_don -> DoSMS('check', $smsdata)) {
			$kredit = $_don -> finalCreditFromPrice($type, $sret['price']);
			
			if($kredit < 1)
				$ret['msg'] = 'Hiba #0';
			else
			{
				$newkredit = $kredit + $jatekos['Karakter'][$karakter]['Kredit'];
				$mysql -> update('playerek', array('Kredit' => $newkredit ), 'ID="'.$jatekos['Karakter'][$karakter]['ID'].'" AND Online="0"');
				
				if(!$mysql -> affected()) {
					$ret['msg'] = 'Hiba #1';
				} else {
					$smsdata = array_merge($smsdata, array(
						'user' => $jatekos['Karakter'][$karakter]['ID'],
						'username' => $jatekos['Karakter'][$karakter]['Nev'],
						'userip' => $_SERVER['REMOTE_ADDR']
					));
					
					if($_don -> DoSMS('use', $smsdata))
						$ret['msg'] = "Sikeres beváltás - Jutalmad: $kredit kredit";
					else
					{
						$ret['msg'] = 'Hiba #2';
						$mysql -> update('playerek', array('Kredit' => $newkredit - $kredit ), 'ID="'.$jatekos['Karakter'][$karakter]['ID'].'" AND Online="0"');
					}
				}
			}
		} else {
			$ret['msg'] = 'Hibás adatok vagy már fel lett használva';
		}
	}
}

die(json_encode($ret));

?>