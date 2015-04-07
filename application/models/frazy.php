<?php

class frazy_model{

	public function serwery_sprawdzajace($dla_selecta = 0){
		include 'serwery.php';

		if($dla_selecta){
			$serwery_2 = array();
			for($i = 1; $i <= count($serwery); $i++){
				$serwery_2[] = array('etykieta' => $serwery[$i],
						'wartosc' => $i);
			}
			$serwery = $serwery_2;
		}

		return $serwery;
	}


	public function serwery_sprawdzajace_ip(){
		include 'serwery.php';

		return $serwery_ip;
	}


	public function typy($dla_selecta = 0){
		$typy = array();

		if($dla_selecta){
			$typy[] = array('nazwa' => 'TOP 10',
					'wartosc' => 1);

			$typy[] = array('nazwa' => 'Ryczałt',
					'wartosc' => 2);
		}else{
			$typy[1] = 'TOP 10';
			$typy[2] = 'Ryczałt';
		}

		return $typy;
	}


	public function typy_top10($dla_selecta = 0){
		$typy = array();

		if($dla_selecta){
			$typy[] = array('nazwa' => 'procentowo',
					'wartosc' => 1);

			$typy[] = array('nazwa' => 'kwotowo',
					'wartosc' => 0);
		}else{
			$typy[1] = 'procentowo';
			$typy[2] = 'kwotowo';
		}

		return $typy;
	}


	public function wszystkie($id_klienta){
		$tabela = $this -> db -> table('frazy');

		$frazy = $tabela -> select('*')
		-> where('id_klienta', '=', $id_klienta)
		-> order_by('nazwa', 'ASC')
		-> execute();

		return $frazy ? $frazy : false;
	}


	public function jedna($id_frazy){
		$tabela = $this -> db -> table('frazy');

		$fraza = $tabela -> select('*')
		-> where('id_frazy', '=', $id_frazy)
		-> limit(1)
		-> execute();

		return $fraza ? $fraza[0] : false;
	}


	public function zapisz($id_frazy, $id_klienta, $kwota_za_fraze,	$minimalna_kwota_za_fraze, $nazwa, $typ, $top10_procentowo, $top10_1_kwota,  $top10_2_kwota,  $top10_3_kwota, $top10_pierwsza_strona, $top_max, $link){
		$tabela = $this -> db -> table('frazy');
		if($id_frazy){
			$tabela -> update(
					array(
							'kwota_za_fraze' => $kwota_za_fraze,
							'minimalna_kwota_za_fraze' => $minimalna_kwota_za_fraze,
							'nazwa' => $nazwa,
							'fraza_link' => $link,
							'typ' => $typ,
							'top10_procentowo' => $top10_procentowo,
							'top10_1_kwota' => $top10_1_kwota,
							'top10_2_kwota' => $top10_2_kwota,
							'top10_3_kwota' => $top10_3_kwota,
							'top10_pierwsza_strona' => $top10_pierwsza_strona))
					-> where('id_frazy','=',$id_frazy)
					-> execute();
		}else{
			$tabela -> insert(array('id_klienta' => $id_klienta,
					'kwota_za_fraze' => $kwota_za_fraze,
					'minimalna_kwota_za_fraze' => $minimalna_kwota_za_fraze,
					'nazwa' => $nazwa,
					'fraza_link' => $link,
					'typ' => $typ,
					'top10_procentowo' => $top10_procentowo,
					'top10_1_kwota' => $top10_1_kwota,
					'top10_2_kwota' => $top10_2_kwota,
					'top10_3_kwota' => $top10_3_kwota,
					'top10_pierwsza_strona' => $top10_pierwsza_strona), false);
		}
		$tabela = $this -> db -> table('klienci');
		$tabela -> update(
					array('top_max' => $top_max))
					-> where('id_klienta','=',$id_klienta)
					-> execute();
		return true;
	}


	public function zapisz_kilka($frazy_ryczalt, $frazy_top, $id_klienta){
		$tabela = $this -> db -> table('frazy');

		if($frazy_ryczalt){
			foreach($frazy_ryczalt as $fraza){
				if(!empty($fraza)){
					$tabela -> insert(array('id_klienta' => $id_klienta,
							'nazwa' => $fraza,
							'typ' => 2), false);
				}
			}
		}

		if($frazy_top){
			foreach($frazy_top as $fraza){
				if(!empty($fraza)){
					$tabela -> insert(array('id_klienta' => $id_klienta,
							'nazwa' => $fraza,
							'typ' => 1), false);
				}
			}
		}

		return true;
	}


	public function usun($id_frazy){
		$tabela = $this -> db -> table('frazy');

		$tabela -> delete()
		-> where('id_frazy','=',$id_frazy)
		-> execute();

		return true;
	}


	public function popros_o_wycene($id_klienta, $kwota_ryczaltu, $top_max){
		$tabela = $this -> db -> table('klienci');
		if($top_max!=0){
		$tabela -> update(array('etap' => 2,
				'kwota_ryczaltu' => $kwota_ryczaltu,
				'top_max' => $top_max))
				-> where('id_klienta','=',$id_klienta)
				-> execute();
		}else{
		$tabela -> update(array('etap' => 2,
				'kwota_ryczaltu' => $kwota_ryczaltu))
				-> where('id_klienta','=',$id_klienta)
				-> execute();
		}
		return true;
	}


	public function wroc_do_wyceny($id_klienta){
		$tabela = $this -> db -> table('klienci');

		$tabela -> update(array('etap' => 2))
		-> where('id_klienta','=',$id_klienta)
		-> execute();

		return true;
	}


	public function anuluj_prosbe_o_wycene($id_klienta){
		$tabela = $this -> db -> table('klienci');

		$tabela -> update(array('etap' => 1))
		-> where('id_klienta','=',$id_klienta)
		-> execute();

		return true;
	}
	
	public function dla_handlowca($id_klienta, $handlowiec){
		$tabela = $this -> db -> table('klienci');
		
		$tabela -> update(array('etap' => 3,'notatka_do_nastepnego_kontaktu' => "Klient dla Handlowca",'id_partnera' => $handlowiec))
		-> where('id_klienta','=',$id_klienta)
		-> execute();

		return true;
	}
	
	public function na_uslugi($id_klienta){
		$tabela = $this -> db -> table('klienci');
		$tabela -> update(array('etap' => 8))
		-> where('id_klienta','=',$id_klienta)
		-> execute();

		return true;
	}
	
	public function zakoncz_bez_testu($id_klienta, $handlowiec){
		$tabela = $this -> db -> table('klienci');
		
		$tabela -> update(array('etap' => 3))
		-> where('id_klienta','=',$id_klienta)
		-> execute();

		return true;
	}
	
	public function podpisz_umowe($id_klienta, $idpoz){
		$tabela = $this -> db -> table('klienci');

		$tabela -> update(array('etap' => 5, 'id_pozycjonera' => $idpoz))
		-> where('id_klienta','=',$id_klienta)
		-> execute();

		return true;
	}
	
	public function od_nowa($id_klienta){
		$tabela = $this -> db -> table('klienci');

		$tabela -> update(array('etap' => 1))
		-> where('id_klienta','=',$id_klienta)
		-> execute();

		return true;
	}


	public function skasuj_wycene($id_klienta){
		$tabela = $this -> db -> table('klienci');

		$tabela -> update(array('etap' => 1))
		-> where('id_klienta','=',$id_klienta)
		-> execute();

		$tabela = $this -> db -> table('frazy');

		$tabela -> update(array('kwota_za_fraze' => 0,
				'minimalna_kwota_za_fraze' => 0))
				-> where('id_klienta','=',$id_klienta)
				-> execute();

		$tabela = $this -> db -> table('klienci');

		$tabela -> update(array('kwota_ryczaltu' => 0))
		-> where('id_klienta','=',$id_klienta)
		-> execute();


		return true;
	}


	public function popros_o_rozpoczecie($id_klienta){
		$tabela = $this -> db -> table('klienci');

		$tabela -> update(array('etap' => 4))
		-> where('id_klienta','=',$id_klienta)
		-> execute();

		return true;
	}


	public function rozpocznij($id_klienta, $idpoz){
		$tabela = $this -> db -> table('klienci');

		$tabela -> update(array('data_rozpoczecia_pozycjonowania' => date("Y-m-d"),
				'etap' => 5,'id_pozycjonera' => $idpoz))
				-> where('id_klienta','=',$id_klienta)
				-> execute();

		return true;
	}


	public function zawies($id_klienta){
		$tabela = $this -> db -> table('klienci');

		$tabela -> update(array('etap' => 6))
		-> where('id_klienta','=',$id_klienta)
		-> execute();

		return true;
	}


	public function wznow($id_klienta){
		$tabela = $this -> db -> table('klienci');

		$tabela -> update(array('etap' => 5))
		-> where('id_klienta','=',$id_klienta)
		-> execute();

		return true;
	}


	public function zatwierdz_wycene($id_klienta, $kwota_ryczaltu, $top_max){
		$tabela = $this -> db -> table('klienci');

		$tabela -> update(array('etap' => 3,
				'kwota_ryczaltu' => $kwota_ryczaltu,
				'top_max' => $top_max))
				-> where('id_klienta','=',$id_klienta)
				-> execute();

		return true;
	}


	public function zapisz_wycene($id_klienta, $kwota_ryczaltu, $top_max){
		$tabela = $this -> db -> table('klienci');

		$tabela -> update(array('kwota_ryczaltu' => $kwota_ryczaltu,
								'top_max' => $top_max))
		-> where('id_klienta','=',$id_klienta)
		-> execute();

		return true;
	}


	public function wyniki_na_dzien($data, $id_klienta){
		$tabela = $this -> db -> table('frazy_wyniki');

		$wyniki = $tabela -> select('*')
		-> where('data', '=', $data)
		-> clause('AND')
		-> where('id_klienta', '=', $id_klienta)
		-> join('frazy')
		-> on('frazy_wyniki.id_frazy','=','frazy.id_frazy')
		-> order_by('nazwa', 'ASC')
		-> execute();

		$nowa = array();
		if($wyniki){
			foreach($wyniki as $element) $nowa[$element['id_frazy']] = $element['wynik'];
		}
		return $nowa;
	}


	public function wyniki_na_dzien_z_nazwa($data, $id_klienta){
		$tabela = $this -> db -> table('frazy_wyniki');

		$wyniki = $tabela -> select('*')
		-> where('data', '=', $data)
		-> clause('AND')
		-> where('id_klienta', '=', $id_klienta)
		-> join('frazy')
		-> on('frazy_wyniki.id_frazy','=','frazy.id_frazy')
		-> order_by('nazwa', 'ASC')
		-> execute();

		$nowa = array();
		if($wyniki){
			foreach($wyniki as $element) $nowa[$element['id_frazy']] = array(
					$element['wynik'],
					$element['nazwa']
			);
		}
		return $nowa;
	}


	public function pierwsze_strony_na_dzien($data, $id_klienta){
		$tabela = $this -> db -> table('frazy_wyniki');

		$wyniki = $tabela -> select('*')
		-> where('data', '=', $data)
		-> clause('AND')
		-> where('id_klienta', '=', $id_klienta)
		-> join('frazy')
		-> on('frazy_wyniki.id_frazy','=','frazy.id_frazy')
		-> order_by('nazwa', 'ASC')
		-> execute();

		$nowa = array();
		if($wyniki){
			foreach($wyniki as $element) $nowa[$element['id_frazy']] = $element['pierwsza_strona'];
		}
		return $nowa;
	}


	public function zapisz_pozycje($data, $id_klienta, $pierwsze_strony, $pozycje){
		if($pozycje){
			$klucze = base::get_array_keys($pozycje);

			foreach($klucze as $index){
				// zapis najlepszej pozycji
				$fraza = self::jedna($index);
				if($pozycje[$index] > 0){
					if($pozycje[$index] < $fraza['najlepsza_pozycja'] || $fraza['najlepsza_pozycja'] == 0){
						$tabela = $this -> db -> table('frazy');

						$tabela -> update(array('najlepsza_pozycja' => $pozycje[$index]))
						-> where('id_frazy','=',$index)
						-> execute();
					}
				}

				$tabela = $this -> db -> table('frazy_wyniki');

				// usuwanie starych wpisów
				$tabela -> delete()
				-> where('id_frazy','=',$index)
				-> clause('AND')
				-> where('data','=',$data)
				-> execute();

				// wstawianie nowego wpisu
				$pierwsza_strona = isset($pierwsze_strony[$index]) ? $pierwsze_strony[$index] : 0;

				$tabela -> insert(array('data' => $data,
						'id_frazy' => $index,
						'pierwsza_strona' => $pierwsza_strona,
						'wynik' => $pozycje[$index]), false);
			}

			// kalkulacja zmiany w stosunku do poprzedniego dnia
			if($data == date("Y-m-d")){
				$odsetek_w_top_10_dzis = self::wylicz_odsetek_na_pierwszej_stronie(self::pierwsze_strony_na_dzien(date("Y-m-d"), $id_klienta));
				$odsetek_w_top_10_wczoraj = self::wylicz_odsetek_na_pierwszej_stronie(self::pierwsze_strony_na_dzien(date("Y-m-d", strtotime("-1 day")), $id_klienta));
				$roznica = $odsetek_w_top_10_dzis - $odsetek_w_top_10_wczoraj;
				$liczba_na_1_stronie_dzisiaj = self::wylicz_liczbe_fraz_na_pierwszej_stronie(self::pierwsze_strony_na_dzien(date("Y-m-d"), $id_klienta));

				// zapis zmiany
				$tabela = $this -> db -> table('klienci');
				$tabela -> update(array('data_sprawdzenia_wynikow' => date("Y-m-d"),
						'odsetek_fraz_w_top_10_ilosc' => $odsetek_w_top_10_dzis,
						'odsetek_fraz_w_top_10_zmiana' => $roznica))
						-> where('id_klienta','=',$id_klienta)
						-> execute();
				$tabela = $this -> db -> table('klienci');
				$tabela -> update(array('data_sprawdzenia_wynikow' => date("Y-m-d"),
						'ile_na_1_stronie' => $liczba_na_1_stronie_dzisiaj))
						-> where('id_klienta','=',$id_klienta)
						-> execute();
			}

		}

		return true;
	}


	public function odsetek_w_top_10($id_klienta, $miesiac){
		$liczba_dni_miesiacu = date("t", strtotime($miesiac));
		$odsetek = array();
		for($i = 1; $i <= $liczba_dni_miesiacu; $i++){
			$dzien = $i < 10 ? '0'.$i : $i;
			$data = $miesiac.'-'.$dzien;
			$wyniki_z_dnia = self::wyniki_na_dzien($data, $id_klienta);
			$odsetek[$i] = $wyniki_z_dnia ? self::wylicz_odsetek_w_top_10($wyniki_z_dnia) : 0;
		}
		return $odsetek;
	}


	public function odsetek_na_pierwszej_stronie($id_klienta, $miesiac){
		$liczba_dni_miesiacu = date("t", strtotime($miesiac));
		$odsetek = array();
		for($i = 1; $i <= $liczba_dni_miesiacu; $i++){
			$dzien = $i < 10 ? '0'.$i : $i;
			$data = $miesiac.'-'.$dzien;
			$pierwsze_strony_na_dzien = self::pierwsze_strony_na_dzien($data, $id_klienta);
			$odsetek[$i] = $pierwsze_strony_na_dzien ? self::wylicz_odsetek_na_pierwszej_stronie($pierwsze_strony_na_dzien) : 0;
		}
		return $odsetek;
	}


	public function zaawansowanie_w_top_10($id_klienta, $miesiac){
		$liczba_dni_miesiacu = date("t", strtotime($miesiac));
		$zaawansowanie = array();
		for($i = 1; $i <= $liczba_dni_miesiacu; $i++){
			$dzien = $i < 10 ? '0'.$i : $i;
			$data = $miesiac.'-'.$dzien;
			$zaawansowanie[$i] = self::wylicz_zaawansowanie_w_top_10($data, $id_klienta);
		}
		return $zaawansowanie;
	}


	public function wylicz_odsetek_w_top_10($wyniki){
		if(!$wyniki) return 0;
		$liczba_fraz = count($wyniki);
		$w_top = 0;
		foreach($wyniki as $wynik){
			if($wynik <= 10 && $wynik > 0) $w_top++;
		}
		return number_format(($w_top / $liczba_fraz) * 100, 0);
	}


	public function wylicz_odsetek_na_pierwszej_stronie($wyniki){
		if(!$wyniki) return 0;
		$liczba_fraz = count($wyniki);
		$na_pierwszej_stronie = 0;
		foreach($wyniki as $wynik) if($wynik == 1) $na_pierwszej_stronie++;

		return number_format(($na_pierwszej_stronie / $liczba_fraz) * 100, 0);
	}


	public function wylicz_liczbe_fraz_na_pierwszej_stronie($wyniki){
		if(!$wyniki) return 0;
		$liczba_fraz = count($wyniki);
		$na = 0;
		foreach($wyniki as $wynik){
			if($wynik == 1) $na++;
		}
		return $na;
	}


	public function wylicz_zaawansowanie_w_top_10($data, $id_klienta){
		if(!$wyniki = self::wyniki_na_dzien($data, $id_klienta)) return 0;
		$liczba_fraz = count($wyniki);

		// liczba fraz w top 10
		$w_top = 0;
		foreach($wyniki as $wynik){
			if($wynik <= 10 && $wynik > 0) $w_top++;
		}


		$suma_procentow = 0;
		foreach($wyniki as $wynik){
			$suma_procentow = $suma_procentow + (($wynik < 11 && $wynik != 0) ? (10 - $wynik + 1) * 10 : 0);
		}

		return $w_top ? floor($suma_procentow / $w_top) : 0;
	}


	public function raport_miesieczny($id_klienta, $miesiac){
		$liczba_dni_miesiacu = date("t", strtotime($miesiac));
		$frazy = self::wszystkie($id_klienta);
		//echo '<pre>';
		$dane = array();
		foreach($frazy as $fraza){
			//echo 'Fraza: '.$fraza['nazwa'].'<br />';
			for($i = 1; $i <= $liczba_dni_miesiacu; $i++){
				$dzien = $i < 10 ? '0'.$i : $i;
				$data = $miesiac.'-'.$dzien;

				$tabela = $this -> db -> table('frazy_wyniki');

				$wynik = $tabela -> select('*')
				-> where('data', '=', $data)
				-> clause('AND')
				-> where('id_frazy', '=', $fraza['id_frazy'])
				-> execute();

				$wynik = $wynik ? $wynik[0] : false;

				//echo '  Data: '.$data.', Wynik: '.($wynik ? $wynik['wynik'] : 0).'<br />';
				$dane[$fraza['id_frazy']][$dzien] = $wynik ? $wynik['wynik'] : 0;
			}
			//echo '<hr />';
			//print_r($dane);
		}

		return $dane;
	}


	public function sprawdz_jakie_sa_frazy($id_klienta){
		if(!$frazy = self::wszystkie($id_klienta)) return false;

		$frazy_top = false;
		$frazy_ryczalt = false;
		foreach($frazy as $fraza){
			if($fraza['typ'] == 1) $frazy_top = true;
			if($fraza['typ'] == 2) $frazy_ryczalt = true;
		}

		if($frazy_top && $frazy_ryczalt) return 3;
		else if($frazy_ryczalt && !$frazy_top) return 2;
		else if($frazy_top && !$frazy_ryczalt) return 1;
		else return false;
	}

	public function ile_frazow($id_klienta){
		$tabela = $this -> db -> table('frazy');

		$wyniki = $tabela -> select('*')
		-> where('id_klienta', '=', $id_klienta)
		-> execute();

			
		$ile_fraz = count($wyniki);
			
		return $ile_fraz;
	}

	public function update_grupy_z_gl($response, $id_klienta){
		$tabela = $this -> db -> table('klienci');

		$response = explode('"', $response);
		$gl_group = (int)$response[3];
			
		$tabela -> update(array('gotlink_grupa' => $gl_group))
		-> where('id_klienta','=',$id_klienta)
		-> execute();
	}
	public function usun_info_grupy_gl_z_bazy($id_klienta){
		$tabela = $this -> db -> table('klienci');
		$tabela -> update(array('gotlink_grupa' => 0))
		-> where('id_klienta','=',$id_klienta)
		-> execute();
	}
	
	public function zmien_handlowca($id_klienta, $idhnd){
		$tabela = $this -> db -> table('klienci');

		$tabela -> update(array('id_partnera' => $idhnd))
		-> where('id_klienta','=',$id_klienta)
		-> execute();
	
	}
}

?>