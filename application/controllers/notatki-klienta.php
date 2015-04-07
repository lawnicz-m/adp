<?php

    class controller{

        public function wszystkie($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $klienci = $this -> load -> model('klienci');

            if(!$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

            $notatki = $klienci -> wszystkie_notatki($id_klienta);

    		$this -> load -> view('notatki-klienta', array('notatki' => $notatki,
    		                                               'klient' => $klient,
    		                                               'uzytkownik' => $uzytkownik));
        }


    	public function form($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $klienci = $this -> load -> model('klienci');

            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
		
    		$this -> load -> view('notatki_klienta_formularz', array('notatka' => false,
    		                                                         'klient' => $klient,
    		                                                         'uzytkownik' => $uzytkownik));
    	}


    	public function zapisz($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $klienci = $this -> load -> model('klienci');
			$partnerzy = $this -> load -> model('partnerzy');
			$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);

            if(!$klient) $this -> load -> error('no-access');

            $data_nastepnego_kontaktu = $this -> input -> post('data_nastepnego_kontaktu');
            $data_utworzenia = $this -> input -> post('data_utworzenia');
            $notatka_do_nastepnego_kontaktu = $this -> input -> post('notatka_do_nastepnego_kontaktu');
            $tresc = $this -> input -> post('tresc');

            if(!$data_utworzenia || !$tresc) $this -> session -> set('error', 1);

            if($this -> session -> get('error')){
    		    $this -> load -> view('notatki_klienta_formularz', array('notatka' => array('data_nastepnego_kontaktu' => $data_nastepnego_kontaktu,
    		                                                                                'data_utworzenia' => $data_utworzenia,
    		                                                                                'notatka_do_nastepnego_kontaktu' => $notatka_do_nastepnego_kontaktu,
    		                                                                                'tresc' => $tresc),
    		                                                             'uzytkownik' => $uzytkownik));
    		    exit;
            }
			$mailnozbe_handl = $this -> input -> post('mailnozbe_handl');
			$mailnozbe_techn = $this -> input -> post('mailnozbe_techn');
			$mailnozbe_copywriter = $this -> input -> post('mailnozbe_copywriter');
			
			if($mailnozbe_handl)
			{
			   $date = date('Y-m-d');
			   $partner_1 = $partnerzy -> jeden($klient['id_partnera']);
			   $tresc = $tresc.'    <br\>'     .$date.',   do '.$partner_1['nazwa'].', Zlecenie w Nozbe';
			}
			
			if($mailnozbe_copywriter)
			{
			   $date = date('Y-m-d');
			   
			   $tresc = $tresc.'    <br\>'     .$date.',   do Copywriter M. Mauer 516 577 883 , copywritingpromultis@wp.pl';
			}
			
			if($mailnozbe_techn)
			{
			   $date = date('Y-m-d');
			   
			   $tresc = $tresc.'    <br\>'     .$date.',   do Dzial techniczny, Zlecenie w Nozbe';
			}
			
            $klienci -> zapisz_notatke($data_utworzenia, $id_klienta, $tresc);
            if($data_nastepnego_kontaktu && $notatka_do_nastepnego_kontaktu) $klienci -> uaktualnij_nastepny_kontakt($data_nastepnego_kontaktu, $id_klienta, $notatka_do_nastepnego_kontaktu);
			if(!$notatka_do_nastepnego_kontaktu) $klienci -> uaktualnij_date_nastepny_kontakt($data_nastepnego_kontaktu, $id_klienta);
			
			
			if($mailnozbe_handl)
			{
				$emailnozbe_handl = new email();
				//$emailnozbe_handl -> to('remigiusz.szwabowicz@imas.pl');
				// $emailnozbe_handl -> to($partner_1['mail_nozbe']);
				$emailnozbe_handl -> to('pdobrzanski.36514@nozbe.me');
				$emailnozbe_handl -> from( 'nozbe@adppoland.pl' );
				$emailnozbe_handl -> subject(iconv("UTF-8","ISO-8859-2", $klient['adres_strony'] ));
				$emailnozbe_handl -> content(iconv("UTF-8","ISO-8859-2", $tresc.'<br/><a href="http://crm.pozycjonowanie-google.eu/klienci/profil/'.$id_klienta.'">http://crm.pozycjonowanie-google.eu/klienci/profil/'.$id_klienta.'</a>'));
				$emailnozbe_handl -> send();
				
			}
			
			if($mailnozbe_techn)
			{
				$emailnozbe_techn = new email();
				//$emailnozbe_techn -> to('remigiusz.szwabowicz@imas.pl');
				$emailnozbe_techn -> to('patryk.4569@nozbe.me');
				$emailnozbe_techn -> from( 'nozbe@adppoland.pl' );
				$emailnozbe_techn -> subject(iconv("UTF-8","ISO-8859-2",$klient['adres_strony']));
				$emailnozbe_techn -> content(iconv("UTF-8","ISO-8859-2", $tresc.'<br/><a href="http://crm.pozycjonowanie-google.eu/klienci/profil/'.$id_klienta.'">http://crm.pozycjonowanie-google.eu/klienci/profil/'.$id_klienta.'</a>'));
				$emailnozbe_techn -> send();
			}
			
			if($mailnozbe_copywriter)
			{
				$mailnozbe_copywriter = new email();
				//$emailnozbe_techn -> to('remigiusz.szwabowicz@imas.pl');
				$mailnozbe_copywriter -> to('copywritingpromultis@wp.pl');
				$mailnozbe_copywriter -> from( 'pdobrzanski@adppoland.pl' );
				$mailnozbe_copywriter -> subject(iconv("UTF-8","ISO-8859-2",$klient['adres_strony']));
				//$mailnozbe_copywriter -> content(iconv("UTF-8","ISO-8859-2", $tresc.'<br/><a href="http://crm.pozycjonowanie-google.eu/klienci/profil/'.$id_klienta.'">http://crm.pozycjonowanie-google.eu/klienci/profil/'.$id_klienta.'</a>'));
				$mailnozbe_copywriter -> content(iconv("UTF-8","ISO-8859-2", $tresc.'   '.$id_klienta.'</a>'));
				$mailnozbe_copywriter -> send();
			}
			
			
            $this -> session -> set('info', 1);

            url::redirect('klienci/profil/'.$id_klienta);
    	}
	
    }

?>