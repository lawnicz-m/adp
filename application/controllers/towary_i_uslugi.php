<?php

    class controller{

        public function index(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $towary_i_uslugi = $this -> load -> model('faktury') -> wszystkie_towary_i_uslugi();

    		$this -> load -> view('towary_i_uslugi', array('towary_i_uslugi' => $towary_i_uslugi,
    		                                               'uzytkownik' => $uzytkownik));
        }


    	public function form($id_towaru_lub_uslugi){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $faktury = $this -> load -> model('faktury');

            $towar_lub_usluga = $faktury -> jeden_towar_lub_usluga($id_towaru_lub_uslugi);
		
    		$this -> load -> view('towary_i_uslugi_formularz', array('towar_lub_usluga' => $towar_lub_usluga,
    		                                                         'uzytkownik' => $uzytkownik));
    	}


    	public function zapisz($id_towaru_lub_uslugi){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            // modele
            $faktury = $this -> load -> model('faktury');

            // zmienne
            $jednostka_miary = $this -> input -> post('jednostka_miary');
            $nazwa = $this -> input -> post('nazwa');
            $pkwiu = $this -> input -> post('pkwiu');
            $stawka_vat = $this -> input -> post('stawka_vat');

            // walidacja
            if(!$jednostka_miary || !$nazwa || !$pkwiu || !$stawka_vat) $this -> session -> set('error', 1);

            if($this -> session -> get('error')){
    		    $this -> load -> view('towary_i_uslugi_formularz', array('towar_lub_usluga' => array('jednostka_miary' => $jednostka_miary,
    		                                                                                         'nazwa' => $nazwa,
    		                                                                                         'pkwiu' => $pkwiu,
    		                                                                                         'stawka_vat' => $stawka_vat),
    		                                                             'uzytkownik' => $uzytkownik));
    		    exit;
            }

            $faktury -> zapisz_towar_lub_usluge($id_towaru_lub_uslugi, $jednostka_miary, $nazwa, $pkwiu, $stawka_vat);

            $this -> session -> set('info', 1);

            if($this -> input -> post('redirectBack')) url::redirect('towary_i_uslugi/form/'.$id_towaru_lub_uslugi);
            else url::redirect('towary_i_uslugi');
    	}

    }

?>