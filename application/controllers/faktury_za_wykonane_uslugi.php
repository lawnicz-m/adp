<?php

    class controller{

        public function index(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $_faktury = $this -> load -> model('faktury');
            if($uzytkownik['typ'] != 'partner') $this -> load -> error('no-access');
            if(!$_faktury -> czy_partner_wykonywal_zlecenia($uzytkownik['id'])) $this -> load -> error('no-access');

            $faktury = $_faktury -> pobierz_faktury_za_wykonane_zlecenia($uzytkownik['id']);

    		$this -> load -> view('faktury_za_wykonane_uslugi', array('faktury' => $faktury,
    		                                                          'uzytkownik' => $uzytkownik));
        }

    }

?>