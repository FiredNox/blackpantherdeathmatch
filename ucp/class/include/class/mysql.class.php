<?

class MySQL
{
	public $link, $connected, $lastResult, $lastID;
	private $connectData;

	public function __construct($host = null, $user = null, $pass = null, $db = null)
	{
		global $config;

		if($host == null) $host = $config["SQL"]["Host"];
		if($user == null) $user = $config["SQL"]["User"];
		if($pass == null) $pass = $config["SQL"]["Pass"];
		if($db   == null) $db   = $config["SQL"]["DB"];
		
		$this -> connectData = array("Host" => $host, "User" => $user, "Pass" => $pass, "DB" => $db);

		$this -> link = mysql_connect($host, $user, $pass);
		mysql_select_db( $db );

		if($this -> link)
		{
			$this -> query('set names utf8');
			$this -> query('set character set utf8');
		}

		$this -> connected = ($this -> link != false);
	}

	function __destruct() {
		if($this -> connected) {
			mysql_close($this -> link);
			$this -> connected = false;
		}
	}
	
	function reconnect() {
		$this -> __destruct();
		$this -> __construct($this -> connectData['Host'], $this -> connectData['User'], $this -> connectData['Pass'], $this -> connectData['DB']);
	}

	function select_db($db) {
		mysql_select_db($db, $this -> link);
	}
	
	function query($query, $store = true)
	{
		$rst = mysql_query($query, $this -> link);
		
		if($store)
			$this -> lastResult = $rst;
		
		$this -> lastID = mysql_insert_id($this -> link);
		
		return $rst;
	}

	function assoc($link = null)
	{
		if($link == null)
			$link = $this -> lastResult;

		return mysql_fetch_assoc($link);
	}

	function object($link = null)
	{
		if($link == null)
			$link = $this -> lastResult;

		return mysql_fetch_object($link);
	}

	function num($link = null)
	{
		if($link == null)
			$link = $this -> lastResult;

		return mysql_num_rows($link);
	}

	function query_assoc($query, $store = true) {
		return $this -> assoc( $this -> query($query, $store) );
	}

	function query_object($query, $store = true) {
		return $this -> object( $this -> query($query, $store) );
	}

	function query_num($query, $store = true) {
		return $this -> num( $this -> query($query, $store) );
	}

	function update($hova, $mit, $where = "", $other = "", $store = false)
	{
		if(strlen($hova) && is_array($mit))
		{
			$updates = array();

			foreach($mit as $key => $value)
			{
				$updates[] = "`$key`='$value'";
			}

			if(strlen($where))
				$where = "WHERE " . $where;

			return $this -> query("UPDATE `$hova` SET ". implode(", ", $updates) ." $where $other", $store);
		}

		return 0;
	}

	function insert($hova, $mit, $store = false)
	{
		if(strlen($hova) && is_array($mit))
		{
			$keys = Array(); $values = Array();

			foreach($mit as $key => $value)
			{
				$keys[] = "`".$key."`";
				$values[] = "'".$value."'";
			}

			return $this -> query("INSERT INTO `$hova`(".implode(", ", $keys).") VALUE(".implode(", ", $values).")", $store);
		}

		return 0;
	}
	
	function affected() {
		return mysql_affected_rows($this -> link);
	}
	
	function escape($s) {
		return mysql_real_escape_string($s, $this -> link);
	}
}

?>