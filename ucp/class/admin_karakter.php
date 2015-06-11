<?
require_once("include/main.php");

if(!$jatekos["Belepve"] || !CheckAdmin() && !$config['Amos'])
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
			$sql = mysql_query("SELECT ID, Nev, Karakterek, Letrehozas, Letrehozando FROM accountok WHERE id = '".$id."'");
			if(mysql_num_rows($sql) == 1)
			{
				$account = mysql_fetch_array($sql); mysql_free_result($sql);
				if($account["Letrehozas"] == 1)
				{
					$kari = explode(",", $account["Letrehozando"]);
					$query = mysql_query("INSERT INTO playerek(Nev, Pass, Sex, Age, Origin, Skin, Model, Money)
					VALUES('".$kari[0]."', '".$kari[1]."', '".($kari[2] == "ferfi" ? '1' : '2')."', '".$kari[4]."', '".($kari[3] == "usa" ? '1' : ($kari[3] == "europa" ? '2' : '3'))."', '".($kari[2] == "ferfi" ? '230' : '75')."', '".($kari[2] == "ferfi" ? '230' : '75')."', '350000')");
					if(!$query) echo Felhivas("MySQL hiba a karakter készítés közben");
					else
					{
						mysql_query("UPDATE accountok SET Letrehozas = '0', Karakterek = Karakterek + 1, Karakter".($account["Karakterek"] == 0 ? "1" : "2")."='".mysql_insert_id()."' WHERE id='".$id."'");
						echo Felhivas($kari[0] . " megerősítve és karakter létrehozva az adatbázisban!");
						SeeLOG("karelf", "<b class='kiemelt'>".$jatekos["LogNev"]."</b> elfogadta <b class='kiemelt'>".$account["Nev"]."</b> karakterét! Karakter: <b class='kiemelt'>".$kari[0]."</b> - IP: ".$kari[5], $jatekos["ID"], $jatekos["LogNev"], 1);
						SeeLOG("u_karelf", "Egy adminisztrátor elfogadta a regisztrálni kívánt karakteredet: ".$kari[0], $account["ID"], $account["Nev"], 0, 1);
					}
				}
			}
		}
		elseif($a == "elutasit")
		{
			$sql = mysql_query("SELECT ID, Nev, Letrehozas, Letrehozando FROM accountok WHERE id = '".$id."'");
			if(mysql_num_rows($sql) == 1)
			{
				$account = mysql_fetch_array($sql); mysql_free_result($sql);
				if($account["Letrehozas"] == 1)
				{
					$kari = explode(",", $account["Letrehozando"]);
					mysql_query("UPDATE accountok SET Letrehozas='0' WHERE id='".$id."'");
					echo Felhivas($kari[0] . " elutasítva!");
					SeeLOG("karelut", "<b class='kiemelt'>".$jatekos["LogNev"]."</b> elutasította <b class='kiemelt'>".$account["Nev"]."</b> karakterét! Karakter: <b class='kiemelt'>".$kari[0]."</b> - IP: ".$kari[5], $jatekos["ID"], $jatekos["LogNev"], 1);
					SeeLOG("u_karelut", "Egy adminisztrátor elutasította a regisztrálni kívánt karakteredet: ".$kari[0], $account["ID"], $account["Nev"], 0, 1);
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
		if(elfogad && confirm("Biztosan elfogadod a karakter regisztrációt?"))
			window.location.href = "admin_karakter<?=$config['Ext']?>?akcio=elfogad&id="+id;
		else if(!elfogad && confirm("Biztosan elutasítod a karakter regisztrációt?"))
			window.location.href = "admin_karakter<?=$config['Ext']?>?akcio=elutasit&id="+id;
	}
</script>

<center><h1>Karakter regisztrációk</h1></center>

<center><table width="100%" align=center>
	<tr>
		<td width="25%" class="cim">Karakter</td>
		<td width="25%" class="cim">Account</td>
		<td width="20%" class="cim">IP</td>
		<td width="20%" class="cim">Dátum</td>
		<td width="10%" class="cim">Admin</td>
	</tr>
<?
	$sql = mysql_query("SELECT Nev, Letrehozando, LetrehozasIdo, IP, ID FROM accountok WHERE Letrehozas = '1' ORDER BY LetrehozasIdo ASC");
	if(mysql_num_rows($sql) == 0)
		echo "<tr><td colspan='5' class='clear'>Nincs megerősítetlen karakter</td></tr>";
	while($acc = mysql_fetch_array($sql))
	{
		$karakter = explode(",", $acc["Letrehozando"]);
		echo"	<tr class='cleartr'>
					<td>".$karakter[0]."</td>
					<td>".$acc["Nev"]."</td>
					<td>".$karakter[5]."</td>
					<td>".$acc["LetrehozasIdo"]."</td>
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
$sql = mysql_query("SELECT Log, Datum, Tipus FROM log WHERE tipus='karelf' OR tipus='karelut' ORDER BY Datum DESC LIMIT 5");
while($log = mysql_fetch_array($sql))
{
	echo"<tr>
			<td class='bal'><img src='img/".($log["Tipus"] == "karelf" ? "plus" : "minus").".gif'> ".$log["Log"]."</td>
			<td class='jobb'>".DatumFormat($log["Datum"])."</td>
		 </tr>";
}
?>
</table><br>

<!--#############################################################################################################-->
<!--#############################################################################################################-->
<!--#############################################################################################################-->

<? Lablec(); ?>