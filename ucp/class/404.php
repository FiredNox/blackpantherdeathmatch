<?
require_once("include/main.php");
Fejlec();

echo "<center><b>
<font size='7' color='#FF3333'>404</font><br>
<font size='3' color='orange'>A keresett oldal nem található: <font color='grey'>".str_replace(".php", "", basename($_SERVER['REDIRECT_URL']))."</font></font>
</b></center>";

Lablec();
?>