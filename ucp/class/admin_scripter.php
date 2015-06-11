<?
if(isset($_POST["CsTeszt"]) && $_POST["CsTeszt"] == "igen" || isset($_POST["CsFo"]) && $_POST["CsFo"] == "igen" ||
isset($_POST['submit']) && isset($_POST['tipus']) || isset($_POST['object']) && isset($_POST['tipus2']))
	echo"<meta http-equiv=refresh content=\"3;url=http://ucp.classrpg.net/admin_scripter.web\">";
	
require_once("include/main.php");

if(!$jatekos["Belepve"] || !IsScripter())
	Error();

Fejlec();
	$d=1;
	$config["FoAlap"] = "/games/samp";
	$teszt="ClassTeszt";
	$fo="ClassRPG";
	$tomoritet=$config["FoAlap"]."/".$teszt."/gamemodes/ClassRPG.zip";
	$tomoritetfilter=$config["FoAlap"]."/".$teszt."/filterscripts/Objectek.zip";
	$tomoritet2=$config["FoAlap"]."/".$fo."/gamemodes/ClassRPG.zip";
	$tomoritetfilter2=$config["FoAlap"]."/".$fo."/filterscripts/Objectek.zip";
	
if( file_exists( $tomoritet))
{
	echo Felhivas("Tömörített fálj TESZTEN létezik:".$tomoritet."<br>");
	$teszten=1;
}
else if( file_exists( $tomoritetfilter))
{
	echo Felhivas("Tömörített fálj TESZTEN létezik:".$tomoritetfilter."<br>");
	$teszten=1;
}
else $teszten=0;
if( file_exists( $tomoritet2))
{
	echo Felhivas("Tömörített fálj FŐSZERVEREN létezik:".$tomoritet2."<br>");
	$foszerver=1; 
}
else if( file_exists( $tomoritetfilter2))
{
	echo Felhivas("Tömörített fálj FŐSZERVEREN létezik:".$tomoritetfilter2."<br>");
	$foszerver=1; 
}
else $foszerver=0;


if(isset($_POST["CsTeszt"]) && $_POST["CsTeszt"] == "igen" || isset($_POST["CsFo"]) && $_POST["CsFo"] == "igen")
{
	if($_POST["CsFo"] == "igen")
		$eleres=$config["FoAlap"]."/".$fo;
	else
		$eleres=$config["FoAlap"]."/".$teszt;
		
	if( file_exists($eleres."/gamemodes/ClassRPG.zip") )
	{
		$file=$eleres."/gamemodes/ClassRPG.amx";
		$atnevezFo=$eleres."/gamemodes/ClassRPG.amx.ori";
		$fomappa=$eleres."/gamemodes";
		$tomoritet=$eleres."/gamemodes/ClassRPG.zip";
	}
	else if( file_exists($eleres."/filterscripts/Objectek.zip") )
	{
		$file=$eleres."/filterscripts/Objectek.amx";
		$atnevezFo=$eleres."/filterscripts/Objectek.amx.ori";
		$fomappa=$eleres."/filterscripts";
		$tomoritet=$eleres."/filterscripts/Objectek.zip";
	}
	else Felhivas("Nincs mit kitömöríteni!");
	
	if( file_exists( $tomoritet) )
	{
		if( file_exists( $file) )
		{
			$ciklus = 0;
			while($ciklus != 1)
			{
				$atnevez=$atnevezFo.$d;
				
				if(file_exists( $atnevez))
					$d++;
				else
					$ciklus = 1;
			}
			echo Felhivas("Alap AMX Átnevezés:".$atnevez."<br>");	
			rename($file, $atnevez);

		}
			
		
		$zip = new ZipArchive;
		if ($zip->open($tomoritet) === TRUE)
		{
			$zip->extractTo($fomappa);
			$zip->close();
			echo Felhivas("Tömörített fálj kicsomagolva<br>");
			unlink($tomoritet);
		} 
		else 
			echo Felhivas("failed");
			
	}
	
}

if(isset($_POST['submit']) && isset($_POST['tipus']))
{
	$fomappa="/games/samp/".$_POST['tipus']."/gamemodes";
	

	$file_name = $_FILES['file']['name']; 
	$tmp_dir = $_FILES['file']['tmp_name']; 

	if(!preg_match('/ClassRPG.zip$/i', $file_name))
	{
		echo Felhivas("Rossz fajltipus!"); 
	}
	else
	{
		$cel=$fomappa."/".$file_name;
		move_uploaded_file($tmp_dir, $cel); 
		
		
		$feltoltve = true; 
	}
}
$feltoltve = false;
if(isset($_POST['object']) && isset($_POST['tipus2']))
{
	$fomappa="/games/samp/".$_POST['tipus2']."/filterscripts";
	$file_name = $_FILES['file']['name']; 
	$tmp_dir = $_FILES['file']['tmp_name']; 

	if(!preg_match('/Objectek.zip$/i', $file_name))
	{
		echo Felhivas("Rossz fajltipus!"); 
	}
	else
	{
		move_uploaded_file($tmp_dir, $fomappa."/".$file_name); 
		$feltoltve = true; 
	}
}
if($feltoltve)
{
	$utvonal = $fomappa."/".$file_name;
	echo Felhivas("Sikeresen feltöltötted a fáljt: ".$utvonal."!");
}
if(isset($_POST["kuld"]) && $_POST["kuld"] == "igen" && isset($_POST["verzio"]))
{
	$sql = mysql_query("UPDATE server SET ertek='".$_POST["verzio"]."' WHERE nev='verzio'");
	if($sql)
		echo Felhivas("Sikeres frissítés! Új verzió: ".$_POST["verzio"]);
	else
		echo Felhivas("Hiba a frissítés során!");
}

if(isset($_POST["cmd"]) && isset($_POST['cmds']))
{
	$sql = mysql_query("INSERT INTO cmd (cmd, e1, e2) VALUES ('".$_POST["cmd"]."', '".$_POST["ee1"]."', '".$_POST["ees2"]."')");
	
	if($sql)
		echo Felhivas("Parancs beküldve: INSERT INTO cmd (cmd, e1, e2) VALUES ('".$_POST["cmd"]."', '".$_POST["ee1"]."', '".$_POST["ees2"]."')");
	else
		echo Felhivas("Hiba a kérés során!");
}

if(isset($_POST["restart"]))
{
	$sql = mysql_query("INSERT INTO cmd (cmd, e1, e2) VALUES ('4', '".$_POST["e1"]."', '".$_POST["e2"]."')");
	
	if($sql)
		echo Felhivas("Szerver restart beküldve!");
	else
		echo Felhivas("Hiba a kérés során!");
}
if(isset($_POST["kick"]) && isset($_POST["ke1"]))
{
	$sql = mysql_query("INSERT INTO cmd (cmd, e1) VALUES ('5', '".$_POST["ke1"]."')");
	
	if($sql)
		echo Felhivas("KICK beküldve!");
	else
		echo Felhivas("Hiba a kérés során!");
}
?>

<style type="text/css"></style>

<script type="text/javascript"></script>

<center><h1>Scripter</h1></center>
<br>

<form method="POST">
<input type="hidden" name="kuld" value="igen">
<b>Jelenlegi verzió</b>:
<?

$sql = mysql_query("SELECT ertek FROM server WHERE nev='verzio'");
if(mysql_num_rows($sql))
{
	$adat = mysql_fetch_array($sql);
	echo "<input type='text' name='verzio' value='".$adat["ertek"]."' size='10' maxlength='10'>";
}
else
	echo "<input type='text' name='verzio' value=''>";
mysql_free_result($sql);
?>
<input type="submit" value="Frissít" style="padding: 2px">
	</form>
	<br><br>
<?
if($teszten == 1)
{
echo"
	
	<form method=\"POST\">
	<input type=\"hidden\" name=\"CsTeszt\" value=\"igen\">

	 <input type=\"submit\" value=\"Kicsomagol TESZT szerver\" style=\"padding: 2px\">
	</form>";
}
if($foszerver == 1)
{
echo "
	<form method=\"POST\">
	<input type=\"hidden\" name=\"CsFo\" value=\"igen\">

	<input type=\"submit\" value=\"Kicsomagol Fő szerver\" style=\"padding: 2px\">
</form>";
}
?>
<br>
<hr>
<br>
<form enctype="multipart/form-data" action="" method="post" />
<input type="hidden" name="MAX_FILE_SIZE" value="20000000" /> <!--a feltöltött file maximális mérete 2mb-->
<label for="file"> ClassRPG.zip feltöltése :</label><input id="file" type="file" name="file" />
<select name="tipus">
    <option value="ClassTeszt">Teszt szerver</option>
    <option value="ClassRPG">Fő szerver</option>

</select>
<input type="submit" name="submit" value="Feltöltés!" />
</form>
<br>
<hr>
<form enctype="multipart/form-data" action="" method="post" />
<input type="hidden" name="MAX_FILE_SIZE" value="2000000" /> <!--a feltöltött file maximális mérete 2mb-->
<label for="file"> Objectek.zip feltöltése :</label><input id="file" type="file" name="file" />
<select name="tipus2">
    <option value="ClassTeszt">Teszt szerver</option>
    <option value="ClassRPG">Fő szerver</option>

</select>
<input type="submit" name="object" value="Feltöltés!" />
</form>
<br>
<br>
<form action="" method="post" />

<b>Szerver restart indítása:</b>
<br>
	<input type="text" name="e1" value="180">
	<input type="text" name="e2" value="60">
<input type="submit" name="restart" value="Indítás!" />
</from>
<br>
<hr>
<br>

<form action="" method="post" />

<b>UID alapú KICK:</b>
<br>
	<input type="text" name="ke1" value="">
</select>
<input type="submit" name="kick" value="Kickelés!" />
</from>
<br>
<hr>
<br>

<form action="" method="post" />

<b>CMD parancs küldés:</b>
<br>
<select name="cmd">
    <option value="1">CMD_KAPU_BETOLT e1:SQLID</option>
    <option value="2">CMD_KAPU_TOROL e1:SQLID</option>
	<option value="3">CMD_KAPU_RELOAD e1:SQLID</option>
	<option value="4">CMD_SZERVER_RESTART e1:idő e2:idő</option>
	<option value="5">CMD_UCP_RUHA e1:pénz</option>
	<option value="6">CMD_UCP_UTALAS e1:bankba pénz</option>
</select>
	<input type="text" name="ee1" value="e1">
</select>
<input type="text" name="ee2" value="e2">
</select>
<input type="submit" name="cmds" value="beküldés!" />
</from>


<? Lablec(); ?>