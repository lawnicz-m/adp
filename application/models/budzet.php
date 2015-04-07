<?php

class budzet_model{
	
	public function zapisz($budzet, $koszt, $na_co, $id_klienta){
		$tabela = $this -> db -> table('klienci');
		
		$baza_budzet_arr = $tabela -> select('budzet')
    		                -> where('id_klienta','=',$id_klienta)
    		                -> execute();
		
		$baza_budzet 	= ($baza_budzet_arr[0]["budzet"]);	
		$baza_budzet = intval($baza_budzet);
		$budzet_int = intval($budzet);
		
		if ($baza_budzet != $budzet_int){
			if(!empty($budzet_int)) { 
			if($id_klienta){
				$tabela -> update(array('budzet' => $budzet))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();} }
       	else {
       		if($id_klienta){ 
				$tabela -> update(array('budzet' => NULL))
					-> where('id_klienta','=',$id_klienta)
       	-> execute();}}}
       	
			$dodaj = $koszt."|".$na_co."\r\n";
   
			$filename = "budzet/".$id_klienta.".txt";
			file_put_contents($filename, $dodaj, $flags = FILE_APPEND, $context = null);
			
	}
}
?>