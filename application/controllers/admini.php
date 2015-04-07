<?php

    class controller{

        public function index(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $admini = $this -> load -> model('admini') -> wszyscy();

    		$this -> load -> view('admini', array('admini' => $admini,
    		                                      'uzytkownik' => $uzytkownik));
        }


    	public function form($id_admina){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $admin = $this -> load -> model('admini') -> jeden($id_admina);
		
    		$this -> load -> view('admini_formularz', array('admin' => $admin,
    		                                                'uzytkownik' => $uzytkownik));
    	}


    	public function zapisz($id_admina){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');

            $admini = $this -> load -> model('admini');

            $data_utworzenia = $this -> input -> post('data_utworzenia');
            $haslo = $this -> input -> post('haslo');
            $login = strtolower(trim($this -> input -> post('login')));
            $mail = strtolower(trim($this -> input -> post('mail')));
            $nazwa = $this -> input -> post('nazwa');

            if(!$data_utworzenia || !$haslo || !$mail || !$nazwa) $this -> session -> set('error', 1);
            else if(!validate::e_mail($mail)) $this -> session -> set('error', 2);
            else if(!validate::login($login)) $this -> session -> set('error', 3);
            else if($admini -> czy_login_istnieje($id_admina, $login)) $this -> session -> set('error', 4);

            if($this -> session -> get('error')){
    		    $this -> load -> view('admini_formularz', array('admin' => array('data_utworzenia' => $data_utworzenia,
    		                                                                     'haslo' => $haslo,
    		                                                                     'login' => $login,
    		                                                                     'mail' => $mail,
    		                                                                     'nazwa' => $nazwa),
    		                                                    'uzytkownik' => $uzytkownik));
    		    exit;
            }

            $admini -> zapisz($data_utworzenia, $haslo, $id_admina, $login, $mail, $nazwa);

            $this -> session -> set('info', 1);

            if($this -> input -> post('redirectBack')) url::redirect('admini/form/'.$id_admina);
            else url::redirect('admini');
    	}

    }

?>