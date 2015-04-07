<?php

    class controller{

    	public function index(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

    		$this -> load -> view('witaj', array('uzytkownik' => $uzytkownik));
    	}
				
		
    	public function nieoplacone_faktury(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

    		$tabela = $this -> db -> table('faktury_vat');

    		$dane = $tabela -> select('*')
                            -> join('klienci')
                            -> on('faktury_vat.id_klienta','=','klienci.id_klienta')
    		                -> where('status','=', 0)
    		                -> clause('AND')
    		                -> where('termin_zaplaty','<',date("Y-m-d"))
    		                -> order_by('termin_zaplaty', 'ASC')
    		                -> order_by('numer_faktury', 'ASC')
    		                -> execute();

            $nieoplacone_faktury = $dane ? $dane : false;

    		$this -> load -> view('witaj', array('nieoplacone_faktury' => $nieoplacone_faktury,
    		                                     'uzytkownik' => $uzytkownik));
    	}


    	public function faktury_oczekujace_na_zaplate(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

    		$tabela = $this -> db -> table('faktury_vat');

    		$dane = $tabela -> select('*')
                            -> join('klienci')
                            -> on('faktury_vat.id_klienta','=','klienci.id_klienta')
    		                -> where('status','=', 0)
    		                -> clause('AND')
    		                -> where('termin_zaplaty','>=',date("Y-m-d"))
    		                -> order_by('termin_zaplaty', 'ASC')
    		                -> order_by('numer_faktury', 'ASC')
    		                -> execute();

            $faktury_oczekujace_na_zaplate = $dane ? $dane : false;

    		$this -> load -> view('witaj', array('faktury_oczekujace_na_zaplate' => $faktury_oczekujace_na_zaplate,
    		                                     'uzytkownik' => $uzytkownik));
    	}


    	public function finansowy_raport_miesieczny(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("select date_format(data_wystawienia, '%Y-%m') as miesiac,
                                              (select sum(round(kwota_brutto))
                                               from faktury_vat
                                               where date_format(data_wystawienia, '%Y-%m') = miesiac
                                               and proforma = 0
                                               group by date_format(data_wystawienia, '%Y-%m')) as kwota_wystawionych,
											   (select count(*)
                                               from faktury_vat
                                               where date_format(data_wystawienia, '%Y-%m') = miesiac) as ilosc_wystawionych
										from faktury_vat
                                        group by miesiac
                                        order by miesiac DESC;");
/* Org zapytanie
select date_format(data_wystawienia, '%Y-%m') as miesiac,
                                              (select sum(round(kwota_brutto))
                                               from faktury_vat
                                               where date_format(data_wystawienia, '%Y-%m') = miesiac
                                               and proforma = 0
                                               group by date_format(data_wystawienia, '%Y-%m')) as kwota_wystawionych,
                                              (select count(*)
                                               from faktury_vat
                                               where date_format(data_wystawienia, '%Y-%m') = miesiac) as ilosc_wystawionych,
                                              (select sum(round(kwota_brutto))
                                               from faktury_vat
                                               where date_format(data_wystawienia, '%Y-%m') = miesiac
                                               and status = 1
                                               and proforma = 0
                                               group by date_format(data_wystawienia, '%Y-%m')) as kwota_oplaconych,
                                              (select count(*)
                                               from faktury_vat
                                               where status = 1
                                               and proforma = 0
                                               and date_format(data_wystawienia, '%Y-%m') = miesiac) as ilosc_oplaconych,
                                              (select sum(round(kwota_brutto))
                                               from faktury_vat
                                               where date_format(data_wystawienia, '%Y-%m') = miesiac
                                               and status = 0
                                               and proforma = 0
                                               group by date_format(data_wystawienia, '%Y-%m')) as kwota_nieoplaconych,
                                              (select count(*)
                                               from faktury_vat
                                               where status = 0
                                               and proforma = 0
                                               and date_format(data_wystawienia, '%Y-%m') = miesiac) as ilosc_nieoplaconych
                                          from faktury_vat
                                          group by miesiac
                                          order by miesiac DESC
*/
    		$this -> load -> view('witaj', array('finansowy_raport_miesieczny' => $dane ? $dane : false,
    		                                     'uzytkownik' => $uzytkownik));
    	}


        public function raport_z_miesiecznych_wplat(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("select date_format(data_wystawienia, '%Y-%m') as miesiac,
                                              (select sum(round(kwota_brutto))
                                               from faktury_vat
                                               where date_format(data_zaplaty, '%Y-%m') = miesiac
                                               and proforma = 0
                                               group by date_format(data_zaplaty, '%Y-%m')) as wplaty_brutto
                                          from faktury_vat
                                          group by miesiac
                                          order by miesiac DESC;");

    		$this -> load -> view('witaj', array('raport_z_miesiecznych_wplat' => $dane ? $dane : false,
    		                                     'uzytkownik' => $uzytkownik));
        }


        public function ostatnie_wplaty(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("SELECT data_zaplaty, nabywca_nazwa, kwota_brutto
                                          FROM faktury_vat
                                          WHERE data_zaplaty != '0000-00-00' and proforma = 0
                                          ORDER BY data_zaplaty DESC
                                          LIMIT 0,30;");

    		$this -> load -> view('witaj', array('ostatnie_wplaty' => $dane ? $dane : false,
    		                                     'uzytkownik' => $uzytkownik));
        }


    	public function najlepsi_partnerzy(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("select p.nazwa,
                                                 p.saldo,
                                                 (select count(*)
                                                  from klienci
                                                  where id_partnera = p.id_partnera) as ilosc_klientow,
                                                 
                                                 (select count(*)
                                                  from klienci
                                                  where
                                                  etap = 2
                                                  and id_partnera = p.id_partnera) as ilosc_klientow_etap_2,
                                                 (select count(*)
                                                  from klienci
                                                  where
                                                  etap = 3
                                                  and id_partnera = p.id_partnera
												  and faktury_za_pozycjonowanie = 1 ) as ilosc_klientow_etap_3,
                                                 (select count(*)
                                                  from klienci
                                                  where
                                                  etap = 4
                                                  and id_partnera = p.id_partnera) as ilosc_klientow_etap_4,
                                                 (select count(*)
                                                  from klienci
                                                  where
                                                  etap = 5
                                                  and id_partnera = p.id_partnera) as ilosc_klientow_etap_5,
                                                 (select count(*)
                                                  from klienci
                                                  where
                                                  etap = 6
                                                  and id_partnera = p.id_partnera) as ilosc_klientow_etap_6
                                          from partnerzy p
                                          order by ilosc_klientow_etap_5 DESC");

    		$this -> load -> view('witaj', array('najlepsi_partnerzy' => $dane ? $dane : false,
    		                                     'uzytkownik' => $uzytkownik));
    	}


        public function faktury_za_pozycjonowanie_do_wystawienia(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("SELECT id_klienta, nazwa
                                          FROM klienci
                                          WHERE etap = 5
                                          AND faktury_za_pozycjonowanie = 1
                                          AND data_rozpoczecia_pozycjonowania < '".date("Y-m")."-01'
                                          ORDER BY nazwa ASC");
            $dane_2 = array();

            $okres = date('Y-m', strtotime('-1 month', strtotime(date('Y-m-d'))));

            foreach($dane as $klient){
                $faktura = $this -> db -> query("SELECT id_faktury
                                                 FROM faktury_vat
                                                 WHERE data_wystawienia LIKE '$okres%'
                                                 AND id_klienta = ".$klient['id_klienta']);

                // klient nie ma wcale faktur za miniony okres
                if(!$faktura){
                    $dane_2[] = $klient;
                }
                // klient ma jakieś faktury - sprawdzamy za co
                else{
                    $usluga_pozycjonowania = $this -> db -> query("SELECT id_pozycji
                                                                   FROM faktury_vat_pozycje
                                                                   WHERE id_faktury = ".$faktura[0]['id_faktury']."
                                                                   AND id_towaru_lub_uslugi = 1");

                    if(!$usluga_pozycjonowania) $dane_2[] = $klient;
                }
            }

    		$this -> load -> view('witaj', array('faktury_za_pozycjonowanie_do_wystawienia' => $dane_2 ? $dane_2 : false,
    		                                     'uzytkownik' => $uzytkownik));
        }


        public function biezaca_aktywnosc_partnerow(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("SELECT nazwa, data_ostatniej_aktywnosci
                                          FROM partnerzy
                                          ORDER BY data_ostatniej_aktywnosci DESC
                                          LIMIT 0,10");

    		$this -> load -> view('witaj', array('biezaca_aktywnosc_partnerow' => $dane ? $dane : false,
    		                                     'uzytkownik' => $uzytkownik));
        }


        public function top_wzrostow(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("SELECT k.id_klienta, k.nazwa, k.odsetek_fraz_w_top_10_zmiana, k.hash, k.ile_na_1_stronie,
                                              (SELECT count(*)
                                               FROM frazy
                                               WHERE id_klienta = k.id_klienta) as liczba_fraz
                                          FROM klienci k
                                          WHERE k.etap = 5
                                          AND k.odsetek_fraz_w_top_10_zmiana > 0
                                          ORDER BY k.odsetek_fraz_w_top_10_zmiana DESC");

    		$this -> load -> view('witaj', array('top_wzrostow' => $dane ? $dane : false,
    		                                     'uzytkownik' => $uzytkownik));
        }


        public function top_spadkow(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("SELECT k.id_klienta, k.nazwa, k.odsetek_fraz_w_top_10_zmiana, k.hash, k.ile_na_1_stronie,
                                              (SELECT count(*)
                                               FROM frazy
                                               WHERE id_klienta = k.id_klienta) as liczba_fraz
                                          FROM klienci k
                                          WHERE k.etap = 5
                                          AND k.odsetek_fraz_w_top_10_zmiana < 0
                                          ORDER BY k.odsetek_fraz_w_top_10_zmiana ASC");

    		$this -> load -> view('witaj', array('top_spadkow' => $dane ? $dane : false,
    		                                     'uzytkownik' => $uzytkownik));
        }


        public function klienci_wymagajacy_dzialania(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("SELECT id_klienta, nazwa, etap, powod_usuniecia
                                          FROM klienci
                                          WHERE (etap = 1)
                                                OR powod_usuniecia != ''
                                          ORDER BY nazwa ASC");

    		$this -> load -> view('witaj', array('klienci_wymagajacy_dzialania' => $dane ? $dane : false,
    		                                     'uzytkownik' => $uzytkownik));
        }


        public function klienci_nierozliczani_za_pozycjonowanie(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("SELECT id_klienta, nazwa
                                          FROM klienci
                                          WHERE faktury_za_pozycjonowanie = 0
                                          ORDER BY nazwa ASC");

    		$this -> load -> view('witaj', array('klienci_nierozliczani_za_pozycjonowanie' => $dane ? $dane : false,
    		                                     'uzytkownik' => $uzytkownik));
        }


        public function klienci_wymagajacy_sprawdzenia_wynikow(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("SELECT k.id_klienta, k.nazwa,
                                              (SELECT count(*)
                                               FROM frazy
                                               WHERE id_klienta = k.id_klienta) as liczba_fraz
                                          FROM klienci k
                                          WHERE (etap = 2 OR etap=3 OR etap=5) AND data_sprawdzenia_wynikow < '".date("Y-m-d")."'
                                          ORDER BY k.nazwa ASC");

            $dane_2 = array();
            if($dane){
                foreach($dane as $w){
                    if($w['liczba_fraz']) $dane_2[] = $w;
                }
            }

    		$this -> load -> view('witaj', array('klienci_wymagajacy_sprawdzenia_wynikow' => $dane_2 ? $dane_2 : false,
    		                                     'uzytkownik' => $uzytkownik));
        }


        public function ostatnie_zmiany(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $plik = file('czendzlog.txt');
            $dane = array();
            foreach($plik as $linia){
                $linia_split = explode('|', $linia);
                $dane[] = array('data' => $linia_split[0],
                                'zmiana' => $linia_split[1]);
            }
            
            //print_r($dane); exit;

    		$this -> load -> view('witaj', array('ostatnie_zmiany' => $dane,
    		                                     'uzytkownik' => $uzytkownik));
        }


        public function globalny_komunikat_dla_klientow(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $plik = file('komunikat.txt');
            $dane = array();
            $komunikat = '';
            foreach($plik as $linia){
                $komunikat .= $linia;
            }

    		$this -> load -> view('witaj', array('globalny_komunikat_dla_klientow' => $komunikat,
    		                                     'uzytkownik' => $uzytkownik));
        }


        public function zapisz_globalny_komunikat_dla_klientow(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $komunikat = $this -> input -> post('komunikat');

            $filename = 'komunikat.txt';

            if(!is_writable($filename)){ echo 'Nie można zapisać danych'; exit; }
            if(!$handle = fopen($filename, 'w')){ echo "Nie można otworzyć pliku"; exit; }
            if(fwrite($handle, $komunikat) === FALSE){ echo "Nie można zapisać do pliku"; exit; }
            fclose($handle);

            $this -> session -> set('info', 'Zapisano komunikat.');

            url::redirect(CONTROLLER);
        }
		
		public function nowi_na_audyt(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("SELECT id_klienta, nazwa, notatka_do_nastepnego_kontaktu, data_utworzenia
                                          FROM klienci
                                          WHERE (etap = 1)
                                          ORDER BY data_utworzenia ASC");

    		$this -> load -> view('witaj', array('nowi_na_audyt' => $dane ? $dane : false,
    		                                     'uzytkownik' => $uzytkownik));
        }
		
		public function klienci_do_zoptymalizowania(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("SELECT id_klienta, nazwa, umowa_czas_okreslony_od, hash
                                          FROM klienci
                                          WHERE (etap = 5) AND (optymalizacja != 1) AND (dostepy = 1) AND (faktury_za_pozycjonowanie = 1)
                                          ORDER BY umowa_czas_okreslony_od ASC");

    		$this -> load -> view('witaj', array('klienci_do_zoptymalizowania' => $dane ? $dane : false,
    		                                     'uzytkownik' => $uzytkownik));
        }
		
		public function klienci_do_poprawienia(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("SELECT id_klienta, nazwa, umowa_czas_okreslony_od, hash
                                          FROM klienci
                                          WHERE (etap = 5) AND (poprawa = 1) AND (faktury_za_pozycjonowanie = 1)
                                          ORDER BY umowa_czas_okreslony_od ASC");

    		$this -> load -> view('witaj', array('klienci_do_poprawienia' => $dane ? $dane : false,
    		                                     'uzytkownik' => $uzytkownik));
        }
		
		public function klienci_bez_dostepow(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $dane = $this -> db -> query("SELECT id_klienta, nazwa, umowa_czas_okreslony_od, hash
                                          FROM klienci
                                          WHERE (etap = 5) AND (dostepy != 1) AND (faktury_za_pozycjonowanie = 1) AND (niebonie != 1)
                                          ORDER BY umowa_czas_okreslony_od ASC");

    		$this -> load -> view('witaj', array('klienci_bez_dostepow' => $dane ? $dane : false,
    		                                     'uzytkownik' => $uzytkownik));
        }
		
	}

?>