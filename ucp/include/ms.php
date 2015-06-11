<?php
define("MS_BETOLTVE", "1");

	session_start();

	mysql_connect("localhost", "user", "password") or die(mysql_error());
	mysql_select_db("fndm");
	mysql_query("set names utf8");  
	date_default_timezone_set("Europe/Budapest");
?>