<?
require_once("include/main.php");
require_once("include/statinfo.php");

if(isset($_GET["ajax"]))
{
    $a = $_GET["a"];
    if($a == "alap")
    {
        echo Cim("Általános statisztika", 70, false);
        echo '<table width="70%" align="center" class="lefttext noupdownpadding">';
        // 1244800800 > 2009-06-12 12:00
        $nap = floor((time() - 1244800800) / 86400);
        $ev = floor($nap / 365);
        $nap = $nap % 365;

        $szoveg = $ev." éve";

        if($nap > 0)
            $szoveg .= " és ".$nap." napja";

        echo'<tr>
                <td width="45%">A szerver indult</td>
                <td>2009. június 12. (<b>'.$szoveg.'</b>)</td>
             </tr>';

        //$sql = mysql_query("SELECT ID FROM playerek"); $db = mysql_num_rows($sql); mysql_free_result($sql); unset($sql);
        $sql = mysql_query("SELECT ID FROM playerek WHERE Online='1'"); $db_online = mysql_num_rows($sql); mysql_free_result($sql); unset($sql);

        //echo '<tr><td>Regisztrált karakterek</td><td>'.$db.'db</td></tr>';

        //$sql = mysql_query("SELECT ID FROM playerek WHERE Member='0'"); $db_civil = mysql_num_rows($sql); mysql_free_result($sql); unset($sql);
        //$sql = mysql_query("SELECT ID FROM playerek WHERE Member='1' OR Member='2' OR Member='4' OR Member='7' OR Member='9' OR Member='10' OR Member='14' OR Member='16' OR Member='20'"); $db_legal = mysql_num_rows($sql); mysql_free_result($sql); unset($sql);
        //$sql = mysql_query("SELECT ID FROM playerek WHERE Member='3' OR Member='5' OR Member='6' OR Member='11' OR Member='13' OR Member='17' OR Member='21'"); $db_illegal = mysql_num_rows($sql); mysql_free_result($sql); unset($sql);

        //echo '<tr><td>Civil / Legális / Illegális megoszlása</td><td><b>'.$db_civil.'</b> ('.round(($db_civil / $db) * 100).'%) / <b>'.$db_legal.'</b> ('.round(($db_legal / $db) * 100).'%) / <b>'.$db_illegal.'</b> ('.round(($db_illegal / $db) * 100).'%)</td></tr>';

        $sql = mysql_query("SELECT Nev FROM playerek ORDER BY ID DESC LIMIT 1"); $utolso = mysql_fetch_array($sql);
        echo '<tr><td>Utolsó regisztrált játékos</td><td><b>'.$utolso["Nev"].'</b></td></tr>';
        echo '</table><br>';

        //#################################################################################################################################//
        //#################################################################################################################################//
        //#################################################################################################################################//

        $sql = mysql_query("SELECT Nev, Phone FROM playerek WHERE Online='1' AND Member='16' ORDER BY nev"); $db_oktato = mysql_num_rows($sql);
        echo Cim("Online oktatók".($db_oktato > 0 ? " <b style='color:#FF5'>(".$db_oktato." oktató)</b>" : ""), 95, false);
        ?>
        <table width="95%" align="center"><tr><td><div align="justify">
        <?
            $db = 0;
            while($player = mysql_fetch_array($sql))
            {
                if($db != 0) echo ", ";

                echo "<b style='color: #FFF'>".$player["Nev"]."</b> (Tel.: ".$player["Phone"].")";
                $db = 1;
            }
             mysql_free_result($sql); unset($sql);
            if($db == 0) echo "Jelenleg nincs online oktató";
        ?>
        </div></td></tr></table><br>
        <?
        //#################################################################################################################################//
        //#################################################################################################################################//
        //#################################################################################################################################//

        echo Cim("Online játékosok".($db_online > 0 ? " <b style='color:#FF5'>(".$db_online." játékos)</b>" : ""), 95, false);
        ?>
        <table width="95%" align="center"><tr><td><div align="justify">
        <?
            $sql_query = mysql_query("SELECT Nev, Member, Admin FROM playerek WHERE Online='1' ORDER BY nev");
            $db = 0;
            $darab = Array("C" => 0, "R" => 0, "M" => 0, "I" => 0, "O" => 0, "F" => 0, "T" => 0,);
            $szinek = Array(
                "C" => "#FFF", // Civil
                "R" => "#66F", // Rendvédelem
                "M" => "#FAA", // Mentő
				"F" => "#2CF", // Tüzoltó
                "I" => "#F40", // Illegális
                "O" => "#FF6", // Oktató
				"T" => "#FFA500" //taxi
			);
            while($player = mysql_fetch_array($sql_query))
            {
                if($db != 0) echo ", ";

                if(in_array($player["Member"], Array(1, 2, 13, 14, 20)))
                {
                    $szin = $szinek["R"];
                    $darab["R"]++;
                }
                else if(in_array($player["Member"], Array(3, 5, 6, 8, 11, 17, 21)))
                {
                    $szin = $szinek["I"];
                    $darab["I"]++;
                }
				else if($player["Member"] == 12)
				{
					$szin = $szinek["F"];
					$darab["F"]++;
				}
                else if($player["Member"] == 4)
                {
                    $szin = $szinek["M"];
                    $darab["M"]++;
                }
                else if($player["Member"] == 16)
                {
                    $szin = $szinek["O"];
                    $darab["O"]++;
                }
				else if($player["Member"] == 10)
                {
                    $szin = $szinek["T"];
                    $darab["T"]++;
                }
                else
                {
                    $szin = $szinek["C"];
                    $darab["C"]++;
                }

                echo "<b style='color: ".$szin."'>".$player["Nev"]."</b>";
                $db = 1;
            }
            mysql_free_result($sql_query);
            if($db == 0) echo "Jelenleg nincs online játékos";
            else
            {
                echo "<br><br><hr width='20%' align='left'><br>";
                echo "<b style='color:".$szinek["R"]."'>Rendvédelem</b>: ".($darab["R"] > 0 ? $darab["R"]."db" : "<i>Nincs</i>")."<br>";
                echo "<b style='color:".$szinek["I"]."'>Illegális</b>: ".($darab["I"] > 0 ? $darab["I"]."db" : "<i>Nincs</i>")."<br>";
				echo "<b style='color:".$szinek["M"]."'>Mentős</b>: ".($darab["M"] > 0 ? $darab["M"]."db" : "<i>Nincs</i>")."<br>";
				echo "<b style='color:".$szinek["F"]."'>Tűzoltó</b>: ".($darab["F"] > 0 ? $darab["F"]."db" : "<i>Nincs</i>")."<br>";
                echo "<b style='color:".$szinek["O"]."'>Oktatók</b>: ".($darab["O"] > 0 ? $darab["O"]."db" : "<i>Nincs</i>")."<br>";
				 echo "<b style='color:".$szinek["T"]."'>Taxi</b>: ".($darab["T"] > 0 ? $darab["T"]."db" : "<i>Nincs</i>")."<br>";
                echo "<b style='color:".$szinek["C"]."'>Civil</b>: ".($darab["C"] > 0 ? $darab["C"]."db" : "<i>Nincs</i>")."<br>";
                echo "<b style='color: grey'>Adminisztrátorok</b>: <i>Mindig figyelnek! Vigyázz, hogy viselkedsz!</i>";
            }
        ?>
        </div></td></tr></table><br>
        <?
    }
    elseif($a == "frakcio")
    {
        echo Cim("Frakció statisztikák", 50, false);
        echo '<table width="50%" align="center" class="lefttext noupdownpadding">';
        echo '<tr><td width="50%" class="cim">Szervezet neve</td><td width="30%" class="cim">Tagok száma</td><td class="cim">Területek</td></tr>';

        $rendvedelem = 0;
        $illegalisok = 0;

        foreach($config["Frakciok"] as $id => $nev)
        {
            if(in_array($id, $config["NemLetezoFrakciok"])) continue;

            $sql = mysql_query("SELECT ID FROM playerek WHERE Member='".$id."' OR Leader='".$id."'");
            $db = mysql_num_rows($sql); mysql_free_result($sql);

            $sql = mysql_query("SELECT ID FROM playerek WHERE Online='1' AND (Member='".$id."' OR Leader='".$id."')");
            $db_onl = mysql_num_rows($sql); mysql_free_result($sql);

            $sql = mysql_query("SELECT ID FROM teruletek WHERE Tulaj='".$id."'");
            $db_terulet = mysql_num_rows($sql); mysql_free_result($sql);

            echo '<tr><td>'.$nev.'</td><td><b>'.$db.'</b> / '.$db_onl.'</td><td><b>'.($db_terulet == 0 ? "" : $db_terulet).'</b></td></tr>';

            if(in_array($id, $config["Rendvedelem"])) $rendvedelem += $db;
            else if(in_array($id, $config["Illegalisok"])) $illegalisok += $db;
        }

        $sql = mysql_query("SELECT ID FROM playerek WHERE Swat = '1'");
        $db = mysql_num_rows($sql); mysql_free_result($sql);

        $sql = mysql_query("SELECT ID FROM playerek WHERE Swat = '1' AND Online='1'");
        $db_onl = mysql_num_rows($sql); mysql_free_result($sql);

        echo '<tr><td>SWAT</td><td><b>'.$db.'</b> / '.$db_onl.'</td><td><b></b></td></tr>';

        echo '</table><br><br>';

        echo '<table width="50%" align="center" class="lefttext noupdownpadding"><tr><td>';
        echo '<b>Összesítés:</b><br>';
        echo 'Rendvédelem: <b>'.$rendvedelem.'db</b><br>';
        echo 'Illegálisok: <b>'.$illegalisok.'db</b><br>';
        echo '</td></tr></table>';
    }
    elseif($a == "terulet")
    {
        $sql = mysql_query("SELECT * FROM teruletek ORDER BY Nev");

        echo '<table width="100%" align="center" class="lefttext noupdownpadding">';
        echo '<tr>
                <td width="22%" class="cim">Terület neve</td>
                <td width="18%" class="cim">Tulaj</td>
                <td width="18%" class="cim">Foglalva</td>
                <td width="18%" class="cim">Foglalható</td>
                <td width="24%" class="cim">Haszon / 1 óra</td>
            </tr>';

        $ido = time();
        while($terulet = mysql_fetch_array($sql))
        {
			$haszon = "";
			$h = explode(",", $terulet["Haszon"]);
			$hm = explode(",", $terulet["HaszonMennyi"]);

			if(count($h) != 0 && strlen($h[0]) && count($h) == count($hm))
			{
				$haszon = Array();
				for($i = 0; $i < count($h); $i++)
				{
					if($h[$i] < 1 || $h[$i] > 3) continue;
					$haszon[] = $haszonok[ $h[$i] ][0] . ": " . $hm[$i] . $haszonok[ $h[$i] ][1];
				}
			}

            echo '<tr>
                <td style="font-weight: bold;">'.($jatekos["Admin"] >= 6 ? '[<font color="white">'.$terulet["ID"].'</font>] ' : '').$terulet["Nev"].'</td>
                <td style="color: '.$config["FrakcioSzinek"][$terulet["Tulaj"]].'; font-weight: bold;">'.$config["Frakciok"][$terulet["Tulaj"]].'</td>
                <td>'.($terulet["Foglalva"] < 100000 ? "" : DatumFormat(date("Y-m-d H:i:s", $terulet["Foglalva"]))).'</td>
                <td>'.($terulet["Foglalva"] < 100000 || ($terulet["Foglalva"] + 7200) <= $ido ? "<b style='color:lightgreen'>Foglalható</b>" : "<b style='color:orange'>".DatumFormat(date("Y-m-d H:i:s", $terulet["Foglalva"] + 7200))."</b>").'</td>
                <td>'.(!is_array($haszon) || !count($haszon) ? "<i>Nincs</i>" : implode(", ", $haszon)).'</td>
            </tr>';

        }

        echo "</table>";
    }
    elseif($a == "aktivitas")
    {
    	$d = $mysql -> query_assoc('SELECT Ertek FROM server WHERE Nev = "Aktivitas"');
    	if(strlen($d['Ertek']))
    	{
    		$aktiv = json_decode($d['Ertek']);
    		
    		echo '<h2>A szerver legaktívabb játékosai</h2><br>';
    		
    		echo '<table width="100%"><tr><td width="33%" class="clear">';
    		
	    		echo '<h3>Az elmúlt egy hónapban</h3><br>';
	    		echo '<table width="100%">
	            	<tr>
	            		<td width="10%">#</td>
	            		<td width="60%">Név</td>
	            		<td width="30%">Idő</td>
	            	</tr>';
	    		
	    		$i = 1;
	    		foreach($aktiv -> Month as $j)
	    		{
	    			echo '<tr><td>' . $i . '</td><td><a href="/jatekosok'.$config['Ext'].'?keres='.$j[1].'">'.$j[1].'</a></td><td>' . round($j[2] / 3600) . ' óra</td></tr>';
	    			$i++;	
	    		}
	    		
	    		echo '</table>';
	    	
	    	echo '</td><td width="33%" class="clear">';
	    	
		    	echo '<h3>Az elmúlt egy hétben</h3><br>';
		    	echo '<table width="100%">
		            	<tr>
		            		<td width="10%">#</td>
		            		<td width="60%">Név</td>
		            		<td width="30%">Idő</td>
		            	</tr>';
		    	 
		    	$i = 1;
		    	foreach($aktiv -> Week as $j)
		    	{
		    		echo '<tr><td>' . $i . '</td><td><a href="/jatekosok'.$config['Ext'].'?keres='.$j[1].'">'.$j[1].'</a></td><td>' . round($j[2] / 3600) . ' óra</td></tr>';
		    		$i++;
		    	}
		    	 
		    	echo '</table>';
	    	
	    	echo '</td><td width="33%" class="clear">';
	    	
		    	echo '<h3>A tegnapi napon</h3><br>';
		    	echo '<table width="100%">
		            	<tr>
		            		<td width="10%">#</td>
		            		<td width="60%">Név</td>
		            		<td width="30%">Idő</td>
		            	</tr>';
		    	 
		    	$i = 1;
		    	foreach($aktiv -> Day as $j)
		    	{
		    		echo '<tr><td>' . $i . '</td><td><a href="/jatekosok'.$config['Ext'].'?keres='.$j[1].'">'.$j[1].'</a></td><td>' . round($j[2] / 3600) . ' óra</td></tr>';
		    		$i++;
		    	}
		    	 
		    	echo '</table>';
	    	
	    	echo '</td></tr></table>';
    	}
    }
    Lablec(false, null, true);
}

Fejlec();
?>

<style type="text/css">
	.informaciok .cim
	{
		font-weight: bold;
		padding: 5px;
		font-size: 110%;
		vertical-align: top;
	}
	.informaciok_info tr td
	{
		text-align: left;
		vertical-align: top;
	}
	.informaciok, .informaciok td
	{
		border: none;
	}
	table{
		border-spacing:0px; }
	td.clear, .cleartr td, .cleartable tr td{
		border: none; }
	.adatok{
		padding: 5px; }
	.adatok hr{
		color:grey; }
	.left{
		text-align: left; }
	img.link{
		cursor: crosshair; }
	img.link:hover{
		cursor: pointer; }
	table.karakter_infok tr td
	{
		text-align:left;
	}
	table.karakter_infok tr td.cim
	{
		font-weight:bold;
		font-size: 125%;
		color:white;
		text-align:center;
		padding: 5px;
		border: none;
	}
	td
	{
		border: 2px outset #444;
		padding: 5px;
		vertical-align: middle;
		text-align:center;
		background-color: #202020;
	}
	table.smallpadding tr td
	{
		padding: 2px;
	}
	table.lefttext tr td
	{
		text-align: left;
	}
	table.noupdownpadding tr td
	{
		padding-top: 2px;
		padding-bottom: 2px;
	}
	.cleartr_jatekos td
	{
		border-top: none;
		border-left: none;
		padding: 0px;
	}
	.cim
	{
		color:white;
		font-weight:bold;
	}
	a.no
	{
		text-decoration:none;
		font-weight:bold;
	}

	.buntetes{
		font-weight: bold;
	}
</style>

<script type="text/javascript">
$(document).ready(function(){
	Betolt("alap");
});
	var effekt = false;
    var ajax = 0;
	function nyit(mit)
	{
		if(effekt) return 1;
		effekt = true;

		if(document.getElementById(mit+"_div").style.display != "none")
		{
			$("#"+mit+"_div").slideToggle(2000, function() { effekt = false; });
			document.getElementById(mit+"_img").src = "img/plus.gif";
		}
		else
		{
			$("#"+mit+"_div").slideToggle(2000, function() { effekt = false; });
			document.getElementById(mit+"_img").src = "img/minus.gif";
		}
	}
function Betolt(mit, extra)
{
    if(ajax)
        return 1;

    ajax = 1;
    $("#ajax").html("<center><b>Betöltés...</b></center>");

    var data = "?ajax&a="+mit;
    if(extra) data += "&" + extra;

    $.ajax({
        type: "POST",
        url: data,
        success: function(msg){
            ajax = 0;
            $("#ajax").html(msg);
        }
    });
}
</script>

<center>
    <h1>Statisztika</h1>
    <b>
        <a href='javascript: void(0);' onclick="Betolt('alap')">Alap / Online</a> - <a href='javascript: void(0);' onclick="Betolt('frakcio')">Frakció</a> - <a href='javascript: void(0);' onclick="Betolt('terulet')">Területek</a> - <a href='javascript: void(0);' onclick="Betolt('aktivitas')">Aktivitás</a>
        <hr width="35%">
    </b>
</center><br>

<div id='ajax' style='display: inline' align="center"></div>

<? Lablec(); ?>