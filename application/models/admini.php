<?php

    class admini_model{

    	public function wszyscy(){
    		$tabela = $this -> db -> table('admini');

    		$dane = $tabela -> select('*')
    		                -> order_by('id_admina', 'ASC')
    		                -> execute();

            return $dane ? $dane : false;
        }


    	public function jeden($id_admina){
    		$tabela = $this -> db -> table('admini');

    		$admin = $tabela -> select('*')
    		                 -> where('id_admina','=',$id_admina)
    		                 -> limit(1)
    		                 -> execute();

            return $admin ? $admin[0] : false;
        }


        public function zapisz($data_utworzenia, $haslo, $id_admina, $login, $mail, $nazwa){
    		$tabela = $this -> db -> table('admini');
    		$baza_haslo_arr = $tabela -> select('haslo')
    		                -> where('id_admina','=',$id_admina)
    		                -> execute();
    		$baza_haslo = ($baza_haslo_arr[0]["haslo"]);
    		
            if($id_admina){
            	if($baza_haslo != $haslo) {
            		$md5 = md5($haslo);
            		$tabela -> update(array('haslo' => $md5,))
    	                -> where('id_admina','=',$id_admina)
            	        -> execute();}
            	        
            	$tabela -> update(array('data_utworzenia' => $data_utworzenia,
            	                        'login' => $login,
            	                        'mail' => $mail,
            	                        'nazwa' => $nazwa))
    	                					-> where('id_admina','=',$id_admina)
            	       					-> execute();
            	
    	    }
    	    else{
    	    				$md5 = md5($haslo);
            	$tabela -> insert(array('data_utworzenia' => $data_utworzenia,
            																	'haslo' => $md5,
            	                        'login' => $login,
            	                        'mail' => $mail,
            	                        'nazwa' => $nazwa), false);
    	    }

    	    return true;
        }


        public function czy_login_istnieje($id_admina, $login){
    		$table = $this -> db -> table('admini');

    		$wynik = $table -> select('*')
    		                -> where('login','=',$login)
    		                -> execute();

            $wynik = $wynik ? 1 : 0;

            if($id_admina && $wynik){
        		$dane = $table -> select('*')
        		               -> where('id_admina','=',$id_admina)
    		                   -> clause('AND')
        		               -> where('login','=',$login)
        		               -> execute();

                $dane = $dane ? 1 : 0;
                if($dane) $wynik = 0;
            }

            return $wynik;
        }

    }

?>