<?php

    class wiadomosci_model{

    	public function pobierz_wszystkie_wiadomosci($uzytkownik, $status, $typ){
            $status = $this -> db -> clean($status);
            $typ = $this -> db -> clean($typ);

            $query =  "SELECT * FROM wiadomosci ";

            if($typ == 'odebrane') $query .= "WHERE typ_odbiorcy = '".$uzytkownik['typ']."' AND id_odbiorcy = '".$uzytkownik['id']."' ";
            else if($typ == 'wyslane') $query .= "WHERE typ_nadawcy = '".$uzytkownik['typ']."' AND id_nadawcy = '".$uzytkownik['id']."' ";

            if($status == 'nieprzeczytane') $query .= "AND data_odczytania = '0000-00-00 00:00:00' ";
            if($status == 'wykonane') $query .= "AND data_potwierdzenia != '0000-00-00 00:00:00' ";
            if($status == 'niewykonane') $query .= "AND data_odczytania != '0000-00-00 00:00:00' AND data_potwierdzenia = '0000-00-00 00:00:00' ";
                      
            $query .= "ORDER BY data_wyslania DESC,
                       id_wiadomosci DESC";

            $dane = $this -> db -> query($query);

            if(!$dane) return false;

            $admini = $this -> load -> model('admini') -> wszyscy();
            $partnerzy = $this -> load -> model('partnerzy') -> wszyscy();
            $pozycjonerzy = $this -> load -> model('pozycjonerzy') -> wszyscy();

            $dane_2 = array();

            $i = 0;
            foreach($dane as $element){
                $dane_2[$i] = $element;

                // nazwa nadawcy
                if($element['typ_nadawcy'] == 'admin') $dane_2[$i]['nazwa_nadawcy'] = self::nazwa_uzytkownika_z_listy($admini, $element['id_nadawcy']);
                else if($element['typ_nadawcy'] == 'partner') $dane_2[$i]['nazwa_nadawcy'] = self::nazwa_uzytkownika_z_listy($partnerzy, $element['id_nadawcy']);
                else if($element['typ_nadawcy'] == 'pozycjoner') $dane_2[$i]['nazwa_nadawcy'] = self::nazwa_uzytkownika_z_listy($pozycjonerzy, $element['id_nadawcy']);

                // nazwa odbiorcy
                if($element['typ_odbiorcy'] == 'admin') $dane_2[$i]['nazwa_odbiorcy'] = self::nazwa_uzytkownika_z_listy($admini, $element['id_odbiorcy']);
                else if($element['typ_odbiorcy'] == 'partner') $dane_2[$i]['nazwa_odbiorcy'] = self::nazwa_uzytkownika_z_listy($partnerzy, $element['id_odbiorcy']);
                else if($element['typ_odbiorcy'] == 'pozycjoner') $dane_2[$i]['nazwa_odbiorcy'] = self::nazwa_uzytkownika_z_listy($pozycjonerzy, $element['id_odbiorcy']);

                $i++;
            }

            return $dane_2;
        }


        public function nazwa_uzytkownika_z_listy($lista, $id_uzytkownika){
            $nowa_lista = array();

            foreach($lista as $element){
                if(isset($element['id_partnera'])) $nowa_lista[$element['id_partnera']] = $element['nazwa'];
                else if(isset($element['id_admina'])) $nowa_lista[$element['id_admina']] = $element['nazwa'];
                else if(isset($element['id_pozycjonera'])) $nowa_lista[$element['id_pozycjonera']] = $element['nazwa'];
            }

            return isset($nowa_lista[$id_uzytkownika]) ? $nowa_lista[$id_uzytkownika] : 'nieznany';
        }


    	public function pobierz_jedna_wiadomosc($id_wiadomosci, $uzytkownik){
            $id_wiadomosci = $this -> db -> clean($id_wiadomosci);

            $dane = $this -> db -> query("SELECT *
                                          FROM wiadomosci
                                          WHERE ((typ_nadawcy = '".$uzytkownik['typ']."' AND id_nadawcy = '".$uzytkownik['id']."')
                                                OR
                                                (typ_odbiorcy = '".$uzytkownik['typ']."' AND id_odbiorcy = '".$uzytkownik['id']."'))
                                                AND id_wiadomosci = '".$id_wiadomosci."'
                                          LIMIT 0,1");

            $dane = $dane ? $dane[0] : false;

            // oznaczenia jako przeczytanej
            if($dane){
                if($dane['typ_odbiorcy'] == $uzytkownik['typ'] && $dane['id_odbiorcy'] == $uzytkownik['id'] && $dane['data_odczytania'] == '0000-00-00 00:00:00') self::oznacz_wiadomosc_jako_przeczytana($id_wiadomosci);
            }

            $admini = $this -> load -> model('admini') -> wszyscy();
            $partnerzy = $this -> load -> model('partnerzy') -> wszyscy();
            $pozycjonerzy = $this -> load -> model('pozycjonerzy') -> wszyscy();

            // nazwa nadawcy
            if($dane['typ_nadawcy'] == 'admin') $dane['nazwa_nadawcy'] = self::nazwa_uzytkownika_z_listy($admini, $dane['id_nadawcy']);
            else if($dane['typ_nadawcy'] == 'partner') $dane['nazwa_nadawcy'] = self::nazwa_uzytkownika_z_listy($partnerzy, $dane['id_nadawcy']);
            else if($dane['typ_nadawcy'] == 'pozycjoner') $dane['nazwa_nadawcy'] = self::nazwa_uzytkownika_z_listy($pozycjonerzy, $dane['id_nadawcy']);

            // nazwa odbiorcy
            if($dane['typ_odbiorcy'] == 'admin') $dane['nazwa_odbiorcy'] = self::nazwa_uzytkownika_z_listy($admini, $dane['id_odbiorcy']);
            else if($dane['typ_odbiorcy'] == 'partner') $dane['nazwa_odbiorcy'] = self::nazwa_uzytkownika_z_listy($partnerzy, $dane['id_odbiorcy']);
            else if($dane['typ_odbiorcy'] == 'pozycjoner') $dane['nazwa_odbiorcy'] = self::nazwa_uzytkownika_z_listy($pozycjonerzy, $dane['id_odbiorcy']);

    		return $dane;
        }


        public function oznacz_wiadomosc_jako_przeczytana($id_wiadomosci){
    		$tabela = $this -> db -> table('wiadomosci');

        	$tabela -> update(array('data_odczytania' => date("Y-m-d H:i:s")))
	                -> where('id_wiadomosci','=',$id_wiadomosci)
        	        -> execute();
        }


        public function oznacz_jako_wykonane($id_wiadomosci, $uzytkownik){
            if(!$wiadomosc = self::pobierz_jedna_wiadomosc($id_wiadomosci, $uzytkownik)) return false;

            if($wiadomosc['typ_odbiorcy'] == $uzytkownik['typ'] && $wiadomosc['id_odbiorcy'] == $uzytkownik['id'] && $wiadomosc['data_potwierdzenia'] == '0000-00-00 00:00:00'){
        		$tabela = $this -> db -> table('wiadomosci');

            	$tabela -> update(array('data_potwierdzenia' => date("Y-m-d H:i:s")))
    	                -> where('id_wiadomosci','=',$id_wiadomosci)
            	        -> execute();
            }
        }


        public function wyslij($id_nadawcy, $id_odbiorcy, $tresc, $typ_nadawcy, $typ_odbiorcy, $tytul){
    		$tabela = $this -> db -> table('wiadomosci');

        	$tabela -> insert(array('data_wyslania' => date("Y-m-d H:i:s"),
        	                        'id_nadawcy' => $id_nadawcy,
        	                        'id_odbiorcy' => $id_odbiorcy,
        	                        'tresc' => $tresc,
        	                        'typ_nadawcy' => $typ_nadawcy,
        	                        'typ_odbiorcy' => $typ_odbiorcy,
        	                        'tytul' => $tytul), false);
        }


        public function pobierz_statystyke_wiadomosci($uzytkownik){
            $query =  "SELECT count(*) as suma_wszystkich_wiadomosci, ";

            // odebrane nieprzeczytane
            $query .= "(SELECT count(*) FROM wiadomosci WHERE typ_odbiorcy = '".$uzytkownik['typ']."' AND id_odbiorcy = '".$uzytkownik['id']."' ";
            $query .= "AND data_odczytania = '0000-00-00 00:00:00') as odebrane_nieprzeczytane, ";

            // odebrane niewykonane
            $query .= "(SELECT count(*) FROM wiadomosci WHERE typ_odbiorcy = '".$uzytkownik['typ']."' AND id_odbiorcy = '".$uzytkownik['id']."' ";
            $query .= "AND data_odczytania != '0000-00-00 00:00:00' AND data_potwierdzenia = '0000-00-00 00:00:00') as odebrane_niewykonane, ";

            // odebrane wykonane
            $query .= "(SELECT count(*) FROM wiadomosci WHERE typ_odbiorcy = '".$uzytkownik['typ']."' AND id_odbiorcy = '".$uzytkownik['id']."' ";
            $query .= "AND data_potwierdzenia != '0000-00-00 00:00:00') as odebrane_wykonane, ";

            // wysłane nieprzeczytane
            $query .= "(SELECT count(*) FROM wiadomosci WHERE typ_nadawcy = '".$uzytkownik['typ']."' AND id_nadawcy = '".$uzytkownik['id']."' ";
            $query .= "AND data_odczytania = '0000-00-00 00:00:00') as wyslane_nieprzeczytane, ";

            // wysłane niewykonane
            $query .= "(SELECT count(*) FROM wiadomosci WHERE typ_nadawcy = '".$uzytkownik['typ']."' AND id_nadawcy = '".$uzytkownik['id']."' ";
            $query .= "AND data_odczytania != '0000-00-00 00:00:00' AND data_potwierdzenia = '0000-00-00 00:00:00') as wyslane_niewykonane, ";

            // wysłane wykonane
            $query .= "(SELECT count(*) FROM wiadomosci WHERE typ_nadawcy = '".$uzytkownik['typ']."' AND id_nadawcy = '".$uzytkownik['id']."' ";
            $query .= "AND data_potwierdzenia != '0000-00-00 00:00:00') as wyslane_wykonane ";

            $query .= "FROM wiadomosci ";
            $query .= "WHERE (typ_odbiorcy = '".$uzytkownik['typ']."' AND id_odbiorcy = '".$uzytkownik['id']."') ";
            $query .= "OR (typ_nadawcy = '".$uzytkownik['typ']."' AND id_nadawcy = '".$uzytkownik['id']."') ";
            $query .= "LIMIT 0,1";

            $dane = $this -> db -> query($query);

            $dane = $dane[0];

            $statystyka = array();
            $statystyka['odebrane']['nieprzeczytane'] = $dane['odebrane_nieprzeczytane'];
            $statystyka['odebrane']['niewykonane'] = $dane['odebrane_niewykonane'];
            $statystyka['odebrane']['wykonane'] = $dane['odebrane_wykonane'];
            $statystyka['wyslane']['nieprzeczytane'] = $dane['wyslane_nieprzeczytane'];
            $statystyka['wyslane']['niewykonane'] = $dane['wyslane_niewykonane'];
            $statystyka['wyslane']['wykonane'] = $dane['wyslane_wykonane'];


            return $statystyka;
        }

    }

?>