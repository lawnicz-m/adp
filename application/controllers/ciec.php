 <?php
class controller{
	public function wyslij_email_do_ciecia($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
			$klienci = $this -> load -> model('klienci');
			$klient = $klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);
			$pozycjoner = $this -> load -> model('pozycjonerzy') -> jeden($klient['id_pozycjonera']);
    		$email = new email();
				$email -> to($klient['mail']);
				$email -> from($uzytkownik['mail']);
				$email -> subject(iconv("UTF-8","ISO-8859-2",'TEST'));
				$email -> content(iconv("UTF-8","ISO-8859-2",EDC1.$klient['adres_strony'].EDC2.$pozycjoner['mail'].EDC3.$klient['hash'].'">KLIK</a>'.EDC4));
				$email -> send();
			url::redirect('frazy/wszystkie/'.$id_klienta);
		}
}