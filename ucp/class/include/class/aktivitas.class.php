<?
##############################
### OSZTÁLY :: STATISZTIKA ###
##############################

define("STAT_ACTIVITY", "o");
define("STAT_MUNKA", "a");
define("STAT_HET", "w");
define("STAT_HONAP", "m");

class Statisztika
{
	private $path, $time, $date, $datetime;
	function __construct()
	{
		global $config;
		$this->path = $config["Path"]["activity"];
		$this->time = time();
		$this->date = date("Y-m-d");
		$this->datetime = date("Y-m-d H:i:s");
	}

	function dayBefore($days)
	{
		return date("Y-m-d", time() - $days*86400);
	}

	function UtoljaraAktiv($time) {
		$unix = time();

		$ma = date("Y-m-d");
		$tegnap = date("Y-m-d", time()-86400);
		$tegnapelott = date("Y-m-d", time()-172800);
		
		if($time > 0)
		{
			$uo = date("Y-m-d H:i", $time);
			$uo_e = explode(" ", $uo);
			$color = "#ff1515";
			if(($unix - $time) < 86400) $color = "#0cf800";
			elseif(($unix - $time) < 172800) $color = "#fff208";
			elseif(($unix - $time) < 604800) $color = "#f86f00";
		
			if($uo_e[0] == $ma)
				$ret = "<b style='color:$color'>Ma ".$uo_e[1]."</b>";
			elseif($uo_e[0] == $tegnap)
				$ret = "<b style='color:$color'>Tegnap ".$uo_e[1]."</b>";
			elseif($uo_e[0] == $tegnapelott)
				$ret = "<b style='color:$color'>Tegnap előtt ".$uo_e[1]."</b>";
			else
				$ret = "<b style='color:$color'>".$uo."</b>";
		}
		else
			$ret = "<i>Soha</i>";
		
		return $ret;
	}
	
	function ActivityIndex($uid, $utoljaraaktiv = -1, $colorize = true, $fullLink = true)
	{
		global $mysql;

		if($uid && ($utoljaraaktiv == -1 || $utoljaraaktiv >= ($this -> time - 2592000)))
		{
			$mysql -> query("SELECT `Month`, `Week` FROM ig_activity_index WHERE UID='$uid'");
			if(!$mysql -> num())
			{
				$resMonth = $mysql -> query_object("SELECT SUM(Ido) AS ossz FROM ig_activity WHERE UID='$uid' AND Datum>='".$this -> dayBefore(30)."' AND Datum!='".$this->date."'", false);
				$resWeek = $mysql -> query_object("SELECT SUM(Ido) AS ossz FROM ig_activity WHERE UID='$uid' AND Datum>='".$this -> dayBefore(7)."' AND Datum!='".$this->date."'", false);

				$mysql -> insert("ig_activity_index", array(
					"UID"   => $uid,
					"Month" => $resMonth -> ossz,
					"Week"  => $resWeek -> ossz,
					"Added" => $this -> date,
				));

				$res = array("Month" => $resMonth -> ossz, "Week" => $resWeek -> ossz);
			}
			else
				$res = $mysql -> assoc();
		}
		else
			$res = array("Month" => 0, "Week" => 0);

		if($colorize)
		{
			// Hónap
			$class = "inactive";

			if($res["Month"] >=     (30) * 3600 * 7  ) $class = "uber";
			elseif($res["Month"] >= (30) * 3600 * 5  ) $class = "hyper";
			elseif($res["Month"] >= (30) * 3600 * 2  ) $class = "active";
			elseif($res["Month"] >= (30) * 3600 * 1  ) $class = "trying";
			elseif($res["Month"] >= (30) * 60   * 30 ) $class = "regular";

			$res["Month"] = round( $res["Month"] / 3600 );

			$res["Month"] = "<b class='activity_$class' title='Havi aktivitás'>".$res["Month"]."</b>";

			// Hét
			$class = "inactive";

			if($res["Week"]     >= (7) * 3600 * 7  ) $class = "uber";
			elseif($res["Week"] >= (7) * 3600 * 5  ) $class = "hyper";
			elseif($res["Week"] >= (7) * 3600 * 2  ) $class = "active";
			elseif($res["Week"] >= (7) * 3600 * 1  ) $class = "trying";
			elseif($res["Week"] >= (7) * 60   * 30 ) $class = "regular";

			$res["Week"] = round( $res["Week"] / 3600 );

			$res["Week"] = "<b class='activity_$class' title='Heti aktivitás'>".$res["Week"]."</b>";
		}

		if($fullLink)
			$res = "<a href='http://wiki.classrpg.net/AktivitasIndex' target='_BLANK'>". implode(" / ", $res) ."</a>";

		return $res;
	}

	function Show($uid = 0)
	{
		if($uid)
		{
			$this->Check($uid, STAT_ACTIVITY, STAT_HONAP);
			$this->Check($uid, STAT_MUNKA, STAT_HONAP);
		}

		if(defined("DYGRAPH_LOADED") === FALSE)
			echo '<script type="text/javascript" src="include/dygraph.js"></script>';

		?>
		<script type="text/javascript" src="include/dygraph-see.js"></script>

		<div id='radio'>
			<input type='radio' id='radio1' name='m' value='o' onclick="Valt('o')" checked><label for='radio1'>Aktivitás</label>
			<input type='radio' id='radio2' name='m' value='a' onclick="Valt('a')"><label for='radio2'>Admin</label>
		</div>

		<br><br>

		<div id="grafikon" style="border: 1px solid white;"></div>
		<?
	}

	function Check($uid, $tipus, $ido = STAT_HONAP)
	{
		if(!is_numeric($uid)) return 1;

		$file = $this->path . "/" . $uid . $tipus . $ido . ".csv";

		if(file_exists($file) && filemtime($file) >= strtotime($this->date . " 00:00:00"))
			return 1;

		if($tipus == STAT_ACTIVITY) $mezok = "Ido,Onduty";
		elseif($tipus == STAT_MUNKA) $mezok = "VA,PM";

		if($ido == STAT_HET)
		{
			$mettol = time() - 7*86400; // -7 nap
			$meddig = $mettol + 6*86400; // +6 nap
			$napok = 7;
		}
		elseif($ido == STAT_HONAP)
		{
			$mettol = time() - 31*86400; // -31 nap
			$meddig = $mettol + 30*86400; // +30 nap
			$napok = 31;
		}
		
		$intervallum = Array(
			"mettol" => $mettol,
			"meddig" => $meddig,
			"napok" => $napok
		);

		$this->Munka($uid, $file, $mezok, $intervallum);
	}

	private function Munka($uid, $file, $mezok, $intervallum)
	{
		$napok = Array();
		for($n = 0; $n < $intervallum["napok"]; $n++)
			$napok[] = date("Y-m-d", $intervallum["mettol"] + 86400*$n);

		$adatok = Array();
		if(file_exists($file))
		{
			$tmp_data = file($file);

			//if(count($tmp_data) == $intervallum["napok"])
			foreach($tmp_data as $sor)
			{
				$exp = explode(",", $sor);
				
				if(count($exp) == 3 && in_array($exp[0], $napok))
				{
					$van = false;
					foreach($adatok as $adat)
					{
						if($adat[0] == $exp[0])
							{$van = true; break;}
					}
					if($van) continue;

					$adatok[] = Array($exp[0], $exp[1], str_replace(Array("\r", "\n"), "", $exp[2]));
				}
			}
			unset($tmp_data);
		}

		foreach($napok as $nap)
		{
			$van = false;
			foreach($adatok as $adat)
			{
				if($adat[0] == $nap)
					{$van = true; break;}
			}

			if($van) continue;

			$sql = mysql_query("SELECT Datum,$mezok FROM ig_activity WHERE Datum='$nap' AND UID='$uid'");
			
			if(mysql_num_rows($sql))
				$adatok[] = mysql_fetch_row($sql);
			else
				$adatok[] = Array($nap, 0, 0);
		}

		sort($adatok);

		$f = fopen($file, 'w');
		foreach($adatok as $sor)
		{
			fwrite($f, implode(',', $sor) . "\n");
		}
		fclose($f);
				
	}
}

$_stat = new Statisztika;

?>