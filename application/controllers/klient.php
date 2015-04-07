<?php

    class controller{

        public function wyniki($hash, $data = 0){
            $klienci = $this -> load -> model('klienci');
            $_frazy = $this -> load -> model('frazy');
            if(!$klient = $klienci -> jeden_klient_po_hashu($hash)) $this -> load -> error('404');
            $data = $data ? $data : date("Y-m-d");
            $miesiac = substr($data, 0, -3);
		/*
            // zapisz dane dostępowe do GA
            if($this -> input -> post('ga_logowanie')){
                $ga_haslo = $this -> input -> post('ga_haslo');
                $ga_mail = $this -> input -> post('ga_mail');

                $klienci -> ga_zapisz_dane_dostepowe($ga_haslo, $ga_mail, $klient['id_klienta']);

                url::redirect('klient/wyniki/'.$klient['hash'].'/'.$data);
            }

            // zmień profil do GA
            if($this -> input -> post('ga_zmien_profil')){
                $ga_profil = $this -> input -> post('ga_profil');

                $klienci -> ga_zmien_profil($ga_profil, $klient['id_klienta']);

                url::redirect('klient/wyniki/'.$klient['hash'].'/'.$data);
            }

            // wyloguj z GA
            if($this -> input -> post('ga_wyloguj')){
                $klienci -> ga_wyloguj($klient['id_klienta']);
                $this -> session -> delete('ga_auth_'.$klient['id_klienta']);

                url::redirect('klient/wyniki/'.$klient['hash'].'/'.$data);
            }

            require 'analytics.class.php';

            $ga = array();
            $ga['zalogowany'] = 0;

            // logowanie do GA
            if($klient['ga_haslo'] && $klient['ga_mail']){

                //echo 'Logowanie z danymi: '.$klient['ga_mail'].', '.$klient['ga_haslo'].'<br />';
                //echo 'Profil: '.$klient['ga_profil'].'<br />';
                //echo 'Błąd: '.$this -> session -> get('ga_error').'<br />';

                $gac = new analytics($klient['ga_mail'], $klient['ga_haslo'], $klient['id_klienta']);
                if(!$this -> session -> get('ga_error')){
                    $ga['zalogowany'] = 1;

                    // pobieranie listy profili
                    $ga['profile'] = $gac -> getProfileList();  

                    // wybieranie profilu
                    if($klient['ga_profil']){
                        //echo 'Profil z bazy<br />';
                        $gac -> setProfileById($klient['ga_profil']);
                    }else{
                        //echo 'Pierwszy profil z listy<br />';
                        // generowanie kluczy
                        $ga['profile_klucze'] = array_keys($ga['profile']);
                        if(isset($ga['profile_klucze'][0])) $gac -> setProfileById($ga['profile_klucze'][0]);
                        else $ga['zalogowany'] = 0;
                    }

                    if($ga['zalogowany']){
                        // generowanie miesiąca z daty
                        $miesiac_2 = explode('-', $miesiac);

                        // ustawianie miesiąca
                        $gac -> setMonth($miesiac_2[1], $miesiac_2[0]); 

                        // ustawianie cache
                        $gac -> useCache(true, 3600);

                        // dane
                        $ga['odwiedziny'] = $gac -> getVisitors();
                        $ga['odslony'] = $gac -> getPageviews();
                        $ga['wyszukiwane_frazy'] = $gac -> getSearchWords();
                    }
                }
            }
		*/
            $aktualne_pozycje = self::pobierz_dane(url::base().'api/pobierz_pozycje_na_dzien/'.$hash.'/'.$data);
            $odsetek_na_pierwszej_stronie = self::pobierz_dane(url::base().'api/pobierz_odsetek_fraz_na_pierwszej_stronie_na_miesiac/'.$hash.'/'.$data);
            //$zaawansowanie_w_top_10 = $_frazy -> zaawansowanie_w_top_10($klient['id_klienta'], $miesiac);

            // globalny komunikat dla klientów
            $plik = file('komunikat.txt');
            $globalny_komunikat_dla_klientow = '';
            foreach($plik as $linia) $globalny_komunikat_dla_klientow .= $linia;

    		$this -> load -> view('klient/wyniki', array('aktualne_pozycje' => $aktualne_pozycje,
    		                                             'data' => $data,
    		                                             'ga' => $ga,
    		                                             'globalny_komunikat_dla_klientow' => $globalny_komunikat_dla_klientow,
    		                                             'klient' => $klient,
    		                                             'miesiac' => $miesiac,
    		                                             'odsetek_na_pierwszej_stronie' => $odsetek_na_pierwszej_stronie));
        }

	/*
        public function akceptacja_zmiany_na_pierwsza_strone($hash){
            $decyzja = $this -> input -> post('akceptacja');
            if($decyzja != 'tak' && $decyzja != 'nie'){ echo 'Nie wybrano żadnej opcji. Cofnij się i zaznacz punkt odpowiadający Twojej decyzji.'; exit; }
            $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
            $data = date("Y-m-d H:i:s");

            if(!$ip){ echo 'Błąd serwera.'; exit; }

            $wpis = $decyzja.'|'.$ip.'|'.$data;

    		$tabela = $this -> db -> table('klienci');

        	$tabela -> update(array('akceptacja_wynikow_na_pierwszej_stronie' => $wpis))
	                -> where('hash','=',$hash)
        	        -> execute();

            header('Location: '.url::page('klient/wyniki/'.$hash));
            exit;
        }
	*/

        public function raport_miesieczny($hash, $miesiac = 0, $format = 'csv'){
            if(!$klient = $this -> load -> model('klienci') -> jeden_klient_po_hashu($hash)) $this -> load -> error('404');

            $_frazy = $this -> load -> model('frazy');

            $miesiac = $miesiac ? $miesiac : date("Y-m");

            $dane = $_frazy -> raport_miesieczny($klient['id_klienta'], $miesiac);
            $frazy = $_frazy -> wszystkie($klient['id_klienta']);
            $odsetek_na_pierwszej_stronie = $_frazy -> odsetek_na_pierwszej_stronie($klient['id_klienta'], $miesiac);

    		$this -> load -> view('klient/raport_'.$format, array('dane' => $dane,
    		                                                      'frazy' => $frazy,
    		                                                      'klient' => $klient,
    		                                                      'miesiac' => $miesiac,
    		                                                      'odsetek_na_pierwszej_stronie' => $odsetek_na_pierwszej_stronie));
        }


        public function pobierz_dane($url){
            $wynik = array('status' => 0, 'dane' => 'Nieokreślony błąd');

            if(!($zapytanie = file($url))){
                $wynik['dane'] = 'Problem z nawiązaniem połączenia z bazą danych';
            }else if(!isset($zapytanie[0])){
                $wynik['dane'] = 'Problem z odbiorem danych';
            }else{
                $zapytanie = json_decode($zapytanie[0], true);
                if(isset($zapytanie['status'])){
                    if($zapytanie['status'] == 1){
                        $wynik = $zapytanie;
                    }else{
                        $wynik['dane'] = $zapytanie['dane'];
                    }
                }else{
                    $wynik['dane'] = 'Problem z formatem danych';
                }
            }

            return $wynik;
        }

    }

?>