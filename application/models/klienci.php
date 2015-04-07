<?php

    class klienci_model{

        // lista
        public function lista($uzytkownik, $limit = 0, $offset = 0){

            // select lub count
            if(!$limit && !$offset) $query = 'SELECT count(*) as number FROM klienci ';
            else $query = 'SELECT * FROM klienci ';

            $query .= "WHERE ";

            // blokada na id partnera, id pozycjonera
            if($uzytkownik['typ'] == 'partner') $query .= 'AND id_partnera = "'.$uzytkownik['id'].'" ';
            else if($uzytkownik['typ'] == 'pozycjoner') $query .= 'AND id_pozycjonera = "'.$uzytkownik['id'].'" ';

            // filtr na id partnera dla admin
            if($uzytkownik['typ'] == 'admin'){
                $filtr_partner = $this -> input -> cookie('filtr_klienci_partner');
                $filtr_partner = $this -> db -> clean($filtr_partner);
                if($filtr_partner) $query .= 'AND id_partnera = "'.$filtr_partner.'" ';
            }
			
			// filtr na id pozycjonera dla admin
            if($uzytkownik['typ'] == 'admin'){
                $filtr_pozycjoner = $this -> input -> cookie('filtr_klienci_pozycjoner');
                $filtr_pozycjoner = $this -> db -> clean($filtr_pozycjoner);
                if($filtr_pozycjoner) $query .= 'AND id_pozycjonera = "'.$filtr_pozycjoner.'" ';
            }
			
			if($uzytkownik['typ'] == 'admin'){
                $filtr_telemarketer = $this -> input -> cookie('filtr_klienci_telemarketer');
                $filtr_telemarketer = $this -> db -> clean($filtr_telemarketer);
                if($filtr_telemarketer) $query .= 'AND id_1_partnera = "'.$filtr_telemarketer.'" ';
            }

            // filtr na etap
            $filtr_etap = $this -> input -> cookie('filtr_klienci_etap');
            $filtr_etap = $this -> db -> clean($filtr_etap);
            if($filtr_etap) $query .= 'AND etap = "'.$filtr_etap.'" ';

            // filtr na dzień
            $filtr_dzien = $this -> input -> cookie('filtr_klienci_dzien');
            $filtr_dzien = $this -> db -> clean($filtr_dzien);
            if($filtr_dzien){
                if($filtr_dzien == 'zalegajacy') $query .= 'AND data_nastepnego_kontaktu < "'.date("Y-m-d").'" ';
                else if($filtr_dzien == 'dzis') $query .= 'AND data_nastepnego_kontaktu = "'.date("Y-m-d").'" ';
                else if($filtr_dzien == 'jutro') $query .= 'AND data_nastepnego_kontaktu = "'.date("Y-m-d", strtotime("+1 day")).'" ';
                else $query .= 'AND data_nastepnego_kontaktu = "'.$filtr_dzien.'" ';
            }

            // filtr na rozliczenia
            $filtr_rozliczenia = $this -> input -> cookie('filtr_klienci_rozliczenia');
            $filtr_rozliczenia = $this -> db -> clean($filtr_rozliczenia);
            if($filtr_rozliczenia){
                if($filtr_rozliczenia == 'rozliczani') $query .= 'AND faktury_za_pozycjonowanie = 1 ';
                else if($filtr_rozliczenia == 'nierozliczani') $query .= 'AND faktury_za_pozycjonowanie = 0 ';
            }
			
			// filtr na SEO
            $filtr_seo = $this -> input -> cookie('filtr_klienci_seo');
            $filtr_seo = $this -> db -> clean($filtr_seo);
            if($filtr_seo){
                if($filtr_seo == 'dopoprawienia') $query .= 'AND poprawa = 1 ';
                else if($filtr_seo == 'niedopoprawienia') $query .= 'AND poprawa = 0 ';
				
            }
				
			// filtr na NBN
            $filtr_nbn = $this -> input -> cookie('filtr_klienci_nbn');
            $filtr_nbn = $this -> db -> clean($filtr_nbn);
            if($filtr_nbn){
                if($filtr_nbn == 'beznbn') $query .= 'AND niebonie = 0 ';
				else if($filtr_nbn == 'znbn') $query .= 'AND niebonie = 1 ';
            }
			
			// filtr na GL
            $filtr_gl = $this -> input -> cookie('filtr_klienci_gl');
            $filtr_gl = $this -> db -> clean($filtr_gl);
            if($filtr_gl){
                if($filtr_gl == 'magrwgotlinku') $query .= 'AND gotlink_grupa != 0 ';
				else if($filtr_gl == 'niemagrwgotlinku') $query .= 'AND gotlink_grupa = 0 ';
            }
			
			// filtr na OPT
            $filtr_opt = $this -> input -> cookie('filtr_klienci_opt');
            $filtr_opt = $this -> db -> clean($filtr_opt);
            if($filtr_opt){
                if($filtr_opt == 'zoptymalizowane') $query .= 'AND optymalizacja = 1 ';
                else if($filtr_opt == 'niezoptymalizowane') $query .= 'AND optymalizacja = 0 ';
            }

            // filtr na OPT Meta
            $filtr_optmeta = $this -> input -> cookie('filtr_klienci_optmeta');
            $filtr_optmeta = $this -> db -> clean($filtr_optmeta);
            if($filtr_optmeta){
                if($filtr_optmeta == 'metatak') $query .= 'AND opt_meta = 1 ';
                else if($filtr_optmeta == 'metanie') $query .= 'AND opt_meta = 0 ';
            }
			
			// filtr na dostepy
            $filtr_dst = $this -> input -> cookie('filtr_klienci_dst');
            $filtr_dst = $this -> db -> clean($filtr_dst);
            if($filtr_dst){
                if($filtr_dst == 'zdst') $query .= 'AND dostepy = 1 ';
                else if($filtr_dst == 'bezdst') $query .= 'AND dostepy = 0 ';
            }
			
			// filtr na teksty
            $filtr_txt = $this -> input -> cookie('filtr_klienci_txt');
            $filtr_txt = $this -> db -> clean($filtr_txt);
            if($filtr_txt){
                if($filtr_txt == 'ztxt') $query .= 'AND teksty = 1 ';
                else if($filtr_txt == 'beztxt') $query .= 'AND teksty = 0 ';
            }
			
			// filtr na vip
            $filtr_vip = $this -> input -> cookie('filtr_klienci_vip');
            $filtr_vip = $this -> db -> clean($filtr_vip);
            if($filtr_vip){
                if($filtr_vip == 'vip') $query .= 'AND vip = 1 ';
                else if($filtr_vip == 'nievip') $query .= 'AND vip = 0 ';
            }
			
			// filtr na ryczałt
            $filtr_rycz = $this -> input -> cookie('filtr_klienci_rycz');
            $filtr_rycz = $this -> db -> clean($filtr_rycz);
            if($filtr_rycz){
                if($filtr_rycz == 'rycz') $query .= 'AND kwota_ryczaltu > 0 ';
                else if($filtr_rycz == 'nierycz') $query .= 'AND kwota_ryczaltu = 0.00 ';
            }
			
			// filtr na kategorie
            $kategoria = $this -> input -> cookie('filtr_kategoria');
            $kategoria = $this -> db -> clean($kategoria);
            if($kategoria){
                if($kategoria == '1') $query .= 'AND kategoria = 1 ';
                else if($kategoria == '2') $query .= 'AND kategoria = 2 ';
				else if($kategoria == '3') $query .= 'AND kategoria = 3 ';
				else if($kategoria == '4') $query .= 'AND kategoria = 4 ';
				else if($kategoria == '5') $query .= 'AND kategoria = 5 ';
				else if($kategoria == '6') $query .= 'AND kategoria = 6 ';
				else if($kategoria == '7') $query .= 'AND kategoria = 7 ';
				else if($kategoria == '8') $query .= 'AND kategoria = 8 ';
				else if($kategoria == '9') $query .= 'AND kategoria = 9 ';
				else if($kategoria == '10') $query .= 'AND kategoria = 10 ';
				else if($kategoria == '11') $query .= 'AND kategoria = 11 ';
				else if($kategoria == '12') $query .= 'AND kategoria = 12 ';
				else if($kategoria == '13') $query .= 'AND kategoria = 13 ';
				else if($kategoria == '14') $query .= 'AND kategoria = 14 ';
            }
			
			// filtr na katalogi
            $filtr_kat = $this -> input -> cookie('filtr_klienci_kat');
            $filtr_kat = $this -> db -> clean($filtr_kat);
            if($filtr_kat){
                if($filtr_kat == 'kat') $query .= 'AND katalogi = 1 ';
                else if($filtr_kat == 'niekat') $query .= 'AND katalogi = 0 ';
            }
			
			// filtr na swl
            $filtr_swl = $this -> input -> cookie('filtr_klienci_swl');
            $filtr_swl = $this -> db -> clean($filtr_swl);
            if($filtr_swl){
                if($filtr_swl == 'swl') $query .= 'AND SWL = 1 ';
                else if($filtr_swl == 'nieswl') $query .= 'AND SWL = 0 ';
            }
			
			// filtr na zaplecza
            $filtr_zap = $this -> input -> cookie('filtr_klienci_zap');
            $filtr_zap = $this -> db -> clean($filtr_zap);
            if($filtr_zap){
                if($filtr_zap == 'zap') $query .= 'AND zaplecza = 1 ';
                else if($filtr_zap == 'niezap') $query .= 'AND zaplecza = 0 ';
            }
			// filtr na zaplecza
            $filtr_ban = $this -> input -> cookie('filtr_klienci_ban');
            $filtr_ban = $this -> db -> clean($filtr_ban);
            if($filtr_ban){
                if($filtr_ban == 'ban') $query .= 'AND reczna_filtr = 1 ';
                else if($filtr_ban == 'nieban') $query .= 'AND reczna_filtr = 0 ';
            }
			
			
            // sortowanie, kierunek, limit
            if($limit || $offset){
                // sortowanie
                $filtr_sortowanie = $this -> input -> cookie('filtr_klienci_sortowanie');
                $filtr_sortowanie = $this -> db -> clean($filtr_sortowanie);
                if($filtr_sortowanie) $query .= 'ORDER BY '.$filtr_sortowanie.' ';
                else $query .= 'ORDER BY nazwa ';
				
				// kierunek
                $filtr_kierunek = $this -> input -> cookie('filtr_klienci_kierunek');
                $filtr_kierunek = $this -> db -> clean($filtr_kierunek);
                if($filtr_kierunek) $query .= $filtr_kierunek.' ';
                else $query .= 'ASC ';

                // limit
                $query .= 'LIMIT '.$offset.','.$limit.' ';
            }

            $query .= 'END_QUERY';
            $query = str_replace('WHERE AND', 'WHERE', $query);
            $query = str_replace('WHERE ORDER', 'ORDER', $query);
            $query = str_replace(' WHERE END_QUERY', '', $query);
            $query = str_replace(' END_QUERY', '', $query);
            
            //echo $query.'<hr />';

            $wynik = $this -> db -> query($query);

            if(!$limit && !$offset){
                return $wynik ? $wynik[0]['number'] : 0;
            }else{
                if($wynik) $wynik = self::dopisz_najnowsza_notatke($wynik);
                if($uzytkownik['typ'] != 'partner') $wynik = self::dodaj_informacje_o_pozycjach($wynik);
                return $wynik;
            }
        }
        
        public function breakdown_totals($limit, $user) {
        	$query = $this->breakdown_buildQuery($user, true);
        	
        	$wynik = $this -> db -> query($query);
        	
        	$totals = array();
        	$totals['clients'] = (int) $wynik[0]['total'];
        	$totals['pages'] = (int) ($wynik[0]['total'] / $limit) + 1;
        	
        	return $totals;
        }
        
        protected function breakdown_buildQuery($user, $count = false, $from=null, $limit=null) {
        	if($count) {
        		$query = 'SELECT count(*) as total FROM klienci WHERE etap = 5 ';
        	} else {
        		$query = 'SELECT * FROM klienci WHERE etap = 5 ';
        	}
        	
        	if($user['typ'] == 'partner') {
        		$query .= ' AND id_partnera = '.$user['id'].' ';
        	} else {
        		if($_SESSION['breakdown_filter_partner'] != 0) {
        			$query .= ' AND id_partnera = '.$_SESSION['breakdown_filter_partner'].' ';
        		}
        	}
        	
        	 
        	if($_SESSION['breakdown_filter_payment'] == 1) {
        		$query .= 'AND faktury_za_pozycjonowanie = 1 ';
        	}
        	
        	if($_SESSION['breakdown_filter_payment'] == 2) {
        		$query .= 'AND faktury_za_pozycjonowanie = 0 ';
        	}
        	 
        	if($_SESSION['breakdown_filter_lump_sum'] == 1) { // tylko ryczałt
        		$query .= 'AND 2 IN (SELECT typ FROM frazy WHERE frazy.id_klienta = klienci.id_klienta GROUP BY typ) ';
        		$query .= 'AND 1 NOT IN (SELECT typ FROM frazy WHERE frazy.id_klienta = klienci.id_klienta GROUP BY typ) ';
        	}
        	 
        	if($_SESSION['breakdown_filter_lump_sum'] == 2) { // tylko top
        		$query .= 'AND 1 IN (SELECT typ FROM frazy WHERE frazy.id_klienta = klienci.id_klienta GROUP BY typ) ';
        		$query .= 'AND 2 NOT IN (SELECT typ FROM frazy WHERE frazy.id_klienta = klienci.id_klienta GROUP BY typ) ';
        	}
        	 
        	if($_SESSION['breakdown_filter_problem'] == 1) {
        		$query .= 'AND poprawa = 1 ';
        	}
        	 
        	if($_SESSION['breakdown_filter_problem'] == 2) {
        		$query .= 'AND poprawa = 0 ';
        	}
        	 
        	if($_SESSION['breakdown_filter_gotlink'] == 1) {
        		$query .= 'AND gotlink_grupa != 0 ';
        	}
        	 
        	if($_SESSION['breakdown_filter_gotlink'] == 2) {
        		$query .= 'AND gotlink_grupa = 0 ';
        	}
        	 
        	if($_SESSION['breakdown_filter_vip'] == 1) {
        		$query .= 'AND vip = 1 ';
        	}
        	 
        	if($_SESSION['breakdown_filter_vip'] == 2) {
        		$query .= 'AND vip = 0 ';
        	}
        	 
        	switch($_SESSION['breakdown_order_by']) {
        		default : // unkonwn/undefined
        		case 0 : // alfabetic
        			$query .= ' ORDER BY adres_strony';
        			break;
        		case 1 : // data utworzenia
        			$query .= ' ORDER BY data_utworzenia';
        			break;
        		case 2 : // następny kontakt
        			$query .= ' ORDER BY data_nastepnego_kontaktu';
        			break;
        		case 3 : // zmiana w TOP 10
        			$query .= ' ORDER BY odsetek_fraz_w_top_10_zmiana';
        			break;
        		case 4 : // liczba fraz na 1
        			$query .= ' ORDER BY ile_na_1_stronie';
        			break;
        		case 5 : // procent fraz na 1
        			$query .= ' ORDER BY odsetek_fraz_w_top_10_ilosc';
        			break;
        		case 6 : // data podpisania
        			$query .= ' ORDER BY umowa_czas_okreslony_od';
        			break;
        		case 7 : // priorytet
        			$query .= ' ORDER BY priorytet';
        			break;
        	}
        	 
        	if($_SESSION['breakdown_order'] == 1) {
        		$query .= ' DESC';
        	} else {
        		$query .= ' ASC';
        	}
        	
        	if($from !== null && $limit !== null) {
        		$query .= ' LIMIT '.$from.','.$limit;
        	} elseif ($limit !== null) {
        		$query .= ' LIMIT '.$limit;
        	}
        	
        	
        	return $query;
        }
        
        private function calculatePrecentages($result) {
        	
        	$precentages = array();
        	if(count($result) < 1) {
        		return array();
        	}
        	
//         	var_dump($result);
        	
        	for($dateDiff=0; $dateDiff<30; $dateDiff++) {
        	
	        	if(count($result[$dateDiff]) < 1) {
	        		continue;
	        	}
        		
        		$currentDate = $result[$dateDiff][0]['data'];
  
        		$currentResults = $result[$dateDiff];
        		$dayBeforeResults = $result[$dateDiff+1];
        		
        		$totalPhrases = count($currentResults);
        		$firstPageCount = 0;
        		
        		$upCount = 0;
        		$dnCount = 0;
        		
        		foreach ($currentResults as $phraseResults) {
        			if( ((int)$phraseResults['pierwsza_strona']) == 1) {
        				$firstPageCount++;
        			}
        			
        			foreach ($dayBeforeResults as $dbPhraseResults) {
        				if($phraseResults['id_frazy'] == $dbPhraseResults['id_frazy']) {
        					
        					if( (int)$phraseResults['wynik'] < (int)$dbPhraseResults['wynik']) {
        						$upCount++;
        					}
        					
        					if( (int)$phraseResults['wynik'] > (int)$dbPhraseResults['wynik']) {
        						$dnCount--;
        					}
        					
        				}
        			}
        		}
        		
        		$firstPagePrecentage = $firstPageCount/$totalPhrases * 100.0;
        		$upPrecentage = $upCount/$totalPhrases * 100.0;
        		$dnPrecentage = $dnCount/$totalPhrases * 100.0;
        		$precentages[$currentDate]['precentage_1st_page'] = $firstPagePrecentage;
        		$precentages[$currentDate]['precentage_up'] = $upPrecentage;
        		$precentages[$currentDate]['precentage_dn'] = $dnPrecentage;
        	}
        	
        	return $precentages;
        }
        
        public function breakdown_first_page_precentage_all($date, $client_id) {
        	
        	$result = array();
        	
        	$time = strtotime($date);
        	
        	for($dateDiff=0; $dateDiff<31; $dateDiff++) {
        		
        		$dateToCheck = date('Y-m-d', strtotime('-'.$dateDiff.' day', $time));
        		
	        	$query = 'SELECT frazy.id_frazy, data, wynik, pierwsza_strona
	        			FROM frazy
	        			JOIN frazy_wyniki ON frazy.id_frazy = frazy_wyniki.id_frazy
   			WHERE data = \''.$dateToCheck.'\'
	        			AND id_klienta = '.$client_id;
	        	
	        	$resultsAtDate = $this->db->query($query);
        	
	        	$result[$dateDiff] = $resultsAtDate;
        	}
        	
//         	echo '<pre>';
//         	var_dump($result);
//         	die;
        	
        	$result = $this->calculatePrecentages($result);
        	
        	return $result;
        }
        
        public function breakdown($uzytkownik, $dateDay = false, $dateCalendar = false,  $from = 0, $limit = 3) {
        	$query = $this->breakdown_buildQuery($uzytkownik, false, $from, $limit);
        	
//         	var_dump($query);
//         	die;
        	
        	$wynik = $this -> db -> query($query);

//         	echo '<pre>';
//         	var_dump($wynik);

        	$dataDzis = null;
        	$dataWczoraj = null;
        	
//         	echo '<pre>';
//         	var_dump($date);
        	
        	if($dateDay) {
        		$date_time = strtotime($dateDay);
        		$dataDzis = date('Y-m-d', $date_time);
        		
        		$date_time_yesterday = strtotime('-1 day', $date_time);
        		$dataWczoraj = date('Y-m-d', $date_time_yesterday);
        	} else {
        		$dateDay = date('Y-m-d');
        		
        		$date_time = strtotime($dateDay);
        		$dataDzis = date('Y-m-d', $date_time);
        		
        		$date_time_yesterday = strtotime('-1 day', $date_time);
        		$dataWczoraj = date('Y-m-d', $date_time_yesterday);
        	}
        	
//         	var_dump($dataDzis);
//         	var_dump($dataWczoraj);
        	

//         	echo '<pre>';
        	for($i = 0; $i<count($wynik); $i++) {
//         		var_dump($wynik[$i]['nazwa']);
        		
        		$id = $wynik[$i]['id_klienta'];
        		
        		$query = 'SELECT * FROM faktury_vat WHERE id_klienta = ' . $id . ' ORDER BY data_wystawienia DESC LIMIT 6';
        		$faktury = $this -> db -> query($query);
        		
        		$kwota4faktur = 0.0;
        		$kwota4fakturZaplacone = 0.0;
        		$kwota4fakturNiezaplacone = 0.0;
        		
        		$j = 0;
        		foreach ($faktury as $faktura) {
        			if($faktura['status'] == 0) {
        				$faktura['payment_done'] = false;
        				$kwota4fakturNiezaplacone += $faktura['kwota_brutto'];
        				if(strtotime(date('Y-m-d')) > strtotime($faktura['termin_zaplaty'])) {
        					$faktura['payment_overtime'] = true;
        				} else {
        					$faktura['payment_overtime'] = false;
        				}
        			} else {
        				$faktura['payment_done'] = true;
        				$kwota4fakturZaplacone += $faktura['kwota_brutto'];
        			}
        			
        			$wynik[$i]['faktury'][$j++] = $faktura;
        			$kwota4faktur += $faktura['kwota_brutto'];
        		}

        		$clientHasBulkPayment = false;
        		$clientHasTop10 = false;
        		
        		$query = 'SELECT * FROM frazy WHERE id_klienta = ' . $id;
        		$frazy2 = $this -> db -> query($query);
        		
        		foreach ($frazy2 as $fraza2) {
        			if($fraza2['typ'] == 2) {
        				$clientHasBulkPayment = true;
        			} else {
        				$clientHasTop10 = true;
        			}
        		}
        		
        		$wynik[$i]['hasBulkPayment'] = $clientHasBulkPayment;
        		$wynik[$i]['hasTopPayment'] = $clientHasTop10;
        		
        		
        		$wynik[$i]['paymentsTotal4'] = $kwota4faktur;
        		$wynik[$i]['paymentsTotal4Done'] = $kwota4fakturZaplacone;
        		$wynik[$i]['paymentsTotal4Overtime'] = $kwota4fakturNiezaplacone;
        		
        		// frazy
        		
        		$phrasesTable = $this->db->table('frazy');
        		
        		$resultsToday = $phrasesTable
        			->select('frazy`.`id_frazy','nazwa','wynik','pierwsza_strona', 'typ')
        			->join('frazy_wyniki')
        			->on('frazy_wyniki.id_frazy','=','frazy.id_frazy')
        			->where('id_klienta', '=', $id)
        			->clause('AND')
        			->where('data', '=', $dataDzis)
        			->execute();

        		$resultsYesterday = $phrasesTable
        			->select('frazy`.`id_frazy','nazwa','wynik','pierwsza_strona', 'typ')
	        		->join('frazy_wyniki')
	        		->on('frazy_wyniki.id_frazy','=','frazy.id_frazy')
	        		->where('id_klienta', '=', $id)
	        		->clause('AND')
	        		->where('data', '=', $dataWczoraj)
	        		->execute();
        		
        		
        		for($j=0; $j<count($resultsToday); $j++) {
        			$todayPhrase = $resultsToday[$j];
        			
        			foreach($resultsYesterday as $yesterdayPhrase) {
        				if($yesterdayPhrase['nazwa'] == $todayPhrase['nazwa']) {
        					if($todayPhrase['wynik'] == 0) {
        						if($yesterdayPhrase['wynik'] > 0) {
        							$resultsToday[$j]['zmiana'] = -500;
        						} else {
        							$resultsToday[$j]['zmiana'] = 0;
        						}
        					} else {
        						if($yesterdayPhrase['wynik'] == 0) {
        							$resultsToday[$j]['zmiana'] = 500 - $todayPhrase['wynik'];
        						} else {
        							$resultsToday[$j]['zmiana'] = $yesterdayPhrase['wynik'] - $todayPhrase['wynik'];
        						}
        					}
        				}
        			}
        			
        			if(!isset($resultsToday[$j]['zmiana'])) {
        				$resultsToday[$j]['zmiana'] = 0;
        			}

        			if($todayPhrase['typ'] == 2) { // ryczalt
        				$clientHasBulkPayment = true;
        			} else {
        				$clientHasTop10 = true;
        			}
        		}
//         		echo '<pre>';
//         		var_dump($resultsToday);
//         		var_dump($resultsYesterday);
//         		die;
        		
        		$wynik[$i]['wynikiDzis'] = $resultsToday;
        		$wynik[$i]['wynikiWczoraj'] = $resultsYesterday;
        		
        		$wynik[$i]['precentages'] = $this->breakdown_first_page_precentage_all($dateCalendar, $id);
        		
//         		echo '<pre>';
//         		var_dump($resultsToday);
//         		die;
				
//         		echo '<pre>';
//         		var_dump($wynik[$i]['precentages']);
//         		die;

        		
        		$query = 'SELECT nazwa FROM partnerzy WHERE id_partnera = ' . $wynik[$i]['id_partnera'];
        		$partner = $this->db->query($query);
        		
        		$wynik[$i]['partner_fullname'] = $partner[0]['nazwa'];
        	}
//         		echo '</pre>';
        		
//         	echo '<pre>';
//         	var_dump($wynik);
//         	die;
        	
        	return $wynik;
        	
        }


        // szukaj
        public function szukaj($uzytkownik, $zapytanie){
            $query = 'SELECT id_klienta as id, adres_strony as label FROM klienci WHERE ';

            // blokada na id partnera, id pozycjonera
            //if($uzytkownik['typ'] == 'partner') $query .= 'AND id_partnera = "'.$uzytkownik['id'].'" ';
            //else if($uzytkownik['typ'] == 'pozycjoner') $query .= 'AND id_pozycjonera = "'.$uzytkownik['id'].'" ';

            $query .= 'AND (nazwa LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR adres_strony LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR adres_strony_2 LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR dane_kontaktowe LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR faktura_adres LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR faktura_kod_pocztowy LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR faktura_miejscowosc LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR faktura_nazwa LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR id_klienta LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR korespondencja_adres LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR korespondencja_kod_pocztowy LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR korespondencja_miejscowosc LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR korespondencja_nazwa LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR mail LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR nip LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR osoba_kontaktowa LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR regon LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR reprezentant LIKE "%'.$zapytanie.'%" ';
            $query .= 'OR telefon LIKE "%'.$zapytanie.'%" )';

            $query = str_replace('WHERE AND', 'WHERE', $query);

            $wynik = $this -> db -> query($query);

            return $wynik;
        }


        // wszyscy klienci
    	public function wszyscy_klienci($id, $typ, $limit, $offset){
    		$tabela = $this -> db -> table('klienci');

            if($typ == 'admin'){
                $filtr_klienci_partnera = $this -> session -> get('filtr_klienci_partnera');
                if($filtr_klienci_partnera){
            		$dane = $tabela -> select('*')
        		                    -> where('id_partnera','=',$filtr_klienci_partnera)
            		                -> order_by('data_utworzenia', 'ASC')
            		                -> order_by('id_klienta', 'ASC')
            		                -> limit($limit)
            		                -> offset($offset)
            		                -> execute();
                }else{
            		$dane = $tabela -> select('*')
            		                -> order_by('data_utworzenia', 'ASC')
            		                -> order_by('id_klienta', 'ASC')
            		                -> limit($limit)
            		                -> offset($offset)
            		                -> execute();
                }
            }else if($typ == 'pozycjoner'){
        		$dane = $tabela -> select('*')
        		                -> where('id_pozycjonera','=',$id)
        		                -> order_by('data_utworzenia', 'ASC')
        		                -> order_by('id_klienta', 'ASC')
        		                -> limit($limit)
        		                -> offset($offset)
        		                -> execute();
            }else if($typ == 'partner'){
        		$dane = $tabela -> select('*')
        		                -> where('id_partnera','=',$id)
        		                -> order_by('data_utworzenia', 'ASC')
        		                -> order_by('id_klienta', 'ASC')
        		                -> limit($limit)
        		                -> offset($offset)
        		                -> execute();
            }

            if($dane) $dane = self::dopisz_najnowsza_notatke($dane);

            return $dane ? $dane : false;
        }


    	public function wszyscy_klienci_policz($id, $typ){
    		$tabela = $this -> db -> table('klienci');

            if($typ == 'admin'){
                $filtr_klienci_partnera = $this -> session -> get('filtr_klienci_partnera');
                if($filtr_klienci_partnera){
                    $suma = $tabela -> count()
            		                -> where('id_partnera','=',$filtr_klienci_partnera)
                                    -> execute();
                }else{
                    $suma = $tabela -> count()
                                    -> execute();
                }
            }else if($typ == 'pozycjoner'){
                $suma = $tabela -> count()
        		                -> where('id_pozycjonera','=',$id)
                                -> execute();
            }else if($typ == 'partner'){
                $suma = $tabela -> count()
        		                -> where('id_partnera','=',$id)
                                -> execute();
            }

            return $suma ? $suma : 0;
        }


        // etapy
        public function etapy($dla_selecta = 0){
            $etapy = array();
            $etapy[1] = 'Nowy klient';
            $etapy[2] = 'Na teście';
            $etapy[3] = 'Po teście';
            $etapy[4] = 'Po teście zrezygnował';
            $etapy[5] = 'Pozycjonowanie';
            $etapy[6] = 'Zawieszony';
			$etapy[7] = 'Nasze';
			$etapy[8] = 'Usługi';

            if($dla_selecta){
                $etapy_2 = array();
                for($i = 1; $i <= count($etapy); $i++){
                    $etapy_2[] = array('etykieta' => $etapy[$i],
                                       'wartosc' => $i);
                }
                $etapy = $etapy_2;
            }

            return $etapy;
        }


    	public function klienci_wedlug_etapu($etap, $uzytkownik, $limit, $offset){
    		$tabela = $this -> db -> table('klienci');

            if($uzytkownik['typ'] == 'admin'){
                $filtr_klienci_partnera = $this -> session -> get('filtr_klienci_partnera');
                if($filtr_klienci_partnera){
            		$dane = $tabela -> select('*')
            		                -> where('id_partnera','=',$filtr_klienci_partnera)
        		                    -> clause('AND')
        		                    -> where('etap','=',$etap)
            		                -> order_by('data_utworzenia', 'ASC')
            		                -> order_by('id_klienta', 'ASC')
            		                -> limit($limit)
            		                -> offset($offset)
            		                -> execute();
                }else{
            		$dane = $tabela -> select('*')
        		                    -> where('etap','=',$etap)
            		                -> order_by('data_utworzenia', 'ASC')
            		                -> order_by('id_klienta', 'ASC')
            		                -> limit($limit)
            		                -> offset($offset)
            		                -> execute();
                }
            }else if($uzytkownik['typ'] == 'pozycjoner'){
        		$dane = $tabela -> select('*')
        		                -> where('id_pozycjonera','=',$uzytkownik['id'])
    		                    -> clause('AND')
    		                    -> where('etap','=',$etap)
        		                -> order_by('data_utworzenia', 'ASC')
        		                -> order_by('id_klienta', 'ASC')
        		                -> limit($limit)
        		                -> offset($offset)
        		                -> execute();
            }else if($uzytkownik['typ'] == 'partner'){
        		$dane = $tabela -> select('*')
        		                -> where('id_partnera','=',$uzytkownik['id'])
    		                    -> clause('AND')
    		                    -> where('etap','=',$etap)
        		                -> order_by('data_utworzenia', 'ASC')
        		                -> order_by('id_klienta', 'ASC')
        		                -> limit($limit)
        		                -> offset($offset)
        		                -> execute();
            }

            if($dane){
                $dane = self::dopisz_najnowsza_notatke($dane);
                if($uzytkownik['typ'] != 'partner') $dane = self::dodaj_informacje_o_pozycjach($dane);
            }

            return $dane ? $dane : false;
        }


    	public function klienci_wedlug_etapu_policz($etap, $uzytkownik){
    		$tabela = $this -> db -> table('klienci');

            if($uzytkownik['typ'] == 'admin'){
                $filtr_klienci_partnera = $this -> session -> get('filtr_klienci_partnera');
                if($filtr_klienci_partnera){
                    $suma = $tabela -> count()
            		                -> where('id_partnera','=',$filtr_klienci_partnera)
        		                    -> clause('AND')
        		                    -> where('etap','=',$etap)
            		                -> execute();
                }else{
                    $suma = $tabela -> count()
        		                    -> where('etap','=',$etap)
            		                -> execute();
                }
            }else if($uzytkownik['typ'] == 'pozycjoner'){
                $suma = $tabela -> count()
        		                -> where('id_pozycjonera','=',$uzytkownik['id'])
    		                    -> clause('AND')
    		                    -> where('etap','=',$etap)
        		                -> execute();
            }else if($uzytkownik['typ'] == 'partner'){
                $suma = $tabela -> count()
        		                -> where('id_partnera','=',$uzytkownik['id'])
    		                    -> clause('AND')
    		                    -> where('etap','=',$etap)
        		                -> execute();
            }

            return $suma ? $suma : 0;
        }


        // zalegajacy
    	public function zalegajacy_klienci($id, $typ, $limit, $offset){
    		$tabela = $this -> db -> table('klienci');

            if($typ == 'admin'){
                $filtr_klienci_partnera = $this -> session -> get('filtr_klienci_partnera');
                if($filtr_klienci_partnera){
            		$dane = $tabela -> select('*')
            		                -> where('id_partnera','=',$filtr_klienci_partnera)
        		                    -> clause('AND')
        		                    -> where('data_nastepnego_kontaktu','<',date("Y-m-d"))
            		                -> order_by('data_utworzenia', 'ASC')
            		                -> order_by('id_klienta', 'ASC')
            		                -> limit($limit)
            		                -> offset($offset)
            		                -> execute();
                }else{
            		$dane = $tabela -> select('*')
        		                    -> where('data_nastepnego_kontaktu','<',date("Y-m-d"))
            		                -> order_by('data_utworzenia', 'ASC')
            		                -> order_by('id_klienta', 'ASC')
            		                -> limit($limit)
            		                -> offset($offset)
            		                -> execute();
                }
            }else if($typ == 'pozycjoner'){
        		$dane = $tabela -> select('*')
        		                -> where('id_pozycjonera','=',$id)
    		                    -> clause('AND')
    		                    -> where('data_nastepnego_kontaktu','<',date("Y-m-d"))
        		                -> order_by('data_utworzenia', 'ASC')
        		                -> order_by('id_klienta', 'ASC')
        		                -> limit($limit)
        		                -> offset($offset)
        		                -> execute();
            }else if($typ == 'partner'){
        		$dane = $tabela -> select('*')
        		                -> where('id_partnera','=',$id)
    		                    -> clause('AND')
    		                    -> where('data_nastepnego_kontaktu','<',date("Y-m-d"))
        		                -> order_by('data_utworzenia', 'ASC')
        		                -> order_by('id_klienta', 'ASC')
        		                -> limit($limit)
        		                -> offset($offset)
        		                -> execute();
            }

            if($dane) $dane = self::dopisz_najnowsza_notatke($dane);

            return $dane ? $dane : false;
        }


    	public function zalegajacy_klienci_policz($id, $typ){
    		$tabela = $this -> db -> table('klienci');

            if($typ == 'admin'){
                $filtr_klienci_partnera = $this -> session -> get('filtr_klienci_partnera');
                if($filtr_klienci_partnera){
                    $suma = $tabela -> count()
            		                -> where('id_partnera','=',$filtr_klienci_partnera)
        		                    -> clause('AND')
        		                    -> where('data_nastepnego_kontaktu','<',date("Y-m-d"))
            		                -> execute();
                }else{
                    $suma = $tabela -> count()
        		                    -> where('data_nastepnego_kontaktu','<',date("Y-m-d"))
            		                -> execute();
                }
            }else if($typ == 'pozycjoner'){
                $suma = $tabela -> count()
        		                -> where('id_pozycjonera','=',$id)
    		                    -> clause('AND')
    		                    -> where('data_nastepnego_kontaktu','<',date("Y-m-d"))
        		                -> execute();
            }else if($typ == 'partner'){
                $suma = $tabela -> count()
        		                -> where('id_partnera','=',$id)
    		                    -> clause('AND')
    		                    -> where('data_nastepnego_kontaktu','<',date("Y-m-d"))
        		                -> execute();
            }

            return $suma ? $suma : 0;
        }


        // na dziś
    	public function klienci_na_dzis($id, $typ, $limit, $offset){
    		$tabela = $this -> db -> table('klienci');

            if($typ == 'admin'){
                $filtr_klienci_partnera = $this -> session -> get('filtr_klienci_partnera');
                if($filtr_klienci_partnera){
            		$dane = $tabela -> select('*')
            		                -> where('id_partnera','=',$filtr_klienci_partnera)
        		                    -> clause('AND')
        		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d"))
            		                -> order_by('data_utworzenia', 'ASC')
            		                -> order_by('id_klienta', 'ASC')
            		                -> limit($limit)
            		                -> offset($offset)
            		                -> execute();
                }else{
            		$dane = $tabela -> select('*')
        		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d"))
            		                -> order_by('data_utworzenia', 'ASC')
            		                -> order_by('id_klienta', 'ASC')
            		                -> limit($limit)
            		                -> offset($offset)
            		                -> execute();
                }
            }else if($typ == 'pozycjoner'){
        		$dane = $tabela -> select('*')
        		                -> where('id_pozycjonera','=',$id)
    		                    -> clause('AND')
    		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d"))
        		                -> order_by('data_utworzenia', 'ASC')
        		                -> order_by('id_klienta', 'ASC')
        		                -> limit($limit)
        		                -> offset($offset)
        		                -> execute();
            }else if($typ == 'partner'){
        		$dane = $tabela -> select('*')
        		                -> where('id_partnera','=',$id)
    		                    -> clause('AND')
    		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d"))
        		                -> order_by('data_utworzenia', 'ASC')
        		                -> order_by('id_klienta', 'ASC')
        		                -> limit($limit)
        		                -> offset($offset)
        		                -> execute();
            }

            if($dane) $dane = self::dopisz_najnowsza_notatke($dane);

            return $dane ? $dane : false;
        }


    	public function klienci_na_dzis_policz($id, $typ){
    		$tabela = $this -> db -> table('klienci');

            if($typ == 'admin'){
                $filtr_klienci_partnera = $this -> session -> get('filtr_klienci_partnera');
                if($filtr_klienci_partnera){
                    $suma = $tabela -> count()
            		                -> where('id_partnera','=',$filtr_klienci_partnera)
        		                    -> clause('AND')
        		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d"))
            		                -> execute();
                }else{
                    $suma = $tabela -> count()
        		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d"))
            		                -> execute();
                }
            }else if($typ == 'pozycjoner'){
                $suma = $tabela -> count()
        		                -> where('id_pozycjonera','=',$id)
    		                    -> clause('AND')
    		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d"))
        		                -> execute();
            }else if($typ == 'partner'){
                $suma = $tabela -> count()
        		                -> where('id_partnera','=',$id)
    		                    -> clause('AND')
    		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d"))
        		                -> execute();
            }

            return $suma ? $suma : 0;
        }


        // na jutro
    	public function klienci_na_jutro($id, $typ, $limit, $offset){
    		$tabela = $this -> db -> table('klienci');

            if($typ == 'admin'){
                $filtr_klienci_partnera = $this -> session -> get('filtr_klienci_partnera');
                if($filtr_klienci_partnera){
            		$dane = $tabela -> select('*')
            		                -> where('id_partnera','=',$filtr_klienci_partnera)
        		                    -> clause('AND')
        		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d", strtotime("+1 day")))
            		                -> order_by('data_utworzenia', 'ASC')
            		                -> order_by('id_klienta', 'ASC')
            		                -> limit($limit)
            		                -> offset($offset)
            		                -> execute();
                }else{
            		$dane = $tabela -> select('*')
        		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d", strtotime("+1 day")))
            		                -> order_by('data_utworzenia', 'ASC')
            		                -> order_by('id_klienta', 'ASC')
            		                -> limit($limit)
            		                -> offset($offset)
            		                -> execute();
                }
            }else if($typ == 'pozycjoner'){
        		$dane = $tabela -> select('*')
        		                -> where('id_pozycjonera','=',$id)
    		                    -> clause('AND')
    		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d", strtotime("+1 day")))
        		                -> order_by('data_utworzenia', 'ASC')
        		                -> order_by('id_klienta', 'ASC')
        		                -> limit($limit)
        		                -> offset($offset)
        		                -> execute();
            }else if($typ == 'partner'){
        		$dane = $tabela -> select('*')
        		                -> where('id_partnera','=',$id)
    		                    -> clause('AND')
    		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d", strtotime("+1 day")))
        		                -> order_by('data_utworzenia', 'ASC')
        		                -> order_by('id_klienta', 'ASC')
        		                -> limit($limit)
        		                -> offset($offset)
        		                -> execute();
            }

            if($dane) $dane = self::dopisz_najnowsza_notatke($dane);

            return $dane ? $dane : false;
        }


    	public function klienci_na_jutro_policz($id, $typ){
    		$tabela = $this -> db -> table('klienci');

            if($typ == 'admin'){
                $filtr_klienci_partnera = $this -> session -> get('filtr_klienci_partnera');
                if($filtr_klienci_partnera){
                    $suma = $tabela -> count()
            		                -> where('id_partnera','=',$filtr_klienci_partnera)
        		                    -> clause('AND')
        		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d", strtotime("+1 day")))
            		                -> execute();
                }else{
                    $suma = $tabela -> count()
        		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d", strtotime("+1 day")))
            		                -> execute();
                }
            }else if($typ == 'pozycjoner'){
                $suma = $tabela -> count()
        		                -> where('id_pozycjonera','=',$id)
    		                    -> clause('AND')
    		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d", strtotime("+1 day")))
        		                -> execute();
            }else if($typ == 'partner'){
                $suma = $tabela -> count()
        		                -> where('id_partnera','=',$id)
    		                    -> clause('AND')
    		                    -> where('data_nastepnego_kontaktu','=',date("Y-m-d", strtotime("+1 day")))
        		                -> execute();
            }

            return $suma ? $suma : 0;
        }


        public function ilosc_zaplanowanych_kontaktow_w_miesiacu($miesiac, $rok, $uzytkownik){
    		$tabela = $this -> db -> table('klienci');

            $dane = array();

            for($i = 1; $i <= 31; $i++){
                $dzien = $i < 10 ? '0'.$i : $i;
                if($uzytkownik['typ'] == 'admin'){

                    $filtr_partner = $this -> input -> cookie('filtr_klienci_partner');
                    $filtr_partner = $this -> db -> clean($filtr_partner);

                    if($filtr_partner){
                        $suma = $tabela -> count()
                		                -> where('id_partnera','=',$filtr_partner)
            		                    -> clause('AND')
            		                    -> where('data_nastepnego_kontaktu','=',$rok.'-'.$miesiac.'-'.$dzien)
                		                -> execute();
                    }else{
                        $suma = $tabela -> count()
            		                    -> where('data_nastepnego_kontaktu','=',$rok.'-'.$miesiac.'-'.$dzien)
                		                -> execute();
                    }
                }else if($uzytkownik['typ'] == 'pozycjoner'){
                    $suma = $tabela -> count()
            		                -> where('id_pozycjonera','=',$uzytkownik['id'])
        		                    -> clause('AND')
        		                    -> where('data_nastepnego_kontaktu','=',$rok.'-'.$miesiac.'-'.$dzien)
            		                -> execute();
                }else if($uzytkownik['typ'] == 'partner'){
                    $suma = $tabela -> count()
            		                -> where('id_partnera','=',$uzytkownik['id'])
        		                    -> clause('AND')
        		                    -> where('data_nastepnego_kontaktu','=',$rok.'-'.$miesiac.'-'.$dzien)
            		                -> execute();
                }
                $dane[$i] = $suma ? $suma : 0;
            }
            //print_r($dane); exit;
            return $dane;

        }


        // notatki
        public function wszystkie_notatki($id_klienta){
    		$tabela = $this -> db -> table('klienci_notatki');

    		$notatki = $tabela -> select('*')
    		                   -> where('id_klienta', '=', $id_klienta)
    		                   -> order_by('data_utworzenia', 'DESC')
    		                   -> order_by('id_notatki', 'DESC')
    		                   -> execute();

            return $notatki ? $notatki : false;
        }
		
		public function wszystkie_notatki_seo(){
    		$tabela = $this -> db -> table('klienci_notatki');

    		$notatki = $tabela -> select('*')
    		                   -> where('id_klienta', '=', $id_klienta)
    		                   -> order_by('data_utworzenia', 'DESC')
    		                   -> order_by('id_notatki', 'DESC')
    		                   -> execute();

            return $notatki ? $notatki : false;
        }
	


    	public function jedna_notatka($id_notatki, $id_klienta){
    		$tabela = $this -> db -> table('klienci_notatki');

    		$notatka = $tabela -> select('*')
    		                   -> where('id_klienta','=',$id_klienta)
    		                   -> clause('AND')
    		                   -> where('id_notatki','=',$id_notatki)
    		                   -> limit(1)
    		                   -> execute();

            return $notatka ? $notatka[0] : false;
        }


        public function zapisz_notatke($data_utworzenia, $id_klienta, $tresc){
    		$tabela = $this -> db -> table('klienci_notatki');

        	$tabela -> insert(array('data_utworzenia' => $data_utworzenia,
        	                        'id_klienta' => $id_klienta,
                                    'tresc' => $tresc), false);

    	    return true;
        }


        public function dopisz_najnowsza_notatke($klienci){
    		$tabela = $this -> db -> table('klienci_notatki');

            $frazy = $this -> load -> model('frazy');

            $dane = array();

            $i = 0;
            foreach($klienci as $klient){
        		$notatka = $tabela -> select('data_utworzenia', 'tresc')
        		                   -> where('id_klienta','=',$klient['id_klienta'])
        		                   -> order_by('data_utworzenia', 'DESC')
        		                   -> order_by('id_notatki', 'DESC')
        		                   -> execute();

                $dane[$i] = $klient;
                $dane[$i]['data_utworzenia_notatki'] = $notatka ? $notatka[0]['data_utworzenia'] : false;
                $dane[$i]['tresc_notatki'] = $notatka ? $notatka[0]['tresc'] : false;
                $dane[$i]['liczba_fraz'] = count($frazy -> wszystkie($klient['id_klienta']));
                $dane[$i]['zaawansowanie_w_top_10'] = $frazy -> wylicz_zaawansowanie_w_top_10(date("Y-m-d"), $klient['id_klienta']);
                $wyniki = $frazy -> pierwsze_strony_na_dzien(date("Y-m-d"), $klient['id_klienta']);
                $dane[$i]['odsetek_fraz_w_top_10'] = $frazy -> wylicz_odsetek_na_pierwszej_stronie($wyniki);
                $dane[$i]['liczba_fraz_w_top_10'] = $frazy -> wylicz_liczbe_fraz_na_pierwszej_stronie($wyniki);
                $dane[$i]['typ_fraz'] = $frazy -> sprawdz_jakie_sa_frazy($klient['id_klienta']);
                $i++;
            }

            return $dane;
        }


        // klient
    	public function jeden_klient($id, $id_klienta, $typ){
    		$tabela = $this -> db -> table('klienci');

            if($typ == 'admin'){
        		$klient = $tabela -> select('*')
        		                  -> where('id_klienta','=',$id_klienta)
        		                  -> limit(1)
        		                  -> execute();
            }else if($typ == 'pozycjoner'){
        		$klient = $tabela -> select('*')
        		                  -> where('id_klienta','=',$id_klienta)
        		                  -> clause('AND')
        		                  -> where('id_pozycjonera','=',$id)
        		                  -> limit(1)
        		                  -> execute();
            }else if($typ == 'partner'){
        		$klient = $tabela -> select('*')
        		                  -> where('id_klienta','=',$id_klienta)
        		                  -> clause('AND')
        		                  -> where('id_partnera','=',$id)
        		                  -> limit(1)
        		                  -> execute();
            }

            return $klient ? $klient[0] : false;
        }


    	public function jeden_klient_po_hashu($hash){
    		$tabela = $this -> db -> table('klienci');

    		$klient = $tabela -> select('*')
    		                  -> where('hash','=',$hash)
    		                  -> limit(1)
    		                  -> execute();

            return $klient ? $klient[0] : false;
        }


    	public function jeden_klient_po_id($id_klienta){
    		$tabela = $this -> db -> table('klienci');

    		$klient = $tabela -> select('*')
    		                  -> where('id_klienta','=',$id_klienta)
    		                  -> limit(1)
    		                  -> execute();

            return $klient ? $klient[0] : false;
        }
                                                                                                                                     

        public function zapisz($adres_strony, $adres_strony_2, $dane_kontaktowe, $data_nastepnego_kontaktu, $data_pierwszego_kontaktu, $data_rozpoczecia_pozycjonowania, $data_utworzenia, $faktura_adres, $faktura_kod_pocztowy, $faktura_miejscowosc, $faktura_nazwa, $faktura_papierowa, $faktury_za_pozycjonowanie, $hosting, $poczta, $cena_hosting, $priorytet, $kategoria, $vip, $id_klienta, $id_partnera, $id_1_partnera, $id_pozycjonera, $korespondencja_adres, $korespondencja_kod_pocztowy, $korespondencja_miejscowosc, $korespondencja_nazwa, $korespondencja_adres, $mail, $nip, $nazwa, $notatka_do_nastepnego_kontaktu, $osoba_kontaktowa, $regon, $reprezentant, $pesel, $telefon, $top_10_1_od, $top_10_1_do, $top_10_2_od, $top_10_2_do, $top_10_3_od, $top_10_3_do, $umowa_czas_okreslony, $umowa_czas_okreslony_do, $umowa_czas_okreslony_od, $uzytkownik, $okres_umowy, $nowe_teksty, $nowa_strona){
    		$tabela = $this -> db -> table('klienci');
    		$baza_id_pozycjonera_arr = $tabela -> select('id_pozycjonera')
    		                -> where('id_klienta','=',$id_klienta)
    		                -> execute();
    		$baza_seo_inf = ($baza_id_pozycjonera_arr[0]["id_pozycjonera"]);
    		
            if($id_klienta){
              if ($baza_id_pozycjonera_arr != $id_pozycjonera){
											if(!empty($id_pozycjonera)) {
													$tabela -> update(array('id_pozycjonera' => $id_pozycjonera))
																		 -> where('id_klienta','=',$id_klienta)
            	        				 -> execute();}}
            	$tabela -> update(array('adres_strony' => $adres_strony,
                                        'adres_strony_2' => $adres_strony_2,
                                        'dane_kontaktowe' => $dane_kontaktowe,
                                        'data_nastepnego_kontaktu' => $data_nastepnego_kontaktu,
                                        'data_pierwszego_kontaktu' => $data_pierwszego_kontaktu,
                                        'data_rozpoczecia_pozycjonowania' => $data_rozpoczecia_pozycjonowania,
                                        'data_utworzenia' => $data_utworzenia,
                                        'faktura_adres' => $faktura_adres,
                                        'faktura_kod_pocztowy' => $faktura_kod_pocztowy,
                                        'faktura_miejscowosc' => $faktura_miejscowosc,
                                        'faktura_nazwa' => $faktura_nazwa,
                                        'faktura_papierowa' => $faktura_papierowa,
                                        'faktury_za_pozycjonowanie' => $faktury_za_pozycjonowanie,
                                        'hosting' => $hosting,
										'poczta' => $poczta,
										'cena_hosting' => $cena_hosting,
										'priorytet' => $priorytet,
										'kategoria' => $kategoria,
										'vip' => $vip,
                                        'okres_umowy' => $okres_umowy,
                                        'nowe_teksty' => $nowe_teksty,
                                        'nowa_strona' => $nowa_strona,
                                        'id_partnera' => $id_partnera,
										'id_1_partnera' => $id_1_partnera,
                                        'korespondencja_adres' => $korespondencja_adres,
                                        'korespondencja_kod_pocztowy' => $korespondencja_kod_pocztowy,
                                        'korespondencja_miejscowosc' => $korespondencja_miejscowosc,
                                        'korespondencja_nazwa' => $korespondencja_nazwa,
                                        'korespondencja_adres' => $korespondencja_adres,
                                        'mail' => $mail,
                                        'nip' => $nip,
                                        'nazwa' => $nazwa,
                                        'notatka_do_nastepnego_kontaktu' => $notatka_do_nastepnego_kontaktu,
                                        'osoba_kontaktowa' => $osoba_kontaktowa,
                                        'regon' => $regon,
                                        'reprezentant' => $reprezentant,
										'pesel' => $pesel,
                                        'telefon' => $telefon,
                                        'top_10_1_od' => $top_10_1_od,
                                        'top_10_1_do' => $top_10_1_do,
                                        'top_10_2_od' => $top_10_2_od,
                                        'top_10_2_do' => $top_10_2_do,
                                        'top_10_3_od' => $top_10_3_od,
                                        'top_10_3_do' => $top_10_3_do,
                                        'umowa_czas_okreslony' => $umowa_czas_okreslony,
                                        'umowa_czas_okreslony_do' => $umowa_czas_okreslony_do,
                                        'umowa_czas_okreslony_od' => $umowa_czas_okreslony_od))
    	                -> where('id_klienta','=',$id_klienta)
            	        -> execute();
    	    }else{
            	$tabela -> insert(array('adres_strony' => $adres_strony,
                                        'adres_strony_2' => $adres_strony_2,
                                        'dane_kontaktowe' => $dane_kontaktowe,
                                        'data_nastepnego_kontaktu' => $data_nastepnego_kontaktu,
                                        'data_pierwszego_kontaktu' => $data_pierwszego_kontaktu,
                                        'data_rozpoczecia_pozycjonowania' => $data_rozpoczecia_pozycjonowania,
                                        'data_utworzenia' => $data_utworzenia,
                                        'faktura_adres' => $faktura_adres,
                                        'faktura_kod_pocztowy' => $faktura_kod_pocztowy,
                                        'faktura_miejscowosc' => $faktura_miejscowosc,
                                        'faktura_nazwa' => $faktura_nazwa,
                                        'faktura_papierowa' => $faktura_papierowa,
                                        'faktury_za_pozycjonowanie' => $faktury_za_pozycjonowanie,
                                        'hosting' => $hosting,
										'poczta' => $poczta,
										'cena_hosting' => $cena_hosting,
										'priorytet' => $priorytet,
										'kategoria' => $kategoria,
										'vip' => $vip,
                                        'okres_umowy' => $okres_umowy,
                                        'nowe_teksty' => $nowe_teksty,
                                        'nowa_strona' => $nowa_strona,
                                        'hash' => md5(time().$adres_strony.$mail.$nazwa),
                                        'id_partnera' => $id_partnera,
										'id_1_partnera' => $id_partnera,
										'id_pozycjonera' => $id_pozycjonera,
                                        'korespondencja_adres' => $korespondencja_adres,
                                        'korespondencja_kod_pocztowy' => $korespondencja_kod_pocztowy,
                                        'korespondencja_miejscowosc' => $korespondencja_miejscowosc,
                                        'korespondencja_nazwa' => $korespondencja_nazwa,
                                        'korespondencja_adres' => $korespondencja_adres,
                                        'mail' => $mail,
                                        'nip' => $nip,
                                        'nazwa' => $nazwa,
                                        'notatka_do_nastepnego_kontaktu' => $notatka_do_nastepnego_kontaktu,
                                        'osoba_kontaktowa' => $osoba_kontaktowa,
                                        'regon' => $regon,
                                        'reprezentant' => $reprezentant,
										'pesel' => $pesel,
                                        'telefon' => $telefon,
                                        'top_10_1_od' => $top_10_1_od,
                                        'top_10_1_do' => $top_10_1_do,
                                        'top_10_2_od' => $top_10_2_od,
                                        'top_10_2_do' => $top_10_2_do,
                                        'top_10_3_od' => $top_10_3_od,
                                        'top_10_3_do' => $top_10_3_do,
                                        'umowa_czas_okreslony' => $umowa_czas_okreslony,
                                        'umowa_czas_okreslony_do' => $umowa_czas_okreslony_do,
                                        'umowa_czas_okreslony_od' => $umowa_czas_okreslony_od), false);
    	    }

    	    return true;
        }


        public function czy_adres_strony_istnieje($adres_strony, $id_klienta){
    		$table = $this -> db -> table('klienci');

    		$result = $table -> select('*')
    		                 -> where('adres_strony','=',$adres_strony)
    		                 -> execute();

            $result = $result ? 1 : 0;

            if($id_klienta && $result){
        		$data = $table -> select('*')
        		               -> where('id_klienta','=',$id_klienta)
    		                   -> clause('AND')
        		               -> where('adres_strony','=',$adres_strony)
        		               -> execute();

                $data = $data ? 1 : 0;
                if($data) $result = 0;
            }

            return $result;
        }


        public function zapisz_komentarz_do_wyceny($id_klienta, $komentarz_do_wyceny){
    		$tabela = $this -> db -> table('klienci');

        	$tabela -> update(array('komentarz_do_wyceny' => $komentarz_do_wyceny))
	                -> where('id_klienta','=',$id_klienta)
        	        -> execute();

    	    return true;
        }


        public function popros_o_usuniecie($id_klienta, $powod_usuniecia){
    		$tabela = $this -> db -> table('klienci');

        	$tabela -> update(array('powod_usuniecia' => $powod_usuniecia))
	                -> where('id_klienta','=',$id_klienta)
        	        -> execute();

            return true;
        }


    /*    public function zapisz_komentarz_do_wynikow($id_klienta, $komentarz_do_wynikow){
    		$tabela = $this -> db -> table('klienci');

        	$tabela -> update(array('komentarz_do_wynikow' => $komentarz_do_wynikow))
	                -> where('id_klienta','=',$id_klienta)
        	        -> execute();

            return true;
        }
	*/

        public function anuluj_prosbe_o_usuniecie($id_klienta){
    		$tabela = $this -> db -> table('klienci');

        	$tabela -> update(array('powod_usuniecia' => ''))
	                -> where('id_klienta','=',$id_klienta)
        	        -> execute();

            return true;
        }


    	public function sprawdz_czy_mozna_usunac_klienta($id_klienta){
    	    // sprawdzanie, czy klient miał wystawianą fakturę vat
    	    $faktury = $this -> load -> model('faktury') -> wszystkie_dla_klienta($id_klienta);

    	    return $faktury ? false : true;
        }


        public function usun_klienta($id_klienta){
            $id_klienta = $this -> db -> clean($id_klienta);

            // usuwanie fraz
            $this -> db -> query("DELETE FROM frazy WHERE id_klienta = '".$id_klienta."'");

            // usuwanie notatek
            $this -> db -> query("DELETE FROM klienci_notatki WHERE id_klienta = '".$id_klienta."'");

            // usuwanie umów
            $this -> db -> query("DELETE FROM umowy WHERE id_klienta = '".$id_klienta."'");

            // usuwanie klienta
            $this -> db -> query("DELETE FROM klienci WHERE id_klienta = '".$id_klienta."'");

            return true;
        }


        // powiązania
        public function zapisz_powiazania($id_klienta, $id_pozycjonera){
    		$tabela = $this -> db -> table('klienci');

            if($id_klienta){
            	$tabela -> update(array('id_pozycjonera' => $id_pozycjonera))
    	                -> where('id_klienta','=',$id_klienta)
            	        -> execute();
    	    }else{
            	$tabela -> insert(array('id_pozycjonera' => $id_pozycjonera), false);
    	    }

    	    return true;
        }


        public function uaktualnij_nastepny_kontakt($data_nastepnego_kontaktu, $id_klienta, $notatka_do_nastepnego_kontaktu){
    		$tabela = $this -> db -> table('klienci');

        	$tabela -> update(array('data_nastepnego_kontaktu' => $data_nastepnego_kontaktu,
                                    'notatka_do_nastepnego_kontaktu' => $notatka_do_nastepnego_kontaktu))
                    -> where('id_klienta','=',$id_klienta)
        	        -> execute();
        }
		public function uaktualnij_date_nastepny_kontakt($data_nastepnego_kontaktu, $id_klienta){
    		$tabela = $this -> db -> table('klienci');

        	$tabela -> update(array('data_nastepnego_kontaktu' => $data_nastepnego_kontaktu))
                    -> where('id_klienta','=',$id_klienta)
        	        -> execute();
        }

        // pozycje
        public function dodaj_informacje_o_pozycjach($klienci){
            $dane = array();

            $i = 0;
            $frazy = $this -> load -> model('frazy');
            foreach($klienci as $klient){
                $dane[$i] = $klient;
                $liczba_fraz = $frazy -> wszystkie($klient['id_klienta']);
                if($liczba_fraz) $dane[$i]['dzisiejsze_pozycje'] = $frazy -> wyniki_na_dzien(date("Y-m-d"), $klient['id_klienta']) ? 1 : 0;
                $i++;
            }

            return $dane;
        }


        // lista do selecta
        public function lista_do_selecta($poza_id = 0){
    		$tabela = $this -> db -> table('klienci');

    		$dane = $tabela -> select('id_klienta', 'nazwa')
    		                -> order_by('nazwa', 'ASC')
    		                -> execute();

            $dane_2 = array();

            if($dane){
                foreach($dane as $element){
                    if($element['id_klienta'] != $poza_id) $dane_2[] = $element;
                }
            }

            return $dane_2;
        }

/*
        // google analytics
        public function ga_zapisz_dane_dostepowe($ga_haslo, $ga_mail, $id_klienta){
    		$tabela = $this -> db -> table('klienci');
    		
            	$tabela -> update(array('ga_haslo' => $ga_haslo,
                                        'ga_mail' => $ga_mail,
                                        'ga_profil' => ''))
    	                -> where('id_klienta','=',$id_klienta)
            	        -> execute();
        }


        public function ga_zmien_profil($ga_profil, $id_klienta){
    		$tabela = $this -> db -> table('klienci');
    		
            	$tabela -> update(array('ga_profil' => $ga_profil))
    	                -> where('id_klienta','=',$id_klienta)
            	        -> execute();
        }


        public function ga_wyloguj($id_klienta){
    		$tabela = $this -> db -> table('klienci');
    		
            	$tabela -> update(array('ga_haslo' => '',
                                        'ga_mail' => '',
                                        'ga_profil' => ''))
    	                -> where('id_klienta','=',$id_klienta)
            	        -> execute();
        }
*/
		public function lista_do_selecta_seo(){
    		$tabela = $this -> db -> table('klienci');

    		$dane = $tabela -> select('id_klienta', 'optymalizacja', 'nazwa')
							-> where('optymalizacja','=','1')
    		                -> execute();

            return $dane ? $dane : false;
        }
    }

?>