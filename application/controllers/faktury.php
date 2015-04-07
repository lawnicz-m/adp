<?php

    class controller{

        public function index(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $faktury = $this -> load -> model('faktury') -> wszystkie();

    		$this -> load -> view('faktury', array('faktury' => $faktury,
    		                                       'filtry' => 1,
    		                                       'uzytkownik' => $uzytkownik));
        }


        public function lista($akcja = 0){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $przeladuj = 0;

            // zmienne
            if(isset($_REQUEST['typ'])){
                $przeladuj = 1;
                cookie::set(array(
                  'name' => 'filtr_faktury_typ',
                  'value' => $_REQUEST['typ'],
                  'expire' => '+1 months'
                ));
            }

            if(isset($_REQUEST['stan'])){
                $przeladuj = 1;
                cookie::set(array(
                  'name' => 'filtr_faktury_stan',
                  'value' => $_REQUEST['stan'],
                  'expire' => '+1 months'
                ));
            }

            if(isset($_REQUEST['klient'])){
                $przeladuj = 1;
                cookie::set(array(
                  'name' => 'filtr_faktury_klient',
                  'value' => $_REQUEST['klient'],
                  'expire' => '+1 months'
                ));
            }
			
			if(isset($_REQUEST['partner'])){
                $przeladuj = 1;
                cookie::set(array(
                  'name' => 'filtr_faktury_partner',
                  'value' => $_REQUEST['partner'],
                  'expire' => '+1 months'
                ));
            }

            if(isset($_REQUEST['miesiac'])){
                $przeladuj = 1;
                cookie::set(array(
                  'name' => 'filtr_faktury_miesiac',
                  'value' => $_REQUEST['miesiac'],
                  'expire' => '+1 months'
                ));
            }

            if(isset($_REQUEST['rok'])){
                $przeladuj = 1;
                cookie::set(array(
                  'name' => 'filtr_faktury_rok',
                  'value' => $_REQUEST['rok'],
                  'expire' => '+1 months'
                ));
            }

            if(isset($_REQUEST['sortowanie'])){
                $przeladuj = 1;
                cookie::set(array(
                  'name' => 'filtr_faktury_sortowanie',
                  'value' => $_REQUEST['sortowanie'],
                  'expire' => '+1 months'
                ));
            }

            if(isset($_REQUEST['kierunek'])){
                $przeladuj = 1;
                cookie::set(array(
                  'name' => 'filtr_faktury_kierunek',
                  'value' => $_REQUEST['kierunek'],
                  'expire' => '+1 months'
                ));
            }

            if(isset($_REQUEST['forma_zaplaty'])){
                $przeladuj = 1;
                cookie::set(array(
                  'name' => 'filtr_forma_zaplaty',
                  'value' => $_REQUEST['forma_zaplaty'],
                  'expire' => '+1 months'
                ));
            }

            if(isset($_REQUEST['typ_uslugi'])){
                $przeladuj = 1;
                cookie::set(array(
                  'name' => 'filtr_typ_uslugi',
                  'value' => $_REQUEST['typ_uslugi'],
                  'expire' => '+1 months'
                ));
            }

            if($przeladuj) url::redirect('faktury/lista');

            $faktury = $this -> load -> model('faktury') -> lista($uzytkownik);

    		$this -> load -> view($akcja ? 'faktury_csv' : 'faktury', array('faktury' => $faktury,
    		                                                                'filtry' => 1,
    		                                                                'uzytkownik' => $uzytkownik));
        }


        public function klienta($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $klienci = $this -> load -> model('klienci');
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

            $faktury = $this -> load -> model('faktury') -> wszystkie_dla_klienta($id_klienta);

    		$this -> load -> view('faktury', array('faktury' => $faktury,
    		                                       'klient' => $klient,
    		                                       'uzytkownik' => $uzytkownik));
        }


    	public function form($id_faktury = 0, $id_klienta = 0, $proforma = 0, $id_tasku = 0){
    	    if($id_tasku) print_r(config::get('db'));
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $klienci = $this -> load -> model('klienci');
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

            $faktury = $this -> load -> model('faktury');
            $partnerzy = $this -> load -> model('partnerzy');

            $faktura = $faktury -> jedna($id_faktury);

            // dane wstępne do faktury za pozycjonowanie
            if($this -> input -> get('pozycjonowanie')){
                $poprzedni_miesiac = date("Y-m-d", strtotime("-1 month"));
                $data = explode('-', $poprzedni_miesiac);
                if(!$faktury -> czy_faktura_na_pozycjonowanie_juz_jest($id_klienta) && $klient['etap'] >= 5){
                    $data_sprzedazy = $data_wystawienia = $data[0].'-'.$data[1].'-'.date("t", strtotime($poprzedni_miesiac));
                    $termin_zaplaty = date("Y-m-d", strtotime("+7 days"));

                    // tryb wyliczenia
                    if($this -> input -> get('tryb') == 'top10') $wyliczona_kwota = $faktury -> wylicz_kwote_zobowiazania_za_miesiac_opcja_top_10($data_wystawienia, $id_klienta);
                    else if($this -> input -> get('tryb') == '1str') $wyliczona_kwota = $faktury -> wylicz_kwote_zobowiazania_za_miesiac_opcja_pierwsza_strona($data_wystawienia, $id_klienta);

                    $kwota_netto = $wyliczona_kwota ? $wyliczona_kwota : 0;
                    $faktura['data_sprzedazy'] = $data_sprzedazy;
                    $faktura['data_wystawienia'] = $data_wystawienia;
                    $faktura['termin_zaplaty'] = $termin_zaplaty;

                    $towary_i_uslugi = $this -> load -> model('faktury') -> towary_i_uslugi(1);

                    $faktura['pozycje'][0]['id_towaru_lub_uslugi'] = $towary_i_uslugi[0]['id_towaru_lub_uslugi'];
                    $faktura['pozycje'][0]['jednostka_miary'] = $towary_i_uslugi[0]['jednostka_miary'];
                    $faktura['pozycje'][0]['pkwiu'] = $towary_i_uslugi[0]['pkwiu'];
                    $faktura['pozycje'][0]['cena_netto'] = $kwota_netto;
                    $faktura['pozycje'][0]['ilosc'] = 1;
                    $faktura['pozycje'][0]['kwota_netto'] = $kwota_netto;
                    $faktura['pozycje'][0]['stawka_vat'] = $towary_i_uslugi[0]['stawka_vat'];
                    $faktura['pozycje'][0]['kwota_podatku'] = round($kwota_netto * ($faktura['pozycje'][0]['stawka_vat'] / 100), 2);
                    $faktura['pozycje'][0]['kwota_brutto'] = $kwota_netto + $faktura['pozycje'][0]['kwota_podatku'];
                }else{
                    $this -> session -> set('error', 'Faktura za pozycjonowanie za okres '.$data[0].'-'.$data[1].' została już wystawiona lub z innych powodów nie może być wystawiona');
                }
            }

            // prowizje
            $partner_1 = $partnerzy -> jeden($klient['id_partnera']);
            $faktura['prowizja_id_partnera_1'] = $partner_1 ? $partner_1['id_partnera'] : 0;
            $faktura['prowizja_partnera_1'] = $partner_1 ? $partner_1['prowizja_partnera'] : 0;         
            $faktura['prowizja_partnera_1_prog'] = 9999;

            $partner_2 = $partnerzy -> jeden($klient['id_1_partnera']);
            $faktura['prowizja_id_partnera_2'] = $partner_2 ? $partner_2['id_partnera'] : 0;
				if($partner_1 == $partner_2) $faktura['prowizja_partnera_2'] = 0;
				else if(isset($klient['telemark_5'])) $faktura['prowizja_partnera_2'] = 0;
				else if($klient['kwota_ryczaltu'] == 0) $faktura['prowizja_partnera_2'] = 1;
				else $faktura['prowizja_partnera_2'] = $partner_2 ? $partner_2['prowizja_partnera'] : 0;
            $faktura['prowizja_partnera_2_prog'] = 9999;

            if(!$id_faktury) $faktura['pozycje'][0]['ilosc'] = 1;
		
    		$this -> load -> view('faktury_formularz', array('faktura' => $faktura,
    		                                                 'klient' => $klient,
    		                                                 'proforma' => $proforma,
    		                                                 'uzytkownik' => $uzytkownik));
    	}


        public function wezwanie_do_zaplaty($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            // modele
            $_faktury = $this -> load -> model('faktury');
            $_klienci = $this -> load -> model('klienci');

            // prawa dostępu
            if(!$klient = $_klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            if(!$faktury = $_faktury -> wszystkie_nieoplacone_dla_klienta($id_klienta)) $this -> load -> error('no-access');

            // zmienne
            $data_wezwania = $this -> input -> post('data_wezwania');
            $numery_faktur = $this -> input -> post('faktury');

            // zapis
            if($data_wezwania && $numery_faktur){
                $_faktury -> utworz_wezwanie_do_zaplaty($data_wezwania, $numery_faktur, $klient);

                $this -> session -> set('info', 'Wezwanie do zapłaty zostało utworzone');

                url::redirect('faktury/wezwania-do-zaplaty');
            }

    		$this -> load -> view('faktury_wezwanie_do_zaplaty_wybor_faktur', array('faktury' => $faktury,
    		                                                                        'klient' => $klient,
    		                                                                        'uzytkownik' => $uzytkownik));
        }


        public function wezwania_do_zaplaty(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $wezwania = $this -> load -> model('faktury') -> wszystkie_wezwania_do_zaplaty();

    		$this -> load -> view('faktury_wezwania_do_zaplaty', array('wezwania' => $wezwania,
    		                                                           'uzytkownik' => $uzytkownik));
        }


        public function usun_wezwanie_do_zaplaty($id_wezwania){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $this -> load -> model('faktury') -> usun_wezwanie_do_zaplaty($id_wezwania);

            $this -> session -> set('info', 'Wezwanie zostało usunięte');

            url::redirect('faktury/wezwania-do-zaplaty');
        }


        public function pobierz_wezwanie_do_zaplaty($id_wezwania){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            if(!$wezwanie = $this -> load -> model('faktury') -> jedno_wezwanie_do_zaplaty($id_wezwania)) $this -> load -> error('404');

            require_once('pdf/config/lang/pol.php');
            require_once('pdf/tcpdf.php');

            $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf -> SetCreator(PDF_CREATOR);
            $pdf -> SetAuthor(PDF_COMPANY_NAME);
            $pdf -> SetTitle(PDF_COMPANY_NAME);
            $pdf -> SetSubject(PDF_COMPANY_NAME);
            $pdf -> SetKeywords(PDF_COMPANY_NAME);

            $pdf -> SetHeaderData(PDF_LOGO_SOURCE, PDF_LOGO_SIZE, PDF_HEADER_1_SC, PDF_HEADER_2_SC);

            $pdf -> setHeaderFont(Array('dejavusanscondensed', '', '9'));
            $pdf -> setFooterFont(Array('dejavusanscondensed', '', '9'));

            $pdf -> SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            $pdf -> SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
            $pdf -> SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);

            $pdf -> SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            $pdf -> setImageScale(PDF_IMAGE_SCALE_RATIO);

            $pdf -> SetFont('dejavusanscondensed', '', 9);

            $pdf -> AddPage();

            $html = file_get_contents(url::page('faktury/pobierz-wezwanie/'.$id_wezwania), false);

            $pdf -> writeHTML($html, true, false, true, false, '');

            $pdf -> Output('Wezwanie dla '.$wezwanie['adresat_nazwa'].' z dnia '.$wezwanie['data_wezwania'].'.pdf', 'D');
        }


        public function pobierz_wezwanie($id_wezwania){
            if(!$wezwanie = $this -> load -> model('faktury') -> jedno_wezwanie_do_zaplaty($id_wezwania)) $this -> load -> error('404');
            
    		$this -> load -> view('dokumenty/wezwanie', array('wezwanie' => $wezwanie));
        }


        public function potwierdz_oplate($id_faktury, $id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            // modele
            $faktury = $this -> load -> model('faktury');
            $klienci = $this -> load -> model('klienci');
            $partnerzy = $this -> load -> model('partnerzy');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            if(!$faktura = $faktury -> jedna($id_faktury)) $this -> load -> error('no-access');
            $historia_wplat = $faktury -> pobierz_historie_wplat($id_faktury);
            $suma_dotychczasowych_wplat = $faktury -> podlicz_sume_dotychczasowych_wplat($id_faktury);

    		$this -> load -> view('potwierdz_oplate_faktury', array('faktura' => $faktura,
    		                                                        'historia_wplat' => $historia_wplat,
    		                                                        'klient' => $klient,
    		                                                        'suma_dotychczasowych_wplat' => $suma_dotychczasowych_wplat,
    		                                                        'uzytkownik' => $uzytkownik));
        }


        public function historia_wplat($id_faktury, $id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            // modele
            $faktury = $this -> load -> model('faktury');
            $klienci = $this -> load -> model('klienci');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            if(!$faktura = $faktury -> jedna($id_faktury)) $this -> load -> error('no-access');
            $historia_wplat = $faktury -> pobierz_historie_wplat($id_faktury);
            $suma_dotychczasowych_wplat = $faktury -> podlicz_sume_dotychczasowych_wplat($id_faktury);

    		$this -> load -> view('faktury_historia_wplat', array('faktura' => $faktura,
    		                                                      'historia_wplat' => $historia_wplat,
    		                                                      'klient' => $klient,
    		                                                      'suma_dotychczasowych_wplat' => $suma_dotychczasowych_wplat,
    		                                                      'uzytkownik' => $uzytkownik));
        }


        public function potwierdz_oplate_2($id_faktury, $id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            // modele
            $faktury = $this -> load -> model('faktury');
            $klienci = $this -> load -> model('klienci');
            $partnerzy = $this -> load -> model('partnerzy');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            if(!$faktura = $faktury -> jedna($id_faktury)) $this -> load -> error('no-access');

            // zmienne
            $data_zaplaty = $this -> input -> post('data_zaplaty');
            $finalna_forma_zaplaty = $this -> input -> post('finalna_forma_zaplaty');
            $osoba_pobierajaca_gotowke = $this -> input -> post('osoba_pobierajaca_gotowke');
            $wplacona_kwota = $this -> input -> post('wplacona_kwota');

            $suma_dotychczasowych_wplat = $faktury -> podlicz_sume_dotychczasowych_wplat($id_faktury);
            $nowa_suma = $suma_dotychczasowych_wplat + $wplacona_kwota;

            if($nowa_suma < $faktura['kwota_brutto']){
                $faktury -> potwierdz_oplate_czesciowa($data_zaplaty, $finalna_forma_zaplaty, $id_faktury, $osoba_pobierajaca_gotowke, $wplacona_kwota, $nowa_suma);
            }else if($nowa_suma == $faktura['kwota_brutto']){
                $faktury -> potwierdz_oplate($data_zaplaty, $finalna_forma_zaplaty, $id_faktury, $osoba_pobierajaca_gotowke, $wplacona_kwota, $nowa_suma);
            }else if($nowa_suma > $faktura['kwota_brutto']){
                $this -> session -> set('error', 'Wpisana kwota samodzielnie lub po zsumowniu przewyższa kwotę wymaganą do całkowitego spłacenia faktury. Sprawdź ponownie kwotę.');
                url::redirect('faktury/potwierdz-oplate/'.$id_faktury.'/'.$id_klienta);
                exit;
            }

            // konieczne ponowne wczytanie faktury do sprawdzenia nowego statusu
            $faktura = $faktury -> jedna($id_faktury);

            if($faktura['status']){
                $dokument = texts::numer_faktury($faktura);

                // notatka w historii relacji
                $klienci -> zapisz_notatke(date("Y-m-d"), $faktura['id_klienta'], 'Odnotowano wpłatę za fakturę VAT, numer '.$dokument);

                if($faktura['pozycje'] && !$faktura['zaliczka'] && !$faktura['proforma']){
                    $i = 1; foreach($faktura['pozycje'] as $pozycja){
                        //echo 'Usluga '.$i.'<br />'; $i++;

                        if($pozycja['prowizja_id_partnera_1'] && $pozycja['prowizja_partnera_1']){
						$telemarek = 0;
						$prow = $pozycja['prowizja_partnera_1'];
						if($klient['umowa_czas_okreslony_od'] > '2013-12-30'){
							if($pozycja['prowizja_partnera_1'] != 7 && $pozycja['prowizja_partnera_1'] != 10 && $pozycja['prowizja_partnera_1'] != 20){
								if ($klient['kwota_ryczaltu'] > 0){
									if($klient['kwota_ryczaltu'] < 600) $prow = 5;
									else if($klient['kwota_ryczaltu'] < 700) $prow = 6;
									else if($klient['kwota_ryczaltu'] < 800) $prow = 7;
									else if($klient['kwota_ryczaltu'] < 900) $prow = 8;
									else if($klient['kwota_ryczaltu'] < 1000) $prow = 9;
									else $prow = 10;
								}else{
									if($klient['kwota_ryczaltu'] < 600) $prow = 5;
									else if($klient['kwota_ryczaltu'] < 700) $prow = 5.5;
									else if($klient['kwota_ryczaltu'] < 800) $prow = 6;
									else if($klient['kwota_ryczaltu'] < 900) $prow = 6.5;
									else if($klient['kwota_ryczaltu'] < 1000) $prow = 7;
									else $prow = 7.5;
								}
							}
						}
							$wplata = $partnerzy -> zwieksz_saldo($pozycja['prowizja_id_partnera_1'], $pozycja['kwota_netto'], $dokument, $prow, $telemarek, $klient['id_klienta']);

                            $partner = $partnerzy -> jeden($pozycja['prowizja_id_partnera_1']);
                            $email = new email();
                            $email -> to($partner['mail']);
                            $email -> from(BASE_MAIL);
                            $email -> subject(iconv("UTF-8","ISO-8859-2",E_MAIL_TITLE_COMPANY_NAME.' | Saldo zostało zwiększone'));
                            $email -> content(iconv("UTF-8","ISO-8859-2",'Na podstawie faktury '.$dokument.' opłaconej przez '.$klient['nazwa'].', Twoje saldo zostało zwiększone o '.$wplata.' PLN i wynosi aktualnie '.$partner['saldo'].' PLN.'));
                            $email -> send();
							
							
                        }

                        if($pozycja['prowizja_id_partnera_2'] && $pozycja['prowizja_partnera_2'] != 1){
							
                            $telemarek = 0;
							$prow = $pozycja['prowizja_partnera_2'];
							if($pozycja['prowizja_partnera_2'] == 5 && $pozycja['kwota_netto'] >= $klient['kwota_ryczaltu']){
							
							$telemarek = 1;
							$wplata = $partnerzy -> zwieksz_saldo($pozycja['prowizja_id_partnera_2'], $pozycja['kwota_netto'], $dokument, $prow, $telemarek, $klient['id_klienta']);
                            $partner = $partnerzy -> jeden($pozycja['prowizja_id_partnera_2']);
                            $email = new email();
                            $email -> to($partner['mail']);
                            $email -> from(BASE_MAIL);
                            $email -> subject(iconv("UTF-8","ISO-8859-2",E_MAIL_TITLE_COMPANY_NAME.' | Saldo zostało zwiększone'));
                            $email -> content(iconv("UTF-8","ISO-8859-2",'Na podstawie faktury '.$dokument.' opłaconej przez '.$klient['nazwa'].', Twoje saldo zostało zwiększone o '.$wplata.' PLN i wynosi aktualnie '.$partner['saldo'].' PLN.'));
                            $email -> send();
							}
							
                        }else if($pozycja['prowizja_id_partnera_2'] && $pozycja['prowizja_partnera_2'] == 1){
							
                            $telemarek = 0;
							$prow = $pozycja['prowizja_partnera_2'];
														
							$wplata = $partnerzy -> zwieksz_saldo($pozycja['prowizja_id_partnera_2'], $pozycja['kwota_netto'], $dokument, $prow, $telemarek, $klient['id_klienta']);
                            $partner = $partnerzy -> jeden($pozycja['prowizja_id_partnera_2']);
                            $email = new email();
                            $email -> to($partner['mail']);
                            $email -> from(BASE_MAIL);
                            $email -> subject(iconv("UTF-8","ISO-8859-2",E_MAIL_TITLE_COMPANY_NAME.' | Saldo zostało zwiększone'));
                            $email -> content(iconv("UTF-8","ISO-8859-2",'Na podstawie faktury '.$dokument.' opłaconej przez '.$klient['nazwa'].', Twoje saldo zostało zwiększone o '.$wplata.' PLN i wynosi aktualnie '.$partner['saldo'].' PLN.'));
                            $email -> send();
                        }
					

                        if($pozycja['wynagrodzenie_wykonawcy_id_partnera'] && $pozycja['wynagrodzenie_wykonawcy_kwota'] != '0.00'){
                            //echo 'Wykonawca: '.$pozycja['wynagrodzenie_wykonawcy_id_partnera'].', kwota: '.$pozycja['wynagrodzenie_wykonawcy_kwota'].'<br />';

                            $wplata = $partnerzy -> zwieksz_saldo_o_wynagrodzenie($pozycja['wynagrodzenie_wykonawcy_id_partnera'], $pozycja['wynagrodzenie_wykonawcy_kwota'], $dokument);

                            $partner = $partnerzy -> jeden($pozycja['wynagrodzenie_wykonawcy_id_partnera']);
                            $email = new email();
                            $email -> to($partner['mail']);
                            $email -> from(BASE_MAIL);
                            $email -> subject(iconv("UTF-8","ISO-8859-2",E_MAIL_TITLE_COMPANY_NAME.' | Saldo zostało zwiększone'));
                            $email -> content(iconv("UTF-8","ISO-8859-2",'Na podstawie faktury '.$dokument.' opłaconej przez '.$klient['nazwa'].', Twoje saldo zostało zwiększone o '.$wplata.' PLN i wynosi aktualnie '.$partner['saldo'].' PLN.'));
                            $email -> send();
                        }

                        //echo '<hr />';
                    }
                }
                
                $this -> session -> set('info', 'Faktura została oznaczona jako opłacona');
            }else{
                $this -> session -> set('info', 'Faktura została oznaczona jako opłacona częściowo');
            }

            url::redirect('faktury/klienta/'.$id_klienta);
        }


    	public function zapisz($id_faktury, $id_klienta, $proforma = 0){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            // modele
            $faktury = $this -> load -> model('faktury');
            $klienci = $this -> load -> model('klienci');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

            // zmienne
            $adnotacje = $this -> input -> post('adnotacje');
            $cena_netto = $this -> input -> post('cena_netto');
            $data_sprzedazy = $this -> input -> post('data_sprzedazy');
            $data_wystawienia = $this -> input -> post('data_wystawienia');
            $forma_zaplaty = $this -> input -> post('forma_zaplaty');
            $id_faktury_zaliczkowej = $this -> input -> post('id_faktury_zaliczkowej');
            $id_towaru_lub_uslugi = $this -> input -> post('id_towaru_lub_uslugi');
            $ilosc = $this -> input -> post('ilosc');
            $jednostka_miary = $this -> input -> post('jednostka_miary');
            $kwota_brutto = $this -> input -> post('kwota_brutto');
            $kwota_netto = $this -> input -> post('kwota_netto');
            $kwota_podatku = $this -> input -> post('kwota_podatku');
            $miejsce_sprzedazy = $this -> input -> post('miejsce_sprzedazy');
            $nabywca_adres = $this -> input -> post('nabywca_adres');
            $nabywca_kod_pocztowy = $this -> input -> post('nabywca_kod_pocztowy');
            $nabywca_miejscowosc = $this -> input -> post('nabywca_miejscowosc');
            $nabywca_nazwa = $this -> input -> post('nabywca_nazwa');
            $nabywca_nip = $this -> input -> post('nabywca_nip');
            $pkwiu = $this -> input -> post('pkwiu');
            $prowizja_id_partnera_1 = $this -> input -> post('prowizja_id_partnera_1');
            $prowizja_id_partnera_2 = $this -> input -> post('prowizja_id_partnera_2');
            $prowizja_partnera_1 = $this -> input -> post('prowizja_partnera_1');
            $prowizja_partnera_1_prog = $this -> input -> post('prowizja_partnera_1_prog');
            $prowizja_partnera_2 = $this -> input -> post('prowizja_partnera_2');
            $prowizja_partnera_2_prog = $this -> input -> post('prowizja_partnera_2_prog');
            $sprzedawca_adres = $this -> input -> post('sprzedawca_adres');
            $sprzedawca_kod_pocztowy = $this -> input -> post('sprzedawca_kod_pocztowy');
            $sprzedawca_miejscowosc = $this -> input -> post('sprzedawca_miejscowosc');
            $sprzedawca_nazwa = $this -> input -> post('sprzedawca_nazwa');
            $sprzedawca_nip = $this -> input -> post('sprzedawca_nip');
            $stawka_vat = $this -> input -> post('stawka_vat');
            $termin_zaplaty = $this -> input -> post('termin_zaplaty');
            $tytul = $this -> input -> post('tytul');
            $zaliczka = $this -> input -> post('zaliczka');
			$ajdik = $klient['id_partnera'];
            $wynagrodzenie_wykonawcy_id_partnera = $this -> input -> post('wynagrodzenie_wykonawcy_id_partnera');
            $wynagrodzenie_wykonawcy_kwota = $this -> input -> post('wynagrodzenie_wykonawcy_kwota');

            // wybieramy dane faktury zaliczkowej jeśli jest określona
            $faktura_zaliczkowa = $id_faktury_zaliczkowej ? $faktury -> jedna($id_faktury_zaliczkowej) : false;

            if($id_faktury) $faktura = $faktury -> jedna($id_faktury);
            else $faktura = false;

            // walidacja
            if(!$cena_netto || !$data_sprzedazy || !$data_wystawienia || !$forma_zaplaty || !$id_towaru_lub_uslugi || !$ilosc || !$jednostka_miary || !$kwota_brutto || !$kwota_netto || !$kwota_podatku || !$miejsce_sprzedazy || !$nabywca_adres || !$nabywca_kod_pocztowy || !$nabywca_miejscowosc || !$nabywca_nazwa || !$nabywca_nip || !$pkwiu || !$sprzedawca_adres || !$sprzedawca_kod_pocztowy || !$sprzedawca_miejscowosc || !$sprzedawca_nazwa || !$sprzedawca_nip || !$stawka_vat || !$termin_zaplaty) $this -> session -> set('error', 1);
            else if($data_wystawienia > date("Y-m-d")) $this -> session -> set('error', 'Data wystawienia faktury nie może być dalsza niż data dzisiejsza');
            else if(!$faktury -> czy_data_jest_mozliwa($data_wystawienia) && $faktura['data_wystawienia'] != $data_wystawienia) $this -> session -> set('error', 'Data wystawienia faktury nie może być już użyta. Proszę zaznaczyć dzisiejszą datę lub wyższą niż wcześniej proponowana.');
            else if($termin_zaplaty < $data_wystawienia) $this -> session -> set('error', 'Termin zapłaty nie może stanowić daty wcześniejszej niż data wystawienia faktury');
            else if($faktura_zaliczkowa && $faktura_zaliczkowa['status'] != 1) $this -> session -> set('error', 'Nie można wystawić faktury końcowej, ponieważ faktura zaliczkowa do której się odnosi nie została opłacona');

            $ilosc_uslug = count($id_towaru_lub_uslugi) - 1;
            $pozycje = array();
            for($i = 0; $i <= $ilosc_uslug; $i++){
                $pozycje[$i]['cena_netto'] = $cena_netto[$i];
                $pozycje[$i]['id_towaru_lub_uslugi'] = $id_towaru_lub_uslugi[$i];
                $pozycje[$i]['ilosc'] = $ilosc[$i];
                $pozycje[$i]['jednostka_miary'] = $jednostka_miary[$i];
                $pozycje[$i]['kwota_brutto'] = $kwota_brutto[$i];
                $pozycje[$i]['kwota_netto'] = $kwota_netto[$i];
                $pozycje[$i]['kwota_podatku'] = $kwota_podatku[$i];
                $pozycje[$i]['pkwiu'] = $pkwiu[$i];
                $pozycje[$i]['prowizja_id_partnera_1'] = $prowizja_id_partnera_1[$i];
                $pozycje[$i]['prowizja_id_partnera_2'] = $prowizja_id_partnera_2[$i];
                $pozycje[$i]['prowizja_partnera_1'] = $prowizja_partnera_1[$i];
                $pozycje[$i]['prowizja_partnera_1_prog'] = $prowizja_partnera_1_prog[$i];
                $pozycje[$i]['prowizja_partnera_2'] = $prowizja_partnera_2[$i];
                $pozycje[$i]['prowizja_partnera_2_prog'] = $prowizja_partnera_2_prog[$i];
                $pozycje[$i]['stawka_vat'] = $stawka_vat[$i];
                $pozycje[$i]['tytul'] = $tytul[$i];
                $pozycje[$i]['wynagrodzenie_wykonawcy_id_partnera'] = $wynagrodzenie_wykonawcy_id_partnera[$i];
                $pozycje[$i]['wynagrodzenie_wykonawcy_kwota'] = $wynagrodzenie_wykonawcy_kwota[$i];
            }

            if($this -> session -> get('error')){
    		    $this -> load -> view('faktury_formularz', array('faktura' => array('adnotacje' => $adnotacje,
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
    		                                                                        'pozycje' => $pozycje,
    		                                                                        'sprzedawca_adres' => $sprzedawca_adres,
    		                                                                        'sprzedawca_kod_pocztowy' => $sprzedawca_kod_pocztowy,
    		                                                                        'sprzedawca_miejscowosc' => $sprzedawca_miejscowosc,
    		                                                                        'sprzedawca_nazwa' => $sprzedawca_nazwa,
    		                                                                        'sprzedawca_nip' => $sprzedawca_nip,
    		                                                                        'termin_zaplaty' => $termin_zaplaty,
    		                                                                        'zaliczka' => $zaliczka),
    		                                                     'klient' => $klient,
    		                                                     'proforma' => $proforma,
    		                                                     'uzytkownik' => $uzytkownik));
    		    exit;
            }

            if($id_utworzonej_faktury = $faktury -> zapisz($adnotacje, $data_sprzedazy, $data_wystawienia, $forma_zaplaty, $id_faktury, $id_faktury_zaliczkowej, $id_klienta, $miejsce_sprzedazy, $nabywca_adres, $nabywca_kod_pocztowy, $nabywca_miejscowosc, $nabywca_nazwa, $nabywca_nip, $pozycje, $proforma, $sprzedawca_adres, $sprzedawca_kod_pocztowy, $sprzedawca_miejscowosc, $sprzedawca_nazwa, $sprzedawca_nip, $termin_zaplaty, $zaliczka, $ajdik)){

                // wpisanie do historii faktury opłaty częściowej z racji faktury zaliczkowej
                if(!$id_faktury && $faktura_zaliczkowa){
                    $faktury -> potwierdz_oplate_czesciowa($faktura_zaliczkowa['data_zaplaty'], $faktura_zaliczkowa['finalna_forma_zaplaty'], $id_utworzonej_faktury, $faktura_zaliczkowa['osoba_pobierajaca_gotowke'], $faktura_zaliczkowa['kwota_brutto'], $faktura_zaliczkowa['kwota_brutto']);
                }

                if($id_faktury) $this -> session -> set('info', 'Faktura została zapisana');
                else $this -> session -> set('info', 'Faktura została utworzona');
                if($this -> input -> post('redirectBack')) url::redirect('faktury/form/'.$id_faktury.'/'.$id_klienta);
                else url::redirect('faktury/klienta/'.$id_klienta);
            }else{
                $this -> session -> set('error', 'Wystąpił nieoczekiwany błąd. Faktura nie została zapisana.');
                url::redirect('faktury/klienta/'.$id_klienta);
            }

    	}


        public function pobierz($id_faktury, $typ, $kwota_kor, $numer_kor){
            $faktury = $this -> load -> model('faktury');

            $faktura = $faktury -> jedna($id_faktury);
            if($faktura['id_faktury_zaliczkowej']) $faktura_zaliczkowa = $faktury -> jedna($faktura['id_faktury_zaliczkowej']);
			if ($typ == 'korygujaca'){
			$this -> load -> view('dokumenty/faktura_korygujaca', array('faktura' => $faktura,
																		'faktura_zaliczkowa' => isset($faktura_zaliczkowa) ? $faktura_zaliczkowa : false,
																		'typ' => $typ,
																		'kwota_kor' => $kwota_kor,
																		'numer_kor' => $numer_kor));
															 }else{
    		$this -> load -> view('dokumenty/faktura', array('faktura' => $faktura,
    		                                                 'faktura_zaliczkowa' => isset($faktura_zaliczkowa) ? $faktura_zaliczkowa : false,
    		                                                 'typ' => $typ));}
        }
		
		public function pobierz_adresowke($id_klienta){
            $klient = $this -> load -> model('klienci') -> jeden_klient_po_id($id_klienta);

    		$this -> load -> view('dokumenty/faktura_adresowka', array('klient' => $klient));
        }


        public function pobierz_pdf($id_faktury, $typ = 'oryginal'){
            if(!$faktura = $this -> load -> model('faktury') -> jedna($id_faktury)) $this -> load -> error('404');
            if(!$klient = $this -> load -> model('klienci') -> jeden_klient_po_id($faktura['id_klienta'])) $this -> load -> error('404');
			$kwota_kor = $this -> input -> post('kwota_kor');
			$numer_kor = $this -> input -> post('numer_kor');
            require_once('pdf/config/lang/pol.php');
            require_once('pdf/tcpdf.php');

            $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf -> SetCreator(PDF_CREATOR);
            $pdf -> SetAuthor(PDF_COMPANY_NAME);
            $pdf -> SetTitle(PDF_COMPANY_NAME);
            $pdf -> SetSubject(PDF_COMPANY_NAME);
            $pdf -> SetKeywords(PDF_COMPANY_NAME);

            $pdf -> SetHeaderData(PDF_LOGO_SOURCE, PDF_LOGO_SIZE, PDF_HEADER_1_SC, PDF_HEADER_2_SC);

            $pdf -> setHeaderFont(Array('dejavusanscondensed', '', '9'));
            $pdf -> setFooterFont(Array('dejavusanscondensed', '', '9'));

            $pdf -> SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            $pdf -> SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
            $pdf -> SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);

            $pdf -> SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            $pdf -> setImageScale(PDF_IMAGE_SCALE_RATIO);

            $pdf -> SetFont('dejavusanscondensed', '', 9);

            $pdf -> AddPage();

            $html = file_get_contents(url::page('faktury/pobierz/'.$faktura['id_faktury'].'/'.$typ.'/'.$kwota_kor.'/'.$numer_kor), false);

            $pdf -> writeHTML($html, true, false, true, false, '');

            /* adres korespondencyjny do koperty
            if($typ == 'oryginal' || $typ == 'duplikat'){
                $pdf -> AddPage();

                $html = file_get_contents(url::page('faktury/pobierz_adresowke/'.$faktura['id_klienta']), false);

                $pdf -> writeHTML($html, true, false, true, false, '');
            }*/

            $pdf -> Output(base::nazwa_faktury_pdf(texts::numer_faktury($faktura), $klient['nazwa'], $typ), 'D');

        }


        public function podglad($id_faktury, $id_klienta, $typ = 'podglad'){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $klienci = $this -> load -> model('klienci');
            $klient = $klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);
            if(!$klient) $this -> load -> error('no-access');

            $faktury = $this -> load -> model('faktury');
            if(!$faktura = $faktury -> jedna($id_faktury)) $this -> load -> error('no-access');

            if($faktura['id_faktury_zaliczkowej']) $faktura_zaliczkowa = $faktury -> jedna($faktura['id_faktury_zaliczkowej']);

            // następne i poprzednie faktury
            $linki = $uzytkownik['typ'] == 'admin' ? $faktury -> nawigacja_do_podgladu($faktura, $id_faktury, $id_faktury) : false;

    		$this -> load -> view('faktury_podglad', array('faktura' => $faktura,
    		                                               'faktura_zaliczkowa' => isset($faktura_zaliczkowa) ? $faktura_zaliczkowa : false,
    		                                               'linki' => $linki,
    		                                               'klient' => $klient,
    		                                               'typ' => $typ,
    		                                               'uzytkownik' => $uzytkownik));
        }


        public function wyslij_oryginal_do_klienta($id_faktury, $typ = 'wystawienie'){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $faktury = $this -> load -> model('faktury');
            if(!$faktura = $faktury -> jedna($id_faktury)) $this -> load -> error('no-access');

            $klienci = $this -> load -> model('klienci');
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $faktura['id_klienta'], $uzytkownik['typ'])) $this -> load -> error('no-access');

            require_once('pdf/config/lang/pol.php');
            require_once('pdf/tcpdf.php');

            $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf -> SetCreator(PDF_CREATOR);
            $pdf -> SetAuthor(PDF_COMPANY_NAME);
            $pdf -> SetTitle(PDF_COMPANY_NAME);
            $pdf -> SetSubject(PDF_COMPANY_NAME);
            $pdf -> SetKeywords(PDF_COMPANY_NAME);

            $pdf -> SetHeaderData(PDF_LOGO_SOURCE, PDF_LOGO_SIZE, PDF_HEADER_1_SC, PDF_HEADER_2_SC);

            $pdf -> setHeaderFont(Array('dejavusanscondensed', '', '9'));
            $pdf -> setFooterFont(Array('dejavusanscondensed', '', '9'));

            $pdf -> SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            $pdf -> SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
            $pdf -> SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);

            $pdf -> SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            $pdf -> setImageScale(PDF_IMAGE_SCALE_RATIO);

            $pdf -> SetFont('dejavusanscondensed', '', 9);

            $pdf -> AddPage();

            $html = file_get_contents(url::page('faktury/pobierz/'.$faktura['id_faktury'].'/oryginal'), false);

            $pdf -> writeHTML($html, true, false, true, false, '');

            base::check_if_folder_exists('pliki');
            base::check_if_folder_exists('pliki/pdf');

            $plik = 'pliki/pdf/'.md5($faktura['id_faktury'].$faktura['id_klienta'].time()).'.pdf';

            $pdf -> Output($plik, 'F');

            $email = new email();
            $email -> to($klient['mail']);
            $email -> from(BASE_MAIL);

            $faktura_kwota = str_replace('.00', '', number_format($faktura['kwota_brutto'], 2, '.', ' '));
            $faktura_numer = texts::numer_faktury($faktura);
            $faktura_termin = texts::nice_date($faktura['termin_zaplaty']);
            $faktura_data_wystawienia = texts::nice_date($faktura['data_wystawienia']);

         if($typ == 'wystawienie'){
                $email -> subject(iconv("UTF-8", "ISO-8859-2", E_MAIL_TITLE_COMPANY_NAME.' | Faktura VAT numer '.$faktura_numer.' dla '.$klient['nazwa']));
                $email -> content(iconv("UTF-8", "ISO-8859-2", 'Szanowni Państwo,<br /><br />W załączniku znajdą Państwo fakturę VAT numer '.$faktura_numer.' wystawioną na kwotę '.$faktura_kwota.' PLN.<br />Termin zapłaty mija dnia '.$faktura_termin.'.<br /><br />Wszelkie szczegóły dotyczące należności znajdą Państwo na załączonej fakturze.<br /><br />Dziękujemy za terminowe wpłaty.<br /><br />'.E_MAIL_FOOTER));

                // notatka w historii relacji
                $klienci -> zapisz_notatke(date("Y-m-d"), $faktura['id_klienta'], 'Wysłano elektroniczną wersję faktury VAT, numer '.$faktura_numer);
            }

            if($typ == 'wezwanie'){
                $email -> subject(iconv("UTF-8", "ISO-8859-2", E_MAIL_TITLE_COMPANY_NAME.' | Wezwanie do zapłaty faktury VAT numer '.$faktura_numer));
                $email -> content(iconv("UTF-8", "ISO-8859-2", '<h1 align="center" style="text-align: center;">WEZWANIE DO ZAPŁATY</h1>Informujemy, że minął termin płatności kwoty '.$faktura_kwota.' PLN wynikającej z faktury VAT nr '.$faktura_numer.' z dnia '.$faktura_data_wystawienia.' r.<br /><br />Zgodnie z ww. fakturą VAT termin zapłaty minął w dniu '.$faktura_termin.' r.<br /><br />Prosimy o jak najszybsze dokonanie płatności na konto ING 42 1050 1575 1000 0023 2143 7036.<br /><br />Jeżeli dokonali Państwo płatności przed otrzymaniem tego wezwania prosimy potraktować je jako nieaktualne.<br /><br />'.E_MAIL_FOOTER));

                // notatka w historii relacji
                $klienci -> zapisz_notatke(date("Y-m-d"), $faktura['id_klienta'], 'Wysłano pierwsze wezwanie do zapłaty faktury VAT, numer '.$faktura_numer);
            }

            if($typ == 'wezwanie_powtorne'){
                $email -> subject(iconv("UTF-8", "ISO-8859-2", E_MAIL_TITLE_COMPANY_NAME.' | Powtórne wezwanie do zapłaty faktury VAT numer '.$faktura_numer));
                $email -> content(iconv("UTF-8", "ISO-8859-2", '<h1 align="center" style="text-align: center;">POWTÓRNE WEZWANIE DO ZAPŁATY</h1>Informujemy, że minął termin płatności kwoty '.$faktura_kwota.' PLN wynikającej z faktury VAT nr '.$faktura_numer.' z dnia '.$faktura_data_wystawienia.' r.<br /><br />Zgodnie z ww. fakturą VAT termin zapłaty minął w dniu '.$faktura_termin.' r.<br /><br />Wzywamy do natychmiastowego uregulwoania zadłużenia na konto ING 42 1050 1575 1000 0023 2143 7036.<br /><br />Jeżeli dokonali Państwo płatności przed otrzymaniem tego wezwania prosimy potraktować je jako nieaktualne.<br /><br />'.E_MAIL_FOOTER));

                // notatka w historii relacji
                $klienci -> zapisz_notatke(date("Y-m-d"), $faktura['id_klienta'], 'Wysłano powtórne wezwanie do zapłaty faktury VAT, numer '.$faktura_numer);
            }

            if($typ == 'wystawienie'){$email -> attachment($plik, 'application/octet-stream', base::nazwa_faktury_pdf($faktura_numer, $klient['nazwa'], 'oryginal'));}
            $email -> send();

            unlink($plik);

            if($typ == 'wystawienie') $faktury -> oznacz_jako_wyslana_mailem($id_faktury);
            if($typ == 'wezwanie') $faktury -> oznacz_jako_wyslane_wezwanie_mailowe_1($id_faktury);
            if($typ == 'wezwanie_powtorne') $faktury -> oznacz_jako_wyslane_wezwanie_mailowe_2($id_faktury);

            $this -> session -> set('info', 'E-mail został wysłany do klienta');

            header("Location: ".$_SERVER['HTTP_REFERER']);
        }


        public function wyslij_na_maila(){
            set_time_limit(0);

            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            // zmienne
            $wyslij_kopie = $this -> input -> post('wyslij_kopie');
            $wyslij_oryginaly = $this -> input -> post('wyslij_oryginaly');
            $zalacz_adresowki = $this -> input -> post('zalacz_adresowki');

            // walidacja
            if(!$id_faktur = $this -> input -> post('id_faktur')) $this -> session -> set('error', 'Nie zaznaczono faktur.');
            else if(!$mail = $this -> input -> post('mail')) $this -> session -> set('error', 'Nie wpisano adresu e-mail.');
            else if(!validate::e_mail($mail)) $this -> session -> set('error', 'Adres e-mail był niepoprawny.');
            else if(!$wyslij_kopie && !$wyslij_oryginaly) $this -> session -> set('error', 'Nie wybrano żadnego typu faktur do wysłania.');

            if($this -> session -> get('error')){ header('Location: '.$_SERVER['HTTP_REFERER']); exit; }

            $folder = md5($uzytkownik['id'].time());

            base::check_if_folder_exists('pliki');
            base::check_if_folder_exists('pliki/pdf');
            base::check_if_folder_exists('pliki/pdf/'.$folder);

            require_once('pdf/config/lang/pol.php');
            require_once('pdf/tcpdf.php');

            $pliki = array();

            $faktury = $this -> load -> model('faktury');
            $klienci = $this -> load -> model('klienci');

            foreach($id_faktur as $id_faktury){
                if(!$faktura = $faktury -> jedna($id_faktury)) $this -> load -> error('no-access');
                if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $faktura['id_klienta'], $uzytkownik['typ'])) $this -> load -> error('no-access');

                // oryginal
                if($wyslij_oryginaly){
                    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                    $pdf -> SetCreator(PDF_CREATOR);
                    $pdf -> SetAuthor(PDF_COMPANY_NAME);
                    $pdf -> SetTitle(PDF_COMPANY_NAME);
                    $pdf -> SetSubject(PDF_COMPANY_NAME);
                    $pdf -> SetKeywords(PDF_COMPANY_NAME);

                    $pdf -> SetHeaderData(PDF_LOGO_SOURCE, PDF_LOGO_SIZE, PDF_HEADER_1_SC, PDF_HEADER_2_SC);

                    $pdf -> setHeaderFont(Array('dejavusanscondensed', '', '9'));
                    $pdf -> setFooterFont(Array('dejavusanscondensed', '', '9'));

                    $pdf -> SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                    $pdf -> SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
                    $pdf -> SetHeaderMargin(PDF_MARGIN_HEADER);
                    $pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);

                    $pdf -> SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                    $pdf -> setImageScale(PDF_IMAGE_SCALE_RATIO);

                    $pdf -> SetFont('dejavusanscondensed', '', 9);

                    $pdf -> AddPage();

                    $html = file_get_contents(url::page('faktury/pobierz/'.$faktura['id_faktury'].'/oryginal'), false);

                    $pdf -> writeHTML($html, true, false, true, false, '');

                    // adres korespondencyjny do koperty
                    if($zalacz_adresowki){
                        $pdf -> AddPage();

                        $html = file_get_contents(url::page('faktury/pobierz_adresowke/'.$faktura['id_klienta']), false);

                        $pdf -> writeHTML($html, true, false, true, false, '');
                    }

                    $numer_faktury = texts::numer_faktury($faktura);
                    $plik = 'pliki/pdf/'.$folder.'/'.base::nazwa_faktury_pdf($numer_faktury, $klient['nazwa'], 'oryginał');

                    $pdf -> Output($plik, 'F');

                    $pliki[] = $plik;

                }

                // kopie
                if($wyslij_kopie){
                    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                    $pdf -> SetCreator(PDF_CREATOR);
                    $pdf -> SetAuthor(PDF_COMPANY_NAME);
                    $pdf -> SetTitle(PDF_COMPANY_NAME);
                    $pdf -> SetSubject(PDF_COMPANY_NAME);
                    $pdf -> SetKeywords(PDF_COMPANY_NAME);

                    $pdf -> SetHeaderData(PDF_LOGO_SOURCE, PDF_LOGO_SIZE, PDF_HEADER_1_SC, PDF_HEADER_2_SC);

                    $pdf -> setHeaderFont(Array('dejavusanscondensed', '', '9'));
                    $pdf -> setFooterFont(Array('dejavusanscondensed', '', '9'));

                    $pdf -> SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                    $pdf -> SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
                    $pdf -> SetHeaderMargin(PDF_MARGIN_HEADER);
                    $pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);

                    $pdf -> SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                    $pdf -> setImageScale(PDF_IMAGE_SCALE_RATIO);

                    $pdf -> SetFont('dejavusanscondensed', '', 9);

                    $pdf -> AddPage();

                    $html = file_get_contents(url::page('faktury/pobierz/'.$faktura['id_faktury'].'/kopia'), false);

                    $pdf -> writeHTML($html, true, false, true, false, '');

                    $numer_faktury = texts::numer_faktury($faktura);
                    $plik = 'pliki/pdf/'.$folder.'/'.base::nazwa_faktury_pdf($numer_faktury, $klient['nazwa'], 'kopia');

                    $pdf -> Output($plik, 'F');

                    $pliki[] = $plik;

                }

            }

            require_once('pclzip.lib.php');

            $archiwum = new PclZip('pliki/pdf/'.$folder.'/archiwum.zip');
 
            $lista = $archiwum -> add($pliki, PCLZIP_OPT_REMOVE_ALL_PATH);

            if(!$lista) die("Error : ".$archiwum -> errorInfo(true));

            $email = new email();
            $email -> to($mail);
            $email -> from(BASE_MAIL);
            $email -> subject(iconv("UTF-8", "ISO-8859-2", E_MAIL_TITLE_COMPANY_NAME.' | Faktury VAT'));
            $email -> content(iconv("UTF-8", "ISO-8859-2", 'Faktury VAT w załączniku.'));
            $email -> attachment('pliki/pdf/'.$folder.'/archiwum.zip', 'application/octet-stream', 'faktury.zip');
            $email -> send();

            base::delete_directory('pliki/pdf/'.$folder);

            $this -> session -> set('info', 'Faktury zostały wysłane.');

            header("Location: ".$_SERVER['HTTP_REFERER']);
        }


        public function wyslij_na_maila_jeden_pdf(){
            set_time_limit(0);

            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            // zmienne
            $wyslij_kopie = $this -> input -> post('wyslij_kopie');
            $wyslij_oryginaly = $this -> input -> post('wyslij_oryginaly');
            $zalacz_adresowki = $this -> input -> post('zalacz_adresowki');

            // walidacja
            if(!$id_faktur = $this -> input -> post('id_faktur')) $this -> session -> set('error', 'Nie zaznaczono faktur.');
            else if(!$mail = $this -> input -> post('mail')) $this -> session -> set('error', 'Nie wpisano adresu e-mail.');
            else if(!validate::e_mail($mail)) $this -> session -> set('error', 'Adres e-mail był niepoprawny.');
            else if(!$wyslij_kopie && !$wyslij_oryginaly) $this -> session -> set('error', 'Nie wybrano żadnego typu faktur do wysłania.');

            if($this -> session -> get('error')){ header('Location: '.$_SERVER['HTTP_REFERER']); exit; }

            $folder = md5($uzytkownik['id'].time());

            base::check_if_folder_exists('pliki');
            base::check_if_folder_exists('pliki/pdf');
            base::check_if_folder_exists('pliki/pdf/'.$folder);

            require_once('pdf/config/lang/pol.php');
            require_once('pdf/tcpdf.php');

            $pliki = array();

            $faktury = $this -> load -> model('faktury');
            $klienci = $this -> load -> model('klienci');

            $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf -> SetCreator(PDF_CREATOR);
            $pdf -> SetAuthor(PDF_COMPANY_NAME);
            $pdf -> SetTitle(PDF_COMPANY_NAME);
            $pdf -> SetSubject(PDF_COMPANY_NAME);
            $pdf -> SetKeywords(PDF_COMPANY_NAME);

            $pdf -> SetHeaderData(PDF_LOGO_SOURCE, PDF_LOGO_SIZE, PDF_HEADER_1_SC, PDF_HEADER_2_SC);

            $pdf -> setHeaderFont(Array('dejavusanscondensed', '', '9'));
            $pdf -> setFooterFont(Array('dejavusanscondensed', '', '9'));

            $pdf -> SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            $pdf -> SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
            $pdf -> SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);

            $pdf -> SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            $pdf -> setImageScale(PDF_IMAGE_SCALE_RATIO);

            $pdf -> SetFont('dejavusanscondensed', '', 9);

            foreach($id_faktur as $id_faktury){
                if(!$faktura = $faktury -> jedna($id_faktury)) $this -> load -> error('no-access');
                if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $faktura['id_klienta'], $uzytkownik['typ'])) $this -> load -> error('no-access');

                // oryginal
                if($wyslij_oryginaly){
                    $pdf -> startPageGroup();
                    $pdf -> AddPage();

                    $html = file_get_contents(url::page('faktury/pobierz/'.$faktura['id_faktury'].'/oryginal'), false);

                    $pdf -> writeHTML($html, true, false, true, false, '');

                    // adres korespondencyjny do koperty
                    if($zalacz_adresowki){
                        $pdf -> AddPage();

                        $html = file_get_contents(url::page('faktury/pobierz_adresowke/'.$faktura['id_klienta']), false);

                        $pdf -> writeHTML($html, true, false, true, false, '');
                    }
                }

                // kopie
                if($wyslij_kopie){
                    $pdf -> startPageGroup();
                    $pdf -> AddPage();

                    $html = file_get_contents(url::page('faktury/pobierz/'.$faktura['id_faktury'].'/kopia'), false);

                    $pdf -> writeHTML($html, true, false, true, false, '');
                }
            }

            $plik = 'pliki/pdf/'.$folder.'/multi.pdf';
            $pdf -> Output($plik, 'F');

            $email = new email();
            $email -> to($mail);
            $email -> from(BASE_MAIL);
            $email -> subject(iconv("UTF-8", "ISO-8859-2", E_MAIL_TITLE_COMPANY_NAME.' | Faktury VAT'));
            $email -> content(iconv("UTF-8", "ISO-8859-2", 'Faktury VAT w załączniku.'));
            $email -> attachment($plik, 'application/octet-stream', 'faktury.pdf');
            $email -> send();

            base::delete_directory('pliki/pdf/'.$folder);

            $this -> session -> set('info', 'Faktury zostały wysłane.');

            header("Location: ".$_SERVER['HTTP_REFERER']);
        }


        public function wyslij_oryginaly_do_klientow(){
            set_time_limit(0);

            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            // walidacja
            if(!$id_faktur = $this -> input -> post('id_faktur')) $this -> session -> set('error', 'Nie zaznaczono faktur.');

            if($this -> session -> get('error')){ header('Location: '.$_SERVER['HTTP_REFERER']); exit; }

            $faktury = $this -> load -> model('faktury');
            $klienci = $this -> load -> model('klienci');

            base::check_if_folder_exists('pliki');
            base::check_if_folder_exists('pliki/pdf');

            foreach($id_faktur as $id_faktury){
                if(!$faktura = $faktury -> jedna($id_faktury)) $this -> load -> error('no-access');
                if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $faktura['id_klienta'], $uzytkownik['typ'])) $this -> load -> error('no-access');

                require_once('pdf/config/lang/pol.php');
                require_once('pdf/tcpdf.php');

                $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                $pdf -> SetCreator(PDF_CREATOR);
                $pdf -> SetAuthor(PDF_COMPANY_NAME);
                $pdf -> SetTitle(PDF_COMPANY_NAME);
                $pdf -> SetSubject(PDF_COMPANY_NAME);
                $pdf -> SetKeywords(PDF_COMPANY_NAME);

                $pdf -> SetHeaderData(PDF_LOGO_SOURCE, PDF_LOGO_SIZE, PDF_HEADER_1_SC, PDF_HEADER_2_SC);

                $pdf -> setHeaderFont(Array('dejavusanscondensed', '', '9'));
                $pdf -> setFooterFont(Array('dejavusanscondensed', '', '9'));

                $pdf -> SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                $pdf -> SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
                $pdf -> SetHeaderMargin(PDF_MARGIN_HEADER);
                $pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);

                $pdf -> SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                $pdf -> setImageScale(PDF_IMAGE_SCALE_RATIO);

                $pdf -> SetFont('dejavusanscondensed', '', 9);

                $pdf -> AddPage();

                $html = file_get_contents(url::page('faktury/pobierz/'.$faktura['id_faktury'].'/oryginal'), false);

                $pdf -> writeHTML($html, true, false, true, false, '');

                $plik = 'pliki/pdf/'.md5($faktura['id_faktury'].$faktura['id_klienta'].time()).'.pdf';

                $pdf -> Output($plik, 'F');

                $faktura_numer = texts::numer_faktury($faktura);

                $email = new email();
                $email -> to($klient['mail']);
                $email -> from(BASE_MAIL);
                $email -> subject(iconv("UTF-8", "ISO-8859-2", E_MAIL_TITLE_COMPANY_NAME.' | Faktura VAT numer '.$faktura_numer.' dla '.$klient['nazwa']));
                $email -> content(iconv("UTF-8", "ISO-8859-2", 'Szanowni Państwo,<br /><br />W załączniku znajdą Państwo fakturę VAT numer '.$faktura_numer.' wystawioną na kwotę '.str_replace('.00', '', $faktura['kwota_brutto']).' PLN.<br />Termin zapłaty mija dnia '.texts::nice_date($faktura['termin_zaplaty']).'.<br /><br />Wszelkie szczegóły dotyczące należności znajdą Państwo na załączonej fakturze.<br /><br />Dziękujemy za terminowe wpłaty.<br /><br />'.E_MAIL_FOOTER));
                $email -> attachment($plik, 'application/octet-stream', base::nazwa_faktury_pdf($faktura_numer, $klient['nazwa'], 'oryginał'));
                $email -> send();

                unlink($plik);

                $faktury -> oznacz_jako_wyslana_mailem($id_faktury);

                // notatka w historii relacji
                $klienci -> zapisz_notatke(date("Y-m-d"), $faktura['id_klienta'], 'Wysłano elektroniczną wersję faktury VAT, numer '.$faktura_numer);

            }

            $this -> session -> set('info', 'Faktury zostały wysłane do klientów');

            header("Location: ".$_SERVER['HTTP_REFERER']);
        }
		
		public function fak_kwota($id_faktury){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $faktury = $this -> load -> model('faktury');
            if(!$faktura = $faktury -> jedna($id_faktury)) $this -> load -> error('no-access');

    		$this -> load -> view('faktura_kor_kwota', array('id_faktury' => $id_faktury,
    		                                               'uzytkownik' => $uzytkownik));
        }

    }

?>