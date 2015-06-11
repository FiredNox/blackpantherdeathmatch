<?php
require_once("include/main.php");

if(!$jatekos["Belepve"] || $jatekos['Admin'] < 1337 && !IsScripter() && !IsSuper())
	Error();

Fejlec();

?>

<style type="text/css">
table.customized tr td {
	font-family: monospace;
	font-size: small;
	font-weight: bold;
}
</style>

<?

$qry = $mysql -> query("SELECT Nev, Admin, Valaszok FROM playerek WHERE Admin >= 1 ORDER BY Valaszok DESC");

echo '
<table width="80%" class="nospadding customized" style="margin: 0px auto">
	<tr>
		<td>Név</td>
		<td>Válaszok</td>
	</tr>
';

if($mysql -> num($qry)) while($u = $mysql -> object($qry)) {
	echo '<tr><td>' . $u -> Nev . '</td><td><pre>' . sprintf("%6s", number_format($u -> Valaszok)) . '</pre></td></tr>';
}

echo '</table>';

Lablec();

?>