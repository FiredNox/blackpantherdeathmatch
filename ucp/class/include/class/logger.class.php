<?php
#########################
### OSZTÁLY :: LOGGER ###
#########################

class Logger {
	private $file, $ip;
	
	public function __construct($file) {
		$this -> file = 'logs/' . $file . '.log';
		$this -> ip = $this -> GetIP();
	}
	
	public function log($entry) {
		$file = fopen($this -> file, 'a');
		fwrite($file, '[' . date('Y-m-d H:i:s') . '][' . $this -> GetIP() . ']' . $entry . PHP_EOL);
		fclose($file);
	}
	
	public function GetIP()
	{
		if(!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
			return $_SERVER['HTTP_CLIENT_IP'];
		elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			return $_SERVER['REMOTE_ADDR'];
	}
}

?>