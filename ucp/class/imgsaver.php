<?php

define('DIRECTORY', '../../../home/cs2d/gfx'); 	//MAPPA AHOVA TOLTI

function saveIMG($id) {
require_once('./g5c.php');
if(isset($id)) {
if(strlen($id) < 0) { die("hibas profil"); } else { 
$code = $id;
}
}
$curl = "http://www.unrealsoftware.de/profile.php?userid=".$code;
//echo $curl;

$shtml = file_get_html($curl);
foreach($shtml->find("div[class=fava]") as $content){
    $div = $content->style;
}

$div = substr($div,21);
$div = substr($div,0, -1);
$name = "http://www.unrealsoftware.de/connect.php?getname=".$code;
$name1 = file_get_html($name);
$name2 = $name1.".jpg";
echo "<img src='http://www.unrealsoftware.de/".$div."' /><br/>";

if(strlen($div) < 3) exit;
$content = file_get_contents('http://www.unrealsoftware.de/'.$div);

file_put_contents(DIRECTORY.'/'.$name2, $content);
}

?>