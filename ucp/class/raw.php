<?
require_once("include/main.php");
Fejlec();
$text = 		$_GET['text']; // sms szoveg
$felado = 		$_GET['tel']; // Felado tel.szam
$szolgaltato	$_GET['provider']; // szolg.
$kategoria = 	$_GET['prive']; //SMS netto ára
$auth =			$_GET['auth']; //KURVAFONTOSNETÖRÖLDKI
$asd = $text . " " . $felado . " " . $szolgaltato . " " . $kategoria . " " . $auth;
echo "text=". rawurlencode($asd);
Lablec();
?>