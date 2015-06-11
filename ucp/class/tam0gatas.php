<? 
require_once("include/main.php");

//Fejlec();
if($_GET['auth'] == "5f744c7e5a6c954205890f9ab882acd5") {
$length = 4;
$code1 = substr(str_shuffle(md5(time())),0,$length);
$code2 = substr(str_shuffle(md5(time())),0,$length);
$code3 = substr(str_shuffle(md5(time())),0,$length);
$code = $code1 . "-" . $code2 . "-" . $code3;
$text2 = "Köszönjük a támogatást! Kódod: " . $code . " http://classrpg.net";

$text = 		$_GET['text']; // sms szoveg
$felado = 		$_GET['tel']; // Felado tel.szam
$szolgaltato =	$_GET['provider']; // szolg.
$kategoria = 	$_GET['prive']; //SMS netto Ã¡ra
$auth =			$_GET['auth']; //KURVAFONTOSNETÃ–RÃ–LDKI
mysql_select_db("clstest2");
mysql_query("SELECT * FROM `sms` WHERE 1");
mysql_query("INSERT INTO `sms` (number, activator, generated, code, activated) VALUES ('".mysql_real_escape_string($felado)."','".mysql_real_escape_string("-")."','".date("Y-m-d H:i:s")."','".mysql_real_escape_string($code)."','-')") or die(mysql_error());


echo "text=",rawurlencode($text2);  
 //MÃ©rt nem egy sima index-ben vna? :D ne kÃ©rdezd nem Ã©n Ã­rtam xd 
} else { die("Nem csalunk ;)"); }
?>
