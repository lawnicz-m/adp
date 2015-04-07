<?php

    class controller{

    	public function index(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
    		$this -> load -> view('ustawienia_formularz', array('uzytkownik' => $uzytkownik));
    	}


    	public function zapisz(){
            $_uzytkownik = $this -> load -> model('uzytkownik');
            $uzytkownik = $_uzytkownik -> zalogowany();

            $nowe_haslo = $this -> input -> post('nowe_haslo');
            $nowe_haslo_2 = $this -> input -> post('nowe_haslo_2');
            $stare_haslo = $this -> input -> post('stare_haslo');

            if(!$stare_haslo || !$nowe_haslo || !$nowe_haslo_2) $this -> session -> set('error', 1);
            else if(!$_uzytkownik -> czy_haslo_jest_poprawne($uzytkownik['login'], $stare_haslo, $uzytkownik['typ'])) $this -> session -> set('error', 'Stare hasło było błędne.');
            else if($nowe_haslo != $nowe_haslo_2) $this -> session -> set('error', 'Nowe hasła różniły się od siebie.');

            if($this -> session -> get('error')){
    		    $this -> load -> view('ustawienia_formularz');
    		    exit;
            }

            $_uzytkownik -> zmien_haslo($uzytkownik['login'], $nowe_haslo, $uzytkownik['typ']);

            $this -> session -> set('info', 'Hasło zostało zmienione.');

            url::redirect('ustawienia');
    	}    	

    }

?>