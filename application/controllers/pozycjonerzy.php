<?php

    class controller{

        public function index(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $pozycjonerzy = $this -> load -> model('pozycjonerzy') -> wszyscy();

    		$this -> load -> view('pozycjonerzy', array('pozycjonerzy' => $pozycjonerzy,
    		                                            'uzytkownik' => $uzytkownik));
        }


    	public function form($id_pozycjonera){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $pozycjoner = $this -> load -> model('pozycjonerzy') -> jeden($id_pozycjonera);
		
    		$this -> load -> view('pozycjonerzy_formularz', array('pozycjoner' => $pozycjoner,
    		                                                      'uzytkownik' => $uzytkownik));
    	}


    	public function zapisz($id_pozycjonera){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $pozycjonerzy = $this -> load -> model('pozycjonerzy');

            $data_utworzenia = $this -> input -> post('data_utworzenia');
            $haslo = $this -> input -> post('haslo');
            $login = strtolower(trim($this -> input -> post('login')));
            $mail = strtolower(trim($this -> input -> post('mail')));
            $nazwa = $this -> input -> post('nazwa');

            if(!$data_utworzenia || !$haslo || !$mail || !$nazwa) $this -> session -> set('error', 1);
            else if(!validate::e_mail($mail)) $this -> session -> set('error', 2);
            else if(!validate::login($login)) $this -> session -> set('error', 3);
            else if($pozycjonerzy -> czy_login_istnieje($id_pozycjonera, $login)) $this -> session -> set('error', 4);

            if($this -> session -> get('error')){
    		    $this -> load -> view('pozycjonerzy_formularz', array('pozycjoner' => array('data_utworzenia' => $data_utworzenia,
    		                                                                                'haslo' => $haslo,
    		                                                                                'login' => $login,
    		                                                                                'mail' => $mail,
    		                                                                                'nazwa' => $nazwa),
    		                                                          'uzytkownik' => $uzytkownik));
    		    exit;
            }

            $pozycjonerzy -> zapisz($data_utworzenia, $haslo, $id_pozycjonera, $login, $mail, $nazwa);

            $this -> session -> set('info', 1);

            if($this -> input -> post('redirectBack')) url::redirect('pozycjonerzy/form/'.$id_partnera);
            else url::redirect('pozycjonerzy');
    	}

    }

?>