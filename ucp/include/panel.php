<script type="text/javascript">
  var tick;
  function stop() {
  clearTimeout(tick);
  }
  function clock() {
  var ut=new Date();
  var h,m,s;
  var time="        ";
  h=ut.getHours();
  m=ut.getMinutes();
  s=ut.getSeconds();
  if(s<=9) s="0"+s;
  if(m<=9) m="0"+m;
  if(h<=9) h="0"+h;
  time+=h+":"+m+":"+s;
  document.getElementById('clock').innerHTML=time;
  tick=setTimeout("clock()",1000); 
  }
</script>				
			</div>

		</div>

		<div class="right">
		
			<div class="subnav">

				<?php
				if(!isset($user))
				{
					?>
					<center><font size=4>Bejelentkezés</font><br><br>
					<form method=post id=login>
					<input type=name name=felhasznalo placeholder=Felhasználónév><br>
					<input type=password name=jelszo placeholder=Jelszó><br>
					Jegyezzen meg <input type=checkbox name=emlekezz value="1"><br>
					<input type=submit name=login value=Bejelentkezés>
					</form>
					<a href="index.php?menu=elfelejtett">Elfelejtett jelszó</a>
					<?php
				}
				else
				{
					$lathatosag = true;
					$query = "select * from jatekosok";
					$result = mysql_query($query);
					$num = mysql_num_rows($result);
					$i = 0;
					while ($i < $num) {
						$hour = "<img src='img/hour.png'>";
						$money = "<img src='img/money.png'>";
						$skull = "<img src='img/skull.png'>";
						$pistol = "<img src='img/pistol.png'>";
						$penzed = mysql_result($result, $i, "Coin");
						$gyilok = mysql_result($result, $i, "Gyilok");
						$halal = mysql_result($result, $i, "Halal");
						echo "<br>";
						echo "<b><font color=yellow size=3>Üdvözöllek, $fsor[Felhasznalonev]!</font><br><br><hr><br><br>";
						include("include/panelrank.php");
						echo "<br><h3>";
						echo "$hour";
						echo '<font color=yellow><body onload="clock();" onunload="stop();"> <span id="clock"></span></font></tr>';
						echo "<br><br>";
						echo "<b><font color=yellow><h4>$money $penzed &cent;</font><br>";
						echo "<b><font color=yellow><h4>$pistol $gyilok db $skull $halal db</font><br>";
						echo "<br>";
						if($lathatosag == true)
						{
							include("include/serverinfo.php");
							
						}
						echo "<div class='subnav_gomb_leader' onclick='window.location.href=\"index.php?kijelentkezes\";'>Kijelentkezés</div>";
					$i++;
					}
				}
				?>
			</div>