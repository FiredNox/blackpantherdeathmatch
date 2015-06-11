<?php
	if(isset($_GET['id']))
	{
		if($_GET['id'] == "") { msg("2","Nincs megadva skin id"); }
		else {
			if($sor['Member'] == "1")
			{
				if($_GET['id'] == "71" OR $_GET['id'] == "280" OR $_GET['id'] == "281" OR $_GET['id'] == "267" OR $_GET['id'] == "266" OR $_GET['id'] == "265" OR $_GET['id'] == "282" OR $_GET['id'] == "283" OR $_GET['id'] == "288" OR $_GET['id'] == "211")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "2")
			{
				if($_GET['id'] == "163" OR $_GET['id'] == "164" OR $_GET['id'] == "165" OR $_GET['id'] == "166" OR $_GET['id'] == "286" OR $_GET['id'] == "93" OR $_GET['id'] == "211")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "3")
			{
				if($_GET['id'] == "102" OR $_GET['id'] == "103" OR $_GET['id'] == "104" OR $_GET['id'] == "195" OR $_GET['id'] == "296" OR $_GET['id'] == "293")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "4")
			{
				if($_GET['id'] == "70" OR $_GET['id'] == "274" OR $_GET['id'] == "275" OR $_GET['id'] == "276" OR $_GET['id'] == "277" OR $_GET['id'] == "278" OR $_GET['id'] == "279" OR $_GET['id'] == "91" OR $_GET['id'] == "216")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "5")
			{
				if($_GET['id'] == "111" OR $_GET['id'] == "126" OR $_GET['id'] == "125" OR $_GET['id'] == "295" OR $_GET['id'] == "258" OR $_GET['id'] == "272")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "6")
			{
				if($_GET['id'] == "217" OR $_GET['id'] == "72" OR $_GET['id'] == "206" OR $_GET['id'] == "147" OR $_GET['id'] == "125" OR $_GET['id'] == "126" OR $_GET['id'] == "113")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "7")
			{
				if($_GET['id'] == "141" OR $_GET['id'] == "171" OR $_GET['id'] == "186" OR $_GET['id'] == "277" OR $_GET['id'] == "295" OR $_GET['id'] == "290" OR $_GET['id'] == "185" OR $_GET['id'] == "187" OR $_GET['id'] == "189" OR $_GET['id'] == "194" OR $_GET['id'] == "211" OR $_GET['id'] == "240" OR $_GET['id'] == "228" OR $_GET['id'] == "163" OR $_GET['id'] == "57" OR $_GET['id'] == "120" OR $_GET['id'] == "147" OR $_GET['id'] == "150" OR $_GET['id'] == "153" OR $_GET['id'] == "17" OR $_GET['id'] == "59")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "8")
			{
				if($_GET['id'] == "3" OR $_GET['id'] == "8" OR $_GET['id'] == "72" OR $_GET['id'] == "91" OR $_GET['id'] == "93" OR $_GET['id'] == "111" OR $_GET['id'] == "112" OR $_GET['id'] == "113" OR $_GET['id'] == "179" OR $_GET['id'] == "184" OR $_GET['id'] == "258" OR $_GET['id'] == "259" OR $_GET['id'] == "272" OR $_GET['id'] == "290" OR $_GET['id'] == "295")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "9")
			{
				if($_GET['id'] == "36" OR $_GET['id'] == "37" OR $_GET['id'] == "59" OR $_GET['id'] == "60" OR $_GET['id'] == "150" OR $_GET['id'] == "170" OR $_GET['id'] == "185" OR $_GET['id'] == "187")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "10")
			{
				if($_GET['id'] == "61" OR $_GET['id'] == "17" OR $_GET['id'] == "147" OR $_GET['id'] == "187" OR $_GET['id'] == "255" OR $_GET['id'] == "171" OR $_GET['id'] == "189" OR $_GET['id'] == "253" OR $_GET['id'] == "150" OR $_GET['id'] == "172" OR $_GET['id'] == "11")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "11")
			{
				if($_GET['id'] == "30" OR $_GET['id'] == "108" OR $_GET['id'] == "109" OR $_GET['id'] == "110" OR $_GET['id'] == "292" OR $_GET['id'] == "298" OR $_GET['id'] == "47" OR $_GET['id'] == "192")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "12")
			{
				if($_GET['id'] == "180" OR $_GET['id'] == "19" OR $_GET['id'] == "22" OR $_GET['id'] == "144" OR $_GET['id'] == "28")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "13")
			{
				if($_GET['id'] == "114" OR $_GET['id'] == "115" OR $_GET['id'] == "116" OR $_GET['id'] == "173" OR $_GET['id'] == "174" OR $_GET['id'] == "175" OR $_GET['id'] == "226" OR $_GET['id'] == "41" OR $_GET['id'] == "233" OR $_GET['id'] == "44" OR $_GET['id'] == "48" OR $_GET['id'] == "184")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nemveheted fel!");
				}
			} else if($sor['Member'] == "14")
			{
				if($_GET['id'] == "163" OR $_GET['id'] == "164" OR $_GET['id'] == "165" OR $_GET['id'] == "166" OR $_GET['id'] == "187" OR $_GET['id'] == "295" OR $_GET['id'] == "287")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "15")
			{
				if($_GET['id'] == "3" OR $_GET['id'] == "46" OR $_GET['id'] == "34" OR $_GET['id'] == "27" OR $_GET['id'] == "48" OR $_GET['id'] == "72" OR $_GET['id'] == "91" OR $_GET['id'] == "124" OR $_GET['id'] == "125" OR $_GET['id'] == "171" OR $_GET['id'] == "189" OR $_GET['id'] == "194" OR $_GET['id'] == "223" OR $_GET['id'] == "242" OR $_GET['id'] == "291")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "16")
			{
				if($_GET['id'] == "228" OR $_GET['id'] == "185" OR $_GET['id'] == "223" OR $_GET['id'] == "189" OR $_GET['id'] == "172" OR $_GET['id'] == "233" OR $_GET['id'] == "57")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "17")
			{
				if($_GET['id'] == "105" OR $_GET['id'] == "106" OR $_GET['id'] == "107" OR $_GET['id'] == "86" OR $_GET['id'] == "149" OR $_GET['id'] == "269" OR $_GET['id'] == "270" OR $_GET['id'] == "271" OR $_GET['id'] == "237" OR $_GET['id'] == "195" OR $_GET['id'] == "65" OR $_GET['id'] == "293")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "18")
			{
				if($_GET['id'] == "8" OR $_GET['id'] == "42" OR $_GET['id'] == "50" OR $_GET['id'] == "144" OR $_GET['id'] == "153" OR $_GET['id'] == "193")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "19")
			{
				if($_GET['id'] == "273" OR $_GET['id'] == "184" OR $_GET['id'] == "30" OR $_GET['id'] == "47" OR $_GET['id'] == "292" OR $_GET['id'] == "193")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "20")
			{
				if($_GET['id'] == "280" OR $_GET['id'] == "266" OR $_GET['id'] == "281" OR $_GET['id'] == "267" OR $_GET['id'] == "282" OR $_GET['id'] == "283" OR $_GET['id'] == "69" OR $_GET['id'] == "265")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "21")
			{
				if($_GET['id'] == "223" OR $_GET['id'] == "98" OR $_GET['id'] == "46" OR $_GET['id'] == "124" OR $_GET['id'] == "272" OR $_GET['id'] == "273" OR $_GET['id'] == "290" OR $_GET['id'] == "126" OR $_GET['id'] == "125" OR $_GET['id'] == "171" OR $_GET['id'] == "119" OR $_GET['id'] == "299")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "22")
			{
				if($_GET['id'] == "277" OR $_GET['id'] == "278")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "23")
			{
				if($_GET['id'] == "59" OR $_GET['id'] == "118" OR $_GET['id'] == "121" OR $_GET['id'] == "122" OR $_GET['id'] == "228" OR $_GET['id'] == "93" OR $_GET['id'] == "141" OR $_GET['id'] == "214" OR $_GET['id'] == "117" OR $_GET['id'] == "120" OR $_GET['id'] == "123" OR $_GET['id'] == "208")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "24")
			{
				if($_GET['id'] == "189" OR $_GET['id'] == "185" OR $_GET['id'] == "186" OR $_GET['id'] == "17" OR $_GET['id'] == "214" OR $_GET['id'] == "11" OR $_GET['id'] == "59" OR $_GET['id'] == "68" OR $_GET['id'] == "71")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			} else if($sor['Member'] == "25")
			{
				if($_GET['id'] == "285")
				{
					$ujskin = mysql_query("UPDATE playerek SET Model='{$_GET['id']}' WHERE Nev='{$sor['Nev']}'");
					$skinvalasztva = mysql_query("UPDATE ucpuserek SET F_skinvalaszt='0' WHERE Felhasznalonev='{$fsor['Felhasznalonev']}'");
					header("Location: index.php?menu=karakterek");
				} else {
					msg("2","Ezt a skint nem veheted fel!");
				}
			}
		}
	}
	echo '<div style="font-size: 16px; color: #ffffff; font-weight: bold;">Fellettél véve egy frakcióba, válassz skin-t!</div>';
	echo '<div style="padding-top: 30px;"></div>';
	if($sor['Member'] == "1")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=71"><img src="skinek/Skin_71.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=280"><img src="skinek/Skin_280.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=281"><img src="skinek/Skin_281.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=267"><img src="skinek/Skin_267.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=266"><img src="skinek/Skin_266.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=265"><img src="skinek/Skin_265.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=282"><img src="skinek/Skin_282.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=283"><img src="skinek/Skin_283.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=288"><img src="skinek/Skin_288.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=211"><img src="skinek/Skin_211.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "2")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=163"><img src="skinek/Skin_163.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=164"><img src="skinek/Skin_164.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=165"><img src="skinek/Skin_165.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=166"><img src="skinek/Skin_166.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=286"><img src="skinek/Skin_286.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=93"><img src="skinek/Skin_93.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=211"><img src="skinek/Skin_211.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "3")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=102"><img src="skinek/Skin_102.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=103"><img src="skinek/Skin_103.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=104"><img src="skinek/Skin_104.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=195"><img src="skinek/Skin_195.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=296"><img src="skinek/Skin_296.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=293"><img src="skinek/Skin_293.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "4")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=70"><img src="skinek/Skin_70.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=274"><img src="skinek/Skin_274.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=275"><img src="skinek/Skin_275.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=276"><img src="skinek/Skin_276.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=277"><img src="skinek/Skin_277.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=278"><img src="skinek/Skin_278.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=279"><img src="skinek/Skin_279.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=91"><img src="skinek/Skin_91.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=216"><img src="skinek/Skin_216.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "5")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=111"><img src="skinek/Skin_111.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=126"><img src="skinek/Skin_126.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=125"><img src="skinek/Skin_125.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=295"><img src="skinek/Skin_295.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=258"><img src="skinek/Skin_258.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=272"><img src="skinek/Skin_272.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "6")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=217"><img src="skinek/Skin_217.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=72"><img src="skinek/Skin_72.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=206"><img src="skinek/Skin_206.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=147"><img src="skinek/Skin_147.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=125"><img src="skinek/Skin_125.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=126"><img src="skinek/Skin_126.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=113"><img src="skinek/Skin_113.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "7")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=141"><img src="skinek/Skin_141.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=171"><img src="skinek/Skin_171.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=186"><img src="skinek/Skin_186.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=277"><img src="skinek/Skin_277.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=295"><img src="skinek/Skin_295.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=290"><img src="skinek/Skin_290.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=185"><img src="skinek/Skin_185.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=187"><img src="skinek/Skin_187.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=189"><img src="skinek/Skin_189.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=194"><img src="skinek/Skin_194.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=59"><img src="skinek/Skin_59.png"></td>
				</tr>
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=211"><img src="skinek/Skin_211.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=240"><img src="skinek/Skin_240.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=228"><img src="skinek/Skin_228.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=163"><img src="skinek/Skin_163.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=57"><img src="skinek/Skin_57.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=120"><img src="skinek/Skin_120.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=147"><img src="skinek/Skin_147.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=150"><img src="skinek/Skin_150.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=153"><img src="skinek/Skin_153.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=17"><img src="skinek/Skin_17.png"></td>
					<td></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "8")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=3"><img src="skinek/Skin_3.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=8"><img src="skinek/Skin_8.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=72"><img src="skinek/Skin_72.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=91"><img src="skinek/Skin_91.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=93"><img src="skinek/Skin_93.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=111"><img src="skinek/Skin_111.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=112"><img src="skinek/Skin_112.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=113"><img src="skinek/Skin_113.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=179"><img src="skinek/Skin_179.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=184"><img src="skinek/Skin_184.png"></td>
				</tr>
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=258"><img src="skinek/Skin_258.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=259"><img src="skinek/Skin_259.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=272"><img src="skinek/Skin_272.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=290"><img src="skinek/Skin_290.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=295"><img src="skinek/Skin_295.png"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "9")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=36"><img src="skinek/Skin_36.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=37"><img src="skinek/Skin_37.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=59"><img src="skinek/Skin_59.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=60"><img src="skinek/Skin_60.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=150"><img src="skinek/Skin_150.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=170"><img src="skinek/Skin_170.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=185"><img src="skinek/Skin_185.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=187"><img src="skinek/Skin_187.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "10")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=61"><img src="skinek/Skin_61.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=17"><img src="skinek/Skin_17.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=147"><img src="skinek/Skin_147.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=187"><img src="skinek/Skin_187.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=255"><img src="skinek/Skin_255.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=171"><img src="skinek/Skin_171.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=189"><img src="skinek/Skin_189.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=253"><img src="skinek/Skin_253.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=150"><img src="skinek/Skin_150.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=172"><img src="skinek/Skin_172.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=11"><img src="skinek/Skin_11.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "11")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=30"><img src="skinek/Skin_30.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=108"><img src="skinek/Skin_108.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=109"><img src="skinek/Skin_109.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=110"><img src="skinek/Skin_110.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=292"><img src="skinek/Skin_292.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=298"><img src="skinek/Skin_298.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=47"><img src="skinek/Skin_47.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=192"><img src="skinek/Skin_192.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "12")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=180"><img src="skinek/Skin_180.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=19"><img src="skinek/Skin_19.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=22"><img src="skinek/Skin_22.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=144"><img src="skinek/Skin_144.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=28"><img src="skinek/Skin_28.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "13")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=114"><img src="skinek/Skin_114.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=115"><img src="skinek/Skin_115.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=116"><img src="skinek/Skin_116.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=173"><img src="skinek/Skin_173.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=174"><img src="skinek/Skin_174.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=175"><img src="skinek/Skin_175.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=226"><img src="skinek/Skin_226.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=41"><img src="skinek/Skin_41.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=233"><img src="skinek/Skin_233.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=44"><img src="skinek/Skin_44.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=48"><img src="skinek/Skin_48.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=184"><img src="skinek/Skin_184.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "14")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=163"><img src="skinek/Skin_163.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=164"><img src="skinek/Skin_164.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=165"><img src="skinek/Skin_165.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=166"><img src="skinek/Skin_166.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=187"><img src="skinek/Skin_187.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=295"><img src="skinek/Skin_295.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=287"><img src="skinek/Skin_287.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "15")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=3"><img src="skinek/Skin_
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=46"><img src="skinek/Skin_
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=34"><img src="skinek/Skin_
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=27"><img src="skinek/Skin_
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=48"><img src="skinek/Skin_
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=72"><img src="skinek/Skin_
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=91"><img src="skinek/Skin_
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=124"><img src="skinek/Skin_
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=125"><img src="skinek/Skin_
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=171"><img src="skinek/Skin_
				</tr>
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=189"><img src="skinek/Skin_
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=194"><img src="skinek/Skin_
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=223"><img src="skinek/Skin_
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=242"><img src="skinek/Skin_
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=291"><img src="skinek/Skin_
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "16")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=228"><img src="skinek/Skin_228.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=185"><img src="skinek/Skin_185.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=223"><img src="skinek/Skin_223.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=189"><img src="skinek/Skin_189.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=172"><img src="skinek/Skin_172.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=233"><img src="skinek/Skin_233.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=57"><img src="skinek/Skin_57.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "17")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=105"><img src="skinek/Skin_105.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=106"><img src="skinek/Skin_106.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=107"><img src="skinek/Skin_107.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=86"><img src="skinek/Skin_86.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=149"><img src="skinek/Skin_149.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=269"><img src="skinek/Skin_269.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=270"><img src="skinek/Skin_270.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=271"><img src="skinek/Skin_271.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=237"><img src="skinek/Skin_237.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=195"><img src="skinek/Skin_195.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=65"><img src="skinek/Skin_65.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=293"><img src="skinek/Skin_293.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "18")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=8"><img src="skinek/Skin_8.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=42"><img src="skinek/Skin_42.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=50"><img src="skinek/Skin_50.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=144"><img src="skinek/Skin_144.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=153"><img src="skinek/Skin_153.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=193"><img src="skinek/Skin_193.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "19")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=273"><img src="skinek/Skin_273.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=184"><img src="skinek/Skin_184.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=30"><img src="skinek/Skin_30.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=47"><img src="skinek/Skin_47.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=292"><img src="skinek/Skin_292.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=193"><img src="skinek/Skin_193.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "20")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=280"><img src="skinek/Skin_280.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=266"><img src="skinek/Skin_266.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=281"><img src="skinek/Skin_281.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=267"><img src="skinek/Skin_267.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=282"><img src="skinek/Skin_282.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=283"><img src="skinek/Skin_283.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=69"><img src="skinek/Skin_69.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=265"><img src="skinek/Skin_265.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "21")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=223"><img src="skinek/Skin_223.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=98"><img src="skinek/Skin_98.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=46"><img src="skinek/Skin_46.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=124"><img src="skinek/Skin_124.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=272"><img src="skinek/Skin_272.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=273"><img src="skinek/Skin_273.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=290"><img src="skinek/Skin_290.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=126"><img src="skinek/Skin_126.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=125"><img src="skinek/Skin_125.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=171"><img src="skinek/Skin_171.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=119"><img src="skinek/Skin_119.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=299"><img src="skinek/Skin_299.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "22")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=277"><img src="skinek/Skin_277.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=278"><img src="skinek/Skin_278.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "23")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=59"><img src="skinek/Skin_59.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=118"><img src="skinek/Skin_118.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=121"><img src="skinek/Skin_121.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=122"><img src="skinek/Skin_122.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=228"><img src="skinek/Skin_228.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=93"><img src="skinek/Skin_93.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=141"><img src="skinek/Skin_141.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=214"><img src="skinek/Skin_214.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=117"><img src="skinek/Skin_117.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=120"><img src="skinek/Skin_120.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=123"><img src="skinek/Skin_123.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=208"><img src="skinek/Skin_208.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "24")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=189"><img src="skinek/Skin_189.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=185"><img src="skinek/Skin_185.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=186"><img src="skinek/Skin_186.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=17"><img src="skinek/Skin_17.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=214"><img src="skinek/Skin_214.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=11"><img src="skinek/Skin_11.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=59"><img src="skinek/Skin_59.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=68"><img src="skinek/Skin_68.png"></td>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=71"><img src="skinek/Skin_71.png"></td>
				</tr>
			</table>';
	} else if($sor['Member'] == "25")
	{
		echo '<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?menu=karakterek&frakcioskinvaltas&id=285"><img src="skinek/Skin_285.png"></td>
				</tr>
			</table>';
	}
?>