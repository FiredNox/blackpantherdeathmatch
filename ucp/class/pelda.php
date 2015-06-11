<?php
define('id_mappa', '../../../games/cs2d/sys/lua/avatartxt'); 	//MAPPA AHOVA TOLTI

require_once("imgsaver.php");

if ($handle = opendir(id_mappa)) {

    while (false !== ($entry = readdir($handle))) {
		
		if(substr($entry, -4) == ".txt") {
		$entry = substr($entry, -4);
		}
        if ($entry != "." && $entry != "..") {
			if(strlen($entry) > 0) {
			echo "a:".$entry;
            saveIMG($entry);
			}
        }
    }

    closedir($handle);
}
?>