<?php

    $q = isset($_GET['q']) ? $_GET['q'] : false;
    if(!$q){ echo '0'; exit; }

function curl_get($url, array $get = NULL, array $options = array()){
        //echo $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($get).'<br />';
        $defaults = array(
            CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($get),
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 4
        );
   
        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if(!$result = curl_exec($ch)) trigger_error(curl_error($ch));
        curl_close($ch);
        return $result;
} 


    // http://www.google.pl/search?q=curl+get&lr=lang_pl
    $wynik_0 = curl_get('http://www.google.pl/search', array('hl' => 'pl','num'=>'10', 'q' => $q));
//echo $wynik_0;
    $wynik_2 = explode("Oko³o ", $wynik_0);
	$wynik_3 = explode(" wyników", $wynik_2[1]);
	/* $wynik_5 =count($wynik_3);*/
   
    //$wynik_4 = explode(' ', $wynik_3[0]);
    $wynik_5 = str_replace(',', '', $wynik_3[0]);


    $linki =0;// explode('Linki sponsorowane', $wynik_0);
   // $linki = count($linki) - 1;
    //echo 'Linki sponsorowane: '.$linki.'<br />';

   // $kwota = ($wynik_5 / 1000) * 3 / 15;
    //echo $wynik_5.'<br />';
    //echo 'P1: '.round($kwota).'<br />';
    //echo 'P2: '.round(round($kwota) / 3 * 2).'<br />';
    //echo 'P2: '.round(round($kwota) / 3).'<br />';

    //echo '<hr />';
    $dane = array('liczba_wynikow' => $wynik_5,
                  'linki_sponsorowane' => $linki,
                  'zapytanie' => $q);

    echo json_encode($dane);

?>