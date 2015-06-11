<?php require("doct.php");?>
<?php

function karbantartas($onevalue)
{
	if($onevalue=="1") // Ok
	{
	$fatal_msg = '<font color=red>KEDVES LÁTOGATÓ! AZ OLDALON KARBANTARTÁS VAN FOLYAMATBAN, KÉRJÜK TÉRJ VUSSZA KÉSŐBB!</font>';
	
		if(isset($fatal_msg))
		{
			if($fatal_msg != "")
			{
				echo '<div align="center">';
				for ($x = 0; $x <= 10; $x++) 
				{
				   echo "<br>";
				}
				echo '<div class="fatal_msg fatal_msg-ok"><p><strong>'.$fatal_msg.'</strong></p></div>';
				echo '</div>';
				
			}
		}
	}else if($onevalue=="0"){include("include/fooldal.php");}
}
?>