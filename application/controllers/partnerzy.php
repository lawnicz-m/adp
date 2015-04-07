<?php

    class controller{

        public function index(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $partnerzy = $this -> load -> model('partnerzy') -> wszyscy();

    		$this -> load -> view('partnerzy', array('partnerzy' => $partnerzy,
    		                                         'uzytkownik' => $uzytkownik));
        }


    	public function form($id_partnera){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $partner = $this -> load -> model('partnerzy') -> jeden($id_partnera);
		
    		$this -> load -> view('partnerzy_formularz', array('partner' => $partner,
    		                                                   'uzytkownik' => $uzytkownik));
    	}


    	public function zapisz($id_partnera){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $partnerzy = $this -> load -> model('partnerzy');

            $adres_strony = str_replace('http://', '', str_replace('www.', '', trim($this -> input -> post('adres_strony'))));
            $dane_kontaktowe = $this -> input -> post('dane_kontaktowe');
            $data_utworzenia = $this -> input -> post('data_utworzenia');
            $faktura_adres = $this -> input -> post('faktura_adres');
            $faktura_kod_pocztowy = $this -> input -> post('faktura_kod_pocztowy');
            $faktura_miejscowosc = $this -> input -> post('faktura_miejscowosc');
            $faktura_nazwa = $this -> input -> post('faktura_nazwa');
            $faktura_papierowa = $this -> input -> post('faktura_papierowa');
            $haslo = $this -> input -> post('haslo');
            $indywidualny = $this -> input -> post('indywidualny');
            $korespondencja_adres = $this -> input -> post('korespondencja_adres');
            $korespondencja_kod_pocztowy = $this -> input -> post('korespondencja_kod_pocztowy');
            $korespondencja_miejscowosc = $this -> input -> post('korespondencja_miejscowosc');
            $korespondencja_nazwa = $this -> input -> post('korespondencja_nazwa');
            $login = strtolower(trim($this -> input -> post('login')));
            $mail = strtolower(trim($this -> input -> post('mail')));
            $nazwa = $this -> input -> post('nazwa');
            $nip = $this -> input -> post('nip');
            $osoba_kontaktowa = $this -> input -> post('osoba_kontaktowa');
            $regon = $this -> input -> post('regon');
            $reprezentant = $this -> input -> post('reprezentant');
            $telefon = strtolower(trim($this -> input -> post('telefon')));
			$mail_nozbe = strtolower(trim($this -> input -> post('mail_nozbe')));



            if(!$data_utworzenia || !$haslo || !$login || !$mail || !$nazwa || !$telefon) $this -> session -> set('error', 1);
            else if(!validate::e_mail($mail)) $this -> session -> set('error', 2);
            else if(!validate::login($login)) $this -> session -> set('error', 3);
            else if($partnerzy -> czy_login_istnieje($id_partnera, $login)) $this -> session -> set('error', 4);

            if($this -> session -> get('error')){
    		    $this -> load -> view('partnerzy_formularz', array('partner' => array('adres_strony' => $adres_strony,
    		                                                                          'data_utworzenia' => $data_utworzenia,
    		                                                                          'haslo' => $haslo,
    		                                                                          'login' => $login,
    		                                                                          'mail' => $mail,
    		                                                                          'nazwa' => $nazwa,
    		                                                                          'telefon' => $telefon,
                                                                                      'dane_kontaktowe' => $dane_kontaktowe,
                                                                                      'faktura_adres' => $faktura_adres,
                                                                                      'faktura_kod_pocztowy' => $faktura_kod_pocztowy,
                                                                                      'faktura_miejscowosc' => $faktura_miejscowosc,
                                                                                      'faktura_nazwa' => $faktura_nazwa,
                                                                                      'faktura_papierowa' => $faktura_papierowa,
                                                                                      'indywidualny' => $indywidualny,
                                                                                      'korespondencja_adres' => $korespondencja_adres,
                                                                                      'korespondencja_kod_pocztowy' => $korespondencja_kod_pocztowy,
                                                                                      'korespondencja_miejscowosc' => $korespondencja_miejscowosc,
                                                                                      'korespondencja_nazwa' => $korespondencja_nazwa,
                                                                                      'nip' => $nip,
                                                                                      'osoba_kontaktowa' => $osoba_kontaktowa,
                                                                                      'regon' => $regon,
                                                                                      'reprezentant' => $reprezentant,
																					  'mail_nozbe' => $mail_nozbe),
    		                                                       'uzytkownik' => $uzytkownik));
    		    exit;
            }

            $partnerzy -> zapisz($adres_strony, $dane_kontaktowe, $data_utworzenia, $faktura_adres, $faktura_kod_pocztowy, $faktura_miejscowosc, $faktura_nazwa, $faktura_papierowa, $haslo, $id_partnera, $indywidualny, $korespondencja_adres, $korespondencja_kod_pocztowy, $korespondencja_miejscowosc, $korespondencja_nazwa, $login, $mail, $nazwa, $nip, $osoba_kontaktowa, $regon, $reprezentant, $telefon, $mail_nozbe);

            $this -> session -> set('info', 1);

            if($this -> input -> post('redirectBack')) url::redirect('partnerzy/form/'.$id_partnera);
            else url::redirect('partnerzy');
    	}


        // powiązania
    	public function powiazania($id_partnera){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $partner = $this -> load -> model('partnerzy') -> jeden($id_partnera);
		
    		$this -> load -> view('powiazania_partnera_formularz', array('partner' => $partner,
    		                                                             'uzytkownik' => $uzytkownik));
    	}


    	public function zapisz_powiazania($id_partnera){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $partnerzy = $this -> load -> model('partnerzy');

            $id_partnera_polecajacego = $this -> input -> post('id_partnera_polecajacego');

            $partnerzy -> zapisz_powiazania($id_partnera, $id_partnera_polecajacego);

            $this -> session -> set('info', 1);

            if($this -> input -> post('redirectBack')) url::redirect('partnerzy/powiazania/'.$id_partnera);
            else url::redirect('partnerzy');
    	}


        // prowizja
    	public function prowizja($id_partnera){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $partner = $this -> load -> model('partnerzy') -> jeden($id_partnera);
		
    		$this -> load -> view('prowizja_partnera_formularz', array('partner' => $partner,
    		                                                           'uzytkownik' => $uzytkownik));
    	}


    	public function zapisz_prowizje($id_partnera){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $partnerzy = $this -> load -> model('partnerzy');

            $prowizja_partnera = $this -> input -> post('prowizja_partnera');
            $prowizja_partnera_prog = $this -> input -> post('prowizja_partnera_prog');
            $prowizja_partnera_polecajacego = $this -> input -> post('prowizja_partnera_polecajacego');

            if($prowizja_partnera == '' || $prowizja_partnera_prog == '' || $prowizja_partnera_polecajacego == '') $this -> session -> set('error', 1);

            if($this -> session -> get('error')){
    		    $this -> load -> view('prowizja_partnera_formularz', array('partner' => array('prowizja_partnera' => $prowizja_partnera,
    		                                                                                  'prowizja_partnera_prog' => $prowizja_partnera_prog,
    		                                                                                  'prowizja_partnera_polecajacego' => $prowizja_partnera_polecajacego),
    		                                                               'uzytkownik' => $uzytkownik));
    		    exit;
            }


            $partnerzy -> zapisz_prowizje($id_partnera, $prowizja_partnera, $prowizja_partnera_prog, $prowizja_partnera_polecajacego);

            $this -> session -> set('info', 1);

            if($this -> input -> post('redirectBack')) url::redirect('partnerzy/prowizja/'.$id_partnera);
            else url::redirect('partnerzy');
    	}


        // saldo
        public function saldo($id_partnera = 0){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin' && $uzytkownik['typ'] != 'partner') $this -> load -> error('no-access');
            if($uzytkownik['typ'] == 'partner') $id_partnera = $uzytkownik['id'];
            if(!$id_partnera) $this -> load -> error('no-access');
                                                             
            // zmienne
            $kwota_obciazenia = trim($this -> input -> post('kwota_obciazenia'));
            $podstawa_obciazenia = trim($this -> input -> post('podstawa_obciazenia'));

            // modele
            $partnerzy = $this -> load -> model('partnerzy');

            $partner = $partnerzy -> jeden($id_partnera);

            // walidacja
            if($uzytkownik['typ'] == 'admin' && ($kwota_obciazenia || $podstawa_obciazenia)){
                if(!$kwota_obciazenia || !$podstawa_obciazenia) $this -> session -> set('error', 1);
                else if(!is_numeric($kwota_obciazenia)) $this -> session -> set('error', 'Kwota jest błędna');
                else if($partner['saldo'] < $kwota_obciazenia) $this -> session -> set('error', 'Kwota obciążenia jest wyższa niż saldo');

                if(!$this -> session -> get('error')){
                    $partnerzy -> obciaz_saldo($id_partnera, $kwota_obciazenia, $podstawa_obciazenia);

                    $email = new email();
                    $email -> to($partner['mail']);
                    $email -> from(BASE_MAIL);
                    $email -> subject(iconv("UTF-8","ISO-8859-2",E_MAIL_TITLE_COMPANY_NAME.' | Przelew zgromadzonych środków został wykonany'));
                    $email -> content(iconv("UTF-8","ISO-8859-2",'Na podstawie dokumentu '.$podstawa_obciazenia.' przelaliśmy na Twoje konto kwotę '.$kwota_obciazenia.' PLN.'));
                    $email -> send();                    

                    $this -> session -> set('info', 'Saldo zostało obciążone');

                    url::redirect('partnerzy/saldo/'.$id_partnera);
                }
            }

            $historia_salda = $partnerzy -> historia_salda($id_partnera);

    		$this -> load -> view('partnerzy_saldo', array('historia_salda' => $historia_salda,
    		                                               'kwota_obciazenia' => $kwota_obciazenia,
    		                                               'partner' => $partner,
    		                                               'podstawa_obciazenia' => $podstawa_obciazenia,
    		                                               'uzytkownik' => $uzytkownik));

        }


        // załączniki
        public function zalaczniki($id_partnera = 0){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $partner = $this -> load -> model('partnerzy') -> jeden($id_partnera);
		
    		$this -> load -> view('partnerzy_zalaczniki', array('partner' => $partner,
    		                                                    'uzytkownik' => $uzytkownik));
        }


        public function pobierz_zalacznik($id_partnera = 0){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $nazwa_pliku = $this -> input -> get('nazwa_pliku');
            if(!$nazwa_pliku) $this -> load -> error('no-access');

            $partner = $this -> load -> model('partnerzy') -> jeden($id_partnera);

            $sciezka = 'pliki/partnerzy/'.base::get_folder_number($partner['id_partnera']).'/'.base::get_file_number($partner['id_partnera']).'/'.$nazwa_pliku;

            header("Content-type: application/force-download");
            header("Content-Transfer-Encoding: Binary");
            header("Content-length: ".filesize($sciezka));
            header("Content-disposition: attachment; filename=\"".basename($sciezka)."\"");
            readfile("$sciezka");
        }


        public function usun_zalacznik($id_partnera = 0){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $nazwa_pliku = $this -> input -> get('nazwa_pliku');
            if(!$nazwa_pliku) $this -> load -> error('no-access');

            $partner = $this -> load -> model('partnerzy') -> jeden($id_partnera);

            $sciezka = 'pliki/partnerzy/'.base::get_folder_number($partner['id_partnera']).'/'.base::get_file_number($partner['id_partnera']).'/'.$nazwa_pliku;

            unlink($sciezka);

            $this -> session -> set('info', 'Plik został usunięty.');

            url::redirect('partnerzy/zalaczniki/'.$id_partnera);
        }


        public function wgraj_zalacznik($id_partnera = 0){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $plik = $this -> input -> files('plik');
            if(!$plik['tmp_name']) $this -> load -> error('no-access');

            $partner = $this -> load -> model('partnerzy') -> jeden($id_partnera);

            $sciezka = 'pliki/partnerzy/'.base::get_folder_number($partner['id_partnera']).'/'.base::get_file_number($partner['id_partnera']).'/'.$plik['name'];

            move_uploaded_file($plik['tmp_name'], $sciezka);

            $this -> session -> set('info', 'Plik został wgrany.');

            url::redirect('partnerzy/zalaczniki/'.$id_partnera);
        }

    }

?>