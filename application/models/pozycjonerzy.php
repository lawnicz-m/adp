<?php

    class pozycjonerzy_model{

    	public function wszyscy(){
    		$tabela = $this -> db -> table('pozycjonerzy');

    		$dane = $tabela -> select('*')
    		                -> order_by('id_pozycjonera', 'ASC')
    		                -> execute();

            return $dane ? $dane : false;
        }


    	public function jeden($id_pozycjonera){
    		$tabela = $this -> db -> table('pozycjonerzy');

    		$pozycjoner = $tabela -> select('*')
    		                      -> where('id_pozycjonera','=',$id_pozycjonera)
    		                      -> limit(1)
    		                      -> execute();

            return $pozycjoner ? $pozycjoner[0] : false;
        }


        public function zapisz($data_utworzenia, $haslo, $id_pozycjonera, $login, $mail, $nazwa){
    		$tabela = $this -> db -> table('pozycjonerzy');
				$baza_haslo_arr = $tabela -> select('haslo')
    		                -> where('id_pozycjonera','=',$id_pozycjonera)
    		                -> execute();
    		$baza_haslo = ($baza_haslo_arr[0]["haslo"]);
    		                
            if($id_pozycjonera){
            	if($baza_haslo != $haslo) {
            		$md5 = md5($haslo);
            		$tabela -> update(array('haslo' => $md5,))
    	                -> where('id_pozycjonera','=',$id_pozycjonera)
            	        -> execute();}
            	        
            	$tabela -> update(array('data_utworzenia' => $data_utworzenia,
            	                        'login' => $login,
            	                        'mail' => $mail,
            	                        'nazwa' => $nazwa))
    	                -> where('id_pozycjonera','=',$id_pozycjonera)
            	        -> execute();
    	    }else{
    	    				$md5 = md5($haslo);
            	$tabela -> insert(array('data_utworzenia' => $data_utworzenia,
            	                        'haslo' => $md5,
            	                        'login' => $login,
            	                        'mail' => $mail,
            	                        'nazwa' => $nazwa), false);
    	    }

    	    return true;
        }


        public function czy_login_istnieje($id_pozycjonera, $login){
    		$table = $this -> db -> table('pozycjonerzy');

    		$wynik = $table -> select('*')
    		                -> where('login','=',$login)
    		                -> execute();

            $wynik = $wynik ? 1 : 0;

            if($id_pozycjonera && $wynik){
        		$dane = $table -> select('*')
        		               -> where('id_pozycjonera','=',$id_pozycjonera)
    		                   -> clause('AND')
        		               -> where('login','=',$login)
        		               -> execute();

                $dane = $dane ? 1 : 0;
                if($dane) $wynik = 0;
            }

            return $wynik;
        }


        public function lista_do_selecta(){
    		$tabela = $this -> db -> table('pozycjonerzy');

    		$dane = $tabela -> select('id_pozycjonera', 'nazwa')
    		                -> order_by('nazwa', 'ASC')
    		                -> execute();

            return $dane ? $dane : false;            
        }
		public function lista_do_selecta_kat(){
    		$tabela = $this -> db -> table('kategorie');

    		$dane = $tabela -> select('numer_kat', 'nazwa')
    		                -> order_by('nazwa', 'ASC')
    		                -> execute();

            return $dane ? $dane : false;            
        }

    }

?>