<?php

	define("CONFIG_BETOLTVE", "1");

	$config = Array("Host", "Port", "User", "Pass", "DB", "CookieName", "Ext", "Frakciok", "Local", "Lap");

	$config["Lap"] = basename($_SERVER["SCRIPT_NAME"], ".php");

	$config["SNev"] = "ClassRPG";
	$config["Nev"] = "ClassRPG - Kezelőfelület";
	$config["WNev"] = "classrpg.net";
	$config["Host"]	= "88.198.80.45";
	$config["Port"]	= "7777";

	$fo = array(
		"ucp.classrpg.net", "usercp.seerpg.net", "www.usercp.seerpg.net",
		"ucp.seerpg.net", "www.ucp.seerpg.net",
		"ucp.seerpg.hu", "www.ucp.seerpg.hu",
		"new.seerpg.net", "www.new.seerpg.net",
		"ideiglenes.seerpg.net", "www.ideiglenes.seerpg.net",
		"server.seerpg.net", "www.server.seerpg.net",
		"www.ucp.classrpg.net",
	);

	if(in_array($_SERVER["SERVER_NAME"], $fo))
		$config["Local"] = false;
	else
		$config["Local"] = true;

	$config["Settings"] = Array(
		"kezelesi_koltseg" => 5
	);

	$config["Scripter"] = Array("Csendes_Marcell","Dolph","FiredNox","fear_ezmegmi","EdwardC","Terno", "Nick");
	$config["Kontroll"] = Array("Csendes_Marcell","Dolph","FiredNox","fear_ezmegmi","EdwardC","Terno", "Nick");
	$config["SuperSCR"] = Array("FiredNox","fear_ezmegmi", "Nick");
	$config["Amos"] = Array("FiredNox");
	
	$config["PK_Oldalak"] = Array(
								"kep" => Array(
									"imageshack.us",
									"seerpgkep.jatekoldal.net"
								),
								"video" => Array(
									"youtube.com",
									"xfire.com"
								)
							);

	if($config["Local"])
	{
		$config["Host"]	= "127.0.0.1";
		$config["Port"]	= "7778";

		$config["SQL"] = Array(
			"Host"	=> "127.0.0.1",
			"User"	=> "class_user",
			"Pass"	=> "Qs6nHArzUyf2I",
			"DB"	=> "class_db",
		);

		$config["TestSQL"] = Array(
			"Host"	=> "127.0.0.1",
			"User"	=> "seosee",
			"Pass"	=> "seeseo",
			"DB"	=> "seotest",
		);

		$config["URL"]	= "http://ucp.classrpg.net";
		$config["Mappa"]= "/games/samp/teszt/";

	}
	else
	{
		$config["SQL"] = Array(
			"Host"	=> "127.0.0.1",
			"User"	=> "class_user",
			"Pass"	=> "Qs6nHArzUyf2I",
			"DB"	=> "class_db",
		);

		$config["TestSQL"] = Array(
			"Host"	=> "127.0.0.1",
			"User"	=> "ucp",
			"Pass"	=> "kezelofelulet",
			"DB"	=> "seotest",
		);

		$config["URL"]	= "http://ucp.classrpg.net";
		$config["Mappa"]= "/games/samp/clstest/";
	}

	$config["Path"] = Array(
		"class" => "include/class",
		"data" => "data",
		"activity" => "data/activity"
	);

	$config["Tamogatas"] = false;
	$config['SMSAuth'] = '';

	$config["WebSQL"]	= Array(
		"Host"	=> "",
		"User"	=> "",
		"Pass"	=> "",
		"DB"	=> ""
	);

	$config["Ext"]  = ".web";
	$config["HibasRuhak"] = Array(3, 4, 5, 6, 8, 42, 53, 65, 74, 86, 91, 119, 149, 208, 268, 273, 289);
	$config["CivilRuhak"] = Array(1, 2, 10, 11, 12, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 26, 27, 28, 29, 34, 35, 36, 37, 38, 39, 41, 43, 44, 45, 49, 50, 51, 52, 54, 55, 56, 57, 58, 62, 63, 64, 67, 68, 69, 72, 73, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 92, 94, 95, 96, 97, 99, 100, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, 141, 143, 144, 145, 146, 151, 152, 153, 154, 155, 156, 157, 158, 159, 160, 162, 167, 168, 170, 172, 176, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 189, 190, 191, 192, 193, 194, 195, 196, 197, 199, 200, 201, 203, 204, 205, 206, 207, 209, 210, 211, 212, 213, 214, 215, 216, 218, 219, 221, 222, 223, 224, 225, 226, 229, 230, 231, 232, 233, 234, 235, 236, 237, 238, 239, 240, 241, 242, 243, 244, 245, 246, 248, 249, 251, 252, 253, 254, 255, 256, 256, 257, 258, 259, 260, 262, 263, 264, 290, 291, 297, 298);

	$config["AdminTeruletek"] = Array(
		Array("nev" => "Kapcsolódások",				"link" => "admin_connect",		"admin" => 1),
		Array("nev" => "Account regisztrációk",		"link" => "admin_account",		"admin" => 1),
		Array("nev" => "Karakter regisztrációk",	"link" => "admin_karakter",		"admin" => 1),
		Array("nev" => "Karakter társítások",		"link" => "admin_tarsitas",		"admin" => 2),
		Array("nev" => "Ban / UnBan",				"link" => "admin_ban",			"admin" => 5),
		Array("nev" => "Karakter szerkesztése",		"link" => "admin_szerkeszt",	"admin" => 3),
        Array("nev" => "Névváltások",				"link" => "admin_nevvaltas",	"admin" => 6),
		Array("nev" => "Szerver log",				"link" => "admin_log",			"admin" => 6),
		Array("nev" => "Szerver Kontroll",			"link" => "admin_kontroll",		"admin" => $config["Kontroll"]),
		Array("nev" => "Web log",					"link" => "admin_weblog",		"admin" => 1337),
		Array("nev" => "Admin Válaszok",			"link" => "admin_va",			"admin" => 1337),
        Array("nev" => "Főadmin eszközök",			"link" => "admin_fo",			"admin" => 1337),
		Array("nev" => "Tesztkérdések",				"link" => "admin_teszt",		"admin" => 1340)
	);
	
	$config["AmosTerulet"] = Array(
		Array("nev" => "Kapcsolódások",				"link" => "admin_connect",		"admin" => $config["Amos"]),
		Array("nev" => "Account regisztrációk",		"link" => "admin_account",		"admin" => $config["Amos"]),
		Array("nev" => "Karakter regisztrációk",	"link" => "admin_karakter",		"admin" => $config["Amos"]),
		Array("nev" => "Karakter társítások",		"link" => "admin_tarsitas",		"admin" => $config["Amos"]),
		Array("nev" => "Ban / UnBan",				"link" => "admin_ban",			"admin" => $config["Amos"]),
		Array("nev" => "Karakter szerkesztése",		"link" => "admin_szerkeszt",	"admin" => $config["Amos"]),
        Array("nev" => "Névváltások",				"link" => "admin_nevvaltas",	"admin" => $config["Amos"]),
		Array("nev" => "Szerver log",				"link" => "admin_log",			"admin" => $config["Amos"]),
		Array("nev" => "Szerver Kontroll",			"link" => "admin_kontroll",		"admin" => $config["Amos"]),
		Array("nev" => "Web log",					"link" => "admin_weblog",		"admin" => $config["Amos"]),
		Array("nev" => "Admin Válaszok",			"link" => "admin_va",			"admin" => $config["Amos"]),
        Array("nev" => "Főadmin eszközök",			"link" => "admin_fo",			"admin" => $config["Amos"]),
		Array("nev" => "CCTV Rejtekhely",			"link" => "admin_rejtekhely",	"egyeb" => "style='color: #1E90FF'",	"admin" => $config["Amos"]),
		Array("nev" => "Tesztkérdések",				"link" => "admin_teszt",		"admin" => $config["Amos"])
	);

	$config["ScripterTeruletek"] = Array(
		Array("nev" => "Alap scripter eszközök", "link" => "admin_scripter", "login" => "scripter"),
		Array("nev" => "Kapuk kezelése", "link" => "admin_kapu", "login" => "scripter"),
		Array("nev" => "Admin Válaszok", "link" => "admin_va", "login" => "scripter"),
		Array("nev" => "Kontroll", "link" => "admin_kontroll", "egyeb" => "style='color: #1E90FF'", "login" => "scripter"),
		//Array("nev" => "PHP Info", "link" => "admin_phpinfo", "admin" => 5555),
		Array("nev" => "Ékezet konvertáló", "link" => "scripter_ekezet", "login" => "scripter"),
		Array("nev" => "SzerverLog", "link" => "admin_log", "login" => "scripter"),
	);

	$config["ScripterInfo"] = Array(
		Array("nev" => "Illegálisok", "link" => "admin_illegalisok", "egyeb" => "style='color: #FF4500'", "login" => "scripter"),
		Array("nev" => "Rendvédelem", "link" => "admin_rendvedelem", "egyeb" => "style='color: #1E90FF'", "login" => "scripter"),
		Array("nev" => "Civilek", "link" => "admin_civilek", "egyeb" => "style='color: #F0F8FF'", "login" => "scripter"),
	);
	
	$config["Menuk"] = Array(
		Array(
			"nev" => "Főoldal", "link" => "fooldal", "login" => "any"
		),
		Array(
			"nev" => "Regisztráció", "link" => "regisztracio", "login" => "nologin"
		),
		Array(
			"nev" => "Karakter", "link" => "karakter", "login" => "login",
			"almenu" => Array(
				Array("nev" => "Művelet", "link" => "muvelet", "login" => "select"),
				Array("nev" => "LOG", "link" => "log", "login" => "login"),
				Array("nev" => "Teszt kitöltése", "link" => "quiz", "login" => "login", "egyeb" => "style='color: #0FE'"),
				Array("nev" => "Piac", "link" => "piac", "login" => "select"
				),
			),
		),
		
		Array(
			"nev" => "Frakció", "link" => "frakcio", "login" => "login",
			"almenu" => Array(
				Array(
					"nev" => "SWAT",
					"link" => "frakcio_swat",
					"login" => "swat"
				),
				Array(
					"nev" => "SSS",
					"link" => "frakcio_sss",
					"login" => "sss"
				),
				Array(
					"nev" => "Autókereskedés",
					"link" => "frakcio_autoker",
					"login" => "autoker"
				),
				Array(
					"nev" => "Autószerelő",
					"link" => "frakcio_szerelo",
					"login" => "szerelo"
				),
				Array(
					"nev" => "Hitman",
					"link" => "frakcio_hitman",
					"login" => "hitman"
				),
			),
		),
		Array(
			"nev" => "Játékosok", "link" => "jatekosok", "login" => "select"
		),
		Array("nev" => "Top", "link" => "toplista", "login" => "login"),
		Array(
			"nev" => "Statisztika", "link" => "statisztika", "login" => "any",
		),
		        Array(
            "nev" => "Információk", "link" => "no", "login" => "login",
            "almenu" => Array(
			
                Array(
                    "nev" => "Névváltások",
                    "link" => "nevvaltasok",
                    "login" => "login"
                ),
				Array(
					"nev" => "Parancsok",
					"link" => "parancsok",
					"login" => "login",
					"egyeb" => "style='color: #98FB98'"),
                Array(
                    "nev" => "Járművek",
                    "link" => "jarmuvek",
                    "login" => "login"
                ),
                Array(
                    "nev" => "Boltrablás",
                    "link" => "egyeb_boltrablas",
                    "login" => "login",
					"egyeb" => "style='color: #1E90FF'"
                ),
                Array(
                    "nev" => "Versenyek",
                    "link" => "versenyek",
                    "login" => "login"
                ),
                Array(
                    "nev" => "Chat convert",
                    "link" => "chat_convert",
                    "login" => "login"
                ),
				/*Array(
					"nev" => "IRC",
					"link" => "irc",
					"login" => "login"
				)*/
            )
        ),
/*		Array(
			"nev" => "Támogatás", "link" => "tamogatas", "login" => "any",
			"egyeb" => "style='color: yellow'",
			"almenu" => Array(
				Array(
					"nev" => "PayPal",
					"link" => "tamogatas_paypal",
					"login" => "any",
				),
			),
		),	
		//Array(
		//	"nev" => "Panaszkönyv", "link" => "panaszkonyv", "login" => "login",
		//),
		
		/*Array(
			"nev" => "Képfeltöltés", "link" => "kepfeltoltes", "login" => "login", "egyeb" => "style='color: #ffa'"
		),*/
		Array(
			"nev" => "Kapcsolat",
			"link" => "kapcsolat",
			"login" => "any",
			"egyeb" => "style='color: #FA7'"
		),
		Array(
			"nev" => "Admin", "link" => "admin", "login" => "admin",
			"egyeb" => "style='font-weight: bold; color: #4F4;'",
			"almenu" => $config["AdminTeruletek"]
		),
		Array(
			"nev" => "Scripter", "link" => "no", "login" => "scripter",
			"egyeb" => "style='font-weight: bold; color: orange'",
			"almenu" => $config["ScripterTeruletek"]
		),
		Array(
			"nev" => "Scripter Info", "link" => "no", "login" => "scripter",
			"egyeb" => "style='font-weight: bold; color: #FFD700'",
			"almenu" => $config["ScripterInfo"]
		),
		Array(
			"nev" => "FN", "link" => "no", "login" => "scripter",
			"egyeb" => "style='font-weight: bold; color: red'",
			"almenu" => $config["AmosTerulet"]
		),
	);

	$config["CookieName"] = Array(
		"name"		=> "ClassRPG_UserCP_Name",
		"pass"		=> "ClassRPG_UserCP_Pass",
		"karakter"	=> "ClassRPG_UserCP_Karakter");

	$ConnectedMySQL = false;

$config["AFA"] = 27;
$config["Prefix"] = "classrpg";

$config["Kredit"] = array(
	'SMS' => array(
		'Csomagok' => array(
			array(
				'Nev'		=> 'Bronz',
				'Szin'		=> '#8c7853',
				'Ara'		=> 260,
				'Kredit'	=> 200,
				'Szam'		=> '06-90-642-342'
			),
			array(
				'Nev'		=> 'Silver',
				'Szin'		=> '#c0c0c0',
				'Ara'		=> 800,
				'Kredit'	=> 450,
				'Szam'		=> '06-90-888-309'
			),
			array(
				'Nev'		=> 'Gold',
				'Szin'		=> '#ffd700',
				'Ara'		=> 1600,
				'Kredit'	=> 1100,
				'Szam'		=> '06-90-888-409'
			),
			array(
				'Nev'		=> 'Platina',
				'Szin'		=> '#82B1CF',
				'Ara'		=> 4000,
				'Kredit'	=> 3300,
				'Szam'		=> '06-90-649-549'
			),
		)
	),
	'PayPal' => array(
		'Min' => 1000,
		'Max' => 15000,
		'Csomagok' => array(
			array(
				'Nev'	=> 'Bronz',
				'Szin'	=> '#8c7853',
				'Min'	=> 0,
				'Bonus'	=> 0
			),
			array(
				'Nev'	=> 'Ezüst',
				'Szin'	=> '#c0c0c0',
				'Min'	=> 3000,
				'Bonus'	=> 5
			),
			array(
				'Nev'	=> 'Arany',
				'Szin'	=> '#ffd700',
				'Min'	=> 7000,
				'Bonus'	=> 10
			),
			array(
				'Nev'	=> 'Gyémánt',
				'Szin'	=> '#82B1CF',
				'Min'	=> 10000,
				'Bonus'	=> 15
			),
		)
	)
);

$config["Csomagok"] = Array(
	/*"1" => Array(
		"ID" => 1,
		"Nev" => "Bronz",
		"Szin" => "bronze",
		"Ara" => 160,
		"Telefonszam" => "06-90-444-154",
		"Penz" => 250000,
		"Kokain" => 100,
		"Heroin" => null,
		"Marihuana" => null,
		"Material" => 500,
		"Kamat" => null,
		"Hazszef" => null,
		"FegyverSlot" => null,
		"Ido" => null,
		"Pont" => null,
		),*/
	"2" => Array(
		"ID" => 2,
		"Nev" => "Silver",
		"Szin" => "silver",
		"Ara" => 260,
		"Telefonszam" => "06-90-642-342",
		"Penz" => 500000,
		"Kokain" => 150,
		"Heroin" => 150,
		"Marihuana" => null,
		"Material" => 1000,
		"Kamat" => null,
		"Hazszef" => null,
		"FegyverSlot" => null,
		"Ido" => null,
		"Pont" => null,
		),
	"3" => Array(
		"ID" => 3,
		"Nev" => "Gold",
		"Szin" => "gold",
		"Ara" => 400,
		"Telefonszam" => "06-90-643-363",
		"Penz" => 1000000,
		"Kokain" => 200,
		"Heroin" => 200,
		"Marihuana" => 100,
		"Material" => 2000,
		"Kamat" => 0.005,
		"Hazszef" => 5,
		"FegyverSlot" => 1,
		"Ido" => 7,
		"Pont" => null,
		),
	"4" => Array(
		"ID" => 4,
		"Nev" => "Platina",
		"Szin" => "cyan",
		"Ara" => 800,
		"Telefonszam" => "06-90-888-309",
		"Penz" => 2500000,
		"Kokain" => 300,
		"Heroin" => 300,
		"Marihuana" => 200,
		"Material" => 5000,
		"Kamat" => 0.015,
		"Hazszef" => 10,
		"FegyverSlot" => 2,
		"Ido" => 14,
		"Pont" => null,
		),
	"5" => Array(
		"ID" => 5,
		"Nev" => "Power",
		"Szin" => "#FF5555",
		"Ara" => 1600,
		"Telefonszam" => "06-90-888-409",
		"Penz" => 6000000,
		"Kokain" => 750,
		"Heroin" => 750,
		"Marihuana" => 400,
		"Material" => 12500,
		"Kamat" => 0.02,
		"Hazszef" => 25,
		"FegyverSlot" => 5,
		"Ido" => 28,
		"Pont" => 1,
		),
);

	$config["Frakciok"] = Array(
		"1" => "Rendőrség",
		"2" => "FBI",
		"3" => "Ballas",
		"4" => "OMSZ",
		"5" => "Cosa Nostra",
		"6" => "Yakuza",
		"7" => "Önkormányzat",
		"8" => "Los Aztecas",
		"9" => "Riporter",
		"10" => "Taxi Zrt.",
		"11" => "Sons of Anarchy",
		"12" => "Tűzoltóság",
		"13" => "Katonaság",
		"14" => "SFPD - Megszünt", // Katonaság volt
		"15" => "SF Rendorség - Megszünt",
		"16" => "Oktató",
		"17" => "GSF",
		"18" => "SF Taxi - Megszünt",
		"19" => "SF Mento - Megszünt",
		"20" => "Sheriff Department",
		"21" => "Turkey Maffia",
	);
/**/
	$config["FrakcioSzinek"] = Array(
		"3" => "#ED3491", // Ballas
		"5" => "white", // La Cosa Nostra
		"6" => "#604B4F", // Yakuza
		"8"	=> "lightblue",	// Aztec
		"11" => "#4169E1", // Sons of Anarchy
	  /*"11" => "yellow	", */ // Vagos
		"17" => "green", // GSF
		"21" => "#EE1212", // Turkey
	);

	$config["FrakcioLimit"] = Array(
		"1" => 25,  // SCPD 1
		"2" => 15,  // FBI 2
		"3" => 15,  // Ballas 3
		"4" => 20,  // Mentő 4
		"5" => 20,  // LCN 5
		"6" => 20,  // Yakuza 6
		"7" => 15,  // Önkormányzat 7
		"8" => 15,  // Aztecas 8
		"9" => 20,  // Riporter 9
		"10" => 20, // Taxi 10
		"11" => 15, // Sons of Anarchy 11
		"12" => 20, // Tűzoltóság - 12
		"13" => 0,  // Katonaság 13
		"14" => 0, // SFPD 14
		"15" => 0,  // - 15
		"16" => 20, // Oktató 16
		"17" => 15, // GSF 17
		"18" => 0,  // - 18
		"19" => 0,  // - 19 
		"20" => 25, // NAV 20
		"21" => 20, // Turkey 21
	);

	$config["NemLetezoFrakciok"] = Array(15, 18, 19);
	$config["Rendvedelem"] = Array(1, 2, 14, 13, 20);
	$config["Kozszolgalati"] = Array(4, 7, 9, 10, 12, 16);
	$config["Illegalisok"] = Array(3, 5, 6, 8, 11, 17, 21);

?>
