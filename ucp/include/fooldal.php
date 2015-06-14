<?php 
header('Content-Type: text/html; charset=utf-8'); 
?> 
<?php include("functions.php");?>
<?php include("doct.php");?>
</script>
</head>

<!-- default margin = default layout -->
<body>
<div align="center">
<div style="width: 1088px;">
<div class="container">
<?php
 /*Közösségi gombok*/
echo"
<div class='social-buttons'>
	<a id='facebook-btn' href='https://www.facebook.com/fntshelp' target='_blank'>
		<span class='social-icon'><span class='social-text'>Kövess minket a Facebook-on!</span></span>
	</a>
	<a id='rss-btn' href='' target='_blank'>
		<span class='social-icon'><span class='social-text'>Kövess minket Youtube-on!</span></span>
	</a>
</div>";
?>
	<div class="header"></div>
	<div class="nav">
		<a href="index.php"><font color=white>Főoldal</font></a>
		<?php
		echo '
		<a href="index.php?menu=statisztika"><font color=white>Statisztika</font></a>';
		/*if(isset($user))
		{
			if(isset($user))
			{
			}

		}*/
		echo '<a href="index.php?menu=kapcsolat&alap"><font color=#FFD700>Kapcsolat</font></a>';
		if(isset($user)) 
		{
			if($fsor[Admin] > '1')
			{
			echo '<a href="index.php?menu=admin"><font color=#4F4>Admin</font></a>';
			}
		}
		if(isset($user)) 
		{
			if($fsor[Admin] > '1337')
			{
			echo '<a href="index.php?menu=foadmin"><font color=lightblue>Főadmin</font></a>';
			}
		}
		if(isset($user)) 
		{
			if($fsor[Admin] >= '5555')
			{
			echo '<a href="index.php?menu=scripter"><font color=orange>Scripter</font></a>';
			}
		}
		
		?>
		<div class="clearer"><span></span></div>
	</div>

	<div class="main">
	
		<div class="left">

			<div class="content">

				<?php
				
				if(isset($_POST['login']))
				{
					echo "<h1>Bejelentkezés</h1>";
					$hash = SHA1($_POST['jelszo']);
					if($_POST['felhasznalo'] == "" || $_POST['jelszo'] == "")
						msg("2", "Minden mező kitöltése kötelező!");
					else if(!VanIlyenFelhasznalo($_POST['felhasznalo']) || RosszJelszo($_POST['felhasznalo'], $hash))
						msg("2", "Hibás felhasználónév / jelszó!");
					else
					{
						$getfsor_q = mysql_query("SELECT * FROM jatekosok WHERE `Felhasznalonev` = '".mysql_escape_string($_POST[felhasznalo])."'");
						$getfsor = mysql_fetch_array($getfsor_q);
						if(isset($_POST['emlekezz']))
						{
							setcookie("user",$getfsor['UID'],time()+31536000);
							setcookie("kivalasztott", $getfsor['UID'], time()+31536000);
							$ip = $_SERVER['REMOTE_ADDR'];
							ucp_log("login","".$_POST['felhasznalo']."", "belépett ".$ip."-vel!");
							header("Location: index.php");
						} else {
							setcookie("user",$getfsor['UID'],time()+1800);
							setcookie("kivalasztott", $getfsor['Admin'], time()+1800);
							$ip = $_SERVER['REMOTE_ADDR'];
							ucp_log("login","".$_POST['felhasznalo']."", "belépett ".$ip."-vel!");
							header("Location: index.php");
						}
					}
				}
				else
				{
					if(isset($_GET['menu']))
					{
					if($_GET['menu'] == "kapcsolat")
					{
						include("kapcsolat.php");
					}
					else if($_GET['menu'] == "egyeb")
					{
						include("egyeb.php");
					}
					else if($_GET['menu'] == "statisztika")
					{
						include("statisztika.php");
					}
					else if($_GET['menu'] == "admin")
					{
						include("admin.php");
					}
					else if($_GET['menu'] == "foadmin")
					{
						include("foadmin.php");
					}
					else if($_GET['menu'] == "tamogatas")
					{
						include("tamogatas.php");
					}
					else if(!isset($_GET['menu']))
					{
						include("main.php");
					}
					else if($_GET['menu'] == "elfelejtett" && !isset($user))
					{
						include("elfelejtett.php");
					}
					else if($_GET['menu'] == "scripter")
					{
						include("scripter.php");
					}
					else if($_GET['menu'] == "fejlesztesek")
					{
						include("fejlesztesek.php");
					}
					else
					{
						echo "<h1><font color=red><b>HIBA</b></font></h1><center>";
						echo "<img src='http://www.darklandrecordings.com/files/error.png'><br>
						<font size=6 color=red><b>A kért oldal nem található!</b></font>";
					}
				} else {
					include("main.php");
				}
				}
				
				?>
				<?php require("include/panel.php"); ?>
			<?php 
			
			if(isset($_GET['menu']))
			{
				if($_GET['menu'] == "admin")
				{
					if($sor['Admin'] > '0' OR $fsor['AAA'] > '0')
					{
						echo '<div style="padding-top:20px;"></div>
								<div class="subnav" style="border-top: 1px solid #02afd8;">
								<div align="center" style="color: limegreen; font-size: 15px">Admin</div>
								<br><hr><br>
								<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&atnezes\';">Áttekintés</div>
								<div style="padding-top: 5px;"></div>
								<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&bejelentesek\';">Bejelentések</div>
								<div style="padding-top: 5px;"></div>
								<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&szabályzat\';">Admin Szabályzat</div>
								<div style="padding-top: 5px;"></div>';
								echo '<br>';
								if($sor['Admin'] > '2' OR $fsor['AAA'] > '2')
								{
									echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&fejlesztesek\';">Admin Fejlesztések</div>
									<div style="padding-top: 5px;"></div>';
									echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&statisztika\';">Admin Statisztikák</div>
									<div style="padding-top: 5px;"></div>';
								}
								echo '<br>';
								if($sor['Admin'] > '3' OR $fsor['AAA'] > '3')
								{
								}
								echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=admin&borton\';">Admin Börtönök</div>
								<div style="padding-top: 5px;"></div>';
								echo '<br>';
						echo '</div>';
						echo '<br>';
					}
				}
			}
			if(isset($_GET['menu']))
			{
				if($_GET['menu'] == "foadmin")
				{
					if($sor['Admin'] > '1337' OR $fsor['AAA'] > '1337')
					{
						echo '<div style="padding-top:20px;"></div>
								<div class="subnav" style="border-top: 1px solid #02afd8;">
								<div align="center" style="color: lightblue; font-size: 15px">Főadmin</div>
								<br><hr><br>
								<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=foadmin&atnezes\';">Áttekintés</div>
								<div style="padding-top: 5px;"></div>
								<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=foadmin&bejelentesek\';">Bejelentések</div>
								<div style="padding-top: 5px;"></div>
								<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=foadmin&szabályzat\';">Főadmin Szabályzat</div>
								<div style="padding-top: 5px;"></div>
								<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=foadmin&szabályzat\';">Főadmin Fejlesztések</div>
								<div style="padding-top: 5px;"></div>
								<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=foadmin&logok\';">Naplózások</div>
									<div style="padding-top: 5px;"></div>';
						echo '</div>';
						echo '<br>';
					}
				}
			}
			if(isset($_GET['menu']))
			{
				if($_GET['menu'] == "kapcsolat")
				{
				echo '<div style="padding-top:20px;"></div>
						<div class="subnav" style="border-top: 1px solid #02afd8;">
						<div align="center" style="color: red; font-size: 15px">Csak végső esetben!</div>
						<br>
						<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=kapcsolat&headmaster\';">Headmaster</div>
						<div style="padding-top: 5px;"></div>';
				echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=kapcsolat&scripterek\';">Scripterek</div>
						<div style="padding-top: 5px;"></div>
						<br><hr><br>
						<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=kapcsolat&foadminok\';">Főadminisztrátok</div>
						<div style="padding-top: 5px;"></div>
						<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=kapcsolat&adminok\';">Adminisztrátorok</div>
						<div style="padding-top: 5px;"></div>
						<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=kapcsolat&segedek\';">Adminisztrátorsegédek</div>
							<div style="padding-top: 5px;"></div>';
				echo '</div>';
				echo '<br>';
				}
			}
			if(isset($_GET['menu']))
			{
				if($_GET['menu'] == "statisztika")
				{
				echo '<div style="padding-top:20px;"></div>
						<div class="subnav" style="border-top: 1px solid #02afd8;">
						<br>
						<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=statisztika&szerver\';">Szerver</div>
						<div style="padding-top: 5px;"></div>';
				echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=statisztika&sajat\';">Játékos</div>
						<div style="padding-top: 5px;"></div>
							<div style="padding-top: 5px;"></div>';
				echo '</div>';
				echo '<br>';
				}
			}
			if(isset($_GET['menu']))
			{
				if($_GET['menu'] == "scripter")
				{
					if($sor['Admin'] == '5555' OR $fsor['AAA'] == '5555')
					{
						echo '<div style="padding-top:20px;"></div>
								<div class="subnav" style="border-top: 1px solid #02afd8;">
								<div align="center" style="color: orange; font-size: 15px">Scripter</div>
								<br><hr><br>
								<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=scripter&atnezes\';">Áttekintés</div>
								<div style="padding-top: 5px;"></div>
								<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=scripter&feladatok\';">Feladatok</div>
								<div style="padding-top: 5px;"></div>
								<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=scripter&szabalyzat\';">Scripter Szabályzat</div>
								<div style="padding-top: 5px;"></div>
								<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=scripter&fejlesztesek\';">Scripter Fejlesztések</div>
								<div style="padding-top: 5px;"></div>';
								echo '<br>';
								if($sor['Felhasznalonev'] == 'FiredNox' OR $fsor['Felhasznalonev'] == 'FiredNox' && $sor['Admin'] == '5555')
								{
									echo '<div align="center" style="color: red; font-size: 16px">Headmaster</div>
									<br><hr><br>';
									echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=scripter&jegyzet\';">Jegyzet</div>
									<div style="padding-top: 5px;"></div>';
									echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=scripter&teszt\';">Teszt</div>
									<div style="padding-top: 5px;"></div>';
									echo '<div class="subnav_gomb" onclick="window.location.href=\'index.php?menu=scripter&logok\';">Naplózások</div>
									<div style="padding-top: 5px;"></div>';
								}
						echo '</div>';
						echo '<br>';
					}
				}
			}?></div>

		<div class="clearer"><span></span></div>

	</div>

	<?php Lablec(1); ?>

</div>
</div>
</div>
</body>

</html>