<?
require_once("include/main.php");

if(isset($_GET["edit"]) && $jatekos["Admin"] && isset($_POST["mail"]) /*&& isset($_POST["msn"])*/ && isset($_POST["help"]))
{
	$mail = trim(addslashes($_POST["mail"]));
	//$msn = trim(addslashes($_POST["msn"]));
	$info = trim(addslashes($_POST["help"]));

	if(strlen($mail) > 50 /*|| strlen($msn) > 50*/ || strlen($info) > 1024)
	{
		header('Location: kapcsolat'.$config['Ext']);
		exit;
	}

	$info = str_replace("\n", "<br>", $info);

//	mysql_query("UPDATE accountok SET CMail='".$mail."', CMSN='".$msn."', CInfo='".$info."' WHERE ID='".$jatekos["ID"]."'");
	mysql_query("UPDATE accountok SET CMail='".$mail."', CInfo='".$info."' WHERE ID='".$jatekos["ID"]."'");
	header('Location: kapcsolat'.$config['Ext']);
	exit;
}

Fejlec();

?>

<style type="text/css">
center > * {text-align: center;}
</style>

<script type="text/javascript">

function chere($txt){
        $mit  = array("á","é","í","ó","ö","ü","ű","ú","Á","É","Í","Ó","Ö","Ü","Ű","Ú","ä","Ä","ß","§" );
  $mire = array("&#225;","&#233;","&#237;","&#243;","&#246;","&#252;","ű","&#250;","&#193;","&#201;","&#205;","&#211;","&#214;","&#220;","Ű","&#218;","&#228;","&#196;","&#223;","&#167;");
        return(str_replace($mit,$mire,$txt))        ;
}

function mutat(id)
{
	if($('#kep_'+id).attr("src") == "img/plus.gif")
	{
		$('#kep_'+id).attr("src", "img/minus.gif");
		$('#info_'+id).css("display", "block");
	}
	else
	{
		$('#kep_'+id).attr("src", "img/plus.gif");
		$('#info_'+id).css("display", "none");
	}
}

</script>

<center><h1>Kapcsolat</h1></center>

<center>

<table>

<br><br>

<h2 style='color: white'>Vezetőség</h2>

<table width='100%'>
<tr class='cim'>
	<td width="25%">Név</td>
	<td width="35%">Elérhetőség</td>
	<td width="40%">Amivel kapcsolatban felkeresheted</td>
</tr>

<?
$sql = mysql_query("SELECT ID, Nev, Online FROM playerek WHERE ID = 8181898 OR ID = 5637 OR ID = 4038 ORDER BY Nev");
if(mysql_num_rows($sql)) while($admin = mysql_fetch_array($sql))
{
//	$sql2 = mysql_query("SELECT CMail, CMSN, CInfo FROM accountok WHERE Karakter1='".$admin["ID"]."' OR Karakter2='".$admin["ID"]."'");
	$sql2 = mysql_query("SELECT CMail, CInfo FROM accountok WHERE Karakter1='".$admin["ID"]."' OR Karakter2='".$admin["ID"]."'");
	if(mysql_num_rows($sql2) != 1)
	{
		mysql_free_result($sql2);
		continue;
	}

	$info = mysql_fetch_array($sql2);
	mysql_free_result($sql2);

	if(strlen($info["CInfo"]))
		$inf = "<td onclick='mutat(\"".$admin["ID"]."\")' class='kez'><img src='img/plus.gif' id='kep_".$admin["ID"]."'><div id='info_".$admin["ID"]."' style='display: none'>".$info["CInfo"]."</div></td>";
	else
		$inf = "<td></td>";

	echo "<tr><td style='font-weight: bold; color: white'>".$admin["Nev"].($admin["Online"] == '1' ? "<br><b style='color:white'>Online</b>" : "")."</td><td>".(strlen($info["CMail"]) ? "<b>E-Mail:</b> ".mailConvert($info["CMail"]) : "")."</td>".$inf."</tr>";
}
?>

</table>

<br><br>

<h2 style='color: orange'>Scripterek</h2>

<table width='100%'>
<tr class='cim'>
	<td width="25%">Név</td>
	<td width="35%">Elérhetőség</td>
	<td width="40%">Amivel kapcsolatban felkeresheted</td>
</tr>


<?
$sql = mysql_query("SELECT ID, Nev, Online FROM playerek WHERE ID = 8183364 OR ID = 2326 OR ID = 234 OR ID = 8177822 ORDER BY Nev");
if(mysql_num_rows($sql)) while($admin = mysql_fetch_array($sql))
{
//	$sql2 = mysql_query("SELECT CMail, CMSN, CInfo FROM accountok WHERE Karakter1='".$admin["ID"]."' OR Karakter2='".$admin["ID"]."'");
	$sql2 = mysql_query("SELECT CMail, CInfo FROM accountok WHERE Karakter1='".$admin["ID"]."' OR Karakter2='".$admin["ID"]."'");
	if(mysql_num_rows($sql2) != 1)
	{
		mysql_free_result($sql2);
		continue;
	}

	$info = mysql_fetch_array($sql2);
	mysql_free_result($sql2);

	if(strlen($info["CInfo"]))
		$inf = "<td onclick='mutat(\"".$admin["ID"]."\")' class='kez'><img src='img/plus.gif' id='kep_".$admin["ID"]."'><div id='info_".$admin["ID"]."' style='display: none'>".$info["CInfo"]."</div></td>";
	else
		$inf = "<td></td>";

	echo "<tr><td style='font-weight: bold; color: orange'>".$admin["Nev"].($admin["Online"] == '1' ? "<br><b style='color:white'>Online</b>" : "")."</td><td>".(strlen($info["CMail"]) ? "<b>E-Mail:</b> ".mailConvert($info["CMail"]) : "")."</td>".$inf."</tr>";
}
?>

</table>

<br><br>

<h2 style='color: lightblue'>FőAdminisztrátorok</h2>
<table width='100%'>
<tr class='cim'>
	<td width="25%">Név</td>
	<td width="35%">Elérhetőség</td>
	<td width="40%">Amivel kapcsolatban felkeresheted</td>
</tr>

<?
$sql = mysql_query("SELECT ID, Nev, Online FROM playerek WHERE ID = 6876 OR ID = 8174654 OR ID = 5326 OR ID = 8172362 ORDER BY Nev");
if(mysql_num_rows($sql)) while($admin = mysql_fetch_array($sql))
{
//	$sql2 = mysql_query("SELECT CMail, CMSN, CInfo FROM accountok WHERE Karakter1='".$admin["ID"]."' OR Karakter2='".$admin["ID"]."'");
	$sql2 = mysql_query("SELECT CMail, CInfo FROM accountok WHERE Karakter1='".$admin["ID"]."' OR Karakter2='".$admin["ID"]."'");
	if(mysql_num_rows($sql2) != 1)
	{
		mysql_free_result($sql2);
		continue;
	}

	$info = mysql_fetch_array($sql2);
	mysql_free_result($sql2);

	if(strlen($info["CInfo"]))
		$inf = "<td onclick='mutat(\"".$admin["ID"]."\")' class='kez'><img src='img/plus.gif' id='kep_".$admin["ID"]."'><div id='info_".$admin["ID"]."' style='display: none'>".$info["CInfo"]."</div></td>";
	else
		$inf = "<td></td>";

//	echo "<tr><td style='font-weight: bold; color: lightgreen'>".$admin["Nev"].($admin["Online"] == '1' ? "<br><b style='color:white'>Online</b>" : "")."</td><td>".(strlen($info["CMail"]) ? "<b>E-Mail:</b> ".mailConvert($info["CMail"]) : "").(strlen($info["CMSN"]) ? (strlen($info["CMail"]) ? "<br><b>MSN:</b> ".mailConvert($info["CMSN"]) : "<b>MSN:</b> ".mailConvert($info["CMSN"])) : "")."</td>".$inf."</tr>";
	echo "<tr><td style='font-weight: bold; color: lightblue'>".$admin["Nev"].($admin["Online"] == '1' ? "<br><b style='color:white'>Online</b>" : "")."</td><td>".(strlen($info["CMail"]) ? "<b>E-Mail:</b> ".mailConvert($info["CMail"]) : "")."</td>".$inf."</tr>";
}
?>

</table>

<br><br>

<h2 style='color: lightgreen'>Adminisztrátorok</h2>
<table width='100%'>
<tr class='cim'>
	<td width="25%">Név</td>
	<td width="35%">Elérhetőség</td>
	<td width="40%">Amivel kapcsolatban felkeresheted</td>
</tr>

<?
$sql = mysql_query("SELECT ID, Nev, Online FROM playerek WHERE ID = 8179684 OR ID = 8178556 OR ID = 8179160 OR ID = 6122 OR ID = 4879 OR ID = 8172295 OR ID = 8175452 ORDER BY Nev");
if(mysql_num_rows($sql)) while($admin = mysql_fetch_array($sql))
{
//	$sql2 = mysql_query("SELECT CMail, CMSN, CInfo FROM accountok WHERE Karakter1='".$admin["ID"]."' OR Karakter2='".$admin["ID"]."'");
	$sql2 = mysql_query("SELECT CMail, CInfo FROM accountok WHERE Karakter1='".$admin["ID"]."' OR Karakter2='".$admin["ID"]."'");
	if(mysql_num_rows($sql2) != 1)
	{
		mysql_free_result($sql2);
		continue;
	}

	$info = mysql_fetch_array($sql2);
	mysql_free_result($sql2);

	if(strlen($info["CInfo"]))
		$inf = "<td onclick='mutat(\"".$admin["ID"]."\")' class='kez'><img src='img/plus.gif' id='kep_".$admin["ID"]."'><div id='info_".$admin["ID"]."' style='display: none'>".$info["CInfo"]."</div></td>";
	else
		$inf = "<td></td>";

//	echo "<tr><td style='font-weight: bold; color: lightgreen'>".$admin["Nev"].($admin["Online"] == '1' ? "<br><b style='color:white'>Online</b>" : "")."</td><td>".(strlen($info["CMail"]) ? "<b>E-Mail:</b> ".mailConvert($info["CMail"]) : "").(strlen($info["CMSN"]) ? (strlen($info["CMail"]) ? "<br><b>MSN:</b> ".mailConvert($info["CMSN"]) : "<b>MSN:</b> ".mailConvert($info["CMSN"])) : "")."</td>".$inf."</tr>";
	echo "<tr><td style='font-weight: bold; color: lightgreen'>".$admin["Nev"].($admin["Online"] == '1' ? "<br><b style='color:white'>Online</b>" : "")."</td><td>".(strlen($info["CMail"]) ? "<b>E-Mail:</b> ".mailConvert($info["CMail"]) : "")."</td>".$inf."</tr>";
}
?>

</table>

<br><?=Felhivas("A Főadminokat,Scriptereket, és Vezetőségi tagokat, mindig a Főadmin Fógadóóra fórumrészükben keresd először!", 1);?><br>
<?
if($jatekos["Admin"])
{
//	$sql = mysql_query("SELECT CMail, CMSN, CInfo FROM accountok WHERE ID='".$jatekos["ID"]."'");
	$sql = mysql_query("SELECT CMail, CInfo FROM accountok WHERE ID='".$jatekos["ID"]."'");
	if($sql)
	{
		$data_a = mysql_fetch_array($sql);

		$data_a["CInfo"] = str_replace("<br>", "\n", $data_a["CInfo"]);

		echo'<br><form method="POST" action="?edit">
		E-Mail: <input type="text" name="mail" value="'.$data_a["CMail"].'"><br>
		<!--MSN: <input type="text" name="msn" value="'.$data_a["CMSN"].'"><br>-->
		<br>Amiben segíteni tudsz:<br>
		<textarea name="help" rows="10" cols="50">'.$data_a["CInfo"].'</textarea>
		<br><br>
		<input type="submit" value="Módosítás">
		</form>';
		mysql_free_result($sql);
	}
}
?>

</center>



<? Lablec(); ?>