<?php
############################
### OSZTÁLY :: TÁMOGATÁS ###
############################

class Donate
{
	private $smsurl = 'http://ucp.classrpg.net/delta/';
	
	public function DoSMS($method, $data)
	{
		$smsurl = $this -> smsurl;
		
		if($method == 'check' || $method == 'unuse')
		{
			if(!is_array($data) || count($data) != 3 || !isset($data['type'], $data['address'], $data['code']))
				return FALSE;
		}
		else if($method == 'use')
		{
			if(!is_array($data) || count($data) != 6 || !isset($data['type'], $data['address'], $data['code'], $data['user'], $data['username'], $data['userip']))
				return FALSE;
		}
		else
			return FALSE;
		
		$params = array();
		$params[] = 'code';
		$params[] = 'method=' . $method;
		foreach($data as $key => $value)
			$params[] = $key . '=' . $value;
		
		$url = $smsurl . '?' . implode('&', $params);
		$json = file_get_contents($url);
		$data = json_decode($json, TRUE);
		if($data === NULL || !isset($data['success']) || $data['success'] !== TRUE)
			return FALSE;
		
		return $data;
	}
	
	public function finalCreditFromPrice($type, $price) {
		global $config;
		
		if($type == 'paypal')
		{
			$bonus = 0;
			foreach($config['Kredit']['PayPal']['Csomagok'] as $csomag) {
				if($csomag['Min'] <= $price && $bonus < $csomag['Bonus']) {
					$bonus = $csomag['Bonus'];
				}
			}
			
			return ($price * ((100 + $bonus) / 100));
		}
		else if($type == 'sms')
		{
			foreach($config['Kredit']['SMS']['Csomagok'] as $csomag) {
				if($csomag['Ara'] == $price)
					return $csomag['Kredit'];
			}
		}
		
		return 0;
	}
}

$_don = new Donate;
?>