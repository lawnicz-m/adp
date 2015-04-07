<?php

    class umowy_model{

        public function wszystkie($id_klienta){
    		$tabela = $this -> db -> table('umowy');

    		$umowy = $tabela -> select('*')
    		                 -> where('id_klienta', '=', $id_klienta)
    		                 -> order_by('numer', 'ASC')
    		                 -> execute();

            return $umowy ? $umowy : false;
        }


        public function jedna($id_umowy){
    		$tabela = $this -> db -> table('umowy');

    		$umowa = $tabela -> select('*')
    		                 -> where('id_umowy', '=', $id_umowy)
                             -> limit(1)
    		                 -> execute();

            return $umowa ? $umowa[0] : false;
        }


        public function zapisz($data_rozpoczecia, $id_klienta, $id_umowy, $nazwa, $numer, $termin_platnosci, $termin_realizacji, $typ_realizacji, $typ_umowy, $wynagrodzenie, $wysokosc_zadatku){
    		$tabela = $this -> db -> table('umowy');

            if($id_umowy){
            	$tabela -> update(array('data_rozpoczecia' => $data_rozpoczecia,
            	                        'nazwa' => $nazwa,
            	                        'numer' => $numer,
            	                        'termin_platnosci' => $termin_platnosci,
                                        'termin_realizacji' => $termin_realizacji,
                                        'typ_realizacji' => $typ_realizacji,
                                        'typ_umowy' => $typ_umowy,
                                        'wynagrodzenie' => $wynagrodzenie,
                                        'wysokosc_zadatku' => $wysokosc_zadatku))
    	                -> where('id_umowy','=',$id_umowy)
            	        -> execute();
    	    }else{
            	$tabela -> insert(array('data_rozpoczecia' => $data_rozpoczecia,
            	                        'id_klienta' => $id_klienta,
            	                        'nazwa' => $nazwa,
            	                        'numer' => $numer,
            	                        'termin_platnosci' => $termin_platnosci,
                                        'termin_realizacji' => $termin_realizacji,
                                        'typ_realizacji' => $typ_realizacji,
                                        'typ_umowy' => $typ_umowy,
                                        'wynagrodzenie' => $wynagrodzenie,
                                        'wysokosc_zadatku' => $wysokosc_zadatku), false);
    	    }

    	    return true;
        }


        public function usun($id_umowy){
    		$tabela = $this -> db -> table('umowy');

        	$tabela -> delete()
                    -> where('id_umowy','=',$id_umowy)
        	        -> execute();

    	    return true;
        }

    }

?>