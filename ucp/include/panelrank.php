<?php
					$adinf = "<b><font size=3px color=lime>Adminisztrátor:</font></b><br>";
					$foinf = "<b><font size=3px color=lightblue>Főadmin:</font></b><br>";
					$scri = "<b><font size=3px color=orange>Scripter:</font></b><br>";
					$head = "<b><font size=3px color=red>Headmaster:</font></b><br>";
					if($sor['Admin'] > '0' and $sor['Admin'] <= '5' and $sor['Felhasznalonev'] != 'FiredNox'){echo "<strong><font size=2px color=white $adinf $fsor[Admin]</font><br>";}
					if($sor['Admin'] > '5' and $sor['Admin'] < '5553' and $sor['Felhasznalonev'] != 'FiredNox'){echo "<strong><font size=2px color=white $foinf $fsor[Admin]</font><br>";}
					if($sor['Admin'] >= '5553' and $sor['Admin'] <= '5555' and $sor['Felhasznalonev'] != 'FiredNox'){echo "<strong><font size=3px color=white $scri $fsor[Admin]</font><br>";}
					if($sor['Felhasznalonev'] == 'FiredNox'){echo "<strong><font size=3px color=white $head $fsor[Admin]</font><br>";}
?>