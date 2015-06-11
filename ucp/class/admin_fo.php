<?
require_once("include/main.php");

if(!$jatekos["Belepve"] || !CheckAdmin() && !IsScripter())
	Error();

Fejlec();

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $a = $_POST["action"];
    if($a == "tarsitas_torles")
    {
        $nev = addslashes($_POST["karakter"]);
        if(strlen($nev) < 5)
            $uzenet = "[Társítás törlése] Minimum 5 karakter hosszú nevet kell megadnod!";
        else
        {
            $sql = mysql_query("SELECT ID FROM playerek WHERE nev = '".$nev."'");
            $db = mysql_num_rows($sql);
            $id = -999;
            if($db == 1)
            {
                $player = mysql_fetch_array($sql);
                $id = $player["ID"];
            }
            mysql_free_result($sql);
            
            if($id == -999)
                $uzenet = "Nincs ilyen név az adatbázisban: ".$nev;
            else
            {
                $sql = mysql_query("SELECT ID FROM accountok WHERE Karakter1='".$id."' OR Karakter2='".$id."'");
                $db = mysql_num_rows($sql);
                if($db == 0)
                    $uzenet = "Ez a karakter nincs társítva";
                else
                {
                    mysql_query("UPDATE accountok SET Karakter1='0' WHERE Karakter1='".$id."'");
                    mysql_query("UPDATE accountok SET Karakter2='0' WHERE Karakter2='".$id."'");
                    $uzenet = "Társítás törölve róla: ".$nev;
                    SeeLOG("tarstor", "<b class='kiemelt'>".$jatekos["Nev"]."</b> törölte a társítást a <b class='kiemelt'>".$nev."</b> nevű karakterről!", $jatekos["ID"], $jatekos["Nev"], 1);
                }
                mysql_free_result($sql);
            }
        }
    }
    elseif($a == "nevvaltas")
    {
        $nev = addslashes($_POST["nev"]);
        if($jatekos["Kivalasztva"] == 0)
            $uzenet = "Nincs karakter kiválasztva";
        elseif(strtolower($nev) == strtolower($jatekos["AK"]["Nev"]))
            $uzenet = "Jelenleg is ez a neved...";
        elseif(!RolePlayNev($nev))
            $uzenet = "Ez nem RolePlay név";
        elseif((strpos(strtolower($nev), "clint") !== false || strpos(strtolower($nev), "eastwood") !== false) && !IsClint())
            $uzenet = "Ez a név nem vehető fel";
        else
        {
            $sql = mysql_query("SELECT ID FROM playerek WHERE nev='".$nev."'");
            if(mysql_num_rows($sql) != 0)
                $uzenet = "Ez a név foglalt";
            else
            {
                $up = mysql_query("UPDATE playerek SET Nev='".$nev."' WHERE ID='".$jatekos["AK"]["ID"]."'");
                if($up) $uzenet = "Sikeres névváltás erről: ".$jatekos["AK"]["Nev"]." erre: ".$nev;
                else $uzenet = "Hiba történt a névváltás közben";
            }
        }
    }
}

if(isset($uzenet)) echo Felhivas($uzenet);
?>

<center><h1>Főadmin eszközök</h1></center>

<table><tr><td>
<form method="POST"><input type="hidden" name="action" value="tarsitas_torles">
Társítás törlése <input type="text" name="karakter"> <input type="submit" value="Mehet" style="padding: 0px">
</form>
</td></tr></table>

<table><tr><td>
<form method="POST"><input type="hidden" name="action" value="nevvaltas">
Saját neved módosítása <input type="text" name="nev"> <input type="submit" value="Mehet" style="padding: 0px">
</form>
</td></tr></table>

<? Lablec(); ?>