<?php

    class partnerzy_model{

    	public function wszyscy(){
    		$tabela = $this -> db -> table('partnerzy');

    		$dane = $tabela -> select('*')
    		                -> order_by('data_utworzenia', 'ASC')
    		                -> order_by('id_partnera', 'ASC')
    		                -> execute();

            return $dane ? $dane : false;
        }


    	public function jeden($id_partnera){
    		$tabela = $this -> db -> table('partnerzy');

    		$partner = $tabela -> select('*')
    		                   -> where('id_partnera','=',$id_partnera)
    		                   -> limit(1)
    		                   -> execute();

            return $partner ? $partner[0] : false;
        }


        public function zapisz($adres_strony, $dane_kontaktowe, $data_utworzenia, $faktura_adres, $faktura_kod_pocztowy, $faktura_miejscowosc, $faktura_nazwa, $faktura_papierowa, $haslo, $id_partnera, $indywidualny, $korespondencja_adres, $korespondencja_kod_pocztowy, $korespondencja_miejscowosc, $korespondencja_nazwa, $login, $mail, $nazwa, $nip, $osoba_kontaktowa, $regon, $reprezentant, $telefon, $mail_nozbe){
    		$tabela = $this -> db -> table('partnerzy');
    		$baza_haslo_arr = $tabela -> select('haslo')
    		                -> where('id_partnera','=',$id_partnera)
    		                -> execute();
				$baza_haslo = ($baza_haslo_arr[0]["haslo"]);
				
            if($id_partnera){
            	if($baza_haslo != $haslo) {
            		$md5 = md5($haslo);
            		$tabela -> update(array('haslo' => $md5))
    	                -> where('id_partnera','=',$id_partnera)
            	        -> execute();}
            	$tabela -> update(array(
            	                        'adres_strony' => $adres_strony,
            	                        'data_utworzenia' => $data_utworzenia,
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
										'mail_nozbe' => $mail_nozbe
            	                        ))
    	                -> where('id_partnera','=',$id_partnera)
            	        -> execute();
    	    }else{
    	    	$md5 = md5($haslo);
            	$tabela -> insert(array(
            	                        'adres_strony' => $adres_strony,
            	                        'data_utworzenia' => $data_utworzenia,
            	                        'haslo' => $md5,
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
										'mail_nozbe' => $mail_nozbe
            	                        ), false);
    	    }

    	    return true;
        }


        public function czy_login_istnieje($id_partnera, $login){
    		$table = $this -> db -> table('partnerzy');

    		$wynik = $table -> select('*')
    		                -> where('login','=',$login)
    		                -> execute();

            $wynik = $wynik ? 1 : 0;

            if($id_partnera && $wynik){
        		$dane = $table -> select('*')
        		               -> where('id_partnera','=',$id_partnera)
    		                   -> clause('AND')
        		               -> where('login','=',$login)
        		               -> execute();

                $dane = $dane ? 1 : 0;
                if($dane) $wynik = 0;
            }

            return $wynik;
        }


        public function lista_do_selecta($poza_id = 0){
    		$tabela = $this -> db -> table('partnerzy');

    		$dane = $tabela -> select('id_partnera', 'nazwa')
    		                -> order_by('nazwa', 'ASC')
    		                -> execute();

            $dane_2 = array();

            if($dane){
                foreach($dane as $element){
                    if($element['id_partnera'] != $poza_id) $dane_2[] = $element;
                }
            }

            return $dane_2;
        }


        // powiązania
        public function zapisz_powiazania($id_partnera, $id_partnera_polecajacego){
    		$tabela = $this -> db -> table('partnerzy');

        	$tabela -> update(array('id_partnera_polecajacego' => $id_partnera_polecajacego))
	                -> where('id_partnera','=',$id_partnera)
        	        -> execute();

    	    return true;
        }


        // prowizja
        public function zapisz_prowizje($id_partnera, $prowizja_partnera, $prowizja_partnera_prog, $prowizja_partnera_polecajacego){
    		$tabela = $this -> db -> table('partnerzy');

        	$tabela -> update(array('prowizja_partnera' => $prowizja_partnera,
        	                        'prowizja_partnera_prog' => $prowizja_partnera_prog,
        	                        'prowizja_partnera_polecajacego' => $prowizja_partnera_polecajacego))
	                -> where('id_partnera','=',$id_partnera)
        	        -> execute();

    	    return true;
        }


        public function zwieksz_saldo($id_partnera, $kwota, $podstawa, $prowizja, $piecprocent, $id_klienta){
            
			$wplata = $kwota * ($prowizja / 100);
            $wplata = round($wplata, 2);
			// zapis
	        $this -> db -> query('LOCK TABLE partnerzy WRITE');
            $this -> db -> query("UPDATE partnerzy
                                  SET saldo = saldo + $wplata
                                  WHERE id_partnera = $id_partnera");
            $this -> db -> query('UNLOCK TABLES');
			
			
			if($piecprocent == 1){
			$this -> db -> query('LOCK TABLE klienci WRITE');
            $this -> db -> query("UPDATE klienci
                                  SET telemark_5 = 1
                                  WHERE id_klienta = $id_klienta");
            $this -> db -> query('UNLOCK TABLES');
			
			
			}

            // historia salda
    		$tabela = $this -> db -> table('historia_salda_partnerow');

        	$tabela -> insert(array('data_utworzenia' => date("Y-m-d H:i:s"),
        	                        'id_partnera' => $id_partnera,
        	                        'tresc' => "Na podstawie dokumentu $podstawa zwiększono saldo o $wplata zł"), false);

            return $wplata;
        }


        public function zwieksz_saldo_o_wynagrodzenie($id_partnera, $kwota, $podstawa){
            // zapis
	        $this -> db -> query('LOCK TABLE partnerzy WRITE');
            $this -> db -> query("UPDATE partnerzy
                                  SET saldo = saldo + $kwota
                                  WHERE id_partnera = $id_partnera");
            $this -> db -> query('UNLOCK TABLES');

            // historia salda
    		$tabela = $this -> db -> table('historia_salda_partnerow');

        	$tabela -> insert(array('data_utworzenia' => date("Y-m-d H:i:s"),
        	                        'id_partnera' => $id_partnera,
        	                        'tresc' => "Na podstawie dokumentu $podstawa zwiększono saldo o $kwota zł"), false);

            return $kwota;
        }


        public function historia_salda($id_partnera){
    		$tabela = $this -> db -> table('historia_salda_partnerow');

    		$dane = $tabela -> select('*')
    		                -> where('id_partnera','=',$id_partnera)
    		                -> order_by('data_utworzenia', 'DESC')
    		                -> execute();

            if(!$dane) return false;

            $dane_2 = array();
            $i = 0;

            foreach($dane as $element){
                $dane_2[$i] = $element;

                // określanie stanu (wpływ, czy obciążenie)
                $dane_2[$i]['status'] = ereg('zwiększono', $element['tresc']) ? '+' : '-';

                // dodawanie id faktury i id faktury wymagane do pokazania podglądu
                if($dane_2[$i]['status'] == '+'){
                    $numer_faktury = explode(' ', $element['tresc']);
                    $faktura = $this -> load -> model('faktury') -> jedna_po_numerze_faktury($numer_faktury[3]);

                    $dane_2[$i]['id_faktury'] = $faktura['id_faktury'];
                    $dane_2[$i]['id_klienta'] = $faktura['id_klienta'];
                }else{
                    $dane_2[$i]['id_faktury'] = false;
                    $dane_2[$i]['id_klienta'] = false;
                }

                $i++;
            }

            return $dane_2;
        }


        public function obciaz_saldo($id_partnera, $kwota_obciazenia, $podstawa_obciazenia){
            // zapis
	        $this -> db -> query('LOCK TABLE partnerzy WRITE');
            $this -> db -> query("UPDATE partnerzy
                                  SET saldo = saldo - $kwota_obciazenia
                                  WHERE id_partnera = $id_partnera");
            $this -> db -> query('UNLOCK TABLES');

            // historia salda
    		$tabela = $this -> db -> table('historia_salda_partnerow');

        	$tabela -> insert(array('data_utworzenia' => date("Y-m-d H:i:s"),
        	                        'id_partnera' => $id_partnera,
        	                        'tresc' => "Na podstawie dokumentu $podstawa_obciazenia obciążono saldo o $kwota_obciazenia zł"), false);
        }
        
        public function getOptionHTML() {
        	$table = $this->db->table('partnerzy');
        	 
        	$partners = $table
        		->select('id_partnera', 'nazwa')
        		->order_by('nazwa', 'ASC')
        		-> execute();
        	 
        	$html = '';
        	
        	foreach ($partners as $partner) {
        		if($_SESSION['breakdown_filter_partner'] !== 0) {
        			if($_SESSION['breakdown_filter_partner'] == $partner['id_partnera']) {
        				$html .= '<option value="'.$partner['id_partnera'].'" selected>'.$partner['nazwa'].'</option>'.PHP_EOL;
        			} else {
        				$html .= '<option value="'.$partner['id_partnera'].'">'.$partner['nazwa'].'</option>'.PHP_EOL;
        			}
        		} else {
        			$html .= '<option value="'.$partner['id_partnera'].'">'.$partner['nazwa'].'</option>'.PHP_EOL;
        		}
        	}
        	 
        	return $html;
        }

    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    