			</div>

		</div>
		<div class="right">

			<div class="subnav">
				
				<? if($jatekos["Admin"] >= 1337) {
					echo '<script type="text/javascript" src="js/_admin_quickmenu.js"></script>';
					echo '<div style="position: relative">';
					echo 	'<div style="position: absolute; right: 0;" class="link" onclick="adminQuickmenu()" id="adminQuickmenu">Admin</div>';
					echo '</div>';
					echo '<div id="admin-quickmenu-dialog" class="overflow">';
					echo '<div id="admin-quickmenuAjax-dialog"></div>';
					echo '<span onclick="adminQuickmenu(\'frakciokezelo\')" class="link">Frakciókezelő</span>';
					echo '</div>';
				}
				?>
				
				<center>

				<?
				echo '<h1 style="font-weight:bold;"><a href="http://'.$config["WNev"].'" target="_BLANK">'.$config["SNev"].'</a></h1>
				<i>'.
				($config["Local"] ? 
					"127.0.0.1:".$config["Port"]
						:
					"ip.".$config["WNev"]
						.($config["Port"] != 7777 ? ":".$config["Port"] : "")
				) . "<br><a href='samp://ip." . $config["WNev"] . ":" . $config["Port"] . "'>Csatlakozás</a>"
				.'</i><br><br><b style="color: yellow">Idő: '.date("H:i:s")."</b><br>";

				$adminlapok = Array("admin", "admin_account", "admin_ban", "admin_karakter", "admin_log", "admin_nevvaltas", "admin_kontroll", "admin_szerkeszt", "admin_tarsitas", "admin_weblog", "admin_fo");
				if(in_array($config["Lap"], $adminlapok))
				{
					echo "<br><hr width='50%' style='border: 2px outset grey'><br>";
					echo "<b>Almenü</b><br>";
					foreach($config["AdminTeruletek"] as $link)
					{
						if(!is_array($link["admin"]) && $jatekos["Admin"] >= $link["admin"] ||
							is_array($link["admin"]) && in_array($jatekos["Nev"], $link["admin"]))
						{
							if($config["Lap"] == $link["link"])
								echo "- <a class='kiemelt bold' href='".$link["link"].$config["Ext"]."'>".$link["nev"]."</a><br>";
							else
								echo "- <a href='".$link["link"].$config["Ext"]."'>".$link["nev"]."</a><br>";
						}
					}
				}

				echo "<br><hr width='50%' style='border: 2px outset grey'><br>";
				if($jatekos["Belepve"])
				{
					if($jatekos["Kivalasztva"] < 1)
					{
						echo "<font color='cyan'><b>Nincs karakter kiválasztva</b><br><br>";
						echo "Ahhoz, hogy minden funkciót használhass, ki kell választanod egy karaktert</font><br><br>";
						//echo "Ezt <b><a href='karakter".$config["Ext"]."'>ITT</a></b> megteheted.</font><br><br>";
					}

					if($jatekos["Karakterek"] > 0)
					{
						echo "<select style='font-size: 10px'
							onChange='window.location = \"karakter".$config["Ext"]."?kivalaszt=\"+this.options[this.selectedIndex].value;'>";

						echo "<option value='0'>===[ Karakter kiválasztása ]===</option>";
						echo "<option value='1'>".$jatekos["Karakter"][0]["Nev"]."</option>";
						if($jatekos["Karakterek"] > 1) echo "<option value='2'>".$jatekos["Karakter"][1]["Nev"]."</option>";

						echo "</select><br>";
					}

					if($jatekos["Karakterek"] > 0 || $jatekos["Kivalasztva"] < 1)
						echo "<br><hr width='50%' style='border: 2px outset grey'><br>";
				}

				if(!$jatekos["Belepve"])
				{
					echo"
						<form method='POST'><input type='hidden' name='akcionev' value='belepes'>
						<input type='text' class='loginInput' name='nev' onFocus='if(this.value==\"Felhasználónév\")this.value=\"\";' maxlength='20' value='".(isset($SeeGlobal["felhasznalonev"]) ? $SeeGlobal["felhasznalonev"] : "Felhasználónév")."'><br>
						<input type='password' class='loginInput' name='jelszo' onFocus='if(this.value==\"alapjelszo!!\")this.value=\"\";' maxlength='20' value='".(isset($SeeGlobal["felhasznalonev"]) ? "" : "alapjelszo!!")."'><br><br>
						<input type='checkbox' class='loginCheckbox' name='megjegyez' value='igen'> Megjegyez<br><br>
						<input type='submit' class='loginSubmit' value='Belépés'>
						</form>
						<br><b><a href='regisztracio".$config["Ext"]."'>Regisztráció</a></b>
						<br><b><a href='elfelejtett_jelszo".$config["Ext"]."'>Elfelejtett jelszó</a></b>
					";

				}
				else
				{

					if($jatekos["Admin"] > 0)
					{
						$sql = mysql_query("SELECT ID FROM accountok WHERE Megerositve = '0'");
						$num = mysql_num_rows($sql); mysql_free_result($sql);
						if($num > 0) echo "<a href='admin_account".$config["Ext"]."'><b>Account regisztrációk:</b> <b style='color:yellow; text-decoration:blink;'>".$num."</b></a><br>";
						else echo "<a href='admin_account".$config["Ext"]."'><b>Account regisztrációk:</b> 0</a><br>";

						$sql = mysql_query("SELECT ID FROM accountok WHERE Letrehozas = '1'");
						$num = mysql_num_rows($sql); mysql_free_result($sql);
						if($num > 0) echo "<a href='admin_karakter".$config["Ext"]."'><b>Karakter regisztrációk:</b> <b style='color:yellow; text-decoration:blink;'>".$num."</b></a><br>";
						else echo "<a href='admin_karakter".$config["Ext"]."'><b>Karakter regisztrációk:</b> 0</a><br>";

						$sql = mysql_query("SELECT ID FROM accountok WHERE Tarsitas = '1'");
						$num = mysql_num_rows($sql); mysql_free_result($sql);
						if($num > 0) echo "<a href='admin_tarsitas".$config["Ext"]."'><b>Karakter társítások:</b> <b style='color:yellow; text-decoration:blink;'>".$num."</b></a><br>";
						else echo "<a href='admin_tarsitas".$config["Ext"]."'><b>Karakter társítások:</b> 0</a><br>";

						$sql = mysql_query("SELECT ID FROM nevvaltas WHERE Elbiralva = 'n'");
						$num = mysql_num_rows($sql); mysql_free_result($sql);
						if($num > 0) echo "<a href='admin_nevvaltas".$config["Ext"]."'><b>Névváltások:</b> <b style='color:yellow; text-decoration:blink;'>".$num."</b></a><br>";
						else echo "<a href='admin_nevvaltas".$config["Ext"]."'><b>Névváltások:</b> 0</a><br>";

						echo "<br><hr width='50%' style='border: 2px outset grey'><br>";
					}
					echo"
						<i title='".$jatekos["Mail"]."'>Üdv, <b>".$jatekos["Nev"]."</b></i><br>
						".($jatekos["Admin"] > 0 ? "<font color='yellow'>Admin: <b>".$jatekos["Admin"]."</b></font><br>" : "")."
						<a href='?kilepes'>Kijelentkezés</a>
					";
				}
				?>
				</center>

			</div>

		</div>

<?
require_once("include/lablec.php");
if($ConnectedMySQL) mysql_close();
?>