<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));
    $tabela = $this -> db -> table('klienci');
    $id_klienta = $klient['id_klienta'];
    $baza_umowa_arr = $tabela -> select('umowa_czas_okreslony_od')
    		                -> where('id_klienta','=',$id_klienta)
    		                -> execute();
    
    $baza_umowa 	= ($baza_umowa_arr[0]["umowa_czas_okreslony_od"]);
    $data = explode("-", $baza_umowa); 
    $umowa_rok = $data[0];

    forms::title(array('title' => 'Dokumenty'));

    forms::itemsOpen(0);

    // WYCENA
    $actions = array();

    $nazwa_pliku = 'Wycena pozycjonowania strony '.$klient['adres_strony'];

    $actions[] = array('class' => 'noCover',
                       'icon' => url::page('inc/cms/img/crystalClear/35/edit.gif'),
                       'label' => 'Uwagi do umowy',
                       'link' => url::page('dokumenty/komentarz_do_wyceny/'.$klient['id_klienta']));

    $actions[] = array('class' => 'noCover',
                       'icon' => url::page('inc/cms/img/crystalClear/35/pdf.gif'),
                       'label' => 'Pobierz PDF',
                       'link' => url::page('pdf/generuj'.($uzytkownik['typ'] == 'partner' && $uzytkownik['indywidualny'] ? '2' : '').'.php?input_file='.url::page('dokumenty/wycena/' . $klient['hash']) . '&amp;output_file='.rawurlencode($nazwa_pliku).'.pdf'),
                       'rel' => 'external');

    forms::item(array('actions' => $actions,
                      'icon' => 'arrow',
                      'id' => 1,
                      'title' => $nazwa_pliku));

    // UMOWA
    $actions = array();

    $nazwa_pliku = 'Umowa na pozycjonowanie strony '.$klient['adres_strony'];

    $actions[] = array('class' => 'noCover',
                       'icon' => url::page('inc/cms/img/crystalClear/35/pdf.gif'),
                       'label' => 'Pobierz PDF',
                       'link' => url::page('pdf/generuj.php?input_file='.url::page('dokumenty/umowa/' . $klient['hash']) . '&amp;output_file=' . rawurlencode($nazwa_pliku).'.pdf').'&amp;footer_text=Umowa nr 1/P/'.$klient['id_klienta'].'/'.date("Y"),
                       'rel' => 'external');

    forms::item(array('actions' => $actions,
                      'icon' => 'arrow',
                      'id' => 1,
                      'title' => $nazwa_pliku));

    // ZAŁĄCZNIK DO UMOWY
    $actions = array();

    $nazwa_pliku = 'Zalacznik do umowy do strony '.$klient['adres_strony'];

    $actions[] = array('class' => 'noCover',
                       'icon' => url::page('inc/cms/img/crystalClear/35/pdf.gif'),
                       'label' => 'Pobierz PDF',
                       'link' => url::page('pdf/generuj.php?input_file='.url::page('dokumenty/wycena/' . $klient['hash'].'/1') . '&amp;output_file='.rawurlencode($nazwa_pliku).'.pdf').'&amp;footer_text=Załącznik do umowy nr 1/P/'.$klient['id_klienta'].'/'.$umowa_rok,
                       'rel' => 'external');

    forms::item(array('actions' => $actions,
                      'icon' => 'arrow',
                      'id' => 1,
                      'title' => $nazwa_pliku));
	
	// Cesja
    $actions = array();

    $nazwa_pliku = 'Cesja umowy dla '.$klient['adres_strony'];

    $actions[] = array('class' => 'noCover',
                       'icon' => url::page('inc/cms/img/crystalClear/35/pdf.gif'),
                       'label' => 'Pobierz PDF',
                       'link' => url::page('pdf/generuj.php?input_file='.url::page('dokumenty/cesja/' . $klient['hash'].'/1') . '&amp;output_file='.rawurlencode($nazwa_pliku).'.pdf').'&amp;footer_text=Cesja umowy nr 1/P/'.$klient['id_klienta'].'/'.$umowa_rok,
                       'rel' => 'external');

    forms::item(array('actions' => $actions,
                      'icon' => 'arrow',
                      'id' => 1,
                      'title' => $nazwa_pliku));
	
	// Umowa na hosting
    $actions = array();

    $nazwa_pliku = 'Umowy hosting dla '.$klient['adres_strony'];

    $actions[] = array('class' => 'noCover',
                       'icon' => url::page('inc/cms/img/crystalClear/35/pdf.gif'),
                       'label' => 'Pobierz PDF',
                       'link' => url::page('pdf/generuj.php?input_file='.url::page('dokumenty/umowahosting/' . $klient['hash'].'/1') . '&amp;output_file='.rawurlencode($nazwa_pliku).'.pdf').'&amp;footer_text=Umowy na hosting nr 1/H/'.$klient['id_klienta'].'/'.$umowa_rok,
                       'rel' => 'external');

    forms::item(array('actions' => $actions,
                      'icon' => 'arrow',
                      'id' => 1,
                      'title' => $nazwa_pliku));


    forms::itemsClose(0);

    $this -> load -> view('footer');
?>