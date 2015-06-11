<?
require_once("include/main.php");

if(!$jatekos["Belepve"] || !CheckAdmin() && !IsScripter())
	Error();

Fejlec();

if(isset($_GET["akcio"])) $a = $_GET["akcio"];
if(isset($_GET["id"])) $id = $_GET["id"];

if(isset($a))
{
	if(isset($id) && is_numeric($id))
	{
		if($a == "elfogad")
		{
			$sql = mysql_query("SELECT ID, KID, AID, ANev, Regi, Uj, Elbiralva FROM nevvaltas WHERE id = '".$id."'");
			if(mysql_num_rows($sql) == 1)
			{
				$nevv = mysql_fetch_array($sql); mysql_free_result($sql);
				$kari_sql = mysql_query("SELECT Nev FROM playerek WHERE ID='".$nevv["KID"]."'");
				$kari = mysql_fetch_array($kari_sql); mysql_free_result($kari_sql);

				$ell_sql = mysql_query("SELECT ID FROM playerek WHERE Nev='".$nevv["Uj"]."'");
				$ell_sql_db = mysql_num_rows($ell_sql); mysql_free_result($ell_sql);

				if($nevv["Elbiralva"] != "n")
				{
					echo Felhivas("Már elbírálták");
				}
				elseif($ell_sql_db != 0)
				{
					echo Felhivas("Ez a név foglalt, a névváltási kérelem törölve");
					mysql_query("DELETE FROM nevvaltas WHERE ID='".$nevv["ID"]."'");
				}
				elseif($kari["Nev"] != $nevv["Regi"])
				{
					echo Felhivas("Már váltott nevet, ezért a névváltás törölve");
					mysql_query("DELETE FROM nevvaltas WHERE ID='".$nevv["ID"]."'");
				}
				elseif($mysql -> query_num("SELECT ID FROM bans WHERE cim = '".$nevv["Regi"]."'") != 0)
				{
					mysql_query("UPDATE nevvaltas SET Elfogadva='n', Elbiralva='i' WHERE ID='".$nevv["ID"]."'");
					echo Felhivas($nevv["Regi"]." névváltása elutasítva, mivel a játékos bannolva van");
					
					SeeLOG("nevelut", "<b class='kiemelt'>".$jatekos["LogNev"]."</b> el akarta fogadni <b class='kiemelt'>".$nevv["Regi"]."</b> névváltását, de a játékos bannolva van, így automatikusan elutasítva", $nevv["AID"], $nevv["ANev"], 1);
					SeeLOG("u_nevelut", "A névváltási kérelmed (".$nevv["Regi"]." > ".$nevv["Uj"] . ") elutasítva", $nevv["AID"], $nevv["ANev"], 0, 1);
				}
				else
				{
					mysql_query("UPDATE playerek SET Nev='".$nevv["Uj"]."' WHERE ID='".$nevv["KID"]."'");
					mysql_query("UPDATE nevvaltas SET Elfogadva='i', Elbiralva='i' WHERE ID='".$nevv["ID"]."'");

					echo Felhivas("Sikeres névváltás: ".$nevv["Regi"]." > ".$nevv["Uj"]);
					SeeLOG("nevelf", "<b class='kiemelt'>".$jatekos["LogNev"]."</b> elfogadta <b class='kiemelt'>".$nevv["Regi"]."</b> névváltását! Új neve: <b class='kiemelt'>".$nevv["Uj"]."</b>", $nevv["AID"], $nevv["ANev"], 1);
					SeeLOG("u_nevelf", "Egy adminisztrátor elfogadta a névváltási kérelmed: ".$nevv["Regi"]." > ".$nevv["Uj"], $nevv["AID"], $nevv["ANev"], 0, 1);
				}
			}
		}
		elseif($a == "elutasit")
		{
			$sql = mysql_query("SELECT ID, KID, Regi, Uj, AID, ANev, Elbiralva FROM nevvaltas WHERE id = '".$id."'");
			if(mysql_num_rows($sql) == 1)
			{
				$nevv = mysql_fetch_array($sql); mysql_free_result($sql);
				$kari_sql = mysql_query("SELECT Nev FROM playerek WHERE ID='".$nevv["KID"]."'");
				$kari = mysql_fetch_array($kari_sql); mysql_free_result($kari_sql);

				if($kari["Nev"] != $nevv["Regi"])
				{
					echo Felhivas("Már váltott nevet, ezért a névváltás törölve");
					mysql_query("DELETE FROM nevvaltas WHERE ID='".$nevv["ID"]."'");
				}
				elseif($nevv["Elbiralva"] != "n")
				{
					echo Felhivas("Már elbírálták");
				}
				else
				{
					mysql_query("UPDATE nevvaltas SET Elfogadva='n', Elbiralva='i' WHERE ID='".$nevv["ID"]."'");

					echo Felhivas("Névváltás elutasítva: ".$nevv["Regi"]." > ".$nevv["Uj"]);
					SeeLOG("nevelut", "<b class='kiemelt'>".$jatekos["LogNev"]."</b> elutasította <b class='kiemelt'>".$nevv["Regi"]."</b> névváltását! Új neve lett volna: <b class='kiemelt'>".$nevv["Uj"]."</b>", $nevv["AID"], $nevv["ANev"], 1);
					SeeLOG("u_nevelut", "Egy adminisztrátor elutasította a névváltási kérelmed: ".$nevv["Regi"]." > ".$nevv["Uj"], $nevv["AID"], $nevv["ANev"], 0, 1);
				}
			}
		}
	}
}

?>

<style type="text/css">
table {
	border-spacing: 0px;
}

td {
	border: 2px outset #888;
	padding: 5px;
	vertical-align: top;
	text-align: center;
	background-color: #202020;
}

td.clear,.cleartr td {
	border: none;
}

.left {
	text-align: left;
}

.cim {
	color: white;
	font-weight: bold;
}

.left li a {
	text-decoration: none;
	font-weight: bold;
	color: white;
}

.left li a:hover {
	color: yellow;
}

img.link {
	cursor: crosshair;
}

img.link:hover {
	cursor: pointer;
}
</style>

<script type="text/javascript">
	function AdminAkcio(id, elfogad)
	{
		if(elfogad && confirm("Biztosan elfogadod a névváltást?"))
			window.location.href = "admin_nevvaltas<?=$config['Ext']?>?akcio=elfogad&id="+id;
		else if(!elfogad && confirm("Biztosan elutasítod a névváltást?"))
			window.location.href = "admin_nevvaltas<?=$config['Ext']?>?akcio=elutasit&id="+id;
	}
</script>

<center>
	<h1>Névváltási kérelmek</h1>
</center>

<center>
	<table width="100%" align=center>
		<tr>
			<td width="30%" class="cim">Karakter</td>
			<td width="30%" class="cim">Új név</td>
			<td width="25%" class="cim">Dátum</td>
			<td width="15%" class="cim">Admin</td>
		</tr>
		<?
		$sql = mysql_query("SELECT ID, Regi, Uj, Datum FROM nevvaltas WHERE Elbiralva = 'n' ORDER BY Datum ASC");
		if(mysql_num_rows($sql) == 0)
			echo "<tr><td colspan='5' class='clear'>Nincs megerősítetlen névváltási kérelem</td></tr>";
		while($nev = mysql_fetch_array($sql))
		{
			echo"	<tr class='cleartr'>
			<td>".$nev["Regi"]."</td>
			<td>".$nev["Uj"]."</td>
			<td>".$nev["Datum"]."</td>
			<td>
			<img class='link' src='img/elfogad.png' height='15' onClick='return AdminAkcio(\"".$nev["ID"]."\", true);'>
			<img class='link' src='img/torol.png' height='15' onClick='return AdminAkcio(\"".$nev["ID"]."\", false);'>
			</td>
			</tr>";
		}
		?>
	</table>
</center>

<!--#############################################################################################################-->
<!--#############################################################################################################-->
<!--#############################################################################################################-->

<br>
<table width="100%" align="center" border="1">
	<tr class="cleartr cim">
		<td width="80%" class="nopadding" style="padding-top: 3px">Esemény</td>
		<td width="20%" class="nopadding" style="padding-top: 3px">Időpont</td>
	</tr>
	<tr class="cleartr">
		<td colspan="2" class="nopadding"><br></td>
	</tr>
	<?
	$sql = mysql_query("SELECT Log, Datum, Tipus FROM log WHERE tipus='nevelf' OR tipus='nevelut' ORDER BY Datum DESC LIMIT 5");
	while($log = mysql_fetch_array($sql))
	{
		echo"<tr>
		<td class='bal'><img src='img/".($log["Tipus"] == "nevelf" ? "plus" : "minus").".gif'> ".$log["Log"]."</td>
		<td class='jobb'>".DatumFormat($log["Datum"])."</td>
		</tr>";
	}
	?>
</table>
<br>

<!--#############################################################################################################-->
<!--#############################################################################################################-->
<!--#############################################################################################################-->

<? Lablec(); ?>