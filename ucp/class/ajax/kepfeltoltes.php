<?

require_once("include/main.php");

// Ellenőrzés
$max = 30;
$db = $mysql -> query_num("SELECT ID FROM kepek WHERE UID='" . $jatekos["ID"] . "'");

$amax = 10;
$mdb = $mysql -> query_num("SELECT ID FROM kepek WHERE UID='" . $jatekos["ID"] . "' AND Statusz='n'");

$rmax = min( array($max - $db, $amax - $mdb ) );
$allow = $rmax > 0 ;

// ===================

$return = array();
$return["msg"] = array();
$return["left"] = 0;

if($allow)
{
	$files = count($_FILES);
	if($files < 1 || $files > 10) break;
	
	$exts = array("jpg", "jpeg", "gif", "png");
	$meret = 5 * 1024 * 1024;
	
	$ok = 0;
	foreach($_FILES as $file)
	{
		$ext = end( explode(".", $file["name"]) );
		if( !strpos($file["name"], "fajl") === false ||
			$file["size"] <= 0 || $file["size"] > $meret ||
			!in_array( $ext , $exts) ||
			$file["error"] > 0
		) continue;
		
		$ok++;
		$rmax--;
		
		$mysql -> insert("kepek", array(
			"UID"   => $jatekos["ID"],
			"Datum" => date("Y-m-d H:i:s"),
			"Tipus" => $ext
		));
		
		$saveto = "kepek/" . $mysql -> lastID . "." . $ext;
		
		move_uploaded_file($file["tmp_name"], $saveto);
		
		if(!$rmax)
			break;
	}
	
	$return["success"] = !!$ok;
	$return["left"] = $rmax;
	
	if(!$ok) {
		$return["msg"][] = "Nem lett fájl feltöltve";
		$return["msg"][] = "Valószínüleg rossz fájlokat próbálsz feltölteni";
		$return["msg"][] = get_magic_quotes_gpc();
	} else {
		$return["msg"][] = "{$ok}db fájl sikeresen feltöltve";
	}
}
else
	$return["msg"][] = "Nem tudsz több fájlt feltölteni, elérted a limitet";

$return["msg"] = implode("\n", $return["msg"]);

echo "<script>window.parent.onUploadReady('".json_encode($return)."')</script>";

?>