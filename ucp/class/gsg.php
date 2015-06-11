<?php
require_once("g5c.php");
$code = "1";
$name = "http://www.unrealsoftware.de/connect.php?getname=".$code;
$names = file_get_html($name);
$n = (strlen($names) > 0) ? $names : ":'(";
echo $n; //Elvileg "DC" -t kell kiirnia.
?>