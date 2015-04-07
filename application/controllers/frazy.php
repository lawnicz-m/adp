<?php

    class controller{

        public function wszystkie($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');

            if(!$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');

            $_frazy = $this -> load -> model('frazy');

            $frazy = $_frazy -> wszystkie($id_klienta);

    		$this -> load -> view('frazy', array('frazy' => $frazy,
    		                                     'klient' => $klient,
    		                                     'uzytkownik' => $uzytkownik));
        }


    	public function form($id_frazy, $id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');
            $frazy = $this -> load -> model('frazy');
            
            $fraza = $frazy -> jedna($id_frazy);
            $klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);

            // prawa dostępu
            if($id_frazy && !$klient) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_frazy');
            if(!$id_frazy && !$acl -> is_allowed($uzytkownik['typ'], 'dodaj_fraze_etap_'.$klient['etap'])) $this -> load -> error('no-access');
            if($id_frazy && !$acl -> is_allowed($uzytkownik['typ'], 'edytuj_fraze_etap_'.$klient['etap'])) $this -> load -> error('no-access');

    		$this -> load -> view('frazy_formularz', array('fraza' => $fraza,
    		                                               'klient' => $klient,
    		                                               'uzytkownik' => $uzytkownik));
    	}


    	public function form_kilka($id_klienta, $id_zadania = 0){
    	    if($id_zadania) print_r(config::get('db'));
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_frazy');
            if(!$acl -> is_allowed($uzytkownik['typ'], 'dodaj_fraze_etap_'.$klient['etap'])) $this -> load -> error('no-access');

    		$this -> load -> view('frazy_kilka_formularz', array('klient' => $klient,
    		                                                     'uzytkownik' => $uzytkownik));
    	}


    	public function zapisz_kilka($id_klienta){
    	    // modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');
            $frazy = $this -> load -> model('frazy');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_frazy');
            if(!$acl -> is_allowed($uzytkownik['typ'], 'dodaj_fraze_etap_'.$klient['etap'])) $this -> load -> error('no-access');

            // zmienne
            $frazy_ryczalt = $this -> input -> post('frazy_ryczalt');
            $frazy_top = $this -> input -> post('frazy_top');

            if($frazy_ryczalt){
                $frazy_ryczalt = str_replace('<br>', ',', str_replace('<br />', ',', nl2br($frazy_ryczalt)));
                $frazy_ryczalt = explode(',', $frazy_ryczalt);
                $frazy_ryczalt = array_map("trim", $frazy_ryczalt);
                $frazy_ryczalt = array_map("strtolower", $frazy_ryczalt);
            }

            if($frazy_top){
                $frazy_top = str_replace('<br>', ',', str_replace('<br />', ',', nl2br($frazy_top)));
                $frazy_top = explode(',', $frazy_top);
                $frazy_top = array_map("trim", $frazy_top);
                $frazy_top = array_map("strtolower", $frazy_top);
            }

            $frazy -> zapisz_kilka($frazy_ryczalt, $frazy_top, $id_klienta);

            $this -> session -> set('info', 1);

            url::redirect('frazy/wszystkie/'.$id_klienta);
    	}


    	public function zapisz($id_frazy, $id_klienta){
    	    // modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');
            $frazy = $this -> load -> model('frazy');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_frazy');
            if(!$id_frazy && !$acl -> is_allowed($uzytkownik['typ'], 'dodaj_fraze_etap_'.$klient['etap'])) $this -> load -> error('no-access');
            if($id_frazy && !$acl -> is_allowed($uzytkownik['typ'], 'edytuj_fraze_etap_'.$klient['etap'])) $this -> load -> error('no-access');

            // zmienne
            $kwota_za_fraze = $this -> input -> post('kwota_za_fraze');
            $minimalna_kwota_za_fraze = $this -> input -> post('minimalna_kwota_za_fraze');
            $nazwa = strtolower(trim($this -> input -> post('nazwa')));
            $link = $this -> input -> post('link');
            $typ = $this -> input -> post('typ');
            $top10_procentowo = $this->input->post('top10_procentowo');
            $top10_1_kwota = $this->input->post('top10_1_kwota');
            $top10_2_kwota = $this->input->post('top10_2_kwota');
            $top10_3_kwota = $this->input->post('top10_3_kwota');
            $top10_pierwsza_strona = $this->input->post('top10_pierwsza_strona');
			$top_max = $this->input->post('top_max');

            if(!$nazwa || !$typ) $this -> session -> set('error', 1);
            if($kwota_za_fraze < $minimalna_kwota_za_fraze) $this -> session -> set('error', 'Oficjalna kwota dla klienta nie może być niższa niż kwota minimalna.');

            if($this -> session -> get('error')){
    		    $this -> load -> view('frazy_formularz', array('fraza' => array('kwota_za_fraze' => $kwota_za_fraze,
    		                                                                    'minimalna_kwota_za_fraze' => $minimalna_kwota_za_fraze,
    		                                                                    'nazwa' => $nazwa,
                                                                                'link' => $link,
    		                                                                    'typ' => $typ),
                                            									'top10_procentowo'	=> $top10_procentowo,
                                            									'top10_1_kwota'		=> $top10_1_kwota,
                                            									'top10_2_kwota'		=> $top10_2_kwota,
                                            									'top10_3_kwota'		=> $top10_3_kwota,
                                                		    					'$top10_pierwsza_strona' => $top10_pierwsza_strona,
                                            									'klient'		=> $klient,
                                            									'uzytkownik'		=> $uzytkownik,
                                            									'top_max'		=> $top_max));
    		    exit;
            }

            $frazy -> zapisz($id_frazy, $id_klienta, $kwota_za_fraze, $minimalna_kwota_za_fraze, $nazwa, $typ, $top10_procentowo, $top10_1_kwota, $top10_2_kwota, $top10_3_kwota, $top10_pierwsza_strona, $top_max, $link);

			$this -> session -> set('info', 1);

            if($this -> input -> post('redirectBack')) url::redirect('frazy/form/'.$id_frazy.'/'.$id_klienta);
            else url::redirect('frazy/wszystkie/'.$id_klienta);
    	}


    	public function usun($id_frazy, $id_klienta){
    	    // modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');
            $frazy = $this -> load -> model('frazy');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_frazy');
            if(!$acl -> is_allowed($uzytkownik['typ'], 'usun_fraze_etap_'.$klient['etap'])) $this -> load -> error('no-access');

            $frazy -> usun($id_frazy);

            $this -> session -> set('info', 'Fraza została usunięta');

            url::redirect('frazy/wszystkie/'.$id_klienta);
    	}

// Rozpoczęcie testu
    public function popros_o_wycene($id_klienta){
    	    
			// modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $frazy = $this -> load -> model('frazy');
            $klienci = $this -> load -> model('klienci');
            $partnerzy = $this -> load -> model('partnerzy');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_frazy');
            if(!$acl -> is_allowed($uzytkownik['typ'], 'popros_o_wycene_etap_'.$klient['etap'])) $this -> load -> error('no-access');

            // zmienne
            $kwota_ryczaltu = $this -> input -> post('kwota_ryczaltu');
			$top_max = $this -> input -> post('top_max');
			if($this -> session -> get('error')) url::redirect('frazy/wszystkie/'.$id_klienta);
			
/*			//baza pobranie ile ma linków
			$ile_frazow = $frazy->ile_frazow($id_klienta);
			$ile_pktow = $ile_frazow * 3000;
			
			//GL dynks
			$data = array(
					'username' => 'adppoland',
					'md5pass' => '081a6d456f1c76d6ff60bfc9585b1f2b',
					'action' => 'add',
					'type' => 'groups',
					'name' => $klient['adres_strony'],
					'points' => $ile_pktow);
					$ch = curl_init('http://www.gotlink.pl/gotlink-api/'); 
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15); 
					curl_setopt($ch, CURLOPT_TIMEOUT, 15); 
					curl_setopt($ch, CURLOPT_POST, 2); 
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
					$response = curl_exec($ch); 
					$odp = json_decode($response, true);
			if (isset($odp['error']))
			{
			$this -> session -> set('error', 'Uwaga błąd! '.$odp['error']);
			if($this -> session -> get('error')) url::redirect('frazy/wszystkie/'.$id_klienta);
			}
			else
			{
			*/
//			$frazy -> update_grupy_z_gl($response, $id_klienta);
//			$this -> session -> set('info', 'Poprawnie dodano grupę Klienta do GL');
			$frazy -> popros_o_wycene($id_klienta, $kwota_ryczaltu, $top_max);
			$klienci -> zapisz_notatke(date("Y-m-d"), $id_klienta, date("H:i").', '.$uzytkownik['nazwa'].' uruchomił bezpłatny test.');

/*				// email o rozpoczęciu testu do Partner
				$partner = $partnerzy -> jeden($klient['id_partnera']);
				$email = new email();
				$email -> to($partner['mail']);
				$email -> from($uzytkownik['mail']);
				$email -> subject(iconv("UTF-8","ISO-8859-2",'Uruchomenie bezpłatnego testu dla: '.$klient['nazwa']));
				$email -> content(iconv("UTF-8","ISO-8859-2",$uzytkownik['nazwa'].' uruchomił test dla "'.$klient['nazwa'].'"'));
				$email -> send();
				// email o rozpoczęciu testu do Klienta
				$email = new email();
				$email -> to($klient['mail']);
				$email -> from($uzytkownik['mail']);
				$email -> subject(iconv("UTF-8","ISO-8859-2",ROZP_TEST_TEMAT));
				$email -> content(iconv("UTF-8","ISO-8859-2",ROZP_TEST_TRESC1.$klient['hash'].'">Panel wyników</a>'.ROZP_TEST_TRESC2));
				$email -> send();*/
				$this -> session -> set('info', 'Uruchomiono bezpłatny test.');
			url::redirect('frazy/wszystkie/'.$id_klienta);
//			}
	}
//Anulowanie testu
    public function anuluj_prosbe_o_wycene($id_klienta){
    	    // modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $frazy = $this -> load -> model('frazy');
            $klienci = $this -> load -> model('klienci');
			$partnerzy = $this -> load -> model('partnerzy');
			
            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']))
			{$this -> load -> error('no-access');}
            $acl = $this -> acl -> get('acl_frazy');
            if(!$acl -> is_allowed($uzytkownik['typ'], 'anuluj_prosbe_o_wycene_etap_'.$klient['etap'])) 
			{$this -> load -> error('no-access');}

/*			//ogień
			if ($klient['gotlink_grupa'] == 0){
			$this -> session -> set('error', 'Test anulowany POPRAWNIE, ale nie mogłem go usunąć z GL, trzeba zrobić to ręcznie.');
			}
			else
			{
				$data = array(
					'username' => 'adppoland',
					'md5pass' => '081a6d456f1c76d6ff60bfc9585b1f2b',
					'action' => 'delete',
					'type' => 'groups',
					'id' => $klient['gotlink_grupa']);
					$ch = curl_init('http://www.gotlink.pl/gotlink-api/'); 
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15); 
					curl_setopt($ch, CURLOPT_TIMEOUT, 15); 
					curl_setopt($ch, CURLOPT_POST, 2); 
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
					$response = curl_exec($ch); 
					$odp = json_decode($response, true);
						if (isset($odp['error']))
						{
						$this -> session -> set('error', 'Uwaga błąd! '.$odp['error']);
							if($this -> session -> get('error')) url::redirect('frazy/wszystkie/'.$id_klienta);
						}
						else{
						$frazy -> usun_info_grupy_gl_z_bazy($id_klienta);
						}
				
			}
*/			
			$frazy -> anuluj_prosbe_o_wycene($id_klienta);
			$klienci -> zapisz_notatke(date("Y-m-d"), $id_klienta, date("H:i").', '.$uzytkownik['nazwa'].' anulował bezpłatny test.');
			$dnk = date(N);
			if ($dnk == 7){
			$data_next_kontakta = date('Y-m-d', strtotime($data_next_kontakta . ' + 1 day'));
			$klienci -> uaktualnij_date_nastepny_kontakt($data_next_kontakta,$id_klienta);
			}
			else if ($dnk == 6){
			$data_next_kontakta = date('Y-m-d', strtotime($data_next_kontakta . ' + 2 days'));
			$klienci -> uaktualnij_date_nastepny_kontakt($data_next_kontakta,$id_klienta);
			}
			else{
			$klienci -> uaktualnij_date_nastepny_kontakt(date("Y-m-d"),$id_klienta);
			}
			
			// email o anulowaniu testu do Partner
            $partner = $partnerzy -> jeden($klient['id_partnera']);
            $email = new email();
            $email -> to($partner['mail']);
            $email -> from($uzytkownik['mail']);
            $email -> subject(iconv("UTF-8","ISO-8859-2",'Anulowanie bezpłatnego testu dla: '.$klient['nazwa']));
            $email -> content(iconv("UTF-8","ISO-8859-2",$uzytkownik['nazwa'].' anulował test dla "'.$klient['nazwa'].'"'));
            $email -> send();
			
            $this -> session -> set('info', 'Test został anulowany.');

            url::redirect('frazy/wszystkie/'.$id_klienta);
		}
    

// Zakończenie testu
    public function zatwierdz_wycene($id_klienta){
    	    // modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $frazy = $this -> load -> model('frazy');
            $klienci = $this -> load -> model('klienci');
            $partnerzy = $this -> load -> model('partnerzy');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_frazy');
            if(!$acl -> is_allowed($uzytkownik['typ'], 'zatwierdz_wycene_etap_'.$klient['etap'])) $this -> load -> error('no-access');
	
		//ogień
/*		if ($klient['gotlink_grupa'] == 0){
			$this -> session -> set('error', 'Test anulowany POPRAWNIE, ale nie mogłem go usunąć z GL, trzeba zrobić to ręcznie.');
			}
			else
			{
					$data = array(
					'username' => 'adppoland',
					'md5pass' => '081a6d456f1c76d6ff60bfc9585b1f2b',
					'action' => 'delete',
					'type' => 'groups',
					'id' => $klient['gotlink_grupa']);
					$ch = curl_init('http://www.gotlink.pl/gotlink-api/'); 
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15); 
					curl_setopt($ch, CURLOPT_TIMEOUT, 15); 
					curl_setopt($ch, CURLOPT_POST, 2); 
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
					$response = curl_exec($ch); 
					$odp = json_decode($response, true);
					if (isset($odp['error']))
					{
					$this -> session -> set('error', 'Uwaga błąd! '.$odp['error']);
					if($this -> session -> get('error')) url::redirect('frazy/wszystkie/'.$id_klienta);
					}
					else
					{		
					$frazy -> usun_info_grupy_gl_z_bazy($id_klienta);
					$this -> session -> set('info', 'Test zakończony poprawnie');
					}
		}
            // zmienne
*/			
            $kwota_ryczaltu = $this -> input -> post('kwota_ryczaltu');
			$top_max = $this -> input -> post('top_max');
            $frazy -> zatwierdz_wycene($id_klienta, $kwota_ryczaltu, $top_max);
/*			
            // mail
            $partner = $partnerzy -> jeden($klient['id_partnera']);
            $email = new email();
            $email -> to($partner['mail']);
            $email -> from($uzytkownik['mail']);
            $email -> subject(iconv("UTF-8","ISO-8859-2",'Zakończenie bezpłatnego testu dla: '.$klient['nazwa']));
            $email -> content(iconv("UTF-8","ISO-8859-2",'Bezpłatny test został zakończony dla "'.$klient['nazwa'].'" '));
            $email -> send();
			// email o zakończeniu testu do Klienta
			$email = new email();
            $email -> to($klient['mail']);
            $email -> from($uzytkownik['mail']);
            $email -> subject(iconv("UTF-8","ISO-8859-2",END_TEST_TEMAT));
            $email -> content(iconv("UTF-8","ISO-8859-2",EOT_1.$klient['odsetek_fraz_w_top_10_ilosc'].EOT_2.$klient['hash'].'">Panel wyników</a>'.EOT_3));
            $email -> send();*/
			$klienci -> zapisz_notatke(date("Y-m-d"), $id_klienta, date("H:i").', '.$uzytkownik['nazwa'].' zakończył bezpłatny test.');
			
			$dnk = date('N');
			if ($dnk == 7){
			$data_next_kontakta = date('Y-m-d', strtotime($data_next_kontakta . ' + 1 day'));
			$klienci -> uaktualnij_date_nastepny_kontakt($data_next_kontakta,$id_klienta);
			}
			else if ($dnk == 6){
			$data_next_kontakta = date('Y-m-d', strtotime($data_next_kontakta . ' + 2 days'));
			$klienci -> uaktualnij_date_nastepny_kontakt($data_next_kontakta,$id_klienta);
			}
			else{
			$klienci -> uaktualnij_date_nastepny_kontakt(date("Y-m-d"),$id_klienta);
			}
            url::redirect('frazy/wszystkie/'.$id_klienta);
			
    }


    	public function zapisz_wycene($id_klienta){
    	    // modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $frazy = $this -> load -> model('frazy');
            $klienci = $this -> load -> model('klienci');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_frazy');
            if(!$acl -> is_allowed($uzytkownik['typ'], 'zapisz_wycene_etap_'.$klient['etap'])) $this -> load -> error('no-access');

            // zmienne
            $kwota_ryczaltu = $this -> input -> post('kwota_ryczaltu');
			$top_max = $this -> input -> post('top_max');
            

            if($this -> session -> get('error')) url::redirect('frazy/wszystkie/'.$id_klienta);

            $frazy -> zapisz_wycene($id_klienta, $kwota_ryczaltu, $top_max);

            $this -> session -> set('info', 'Wycena zapisana');

            url::redirect('frazy/wszystkie/'.$id_klienta);
    	}

//Po teście zrezygnował
    	public function popros_o_rozpoczecie($id_klienta){
    	    // modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $frazy = $this -> load -> model('frazy');
            $klienci = $this -> load -> model('klienci');
            $partnerzy = $this -> load -> model('partnerzy');
			
            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_frazy');
            if(!$acl -> is_allowed($uzytkownik['typ'], 'popros_o_rozpoczecie_etap_'.$klient['etap'])) $this -> load -> error('no-access');

            $frazy -> popros_o_rozpoczecie($id_klienta);

            $klienci -> zapisz_notatke(date("Y-m-d"), $id_klienta, 'Klient po teście zrezygnował lub został przeniesiony na późniejszy termin. Kliknięte przez: '.$uzytkownik['nazwa']);

            // mail
            $partner = $partnerzy -> jeden($klient['id_partnera']);
            $email = new email();
            $email -> to($partner['mail']);
            $email -> from($uzytkownik['mail']);
            $email -> subject(iconv("UTF-8","ISO-8859-2",E_MAIL_TITLE_COMPANY_NAME.' | Klient po teście zrezygnował lub zawiesił'));
            $email -> content(iconv("UTF-8","ISO-8859-2",'Klient zrezygnował po teście, lub rozmowy zostały przeniesione na późniejszy termin. "'.$klient['nazwa'].'"'));
            $email -> send();

            $this -> session -> set('info', 'Klient zawieszony.');

            url::redirect('frazy/wszystkie/'.$id_klienta);
    	}

// Podpisał umowę Klient
    	public function rozpocznij($id_klienta){
    	    // modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $frazy = $this -> load -> model('frazy');
            $klienci = $this -> load -> model('klienci');
            $partnerzy = $this -> load -> model('partnerzy');
			
			$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);
			$tech_numerek = file_get_contents('techniczny.txt');
			if($tech_numerek == 1){
			$idpoz = 2;
			file_put_contents('techniczny.txt', 0);
			}
			else{
			$idpoz = 4;
			file_put_contents('techniczny.txt', 1);
			}
			
			$pozycjoner = $this -> load -> model('pozycjonerzy') -> jeden($idpoz);
			$frazy -> rozpocznij($id_klienta, $idpoz);
			
			$klienci -> zapisz_notatke(date("Y-m-d"), $id_klienta, 'Pozycjonowanie zostało rozpoczęte. Kliknął: '.$uzytkownik['nazwa']);
			
            // mail do partnera
            
			$partner = $partnerzy -> jeden($klient['id_partnera']);
            $email = new email();
            $email -> to($partner['mail']);
            $email -> from($uzytkownik['mail']);
            $email -> subject(iconv("UTF-8","ISO-8859-2",E_MAIL_TITLE_COMPANY_NAME.' | Pozycjonowanie zostało rozpoczęte'));
            $email -> content(iconv("UTF-8","ISO-8859-2",'ADP Poland Sp. z o.o. rozpoczął pozycjonowanie klienta "'.$klient['nazwa'].'"'));
            $email -> send();
			
			// mail do pozycjonera
            
			
            $email = new email();
            $email -> to($pozycjoner['mail']);
            $email -> from($uzytkownik['mail']);
            $email -> subject(iconv("UTF-8","ISO-8859-2",$uzytkownik['nazwa'].' rozpoczął pozycjonowanie "'.$klient['adres_strony'].'" i przypisał go Tobie'));
            $email -> content(iconv("UTF-8","ISO-8859-2",$uzytkownik['nazwa'].' rozpoczął pozycjonowanie "'.MAIL_TECHNICZNY1.$klient['id_klienta'].MAIL_TECHNICZNY2.$klient['nazwa'].MAIL_TECHNICZNY4));
            $email -> send();

            $this -> session -> set('info', 'Pozycjonowanie zostało rozpoczęte, pozycjoner przypisany i poinformowany.');

            url::redirect('frazy/wszystkie/'.$id_klienta);
    	}


    	public function zawies($id_klienta){
    	    // modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $frazy = $this -> load -> model('frazy');
            $klienci = $this -> load -> model('klienci');
            $partnerzy = $this -> load -> model('partnerzy');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_frazy');
            if(!$acl -> is_allowed($uzytkownik['typ'], 'zawies_etap_'.$klient['etap'])) $this -> load -> error('no-access');

            $frazy -> zawies($id_klienta);

            $klienci -> zapisz_notatke(date("Y-m-d"), $id_klienta, 'Pozycjonowanie zostało zawieszone. Kliknął: '.$uzytkownik['nazwa']);

            // mail do partnera
            $partner = $partnerzy -> jeden($klient['id_partnera']);
            $email = new email();
            $email -> to($partner['mail']);
            $email -> from($uzytkownik['mail']);
            $email -> subject(iconv("UTF-8","ISO-8859-2",E_MAIL_TITLE_COMPANY_NAME.' | Pozycjonowanie zostało zawieszone'));
            $email -> content(iconv("UTF-8","ISO-8859-2",'Pozycjoner zawiesił pozycjonowanie klienta "'.$klient['nazwa'].'"'));
            $email -> send();

            $this -> session -> set('info', 'Pozycjonowanie zostało zawieszone.');

            url::redirect('frazy/wszystkie/'.$id_klienta);
    	}

    	public function wznow($id_klienta){
    	    // modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $frazy = $this -> load -> model('frazy');
            $klienci = $this -> load -> model('klienci');
            $partnerzy = $this -> load -> model('partnerzy');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_frazy');
            if(!$acl -> is_allowed($uzytkownik['typ'], 'wznow_etap_'.$klient['etap'])) $this -> load -> error('no-access');

            $frazy -> wznow($id_klienta);

            $klienci -> zapisz_notatke(date("Y-m-d"), $id_klienta, 'Pozycjonowanie zostało wznowione.');

            // mail do partnera
            $partner = $partnerzy -> jeden($klient['id_partnera']);
            $email = new email();
            $email -> to($partner['mail']);
            $email -> from($uzytkownik['mail']);
            $email -> subject(iconv("UTF-8","ISO-8859-2",E_MAIL_TITLE_COMPANY_NAME.' | Pozycjonowanie zostało wznowione'));
            $email -> content(iconv("UTF-8","ISO-8859-2",'Pozycjoner wznowił pozycjonowanie klienta "'.$klient['nazwa'].'"'));
            $email -> send();

            $this -> session -> set('info', 'Pozycjonowanie zostało wznowione.');

            url::redirect('frazy/wszystkie/'.$id_klienta);
    	}


    	public function skasuj_wycene($id_klienta){
    	    // modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $frazy = $this -> load -> model('frazy');
            $klienci = $this -> load -> model('klienci');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_frazy');
            if(!$acl -> is_allowed($uzytkownik['typ'], 'skasuj_wycene_etap_'.$klient['etap'])) $this -> load -> error('no-access');

            $frazy -> skasuj_wycene($id_klienta);

            $klienci -> zapisz_notatke(date("Y-m-d"), $id_klienta, 'Wycena została skasowana.');

            $this -> session -> set('info', 'Wycena została skasowana. Możesz wprowadzić nowe słowa, itd...');

            url::redirect('frazy/wszystkie/'.$id_klienta);
    	}


        public function pozycje($id_klienta, $data = 0){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');

            if(!$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_frazy');
            if(!$acl -> is_allowed($uzytkownik['typ'], 'pozycje_etap_'.$klient['etap'])) $this -> load -> error('no-access');

            $frazy = $this -> load -> model('frazy');

            $data = $data ? $data : date("Y-m-d");
            $aktualne_data = $data;
            $wczesniejsze_data = date('Y-m-d', strtotime('-1 day', strtotime($aktualne_data)));

            $aktualne_pozycje = $frazy -> wyniki_na_dzien($aktualne_data, $id_klienta);
            $aktualne_pierwsze_strony = $frazy -> pierwsze_strony_na_dzien($aktualne_data, $id_klienta);
            $wczesniejsze_pozycje = $frazy -> wyniki_na_dzien($wczesniejsze_data, $id_klienta);
            $wczesniejsze_pierwsze_strony = $frazy -> pierwsze_strony_na_dzien($wczesniejsze_data, $id_klienta);

            $frazy = $frazy -> wszystkie($id_klienta);

    		$this -> load -> view('pozycje_formularz', array('aktualne_pozycje' => $aktualne_pozycje,
    		                                                 'aktualne_pierwsze_strony' => $aktualne_pierwsze_strony,
    		                                                 'data' => $data,
    		                                                 'frazy' => $frazy,
    		                                                 'klient' => $klient,
    		                                                 'uzytkownik' => $uzytkownik,
    		                                                 'wczesniejsze_pierwsze_strony' => $wczesniejsze_pierwsze_strony,
    		                                                 'wczesniejsze_pozycje' => $wczesniejsze_pozycje));
        }


        public function zapisz_pozycje($id_klienta, $data = 0){
            // modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $frazy = $this -> load -> model('frazy');
            $klienci = $this -> load -> model('klienci');

            // prawa dostepu
            if(!$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            $acl = $this -> acl -> get('acl_frazy');
            if(!$acl -> is_allowed($uzytkownik['typ'], 'pozycje_etap_'.$klient['etap'])) $this -> load -> error('no-access');

            // zmienne
            $pierwsze_strony = $this -> input -> post('pierwsze_strony');
            $pozycje = $this -> input -> post('pozycje');

            // walidacja
            if(!$pozycje || !is_array($pozycje) || !$data) $this -> load -> error('404');

            $frazy -> zapisz_pozycje($data, $id_klienta, $pierwsze_strony, $pozycje);

            $this -> session -> set('info', 1);

            if($this -> input -> post('redirectBack')) url::redirect('frazy/pozycje/'.$id_klienta.'/'.$data);
            else url::redirect('klienci/profil/'.$id_klienta);
        }
		
		
		
		
		
		
		
		
		
	public function wyslij_email($id_klienta){
	// modele
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $frazy = $this -> load -> model('frazy');
            $klienci = $this -> load -> model('klienci');
            $partnerzy = $this -> load -> model('partnerzy');

            // prawa dostępu
            if(!$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            
            
	
	$data_utworzenia = $this -> input -> post('data_utworzenia');
	
	$tresci = $this -> input -> post('tresc_email');
	$tematy = $this -> input -> post('temat');
	
	if(!$tresci) $this -> session -> set('error', 1);
	
	if($this -> session -> get('error')){
    		    $this -> load -> view('notatki_klienta_formularz', array('notatka' => array('data_utworzenia' => $data_utworzenia,
																							'tresc_email' => $tresci,
																							'uzytkownik' => $uzytkownik)));
																							exit;
            }
	$tresc = date("H:i").', '.$uzytkownik['nazwa'].' Wysłał email o temacie: '.$tematy.' O treści: '.$tresci;
	$klienci -> zapisz_notatke($data_utworzenia, $id_klienta, $tresc);
	
	$partner = $partnerzy -> jeden($klient['id_partnera']);
	        $email = new email();
            $email -> to($klient['mail']);
            $email -> from($uzytkownik['mail']);
            $email -> subject(iconv("UTF-8","ISO-8859-2",$tematy));
            $email -> content(iconv("UTF-8","ISO-8859-2",$tresci.STOPKA_EMAILA));
            $email -> send();
	

            url::redirect('klienci/profil/'.$id_klienta);
	
	}
//===============================================================================================================
//===============================================================================================================
//
//
// Klawisze do zmiany bez infa.
//
//
//===============================================================================================================
//===============================================================================================================	
	public function dla_handlowca($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
        $frazy = $this -> load -> model('frazy');
        $klienci = $this -> load -> model('klienci');
		$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, 'admin');
        
	$handl_numerek = file_get_contents('handlowiec.txt');
			if($handl_numerek == 1){
			$handlowiec = 15;
			$emil='zzwirblinski@adppoland.pl';
			file_put_contents('handlowiec.txt', 2);
			}
			else if($handl_numerek == 2){
			$handlowiec = 17;
			$emil='akarkulewska@adppoland.pl';
			file_put_contents('handlowiec.txt', 3);
			}
			else if($handl_numerek == 3){
			$handlowiec = 19;
			$emil='alasota@adppoland.pl';
			file_put_contents('handlowiec.txt', 4);
			}
			else if($handl_numerek == 4){
			$handlowiec = 31;
			$emil='mmasiowska@adppoland.pl';
			file_put_contents('handlowiec.txt', 1);
			}
		
		$email = new email();
		$email -> to($emil);
		$email -> from($uzytkownik['mail']);
		$email -> subject(iconv("UTF-8","ISO-8859-2",'"'.$klient['nazwa'].'" został ustawiony jako "Klient dla Handlowca"'));
		$email -> content(iconv("UTF-8","ISO-8859-2",'A ustawił to : '.$uzytkownik['nazwa'].'.'));
		$email -> send();	

		$email = new email();
		$email -> to('mb@adppoland.pl');
		$email -> from($uzytkownik['mail']);
		$email -> subject(iconv("UTF-8","ISO-8859-2",'"'.$klient['nazwa'].'" został ustawiony jako "Klient dla Handlowca"'));
		$email -> content(iconv("UTF-8","ISO-8859-2",'Dostał(a) '.$emil.' A ustawił to : '.$uzytkownik['nazwa'].'.'));
		$email -> send();		
		
		$frazy -> dla_handlowca($id_klienta, $handlowiec);
		url::redirect('frazy/wszystkie/'.$id_klienta);	
	}
	
	public function na_uslugi($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
        $frazy = $this -> load -> model('frazy');
        $klienci = $this -> load -> model('klienci');
		$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, 'admin');
        $frazy -> na_uslugi($id_klienta);
		$klienci -> zapisz_notatke(date("Y-m-d"), $id_klienta, 'Przeniesiony na etap Usługi. Kliknął: '.$uzytkownik['nazwa']);
		url::redirect('frazy/wszystkie/'.$id_klienta);		
	}
	
	public function zakoncz_bez_testu($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
        $frazy = $this -> load -> model('frazy');
        $klienci = $this -> load -> model('klienci');
		$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, 'admin');
        $frazy -> zakoncz_bez_testu($id_klienta, $handlowiec);
		url::redirect('frazy/wszystkie/'.$id_klienta);			
	}
	
	public function podpisz_umowe($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
        $frazy = $this -> load -> model('frazy');
        $klienci = $this -> load -> model('klienci');
        $partnerzy = $this -> load -> model('partnerzy');
		$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, 'admin');
		$partner = $partnerzy -> jeden($klient['id_partnera']);
		
		$tech_numerek = file_get_contents('techniczny.txt');
			if($tech_numerek == 1){
			$idpoz = 2;
			file_put_contents('techniczny.txt', 0);
			}
			else{
			$idpoz = 3;
			file_put_contents('techniczny.txt', 1);
			}
		if($frazy -> podpisz_umowe($id_klienta, $idpoz))
			{
			$email = new email();
			$email -> to($partner['mail']);
			$email -> from($uzytkownik['mail']);
			$email -> subject(iconv("UTF-8","ISO-8859-2",'Przeneisiono: "'.$klient['nazwa'].'" na etap Pozycjonowanie'));
			$email -> content(iconv("UTF-8","ISO-8859-2",$uzytkownik['nazwa'].' przeniósł "'.$klient['nazwa'].'" na etap POZYCJONOWANIE'));
			$email -> send();
			
			$klienci -> zapisz_notatke(date("Y-m-d"), $id_klienta, 'Pozycjonowanie zostało rozpoczęte. Kliknął: '.$uzytkownik['nazwa']);

            // mail do pozycjonera
            $pozycjoner = $this -> load -> model('pozycjonerzy') -> jeden($idpoz);
			$email = new email();
            $email -> to($pozycjoner['mail']);
            $email -> from($uzytkownik['mail']);
            $email -> subject(iconv("UTF-8","ISO-8859-2",$uzytkownik['nazwa'].' zmienił etap dla "'.$klient['adres_strony'].'" na Pozycjonowanie'));
            $email -> content(iconv("UTF-8","ISO-8859-2",$uzytkownik['nazwa'].' zmienił etap dla "'.MAIL_TECHNICZNY1.$klient['id_klienta'].MAIL_TECHNICZNY2.$klient['nazwa'].MAIL_TECHNICZNY3));
            $email -> send();
			
			$this -> session -> set('info', 'Przeniesiono poprawnie na etap: POZYCJONOWANIE, dodano pozycjonera i go poinformowano.');
			}
		else
			{
			$this -> session -> set('error', 'BŁĄD !! Nie przeniesiono Klienta!');
			}
		url::redirect('frazy/wszystkie/'.$id_klienta);
	}
	public function od_nowa($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
		$frazy = $this -> load -> model('frazy');
		$klienci = $this -> load -> model('klienci');
		$partnerzy = $this -> load -> model('partnerzy');
		$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, 'admin');
		$partner = $partnerzy -> jeden($klient['id_partnera']);
	
		if($frazy -> od_nowa($id_klienta)){
			$email = new email();
			$email -> to($partner['mail']);
			$email -> from($uzytkownik['mail']);
			$email -> subject(iconv("UTF-8","ISO-8859-2",'Cofnięcie: "'.$klient['nazwa'].'" na etap Nowy Klient'));
			$email -> content(iconv("UTF-8","ISO-8859-2",$uzytkownik['nazwa'].' cofnął "'.$klient['nazwa'].'" na etap NOWY KLIENT'));
			$email -> send();
		$this -> session -> set('info', 'Przeniesiono poprawnie na etap: NOWY KLIENT');
		}
		else
		{
		$this -> session -> set('error', 'BŁĄD !! Nie przeniesiono Klienta!');
		}
		url::redirect('frazy/wszystkie/'.$id_klienta);
	}
	
	
	
	
	protected function generatePairs($phrases, $count=1) {
		$phrasesNames = array();
		$phrasesCounts = array();

		foreach($phrases as $phrase) {
			$phrasesNames[] = $phrase['nazwa'];
			$phrasesCounts[] = 0;
		}

		$result = array();
		$numPhrases = count($phrasesNames);
					
		while(!$this->areAllPhrasesDone($phrasesCounts, $count)) {
			$pair = '';
			
			if($this->numPhrasesNotDone($phrasesCounts, $count) == 1) {
				
				foreach ($phrasesCounts as $phrasesCount) {
					if($phrasesCount < ($count-1)) {
// 						echo 'orphan<br>';
						// orphaned phrase, discard results, generate from beginning
						return $this->generatePairs($phrases, $count);
					}
				}
				
				$random1 = $this->getRandomPhraseIndex($phrasesCounts, $count, $phrasesNames);
				$phrasesCounts[$random1] += 1;
				
				$pair = $phrasesNames[$random1];
				
			} else {
				$random1 = $this->getRandomPhraseIndex($phrasesCounts, $count, $phrasesNames);
				$random2 = $this->getRandomPhraseIndex($phrasesCounts, $count, $phrasesNames, $random1);
								
				$phrasesCounts[$random1] += 1;
				$phrasesCounts[$random2] += 1;
					
				$pair = $phrasesNames[$random1] . '; ' . $phrasesNames[$random2];				
			}

			$result[] = $pair;
		}

		if($numPhrases == 1) {
			$result[] = $phrasesNames[0];
		}
		
		return $result;

	}

	private function getRandomPhraseIndex($phrasesCounts, $targetCount, $phrasesNames, $other=-1) {
		$numPhrases = count($phrasesNames);
		
		$random = $other;

		while($random == $other) {
			$random = rand(0, $numPhrases-1);
			if($this->isPhraseDone($phrasesCounts, $targetCount, $random)) {
				$random = $other;
			}
		}

		return $random;
	}
	
	private function isPhraseDone($phrasesCounts, $targetCount, $phraseIndex) {
		return $phrasesCounts[$phraseIndex] >= $targetCount;
	}

	private function areAllPhrasesDone($phrasesCounts, $targetCount) {
		$done = true;
		foreach($phrasesCounts as $phraseCount) {
			if($phraseCount < $targetCount) {
				$done = false;
			}
		}
		return $done;
	}

	private function numPhrasesNotDone($phrasesCounts, $targetCount) {
		$notDone = 0;
		foreach($phrasesCounts as $phraseCount) {
			if($phraseCount < $targetCount) {
				$notDone++;
			}
		}

		return $notDone;
	}


	public function genpairs($id_klienta, $count) {
		
		if(isset($_POST['genpairs_topic'])) {
			$topic = $_POST['genpairs_topic'];
			$_SESSION['genpairs_topic'] = $topic;
		} else {
			$_SESSION['genpairs_topic'] = 'temat';
		}
		
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
		$klienci = $this -> load -> model('klienci');

		if(isset($_POST['count'])) {
			$count = $_POST['count'];
		}

		if(!$klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
		
		$_frazy = $this -> load -> model('frazy');

		$frazy = $_frazy -> wszystkie($id_klienta);

		$acl = $this -> acl -> get('acl_frazy');

		$generatedPairs = array();

		if($acl -> is_allowed($uzytkownik['typ'], 'generuj_pary')) {
			$generatedPairs = $this->generatePairs($frazy, $count);
		} else {
			$generatedPairs = array('Brak dostępu.');
		}

		$this -> load -> view('genpairs',
				array(
						'generatedPairs' => $generatedPairs,
						'idKlienta' => $id_klienta,
						'category' => $klient['kategoria'],
						'clientPage' => $klient['adres_strony'],
						'count' => $count,
				));


	}
	
	
	
	
	
	
	
}
?>