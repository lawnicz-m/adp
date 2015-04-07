<?php

    class controller{

        public function sprawdz_date($date){
            if(preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)){
                if(checkdate($parts[2],$parts[3],$parts[1])) return true;
                else return false;
            }else{
                return false;
            }
        }


        public function pobierz_pozycje_na_dzien($hash = 0, $data = 0){
            // wczytywanie modeli
            $_klienci = $this -> load -> model('klienci');
            $_frazy = $this -> load -> model('frazy');

            $odpowiedz = array('status' => 1, 'dane' => '');

            // walidacja danych
            if(!$hash) $odpowiedz = array('status' => 0, 'dane' => 'Brak ID klienta');
            else if(!$data) $odpowiedz = array('status' => 0, 'dane' => 'Brak daty');
            else if(!self::sprawdz_date($data)) $odpowiedz = array('status' => 0, 'dane' => 'Błędna data');
            else if(!$klient = $_klienci -> jeden_klient_po_hashu($hash)) $odpowiedz = array('status' => 0, 'dane' => 'Klient nie istnieje');
            else if(!$frazy = $_frazy -> wszystkie($klient['id_klienta'])) $odpowiedz = array('status' => 0, 'dane' => 'Brak fraz');
            else if(!$aktualne_pozycje = $_frazy -> wyniki_na_dzien($data, $klient['id_klienta'])) $odpowiedz = array('status' => 0, 'dane' => 'Brak danych na ten dzień');            

            if($odpowiedz['status']){
                // pobieranie dodatkowych danych
                $wczesniejsze_pozycje = $_frazy -> wyniki_na_dzien(date('Y-m-d', strtotime('-1 day', strtotime($data))), $klient['id_klienta']);
                $aktualne_pierwsze_strony = $_frazy -> pierwsze_strony_na_dzien($data, $klient['id_klienta']);

                $dane = array();
                $i = 0;
                foreach($frazy as $fraza){
                    $aktualna_pozycja = isset($aktualne_pozycje[$fraza['id_frazy']]) ? $aktualne_pozycje[$fraza['id_frazy']] : 0;
                    $poprzednia_pozycja = isset($wczesniejsze_pozycje[$fraza['id_frazy']]) ? $wczesniejsze_pozycje[$fraza['id_frazy']] : 0;
                    $zmiana = $poprzednia_pozycja - $aktualna_pozycja;
                    if(!$poprzednia_pozycja) $zmiana = 0;
                    if($poprzednia_pozycja > 0 && !$aktualna_pozycja) $zmiana = -500;
                    if($poprzednia_pozycja == 0 && $aktualna_pozycja > 0) $zmiana = 500 - $aktualna_pozycja;
                    $tenedencja = $zmiana < 0 ? 0 : 1;
                    $zmiana = str_replace('-', '', $zmiana);
                    $pierwsza_strona = isset($aktualne_pierwsze_strony[$fraza['id_frazy']]) && $aktualne_pierwsze_strony[$fraza['id_frazy']] == '1' ? true : false;
                    $dane[$i]['nazwa'] = $fraza['nazwa'];
                    $dane[$i]['pozycja'] = $aktualna_pozycja;
                    $dane[$i]['zmiana'] = $zmiana ? $zmiana : 0;
                    $dane[$i]['tenedencja'] = $zmiana ? ($tenedencja ? '+' : '-') : 0;
                    $dane[$i]['najlepsza_pozycja'] = ($fraza['najlepsza_pozycja'] ? $fraza['najlepsza_pozycja'] : '-');
                    $dane[$i]['pierwsza_strona'] = $pierwsza_strona ? 1 : 0;
                    $i++;
                }
                $odpowiedz['dane'] = $dane;
            }

            echo json_encode($odpowiedz);
        }


        public function pobierz_odsetek_fraz_na_pierwszej_stronie_na_miesiac($hash = 0, $data = 0){
            // wczytywanie modeli
            $_klienci = $this -> load -> model('klienci');
            $_frazy = $this -> load -> model('frazy');

            $odpowiedz = array('status' => 1, 'dane' => '');

            // walidacja danych
            if(!$hash) $odpowiedz = array('status' => 0, 'dane' => 'Brak ID klienta');
            else if(!$data) $odpowiedz = array('status' => 0, 'dane' => 'Brak daty');
            else if(!self::sprawdz_date($data)) $odpowiedz = array('status' => 0, 'dane' => 'Błędna data');
            else if(!$klient = $_klienci -> jeden_klient_po_hashu($hash)) $odpowiedz = array('status' => 0, 'dane' => 'Klient nie istnieje');

            if($odpowiedz['status']){
                $miesiac = substr($data, 0, -3);
                $odsetek_na_pierwszej_stronie = $_frazy -> odsetek_na_pierwszej_stronie($klient['id_klienta'], $miesiac);                      
                $odpowiedz['dane'] = $odsetek_na_pierwszej_stronie;
            }

            echo json_encode($odpowiedz);
        }
    }

?>