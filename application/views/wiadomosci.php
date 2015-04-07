<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::button(array('value' => 'Wyślij',
                        'link' => url::page(CONTROLLER.'/napisz')));

    forms::button(array('value' => 'Niewykonane ('.$statystyka[PARAM]['niewykonane'].')',
                        'link' => url::page(CONTROLLER.'/index/'.PARAM.'/niewykonane')));

    forms::button(array('value' => 'Wykonane ('.$statystyka[PARAM]['wykonane'].')',
                        'link' => url::page(CONTROLLER.'/index/'.PARAM.'/wykonane')));

    forms::button(array('value' => 'Nieprzeczytane ('.$statystyka[PARAM]['nieprzeczytane'].')',
                        'link' => url::page(CONTROLLER.'/index/'.PARAM.'/nieprzeczytane')));

    forms::title(array('title' => $status.' ('.($wiadomosci ? count($wiadomosci) : 0).')'));

    forms::itemsOpen(0);

    if($wiadomosci){
        foreach($wiadomosci as $wiadomosc){
            $actions = array();

            $actions[] = array('class' => 'noCover',
                               'icon' => url::page('inc/cms/img/crystalClear/35/edit.gif'),
                               'label' => 'Odczytaj',
                               'link' => url::page(CONTROLLER.'/odczytaj/'.$wiadomosc['id_wiadomosci']));

            forms::item(array('actions' => $actions,
                              'icon' => 'mail',
                              'id' => 1,
                              'subTitle' => 'Od: '.$wiadomosc['nazwa_nadawcy'].' ('.$wiadomosc['typ_nadawcy'].')<br />Do: '.$wiadomosc['nazwa_odbiorcy'].' ('.$wiadomosc['typ_odbiorcy'].')<br />Dnia: '.$wiadomosc['data_wyslania'],
                              'title' => $wiadomosc['tytul']));
        }
    }

    forms::itemsClose(0);

    $this -> load -> view('footer');
?>