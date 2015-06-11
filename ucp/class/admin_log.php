<?
require_once("include/main.php");

if(!$jatekos["Belepve"] || !CheckAdmin() && !IsScripter())
	Error();

$tipusok = Array("Admin", "Ban", "Chat", "Cheat", "Connect", "Damage", "Egyeb", "Fegyver", "Kick", "Kill", "Nevvaltas", "Parancsok", "Pay", "Shoot", "Shoot2", "Szef", "MySQL", "Scripter");
$mettol = "2013-01-01";

if(isset($_GET["ajax"]))
{
	$log = $_POST["log"];
	$datum = $_POST["datum"];

	
	if($log ==  "MySQL" && !IsScripter())
		$log = $tipusok[4];
		
	$het = 0;
	if($_POST["het"] == '1' && (IsClint() || IsTerno()))
		$het = 1;

    if(!in_array($log, $tipusok) && $log != "SAMP") exit;

    if($log != "SAMP")
        $fajl = $config["Mappa"] . "/scriptfiles/Log/".$log."/".$datum.".log";
    else
        $fajl = $config["Mappa"] . "/samp.ban";

	$mit = Array($fajl);
	if($het)
	{
		$mikor = strtotime($datum . " 12:12:12");
		for($n = 1; $n <= 7; $n++)
		{
			$dat = date("Y-m-d", $mikor - (86400 * $n));
			$neve = $config["Mappa"] . "/scriptfiles/Log/".$log."/".$dat.".log";
			if(file_exists($neve))
				$mit[] = $neve;
		}
	}
	$_POST["exp"] = "@".$_POST["exp"]."@iu";
	for($f = 0; $f < count($mit); $f++)
	{
		$fajl = $mit[$f];
		$handle = @fopen($fajl, "r");
		if ($handle)
		{
			if(isset($_GET["regexp"]))
			{
				echo "<span class='left'><br><hr><br>$fajl<br><br><br>";
				$tartalom = fread($handle, filesize($fajl));
				fclose($handle);
				preg_match_all($_POST["exp"], $tartalom, $talalatok);
				unset($tartalom);

				$db = 1;
				foreach($talalatok[0] AS $talalat)
				{
					if($talalat == "") continue;
					echo $talalat."<br>";
					if($db == 1000)
					{
						echo"<br><i>A többi találat nincs megjelenítve!</i>";
						break;
					}
					$db++;
				}

				unset($talalat);
				unset($talalatok);
				echo "</span>";
			}
			else
			{
				if(filesize($fajl) > (2*1024*1024))
				{
					fclose($handle);
					echo "<br>A LOG mérete túl nagy, így le kell töltened, <a href='?letolt&log=".$log."&datum=".$datum."' target='_BLANK'>ITT</a>";
				}
				else
				{
					if($log != "SAMP")
						echo "<br>Letölthető: <a href='?letolt&log=".$log."&datum=".$datum."' target='_BLANK'>ITT</a><br><br>";

					echo "<span class='left'>";
					while (!feof($handle)) {
						$buffer = fgets($handle, 4096);
						echo $buffer . "<br>";
					}
					fclose($handle);
					echo "</span>";
					break;
				}
			}
		}
		else
			echo "Fájl megnyitása sikertelen";
	}
	Lablec(false, null, true);
}
elseif(isset($_GET["letolt"]))
{
	$log = $_GET["log"];
	$datum = $_GET["datum"];

	if(!in_array($log, $tipusok)) exit;

	if($log != "SAMP")
		$fajl = $config["Mappa"] . "/scriptfiles/Log/".$log."/".$datum.".log";
	else
		$fajl = $config["Mappa"] . "/samp.ban";

	$letoltes = "[ClassRPG-".$log."]".$datum.".log";
	$type = "application/octet-stream";

	$handle = @fopen($fajl, "r");
	if ($handle) {
		header("Content-type: $type");
		header("Content-Disposition: attachment;filename=$letoltes");
		header("Content-Transfer-Encoding: binary");
		header('Pragma: no-cache');
		header('Expires: 0');
	    while (!feof($handle)) {
			$buffer = fgets($handle, 4096);
		    echo $buffer;
	    }
	    fclose($handle);
	}
	else
		echo "Fájl megnyitása sikertelen";
	Lablec(false, null, true);

}
Fejlec();
?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#keres_regexp1').keypress(function(event){ if(event.which == '13') Kereses(1); });
		$('#keres_regexp2').keypress(function(event){ if(event.which == '13') Kereses(2); });
		$('#keres_regexp3').keypress(function(event){ if(event.which == '13') Kereses(3); });
    });
	var ajaxtoltes = false;
	var extra = false;
	function SimaLOG()
	{
		log = $("#tipus").val();
		Lekeres(log);
	}
	function Lekeres(mit)
	{
		if(ajaxtoltes)
			return 1;

		log = mit;
		datum = $("#ido").val();

		$("#statusz").html("<img src='img/ajax-loader.gif'>");

		$.ajax({
			type: "POST",
			url: "?ajax",
			data: "log="+log+"&datum="+datum,
			success: function(msg){
				$("#statusz").html("<b>"+msg+"</b>");
				ajaxtoltes = false;
			}
		});
	}

    function Kereses(id)
    {
        if(ajaxtoltes)
            return 1;

		if(!extra)
		{
			log = $("#tipus").val();
			datum = $("#ido").val();
		}
		else
		{
			log = $("#tipus_"+id).val();
			datum = $("#ido_"+id).val();
		}
        regexp = $("#keres_regexp"+id).val();

		het = 0;
		if($('#het') && $('#het').attr("checked"))
			het = 1;

        $("#statusz").html("<img src='img/ajax-loader.gif'>");

        $.ajax({
            type: "POST",
            url: "?ajax&regexp",
            data: "exp="+regexp+"&log="+log+"&datum="+datum+"&het="+het,
            success: function(msg){
                $("#statusz").html("<b>"+msg+"</b>");
                ajaxtoltes = false;
            }
        });
    }

	function Extra()
	{
		if(!extra)
		{
			$('#extra_2').css("display", "inline");
			$('#extra_3').css("display", "inline");

			$('#tipus_1').css("display", "inline");
			$('#tipus_2').css("display", "inline");
			$('#tipus_3').css("display", "inline");

			$('#ido_1').css("display", "inline");
			$('#ido_2').css("display", "inline");
			$('#ido_3').css("display", "inline");
			extra = true;
		}
		else
		{
			$('#extra_2').css("display", "none");
			$('#extra_3').css("display", "none");

			$('#tipus_1').css("display", "none");
			$('#tipus_2').css("display", "none");
			$('#tipus_3').css("display", "none");

			$('#ido_1').css("display", "none");
			$('#ido_2').css("display", "none");
			$('#ido_3').css("display", "none");
			extra = false;
		}
	}
</script>

<style type="text/css">
	table{border-spacing:0px;}
	td{border: 2px outset #888;padding: 5px;vertical-align: middle;text-align:center;background-color: #202020;}
	td.clear, .cleartr td{border: none;}
	.left{text-align: left;}
	.cim{color:white;font-weight:bold;}
	.left li a{text-decoration:none;font-weight:bold;color:white;}
	.left li a:hover{color:yellow;}
	img.link{cursor: crosshair;}
	img.link:hover{cursor: pointer;}
</style>

<?
function SelectKiiras($tipus, $id = "", $display = true)
{
	global $tipusok, $mettol;
	if($tipus == 't')
	{
		$tipusSelect = '<select id="tipus'.$id.'" style="font-size: 10px;'.(!$display ? "display:none" : "").'">';
		if(IsScripter())
			for($x = 0; $x < count($tipusok); $x++) $tipusSelect .= "<option value='".$tipusok[$x]."'>".$tipusok[$x]."</option>";
		else
			for($x = 0; $x < count($tipusok)-1; $x++) $tipusSelect .= "<option value='".$tipusok[$x]."'>".$tipusok[$x]."</option>";
		$tipusSelect .= '</select>';

		return $tipusSelect;
	}
	elseif($tipus == 'i')
	{
		$ma = date("Y-m-d"); $holnap = date("Y-m-d", time() + 86400); $most = $mettol; $time = strtotime($mettol . " 00:00:00");

		$idoSelect = '<select id="ido'.$id.'" style="font-size: 10px;'.(!$display ? "display:none" : "").'">';
		while($most != $holnap)
		{
			$idoSelect .= "<option value='".$most."' ".($most == $ma ? "selected" : "").">".$most."</option>";

			$time += 86400;
			$most = date("Y-m-d", $time);
		}
		$idoSelect .= "</select>";

		return $idoSelect;
	}
	elseif($tipus == 'm')
	{
		$tipusSelect = '<select id="tipus'.$id.'" style="font-size: 10px;'.(!$display ? "display:none" : "").'">';
		for($x = 0; $x < count($tipusok); $x++) $tipusSelect .= "<option value='".$tipusok[$x]."'>".$tipusok[$x]."</option>";
		$tipusSelect .= '</select>';

		$ma = date("Y-m-d"); $holnap = date("Y-m-d", time() + 86400); $most = $mettol; $time = strtotime($mettol . " 12:00:00");

		$idoSelect = '<select id="ido'.$id.'" style="font-size: 10px;'.(!$display ? "display:none" : "").'">';
		while($most != $holnap)
		{
			$idoSelect .= "<option value='".$most."' ".($most == $ma ? "selected" : "").">".$most."</option>";

			$time += 86400;
			$most = date("Y-m-d", $time);
		}
		$idoSelect .= "</select>";

		return $tipusSelect . $idoSelect;
	}
}

?>

<center><h1>LOG</h1></center>

<center><table width='100%' align='center'><tr><td width='100%'>
<a href='javascript: void(0)' onclick='Extra()'>Regexp Extra</a><br>
@ <input type='text' size='75' id='keres_regexp1' value = '.*.*' style='font-family: monospace; font-size: 11px;'> @iu <button onclick='Kereses(1)'>Go</button><?=SelectKiiras('m', '_1', false)?><br>

<div id='extra_2' style='display: none'>
	@ <input type='text' size='75' id='keres_regexp2' style='font-family: monospace; font-size: 11px;'> @iu <button onclick='Kereses(2)'>Go</button><?=SelectKiiras('m', '_2', false)?><br>
</div><div id='extra_3' style='display: none'>
	@ <input type='text' size='75' id='keres_regexp3' style='font-family: monospace; font-size: 11px;'> @iu <button onclick='Kereses(3)'>Go</button><?=SelectKiiras('m', '_3', false)?><br>
</div>

<?

echo '<a href="#lent">Le</a> ' . SelectKiiras('m') . ((IsClint() || IsTerno()) ? ' <input type="checkbox" id="het">1hét ' : '');
?>
<input type="button" onclick="SimaLOG()" value="Megnéz" style="padding:0px"><input type="button" onclick="Lekeres('SAMP')" value="SAMP Bannok" style="padding:0px">
 <div id='statusz' style='font-size:10px'></div><br>

</td></tr></table><a href="#fent">Fel</a>

</center>

<? Lablec(); ?>