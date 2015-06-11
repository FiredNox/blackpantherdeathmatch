<?php
require_once("include/main.php");

if(!$jatekos["Belepve"] || $jatekos["Admin"] < 1 && !$config['Amos'])
	Error();

Fejlec();

$nev = false;
if( $_SERVER["REQUEST_METHOD"] == "GET" && isset( $_GET["nev"] ) )
{
	$nev = trim( $_GET["nev"] );
	if(!SzovegAnalizalas( $nev, "_" )) $nev = false;
}

$bid = false;
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset( $_GET['bid'] ) )
{
	$bid = trim( $_GET['bid'] );
	//if(!is_numeric($bid)) $bid = false;
	if(!SzovegAnalizalas( $nev, "_" )) $bid = false;
}

$acc = false;
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset( $_GET['acc'] ) )
{
	$acc = trim( $_GET['acc'] );
	$acc = mysql_real_escape_string($acc);

	if(strlen($acc) < 1 || strlen($acc) > 50)
		$acc = false;
}

?>

<style type="text/css">
</style>

<center><h1>Kapcsolódások</h1>

<form method="GET">
	Kérlek add meg a nevet: <input type="text" name="nev" value="<?=($nev ? $nev : "")?>">
	 <input type="submit" value="Keresés" style="padding: 1px">
</form>

<br>

<table width="100%">
<tr class="cim">
	<td width="20%">IP</td>
	<td width="20%">Utolsó belépés</td>
	<td>Kapcsolódó karakterek</td>
</tr>

<tr>

<?php

if($nev)
{
	$qry = mysql_query( "SELECT IP, MAX(Ido) FROM ig_connect WHERE Nev='$nev' GROUP BY IP ORDER BY Ido DESC LIMIT 10" );
	if(!mysql_num_rows($qry)) echo "<td colspan='3'><i>Nincs találat...</u></td>";
	else
	{
		while( $ip = mysql_fetch_row($qry) )
		{
			$kapcs = Array();
			$qry2 = mysql_query( "SELECT Nev FROM ig_connect WHERE IP='". $ip[0] ."' AND Nev!='$nev' GROUP BY Nev ORDER BY Ido DESC LIMIT 20" );
			while($ip2 = mysql_fetch_row( $qry2 ))
				$kapcs[] = "<a href='jatekosok".$config["Ext"]."?keres=".$ip2[0]."' target='_BLANK'>".$ip2[0]."</a>";

			echo "<tr><td>".$ip[0]."</td><td>".DatumFormat($ip[1])."</td><td>". implode(", ", $kapcs) ."</td></tr>";
		}
	}
}
else
	echo "<td colspan='3'><i>Várakozás keresésre...</u></td>";

?>

</tr></table>

<br>
<hr>
<br>
<form method="GET">
	Kérlek add meg: BID / Nev /cid: <input type="text" name="bid" value="<?=($bid ? $bid : '')?>">
	 <select name="bid_ido">
	<?php
		$t = time();
		$ts = isset($_GET['bid_ido']) ? $_GET['bid_ido'] : false;
		
		for($n = 0; $n < 30; $n++)
		{
			$d = date("Y-m-d", $t - ($n * 86400));
			echo "<option value='$d' ". ($ts && $d == $ts ? 'selected' : '') .">$d</option>";
		}

	?>
	</select>
	<br />
	Konkrét idő nélkül max 60 találat: <input type="checkbox" name="noido" value="60"><br />
	Csoportosítás <input type="checkbox" name="group" value="1"><br />
	 <input type="submit" value="Keresés" style="padding: 1px">
</form>

<br>

<table id="ig_connect" width="100%">
	<tr class="cim">
		<td width="10%">UID</td>
		<td width="10%">BID</td>
		<td width="20%">Név</td>
		<td width="20%">IP</td>
		<td width="20%">Időpont</td>
		<td width="20%">CID</td>
	</tr>

<?php 
if($bid)
{
	$i = strtotime($_GET['bid_ido'] . ' 00:00:00');
	if($i)
	{
		if(is_numeric($bid))
			$feltetel = "BID='$bid'";
		else if(strpos($bid, "-") !== false)
			$feltetel = "Code='$bid'";
		else
			$feltetel = "Nev='$bid'";
		

		if($_GET['group'])
		{
			$csop="GROUP BY UID";
			$count="count(UID) as talalat,";
			$zar1="("; $zar2=")";
		}
		if($_GET['noido'] == 60)
			$r = $mysql -> query("SELECT UID, BID, Nev, $count IP, Ido, Code FROM ig_connect WHERE $feltetel $csop ORDER BY Ido DESC LIMIT 0, 60");
		else
			$r = $mysql -> query("SELECT UID, BID, Nev, $count IP, Ido, Code FROM ig_connect WHERE $feltetel $csop AND Ido >= $i AND Ido <= ". ($i+86400) ." ORDER BY Ido DESC");

		
		if($mysql -> num())
		{
			while($r = $mysql -> assoc())
				echo "<tr>
					<td>$r[UID]</td>
					<td>$r[BID]</td>
					<td>$r[Nev] $zar1 $r[talalat] $zar2</td>
					<td>$r[IP]</td>
					<td>". date('Y-m-d H:i:s', $r['Ido']) ."</td>
					<td style='font-size: 8px'><a href='admin_connect.web?bid=".$r['Code']."&noido=60&group=1' >".$r['Code']."</a></td>
				</tr>";
		}
		else
			echo '<tr><td colspan="6">Nincs találat</td></tr>';
	}	
}
?>

</table>

<br><br>
<hr>
<br><br>
<form method="GET">
	Kérlek add meg az account nevet: <input type="text" name="acc" value="<?=($acc ? $acc : '')?>">
	 <input type="submit" value="Keresés" style="padding: 1px">
</form>

<?
if($acc)
{
	$karik = [];
	$res = mysql_query('SELECT Karakter1, Karakter2 FROM accountok WHERE Nev="'.$acc.'"');
	if(mysql_num_rows($res) == 1)
	{
		$d = mysql_fetch_array($res);

		if(is_numeric($d['Karakter1']) && $d['Karakter1'] > 0)
		{
			$res2 = mysql_query('SELECT ID, Nev FROM playerek WHERE ID = "'.$d['Karakter1'].'"');
			if(mysql_num_rows($res2) == 1)
			{
				$karik[] = mysql_fetch_array($res2);
			}
		}

		if(is_numeric($d['Karakter2']) && $d['Karakter2'] > 0)
		{
			$res2 = mysql_query('SELECT ID, Nev FROM playerek WHERE ID = "'.$d['Karakter2'].'"');
			if(mysql_num_rows($res2) == 1)
			{
				$karik[] = mysql_fetch_array($res2);
			}
		}
		
	}

	if(count($karik))
	{
		echo 'Karakterek: ';
		foreach($karik as $kari)
			echo '<a target="_BLANK" href="jatekosok'.$config['Ext'].'?keres='.$kari['Nev'].'">'.$kari['Nev'].'</a> (ID: '.$kari['ID'].') ';
	}
}
?>
<br>
<hr>
<br>
</center>

<? Lablec(); ?>