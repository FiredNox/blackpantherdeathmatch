<? //ááűőúöüó
if(!defined("SAMP_QUERY_BETOLTVE")) require_once("include/samp_query.php");
$SzerverAdatok = Array("Online", "Players", "MaxPlayers");
$SzerverAdatok["Online"] = false;
try
{
    $rQuery = new QueryServer( $config["Host"], $config["Port"] );

    $aInformation = $rQuery->GetInfo( );
	$SzerverAdatok["Online"] = true;
	$SzerverAdatok["MaxPlayers"] = $aInformation['MaxPlayers'];
	$SzerverAdatok["Players"] = $aInformation['Players'];

    $rQuery->Close( );
}
catch (QueryServerException $pError)
{
}
unset($aInformation, $rQuery);
?>