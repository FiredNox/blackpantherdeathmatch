<?
require_once("include/main.php");
Fejlec();
?>

<style type="text/css"></style>

<script type="text/javascript"></script>

<center><h1>Online</h1></center>

<table width="50%">
<tr>
    <td>Név</td>
    <td>Utoljára aktív</td>
    <td>Utolsó lap</td>
</tr>

<?

$mikortol = date("Y-m-d H:i:s", time() - 900);
$sql = mysql_query("SELECT Nev, UtoljaraAktiv, UtoljaraLatott FROM accountok WHERE UtoljaraAktiv >= '$mikortol' ORDER BY UtoljaraAktiv DESC");
$time = time();
while($user = mysql_fetch_array($sql))
{
	$mikor = $time - strtotime($user["UtoljaraAktiv"]);
    echo "<tr><td>".$user["Nev"]."</td><td>".DatumFormat($user["UtoljaraAktiv"])." | ". 
		($mikor < 60 ? $mikor ."mp" : round($mikor/60) ."p")
	."</td><td>".$user["UtoljaraLatott"]."</td></tr>";
}

?>
</table>

<? Lablec(); ?>