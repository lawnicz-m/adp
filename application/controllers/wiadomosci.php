<?php

    class controller{

        public function index($typ = 0, $status = 0){
            if(!$typ || !$status) url::redirect(CONTROLLER.'/index/odebrane/nieprzeczytane');

            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $_wiadomosci = $this -> load -> model('wiadomosci');

            $status_2 = ($typ == 'odebrane' ? 'Odebrane' : 'Wysłane').' '.$status;

    		$this -> load -> view('wiadomosci', array('status' => $status_2,
    		                                          'statystyka' => $_wiadomosci -> pobierz_statystyke_wiadomosci($uzytkownik),
    		                                          'wiadomosci' => $_wiadomosci -> pobierz_wszystkie_wiadomosci($uzytkownik, $status, $typ),
    		                                          'uzytkownik' => $uzytkownik));
        }


        public function odczytaj($id_wiadomosci){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $_wiadomosci = $this -> load -> model('wiadomosci');

    		$this -> load -> view('wiadomosc', array('wiadomosc' => $_wiadomosci -> pobierz_jedna_wiadomosc($id_wiadomosci, $uzytkownik),
    		                                         'uzytkownik' => $uzytkownik));
            
        }


        public function oznacz_jako_wykonane($id_wiadomosci){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $_wiadomosci = $this -> load -> model('wiadomosci');

            $_wiadomosci -> oznacz_jako_wykonane($id_wiadomosci, $uzytkownik);

            $this -> session -> set('info', 'Zadanie zostało oznaczone jako wykonane');

            url::redirect(CONTROLLER.'/odczytaj/'.$id_wiadomosci);
        }


        public function napisz(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin' && $uzytkownik['typ'] != 'partner') $this -> load -> error('no-access');
			
			function subval_sort($a,$subkey) {
					foreach($a as $k=>$v) {
											$b[$k] = strtolower($v[$subkey]);
											}
					asort($b);
					foreach($b as $key=>$val) {
												$c[] = $a[$key];
												}
					return $c;
			}
            // lista odbiorców
            if($uzytkownik['typ'] == 'admin') $adm = $this -> load -> model('admini') -> wszyscy();
			if($uzytkownik['typ'] == 'admin') $part = $this -> load -> model('partnerzy') -> wszyscy();
			if($uzytkownik['typ'] == 'admin') $odbiorcy = array_merge($adm, $part);
            if($uzytkownik['typ'] == 'partner') $odbiorcy = $this -> load -> model('admini') -> wszyscy();

			$odbiorcy = subval_sort($odbiorcy, 'nazwa');
			
			
    		$this -> load -> view('napisz_wiadomosc', array('odbiorcy' => $odbiorcy,
    		                                                'uzytkownik' => $uzytkownik,
    		                                                'wiadomosc' => false));
        }


        public function wyslij(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin' && $uzytkownik['typ'] != 'partner') $this -> load -> error('no-access');

            $id_nadawcy = $uzytkownik['id'];
            $id_odbiorcy = $this -> input -> post('id_odbiorcy');
            $tresc = $this -> input -> post('tresc');
            $typ_nadawcy = $uzytkownik['typ'];
            $typ_odbiorcy = $this -> input -> post('typ');;
            $tytul = $this -> input -> post('tytul');

            if(!$tresc || !$tytul) $this -> session -> set('error', 1);

            if($this -> session -> get('error')){
			
			function subval_sort($a,$subkey) {
					foreach($a as $k=>$v) {
											$b[$k] = strtolower($v[$subkey]);
											}
					asort($b);
					foreach($b as $key=>$val) {
												$c[] = $a[$key];
												}
					return $c;
			}
                // lista odbiorców
            if($uzytkownik['typ'] == 'admin') $adm = $this -> load -> model('admini') -> wszyscy();
			if($uzytkownik['typ'] == 'admin') $part = $this -> load -> model('partnerzy') -> wszyscy();
			if($uzytkownik['typ'] == 'admin') $odbiorcy = array_merge($adm, $part);
            if($uzytkownik['typ'] == 'partner') $adm = $this -> load -> model('admini') -> wszyscy();
			if($uzytkownik['typ'] == 'partner') $part = $this -> load -> model('partnerzy') -> wszyscy();
			if($uzytkownik['typ'] == 'partner') $odbiorcy = array_merge($adm, $part);
				
			$odbiorcy = subval_sort($odbiorcy, 'nazwa');
				
						
    		    $this -> load -> view('napisz_wiadomosc', array('wiadomosc' => array('id_odbiorcy' => $id_odbiorcy,
    		                                                                         'tresc' => $tresc,
    		                                                                         'tytul' => $tytul),
																					 'odbiorcy' => $odbiorcy,
																				     'uzytkownik' => $uzytkownik));
    		    exit;
            }

            $this -> load -> model('wiadomosci') -> wyslij($id_nadawcy, $id_odbiorcy, $tresc, $typ_nadawcy, $typ_odbiorcy, $tytul);

            $this -> session -> set('info', 'Wiadomosc została wysłana');

            url::redirect(CONTROLLER.'/index/wyslane/nieprzeczytane');
        }

    }

?>