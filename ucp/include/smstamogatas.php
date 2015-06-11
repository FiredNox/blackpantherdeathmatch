<?php
	/*
	Autentikációs kód: 739a98425389e26642beda27aca62460
	id = az SMS egyedi azonosítója
	text = az SMS szövege
	tel = feladó telefonszáma (formatum: 36201234567)
	dest = a címzett száma (formatum: 612312)
	provider = a feladó szolgáltatója (1 = Pannon, 2 = T-mobile, 3 = Vodafone, 4 = Teszt)
	price = az SMS nettó értéke (formatum: 160)
	auth = a szerver hitelesítésére használt kód (további információ a beállításoknál)
	*/
	if(isset($_GET['auth']))
	{
		if($_GET['auth'] == "739a98425389e26642beda27aca62460")
		{
			
			include('funkciok.php');
			$csomag = $_GET['price'];
			$uzenet = $_GET['text'];
			$tel = $_GET['tel'];
			$user = explode("realrpg ",$uzenet);
			//InsertLog("tamogatasok","Támogatás debug: Üzenet: " . $uzenet,-1,-1);	
			$ertek = $csomag;
				
			$penz = 0;
			$kokain = 0;
			$heroin = 0;
			$marihuana = 0;
			$mati = 0;
			$ppont = 0;
			if($ertek == "400")
			{
				$penz = "1500000";
				$kokain = "1000";
				$heroin = "1000";
				$marihuana = "1000";
				$mati = "5000";
				$ppont = "1000";
			} else if($ertek == "800")
			{
				$penz = "3000000";
				$kokain = "2000";
				$heroin = "2000";
				$marihuana = "2000";
				$mati = "10000";
				$ppont = "2000";
			} else if($ertek == "1600")
			{
				$penz = "6000000";
				$kokain = "3000";
				$heroin = "3000";
				$marihuana = "3000";
				$mati = "20000";
				$ppont = "3000";
			}			
			if(LetezoSeeAccount($user[1]))
			{
				$adat = MySql_Get("SELECT * FROM playerek WHERE Nev='".$user[1]."'");
				if(!Online($user[1]))
				{
					InsertLog("tamogatasok","Támogatták a szervert! Felhasználó:".$user[1]." | Telefonszám: ".$tel." | Csomag: ".$ertek."",-1,-1);
					InsertLog("player","Támogatás érkezett a karakteredre! Telefonszám: ".$tel." | Csomag: ".$ertek."<br>
					+".$penz."Ft Pénz<br>
					+".$kokain." g Kokain<br>
					+".$heroin." g Heroin<br>
					+".$marihuana." g Marihuana<br>
					+".$mati." db Material<br>
					+".$ppont." db prémiumpont<br>",-1,$adat['ID']);
					$penz = ($adat['Money']+$penz);
					$cuccok = explode(",",$adat['Cuccok']);
					$mati = ($cuccok[4]+$mati);
					$kokain = ($cuccok[5]+$kokain);
					$heroin = ($cuccok[6]+$heroin);
					$marihuana = ($cuccok[7]+$marihuana);
					$premium = explode(",",$adat['Premium']);
					$premium[0] = $ertek;
					$premium[1] = ($premium[1]+$ppont);
					mysql_query("UPDATE playerek SET Money='".$penz."', Cuccok='".$cuccok[0].",".$cuccok[1].",".$cuccok[2].",".$cuccok[3].",".$mati.",".$kokain.",".$heroin.",".$marihuana."' WHERE ID='".$adat['ID']."'");
				}
				else
				{
					InsertLog("tamogatasok","".$user[1]." nevű karaktertől támogatás érkezett, de nem kapta meg, mert a karaktere online volt!<br>
					Csomag: ".$ertek." | Telefon: ".$tel."",-1,$adat['ID']);
					InsertLog("player","Támogatás érkezett a karakteredre, de nem kaptad meg, mert a karaktered ONLINE VAN!!!",-1,$adat['ID']);
				}
			}
			else
			{
				InsertLog("tamogatasok","".$user[1]." nevű karaktertől támogatás érkezett, de ilyen karakter nem létezik!<br>
				Csomag: ".$ertek." | Telefon: ".$tel."",-1,$adat['ID']);
			}
		}
		else
		{
			echo 'Ne próbálkozz!';
		}
	}
	else
	{
		echo 'Ne próbálkozz!';
	}
?>