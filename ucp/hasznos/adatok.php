
		<SCRIPT>
			$(document).ready(function(){
			
				$("#le").click(function(){
					$("#show").slideDown(1000);
				});
				
				$("#fel").click(function(){
					$("#show").slideUp(1000);
				});
			});
			
		</SCRIPT>
			<div id="center">
				<?php
					if($_GET["action"] == "myadat")
					{
						switch ($row["Repair"])
						{
							case 0: $AutoRepair = "Kikapcsolva";
							case 1: $AutoRepair = "Bekapcsolva";
						}
						
						echo '<h1>Adataid</h1><br />';
						echo '
							<table width="300">
								<tr><td>Neved</td><td><b>',$row["Name"],'</b></td></tr>
								<tr><td>Pont</td><td><b>',$row["Score"],'</b></td></tr>
								<tr><td>Pénz</td><td><b>',$row["Money"],'</b></td></tr>
								<tr><td>Kedvenc Skin ID</td><td><b>',$row["SaveSkin"],'</b></td></tr>
								<tr><td>Admin szinted</td><td><b>',$row["Admin"],'</b></td></tr>
								<tr><td>V.I.P szint</td><td><b>',$row["VIP"],'</b></td></tr>
								<tr><td>Drift Score</td><td><b>',$row["DriftScore"],'</b></td></tr>
							</table>
							
							<div id="adatokright">
								<div id="adatbox">
									<button id="le"><img src="images/nyil.png" width="15" height="15" /></button><span style="cursor:pointer; margin-left:60px;">Egyéb Adatok</span><span style="float:right;"><button id="fel"><img src="images/nyilfel.png" width="15" height="15" /></span>
								</div>
								<div id="show">
								<hr /><br />
								<table width="300">
									<tr><td>Regisztrációs ID:</td><td><b>',$row["ID"],'</b></td></tr>
									<tr><td>Email címed:</td><td><b>',$row["Email"],'</b></td></tr>
									<tr><td>Jelszavad:</td><td><b>',$row["Password"],'</b></td></tr>
									<tr><td>Regisztráltál:</td><td><b>',$row["RegDate"],'</b></td></tr>
									<tr><td>Automatikus javítás:</td><td><b>',$AutoRepair,'</b></td></tr>
								</table>
								</div>
							</div>
						';
					}
				?>
			</div>
			<div id="jobb">
				
			</div>