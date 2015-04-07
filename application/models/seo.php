<?php

class seo_model{
	
	public function seo_zapisz ($optymalizacja, $google_ana, $web_tool, $poprawa, $niebonie, $cms_adres, $ftp_server, $seo_inne, $cms_login, $cms_haslo, $ftp_login, $ftp_haslo, $dostepy, $teksty, $id_klienta, $katalogi, $swl, $zaplecza, $mapkagoogle, $katdataod, $katdatado, $swldataod, $swldatado, $zapdataod, $zapfala, $cslink, $csdata, $optdata, $dostepy_cms, $opt_meta_data, $opt_meta, $host_zly, $strona_zla, $strona_popr, $reczna_filtr){
	
	$tabela = $this -> db -> table('klienci');
	$key = "bWaIvexnHHMj9J1E62Kd";
    $method = "cast5-cfb";
   
   $baza_cms_adres_arr = $tabela -> select('cms_adres')
    		                -> where('id_klienta','=',$id_klienta)
    		                -> execute();
   $baza_ftp_server_arr = $tabela -> select('ftp_server')
    		                -> where('id_klienta','=',$id_klienta)
    		                -> execute();
   $baza_seo_inne_arr = $tabela -> select('seo_inne')
    		                -> where('id_klienta','=',$id_klienta)
    		                -> execute();
   $baza_cms_login_arr = $tabela -> select('cms_login')
    		                -> where('id_klienta','=',$id_klienta)
    		                -> execute();
   $baza_cms_haslo_arr = $tabela -> select('cms_haslo')
    		                -> where('id_klienta','=',$id_klienta)
    		                -> execute();
   $baza_ftp_login_arr = $tabela -> select('ftp_login')
    		                -> where('id_klienta','=',$id_klienta)
    		                -> execute();
   $baza_ftp_haslo_arr = $tabela -> select('ftp_haslo')
    		                -> where('id_klienta','=',$id_klienta)
    		                -> execute();
    		                
  $baza_cms_adres 	= ($baza_cms_adres_arr[0]["cms_adres"]);	  
  $baza_ftp_server 	= ($baza_ftp_server_arr[0]["ftp_server"]);	
  $baza_seo_inne 	= ($baza_seo_inne_arr[0]["seo_inne"]);	
  $baza_cms_login 	= ($baza_cms_login_arr[0]["cms_login"]);
  $decrypted_cms_login = openssl_decrypt($baza_cms_login, $method, $key);
  $baza_cms_haslo 	= ($baza_cms_haslo_arr[0]["cms_haslo"]);
  $decrypted_cms_haslo = openssl_decrypt($baza_cms_haslo, $method, $key);
  $baza_ftp_login 	= ($baza_ftp_login_arr[0]["ftp_login"]);
  $decrypted_ftp_login = openssl_decrypt($baza_ftp_login, $method, $key);
  $baza_ftp_haslo 	= ($baza_ftp_haslo_arr[0]["ftp_haslo"]);
  $decrypted_ftp_haslo = openssl_decrypt($baza_ftp_haslo, $method, $key);

	     	
   	if(!empty($optymalizacja)) {
				if($id_klienta){ 
				$tabela -> update(array('optymalizacja' => true))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('optymalizacja' => false))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		
	if(!empty($dostepy)) {
				if($id_klienta){ 
				$tabela -> update(array('dostepy' => true))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('dostepy' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		
	if(!empty($teksty)) {
				if($id_klienta){ 
				$tabela -> update(array('teksty' => true))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('teksty' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
    	
    	if(!empty($google_ana)) {
				if($id_klienta){ 
				$tabela -> update(array('google_ana' => true))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('google_ana' => false))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
       	
    	if(!empty($web_tool)) {
				if($id_klienta){ 
				$tabela -> update(array('web_tool' => true))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('web_tool' => false))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
       	
    	if(!empty($poprawa)) {
				if($id_klienta){ 
				$tabela -> update(array('poprawa' => true))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('poprawa' => false))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
       	
		if(!empty($niebonie)) {
				if($id_klienta){ 
				$tabela -> update(array('niebonie' => true))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('niebonie' => false))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
			if ($baza_cms_adres != $cms_adres){
			if(!empty($cms_adres)) { 
			if($id_klienta){
				$tabela -> update(array('cms_adres' => $cms_adres))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('cms_adres' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}}
       	
			if ($baza_ftp_server != $ftp_server){
			if(!empty($ftp_server)) { 
			if($id_klienta){ 
				$tabela -> update(array('ftp_server' => $ftp_server))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('ftp_server' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}}
       	
			if ($baza_seo_inne != $seo_inne){
			if(!empty($seo_inne)) { 
			if($id_klienta){ 
				$tabela -> update(array('seo_inne' => $seo_inne))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('seo_inne' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}}       	
			if ($decrypted_cms_login != $cms_login){
			if(!empty($cms_login)) { 
			if($id_klienta){
				$encrypted = openssl_encrypt($cms_login, $method, $key);
				$tabela -> update(array('cms_login' => $encrypted))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('cms_haslo' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}}
       	
    	if ($decrypted_cms_haslo != $cms_haslo){
			if(!empty($cms_haslo)) { 
			if($id_klienta){
				$encrypted = openssl_encrypt($cms_haslo, $method, $key);
				$tabela -> update(array('cms_haslo' => $encrypted))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('cms_haslo' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}}
       	
			if ($decrypted_ftp_login != $ftp_login){
			if(!empty($ftp_login)) { 
			if($id_klienta){
				$encrypted = openssl_encrypt($ftp_login, $method, $key);
				$tabela -> update(array('ftp_login' => $encrypted))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('ftp_login' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}}
    
    	if ($decrypted_ftp_haslo != $ftp_haslo){
			if(!empty($ftp_haslo)) { 
			if($id_klienta){
				$encrypted = openssl_encrypt($ftp_haslo, $method, $key);
				$tabela -> update(array('ftp_haslo' => $encrypted))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('ftp_haslo' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}}
		//Yuri addon
		
		if(!empty($katalogi)) {
				if($id_klienta){ 
				$tabela -> update(array('katalogi' => true))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('katalogi' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		if(!empty($zaplecza)) {
				if($id_klienta){ 
				$tabela -> update(array('zaplecza' => true))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('zaplecza' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		if(!empty($swl)) {
				if($id_klienta){ 
				$tabela -> update(array('swl' => true))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('swl' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		
		if(!empty($mapkagoogle)) {
				if($id_klienta){ 
				$tabela -> update(array('google_mapa' => $mapkagoogle))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('google_mapa' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		
		if(!empty($katdataod)) {
				if($id_klienta){ 
				$tabela -> update(array('data_katalogi_start' => $katdataod))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('data_katalogi_start' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		if(!empty($katdatado)) {
				if($id_klienta){ 
				$tabela -> update(array('data_katalogi_end' => $katdatado))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('data_katalogi_end' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		
		if(!empty($swldataod)) {
				if($id_klienta){ 
				$tabela -> update(array('data_swl_start' => $swldataod))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('data_swl_start' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		if(!empty($swldatado)) {
				if($id_klienta){ 
				$tabela -> update(array('data_swl_end' => $swldatado))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('data_swl_end' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		
		if(!empty($zapdataod)) {
				if($id_klienta){ 
				$tabela -> update(array('data_zaplecza' => $zapdataod))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('data_zaplecza' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		if(!empty($zapfala)) {
				if($id_klienta){ 
				$tabela -> update(array('zaplecza_fala' => $zapfala))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('zaplecza_fala' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		
		if(!empty($cslink)) {
				if($id_klienta){ 
				$tabela -> update(array('cs_link' => $cslink))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('cs_link' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		if(!empty($csdata)) {
				if($id_klienta){ 
				$tabela -> update(array('cs_data' => $csdata))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('cs_data' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		if(!empty($optdata)) {
				if($id_klienta){ 
				$tabela -> update(array('opt_data' => $optdata))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('opt_data' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		if(!empty($dostepy_cms)) {
				if($id_klienta){ 
				$tabela -> update(array('dostepy_cms' => $dostepy_cms))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('dostepy_cms' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		if(!empty($opt_meta_data)) {
				if($id_klienta){ 
				$tabela -> update(array('opt_meta_data' => $opt_meta_data))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('opt_meta_data' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		if(!empty($opt_meta)) {
				if($id_klienta){ 
				$tabela -> update(array('opt_meta' => $opt_meta))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('opt_meta' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		if(!empty($host_zly)) {
				if($id_klienta){ 
				$tabela -> update(array('host_zly' => $host_zly))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('host_zly' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		if(!empty($strona_zla)) {
				if($id_klienta){ 
				$tabela -> update(array('strona_zla' => $strona_zla))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('strona_zla' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		if(!empty($strona_popr)) {
				if($id_klienta){ 
				$tabela -> update(array('strona_popr' => $strona_popr))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('strona_popr' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
		
		if(!empty($reczna_filtr)) {
				if($id_klienta){ 
				$tabela -> update(array('reczna_filtr' => $reczna_filtr))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('reczna_filtr' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}
					
	}
}
?>