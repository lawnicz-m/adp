<?php

    class controller{

    	public function index(){
            $this -> load -> model('uzytkownik') -> zalogowany();
    		$this -> load -> view('logowanie', array('uzytkownik' => false));
    	}


        public function zaloguj(){
        	$login = $this -> input -> post('login');
        	$haslo = $this -> input -> post('haslo');
        	$typ = strtolower($this -> input -> post('typ'));
        	
        	$md5 = md5($haslo);

        	if($this -> load -> model('uzytkownik') -> zaloguj($login, $md5, $typ)){
        	    url::redirect('witaj');
        	}else{
        	    $this -> session -> set('error', 'Login lub hasło były błędne');
        	    url::redirect('autoryzacja');
            }
        }


        public function wyloguj(){
        	$this -> load -> model('uzytkownik') -> wyloguj();
        	url::redirect('autoryzacja');
        }

    }

?>