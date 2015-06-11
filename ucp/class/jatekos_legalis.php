<?php
require_once("include/main.php");

if(!$jatekos["Belepve"])
	Error();

Fejlec();

?>

<style type="text/css">
table.customized tr td {
	font-family: comicsans;
	font-weight: bold;
	font-size: 20px;
}
</style>

<?

$qry = $mysql -> query("SELECT ID, Nev, Member, House FROM playerek WHERE Member = 1 OR Member = 2 OR Member = 20 ORDER BY Member DESC");

echo '
<table width="50%" class="nospadding customized" style="margin: 0px auto">
	<tr>
		<td>Név</td>
		<td>Haz</td>
	</tr>
';

if($mysql -> num($qry)) while($u = $mysql -> object($qry)) {
	if($u -> House > 0) echo '<tr><td>' . $u -> Nev . '</td><td><pre>' .($u -> House == -1 ? "NINCS" : "VAN"). '</pre></td></tr>';
}

echo '</table>';

Lablec();

?>