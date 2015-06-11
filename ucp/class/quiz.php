<?
require_once("include/main.php");

if(!$jatekos["Belepve"])
	Error();

require_once("include/statinfo.php");

$probaido = 10;
$probatime = 600;
$quizido = 604800; // 1hét

$ajanlott = Array("Szerverszabályzat", "Szabályzat", "RolePlay", "Report", "DM", "PG", "RK", "DB", "SK", "OOC", "MG", "Törvénykönyv");

session_start();
//define("JFORMER", 1);
//if(defined("JFORMER")) require_once("include/jformer.php");

$time = time();

function Generalas()
{
	global $quizcats;
	foreach($quizcats as $id => $quizq)
	{
		$ks = Array();

		$query = mysql_query("SELECT ID FROM quiz WHERE Kategoria='".$id."' ORDER BY RAND() LIMIT ".$quizq["db"]);
		while($q = mysql_fetch_array($query)) $ks[] = $q["ID"];
		mysql_free_result($query);

		$db = count($ks);
		if($db != $quizq["db"]) return 0;
		//sort($ks);
		shuffle($ks);

		if($quizq["db"] > 10)
		{
			$db = 1; $x = 1;
			while($x < $quizq["db"])
			{
				if($x % 10 == 1) $_SESSION[ $quizq["ID"] . $db ] = Array($ks[$x-1]);
				elseif($x % 10 != 10) $_SESSION[ $quizq["ID"] . $db ][] = $ks[$x-1];
				else
				{
					$_SESSION[ $quizq["ID"] . $db ][] = $ks[$x-1];
					$db++;
				}
				$x++;
			}
		}
		else
		{
			$x = 1;
			while($x <= $quizq["db"])
			{
				if($x == 1) $_SESSION[ $quizq["ID"] ] = Array($ks[$x-1]);
				elseif($x != 10) $_SESSION[ $quizq["ID"] ][] = $ks[$x-1];
				else
				{
					$_SESSION[ $quizq["ID"] ][] = $ks[$x-1];
					$db++;
				}
				$x++;
			}
		}
	}
	return 1;
}

function Kerdesek($nev)
{
	$k = 1;
	while($k <= 10)
	{
		//if($k == 1)
		//	echo "<center><table width='100%' align='center'><tr><td style='text-align:left; vertical-align: top;' class='clear' width='50%'>";
		//elseif($k == 6)
		//	echo "</td><td style='text-align:left; vertical-align: top;' class='clear'>";
		if($k == 1)
			echo "<center><input type='hidden' id='kerdesek' value='".implode(",", $_SESSION[$nev])."'><table width='100%' align='center' class='quiz clear'><tr><td width='50%'>";
		elseif($k % 2 == 1)
			echo "</td></tr><tr><td>";
		elseif($k % 2 == 0)
			echo "</td><td>";

		if($k != 1 && $k != 2)
			echo "<hr><br>";

		$id = $_SESSION[$nev][$k-1];
		$query = mysql_query("SELECT Kerdes, Valaszok, Helyes FROM quiz WHERE ID='".$id."'");
		$kerdes = mysql_fetch_array($query);

		$kerdes["Valaszok"] = explode(";", $kerdes["Valaszok"]);
		
		$valaszok = Array();

		$vid = 1;
		foreach($kerdes["Valaszok"] as $v)
		{
			$valaszok[] = Array("ID" => $vid, "Q" => $v);
			$vid++;
		}

		shuffle($valaszok);

		echo "<b>".$kerdes["Kerdes"]."</b><br>";
		foreach($valaszok as $v)
		{
			echo "&nbsp;&nbsp;&nbsp;<input type='radio' name='".$id."' id='".$id."_".$v["ID"]."'> <label for='".$id."_".$v["ID"]."'>".$v["Q"]."</label><br>";
		}

		if($k == 10)
			echo "</td></tr></table></center>";

		$k++;
	}
}
if(isset($_GET["ajax"]))
{
	$time = time();

	if($jatekos["Teszt"] < 0 && abs($jatekos["Teszt"]) > $time)
	{
		echo "A teszten megbuktál. A következő időpont után újra lehetőséged nyílik kitölteni: ".DatumFormat(date("Y-m-d H:i:s", abs($jatekos["Teszt"])));
		AjaxExit();
	}
	if($jatekos["Teszt"] > $time)
	{
		echo "A tesztet sikeresen kitöltötted. Érvényes: ". date("Y-m-d H:i:s", $jatekos["Teszt"]);
		if($jatekos["Karakterek"] >= 1 && $jatekos["Karakter"][0]["Tutorial"] < $time)
		{
			if($jatekos["Karakter"][0]["Online"])
				echo "<br>- A ".$jatekos["Karakter"][0]["Nev"]." nevű karakterednek nincs jogosultsága a szintlépéshez, jogosultságot úgy szerezhetsz, hogy kilépsz a játékból, és frissíted ezt a lapot (F5)";
			else
			{
				@mysql_query("UPDATE playerek SET Tutorial='".$jatekos["Teszt"]."' WHERE ID='".$jatekos["Karakter"][0]["ID"]."'");
				echo "<br>- A ".$jatekos["Karakter"][0]["Nev"]." nevű karaktered megkapta a szintlépési jogosultságot, amíg a teszt érvényessége tart";
			}
		}
		if($jatekos["Karakterek"] >= 2 && $jatekos["Karakter"][1]["Tutorial"] < $time)
		{
			if($jatekos["Karakter"][1]["Online"])
				echo "<br>- A ".$jatekos["Karakter"][1]["Nev"]." nevű karakterednek nincs jogosultsága a szintlépéshez, jogosultságot úgy szerezhetsz, hogy kilépsz a játékból, és frissíted ezt a lapot (F5)";
			else
			{
				@mysql_query("UPDATE playerek SET Tutorial='".$jatekos["Teszt"]."' WHERE ID='".$jatekos["Karakter"][1]["ID"]."'");
				echo "<br>- A ".$jatekos["Karakter"][1]["Nev"]." nevű karaktered megkapta a szintlépési jogosultságot, amíg a teszt érvényessége tart";
			}
		}
		AjaxExit();
	}

	if(!isset($_SESSION["quiz"]))
	{
		if(!isset($_GET["go"]))
		{
			echo "A teszt kitöltésének megkezdéséhez kattints <a href='javascript:void(0)' onclick='Folytat()'>ide</a>";
			AjaxExit();
		}
		else $_SESSION["quiz"] = 0;
	}

	$q = $_SESSION["quiz"];

	if(!$q)
	{
		if(!Generalas())
		{
			echo "Hiba történt";
			AjaxExit();
		}
		$q = ++$_SESSION["quiz"];
		$_SESSION["started"] = time();
	}

	if(isset($_POST["valaszok"]))
	{
		$valaszok = explode(",", $_POST["valaszok"]);
		if(count($valaszok) != 10)
		{
			echo "Hiba történt (#3)";
			AjaxExit();
		}
		foreach($valaszok as $v)
		{
			$c = explode(":", $v);
			if(!is_numeric($c[0]) || !is_numeric($c[1]))
			{
				echo "Hiba történt (#4)";
				AjaxExit();
			}
			$query = mysql_query("SELECT Kerdes, Helyes FROM quiz WHERE ID='".$c[0]."'");
			$q = mysql_fetch_array($query); mysql_free_result($query);

			if($c[1] != $q["Helyes"])
			{
				$ujproba = $time + $probatime;
				mysql_query("UPDATE accountok SET Teszt='". ($ujproba * -1) ."' WHERE ID='".$jatekos["ID"]."'");
				echo "A teszten megbuktál. A \"".$q["Kerdes"]."\" kérdésre hibás választ adtál. Megpróbálhatod újra ".$probaido." perc múlva (".date("Y-m-d H:i:s", $ujproba).")";
				SeeLOG("tesztfail", "<b class='kiemelt'>".$jatekos["Nev"]."</b> sikertelenül töltötte ki a tesztet. Elhibázott kérdés: ".$q["Kerdes"]." (". ($time-$_SESSION["started"]) ."mp)", $jatekos["ID"], $jatekos["Nev"], 1);
				session_unset();
				AjaxExit();
			}
		}
		$q = ++$_SESSION["quiz"];
	}

	if($q <= 3)
	{
		$cats = Array("alap", "kresz", "szitu");
		if(!isset($_SESSION[ $cats[$q-1] ]) || count($_SESSION[ $cats[$q-1] ]) != 10)
		{
			echo "Hiba történt (#5)";
			AjaxExit();
		}
	}
	else
	{
		$siker = $time + $quizido;
		mysql_query("UPDATE accountok SET Teszt='". $siker ."' WHERE ID='".$jatekos["ID"]."'");
		echo "Sikeresen megírtad a tesztet. A következő egy hétben lehetőséged nyílik új karaktert regisztrálni, vagy szintet lépni. (Érvényes: ".date("Y-m-d H:i:s", $siker).")";
		SeeLOG("tesztok", "<b class='kiemelt'>".$jatekos["Nev"]."</b> sikeresen kitöltötte a tesztet (". ($time-$_SESSION["started"]) ."mp)", $jatekos["ID"], $jatekos["Nev"], 1);

		if($jatekos["Karakterek"] >= 1)
		{
			if($jatekos["Karakter"][0]["Online"])
			{
				echo "<br>- A ".$jatekos["Karakter"][0]["Nev"]." nevű karakterednek nincs jogosultsága a szintlépéshez, jogosultságot úgy szerezhetsz, hogy kilépsz a játékból, és frissíted ezt a lapot (F5)";
			}
			else
			{
				@mysql_query("UPDATE playerek SET Tutorial='".$siker."' WHERE ID='".$jatekos["Karakter"][0]["ID"]."'");
				echo "<br>- A ".$jatekos["Karakter"][0]["Nev"]." nevű karaktered megkapta a szintlépési jogosultságot, amíg a teszt érvényessége tart";
			}
		}
		if($jatekos["Karakterek"] >= 2)
		{
			if($jatekos["Karakter"][1]["Online"])
			{
				echo "<br>- A ".$jatekos["Karakter"][1]["Nev"]." nevű karakterednek nincs jogosultsága a szintlépéshez, jogosultságot úgy szerezhetsz, hogy kilépsz a játékból, és frissíted ezt a lapot (F5)";
			}
			else
			{
				@mysql_query("UPDATE playerek SET Tutorial='".$siker."' WHERE ID='".$jatekos["Karakter"][1]["ID"]."'");
				echo "<br>- A ".$jatekos["Karakter"][1]["Nev"]." nevű karaktered megkapta a szintlépési jogosultságot, amíg a teszt érvényessége tart";
			}
		}

		session_unset();
		AjaxExit();
	}

	Kerdesek( $cats[$q-1] );

	echo "<br><br><center><button onclick='Folytat()'>Folytatás</button></center>";

	AjaxExit();
}

Fejlec();
//Print_r2($_SESSION);
?>

<style type="text/css">
table.quiz tr td
{
	text-align:left;
	vertical-align: top;
}
</style>

<script type="text/javascript">
var ajax = 0;

$(document).ready(function() {
	Betolt();
});

function Folytat()
{
	if(ajax) return 1;

	if($('#kerdesek').length)
	{
		var kerdesek = $('#kerdesek').val().split(',');
		var megadott = Array();
		var hiba = 0;
		var i = 1;

		for(var q in kerdesek)
		{
			i = 1;
			hiba = 1;
			while($('#'+kerdesek[q]+'_'+i).length)
			{
				if($('#'+kerdesek[q]+'_'+i).attr("checked"))
				{
					hiba = 0;
					megadott.push(kerdesek[q]+":"+i);
					break;
				}
				i++;
			}
			if(hiba)
				return alert("Töltsd ki a teljes tesztet!");
		}

		if(megadott.length)
			Betolt('', 'valaszok='+megadott);
	}
	else
		Betolt("go");
}

function Betolt(extra, post)
{
	if(ajax) return alert("Egy kérés már futás alatt van");

	ajax = 1;

	cim = "?ajax";
	if(extra && extra.length)
		cim = cim +"&"+ extra;

	if(post)
		adat = post;
	else
		adat = null;

	$("#ajax").html("<center><b>Betöltés...</b></center>");
	$.ajax({
		type: "POST",
		url: cim,
		data: adat,
		success: function(msg){
			ajax = 0;
			$("#ajax").html(msg);
		}
	});
}
</script>

<center><h1>Teszt</h1>

<table width='90%'><tr><td class="border-radius" style='border: 3px double white; color: #5D5; background-color: #444; text-align: justify; font-weight: bold;'>
A teszt egy több kategóriából álló kérdések összessége. A kitöltése kötelező a karakter szintlépéséhez. A kitöltése után egy hétig lehet szintet lépni. Az egy hét elteltével ismét szükséges a teszt kitöltése. Ha elbuktál rajta, ne aggódj, olvasd át a wikipédiánkon lévő bejegyzéseket, és <?=$probaido?>perc múlva újból megpróbálhatod.<br>
<br>
Főbb olvasmány: <a href='http://wiki.<?=$config["WNev"]?>/Kerdesek' target='_BLANK'>Tesztkérdések</a><br>
Egyéb: <? foreach($ajanlott as $a) echo "<a href='http://wiki.".$config["WNev"]."/".$a."' target='_BLANK'>".$a."</a>&nbsp;&nbsp;&nbsp;"; ?>
</td></tr></table>

<br>

<table width='90%'><tr><td class="border-radius" style='border: 3px double white; color: #EEE; background-color: #444; text-align: justify; font-weight: bold;'><div id='ajax' stlye='display: inline'>
</div></td></tr></table>

</center>

<? Lablec(); ?>