<?
#########################
### OSZTÁLY :: REMOTE ###
#########################

class Remote
{

	private $url = "", $timeout = 10, $return = 1;

	public function setURL( $url )
	{
		$this -> url = $url;
	}

	public function get()
	{
		if(!isset($this->url)) return "!";
		if(strpos($this->url, "http://") === false) return "?";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, $this->return);
		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}

}

$_rem = new Remote();

?>