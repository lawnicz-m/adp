<?php

class validate{

    // IS VALID E-MAIL
    static function e_mail($email){
    	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email);
    }


    // IS VALID LOGIN
    static function login($login){
    	return eregi("^([a-z0-9.]{3,20})$", $login);
    }


    // PASSWORD
    static function password($password){
    	return eregi("^([_A-Za-z0-9-]{4,20})$", $password);
    }


    // IS VALID URL
    static function isValidUrl($url){
        $regex = "^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|localhost|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$";
        return eregi($regex, $url);
    }


    // IS PAGE URL VALID
    static function page_url($url){
    	return eregi("^([_a-z/0-9-]{1,250})$", $url);
    }


    // IS NIP VALID
	static function isValidNIP($nip){
		$wagi = array(6, 5, 7, 2, 3, 4, 5, 6, 7);
		if(strlen($nip) != 10){
			return 0;
		}
		// tworzenie sumy iloczynów
		$suma_calosc = 0;
		for($x = 0; $x < 9; $x++)
		$suma_calosc += $wagi[$x] * $nip[$x];
		$sum_m = $suma_calosc % 11;
		if($sum_m == 10) $sum_m = 0;
		if($sum_m == $nip[9]) return 1;
		return 0;
	}


}

?>