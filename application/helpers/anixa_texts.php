<?php

    class texts{

        // CZYTELNY MIESIĄC
        static function czytelny_miesiac($miesiac, $forma = 1){
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
        // ILE DNI MINĘŁO Klienci 
        static function ile_dni_minelo_klienci($date1, $date2){		$killa = ' ';            if($date2 >= $date1) return $killa;

            $diff = abs(strtotime($date2) - strtotime($date1));

            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

            $result = '<span style="color: red;font-size: x-large;">Zapomniany już ';
            if($years > 0){
                $result .= $years.' ';
                if($years == 1) $result .= 'rok ';
                if($years > 1) $result .= 'lata ';
                if($years > 4) $result .= 'lat ';
            }
            if($months > 0){
                $result .= $months.' ';
                if($months == 1) $result .= 'miesiąc ';
                if($months > 1 && $months < 5) $result .= 'miesiące ';
                if($months > 4) $result .= 'miesięcy ';
            }
            if($days > 0){
                $result .= $days.' ';
                if($days == 1) $result .= 'dzień';
                else $result .= 'dni';
            }
            if($days == 0) $result .= ' ';

            $result = str_replace(', 0 dni', '', $result);

            return $result;
        }		// ZA ILE OD DZIS Klienci        static function za_ile_dni_klienci($date1, $date2){		$killa = ' ';            if($date1 > $date2) return $killa;            $diff = abs(strtotime($date2) - strtotime($date1));            $years = floor($diff / (365*60*60*24));            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));            $result = 'Kontakt za ';            if($years > 0){                $result .= $years.' ';                if($years == 1) $result .= 'rok, ';                if($years > 1) $result .= 'lata, ';                if($years > 4) $result .= 'lat, ';            }            if($months > 0){                $result .= $months.' ';                if($months == 1) $result .= 'miesiąc, ';                if($months > 1 && $months < 5) $result .= 'miesiące, ';                if($months > 4) $result .= 'miesięcy, ';            }            if($days > 0){                $result .= $days.' ';                if($days == 1) $result .= 'dzień';                else $result .= 'dni';            }            if($result == 'Kontakt za 1 dzień') $result = '<span style="color: green;font-size: large;">Kontakt jutro';            if($days == 0 && $result == 'Kontakt za ') $result = '<span style="color: green;font-size: x-large;">Kontakt dzisiaj</span>';			            return $result;        }		// ZA ILE OD DZIS        static function za_ile_dni($date1, $date2){            if($date1 > $date2) return $date2;            $diff = abs(strtotime($date2) - strtotime($date1));            $years = floor($diff / (365*60*60*24));            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));            $result = 'Za ';            if($years > 0){                $result .= $years.' ';                if($years == 1) $result .= 'rok, ';                if($years > 1) $result .= 'lata, ';                if($years > 4) $result .= 'lat, ';            }            if($months > 0){                $result .= $months.' ';                if($months == 1) $result .= 'miesiąc, ';                if($months > 1 && $months < 5) $result .= 'miesiące, ';                if($months > 4) $result .= 'miesięcy, ';            }            if($days > 0){                $result .= $days.' ';                if($days == 1) $result .= 'dzień';                else $result .= 'dni';            }            if($result == 'Za 1 dzień') $result = 'Jutro';            if($days == 0 && $result == 'Za ') $result = 'Dzisiaj';            return $result;        }        // ILE DNI MINĘŁO        static function ile_dni_minelo($date1, $date2){            $diff = abs(strtotime($date2) - strtotime($date1));            $years = floor($diff / (365*60*60*24));            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));            $result = '';            if($years > 0){                $result .= $years.' ';                if($years == 1) $result .= 'rok, ';                if($years > 1) $result .= 'lata, ';                if($years > 4) $result .= 'lat, ';            }            if($months > 0){                $result .= $months.' ';                if($months == 1) $result .= 'miesiąc, ';                if($months > 1 && $months < 5) $result .= 'miesiące, ';                if($months > 4) $result .= 'miesięcy, ';            }            if($days > 0){                $result .= $days.' ';                if($days == 1) $result .= 'dzień';                else $result .= 'dni';            }            if($days == 0) $result .= '0 dni';            $result = str_replace(', 0 dni', '', $result);            return $result;        }				
        // NICE DATE
        static function nice_date($a, $form = 0){
            $pre = explode(' ', $a);
            $a = explode('-', $pre[0]);
            $b = self::nice_days($a[2]).' '.self::nice_months($a[1], $form).' '.$a[0];
            return $b;
        }


        // NICE HOUR
        static function nice_hour($a){
            $pre = explode(' ', $a);
            $a = explode(':', $pre[1]);
            $b = $a[0].':'.$a[1];
            return $b;
        }


        // SPLIT DATE
        static function split_date($a){
            $a = explode('-', $a);
            return $a;
        }


        // NICE MONTHS
        static function nice_months($a, $form){
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


        // NICE DAYS
        static function nice_days($a){
            if($a < 10) $a = substr($a, 1, 2);
            return $a;
        }


        // READABLE URL
        static function nice_url($a){
            $a = str_replace('http://', '', $a);
            $a = str_replace('www.', '', $a);

            return $a;
        }


        // CONVERT QUOTES TO FORM INPUT READABLE
        static function convert_quotes($a){
        	$a = str_replace('"','&quot;',$a);
        	return $a;
        }


    	// CUT BREAKS
    	static function nl2br2($f){
    		return preg_replace("/\r\n|\n|\r/", "<br />", $f);
    	}
    	static function nl2br3($f){
    		return preg_replace("/\r\n|\n|\r/", "", $f);
    	}


    	// SHORT TEXT
    	static function short($a, $b){
    		if (strlen($a) > $b){
    			return substr($a, 0, strrpos(substr($a, 0, $b), " ")).'... ';
    		}
    		else{
    			return $a;
    		}
    	}


        // HUMAN READABLE FILE SIZE
        static function readable_file_size($size) {
            $mod = 1024;
            $units = explode(' ','B KB MB GB TB PB');
            for($i = 0; $size > $mod; $i++){
                $size /= $mod;
            }
            return round($size, 2) . '&nbsp;' . $units[$i];
        }

        static function bold_word($a){
            $b = explode(' ', $a);
            $c = '';
            if(count($b) == 1){
                $c = '<b>'.$a.'</b>';
            }else{
                for($i = 0; $i <= count($b) - 1; $i++){
                    if($i == 1) $c .= '<b>';
                    $c .= $b[$i].' ';
                    if($i == 1) $c .= '</b>';
                }
            }
            return $c;
        }

        static function numer_faktury($faktura){
            $data = explode('-', $faktura['data_wystawienia']);
            return ($faktura['proforma'] ? 'PRO/'.$faktura['numer_faktury_proforma'].'/I' : $faktura['numer_faktury']).'/'.$data[1].'/'.$data[0];
        }

    }

?>
