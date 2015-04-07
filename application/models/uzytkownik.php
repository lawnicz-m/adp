<?php

    class uzytkownik_model{

        public function zalogowany(){
    		$haslo = $this -> session -> get('haslo');
    	    $id = $this -> session -> get('id');
    		$login = $this -> session -> get('login');
    		$typ = $this -> session -> get('typ');

            if($typ == 'partner') $tabela = $this -> db -> table('partnerzy');		
		    else if($typ == 'pozycjoner') $tabela = $this -> db -> table('pozycjonerzy');
		    else $tabela = $this -> db -> table('admini');

            if($typ == 'partner') $kolumna_id = 'id_partnera';
		    else if($typ == 'pozycjoner') $kolumna_id = 'id_pozycjonera';
		    else $kolumna_id = 'id_admina';

    		$uzytkownik = $tabela -> select('*')
    		                      -> where($kolumna_id, '=', $id)
    		                      -> clause('AND')
    		                      -> where('login', '=', $login)
    		                      -> clause('AND')
    		                      -> where('haslo', '=', $haslo)
    		                      -> execute();
            // autoryzacja
    		if(!$uzytkownik){
    		    $this -> wyloguj();
    		    if(CONTROLLER != 'autoryzacja') url::redirect('autoryzacja');
    		    return false;
    		}
            if(CONTROLLER == 'autoryzacja') url::redirect('witaj');

    		$uzytkownik = $uzytkownik[0];

            $uzytkownik['id'] = $id;
            $uzytkownik['typ'] = $typ;

            // zapis aktywności partnera
            if($typ == 'partner'){
                $this -> db -> query("UPDATE partnerzy
                                      SET data_ostatniej_aktywnosci = now()
                                      WHERE id_partnera = $id");
            }

            return $uzytkownik;

        }


    	public function zaloguj($login, $haslo, $typ){
            if($typ == 'partner') $tabela = $this -> db -> table('partnerzy');		
		    else if($typ == 'pozycjoner') $tabela = $this -> db -> table('pozycjonerzy');
		    else $tabela = $this -> db -> table('admini');

    		$uzytkownik = $tabela -> select('*')
    		                      -> where('login', '=', $login)
    		                      -> clause('AND')
    		                      -> where('haslo', '=', $haslo)
    		                      -> execute();

    		$uzytkownik = $uzytkownik ? $uzytkownik[0] : false;

    		if($uzytkownik){
                if(isset($uzytkownik['id_admina'])) $id = $uzytkownik['id_admina'];
                else if(isset($uzytkownik['id_pozycjonera'])) $id = $uzytkownik['id_pozycjonera'];
                else if(isset($uzytkownik['id_partnera'])) $id = $uzytkownik['id_partnera'];
                else return false;

    			$this -> session -> set('haslo', $haslo);
    			$this -> session -> set('id', $id);
    			$this -> session -> set('login', $login);
    			$this -> session -> set('typ', $typ);

    			return true;
    		}else{
    			return false;
    		}
    	}


        public function wyloguj(){
        	$this -> session -> delete('haslo');
        	$this -> session -> delete('id');
        	$this -> session -> delete('login');
        	$this -> session -> delete('typ');

            return true;
        }


    	public function zmien_haslo($login, $haslo, $typ){
            if($typ == 'partner') $tabela = $this -> db -> table('partnerzy');		
		    else if($typ == 'pozycjoner') $tabela = $this -> db -> table('pozycjonerzy');
		    else $tabela = $this -> db -> table('admini');

            $haslo = $this -> db -> clean($haslo);

        	$tabela -> update(array('haslo' => $haslo))
	                -> where('login','=',$login)
        	        -> execute();

            $this -> session -> set('haslo', $haslo);

            return true;
        }


    	public function czy_haslo_jest_poprawne($login, $haslo, $typ){
            if($typ == 'partner') $tabela = $this -> db -> table('partnerzy');		
		    else if($typ == 'pozycjoner') $tabela = $this -> db -> table('pozycjonerzy');
		    else $tabela = $this -> db -> table('admini');

    		$dane = $tabela -> select('haslo')
    		                -> where('login','=',$login)
    		                -> execute();

            $haslo_z_bazy = $dane ? $dane[0]['haslo'] : false;
            if(!$haslo_z_bazy) return false;
            if($haslo_z_bazy == $haslo) return true;
            else return false;

        }

    }

?>