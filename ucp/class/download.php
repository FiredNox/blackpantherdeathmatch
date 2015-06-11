<?
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Reporting E_NOTICE can be good too (to report uninitialized
// variables or catch variable name misspellings ...)
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);

// Report all PHP errors (see changelog)
error_reporting(E_ALL);

// Report all PHP errors
error_reporting(-1);

// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

$i = 1;
$l = 101;

while ($i < $l) {
    $html = get_data('http://unrealsoftware.de/u_ava/'.$i.'/');
    getImages($html);
    $i += 1;
}

function getImages($html) {
    $matches = array();
    $regex = '~http://unrealsoftware.de/u_ava//(.*?)\.jpg~i';
    preg_match_all($regex, $html, $matches);
    foreach ($matches[1] as $img) {
        saveImg($img);
    }
}

function saveImg($name) {
    $url = 'http://unrealsoftware.de/u_ava/'.$name.'.jpg';
    $data = get_data($url);
    file_put_contents('photos/'.$name.'.jpg', $data);
}

?>