<?php
	if(!isset($vaxcbnsaay)) die("Ezt a m�veletet nem hajthatod v�gre k�ls� hivatkoz�sb�l. A folyamat le�ll.");
	function main() { header("Location: index.php"); die(); }
	if(!isset($_SESSION["username"])) die("<div id='die'>Nem vagy bejelentkezve!</div>");
	if(!isset($_GET["t"])) main();
	if(!isset($_GET["tid"])) main();
	var_dump($_POST);
	if($_GET["t"] == "m") {
	
		echo '�zenet elk�ld�se...';
	$q = $db->prepare("INSERT INTO `f_messages` (`MsgAUTHOR`,`MsgCONTENT`,`MsgDATE`,`MsgTOPIC`) VALUES (?,?,?,?)");
	$q->execute(array($_SESSION["username"],$_POST["comment"],time(),$_GET["tid"]));
	main();
	} elseif($_GET["t"] == "t") {
		echo 'T�ma elk�ld�se...';
		$q = $db->prepare("INSERT INTO `f_topics` (`TopicAUTHOR`,`TopicCONTENT`,`TopicDATE`,`TopicTITLE`) VALUES (?,?,?,?)");
		$q->execute(array($_SESSION["username"],$_POST["comment"],time(),$_POST["topictitle"]));
	} else echo $_GET["t"];