<?php
class controller{
	public function gotlink_API(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
			if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');
    		$this -> load -> view('witaj', array('uzytkownik' => $uzytkownik));
		}


	public function gotlink_API_pobierz(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
			if($uzytkownik['typ'] != ('admin' || 'pozycjoner')) $this -> load -> error('no-access');
				$data = array(
				'username' => 'adppoland',
				'md5pass' => '081a6d456f1c76d6ff60bfc9585b1f2b',
				'action' => 'get',
				'type' => 'links',
				'order' => 'group_id',
				'order_type' => 'desc',
				'return' => 'json');
				$ch = curl_init('http://www.gotlink.pl/gotlink-api/');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
				curl_setopt($ch, CURLOPT_TIMEOUT, 15);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				$response = curl_exec($ch);
				curl_close($ch);
				$odp = json_decode($response, true);
				if (isset($odp['error'])) {
				$this -> session -> set('error', 'Uwaga błąd! '.$odp['error']);
				}
				else{
				file_put_contents('gotlinek.txt', $response);
				$this -> session -> set('info', 'Pobrano poprawnie dane z GL');
				}
				url::goback();
		}
	public function gotlink_status($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();

            if($uzytkownik['typ'] != ('admin' || 'pozycjoner')) $this -> load -> error('no-access');

            $klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);

            if($id_klienta && !$klient) $this -> load -> error('no-access');

			$this -> load -> view('gotlink_status', array('klient' => $klient, 'uzytkownik' => $uzytkownik));
		}

	public function aktualizuj_gotlink($id_klienta){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $klienci = $this -> load -> model('klienci');
			if($id_klienta && !$klienci -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ'])) $this -> load -> error('no-access');
				$gotlink_stare_punkty = $this -> input -> post('punkty_stare');
				$gotlink_points = $this -> input -> post('points');
				$gotlink_group_id = $this -> input -> post('id_grupy');
				if ($gotlink_points != $gotlink_stare_punkty)
					if ($gotlink_points == 0)
					{
					$data = array(
					'username' => 'adppoland',
					'md5pass' => '081a6d456f1c76d6ff60bfc9585b1f2b',
					'action' => 'delete',
					'type' => 'groups',
					'id' => $gotlink_group_id);
					$ch = curl_init('http://www.gotlink.pl/gotlink-api/');
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
					curl_setopt($ch, CURLOPT_TIMEOUT, 15);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
					$response = curl_exec($ch);
					curl_close($ch);
					$odp = json_decode($response, true);
						if (isset($odp['error']))
						$this -> session -> set('error', 'Uwaga błąd! '.$odp['error']);
						$this -> session -> set('info', 'Usunięto poprawnie Klienta z GL');
				}
				else{

						$data = array(
						'username' => 'adppoland',
						'md5pass' => '081a6d456f1c76d6ff60bfc9585b1f2b',
						'action' => 'edit',
						'type' => 'groups',
						'id' => $gotlink_group_id,
						'points' => $gotlink_points);

						$ch = curl_init('http://www.gotlink.pl/gotlink-api/');
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
						curl_setopt($ch, CURLOPT_TIMEOUT, 15);
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
						$response = curl_exec($ch);
						curl_close($ch);
						$odp = json_decode($response, true);
							if (isset($odp['error']))
							$this -> session -> set('error', 'Uwaga błąd! '.$odp['error']);
							$this -> session -> set('info', 'Poprawiono liczbę punktów przypisanych dla Klienta');
					}

			url::goback();
    	}
	public function update_gl(){
			$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
			if($uzytkownik['typ'] != ('admin' || 'pozycjoner')) $this -> load -> error('no-access');
			$table = $this -> db -> table('klienci');

    		$klienci = $table -> select('*')
    		                  -> execute();

			$data = array(
					'username' => 'adppoland',
					'md5pass' => '081a6d456f1c76d6ff60bfc9585b1f2b',
					'action' => 'get',
					'type' => 'groups');
					$ch = curl_init('http://www.gotlink.pl/gotlink-api/');
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
					curl_setopt($ch, CURLOPT_TIMEOUT, 15);
					curl_setopt($ch, CURLOPT_POST, 2);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
					$response = curl_exec($ch);
					$odp = array();
					$odp = json_decode($response, true);
						if (isset($odp['error']))
						{
						$this -> session -> set('error', 'Uwaga błąd! '.$odp['error']);
							if($this -> session -> get('error')) url::goback();
						}
						else{
						$odp2 = array();
						$odp2 = $odp['result'];
						
						foreach ($klienci as $klient){
						$table -> update(array('gotlink_grupa' => '0', 'gotlink_punkty' => '0'))
												-> where('id_klienta','=',$klient['id_klienta'])
												-> execute();
						}				
										
						foreach ($klienci as $klient){
								foreach ($odp2 as $gotlink){
								
													
									if ($klient['adres_strony'] == $gotlink['name'] || 'www.'.$klient['adres_strony'] == $gotlink['name']){

										$gl_punkty = $gotlink['points'];
										$gl_group = $gotlink['id'];
										$table -> update(array('gotlink_grupa' => $gl_group, 'gotlink_punkty' => $gl_punkty))
												-> where('id_klienta','=',$klient['id_klienta'])
												-> execute();

										}
								}

							}
						}


		$this -> session -> set('info', 'Poprawnie przypisano grupy z GL do bazy');
		url::goback();
		}
		public function usun_nfo_grupa_gl($id_klienta){
		$uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
		if($uzytkownik['typ'] != ('admin' || 'pozycjoner')) $this -> load -> error('no-access');
        $klient = $this -> load -> model('klienci') -> jeden_klient($uzytkownik['id'], $id_klienta, $uzytkownik['typ']);
        if($id_klienta && !$klient) $this -> load -> error('no-access');
		if($uzytkownik['typ'] != 'admin') $this -> load -> error('no-access');
		$table = $this -> db -> table('klienci');
		
		$table -> update(array('gotlink_grupa' => 0))
												-> where('id_klienta','=',$klient['id_klienta'])
												-> execute();

										
		$this -> session -> set('info', 'Poprawnie usunięto grupę GL z bazy');
		url::goback();
		}
		
		
		
}

?>