<?
require_once("include/main.php");
Fejlec();
if(!$jatekos["Belepve"]) Hiba("Nem vagy belépve");
?>

<style type="text/css"></style>

<script type="text/javascript">
$(function(){
    $( "#radio" ).buttonset();
    $( "#gomb" ).button();
});
</script>

<center><h1>Névváltások</h1></center>

<?

$text = "";

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["m"]))
{
    if($_GET["m"] == "e" && isset($_GET["e"]))
    {
        $e = $_GET["e"];
        if(!RolePlayNev($e) && !is_numeric($e))
            $uzenet = "Nem RolePlay név / Hibás UID";
        else
        {
            $k_sql = mysql_query("SELECT ID, Nev FROM playerek WHERE Nev='$e' OR ID='$e'");
            if(mysql_num_rows($k_sql) != 1)
                $uzenet = "Nincs találat: $e";
            else
            {
                $data = mysql_fetch_array($k_sql);
                $text .= "<hr><br><center><h2>".$data["Nev"]."</h2><br>
                    <table width='85%' class='kozep'>
                    <tr class='cim'>
                        <td width='35%'>Régi név</td>
                        <td width='35%'>Új név</td>
                        <td width='30%'>Időpont</td>
                    </tr>
                ";
                
                $n_sql = mysql_query("SELECT Regi, Uj, Datum FROM nevvaltas WHERE KID='".$data["ID"]."' ORDER BY Datum DESC");
                
                if(mysql_num_rows($n_sql) > 0) while($nevvaltas = mysql_fetch_array($n_sql))
                {
                    $text .= "<tr class='nopadding'><td>".$nevvaltas["Regi"]."</td><td>".$nevvaltas["Uj"]."</td><td>".$nevvaltas["Datum"]."</td></tr>";
                }
                else
                    $text .= "<tr class='nopadding'><td colspan='3'>Nincs bejegyzett névváltás</td></tr>";
                
                $text .= "</table></center>";
            }
        }
    }
    elseif($_GET["m"] == "t" && isset($_GET["e"]))
    {
        $e = $_GET["e"];
        if(!RolePlayNev($e))
            $uzenet = "Nem RolePlay név";
        else
        {
            $k_sql = mysql_query("SELECT KID, Regi, Uj, Datum FROM nevvaltas WHERE Regi='$e'");
            if(mysql_num_rows($k_sql) == 0)
                $uzenet = "Senki sem használta ezt a nevet: $e";
            else
            {
                $text .= "<hr><br><center><h2>Keresés: ".$e."</h2><br>
                    <table width='99%' class='kozep'>
                    <tr class='cim'>
                        <td width='12%'>UID</td>
                        <td width='22%'>Régi név</td>
                        <td width='22%'>Új név</td>
                        <td width='22%'>Jelenlegi neve</td>
                        <td width='22%'>Időpont</td>
                    </tr>
                ";
                while($nevvaltas = mysql_fetch_array($k_sql))
                {
                    $player = mysql_query("SELECT Nev FROM playerek WHERE ID='".$nevvaltas["KID"]."'");
                    if(mysql_num_rows($player) == 0) $nev = "<i>Törölt játékos</i>";
                    else
                    {
                        $neva = mysql_fetch_array($player);
                        $nev = $neva["Nev"];
                    }
                    
                    $text .= "
                        <tr class='nopadding'>
                            <td>".$nevvaltas["KID"]."</td>
                            <td>".$nevvaltas["Regi"]."</td>
                            <td>".$nevvaltas["Uj"]."</td>
                            <td>".$nev."</td>
                            <td>".$nevvaltas["Datum"]."</td>
                        </tr>
                    ";
                }
                
                $text .= "</table></center>";
            }
        }
    }
}
if(isset($uzenet)) echo Felhivas($uzenet)."<br><br>";

echo "<center>
<form method='GET'>
<div id='radio'>
    <input type='radio' id='radio1' name='m' value='e' ".(!isset($_GET["m"]) || isset($_GET["m"]) && $_GET["m"] == "e" ? "checked" : "")."><label for='radio1'>Egy játékos névváltásainak listázása Név / UID alapján</label>
    <input type='radio' id='radio2' name='m' value='t' ".(isset($_GET["m"]) && $_GET["m"] == "t" ? "checked" : "")."><label for='radio2'>A megadott nevet használt játékosok listázása</label>
</div>
<br>
Keresés: <input type='text' name='e' class='text ui-widget-content ui-corner-all' ".(isset($_GET["e"]) ? "value=".$_GET["e"] : "").">
<br><br>
<button id='gomb'>Keresés</button>
</form>
</center>

<br><br>
";

echo $text; unset($text);

?>
</center>
<? Lablec(); ?>