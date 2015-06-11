<?
$p = $_GET["p"];
if(strpos(".", $p) !== false) exit;

switch($p) {
	default:
		if(file_exists("ajax/$p.php"))
			require_once("ajax/$p.php");
	break;
}
?>