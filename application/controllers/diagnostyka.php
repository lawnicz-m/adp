<?php

    class controller{

    	public function index(){
            $uzytkownik = $this -> load -> model('uzytkownik') -> zalogowany();
            $adres_strony = $this -> input -> post('adres_strony');
            $frazy = $this -> input -> post('frazy');

            if($frazy){
                $frazy = str_replace('<br>', ',', str_replace('<br />', ',', nl2br($frazy)));
                $frazy = explode(',', $frazy);
                $frazy = array_map("trim", $frazy);
                $frazy = array_map("strtolower", $frazy);
            }

            $i = 1;
            $frazy_2 = array();
            if($frazy){
                foreach($frazy as $fraza){
                    $frazy_2[$i]['id_frazy'] = $i;
                    $frazy_2[$i]['nazwa'] = $fraza;
                    $i++;
                }
            }else{
                $frazy_2 = false;
            }

            //print_r($frazy_2);
            //exit;
    		$this -> load -> view('diagnostyka', array('adres_strony' => $adres_strony,
    		                                           'frazy' => $frazy_2,
    		                                           'uzytkownik' => $uzytkownik));
    	}


        public function pobierz_slowa_kluczowe($adres_strony){
            $result = self::getUrlData('http://'.$adres_strony);
            if(isset($result) && isset($result['metaTags']) && isset($result['metaTags']['keywords']) && isset($result['metaTags']['keywords']['value'])){
                $keywords = $result['metaTags']['keywords']['value'];
                $frazy = str_replace('<br>', ',', str_replace('<br />', ',', nl2br($keywords)));
                $frazy = explode(',', $frazy);
                $frazy = array_map("trim", $frazy);
                $frazy = array_map("strtolower", $frazy);
                foreach($frazy as $fraza){
                    echo $fraza."\n";
                }
            }
            //echo '<pre>';
            //print_r($result);
        }

        public function getUrlData($url)
        {
            $result = false;
   
            $contents = self::getUrlContents($url);

            if (isset($contents) && is_string($contents))
            {
                $title = null;
                $metaTags = null;
       
                preg_match('/<title>([^>]*)<\/title>/si', $contents, $match );

                if (isset($match) && is_array($match) && count($match) > 0)
                {
                    $title = strip_tags($match[1]);
                }
       
                preg_match_all('/<[\s]*meta[\s]*name="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);
                //preg_match_all('/<[\s]*meta[\s]*content="?([^>"]*)"?[\s]*[\/]?[\s]*' . 'name="?([^>"]*)"?[\s]*>/si', $contents, $match);
                                                     //name="?([^>"]*)"?[\s]
                                                     //content="?([^>"]*)"?[\s]*[\/]?[\s]
                if (isset($match) && is_array($match) && count($match) == 3)
                {
                    $originals = $match[0];
                    $names = $match[1];
                    $values = $match[2];
           
                    if (count($originals) == count($names) && count($names) == count($values))
                    {
                        $metaTags = array();
               
                        for ($i=0, $limiti=count($names); $i < $limiti; $i++)
                        {
                            $metaTags[$names[$i]] = array (
                                'html' => htmlentities($originals[$i]),
                                'value' => $values[$i]
                            );
                        }
                    }
                }
       
                $result = array (
                    'title' => $title,
                    'metaTags' => $metaTags
                );
            }
   
            return $result;
        }

        public function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0)
        {
            $result = false;
   
            $contents = @file_get_contents($url);
   
            // Check if we need to go somewhere else
   
            if (isset($contents) && is_string($contents))
            {
                preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);
       
                if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1)
                {
                    if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections)
                    {
                        return self::getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
                    }
           
                    $result = false;
                }
                else
                {
                    $result = $contents;
                }
            }
   
            return $contents;
        }

    }

?>