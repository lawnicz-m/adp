<?php

    class controller{

        public function wszystkie($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_dokumenty');
            if(!$acl -> is_allowed($uzytkownik['typ'], 'lista_etap_'.$klient['etap'])) $this -> load -> error('no-access');

    		$this -> load -> view('dokumenty', array('klient' => $klient,
    		                                         'uzytkownik' => $uzytkownik));
        }


        public function wycena($hash, $jako_zalacznik = 0){
            if(!$klient = $this -> load -> model('klienci') -> jeden_klient_po_hashu($hash)) $this -> load -> error('404');
            if($klient['etap'] < 3) $this -> load -> error('404');

            $frazy = $this -> load -> model('frazy') -> wszystkie($klient['id_klienta']);

    		$this -> load -> view('dokumenty/wycena', array('frazy' => $frazy,
    		                                                'jako_zalacznik' => $jako_zalacznik,
    		                                                'klient' => $klient));
        }


    	public function komentarz_do_wyceny($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);

            if($id_klienta && !$klient) $this -> load -> error('no-access');
		
    		$this -> load -> view('komentarz_do_wyceny_formularz', array('klient' => $klient,
    		                                                             'uzytkownik' => $uzytkownik));

    	}


    	public function zapisz_komentarz_do_wyceny($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');

            if($id_klienta && !$klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

            $komentarz_do_wyceny = $this -> input -> post('komentarz_do_wyceny');

            $klienci -> zapisz_komentarz_do_wyceny($id_klienta, $komentarz_do_wyceny);

            $this -> session -> set('info', 1);

            if($this -> input -> post('redirectBack')) url::redirect('dokumenty/komentarz_do_wyceny/'.$id_klienta);
            else url::redirect('dokumenty/wszystkie/'.$id_klienta);
    	}


        public function umowa($hash){
            if(!$klient = $this -> load -> model('klienci') -> jeden_klient_po_hashu($hash)) $this -> load -> error('404');
            if($klient['etap'] < 3) $this -> load -> error('404');

            $frazy = $this -> load -> model('frazy') -> wszystkie($klient['id_klienta']);

    		$this -> load -> view('dokumenty/umowa', array('frazy' => $frazy,
    		                                               'klient' => $klient));
        }
		
		public function cesja($hash){
            if(!$klient = $this -> load -> model('klienci') -> jeden_klient_po_hashu($hash)) $this -> load -> error('404');
            if($klient['etap'] < 3) $this -> load -> error('404');

            $frazy = $this -> load -> model('frazy') -> wszystkie($klient['id_klienta']);

    		$this -> load -> view('dokumenty/cesja', array('frazy' => $frazy,
    		                                               'klient' => $klient));
        }
		
		public function umowahosting($hash){
            if(!$klient = $this -> load -> model('klienci') -> jeden_klient_po_hashu($hash)) $this -> load -> error('404');
            if($klient['etap'] < 3) $this -> load -> error('404');

            $frazy = $this -> load -> model('frazy') -> wszystkie($klient['id_klienta']);

    		$this -> load -> view('dokumenty/umowahosting', array('frazy' => $frazy,
    		                                               'klient' => $klient));
        }

    }

?>