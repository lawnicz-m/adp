<?php

class queryservers_model {
	
	private $SERVER_TIMEOUT_IN_HOURS = 3;

	public function all() {
		$table = $this->db->table('query_servers');

		$servers = $table
		->select('*')
		->order_by('server_url', 'ASC')
		->execute();

		return $servers ? $servers : false;
	}

	public function available() {
		$query = 'SELECT * FROM (SELECT id_qserver, server_url, TIMESTAMPDIFF(HOUR, `last_query_time`, NOW()) as hours_since_last_used
				FROM query_servers) as qs WHERE hours_since_last_used >= '. $this->SERVER_TIMEOUT_IN_HOURS;
		
		$servers = $this->db->query($query);

		return $servers ? $servers : false;
	}
	
	public function availibleForForm($timeoutHours) {
		
		$query = 'SELECT * FROM (SELECT id_qserver, server_url, TIMESTAMPDIFF(HOUR, `last_query_time`, NOW()) as hours_since_last_used
				FROM query_servers) as qs WHERE hours_since_last_used >= '. $this->SERVER_TIMEOUT_IN_HOURS;
		
		$servers = $this->db->query($query);
		
		for($i=0; $i<count($servers); $i++) {
			$servers[$i]['server_label'] = $servers[$i]['id_qserver'].' : '.$servers[$i]['server_url'] . ' ('.$servers[$i]['hours_since_last_used'].' h)';
		}
		
		return $servers;
	}
	
	public function queryPhrases($queryServerURL, $ip, $fileName, $pageAddress, $phrases) {
		
		$agent = "User-Agent: Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.13) Gecko/20101206 Ubuntu/10.10 (maverick) Firefox/3.6.13";
		$fields = array(
				'serwer_sprawdzajacy'	=> $queryServerURL,
				'ip'					=> $ip,
				'nazwa_pliku'			=> $fileName,
				'adres_strony'			=> $pageAddress,
				'frazy'					=> $phrases
		);
		
		$fields_string = '';
		foreach($fields as $key=>$value) {
			$fields_string .= "$key=$value&";
		}
		
		$fields_string = substr($fields_string, 0, strlen($fields_string) - 1);
		
		$headers = array(
        	"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
        	"Accept-Language: en-us,en;q=0.5",
        	"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
        	"Keep-Alive: 115",
        	"Connection: keep-alive");
		
		// http://' + $('#serwer_sprawdzajacy option:selected').text() + '/fm33/szukanie.php
		$ch = curl_init('http://' . $queryServerURL . '/fm33/szukanie.php');

		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$response = curl_exec($ch);
		$responseHeader  = curl_getinfo($ch);
		
		curl_close($ch);

		$fh = fopen('/srv/www/vhosts/adp/response.txt','w+');
		fwrite($fh, $response);
		fclose($fh);
		
// 		if($response = 0) {
// 			$this->notify_used($queryServerURL);
// 		} else {
// 			/*
// 			 * DB STUFF
// 			 */
// 		}

		/*
		 * <input name="q" type="hidden" value="dziaĹki budowlane szczecin prawobrzeĹźe" />
  <input name="qidd" type="hidden" value="11061123" />
  <input name="ip" type="hidden" value="www.google.pl" />
  <input name="poz" type="hidden"  value="2" />
  <input name="bieg" type="hidden" value="50" />
  <input name="dajesz" type="hidden" value="1" />
  <input name="pp2" type="hidden" value="11061123|0--||" />
    <input name="pierw" type="hidden" value="" />
  <input name="adres_strony" type="hidden" value="dzialkibudowlaneszczecin.net" />
  <input name="frazy" type="hidden" value="11061123|dziaĹki budowlane szczecin prawobrzeĹźe||11061125|dziaĹki na sprzedaĹź szczecin||11061124|dziaĹki rekreacyjne szczecin" />
  <input name="count" type="hidden" value="" />
  <input name="nazwa_pliku" type="hidden" value="22041371454968509-ok-.txt" />
  <script>document.forms['ok'].submit()</script></form>
		 */
	}

	public function notify_used($queryServerURL) {
		$table = $this->db->table('query_servers');
		
		$servers = $table
		->update(array('last_query_time' => 'NOW()'))
		->where('server_url', '=', $queryServerURL)
		->execute();
	}

}





