<?
require_once("include/main.php");

if(!$jatekos["Belepve"] || !CheckAdmin() && !IsScripter())
	Error();

Fejlec();

$a = $_GET["akcio"];
$id = $_GET["id"];
if(isset($a))
{
	if(isset($id) && is_numeric($id))
	{
		if($a == "elfogad")
		{
			$sql = mysql_query("SELECT Nev, Mail, IP, Megerositve FROM accountok WHERE id = '".$id."'");
			if(mysql_num_rows($sql) == 1)
			{
				$account = mysql_fetch_array($sql); mysql_free_result($sql);
				if($account["Megerositve"] == 0)
				{
					mysql_query("UPDATE accountok SET Megerositve='1' WHERE id='".$id."'");
					echo Felhivas($account["Nev"] . " megerősítve!");
					SeeLOG("accelf", "<b class='kiemelt'>".$jatekos["LogNev"]."</b> elfogadta <b class='kiemelt'>".$account["Nev"]."</b> accountját! Account: <b class='kiemelt'>".$account["Nev"]."</b> - Mail: ".$account["Mail"]." - IP: ".$account["IP"], $jatekos["ID"], $jatekos["LogNev"], 1);
				}
			}
		}
		elseif($a == "elutasit")
		{
			$sql = mysql_query("SELECT Nev, Mail, IP, Megerositve FROM accountok WHERE id = '".$id."'");
			if(mysql_num_rows($sql) == 1)
			{
				$account = mysql_fetch_array($sql); mysql_free_result($sql);
				if($account["Megerositve"] == 0)
				{
					mysql_query("DELETE FROM accountok WHERE id='".$id."'");
					echo Felhivas($account["Nev"] . " elutasítva és törölve!");
					SeeLOG("accelut", "<b class='kiemelt'>".$jatekos["LogNev"]."</b> elutasította <b class='kiemelt'>".$account["Nev"]."</b> accountját! Account: <b class='kiemelt'>".$account["Nev"]."</b> - Mail: ".$account["Mail"]." - IP: ".$account["IP"], $jatekos["ID"], $jatekos["LogNev"], 1);
				}
			}
		}
	}
}

?>

<style type="text/css">
	table
	{
		border-spacing:0px;
	}
	td
	{
		border: 2px outset #888;
		padding: 5px;
		vertical-align: top;
		text-align:center;
		background-color: #202020;
	}
	td.clear, .cleartr td{border: none;}
	.left
	{
		text-align: left;
	}
	.cim
	{
		color:white;
		font-weight:bold;
	}
	.left li a
	{
		text-decoration:none;
		font-weight:bold;
		color:white;
	}
	.left li a:hover
	{
		color:yellow;
	}
	img.link
	{
		cursor: crosshair;
	}
	img.link:hover
	{
		cursor: pointer;
	}
</style>

<script type="text/javascript">
	function AdminAkcio(id, elfogad)
	{
		if(elfogad && confirm("Biztosan elfogadod az account regisztrációt?"))
			window.location.href = "admin_account<?=$config['Ext']?>?akcio=elfogad&id="+id;
		else if(!elfogad && confirm("Biztosan elutasítod az account regisztrációt?"))
			window.location.href = "admin_account<?=$config['Ext']?>?akcio=elutasit&id="+id;
	}
</script>

<center><h1>Account regisztrációk</h1></center>

<center><table width="100%" align=center>
	<tr>
		<td width="25%" class="cim">Account</td>
		<td width="25%" class="cim">E-Mail</td>
		<td width="20%" class="cim">IP</td>
		<td width="20%" class="cim">Dátum</td>
		<td width="10%" class="cim">Admin</td>
	</tr>
<?
	$sql = mysql_query("SELECT * FROM accountok WHERE megerositve != '1' ORDER BY regisztralt ASC");
	if(mysql_num_rows($sql) == 0)
		echo "<tr><td colspan='5' class='clear'>Nincs megerősítetlen account</td></tr>";
	while($acc = mysql_fetch_array($sql))
	{
		echo"	<tr class='cleartr'>
					<td>".$acc["Nev"]."</td>
					<td>".$acc["Mail"]."</td>
					<td>".$acc["IP"]."</td>
					<td>".$acc["Regisztralt"]."</td>
					<td>
					<img class='link' src='img/elfogad.png' height='15' onClick='return AdminAkcio(\"".$acc["ID"]."\", true);'> 
					<img class='link' src='img/torol.png' height='15' onClick='return AdminAkcio(\"".$acc["ID"]."\", false);'>
					</td>
				</tr>";
	}
?>
</table></center>

<!--#############################################################################################################-->
<!--#############################################################################################################-->
<!--#############################################################################################################-->

<br><table width="100%" align="center" border="1">
				<tr class="cleartr cim">
					<td width="80%" class="nopadding" style="padding-top: 3px">Esemény</td>
					<td width="20%" class="nopadding" style="padding-top: 3px">Időpont</td>
				</tr><tr class="cleartr"><td colspan="2" class="nopadding"><br></td></tr>
<?
$sql = mysql_query("SELECT Log, Datum, Tipus FROM log WHERE tipus='accelf' OR tipus='accelut' ORDER BY Datum DESC LIMIT 5");
while($log = mysql_fetch_array($sql))
{
	echo"<tr>
			<td class='bal'><img src='img/".($log["Tipus"] == "accelf" ? "plus" : "minus").".gif'> ".$log["Log"]."</td>
			<td class='jobb'>".DatumFormat($log["Datum"])."</td>
		 </tr>";
}
?>
</table><br>

<!--#############################################################################################################-->
<!--#############################################################################################################-->
<!--#############################################################################################################-->

<? Lablec(); ?>