<?
require_once("include/main.php");

if(!$jatekos["Belepve"] || $jatekos["Admin"] < 1)
	Error();

Fejlec();
?>

<style type="text/css">
	table
	{
		border-spacing:0px;
	}
	td
	{
		border: 2px outset #888;
		padding: 5px;
		vertical-align: top;
		text-align:center;
	}
	td.clear, table.cleartable tr td{border: none;}
	.left
	{
		text-align: left;
	}
	.cim
	{
		color:white;
		font-weight:bold;
	}
	.left li a
	{
		text-decoration:none;
		font-weight:bold;
		color:white;
	}
	.left li a:hover
	{
		color:yellow;
	}
	.noncim
	{
		border:none;
	}
</style>

<script type="text/javascript">
var gombok = Array("account", "karakter", "tarsitas", "log", "szerkeszt", "ban", "weblog", "kontroll", "nevvaltas", "fo", "quiz", "connect");
$(document).ready(function(){
	for(x = 0; x < gombok.length; x++)
	{
		if($("#admin_"+gombok[x]))
		{
			$("#admin_"+gombok[x]).mouseover(function(){$(this).attr("src", "img/admin/"+$(this).attr("id")+"_fekete.png")});
			$("#admin_"+gombok[x]).mouseout(function(){$(this).attr("src", "img/admin/"+$(this).attr("id")+".png")});
		}
	}
});
</script>

<center><h1>Adminisztrátori felület</h1></center>

<center>

<?
	$adminlinkek = Array();

	foreach($config["AdminTeruletek"] as $link)
	{
		if(!is_array($link["admin"]) && $link["admin"] <= $jatekos["Admin"] ||
			is_array($link["admin"]) && in_array($jatekos["Nev"], $link["admin"]))
		$adminlinkek[] = $link;
	}

	$db = count($adminlinkek);
	if($db == 0)
		echo "<b>Sajnos semmihez sincs jogod :(</b>";
	else
	{
		echo '<table width="100%" align="center" class="clear">';
		$dbpersor = 4; $width = 100 / $dbpersor;
		for($x = 1; $x <= $db; $x++)
		{
			if($x % $dbpersor == 1)
				echo "<tr>";

			echo "<td ".($x == $db && $x % $dbpersor != 0 ? "colspan='".($dbpersor - $x + 1)."'" : "")." width='".$width."%'>
                    <a href='".$adminlinkek[$x-1]["link"].$config["Ext"]."'>
                        <img id='".$adminlinkek[$x-1]["link"]."' src='img/admin/".$adminlinkek[$x-1]["link"].".png'>
                    </a><br><b>".$adminlinkek[$x-1]["nev"]."</b>
                  </td>";

			if($x == $db || $x % $dbpersor == 0)
				echo "</tr>";
		}
		echo '</table>';
	}
?>

</center>

<? Lablec(); ?>