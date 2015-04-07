<?php

class controller{

	// klienci
	public function index(){
		url::redirect('klienci/na-dzis');
	}


	public function breakdown($dateDay, $dateCalendar, $page = 1) {

		if(!isset($_SESSION['breakdown_filter_count'])) {
			$_SESSION['breakdown_filter_count'] = 5;
		}
		 
		if(!isset($_SESSION['breakdown_filter_payment'])) {
			$_SESSION['breakdown_filter_payment'] = 0;
		}
		 
		if(!isset($_SESSION['breakdown_filter_lump_sum'])) {
			$_SESSION['breakdown_filter_lump_sum'] = 0;
		}
		 
		if(!isset($_SESSION['breakdown_filter_partner'])) {
			$_SESSION['breakdown_filter_partner'] = 0;
		}
		 
		if(!isset($_SESSION['breakdown_filter_problem'])) {
			$_SESSION['breakdown_filter_partner'] = 0;
		}
		 
		if(!isset($_SESSION['breakdown_filter_gotlink'])) {
			$_SESSION['breakdown_filter_partner'] = 0;
		}
		 
		if(!isset($_SESSION['breakdown_filter_vip'])) {
			$_SESSION['breakdown_filter_partner'] = 0;
		}

		
		if(!isset($_SESSION['breakdown_order_by'])) {
			$_SESSION['breakdown_order_by'] = 0;
		}

		if(!isset($_SESSION['breakdown_order'])) {
			$_SESSION['breakdown_order'] = 0;
		}
		
		

		if(isset($_POST['breakdown_clear_filters'])) {
			$_SESSION['breakdown_filter_count'] = 5;
			$_SESSION['breakdown_filter_payment'] = 0;
			$_SESSION['breakdown_filter_lump_sum'] = 0;
			$_SESSION['breakdown_filter_partner'] = 0;
			$_SESSION['breakdown_filter_problem'] = 0;
			$_SESSION['breakdown_filter_gotlink'] = 0;
			$_SESSION['breakdown_filter_vip'] = 0;
			
			$_SESSION['breakdown_order_by'] = 0;
			$_SESSION['breakdown_order'] = 0;
		} else {
			if(isset($_POST['breakdown_filter_count'])) {
				$_SESSION['breakdown_filter_count'] = $_POST['breakdown_filter_count'];
			}

			if(isset($_POST['breakdown_filter_payment'])) {
				$_SESSION['breakdown_filter_payment'] = $_POST['breakdown_filter_payment'];
			}

			if(isset($_POST['breakdown_filter_lump_sum'])) {
				$_SESSION['breakdown_filter_lump_sum'] = $_POST['breakdown_filter_lump_sum'];
			}

			if(isset($_POST['breakdown_filter_partner'])) {
				$_SESSION['breakdown_filter_partner'] = $_POST['breakdown_filter_partner'];
			}

			if(isset($_POST['breakdown_filter_problem'])) {
				$_SESSION['breakdown_filter_problem'] = $_POST['breakdown_filter_problem'];
			}

			if(isset($_POST['breakdown_filter_gotlink'])) {
				$_SESSION['breakdown_filter_gotlink'] = $_POST['breakdown_filter_gotlink'];
			}

			if(isset($_POST['breakdown_filter_vip'])) {
				$_SESSION['breakdown_filter_vip'] = $_POST['breakdown_filter_vip'];
			}

			if(isset($_POST['breakdown_order_by'])) {
				$_SESSION['breakdown_order_by'] = $_POST['breakdown_order_by'];
			}

			if(isset($_POST['breakdown_order'])) {
				$_SESSION['breakdown_order'] = $_POST['breakdown_order'];
			}
		}
		 
		$user = $this->load->model('uzytkownik') -> zalogowany();

		$_clients = $this->load->model('klienci');
		 
		$limit = $_SESSION['breakdown_filter_count'];
		$from = ($page-1) * $limit;

		$clients = $_clients->breakdown($user, $dateDay, $dateCalendar, $from, $limit);
		$clientsTotals = $_clients->breakdown_totals($limit, $user);
		$totalPages = $clientsTotals['pages'];
		$clientsCount = $clientsTotals['clients'];
		 
		$partners = $this->load->model('partnerzy');
		$partnersOptionHTML = $partners->getOptionHTML();
		 
		$this->load->view(
				'breakdown',
				array(
						'dateDay' => $dateDay,
						'dateCalendar' => $dateCalendar,
						'dayBefore' => date('Y-m-d', strtotime('-1 day', strtotime($dateCalendar))),
						'dayAfter' => date('Y-m-d', strtotime('+1 day', strtotime($dateCalendar))),
						'weekBefore' => date('Y-m-d', strtotime('-7 day', strtotime($dateCalendar))),
						'weekAfter' => date('Y-m-d', strtotime('+7 day', strtotime($dateCalendar))),
						'monthBefore' => date('Y-m-d', strtotime('-30 day', strtotime($dateCalendar))),
						'monthAfter' => date('Y-m-d', strtotime('+30 day', strtotime($dateCalendar))),
						'clients' => $clients,
						'clientsCount' => $clientsCount,
						'user' => $user,
						'page' => $page,
						'totalPages' => $totalPages,
						'partnersOptionHTML' => $partnersOptionHTML,
				)
		);

		//         	echo '<pre>';
		//         	var_dump($klienci);
		//         	echo '</pre>';

	}


	public function lista($strona = 1){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		// modele
		$_klienci = $this -> load -> model('klienci');

		$przeladuj = 0;

		// zmienne
		if(isset($_REQUEST['dzien'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_dzien',
			'value' => $_REQUEST['dzien'],
			'expire' => '+1 months'
					));
		}

		if(isset($_REQUEST['etap'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_etap',
			'value' => $_REQUEST['etap'],
			'expire' => '+1 months'
					));
		}

		if(isset($_REQUEST['rozliczenia'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_rozliczenia',
			'value' => $_REQUEST['rozliczenia'],
			'expire' => '+1 months'
					));
		}

		if(isset($_REQUEST['partner'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_partner',
			'value' => $_REQUEST['partner'],
			'expire' => '+1 months'
					));
		}
			
		if(isset($_REQUEST['telemarketer'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_telemarketer',
			'value' => $_REQUEST['telemarketer'],
			'expire' => '+1 months'
					));
		}
			
		if(isset($_REQUEST['pozycjoner'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_pozycjoner',
			'value' => $_REQUEST['pozycjoner'],
			'expire' => '+1 months'
					));
		}

		if(isset($_REQUEST['sortowanie'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_sortowanie',
			'value' => $_REQUEST['sortowanie'],
			'expire' => '+1 months'
					));
		}
			
		if(isset($_REQUEST['opt'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_opt',
			'value' => $_REQUEST['opt'],
			'expire' => '+1 months'
					));
		}

		if(isset($_REQUEST['optmeta'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_optmeta',
			'value' => $_REQUEST['optmeta'],
			'expire' => '+1 months'
					));
		}
			
		if(isset($_REQUEST['nbn'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_nbn',
			'value' => $_REQUEST['nbn'],
			'expire' => '+1 months'
					));
		}
			
		if(isset($_REQUEST['gl'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_gl',
			'value' => $_REQUEST['gl'],
			'expire' => '+1 months'
					));
		}
		if(isset($_REQUEST['seo'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_seo',
			'value' => $_REQUEST['seo'],
			'expire' => '+1 months'
					));
		}
			
		if(isset($_REQUEST['dst'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_dst',
			'value' => $_REQUEST['dst'],
			'expire' => '+1 months'
					));
		}
			
		if(isset($_REQUEST['txt'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_txt',
			'value' => $_REQUEST['txt'],
			'expire' => '+1 months'
					));
		}
			
		if(isset($_REQUEST['vip'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_vip',
			'value' => $_REQUEST['vip'],
			'expire' => '+1 months'
					));
		}
			
		if(isset($_REQUEST['rycz'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_rycz',
			'value' => $_REQUEST['rycz'],
			'expire' => '+1 months'
					));
		}

		if(isset($_REQUEST['kierunek'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_kierunek',
			'value' => $_REQUEST['kierunek'],
			'expire' => '+1 months'
					));
		}

		if(isset($_REQUEST['limit'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_limit',
			'value' => $_REQUEST['limit'],
			'expire' => '+1 months'
					));
		}
		
		if(isset($_REQUEST['kategoria'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_kategoria',
			'value' => $_REQUEST['kategoria'],
			'expire' => '+1 months'
					));
		}
		
		if(isset($_REQUEST['katalogi'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_kat',
			'value' => $_REQUEST['katalogi'],
			'expire' => '+1 months'
					));
		}
		
		if(isset($_REQUEST['swl'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_swl',
			'value' => $_REQUEST['swl'],
			'expire' => '+1 months'
					));
		}
		
		if(isset($_REQUEST['zaplecza'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_zap',
			'value' => $_REQUEST['zaplecza'],
			'expire' => '+1 months'
					));
		}
		if(isset($_REQUEST['reczna_filtr'])){
			$przeladuj = 1;
			cookie::set(array(
			'name' => 'filtr_klienci_ban',
			'value' => $_REQUEST['reczna_filtr'],
			'expire' => '+1 months'
					));
		}

		if($przeladuj) url::redirect('klienci/lista');

		$suma = $_klienci -> lista($uzytkownik);

		$limit = $this -> input -> cookie('filtr_klienci_limit');
		$paginacja = new pagination($suma, $strona, $limit ? $limit : LICZBA_KLIENTOW_NA_STRONE);

		$klienci = $_klienci -> lista($uzytkownik, $paginacja -> limit, $paginacja -> min);

		$this -> load -> view('klienci', array('filtry' => 1,
				'klienci' => $klienci,
				'paginacja' => $paginacja,
				'paginacja_link' => 'klienci/lista',
				'suma' => $suma,
				'uzytkownik' => $uzytkownik));
	}


	public function szukaj(){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		echo json_encode($this -> load -> model('klienci') -> szukaj($uzytkownik, $this -> input -> get('term')));
	}


	public function filtr(){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

		$id_partnera = $this -> input -> get('id_partnera');
		$przekierowanie = $this -> input -> get('przekierowanie');

		if($id_partnera) $this -> session -> set('filtr_klienci_partnera', $id_partnera);
		else $this -> session -> delete('filtr_klienci_partnera');

		url::redirect($przekierowanie);
	}


	public function wszyscy($strona = 1){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		$_klienci = $this -> load -> model('klienci');

		$suma = $_klienci -> wszyscy_klienci_policz($uzytkownik['id'], $uzytkownik['typ']);

		$paginacja = new pagination($suma, $strona, LICZBA_KLIENTOW_NA_STRONE);

		$klienci = $_klienci -> wszyscy_klienci($uzytkownik['id'], $uzytkownik['typ'], $paginacja -> limit, $paginacja -> min);

		$this -> load -> view('klienci', array('klienci' => $klienci,
				'paginacja' => $paginacja,
				'paginacja_link' => 'klienci/wszyscy',
				'suma' => $suma,
				'uzytkownik' => $uzytkownik));
	}


	public function etap($etap = 1, $strona = 1){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		$_klienci = $this -> load -> model('klienci');

		$suma = $_klienci -> klienci_wedlug_etapu_policz($etap, $uzytkownik);

		$paginacja = new pagination($suma, $strona, LICZBA_KLIENTOW_NA_STRONE);

		$klienci = $_klienci -> klienci_wedlug_etapu($etap, $uzytkownik, $paginacja -> limit, $paginacja -> min);

		$this -> load -> view('klienci', array('klienci' => $klienci,
				'paginacja' => $paginacja,
				'paginacja_link' => 'klienci/etap/'.$etap,
				'suma' => $suma,
				'uzytkownik' => $uzytkownik));
	}


	public function zalegajacy($strona = 1){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		$_klienci = $this -> load -> model('klienci');

		$suma = $_klienci -> zalegajacy_klienci_policz($uzytkownik['id'], $uzytkownik['typ']);

		$paginacja = new pagination($suma, $strona, LICZBA_KLIENTOW_NA_STRONE);

		$klienci = $_klienci -> zalegajacy_klienci($uzytkownik['id'], $uzytkownik['typ'], $paginacja -> limit, $paginacja -> min);

		$this -> load -> view('klienci', array('klienci' => $klienci,
				'paginacja' => $paginacja,
				'paginacja_link' => 'klienci/zalegajacy',
				'suma' => $suma,
				'uzytkownik' => $uzytkownik));
	}


	public function na_dzis($strona = 1){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		$_klienci = $this -> load -> model('klienci');

		$suma = $_klienci -> klienci_na_dzis_policz($uzytkownik['id'], $uzytkownik['typ']);

		$paginacja = new pagination($suma, $strona, LICZBA_KLIENTOW_NA_STRONE);

		$klienci = $_klienci -> klienci_na_dzis($uzytkownik['id'], $uzytkownik['typ'], $paginacja -> limit, $paginacja -> min);

		$this -> load -> view('klienci', array('klienci' => $klienci,
				'paginacja' => $paginacja,
				'paginacja_link' => 'klienci/na-dzis',
				'suma' => $suma,
				'uzytkownik' => $uzytkownik));
	}


	public function na_jutro($strona = 1){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		$_klienci = $this -> load -> model('klienci');

		$suma = $_klienci -> klienci_na_jutro_policz($uzytkownik['id'], $uzytkownik['typ']);

		$paginacja = new pagination($suma, $strona, LICZBA_KLIENTOW_NA_STRONE);

		$klienci = $_klienci -> klienci_na_jutro($uzytkownik['id'], $uzytkownik['typ'], $paginacja -> limit, $paginacja -> min);

		$this -> load -> view('klienci', array('klienci' => $klienci,
				'paginacja' => $paginacja,
				'paginacja_link' => 'klienci/na-jutro',
				'suma' => $suma,
				'uzytkownik' => $uzytkownik));
	}


	public function form($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);

		if($id_klienta && !$klient) $this -> load -> error('no-access');

		$this -> load -> view('klienci_formularz', array('klient' => $klient,
				'uzytkownik' => $uzytkownik));

	}


	public function profil($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		if($uzytkownik['typ'] != 'partner' && !$id_klienta) $this -> load -> error('no-access');

		$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);

		if($id_klienta && !$klient) $this -> load -> error('no-access');

		$this -> load -> view('klienci_profil', array('klient' => $klient,
				'uzytkownik' => $uzytkownik));

	}


	public function zapisz($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
		$klienci = $this -> load -> model('klienci');

		if($id_klienta && !$klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

		$adres_strony = trim(str_replace('http://', '', str_replace('www.', '', $this -> input -> post('adres_strony'))));
		$adres_strony_2 = $this -> input -> post('adres_strony_2');
		$dane_kontaktowe = $this -> input -> post('dane_kontaktowe');
		$data_nastepnego_kontaktu = $this -> input -> post('data_nastepnego_kontaktu');
		$data_pierwszego_kontaktu = $this -> input -> post('data_pierwszego_kontaktu');
		$data_rozpoczecia_pozycjonowania = $this -> input -> post('data_rozpoczecia_pozycjonowania');
		$data_utworzenia = $this -> input -> post('data_utworzenia');
		$faktura_adres = $this -> input -> post('faktura_adres');
		$faktura_kod_pocztowy = $this -> input -> post('faktura_kod_pocztowy');
		$faktura_miejscowosc = $this -> input -> post('faktura_miejscowosc');
		$faktura_nazwa = $this -> input -> post('faktura_nazwa');
		$faktura_papierowa = $this -> input -> post('faktura_papierowa');
		$faktury_za_pozycjonowanie = ($id_klienta || $uzytkownik['typ'] != 'partner') ? $this -> input -> post('faktury_za_pozycjonowanie') : 1;
		$hosting = $this -> input -> post('hosting');
		$poczta = $this -> input -> post('poczta');
		$cena_hosting = $this -> input -> post('cena_hosting');
		$priorytet = $this -> input -> post('priorytet');
		$kategoria = $this -> input -> post('kategoria');
		$vip = $this -> input -> post('vip');
		$okres_umowy = $this -> input -> post('okres_umowy');
		$nowe_teksty = $this -> input -> post('nowe_teksty');
		$nowa_strona = $this -> input -> post('nowa_strona');
		$id_partnera = $this -> input -> post('id_partnera');
		$id_1_partnera = $this -> input -> post('id_1_partnera');
		$id_pozycjonera = $this -> input -> post('id_pozycjonera');
		$korespondencja_adres = $this -> input -> post('korespondencja_adres');
		$korespondencja_adres = $this -> input -> post('korespondencja_adres');
		$korespondencja_kod_pocztowy = $this -> input -> post('korespondencja_kod_pocztowy');
		$korespondencja_miejscowosc = $this -> input -> post('korespondencja_miejscowosc');
		$korespondencja_nazwa = $this -> input -> post('korespondencja_nazwa');
		$mail = strtolower(trim($this -> input -> post('mail')));
		$nazwa = $this -> input -> post('nazwa');
		$nip = $this -> input -> post('nip');
		$notatka_do_nastepnego_kontaktu = $this -> input -> post('notatka_do_nastepnego_kontaktu');
		$osoba_kontaktowa = $this -> input -> post('osoba_kontaktowa');
		$regon = $this -> input -> post('regon');
		$reprezentant = $this -> input -> post('reprezentant');
		$pesel = $this -> input -> post('pesel');
		$telefon = trim(str_replace(')', '', str_replace('(', '', str_replace(' ', '', str_replace('-', '', $this -> input -> post('telefon'))))));
		$top_10_1_do = $this -> input -> post('top_10_1_do');
		$top_10_1_od = $this -> input -> post('top_10_1_od');
		$top_10_2_do = $this -> input -> post('top_10_2_do');
		$top_10_2_od = $this -> input -> post('top_10_2_od');
		$top_10_3_do = $this -> input -> post('top_10_3_do');
		$top_10_3_od = $this -> input -> post('top_10_3_od');
		$umowa_czas_okreslony = $this -> input -> post('umowa_czas_okreslony');
		$umowa_czas_okreslony_do = $this -> input -> post('umowa_czas_okreslony_do');
		$umowa_czas_okreslony_od = $this -> input -> post('umowa_czas_okreslony_od');

		if(!$adres_strony ||
		!$data_nastepnego_kontaktu ||
		!$data_pierwszego_kontaktu ||
		!$data_utworzenia ||
		!$id_partnera ||
		!$mail ||
		!$nazwa ||
		!$notatka_do_nastepnego_kontaktu ||
		!$osoba_kontaktowa ||
		!$telefon ||
		!$top_10_1_od ||
		!$top_10_1_do ||
		$top_10_2_od == '' ||
		$top_10_2_do == '' ||
		$top_10_3_od == '' ||
		$top_10_3_do == '') $this -> session -> set('error', 1);
		if(!validate::e_mail($mail)) $this -> session -> set('error', 2);
		if($klienci -> czy_adres_strony_istnieje($adres_strony, $id_klienta)) $this -> session -> set('error', 'Klient z takim adresem strony jest już w naszej bazie i nie można dodać go ponownie.');

		if($this -> session -> get('error')){
			$this -> load -> view('klienci_formularz', array('klient' => array('adres_strony' => $adres_strony,
					'adres_strony_2' => $adres_strony_2,
					'dane_kontaktowe' => $dane_kontaktowe,
					'data_nastepnego_kontaktu' => $data_nastepnego_kontaktu,
					'data_pierwszego_kontaktu' => $data_pierwszego_kontaktu,
					'data_rozpoczecia_pozycjonowania' => $data_rozpoczecia_pozycjonowania,
					'data_utworzenia' => $data_utworzenia,
					'faktura_adres' => $faktura_adres,
					'faktura_kod_pocztowy' => $faktura_kod_pocztowy,
					'faktura_miejscowosc' => $faktura_miejscowosc,
					'faktura_nazwa' => $faktura_nazwa,
					'faktura_papierowa' => $faktura_papierowa,
					'faktury_za_pozycjonowanie' => $faktury_za_pozycjonowanie,
					'hosting' => $hosting,
					'poczta' => $poczta,
					'cena_hosting' => $cena_hosting,
					'priorytet' => $priorytet,
					'kategoria' => $kategoria,
					'vip' => $vip,
					'okres_umowy' => $okres_umowy,
					'nowe_teksty' => $nowe_teksty,
					'nowa_strona' => $nowa_strona,
					'id_partnera' => $id_partnera,
					'id_1_partnera' => $id_1_partnera,
					'id_pozycjonera' => $id_pozycjonera,
					'korespondencja_adres' => $korespondencja_adres,
					'korespondencja_kod_pocztowy' => $korespondencja_kod_pocztowy,
					'korespondencja_miejscowosc' => $korespondencja_miejscowosc,
					'korespondencja_nazwa' => $korespondencja_nazwa,
					'korespondencja_adres' => $korespondencja_adres,
					'mail' => $mail,
					'nip' => $nip,
					'nazwa' => $nazwa,
					'notatka_do_nastepnego_kontaktu' => $notatka_do_nastepnego_kontaktu,
					'osoba_kontaktowa' => $osoba_kontaktowa,
					'regon' => $regon,
					'reprezentant' => $reprezentant,
					'pesel' => $pesel,
					'telefon' => $telefon,
					'top_10_1_od' => $top_10_1_od,
					'top_10_1_do' => $top_10_1_do,
					'top_10_2_od' => $top_10_2_od,
					'top_10_2_do' => $top_10_2_do,
					'top_10_3_od' => $top_10_3_od,
					'top_10_3_do' => $top_10_3_do,
					'umowa_czas_okreslony' => $umowa_czas_okreslony,
					'umowa_czas_okreslony_do' => $umowa_czas_okreslony_do,
					'umowa_czas_okreslony_od' => $umowa_czas_okreslony_od),
					'uzytkownik' => $uzytkownik));
			exit;
		}

		$klienci -> zapisz($adres_strony,
				$adres_strony_2,
				$dane_kontaktowe,
				$data_nastepnego_kontaktu,
				$data_pierwszego_kontaktu,
				$data_rozpoczecia_pozycjonowania,
				$data_utworzenia,
				$faktura_adres,
				$faktura_kod_pocztowy,
				$faktura_miejscowosc,
				$faktura_nazwa,
				$faktura_papierowa,
				$faktury_za_pozycjonowanie,
				$hosting,
				$poczta,
				$cena_hosting,
				$priorytet,
				$kategoria,
				$vip,
				$id_klienta,
				$id_partnera,
				$id_1_partnera,
				$id_pozycjonera,
				$korespondencja_adres,
				$korespondencja_kod_pocztowy,
				$korespondencja_miejscowosc,
				$korespondencja_nazwa,
				$korespondencja_adres,
				$mail,
				$nip,
				$nazwa,
				$notatka_do_nastepnego_kontaktu,
				$osoba_kontaktowa,
				$regon,
				$reprezentant,
				$pesel,
				$telefon,
				$top_10_1_od,
				$top_10_1_do,
				$top_10_2_od,
				$top_10_2_do,
				$top_10_3_od,
				$top_10_3_do,
				$umowa_czas_okreslony,
				$umowa_czas_okreslony_do,
				$umowa_czas_okreslony_od,
				$uzytkownik,
				$okres_umowy,
				$nowe_teksty,
				$nowa_strona);

		$this -> session -> set('info', 1);

		if($this -> input -> post('redirectBack')) url::redirect('klienci/form/'.$id_klienta);
		else url::redirect($id_klienta ? 'klienci/profil/'.$id_klienta : 'klienci/lista');
	}


	public function panel($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		if($uzytkownik['typ'] != 'partner' && !$id_klienta) $this -> load -> error('no-access');

		$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);

		if($id_klienta && !$klient) $this -> load -> error('no-access');

		$this -> load -> view('klienci_panel', array('klient' => $klient,
				'uzytkownik' => $uzytkownik));

	}


	public function usun_klienta($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
		$klienci = $this -> load -> model('klienci');

		if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');
		if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

		$pozwolenie_na_usuniecie = $klienci -> sprawdz_czy_mozna_usunac_klienta($id_klienta);

		$this -> load -> view('usun_klienta', array('klient' => $klient,
				'pozwolenie_na_usuniecie' => $pozwolenie_na_usuniecie,
				'uzytkownik' => $uzytkownik));
	}


	public function popros_o_usuniecie($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
		$klienci = $this -> load -> model('klienci');

		if($id_klienta && !$klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

		$powod_usuniecia = $this -> input -> post('powod_usuniecia');

		if(!$powod_usuniecia) $this -> session -> set('error', 'Wypełnij pole z powodem usunięcia.');

		if($pozwolenie_na_usuniecie = $klienci -> sprawdz_czy_mozna_usunac_klienta($id_klienta)){
			$klienci -> popros_o_usuniecie($id_klienta, $powod_usuniecia);
			$this -> session -> set('info', 'Klient został zgłoszony do usunięcia.');
		}else{
			$this -> session -> set('error', 'Nie można usunąć klienta, ponieważ ma on już wystawioną fakturę VAT i system musi utrzymać jego dane dla celów statystycznych.');
		}

		url::redirect(CONTROLLER.'/profil/'.$id_klienta);
	}


	public function zatwierdz_usuniecie_klienta($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
		$klienci = $this -> load -> model('klienci');

		if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');
		if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

		// jeśli jest pozwolenie
		if($klienci -> sprawdz_czy_mozna_usunac_klienta($id_klienta)){
			$klienci -> usun_klienta($id_klienta);

			$this -> session -> set('info', 'Klient został usunięty.');

			url::redirect('witaj');
		}
	}


	public function anuluj_prosbe_o_usuniecie($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
		$klienci = $this -> load -> model('klienci');

		if($id_klienta && !$klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

		$klienci -> anuluj_prosbe_o_usuniecie($id_klienta);

		$this -> session -> set('info', 'Prośba o usunięcie została anulowana.');

		url::redirect(CONTROLLER.'/profil/'.$id_klienta);
	}


	/*    public function zapisz_komentarz_do_wynikow($id_klienta){
	 $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
	$klienci = $this -> load -> model('klienci');

	if($id_klienta && !$klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

	$komentarz_do_wynikow = $this -> input -> post('komentarz_do_wynikow');

	$klienci -> zapisz_komentarz_do_wynikow($id_klienta, $komentarz_do_wynikow);

	$this -> session -> set('info', 'Zapisano komentarz.');

	url::redirect(CONTROLLER.'/profil/'.$id_klienta);
	}
	*/

	// powiązania
	public function powiazania($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

		$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);

		$this -> load -> view('powiazania_klienta_formularz', array('klient' => $klient,
				'uzytkownik' => $uzytkownik));
	}


	public function zapisz_powiazania($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

		$klienci = $this -> load -> model('klienci');

		$id_pozycjonera = $this -> input -> post('id_pozycjonera');

		if(!$id_pozycjonera) $this -> session -> set('error', 1);

		if($this -> session -> get('error')){
			$this -> load -> view('powiazania_klienta_formularz', array('klient' => array('id_pozycjonera' => $id_pozycjonera),
					'uzytkownik' => $uzytkownik));
			exit;
		}

		$klienci -> zapisz_powiazania($id_klienta, $id_pozycjonera);

		$this -> session -> set('info', 1);

		if($this -> input -> post('redirectBack')) url::redirect('klienci/powiazania/'.$id_klienta);
		else url::redirect('klienci/profil/'.$id_klienta);
	}


	// załączniki
	public function zalaczniki($id_klienta = 0){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		if(!$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

		$this -> load -> view('klienci_zalaczniki', array('klient' => $klient,
				'uzytkownik' => $uzytkownik));
	}




	public function pobierz_zalacznik($id_klienta = 0){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		if(!$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
		$nazwa_pliku = $this -> input -> get('nazwa_pliku');
		if(!$nazwa_pliku) $this -> load -> error('no-access');

		$sciezka = 'pliki/klienci/'.base::get_folder_number($klient['id_klienta']).'/'.base::get_file_number($klient['id_klienta']).'/'.$nazwa_pliku;

		header("Content-type: application/force-download");
		header("Content-Transfer-Encoding: Binary");
		header("Content-length: ".filesize($sciezka));
		header("Content-disposition: attachment; filename=\"".basename($sciezka)."\"");
		readfile("$sciezka");
	}


	public function usun_zalacznik($id_klienta = 0){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		if(!$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
		$nazwa_pliku = $this -> input -> get('nazwa_pliku');
		if(!$nazwa_pliku) $this -> load -> error('no-access');

		$sciezka = 'pliki/klienci/'.base::get_folder_number($klient['id_klienta']).'/'.base::get_file_number($klient['id_klienta']).'/'.$nazwa_pliku;

		unlink($sciezka);

		$this -> session -> set('info', 'Plik został usunięty.');

		url::redirect('klienci/zalaczniki/'.$id_klienta);
	}


	public function wgraj_zalacznik($id_klienta = 0){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

		if(!$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

		$plik = $this -> input -> files('plik');
		if(!$plik['tmp_name']) $this -> load -> error('no-access');

		$sciezka = 'pliki/klienci/'.base::get_folder_number($klient['id_klienta']).'/'.base::get_file_number($klient['id_klienta']).'/';

		move_uploaded_file($plik['tmp_name'], $sciezka.$plik['name']);

		$this -> session -> set('info', 'Plik został wgrany.');

		url::redirect('klienci/zalaczniki/'.$id_klienta);
	}

}

?>