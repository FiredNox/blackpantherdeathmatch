<?php
require_once("include/main.php");

if(!$jatekos["Belepve"] || $jatekos['Admin'] < 1337 && !IsScripter())
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

$qry = $mysql -> query("SELECT ID, Nev, Member, House FROM playerek WHERE Member = 5 OR Member = 8 OR Member = 11 OR Member = 17 OR Member = 21 ORDER BY Member DESC");

echo '
<table width="50%" class="nospadding customized" style="margin: 0px auto">
	<tr>
		<td>Név</td>
		<td>Frakcio</td>
	</tr>
';

if($mysql -> num($qry)) while($u = $mysql -> object($qry)) {
	echo '<tr><td>' . $u -> Nev . '</td><td><pre>' . sprintf("%6s", number_format($u -> Member)) . '</pre></td></tr>';
}

echo '</table>';

Lablec();

?>