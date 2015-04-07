<?php

    class controller{

        public function wszystkie($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');

            if(!$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

            $umowy = $this -> load -> model('umowy') -> wszystkie($id_klienta);

    		$this -> load -> view('umowy', array('klient' => $klient,
    		                                     'umowy' => $umowy,
    		                                     'uzytkownik' => $uzytkownik));
        }


    	public function form($id_umowy, $id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            if(!$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            
            $umowa = $this -> load -> model('umowy') -> jedna($id_umowy);

    		$this -> load -> view('umowy_formularz', array('klient' => $klient,
    		                                               'umowa' => $umowa,
    		                                               'uzytkownik' => $uzytkownik));
    	}


    	public function zapisz($id_umowy, $id_klienta){
    	    // modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');
            $umowy = $this -> load -> model('umowy');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

            // zmienne
            $data_rozpoczecia = $this -> input -> post('data_rozpoczecia');
            $nazwa = $this -> input -> post('nazwa');
            $numer = $this -> input -> post('numer');
            $termin_platnosci = $this -> input -> post('termin_platnosci');
            $termin_realizacji = $this -> input -> post('termin_realizacji');
            $typ_realizacji = $this -> input -> post('typ_realizacji');
            $typ_umowy = $this -> input -> post('typ_umowy');
            $wynagrodzenie = $this -> input -> post('wynagrodzenie');
            $wysokosc_zadatku = $this -> input -> post('wysokosc_zadatku');

            if(!$nazwa || !$numer) $this -> session -> set('error', 1);

            if($this -> session -> get('error')){
    		    $this -> load -> view('umowy_formularz', array('umowa' => array('data_rozpoczecia' => $data_rozpoczecia,
    		                                                                    'nazwa' => $nazwa,
    		                                                                    'numer' => $numer,
    		                                                                    'termin_platnosci' => $termin_platnosci,
    		                                                                    'termin_realizacji' => $termin_realizacji,
                                                                                'typ_realizacji' => $typ_realizacji,
                                                                                'typ_umowy' => $typ_umowy,
    		                                                                    'wynagrodzenie' => $wynagrodzenie,
    		                                                                    'wysokosc_zadatku' => $wysokosc_zadatku),
    		                                                   'klient' => $klient,
    		                                                   'uzytkownik' => $uzytkownik));
    		    exit;
            }

            $umowy -> zapisz($data_rozpoczecia, $id_klienta, $id_umowy, $nazwa, $numer, $termin_platnosci, $termin_realizacji, $typ_realizacji, $typ_umowy, $wynagrodzenie, $wysokosc_zadatku);

            $this -> session -> set('info', 1);

            if($this -> input -> post('redirectBack')) url::redirect(CONTROLLER.'/form/'.$id_umowy.'/'.$id_klienta);
            else url::redirect(CONTROLLER.'/wszystkie/'.$id_klienta);
    	}


    	public function usun($id_umowy, $id_klienta){
    	    // modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

            $this -> load -> model('umowy') -> usun($id_umowy);

            $this -> session -> set('info', 'Umowa została usunięta');

            url::redirect(CONTROLLER.'/wszystkie/'.$id_klienta);
    	}


        public function pobierz_pdf($id_umowy){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
			
            if(!$umowa = $this -> load -> model('umowy') -> jedna($id_umowy)) $this -> load -> error('no-access');
            if(!$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $umowa['id_klienta'], $uzytkownik['typ'])) $this -> load -> error('no-access');
            $_frazy = $this -> load -> model('frazy');
            $frazy = $_frazy -> wszystkie($umowa['id_klienta']);
            require_once('pdf/config/lang/pol.php');
            require_once('pdf/tcpdf.php');

            $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf -> SetCreator(PDF_CREATOR);
            $pdf -> SetAuthor(PDF_COMPANY_NAME);
            $pdf -> SetTitle(PDF_COMPANY_NAME);
            $pdf -> SetSubject(PDF_COMPANY_NAME);
            $pdf -> SetKeywords(PDF_COMPANY_NAME);

            $pdf -> SetHeaderData(PDF_LOGO_SOURCE, PDF_LOGO_SIZE, PDF_HEADER_1, PDF_HEADER_2);

            $pdf -> setHeaderFont(Array('dejavusanscondensed', '', '9'));
            $pdf -> setFooterFont(Array('dejavusanscondensed', '', '9'));

            $pdf -> SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            $pdf -> SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
            $pdf -> SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf -> SetFooterText('Umowa nr '.$umowa['numer']);

            $pdf -> SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            $pdf -> setImageScale(PDF_IMAGE_SCALE_RATIO);

            $pdf -> SetFont('dejavusanscondensed', '', 10);

            $pdf -> startPageGroup();
            $pdf -> AddPage();

            ob_start();

            include('application/views/dokumenty/'.$umowa['typ_umowy'].'.php');
            
            $pdf -> writeHTML(ob_get_contents(), true, false, true, false, '');

            ob_end_clean();

            if($umowa['typ_umowy'] == 'umowa_na_serwis_witryny_internetowej'){

                $pdf -> startPageGroup();
                $pdf -> AddPage();

                ob_start();

                include('application/views/dokumenty/'.$umowa['typ_umowy'].'_zalacznik.php');

                $pdf -> writeHTML(ob_get_contents(), true, false, true, false, '');

                ob_end_clean();
                
            }

            $pdf -> Output(strtolower(str_replace('/', '-', $umowa['nazwa'].'.pdf')), 'D');
        }

    }

?>