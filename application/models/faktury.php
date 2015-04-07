<?php

    class faktury_model{

        // faktury za wykonane usługi
        public function czy_partner_wykonywal_zlecenia($id_partnera){
    		$dane = $this -> db -> query("SELECT id_faktury
    		                              FROM faktury_vat
    		                              WHERE wykonawca_uslugi_index LIKE '%,$id_partnera,%'
    		                              LIMIT 0,1");
    		return $dane ? 1 : 0;
        }


        public function pobierz_faktury_za_wykonane_zlecenia($id_partnera){
    		$dane = $this -> db -> query("SELECT fv.*, (SELECT sum(wynagrodzenie_wykonawcy_kwota)
    		                                         FROM faktury_vat_pozycje fvp
    		                                         WHERE fv.id_faktury = fvp.id_faktury
    		                                         AND wynagrodzenie_wykonawcy_id_partnera = $id_partnera) as suma_kwot_wynagrodzenia_za_wykonanie
    		                              FROM faktury_vat fv
    		                              WHERE fv.wykonawca_uslugi_index LIKE '%,$id_partnera,%'
    		                              ORDER BY fv.id_faktury DESC");

    		return $dane ? $dane : false;
        }


        // towary i usługi
    	public function wszystkie_towary_i_uslugi(){
    		$tabela = $this -> db -> table('towary_i_uslugi');

    		$dane = $tabela -> select('*')
    		                -> order_by('id_towaru_lub_uslugi', 'ASC')
    		                -> execute();

            return $dane ? $dane : false;
        }


        public function jeden_towar_lub_usluga($id_towaru_lub_uslugi){
    		$tabela = $this -> db -> table('towary_i_uslugi');

    		$dane = $tabela -> select('*')
    		                -> where('id_towaru_lub_uslugi','=',$id_towaru_lub_uslugi)
    		                -> limit(1)
    		                -> execute();

            return $dane ? $dane[0] : false;
        }


        public function zapisz_towar_lub_usluge($id_towaru_lub_uslugi, $jednostka_miary, $nazwa, $pkwiu, $stawka_vat){
    		$tabela = $this -> db -> table('towary_i_uslugi');

            if($id_towaru_lub_uslugi){
            	$tabela -> update(array('jednostka_miary' => $jednostka_miary,
            	                        'nazwa' => $nazwa,
                                        'pkwiu' => $pkwiu,
                                        'stawka_vat' => $stawka_vat))
    	                -> where('id_towaru_lub_uslugi','=',$id_towaru_lub_uslugi)
            	        -> execute();
    	    }else{
            	$tabela -> insert(array('jednostka_miary' => $jednostka_miary,
            	                        'nazwa' => $nazwa,
                                        'pkwiu' => $pkwiu,
                                        'stawka_vat' => $stawka_vat), false);
    	    }

    	    return true;
        }


        public function towary_i_uslugi($dla_selecta = 0){
            $uslugi = self::wszystkie_towary_i_uslugi();

            if(!$dla_selecta){
                $uslugi_2 = array();
                foreach($uslugi as $usluga) $uslugi_2[$usluga['id_towaru_lub_uslugi']] = $usluga['nazwa'];
                $uslugi = $uslugi_2;
            }

            return $uslugi;
        }


        // faktury
        public function lista($uzytkownik){
            $query = 'SELECT * FROM faktury_vat INNER JOIN klienci ON faktury_vat.id_klienta = klienci.id_klienta ';

            $query .= "WHERE ";

            // filtr na stan
            $filtr_stan = $this -> input -> cookie('filtr_faktury_stan');
            $filtr_stan = $this -> db -> clean($filtr_stan);
            if($filtr_stan){
                if($filtr_stan == 'oczekujace') $query .= 'AND faktury_vat.status = "0" AND faktury_vat.termin_zaplaty >= "'.date("Y-m-d").'" ';
                else if($filtr_stan == 'oplacone') $query .= 'AND faktury_vat.status = "1" ';
                else if($filtr_stan == 'nieoplacone') $query .= 'AND faktury_vat.status = "0" AND faktury_vat.termin_zaplaty < "'.date("Y-m-d").'" ';
            }

            // filtr typ
            $filtr_typ = $this -> db -> clean($this -> input -> cookie('filtr_faktury_typ'));
            if($filtr_typ == 'normalne') $query .= 'AND faktury_vat.proforma = "0" ';
            else if($filtr_typ == 'proformy') $query .= 'AND faktury_vat.proforma = "1" ';

            // filtr forma zapłaty
            $filtr_forma_zaplaty = $this -> db -> clean($this -> input -> cookie('filtr_forma_zaplaty'));
            if($filtr_forma_zaplaty) $query .= 'AND faktury_vat.finalna_forma_zaplaty = "'.$filtr_forma_zaplaty.'" ';

            // filtr typ usługi
            $filtr_typ_uslugi = $this -> db -> clean($this -> input -> cookie('filtr_typ_uslugi'));
            if($filtr_typ_uslugi) $query .= 'AND faktury_vat.typ_uslugi_index LIKE "%,'.$filtr_typ_uslugi.',%" ';

            // filtr na datę wystawienia
            $filtr_miesiac = $this -> input -> cookie('filtr_faktury_miesiac');
            $filtr_miesiac = $this -> db -> clean($filtr_miesiac);
            $filtr_rok = $this -> input -> cookie('filtr_faktury_rok');
            $filtr_rok = $this -> db -> clean($filtr_rok);

            $data = '';
            if($filtr_rok) $data .= $filtr_rok;
            if($filtr_miesiac) $data .= '-'.$filtr_miesiac.'-';

            if($data) $query .= 'AND faktury_vat.data_wystawienia LIKE "%'.$data.'%" ';

            // filtr na id klienta
            $filtr_klient = $this -> input -> cookie('filtr_faktury_klient');
            $filtr_klient = $this -> db -> clean($filtr_klient);
            if($filtr_klient) $query .= 'AND faktury_vat.id_klienta = "'.$filtr_klient.'" ';
			
			// filtr na id partner
            $filtr_partner = $this -> input -> cookie('filtr_faktury_partner');
            $filtr_partner = $this -> db -> clean($filtr_partner);
            if($filtr_partner) $query .= 'AND faktury_vat.id_partnera = "'.$filtr_partner.'" ';

            // sortowanie i kierunek
            $filtr_sortowanie = $this -> input -> cookie('filtr_faktury_sortowanie');
            $filtr_sortowanie = $this -> db -> clean($filtr_sortowanie);
            $filtr_kierunek = $this -> input -> cookie('filtr_faktury_kierunek');
            $filtr_kierunek = $this -> db -> clean($filtr_kierunek);

            if(!$filtr_sortowanie) $filtr_sortowanie = 'data_wystawienia';
            if(!$filtr_kierunek) $filtr_kierunek = 'desc';
            if($filtr_sortowanie == 'numer_faktury') $filtr_sortowanie = 'data_wystawienia';

            $query .= 'ORDER BY faktury_vat.'.$filtr_sortowanie.' '.$filtr_kierunek.', faktury_vat.numer_faktury '.$filtr_kierunek.' ';

            $query .= 'END_QUERY';
            $query = str_replace('WHERE AND', 'WHERE', $query);
            $query = str_replace('WHERE ORDER', 'ORDER', $query);
            $query = str_replace(' WHERE END_QUERY', '', $query);
            $query = str_replace(' END_QUERY', '', $query);
            
            //echo $query.'<hr />';

            $wynik = $this -> db -> query($query);

            return $wynik ? $wynik : false;
        }


        public function zbuduj_index_typow_uslug(){
            if(!$faktury = self::wszystkie()) return false;

            foreach($faktury as $faktura){
                $pozycje = self::pozycje_faktury($faktura['id_faktury']);
                if($pozycje){
                    $index = ',';
                    foreach($pozycje as $pozycja){
                        $index .= $pozycja['id_towaru_lub_uslugi'].',';
                    }

            		$tabela = $this -> db -> table('faktury_vat');

                	$tabela -> update(array('typ_uslugi_index' => $index))
        	                -> where('id_faktury','=',$faktura['id_faktury'])
                	        -> execute();
                }
            }
        }


        public function zbuduj_index_wykonawcow_uslug(){
            if(!$faktury = self::wszystkie()) return false;

            foreach($faktury as $faktura){
                $pozycje = self::pozycje_faktury($faktura['id_faktury']);
                if($pozycje){
                    $index = ',';
                    foreach($pozycje as $pozycja){
                        $index .= $pozycja['wynagrodzenie_wykonawcy_id_partnera'].',';
                    }

                    if($index != ','){
                		$tabela = $this -> db -> table('faktury_vat');

                    	$tabela -> update(array('wykonawca_uslugi_index' => $index))
            	                -> where('id_faktury','=',$faktura['id_faktury'])
                    	        -> execute();
                    }
                }
            }
        }


    	public function wszystkie(){
    		$tabela = $this -> db -> table('faktury_vat');

    		$dane = $tabela -> select('*')
                            -> join('klienci')
                            -> on('faktury_vat.id_klienta','=','klienci.id_klienta')
    		                -> order_by('data_wystawienia', 'DESC')
    		                -> order_by('numer_faktury', 'DESC')
    		                -> execute();

            return $dane ? $dane : false;
        }


    	public function wszystkie_dla_klienta($id_klienta){
    		$tabela = $this -> db -> table('faktury_vat');

    		$dane = $tabela -> select('*')
    		                -> where('id_klienta','=', $id_klienta)
    		                -> order_by('data_wystawienia', 'DESC')
    		                -> order_by('numer_faktury', 'DESC')
    		                -> execute();

            return $dane ? $dane : false;
        }


    	public function wszystkie_nieoplacone_dla_klienta($id_klienta){
    		$tabela = $this -> db -> table('faktury_vat');

    		$dane = $tabela -> select('*')
    		                -> where('id_klienta','=', $id_klienta)
    		                -> clause('AND')
    		                -> where('termin_zaplaty','<', date("Y-m-d"))
    		                -> clause('AND')
    		                -> where('status','!=', 1)
    		                -> order_by('data_wystawienia', 'DESC')
    		                -> order_by('numer_faktury', 'DESC')
    		                -> execute();

            return $dane ? $dane : false;
        }


        public function pozycje_faktury($id_faktury){
    		$tabela = $this -> db -> table('faktury_vat_pozycje');

    		$dane = $tabela -> select('*')
    		                -> where('id_faktury','=',$id_faktury)
    		                -> order_by('id_pozycji', 'ASC')
    		                -> execute();

            return $dane ? $dane : false;
        }


    	public function jedna($id_faktury){
    		$tabela = $this -> db -> table('faktury_vat');

    		$faktura = $tabela -> select('*')
    		                   -> where('id_faktury','=',$id_faktury)
    		                   -> limit(1)
    		                   -> execute();

            if(!$faktura) return false;

            $faktura = $faktura[0];
            $faktura['pozycje'] = self::pozycje_faktury($id_faktury);

            return $faktura;
        }


    	public function jedna_po_numerze_faktury($numer_faktury){
            $skladowe = explode('/', $numer_faktury);
            $numer_faktury = $skladowe[0];
            $miesiac = $skladowe[1];
            $rok = $skladowe[2];

            $faktura = $this -> db -> query("SELECT * FROM faktury_vat
                                             WHERE numer_faktury = '$numer_faktury'
                                             AND data_wystawienia LIKE '$rok-$miesiac-%'
                                             LIMIT 0,1");

            return $faktura ? $faktura[0] : false;
        }


        public function utworz_wezwanie_do_zaplaty($data_wezwania, $numery_faktur, $klient){
    		$tabela = $this -> db -> table('faktury_vat_wezwania');

        	$wezwanie = $tabela -> insert(array('adresat_adres' => $klient['faktura_adres'],
                                                'adresat_kod_pocztowy' => $klient['faktura_kod_pocztowy'],
                                                'adresat_miejscowosc' => $klient['faktura_miejscowosc'],
                                                'adresat_nazwa' => $klient['faktura_nazwa'],
                                                'data_wezwania' => $data_wezwania,
                                                'id_klienta' => $klient['id_klienta'],
                                                'miejscowosc_nadania' => INVOICE_COMPANY_ADDRESS_CITY,
                                                'nadawca_adres' => INVOICE_COMPANY_ADDRESS_STREET,
                                                'nadawca_kod_pocztowy' => INVOICE_COMPANY_ADDRESS_POSTAL_CODE,
                                                'nadawca_miejscowosc' => INVOICE_COMPANY_ADDRESS_CITY,
                                                'nadawca_nazwa' => INVOICE_COMPANY_NAME), true);

    		$tabela = $this -> db -> table('faktury_vat_wezwania_pozycje');

            $suma_faktur = 0;
            $suma_zaplaconych = 0;
            $uslugi = self::towary_i_uslugi(0);

            foreach($numery_faktur as $id_faktury){
                // pobieranie danych faktury
                $faktura = self::jedna($id_faktury);

                // wyliczanie zapłaconej części
                $zaplacona_czesc = self::podlicz_sume_dotychczasowych_wplat($faktura['id_faktury']);

                // sumowanie tytułów usług z jednej faktury
                $tytul = '';
                foreach($faktura['pozycje'] as $pozycja){
                    $tytul .= $uslugi[$pozycja['id_towaru_lub_uslugi']].', ';
                }
                $tytul = substr($tytul, 0, -2);

                // zapisz
            	$tabela -> insert(array('calkowita_kwota_faktury' => $faktura['kwota_brutto'],
                                        'data_wystawienia_faktury' => $faktura['data_wystawienia'],
                                        'id_wezwania' => $wezwanie['id_wezwania'],
                                        'ilosc_dni_przeterminowanych' => abs(strtotime($data_wezwania) - strtotime($faktura['termin_zaplaty'])) / (60*60*24),
                                        'numer_faktury' => texts::numer_faktury($faktura),
                                        'termin_zaplaty_faktury' => $faktura['termin_zaplaty'],
                                        'tytul_faktury' => $tytul,
                                        'zaplacona_kwota_faktury' => $zaplacona_czesc), false);
                // sumowanie kwot
                $suma_faktur = $suma_faktur + $faktura['kwota_brutto'];
                $suma_zaplaconych = $suma_zaplaconych + $zaplacona_czesc;
            }

            // zapis kwot
    		$tabela = $this -> db -> table('faktury_vat_wezwania');

        	$tabela -> update(array('kwota_do_zaplaty' => round($suma_faktur, 2),
                                    'pozostala_kwota' => round(($suma_faktur - $suma_zaplaconych), 2),
                                    'wplacona_kwota' => round($suma_zaplaconych, 2)))
	                -> where('id_wezwania','=',$wezwanie['id_wezwania'])
        	        -> execute();
            
            return true;
        }


    	public function wszystkie_wezwania_do_zaplaty(){
    		$tabela = $this -> db -> table('faktury_vat_wezwania');

    		$dane = $tabela -> select('*')
                            //-> join('klienci')
                            //-> on('faktury_vat_wezwania.id_klienta','=','klienci.id_klienta')
    		                -> order_by('data_wezwania', 'DESC')
    		                -> order_by('id_wezwania', 'DESC')
    		                -> execute();

            return $dane ? $dane : false;
        }


    	public function jedno_wezwanie_do_zaplaty($id_wezwania){
    		$tabela = $this -> db -> table('faktury_vat_wezwania');

    		$wezwanie = $tabela -> select('*')
    		                    -> where('id_wezwania','=',$id_wezwania)
    		                    -> limit(1)
    		                    -> execute();

            if(!$wezwanie) return false;

    		$tabela = $this -> db -> table('faktury_vat_wezwania_pozycje');

    		$dane = $tabela -> select('*')
    		                -> where('id_wezwania','=',$id_wezwania)
    		                -> order_by('id_pozycji', 'ASC')
    		                -> execute();

            $pozycje = $dane ? $dane : false;

            $wezwanie = $wezwanie[0];
            $wezwanie['pozycje'] = $pozycje;

            return $wezwanie;
        }


        public function usun_wezwanie_do_zaplaty($id_wezwania){
    		$tabela = $this -> db -> table('faktury_vat_wezwania');

        	$tabela -> delete()
                    -> where('id_wezwania','=',$id_wezwania)
        	        -> execute();

    		$tabela = $this -> db -> table('faktury_vat_wezwania_pozycje');

        	$tabela -> delete()
                    -> where('id_wezwania','=',$id_wezwania)
        	        -> execute();

    	    return true;
        }


        public function zapisz($adnotacje, $data_sprzedazy, $data_wystawienia, $forma_zaplaty, $id_faktury, $id_faktury_zaliczkowej, $id_klienta, $miejsce_sprzedazy, $nabywca_adres, $nabywca_kod_pocztowy, $nabywca_miejscowosc, $nabywca_nazwa, $nabywca_nip, $pozycje, $proforma, $sprzedawca_adres, $sprzedawca_kod_pocztowy, $sprzedawca_miejscowosc, $sprzedawca_nazwa, $sprzedawca_nip, $termin_zaplaty, $zaliczka, $ajdik){
    		$tabela = $this -> db -> table('faktury_vat');

            if($id_faktury){
            	$tabela -> update(array('adnotacje' => $adnotacje,
            	                        'data_sprzedazy' => $data_sprzedazy,
                                        'data_wystawienia' => $data_wystawienia,
                                        'forma_zaplaty' => $forma_zaplaty,
                                        'id_faktury_zaliczkowej' => $id_faktury_zaliczkowej,
                                        'miejsce_sprzedazy' => $miejsce_sprzedazy,
                                        'nabywca_adres' => $nabywca_adres,
                                        'nabywca_kod_pocztowy' => $nabywca_kod_pocztowy,
                                        'nabywca_miejscowosc' => $nabywca_miejscowosc,
                                        'nabywca_nazwa' => $nabywca_nazwa,
                                        'nabywca_nip' => $nabywca_nip,
                                        'sprzedawca_adres' => $sprzedawca_adres,
                                        'sprzedawca_kod_pocztowy' => $sprzedawca_kod_pocztowy,
                                        'sprzedawca_miejscowosc' => $sprzedawca_miejscowosc,
                                        'sprzedawca_nazwa' => $sprzedawca_nazwa,
                                        'sprzedawca_nip' => $sprzedawca_nip,
                                        'termin_zaplaty' => $termin_zaplaty,
                                        'zaliczka' => $zaliczka))
    	                -> where('id_faktury','=',$id_faktury)
            	        -> execute();
    	    }else{
    	        $this -> db -> query('LOCK TABLE faktury_vat WRITE');

    	        if(!self::czy_data_jest_mozliwa($data_wystawienia)) return false;

                $nr = self::wylicz_numer_faktury($data_wystawienia, $proforma);
                $nr_normalna = $proforma ? 0 : $nr;
                $nr_proforma = $proforma ? $nr : 0;

            	$tabela -> insert(array('adnotacje' => $adnotacje,
            	                        'data_sprzedazy' => $data_sprzedazy,
            	                        'data_utworzenia' => date("Y-m-d"),
                                        'data_wystawienia' => $data_wystawienia,
                                        'forma_zaplaty' => $forma_zaplaty,
                                        'id_klienta' => $id_klienta,
                                        'id_faktury_zaliczkowej' => $id_faktury_zaliczkowej,
                                        'miejsce_sprzedazy' => $miejsce_sprzedazy,
                                        'nabywca_adres' => $nabywca_adres,
                                        'nabywca_kod_pocztowy' => $nabywca_kod_pocztowy,
                                        'nabywca_miejscowosc' => $nabywca_miejscowosc,
                                        'nabywca_nazwa' => $nabywca_nazwa,
                                        'nabywca_nip' => $nabywca_nip,
                                        'numer_faktury' => $nr_normalna,
                                        'numer_faktury_proforma' => $nr_proforma,
                                        'proforma' => $proforma,
                                        'sprzedawca_adres' => $sprzedawca_adres,
                                        'sprzedawca_kod_pocztowy' => $sprzedawca_kod_pocztowy,
                                        'sprzedawca_miejscowosc' => $sprzedawca_miejscowosc,
                                        'sprzedawca_nazwa' => $sprzedawca_nazwa,
                                        'sprzedawca_nip' => $sprzedawca_nip,
                                        'termin_zaplaty' => $termin_zaplaty,
                                        'zaliczka' => $zaliczka,
										'id_partnera' => $ajdik), false);

    	        $this -> db -> query('UNLOCK TABLES');

                if($proforma){
            		$faktura = $tabela -> select('id_faktury')
            		                   -> where('numer_faktury_proforma','=',$nr_proforma)
            		                   -> clause('AND')
            		                   -> where('data_sprzedazy','=',$data_sprzedazy)
            		                   -> limit(1)
            		                   -> execute();                    
                }else{
            		$faktura = $tabela -> select('id_faktury')
            		                   -> where('numer_faktury','=',$nr_normalna)
            		                   -> clause('AND')
            		                   -> where('data_sprzedazy','=',$data_sprzedazy)
            		                   -> limit(1)
            		                   -> execute();
                }

                $id_faktury = $faktura ? $faktura[0]['id_faktury'] : false;
    	    }

            // zapis pozycji
            if($id_faktury){
                if($pozycje){
    		        $tabela = $this -> db -> table('faktury_vat_pozycje');
			        $tabela -> delete('id_faktury','=',$id_faktury);

                    // zapis pozycji
                    $kwota_netto = 0;
                    $kwota_podatku = 0;
                    $kwota_brutto = 0;
                    foreach($pozycje as $pozycja){
                        $kwota_netto = $kwota_netto + $pozycja['kwota_netto'];
                        $kwota_podatku = $kwota_podatku + $pozycja['kwota_podatku'];
                        $kwota_brutto = $kwota_brutto + $pozycja['kwota_brutto'];
                    	$tabela -> insert(array('cena_netto' => $pozycja['cena_netto'],
                                                'id_faktury' => $id_faktury,
                                                'id_towaru_lub_uslugi' => $pozycja['id_towaru_lub_uslugi'],
                                                'ilosc' => $pozycja['ilosc'],
                                                'jednostka_miary' => $pozycja['jednostka_miary'],
                                                'kwota_brutto' => $pozycja['kwota_brutto'],
                                                'kwota_netto' => $pozycja['kwota_netto'],
                                                'kwota_podatku' => $pozycja['kwota_podatku'],
                                                'pkwiu' => $pozycja['pkwiu'],
                                                'prowizja_id_partnera_1' => $pozycja['prowizja_id_partnera_1'],
                                                'prowizja_id_partnera_2' => $pozycja['prowizja_id_partnera_2'],
                                                'prowizja_partnera_1' => $pozycja['prowizja_partnera_1'],
                                                'prowizja_partnera_1_prog' => $pozycja['prowizja_partnera_1_prog'],
                                                'prowizja_partnera_2' => $pozycja['prowizja_partnera_2'],
                                                'prowizja_partnera_2_prog' => $pozycja['prowizja_partnera_2_prog'],
                                                'stawka_vat' => $pozycja['stawka_vat'],
                                                'tytul' => $pozycja['tytul'],
                                                'wynagrodzenie_wykonawcy_id_partnera' => $pozycja['wynagrodzenie_wykonawcy_id_partnera'],
                                                'wynagrodzenie_wykonawcy_kwota' => $pozycja['wynagrodzenie_wykonawcy_kwota']), false);
                    }

                    // zapis kwot
    		        $tabela = $this -> db -> table('faktury_vat');

                	$tabela -> update(array('kwota_brutto' => $kwota_brutto,
                                            'kwota_netto' => $kwota_netto,
                                            'kwota_podatku' => $kwota_podatku))
        	                -> where('id_faktury','=',$id_faktury)
                	        -> execute();

                    // budowanie indexu typów usług
                    self::zbuduj_index_typow_uslug();

                    // budowanie indexu wykonawców usług
                    self::zbuduj_index_wykonawcow_uslug();
                }
            }

    	    return $id_faktury;
        }


        public function wylicz_numer_faktury($data_wystawienia, $proforma){
            $data = explode('-', $data_wystawienia);
            $rok_miesiac = $data[0].'-'.$data[1];

            $query = "SELECT numer_faktury";
            $query .= $proforma ? '_proforma' : '';
            $query .= " FROM faktury_vat
                      WHERE data_wystawienia LIKE '$rok_miesiac%'
                      ORDER BY numer_faktury";
            $query .= $proforma ? '_proforma' : '';
            $query .= " DESC LIMIT 0,1";

    		$faktura = $this -> db -> query($query);

            $numer_faktury = $faktura ? ($proforma ? $faktura[0]['numer_faktury_proforma'] : $faktura[0]['numer_faktury']) : '0';
            $numer_faktury++;

            return $numer_faktury;
        }


        public function czy_data_jest_mozliwa($data_wystawienia){
            $data = explode('-', $data_wystawienia);
            $rok_miesiac = $data[0].'-'.$data[1];

    		$data = $this -> db -> query("SELECT data_wystawienia
		                                  FROM faktury_vat
		                                  WHERE data_wystawienia LIKE '$rok_miesiac%'
		                                  ORDER BY data_wystawienia DESC
		                                  LIMIT 0,1");

            $najwyzsza_data = $data ? $data[0]['data_wystawienia'] : $rok_miesiac.'-01';

            return $data_wystawienia >= $najwyzsza_data ? true : false;
        }


        public function czy_faktura_na_pozycjonowanie_juz_jest($id_klienta){
            $poprzedni_miesiac = date("Y-m-d", strtotime("-1 month"));
            $data = explode('-', $poprzedni_miesiac);
            $rok_miesiac = $data[0].'-'.$data[1];

            $wynik = false;

    		$faktury = $this -> db -> query("SELECT id_faktury
		                                     FROM faktury_vat
		                                     WHERE data_wystawienia LIKE '$rok_miesiac%'
		                                     AND id_klienta = '$id_klienta'");

            if($faktury){
                foreach($faktury as $faktura){
                    $f = self::jedna($faktura['id_faktury']);
                    if($f && $f['pozycje']){
                        foreach($f['pozycje'] as $p){
                            if($p['id_towaru_lub_uslugi'] == 1) $wynik = true;
                        }
                    }
                }
            }

            return $wynik;
        }


        public function wylicz_kwote_zobowiazania_za_miesiac_opcja_top_10($data_wystawienia, $id_klienta){
            $_frazy = $this -> load -> model('frazy');
            $klienci = $this -> load -> model('klienci');

            if(!$frazy = $_frazy -> wszystkie($id_klienta)) return false;
            if(!$klient = $klienci -> jeden_klient_po_id($id_klienta)) return false;

            $liczba_dni = date("t", strtotime($data_wystawienia));
            $ryczalt = 0;
            $top = 0;
            $data = explode('-', $data_wystawienia);

            for($i = 1; $i <= $liczba_dni; $i++){
                $dzien = $data[0].'-'.$data[1].'-'.($i < 10 ? '0'.$i : $i);
                $wynik = $_frazy -> wyniki_na_dzien($dzien, $id_klienta);
                //print_r($wynik);
                //echo '<h1>'.$dzien.'</h1>';
                foreach($frazy as $fraza){
                    if($fraza['typ'] == 2){
                        // jeśli jest to fraza ryczałtowa zaznaczyć tylko, że jest choć jedna
                        $ryczalt = 1;
                        //echo '"'.$fraza['nazwa'].'" jest ryczałtowa<hr />';
                    }else{
                        $pozycja = ($wynik && isset($wynik[$fraza['id_frazy']])) ? $wynik[$fraza['id_frazy']] : 0;
                        $koszt = 0;

                        if($pozycja >= $klient['top_10_1_od'] && $pozycja <= $klient['top_10_1_do']) $koszt = $fraza['kwota_za_fraze'];
                        if(($klient['top_10_2_od'] && $klient['top_10_2_do']) && ($pozycja >= $klient['top_10_2_od'] && $pozycja <= $klient['top_10_2_do'])) $koszt = round(($fraza['kwota_za_fraze'] / 3) * 2);
                        if(($klient['top_10_3_od'] && $klient['top_10_3_do']) && ($pozycja >= $klient['top_10_3_od'] && $pozycja <= $klient['top_10_3_do'])) $koszt = round($fraza['kwota_za_fraze'] / 3);
                        
                        //echo '"'.$fraza['nazwa'].'" pozycja: '.$pozycja.', koszt: '.$koszt.'<hr />';
                        $top = $top + $koszt;
                    }
                }
            }
            //echo 'Suma kwot: '.$top.'<hr />';

            // wyznaczenie stałej kwoty ryczałtu
            if($ryczalt) $ryczalt = $klient['kwota_ryczaltu'];

            // podzielnik - tu liczba dni
            $podzielnik = $liczba_dni;

            $data_rozpoczecia = $klient['data_rozpoczecia_pozycjonowania'];
            //$data_rozpoczecia = '2010-05-15';
            $data_rozp = explode('-', $data_rozpoczecia);
            $data_wyst = explode('-', $data_wystawienia);

            // sprawdzam, czy nie wystawiamy faktury za miesiąc w którym rozpoczęliśmy pozycjonowanie
            $czastkowo = $data_rozp[0].$data_rozp[1] == $data_wyst[0].$data_wyst[1] ? 1 : 0;

            // Musimy rozliczyć się cząstkowo
            if($czastkowo){
                $roznica = str_replace('-', '', $data_wystawienia) - str_replace('-', '', $data_rozpoczecia);
                $roznica++;
                $podzielnik = $roznica;
            }
            //echo $podzielnik.'<hr />';
            $realne_top = $top / $liczba_dni;
            $realny_ryczalt = ($ryczalt / $liczba_dni) * $podzielnik;
            $suma = round(($realne_top + $realny_ryczalt), 2);

            return $suma;
        }


        public function wylicz_kwote_zobowiazania_za_miesiac_opcja_pierwsza_strona($data_wystawienia, $id_klienta){
            $_frazy = $this -> load -> model('frazy');
            $klienci = $this -> load -> model('klienci');

            if(!$frazy = $_frazy -> wszystkie($id_klienta)) return false;
            if(!$klient = $klienci -> jeden_klient_po_id($id_klienta)) return false;

            $liczba_dni = date("t", strtotime($data_wystawienia));
            $ryczalt = 0;
            $top = 0;
            $data = explode('-', $data_wystawienia);

            for($i = 1; $i <= $liczba_dni; $i++){
                $dzien = $data[0].'-'.$data[1].'-'.($i < 10 ? '0'.$i : $i);
                $wynik = $_frazy -> pierwsze_strony_na_dzien($dzien, $id_klienta);
                //echo '<pre>';
                //print_r($wynik);
                //echo '<h1>'.$dzien.'</h1>';
                foreach($frazy as $fraza){
                    if($fraza['typ'] == 2){
                        // jeśli jest to fraza ryczałtowa zaznaczyć tylko, że jest choć jedna
                        $ryczalt = 1;
                        //echo '"'.$fraza['nazwa'].'" jest ryczałtowa<hr />';
                    }else{
                        $fraza_na_pierwszej_stronie = ($wynik && isset($wynik[$fraza['id_frazy']])) ? $wynik[$fraza['id_frazy']] : 0;
                        
                        $koszt = 0;
                        if($fraza_na_pierwszej_stronie) $koszt = round(($fraza['kwota_za_fraze'] / 3) * 2);
                        
                        //echo '"'.$fraza['nazwa'].'" na 1 str.: '.$fraza_na_pierwszej_stronie.', koszt: '.$koszt.'<hr />';
                        $top = $top + $koszt;
                    }
                }
            }
            //echo 'Suma kwot: '.$top.'<hr />';

            // wyznaczenie stałej kwoty ryczałtu
            if($ryczalt) $ryczalt = $klient['kwota_ryczaltu'];

            // podzielnik - tu liczba dni
            $podzielnik = $liczba_dni;

            $data_rozpoczecia = $klient['data_rozpoczecia_pozycjonowania'];
            //$data_rozpoczecia = '2010-05-15';
            $data_rozp = explode('-', $data_rozpoczecia);
            $data_wyst = explode('-', $data_wystawienia);

            // sprawdzam, czy nie wystawiamy faktury za miesiąc w którym rozpoczęliśmy pozycjonowanie
            $czastkowo = $data_rozp[0].$data_rozp[1] == $data_wyst[0].$data_wyst[1] ? 1 : 0;

            // Musimy rozliczyć się cząstkowo
            if($czastkowo){
                $roznica = str_replace('-', '', $data_wystawienia) - str_replace('-', '', $data_rozpoczecia);
                $roznica++;
                $podzielnik = $roznica;
            }
            //echo 'Podzielnik: '.$podzielnik.'<hr />';
            $realne_top = $top / $liczba_dni;
            $realny_ryczalt = ($ryczalt / $liczba_dni) * $podzielnik;
            $suma = round(($realne_top + $realny_ryczalt), 2);
            //echo 'Kwota do zapłaty: '.$suma.'<hr />';
            //exit;
            return $suma;
        }


        public function dopisz_wplate_do_historii($data_wplaty, $forma_zaplaty, $id_faktury, $osoba_pobierajaca_gotowke, $wplacona_kwota){
    		$tabela = $this -> db -> table('faktury_vat_wplaty');

        	$tabela -> insert(array('data_wplaty' => $data_wplaty,
        	                        'forma_zaplaty' => $forma_zaplaty,
        	                        'id_faktury' => $id_faktury,
        	                        'osoba_pobierajaca_gotowke' => $osoba_pobierajaca_gotowke,
        	                        'wplacona_kwota' => $wplacona_kwota), false);
            return true;
        }


    	public function pobierz_historie_wplat($id_faktury){
    		$tabela = $this -> db -> table('faktury_vat_wplaty');

    		$dane = $tabela -> select('*')
    		                -> where('id_faktury','=',$id_faktury)
    		                -> order_by('data_wplaty', 'ASC')
    		                -> order_by('id_wplaty', 'ASC')
    		                -> execute();

            return $dane ? $dane : false;
        }


    	public function potwierdz_oplate($data_zaplaty, $finalna_forma_zaplaty, $id_faktury, $osoba_pobierajaca_gotowke, $wplacona_kwota, $nowa_suma){
            $faktura = self::jedna($id_faktury);
            if(!$faktura) return false;
            if($faktura['status'] == '1') return false;

    		$tabela = $this -> db -> table('faktury_vat');

        	$tabela -> update(array('data_zaplaty' => $data_zaplaty,
        	                        'finalna_forma_zaplaty' => $finalna_forma_zaplaty,
        	                        'osoba_pobierajaca_gotowke' => $osoba_pobierajaca_gotowke,
        	                        'status' => 1))
	                -> where('id_faktury','=',$id_faktury)
        	        -> execute();

            self::dopisz_wplate_do_historii($data_zaplaty, $finalna_forma_zaplaty, $id_faktury, $osoba_pobierajaca_gotowke, $wplacona_kwota, $nowa_suma);

            return true;
        }


    	public function potwierdz_oplate_czesciowa($data_zaplaty, $finalna_forma_zaplaty, $id_faktury, $osoba_pobierajaca_gotowke, $wplacona_kwota, $nowa_suma){
            $faktura = self::jedna($id_faktury);
            if(!$faktura) return false;
            if($faktura['status'] == '1') return false;

    		$tabela = $this -> db -> table('faktury_vat');

        	$tabela -> update(array('data_zaplaty' => $data_zaplaty,
        	                        'finalna_forma_zaplaty' => $finalna_forma_zaplaty,
        	                        'osoba_pobierajaca_gotowke' => $osoba_pobierajaca_gotowke,
        	                        'status' => 0,
        	                        'wplacona_kwota' => $nowa_suma))
	                -> where('id_faktury','=',$id_faktury)
        	        -> execute();

            self::dopisz_wplate_do_historii($data_zaplaty, $finalna_forma_zaplaty, $id_faktury, $osoba_pobierajaca_gotowke, $wplacona_kwota, $nowa_suma);

            return true;
        }


        public function podlicz_sume_dotychczasowych_wplat($id_faktury){
    		$suma = $this -> db -> query('SELECT sum(wplacona_kwota) as suma_wplat
    		                              FROM faktury_vat_wplaty
    		                              WHERE id_faktury = '.$id_faktury.'
    		                              LIMIT 0,1');
            return $suma && $suma[0]['suma_wplat'] ? $suma[0]['suma_wplat'] : 0;
        }


        public function nawigacja_do_podgladu($faktura, $id_faktury, $id_faktury){
            $linki = array();

            $miesiac_wystawienia = date('Y-m', strtotime($faktura['data_wystawienia']));
            $nastepny_miesiac_wystawienia = date('Y-m', strtotime('+1 month', strtotime($faktura['data_wystawienia'])));

            // nowsza faktura
            $dane = $this -> db -> query("SELECT id_faktury, id_klienta
                                          FROM faktury_vat
                                          WHERE numer_faktury > ".$faktura['numer_faktury']."
                                          AND data_wystawienia LIKE '$miesiac_wystawienia%'
                                          LIMIT 0,1");

            // jeśli nie ma następnej faktury w tym miesiącu, spróbować znaleźć 1-szą z następnego
            if(!$dane){
                $dane = $this -> db -> query("SELECT id_faktury, id_klienta
                                              FROM faktury_vat
                                              WHERE numer_faktury = 1
                                              AND data_wystawienia >= '$nastepny_miesiac_wystawienia-01'
                                              ORDER BY data_wystawienia ASC
                                              LIMIT 0,1");
            }
            $linki['nastepna_faktura'] = $dane ? $dane[0] : false;

            // starsza faktura
            $dane = $this -> db -> query("SELECT id_faktury, id_klienta
                                          FROM faktury_vat
                                          WHERE numer_faktury < ".$faktura['numer_faktury']."
                                          AND data_wystawienia LIKE '$miesiac_wystawienia%'
                                          LIMIT 0,1");

            // jeśli nie ma następnej faktury w tym miesiącu, spróbować znaleźć ostatnią z poprzedniego
            if(!$dane){
                $dane = $this -> db -> query("SELECT id_faktury, id_klienta
                                              FROM faktury_vat
                                              WHERE data_wystawienia < '$miesiac_wystawienia-01'
                                              ORDER BY data_wystawienia DESC, numer_faktury DESC
                                              LIMIT 0,1");
            }
            $linki['poprzednia_faktura'] = $dane ? $dane[0] : false;

            return $linki;
        }


        public function oznacz_jako_wyslana_mailem($id_faktury){
    		$tabela = $this -> db -> table('faktury_vat');

        	$tabela -> update(array('wyslana_mailem' => 1))
	                -> where('id_faktury','=',$id_faktury)
        	        -> execute();

    	    return true;
        }


        public function oznacz_jako_wyslane_wezwanie_mailowe_1($id_faktury){
    		$tabela = $this -> db -> table('faktury_vat');

        	$tabela -> update(array('wezwanie_mailowe_1' => 1,
        	                        'wezwanie_mailowe_1_data_wyslania' => date("Y-m-d")))
	                -> where('id_faktury','=',$id_faktury)
        	        -> execute();

    	    return true;
        }


        public function oznacz_jako_wyslane_wezwanie_mailowe_2($id_faktury){
    		$tabela = $this -> db -> table('faktury_vat');

        	$tabela -> update(array('wezwanie_mailowe_2' => 1,
        	                        'wezwanie_mailowe_2_data_wyslania' => date("Y-m-d")))
	                -> where('id_faktury','=',$id_faktury)
        	        -> execute();

    	    return true;
        }


        public function lista_faktur_zaliczkowych_dla_klienta($id_klienta){
    		$tabela = $this -> db -> table('faktury_vat');

    		$dane = $tabela -> select('*')
    		                -> where('id_klienta','=', $id_klienta)
    		                -> clause('AND')
    		                -> where('zaliczka','=', 1)
    		                -> order_by('data_wystawienia', 'DESC')
    		                -> order_by('numer_faktury', 'DESC')
    		                -> execute();

            return $dane ? $dane : false;
        }

    }

?>