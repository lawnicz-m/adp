<?php

class controller{
    
	public function view($id_klienta){
								$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            
            $klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);

            if($id_klienta && !$klient) $this -> load -> error('no-access');

			$this -> load -> view('budzet_status', array('klient' => $klient, 'uzytkownik' => $uzytkownik));
		}
	public function form($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            $klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);

            if($id_klienta && !$klient) $this -> load -> error('no-access');
		
    		$this -> load -> view('budzet_form', array('klient' => $klient, 'uzytkownik' => $uzytkownik));

		}
	public function zapisz($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');
            $model = $this -> load -> model('budzet');
            
            if($id_klienta && !$klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
            
            $budzet = $this -> input -> post('budzet');
            $koszt = $this -> input -> post('koszt');
            $na_co = $this -> input -> post('na_co');
            
            $model -> zapisz($budzet, $koszt, $na_co, $id_klienta);

       				$this -> session -> set('info', 1);
            
            url::redirect($id_klienta ? 'budzet/view/'.$id_klienta : 'klienci/lista');
		}                                              
}
?>