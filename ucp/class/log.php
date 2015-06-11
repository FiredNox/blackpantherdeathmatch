<?
require_once("include/main.php");
if(!$jatekos["Belepve"]) Hiba("Nem vagy belépve!", true);

$darab = 10;

if(isset($_GET["ajax"]))
{
	$o = $_POST["o"];
	if(!isset($o))
		$from = 0;
	else
		$from = ($o - 1) * $darab;

	$res = mysql_query("SELECT * FROM log WHERE AID='".$jatekos["ID"]."' AND Admin='0' ORDER BY Datum DESC LIMIT ".$from.", ".$darab);
	if(mysql_num_rows($res) == 0)
		echo "Nem történt semmi";
	else
	{
		echo'
			<table width="100%" align="center" border="1">
				<tr class="cleartr cim">
					<td width="80%" class="nopadding" style="padding-top: 3px">Esemény</td>
					<td width="20%" class="nopadding" style="padding-top: 3px">Időpont</td>
				</tr><!--<tr class="cleartr"><td colspan="2" class="nopadding"><br></td>--></tr>';

		while($log = mysql_fetch_array($res))
		{
			echo"<tr id='log_".$log["ID"]."' ".($log["Olvasva"] == '0' ? "class='uj'" : "").">
					<td class='bal'>
						".$log["Log"]."
						".($log["Olvasva"] == '0' ? "<img src='img/nagyito.png' title='Olvasottnak jelöl' width='10px' id='olvas_".$log["ID"]."' onclick='Olvas(\"".$log["ID"]."\");' class='kez'>" : "")."
					</td>
					<td class='jobb'>".$log["Datum"]."</td>
				</tr>
				";
				//if($log["Olvasva"] == '0') mysql_query("UPDATE log SET Olvasva='1' WHERE ID='".$log["ID"]."'");
		}
		mysql_free_result($res);

		echo'</table>';

		echo "<br>";

		$sql = mysql_query("SELECT ID FROM log WHERE AID='".$jatekos["ID"]."' AND Admin='0'");
		$num = mysql_num_rows($sql); mysql_free_result($sql);

		$peroldal = $darab; // Bejegyzés per olda
		$latni = 2; // A jelenlegi oldal körül hányat mutasson
		$elsok = 3; // Az első és utolsó oldalak közül hányat mutasson

		$oldalak = ceil($num / $peroldal);
		$p = $o;
		if(!isset($p) || $p < 1 || $p > $oldalak) $p = 1;

		for($x = 1; $x <= $oldalak; $x++)
		{
			if($x == 1) $szoveg = "Első";
			else if($x == $oldalak) $szoveg = "Utolsó";
			else $szoveg = $x;

			if($x <= $elsok || $x > ($oldalak - $elsok) || $x >= ($p - $latni) && $x <= ($p + $latni))
			{
				if($x != $p)
					$kiirat = " <a href='javascript: void(0)' onclick='Toltes(\"".$x."\")'>".$szoveg."</a>";
				else
					$kiirat = " <a class='no'>".$szoveg."</a>";
				if($x < $oldalak) $kiirat .= " ";
				echo $kiirat;
			}
			else
			{
				if($x < $p && !$pontok[1])
				{
					$pontok[1] = true;
					echo " ... ";
				}
				else if($x > $p && !$pontok[2])
				{
					$pontok[2] = true;
					echo " ... ";
				}
			}
		}
		echo "<br>";

		if($oldalak > 1)
		{
			if($p > 1)
				echo "<a href='javascript: void(0)' onclick='Toltes(\"".($p-1)."\")'><< Előző</a>";
			else
				echo "<a class='no'><< Előző</a>";
			echo " - ";
			if($p < $oldalak)
				echo "<a href='javascript: void(0)' onclick='Toltes(\"".($p+1)."\")'>Következő >></a>";
			else
				echo "<a class='no'>Következő >></a>";
		}
	}
	Lablec(false, null, true);
}
elseif(isset($_GET["ajax_olvas"]))
{
	$id = $_POST["id"];
	$sql = mysql_query("SELECT AID, Olvasva FROM log WHERE ID='".$id."'");
	if(mysql_num_rows($sql) == 0)
		echo "0";
	else
	{
		$log = mysql_fetch_array($sql);
		if($log["AID"] != $jatekos["ID"])
			echo "0";

		if($log["Olvasva"] != "1") $keres = mysql_query("UPDATE log SET Olvasva='1' WHERE ID='".$id."'");
		else $keres = 1;
		
		if($keres) echo "1";
		else echo "0";
	}
	mysql_free_result($sql);
	Lablec(false, null, true);
}

Fejlec();
if(isset($uzenet)) echo Felhivas($uzenet);
?>
<style type="text/css">
	table{ border-spacing:0px; }
	td
	{
		/*border: 2px outset #888;*/
		padding: 3px;
		vertical-align: top;
		text-align:center;
		background-color: #222222;
		color: white;
		font-weight: bold;
	}
	/*td.clear, .cleartr td, .cleartable tr td{ border: none; }*/
	.left{ text-align: left; }
	.adat
	{
		font-weight:bold;
		text-align:left;
	}
	.kozep
	{
		/*border-left: 2px solid #888;
		border-right: 2px solid #888;*/
	}
	tr.uj td
	{
		background-color: darkorange;
		color: black;
		font-weight: bold;
	}
	tr.cim td{ color: white; font-size: 125%;}
	.nopadding{ padding: 0px; }
	.link{ cursor: crosshair; }
	.link:hover{ cursor: pointer; }
	.padding { padding: 3px; }
	a.no
	{
		text-decoration:none;
		font-weight:bold;
	}
</style>

<script type="text/javascript">
var tolt = false;
$(document).ready(
	function(){
		Toltes(1);
	}
);

function Olvas(id)
{
	if(!id || !IsNumeric(id))
		return 1;

	$("#olvas_"+id).attr("src", "img/ajax-loader.gif");

	tolt = true;

	$.ajax({
		type: "POST",
		url: "?ajax_olvas",
		data: "id="+id,
		success: function(msg){
			if(msg == "1")
			{
				$('#log_'+id).removeClass("uj");
				$('#olvas_'+id).remove();
			}
			else
				$('#olvas_'+id).attr("src", "img/nagyito.png");

			tolt = false;
		}
	});
}

function Toltes(id)
{
	if(tolt) return 1;
	if(!id || !IsNumeric(id) || id < 1 || id > 999)
	{
		$("#log").html("Hiba történt");
		return 1;
	}
	$("#log").html("<img src='img/ajax-loader.gif'>");

	$.ajax({
		type: "POST",
		url: "?ajax",
		data: "o="+id,
		success: function(msg){
			$("#log").html(msg);
			tolt = false;
		}
	});
}
</script>

<center><h1>Log</h1></center>

<center><table width="98%" align="center"><tr><td width="100%" style="background-color: transparent; border: none;">

<div id='log'></div>

</td></tr></table></center>

<? Lablec(); ?>