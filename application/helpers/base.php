<?php

    // PUTTING URL LEVELS AS CONSTANTS
    $current_url = explode('/', CURRENT_PAGE);
    $current_controller = isset($current_url[0]) ? $current_url[0] : '';
    $current_action = isset($current_url[1]) ? $current_url[1] : '';
    $current_param = isset($current_url[2]) ? $current_url[2] : 0;
    $current_param_2 = isset($current_url[3]) ? $current_url[3] : 0;
    define('CONTROLLER', $current_controller);
    define('ACTION', $current_action);
    define('PARAM', $current_param);
    define('PARAM_2', $current_param_2);



    class base{

        /* IS LOCAL
        static function is_local(){
            if($_SERVER["REMOTE_ADDR"] == '192.168.2.1' ||
               $_SERVER["REMOTE_ADDR"] == '192.168.1.100' ||
               $_SERVER["REMOTE_ADDR"] == '192.168.1.101' ||
               $_SERVER["REMOTE_ADDR"] == '192.168.2.2' ||
               $_SERVER["REMOTE_ADDR"] == '192.168.2.3' ||
               $_SERVER["REMOTE_ADDR"] == '192.168.2.4' ||
               $_SERVER["REMOTE_ADDR"] == '192.168.2.5' ||
               $_SERVER["REMOTE_ADDR"] == '192.168.2.6' ||
               $_SERVER["REMOTE_ADDR"] == '192.168.2.7' ||
               $_SERVER["REMOTE_ADDR"] == '192.168.2.8' ||
               $_SERVER["REMOTE_ADDR"] == '192.168.2.9' ||
               $_SERVER["REMOTE_ADDR"] == '192.168.2.10' ||
               $_SERVER["REMOTE_ADDR"] == '172.16.27.128' ||
               $_SERVER["REMOTE_ADDR"] == '172.16.27.1' ||
               $_SERVER["REMOTE_ADDR"] == '127.0.0.1' ||
               $_SERVER["REMOTE_ADDR"] == '::1'){
                return true;
            }else{
                return false;
            }
        }*/


        // CHECK FILES
        static function isFileSelected($a){
            if($_FILES[$a]['tmp_name'] == 'none' || $_FILES[$a]['tmp_name'] == '') return false;
            else return true;
        }
        static function isFileSize($a, $b){
            $b = 1048400 * $b;
            if($_FILES[$a]['size'] > $b) return false;
            else return true;
        }
        static function isFileType($a, $b){
            if($_FILES[$a]['type'] != $b) return false;
            else return true;
        }


    	// FILES AND FOLDERS ID
    	static function get_file_number($x){
    		$y = 100;
    		$i = floor($x/$y);
    		return $x - $i*$y;
    	}
    	static function get_folder_number($a){
    		$b = floor($a/100);
    		return $b;
    	}
    	static function check_if_folder_exists($a){
    		if (!is_dir($a)){
    			mkdir($a,0777);
    			chmod($a,0777);
    		}
    	}


        // DELETE DIRECTORY
        static function delete_directory($dir) {
            if (!file_exists($dir)) return true;
            if (!is_dir($dir) || is_link($dir)) return unlink($dir);
                foreach (scandir($dir) as $item) {
                    if ($item == '.' || $item == '..') continue;
                    if (!self::delete_directory($dir . "/" . $item)) {
                        chmod($dir . "/" . $item, 0777);
                        if (!self::delete_directory($dir . "/" . $item)) return false;
                    };
                }
                return rmdir($dir);
        }


        // GET ARRAY KEYS
        static function get_array_keys($ar){
            foreach($ar as $k => $v){
                $keys[] = $k;
                if(is_array($ar[$k]))
                    $keys = array_merge($keys, get_array_keys($ar[$k]));
            }
            return $keys;
        }


        // NAZWA FAKTURY W PDF
        static function nazwa_faktury_pdf($numer, $klient, $typ){
            $a = 'faktura '.$numer.' '.$klient.' '.$typ.'.pdf';
            $a = strtolower($a);
            $a = str_replace('ę', 'e', $a);
            $a = str_replace('ó', 'o', $a);
            $a = str_replace('ą', 'a', $a);
            $a = str_replace('ś', 's', $a);
            $a = str_replace('ł', 'l', $a);
            $a = str_replace('ż', 'z', $a);
            $a = str_replace('ź', 'z', $a);
            $a = str_replace('ć', 'c', $a);
            $a = str_replace('ń', 'n', $a);
            $a = str_replace('/', '-', $a);
            $a = str_replace(' ', '_', $a);

            return $a;
        }

    }
?>