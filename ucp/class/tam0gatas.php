<? 
require_once("include/main.php");

//Fejlec();
if($_GET['auth'] == "5f744c7e5a6c954205890f9ab882acd5") {
$length = 4;
$code1 = substr(str_shuffle(md5(time())),0,$length);
$code2 = substr(str_shuffle(md5(time())),0,$length);
$code3 = substr(str_shuffle(md5(time())),0,$length);
$code = $code1 . "-" . $code2 . "-" . $code3;
$text2 = "K�sz�nj�k a t�mogat�st! K�dod: " . $code . " http://classrpg.net";

$text = 		$_GET['text']; // sms szoveg
$felado = 		$_GET['tel']; // Felado tel.szam
$szolgaltato =	$_GET['provider']; // szolg.
$kategoria = 	$_GET['prive']; //SMS netto ára
$auth =			$_GET['auth']; //KURVAFONTOSNETÖRÖLDKI
mysql_select_db("clstest2");
mysql_query("SELECT * FROM `sms` WHERE 1");
mysql_query("INSERT INTO `sms` (number, activator, generated, code, activated) VALUES ('".mysql_real_escape_string($felado)."','".mysql_real_escape_string("-")."','".date("Y-m-d H:i:s")."','".mysql_real_escape_string($code)."','-')") or die(mysql_error());


echo "text=",rawurlencode($text2);  
 //Mért nem egy sima index-ben vna? :D ne kérdezd nem én írtam xd 
} else { die("Nem csalunk ;)"); }
?>
