<?php

class controller{
    
	public function seo_view($id_klienta){
								$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            
            $klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);

            if($id_klienta && !$klient) $this -> load -> error('no-access');

			$this -> load -> view('seo_status', array('klient' => $klient, 'uzytkownik' => $uzytkownik));
		}
	public function seo_kat($id_klienta){
			$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);
            $pozycjonerzy = $this -> load -> model('pozycjonerzy');
			$pozycjoner = $pozycjonerzy -> jeden($klient['id_pozycjonera']);
			$partnerzy = $this -> load -> model('partnerzy');
			$partner = $partnerzy -> jeden($klient['id_partnera']);
            if($id_klienta && !$klient) $this -> load -> error('no-access');
			$this -> load -> view('seo_kat', array('frazy' => $frazy, 'klient' => $klient, 'partner' => $partner, 'pozycjoner' => $pozycjoner, 'uzytkownik' => $uzytkownik));
		}
	public function form($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);

            if($id_klienta && !$klient) $this -> load -> error('no-access');
		
    		$this -> load -> view('seo_form', array('klient' => $klient,
    		                                                 'uzytkownik' => $uzytkownik));

		}
	public function zapisz($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');
            $seo = $this -> load -> model('seo');

            if($id_klienta && !$klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            
            
            $optymalizacja = $this -> input -> post('optymalizacja');
            $google_ana = $this -> input -> post('google_ana');
            $web_tool = $this -> input -> post('web_tool');
            $poprawa = $this -> input -> post('poprawa');
			$niebonie = $this -> input -> post('niebonie');
            $cms_adres = $this -> input -> post('cms_adres');
            $ftp_server = $this -> input -> post('ftp_server');
            $seo_inne = $this -> input -> post('seo_inne');    						
    		$cms_login = $this -> input -> post('cms_login');             
            $cms_haslo = $this -> input -> post('cms_haslo');            
            $ftp_login = $this -> input -> post('ftp_login');            
            $ftp_haslo = $this -> input -> post('ftp_haslo');
			$dostepy = $this -> input -> post('dostepy');
			$teksty = $this -> input -> post('teksty');
			$katalogi = $this -> input -> post('katalogi');
			$swl = $this -> input -> post('SWL');
            $zaplecza = $this -> input -> post('zaplecza');
			$mapkagoogle = $this -> input -> post('google_mapa');
			$katdataod = $this -> input -> post('data_katalogi_start');
			$katdatado = $this -> input -> post('data_katalogi_end');
			$swldataod = $this -> input -> post('data_SWL_start');
			$swldatado = $this -> input -> post('data_SWL_end');
			$zapdataod = $this -> input -> post('data_zaplecza');
			$zapfala = $this -> input -> post('zaplecza_fala');
			$cslink = $this -> input -> post('cs_link');
			$csdata = $this -> input -> post('cs_data');
			$optdata = $this -> input -> post('opt_data');
			$dostepy_cms = $this -> input -> post('dostepy_cms');
			$opt_meta_data = $this -> input -> post('opt_meta_data');
			$opt_meta = $this -> input -> post('opt_meta');
			$host_zly = $this -> input -> post('host_zly');
			$strona_zla = $this -> input -> post('strona_zla');
			$strona_popr = $this -> input -> post('strona_popr');		
			$reczna_filtr = $this -> input -> post('reczna_filtr');
			$seo -> seo_zapisz($optymalizacja, $google_ana, $web_tool, $poprawa, $niebonie, $cms_adres, $ftp_server, $seo_inne, $cms_login, $cms_haslo, $ftp_login, $ftp_haslo, $dostepy, $teksty, $id_klienta, $katalogi, $swl, $zaplecza, $mapkagoogle, $katdataod, $katdatado, $swldataod, $swldatado, $zapdataod, $zapfala, $cslink, $csdata, $optdata, $dostepy_cms, $opt_meta_data, $opt_meta, $host_zly, $strona_zla, $strona_popr, $reczna_filtr);    
            
            $this -> session -> set('info', 1);
            
            url::redirect($id_klienta ? 'seo/seo_view/'.$id_klienta : 'klienci/lista');
	}
	public function dodaj_tresci($id_klienta){
		    $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');
            $_frazy = $this -> load -> model('frazy');
    		$frazy = $_frazy -> wszystkie($id_klienta);
		// FUNKCJE POCZĄTEk ============================================================================

		function randomGen($min, $max, $quantity, $plikklienta) {
		    $numbers = range($min, $max);
		    if ($plikklienta == NULL) { } 
		    else {
		    		$numbers = array_diff($numbers, $plikklienta);	
		   	}
		    if (sizeof($numbers) < $quantity) {
				echo "Za dużo tekstów, za mało wolnych zaplecz<br />";
				echo "Tekstów jest ".$quantity." a wolnych zapleczy tylko: ".sizeof($numbers)."<br />";
				echo "Zmniejsz liczbę dodawanych tekstów lub dokup domen :)";
				die;
			}
			shuffle($numbers);
		    return array_slice($numbers, 0, $quantity);
		}
		// KONIEC FUNKCJI ===============================================================================
		$tresciraw = $this -> input -> post('tresciraw');
		$kategoria = $this -> input -> post('kategoria');
		$adres = $this -> input -> post('adres');
		$nazwa_klienta = $this -> input -> post('nazwa_klienta');
		$kod_pocztowy = $this -> input -> post('kod_pocztowy');
		$miasto = $this -> input -> post('miasto');
		$telefon = $this -> input -> post('telefon');
		$url = $this -> input -> post('url');
		$state = 'Województwo';
		foreach ($frazy as $fraza) { if(isset($_POST[$fraza['id_frazy']]) && $_POST[$fraza['id_frazy']] == 'Yes') { $slowa_kluczowe[] = array($fraza['nazwa'], $fraza['fraza_link']);   }}   	
		$mixy= $this -> input -> post('mixy');






		$frazy_mix= array();
		$frazy_mix[] = array("www","http://".$url);
		$frazy_mix[] = array("strona","http://".$url);
		$frazy_mix[] = array("strona www","http://".$url);
		$frazy_mix[] = array("strona internetowa","http://".$url);
		$frazy_mix[] = array("tu","http://".$url);
		$frazy_mix[] = array("kliknij tutaj","http://".$url);
		$frazy_mix[] = array("stronie","http://".$url);
		$frazy_mix[] = array($url,"http://".$url);
		$frazy_mix[] = array($nazwa_klienta,"http://".$url);
		$frazy_mix[] = array("kontakt","http://".$url);
		$frazy_mix[] = array("sprawdz","http://".$url);
		$frazy_mix[] = array("zobacz","http://".$url);
		$frazy_mix[] = array("więcej","http://".$url);
		$frazy_mix[] = array("czytaj","http://".$url);
		$frazy_mix[] = array("kliknij","http://".$url);
		$frazy_mix[] = array("przejdz","http://".$url);
		$frazy_mix[] = array("on-line","http://".$url);
		$frazy_mix[] = array("odwiedz","http://".$url);
		$frazy_mix[] = array("zajrzyj","http://".$url);
		$frazy_mix[] = array("witryna","http://".$url);
		
		     if (strpos($kod_pocztowy, '0') === 0) { $state = 'Mazowieckie'; }
		else if (strpos($kod_pocztowy, '1') === 0) { $state = 'Warmińsko-Mazurskie'; }
		else if (strpos($kod_pocztowy, '2') === 0) { $state = 'Lubelskie'; }
		else if (strpos($kod_pocztowy, '3') === 0) { $state = 'Małoposkie'; }
		else if (strpos($kod_pocztowy, '4') === 0) { $state = 'Śląskie'; }
		else if (strpos($kod_pocztowy, '5') === 0) { $state = 'Dolnośląskie'; }
		else if (strpos($kod_pocztowy, '6') === 0) { $state = 'Wielkopolskie'; }
		else if (strpos($kod_pocztowy, '7') === 0) { $state = 'Zachodniopomorskie';	}
		else if (strpos($kod_pocztowy, '8') === 0) { $state = 'Pomorskie'; }
		else if (strpos($kod_pocztowy, '9') === 0) { $state = 'Łódźkie'; }
		
		if ($tresciraw == NULL) { $this -> session -> set('error', "Nie wkleiłeś tekstów. Za karę usunę Ci to co wkleiłeś."); url::redirect($id_klienta ? 'seo/seo_kat/'.$id_klienta : 'klienci/lista'); }
		if ($kategoria == "0") { $this -> session -> set('error', "Nie wybrałeś kategorii. Za karę usunę Ci to co wkleiłeś."); url::redirect($id_klienta ? 'seo/seo_kat/'.$id_klienta : 'klienci/lista'); }
		foreach ($frazy as $fraza) { if (($fraza['fraza_link'] == "") || ($fraza['fraza_link'] == NULL)) { $this -> session -> set('error', "Frazy nie mają przypisanych URLi."); url::redirect($id_klienta ? 'seo/seo_kat/'.$id_klienta : 'klienci/lista'); } }
		//if ($slowa_kluczowe < 1) { $this -> session -> set('error', "Błąd w pobieraniu fraz, skontaktuj się z Jackiem."); url::redirect($id_klienta ? 'seo/seo_kat/'.$id_klienta : 'klienci/lista'); }

		

		$text = explode("#", $tresciraw);
		$iloscwpisow = sizeof($text);
		$iloscfraz = sizeof($slowa_kluczowe);
		$ilemix = 0;
		$ilemoney = 0;
		if ($iloscfraz < 1) {
			$ilemix = $iloscwpisow;
		}else {
			if ($iloscfraz < $iloscwpisow) {$ilemix = floor($iloscwpisow/4);}
			else if ($iloscfraz == $iloscwpisow) { $ilemix = floor($iloscwpisow/3); }
			else { $ilemix = floor($iloscwpisow/4); }
			if ($_POST['mixy'] == 'Yes') { $ilemoney = $iloscwpisow-$ilemix; }
			else { $ilemix = 0; $ilemoney = $iloscwpisow; }
		}
		if (sizeof($slowa_kluczowe) < 1) {
		while ( sizeof($slowa_kluczowe) < $ilemoney) { $slowa_kluczowe = array_merge($slowa_kluczowe, $slowa_kluczowe); }
		shuffle(shuffle(shuffle($slowa_kluczowe)));
		$slowa_kluczowe = array_slice($slowa_kluczowe, 0, $ilemoney);
		}
		shuffle(shuffle($frazy_mix));

		$frazy_mix = array_slice($frazy_mix, 0, $ilemix);
		if (is_null($slowa_kluczowe)) {
		$slowa_kluczowe = $frazy_mix;			
		} else
		{ $slowa_kluczowe = array_merge($slowa_kluczowe, $frazy_mix); }
		while ( sizeof($slowa_kluczowe) < $iloscwpisow) { $slowa_kluczowe = array_merge($slowa_kluczowe, $slowa_kluczowe); }
		if ($iloscwpisow < sizeof($slowa_kluczowe)) { $slowa_kluczowe = array_slice($slowa_kluczowe, 0, $iloscwpisow); }
		
		shuffle(shuffle($slowa_kluczowe));
		$plikklienta = unserialize(file_get_contents('/LogomAlogo15432/'.$id_klienta));
		$plikklientavp = unserialize(file_get_contents('/LogomAlogo15432/main/'.$id_klienta));

		$domiha = array(array("alfaiomegajuz.com.pl", "9084b0a9e4a14bdbdd994d15768f89bd68be28f3"),
				array("algebrakredek.com.pl", "b1afb6bf0b517e6e11578970a27b4bc90a98ca4a"),
				array("alkatrazy.com.pl", "5af1e2916a018efd895bf6598f258a529d69f049"),
				array("altruizmstosowany.com.pl", "55c207289aab1d6bbdb0b4ca0617d16f238cb2b0"),
				array("aszkupraw.com.pl", "16e1379f2870fcabd59203ab7e162719c302a8a5"),
				array("bulbuga.com.pl", "75c615470d8144cd120e5a9b936b0dcc99ca2a78"),
				array("elewacjaogrodowa.com.pl", "9a103801cb5cef3af317808b02aa781e67ba6564"),
				array("elkubra.com.pl", "2193bca0dfc366607007300c015c6178d3ed9c34"),
				array("glowackibiz.com.pl", "541e96c77d84185d9a2cb562fe11994d9f4674f5"),
				array("interfejsydwa.com.pl", "41276337c2c27b04911f08e8308d5f65e3c408e2"),
				array("juzukra.com.pl", "c1bf2622d72f7af66490d79714d2cd74e0807df6"),
				array("kilofy.com.pl", "75081464a1ad5f4e09bc9a347377a35e87a8f612"),
				array("lastafarianie.com.pl", "89ce2aa2d5210e9227163f2b5e1b4b00610c0f32"),
				array("lipazmiodem.com.pl", "f49c12b86b2a739075d101ba6e3f8dc09c424587"),
				array("lodolamaczki.com.pl", "963d72932c60f16a0cb111778e26ac8974fb74b1"),
				array("olerwan.com.pl", "d9eb75898b10b4c58bbdda3f5ebdf6e221c8d422"),
				array("smartfonastanie.com.pl", "5207c75008bf898c4746300af72e202859739f95"),
				array("statystykamachoniu.com.pl", "ee351b5c165e4cd88ff437bf13549be8876f7cb7"),
				array("szczebrzeszynispolka.com.pl", "c3d3e73fb4b5573ac5b9484676d1b6ca45ce7822"),
				array("ufajacymi.com.pl", "e540a2d97bd822bf145eb4bb6ad5cf36a699fd30"),
				array("elfyusze.com.pl", "71c97efdb9a32dd5cab662aef45bc15ffae726bb"),
				array("zdechlekwiaty.com.pl", "2c916388a406dc14348f2e1b090f94d2ced62cf0"),
				array("bialekropki.com.pl", "7dc7d40e535bdfc6663a18b9d642ff3aa293d7bc"),
				array("zlotegacie.com.pl", "8913c6c0c0da40db4a5add3472abe4b13b674095"),
				array("czulypunkt.com.pl", "55e5d11b8a4a5248c633e84740f2e72fccd8670a"),
				array("bialyzubr.com.pl", "e593712a8a76ab86257917d5e1f700721abcf726"),
				array("zosiazla.com.pl", "bae17fad6b576fc18b31f9b1070d2b17c34ea1e4"),
				array("bialytwarog.com.pl", "243cd4481e38ac8c622403ae6c052ea2ffeb76e6"),
				array("zoltyser.com.pl", "dd0930ebd8c08740267cd6085f4a54e1876c8f9a"),
				array("sokzgumijagod.com.pl", "4b88c753859efb848c0db48aaea7b134a4e45a22"),
				array("malegile.com.pl", "9fd4837edb46b7a9e6e67d192f6ba4cbff3e7fa2"),
				array("czarnekruki.com.pl", "3ddbc1e69fa16110e60e0f4d1cc07987296c32ab"),
				array("szczwanylisek.com.pl", "98625e727b9c23da7364252c5ce5028fa56b18dd"),
				array("bialymis.com.pl", "3247beaa980e7d244685b82d93195005c1d47b34"),
				array("rowerowepysiaczki.com.pl", "c5c02b860968a1a8aec4188393a60daeed9a07ad"),
				array("misienadeskorolkach.com.pl", "1166342090ec52ff0d9fd784dfab01a533a41901"),
				array("albedoziemi.com.pl", "cf045ae1d4b969ed8f8dab008b97c423b698fa4a"),
				array("blackandberry.com.pl", "354fa303cc36230347f7b866a7c36f0d1c40e1d2"),
				array("alfaromek.com.pl", "1f262bffd86633f2583effdcf8db9f08d5e17c11"),
				array("internety.com.pl", "ab5551a31d8bc4827ecc1cc772db72c14174c481"),
				array("sitemap.com.pl", "c9b184d119d1da27b7fd09a255bb44aaa28d666b"),
				array("rajdowe.com.pl", "719236aae7cfe8a38526d37f3df3f57f9ce4fcc4"),
				array("kurcze.com.pl", "4cdea7c2538e824740e807961195e61404402fe8"),
				array("koleje.com.pl", "3c8ecd19134f126c5e9f0091ec09abfba156e3f2"),
				array("bronie.com.pl", "dcc2c3cd2b99b329937129fe6adc34892485826f"),
				array("widelec.com.pl", "011ec1ff931bb19a4bf30738282dd2c01f561f04"),
				array("zombi.com.pl", "bf2c2a53d0c898feaf83cc4e3451607409bb77c1"),
				array("doki.com.pl", "019618a7288d07ecf262f1e4e9148931a62d7273"),
				array("dziadkowi.com.pl", "82c4e2e650883a329851452f40709cecd9d3a39a"),
				array("pomarancz.com.pl", "f2b4a0f9cbc3c7a737a17df2c80d441c19fdaa56"),
				array("wielkiszu.com.pl", "3b879202b85a59c171899b763288f006790c61bc"),
				array("zielonaczapka.com.pl", "ce0d56cc3393a2fc757acbe8b626c254025b8fd4"),
				array("zielonyszalik.com.pl", "89086cb37cec24c7060db314f4aebe2588b103be"),
				array("zielonebuty.com.pl", "7deb83220c058d183960f7a0fb8b8438a5341152"),
				array("lewanoga.com.pl", "d3ec3cbcc653c7a34891bca053169d2c1abb4158"),
				array("prawanoga.com.pl", "3c479da6f6a8a8a4a06d15f7b2a374666dfbff2e"),
				array("myszkomputerowa.com.pl", "9799b54373df01f7b6897d6f67ee252c7fa13977"),
				array("kabeldomyszy.com.pl", "49df2e5866872a523ccbd43fc7ea023d4033a2e4"),
				array("kabeldomonitora.com.pl", "4c02b2c3394a3203677ce05aafa490bd6145058c"),
				array("zasmarkanechusteczki.com.pl", "f1529e725dabbda8721ad82da29a4dce4d981038"),
				array("ramyokienne.com.pl", "865af2690012a1220ea717f9a4d667fb3e3f5d78"),
				array("internetwwiaderku.com.pl", "1aa9556d2c418c8d23eabcc2ffcd2b8f3500bf17"),
				array("gitaryiflety.com.pl", "64acf0aac2d5dd2a4a72e6b9307d23ecec4d7fb5"),
				array("informatykzblizna.com.pl", "38205ddad14d230039697efdc11b3529ce5a1214"),
				array("kontemplacja.com.pl", "726f01058a0e5ca347f93b7395db07632f915173"),
				array("cyganiwpiwnicy.com.pl", "1903b692ce62bedf6b21b12d184f756f3c5ac139"),
				array("seohost.com.pl", "efa5ee1f4967c0993c482c2797f888c2408464c4"),
				array("maksistranci.com.pl", "1cc6c498bbbade10a561298dfb6cebb294f186ad"),
				array("amelinium.com.pl", "69f274dd43d9f32721560a402e263e6f1f71a78f"),
				array("poselosel.com.pl", "14d73b7ff216c3cbe2718b3e532a952ae2a0797e"),
				array("pesel.com.pl", "3ea7cfb2b6a8344fba29aecf454e7057f0cc637f"),
				array("krzywenogi.com.pl", "4b77d8069f83d06d4ea0a9ffed003c501d1f6c0f"),
				array("panroman.com.pl", "b4efa2fab7f3bf9c2d94a9d7ff13826b007e53d5"),
				array("wpisznazwedomeny.com.pl", "e23f6cc24c23bce05ba4da58999eaec51e0b9ffa"),
				array("kampaniamajowa.com.pl", "13180aad57c610c28f8cc8c35c4fbf549cb9ec86"),
				array("zpapieru.com.pl", "777feffae40be0dd34e76e644ff5ac7cb838f3ac"),
				array("robotyilasery.com.pl", "a988df3e4019d84c6e1fb75bc7c7f23fb76f26b0"),
				array("leniwce.com.pl", "3bbf8c01294ee54724a55371bc0e314bf424af89"),
				array("sportowetraktory.com.pl", "20fb952d068f55e300b05ed382334eb6f400d1c8"),
				array("katalog-logo.com.pl", "604470a5f10db1f7eac4318da756816be23c31a3"));

		$iloscdomen = sizeof($domiha);
		if($iloscwpisow > 3){ if (mt_rand(1,30) % 10) {
		if ($iloscwpisow > 1) {$zaplecza = randomGen(0,$iloscdomen-1,$iloscwpisow-1,$plikklienta);}
		$zapleczavp = randomGen(0,$iloscdomen,1,$plikklientavp);
		} else {
		if ($iloscwpisow > 3) {$zaplecza = randomGen(0,$iloscdomen-1,$iloscwpisow-3,$plikklienta);}
		$zapleczavp = randomGen(0,$iloscdomen,3,$plikklientavp);
		}
		}else {
		if ($iloscwpisow > 1) {$zaplecza = randomGen(0,$iloscdomen-1,$iloscwpisow-1,$plikklienta);}
		$zapleczavp = randomGen(0,$iloscdomen,1,$plikklientavp);
		}		

		$ftp_username = "privkat";
		$ftp_userpass = "vrdgw1990";
		$ftp_server = "s7.seo-linuxpl.com";
		$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server"); if (@ftp_login($ftp_conn, $ftp_username, $ftp_userpass)) { echo "Connection established. <br />"; } else { echo "Couldn't establish a connection."; die; }

		
		$notka=array();
		$notkavp=array();

	foreach ($zaplecza as $zaplecze) {
		
		$nowywpis[0] = "<?php\n";
		$nowywpis[1] = '$url="'.$slowa_kluczowe[0][1]."\";\n";
		$nowywpis[2] = '$key="'.$slowa_kluczowe[0][0]."\";\n";
		$nowywpis[3] = '$opis="'.$text[0]."\";\n";
		$nowywpis[4] = '$nazwa="'.$nazwa_klienta."\";\n";
		$nowywpis[5] = '$adres="'.$adres."\";\n";
		$nowywpis[6] = '$zip="'.$kod_pocztowy."\";\n";
		$nowywpis[7] = '$miasto="'.$miasto."\";\n";
		$nowywpis[8] = '$state="'.$state."\";\n";
		$nowywpis[9] = '$tel="+48'.$telefon."\";\n";
		$nowywpis[10] = '?>';
		
		file_put_contents('tempfila', $nowywpis);
		ftp_chdir($ftp_conn, "domains/".$domiha[$zaplecze][0]."/public_html");
		$local_file = "local";
		$server_file = "index.php";
		ftp_get($ftp_conn, $local_file, $server_file, FTP_ASCII);
		ftp_mkdir($ftp_conn, $kategoria);
		ftp_put($ftp_conn, $kategoria."/".$server_file, $local_file, FTP_ASCII);
		ftp_chdir($ftp_conn, $domiha[$zaplecze][1]);
		ftp_mkdir($ftp_conn, $kategoria);
		ftp_put($ftp_conn, $kategoria."/".$id_klienta, 'tempfila', FTP_ASCII);
		$notka[] = "Dodano w ".$kategoria." na: <a href=\"http://".$domiha[$zaplecze][0]."\" rel=\"external\">".$domiha[$zaplecze][0]."</a> ".$nowywpis[1]." ".$nowywpis[2];
		ftp_chdir($ftp_conn, "../");
		ftp_chdir($ftp_conn, "../");
		ftp_chdir($ftp_conn, "../");
		ftp_chdir($ftp_conn, "../");
		ftp_chdir($ftp_conn, "../");
		ftp_chdir($ftp_conn, "../");
		unset($text[0]);
		unset($slowa_kluczowe[0]);
		$text = array_values($text);
		$slowa_kluczowe = array_values($slowa_kluczowe);
	}

	foreach ($zapleczavp as $zapleczevp) {
		$text[0] = trim($text[0]);
		$nowywpis[0] = "<?php\n";
		$nowywpis[1] = '$url="'.$slowa_kluczowe[0][1]."\";\n";
		$nowywpis[2] = '$key="'.$slowa_kluczowe[0][0]."\";\n";
		$nowywpis[3] = '$opis="'.$text[0]."\";\n";
		$nowywpis[4] = '$nazwa="'.$nazwa_klienta."\";\n";
		$nowywpis[5] = '$adres="'.$adres."\";\n";
		$nowywpis[6] = '$zip="'.$kod_pocztowy."\";\n";
		$nowywpis[7] = '$miasto="'.$miasto."\";\n";
		$nowywpis[8] = '$state="'.$state."\";\n";
		$nowywpis[9] = '$tel="+48'.$telefon."\";\n";
		$nowywpis[10] = '?>';
		file_put_contents('tempfila2', $nowywpis);
		ftp_chdir($ftp_conn, "domains/".$domiha[$zapleczevp][0]."/public_html");
		ftp_chdir($ftp_conn, $domiha[$zapleczevp][1]);
		ftp_put($ftp_conn, "AAA/".$id_klienta, "tempfila2", FTP_ASCII);
		$notkavp[] =  "Dodano w głowej na: <a href=\"http://".$domiha[$zapleczevp][0]."\" rel=\"external\">".$domiha[$zapleczevp][0]."</a> ".$nowywpis[1]." ".$nowywpis[2];
		ftp_chdir($ftp_conn, "../");
		ftp_chdir($ftp_conn, "../");
		ftp_chdir($ftp_conn, "../");
		ftp_chdir($ftp_conn, "../");
		ftp_chdir($ftp_conn, "../");
		ftp_chdir($ftp_conn, "../");
		unset($text[0]);
		unset($slowa_kluczowe[0]);
		$text = array_values($text);
		$slowa_kluczowe = array_values($slowa_kluczowe);
	}
ftp_close($ftp_conn);
		
if($iloscwpisow > 1){
	if ($plikklienta == NULL) { $plikklienta = $zaplecza; }
	else { $plikklienta = array_merge($plikklienta, $zaplecza); }
}
if ($plikklientavp == NULL) { $plikklientavp = $zapleczavp; }
else { $plikklientavp = array_merge($plikklientavp, $zapleczavp); }
file_put_contents('/LogomAlogo15432/'.$id_klienta, serialize($plikklienta));
file_put_contents('/LogomAlogo15432/main/'.$id_klienta, serialize($plikklientavp));
unlink('tempfila');
unlink("tempfila2");
unlink("local");
$notatka = implode(',', array_merge($notka, $notkavp));
$data_utworzenia = date("Y-m-d");
$klienci -> zapisz_notatke($data_utworzenia, $id_klienta, $notatka);
	$this -> session -> set('info', 'Stało się :)');
    url::redirect('seo/seo_kat/'.$id_klienta);
    }
}
?>