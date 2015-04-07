<?php

    function czytelny_miesiac($miesiac, $forma = 1){
        $miesiac = explode('-', $miesiac);
        $miesiac = $miesiac[1].'-'.$miesiac[0];
        if($forma == 1){
            $miesiac = str_replace('01-', 'styczniu ', $miesiac);
            $miesiac = str_replace('02-', 'lutym ', $miesiac);
            $miesiac = str_replace('03-', 'marcu ', $miesiac);
            $miesiac = str_replace('04-', 'kwietniu ', $miesiac);
            $miesiac = str_replace('05-', 'maju ', $miesiac);
            $miesiac = str_replace('06-', 'czerwcu ', $miesiac);
            $miesiac = str_replace('07-', 'lipcu ', $miesiac);
            $miesiac = str_replace('08-', 'sierpniu ', $miesiac);
            $miesiac = str_replace('09-', 'wrześniu ', $miesiac);
            $miesiac = str_replace('10-', 'październiku ', $miesiac);
            $miesiac = str_replace('11-', 'listopadzie ', $miesiac);
            $miesiac = str_replace('12-', 'grudniu ', $miesiac);
        }else if($forma == 2){
            $miesiac = str_replace('01-', 'styczeń ', $miesiac);
            $miesiac = str_replace('02-', 'luty ', $miesiac);
            $miesiac = str_replace('03-', 'marzec ', $miesiac);
            $miesiac = str_replace('04-', 'kwiecień ', $miesiac);
            $miesiac = str_replace('05-', 'maj ', $miesiac);
            $miesiac = str_replace('06-', 'czerwiec ', $miesiac);
            $miesiac = str_replace('07-', 'lipiec ', $miesiac);
            $miesiac = str_replace('08-', 'sierpień ', $miesiac);
            $miesiac = str_replace('09-', 'wrzesień ', $miesiac);
            $miesiac = str_replace('10-', 'październik ', $miesiac);
            $miesiac = str_replace('11-', 'listopad ', $miesiac);
            $miesiac = str_replace('12-', 'grudzień ', $miesiac);
        }
        return $miesiac;
    }

    function czytelny_miesiac_2($a, $form){
        $months = Array();
        if($form == 1){
            $months['01'] = 'styczeń';
            $months['02'] = 'luty';
            $months['03'] = 'marzec';
            $months['04'] = 'kwiecień';
            $months['05'] = 'maj';
            $months['06'] = 'czerwiec';
            $months['07'] = 'lipiec';
            $months['08'] = 'sierpień';
            $months['09'] = 'wrzesień';
            $months['10'] = 'październik';
            $months['11'] = 'listopad';    
            $months['12'] = 'grudzień';
        }else{
            $months['01'] = 'stycznia';
            $months['02'] = 'lutego';
            $months['03'] = 'marca';
            $months['04'] = 'kwietnia';
            $months['05'] = 'maja';
            $months['06'] = 'czerwca';
            $months['07'] = 'lipca';
            $months['08'] = 'sierpnia';
            $months['09'] = 'września';
            $months['10'] = 'października';
            $months['11'] = 'listopada';    
            $months['12'] = 'grudnia';
        }
        return $a != '00' ? $months[$a] : '';
    }

    function czytelny_dzien($a){
        if($a < 10) $a = substr($a, 1, 2);
        return $a;
    }

    function czytelna_data($a, $form = 0){
        $pre = explode(' ', $a);
        $a = explode('-', $pre[0]);
        $b = czytelny_dzien($a[2]).' '.czytelny_miesiac_2($a[1], $form).' '.$a[0];
        return $b;
    }

    function pobierz_dane($url){
        $wynik = array('status' => 0, 'dane' => 'Nieokreślony błąd');

        if(!($zapytanie = file($url))){
            $wynik['dane'] = 'Problem z nawiązaniem połączenia z bazą danych';
        }else if(!isset($zapytanie[0])){
            $wynik['dane'] = 'Problem z odbiorem danych';
        }else{
            $zapytanie = json_decode($zapytanie[0], true);
            if(isset($zapytanie['status'])){
                if($zapytanie['status'] == 1){
                    $wynik = $zapytanie;
                }else{
                    $wynik['dane'] = $zapytanie['dane'];
                }
            }else{
                $wynik['dane'] = 'Problem z formatem danych';
            }
        }

        return $wynik;
    }

?>