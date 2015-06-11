<?php
require_once("include/main.php");

if(!$jatekos["Belepve"] || !in_array($jatekos["Nev"], $config["Kontroll"]))
	Error();

$elerhetoseg = Array(
	"clstest" => $config["Kontroll"],
	"ClassTeszt" => $config["Kontroll"],
);




function DoControl($action, $data)
{
	if($action !== 'start' && $action !== 'stop')
		return FALSE;


	$params = array();
	//$params[] = 'action=' . $action;
	foreach($data as $key => $value)
		$server =  $value;

    

	echo $server."  ";
	$url = 'http://ucp.classrpg.net/control/'.$server;
	$eleres = '/var/www/usercp/control/'.$server;

	if($action == "start")
	{
		$url = $url.".sh";
		$eleres =$eleres.".sh";
	}
	else if($action == "stop")
	{
		$url = $url."Stop.sh";
		$eleres =$eleres."Stop.sh";
	}
	if(!file_exists($eleres))
		return FALSE;


	$json = file_get_contents($url);
	//echo print_r($json, TRUE) . ' - ';
	//$data = json_decode($json, TRUE);

	echo '<pre>'.shell_exec($json).'</pre>';


	return TRUE;
}

$szerverek = Array();
foreach($elerhetoseg as $nev => $data)
	if(in_array($jatekos["Nev"], $elerhetoseg[$nev]))
		$szerverek[$nev] = 0;

if(isset($_GET["ajax"]))
{
	$m = $_POST["m"];
	if($m == "check")
	{
		$db = count($szerverek);
        $hol = 1;
        $persor = 3;

        echo '<center><table width="100%" class="clear">';
        
        foreach($szerverek AS $nev => $x)
        {
            $szerverek[$nev] = file_exists("/var/www/usercp/control/".$nev.".co");
            if($hol % $persor == 1)
                echo "<tr>";
            
            echo "<td><td><table width='100%'>";
                echo '<tr><td style="font-size: 15px">'.$nev.'</td></tr><tr><td>';
			    echo '<b>Státusz</b>: '.($szerverek[$nev] ? "<b style='color: green'>Fut</b>" : "<b style='color: red'>Leállítva</b>").'<br><br>';

			    echo '
			    <input style="padding: 1px; font-size: 9px;" type="button" onclick="Muvelet(\''.$nev.'\', \'start\');" value="START / RESTART">
			    <input style="padding: 1px; font-size: 9px;" type="button" onclick="Muvelet(\''.$nev.'\', \'stop\');" value="STOP">
			    ';

			    echo '</td></tr>';
                
            echo "</table></td></td>";
            
            if($hol % $persor == 0 || $hol == $db)
                echo "</tr>";
            
            $hol++;
        }

		echo'</table></center>';
	}
	elseif($m == "do")
	{
		$s = $_POST["s"]; $a = $_POST["a"];
		if(in_array($s, $szerverek))
		{
			$pid = "/var/www/usercp/control/".$s.".sh";
			
			
			if($a == "start")
			{
				$started = DoControl('start', array('server' => $s));
				if($started === FALSE)
					echo 'HIBA: A szerver nem lett elindítva';
				else
				{
					echo 'A szerver sikeresen elindítva';
					SeeLOG("kontroll", "<b class='kiemelt'>".$jatekos["Nev"]."</b> újraindította a <b class='kiemelt'>".$s."</b> szervert", $jatekos["ID"], $jatekos["Nev"], 1);
					fclose( fopen($pid, 'w') );
				}
			}
			else if($a == "stop")
			{
				$stopped = DoControl('stop', array('server' => $s));
				if($started === FALSE)
					echo "HIBA: A szerver nem lett leállítva";
				else
				{
					echo 'A szerver sikeresen leállítva';
					SeeLOG("kontroll", "<b class='kiemelt'>".$jatekos["Nev"]."</b> leállította a <b class='kiemelt'>".$s."</b> szervert", $jatekos["ID"], $jatekos["Nev"], 1);
					//unlink($pid);
				}
			}
		}
	}
	Lablec(false, null, true);
}

Fejlec();
?>

<style type="text/css"></style>

<script type="text/javascript">
var tolt = false;
$(document).ready(
	function(){
		Check();
	}
);

<?=$js_tomb?>

function Check()
{
	if(tolt) return 1;
	tolt = true;

	$('#ajax').html("Töltés...");

	$.ajax({
		type: "POST",
		url: "?ajax",
		data: "m=check",
		success: function(msg){

			$('#ajax').html(msg);
			tolt = false;
		}
	});
}

function Muvelet(szerver, akcio)
{
	if(tolt) return 1;
	tolt = true;

	$('#ajax').html("A kért művelet végrehajtása folyamatban...");

	adat = "m=do&s="+szerver+"&a="+akcio;

	$.ajax({
		type: "POST",
		url: "?ajax",
		data: adat,
		success: function(msg){

			tolt = false;
			$('#ajax').html(msg);
			setTimeout("Check()", 3000);
		}
	});
}

</script>

<center>

<h1>Szerver Kontroll</h1>

<a class="kez" onclick="Check()" style="font-weight: bold">Frissítés</a><br><br>

<table width="90%"><tr><td><div id="ajax">
</div></td></tr></table>

<br>

<div id="config"></div>

</center>

<? Lablec(); ?>