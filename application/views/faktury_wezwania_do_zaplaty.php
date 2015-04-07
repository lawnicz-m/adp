<?php
if($uzytkownik['typ'] == 'admin' && $uzytkownik['id'] == '1' || $uzytkownik['id'] == '9'){
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::title(array('title' => 'Wezwania do zapłaty'));

    forms::itemsOpen(0);

    if($wezwania){
        foreach($wezwania as $wezwanie){

            $actions = array();

            /*
            $actions[] = array('icon' => url::page('inc/cms/img/crystalClear/35/edit.gif'),
                               'label' => 'Edytuj',
                               'link' => url::page(CONTROLLER.'/form/'.$wezwanie['id_wezwania']));
            */
            $actions[] = array('icon' => url::page('inc/cms/img/crystalClear/35/pdf.gif'),
                               'label' => 'Pobierz PDF',
                               'link' => url::page(CONTROLLER.'/pobierz-wezwanie-do-zaplaty/'.$wezwanie['id_wezwania']),
                               'rel' => 'external');

            $actions[] = array('icon' => url::page('inc/cms/img/crystalClear/35/delete.gif'),
                               'label' => 'Usuń',
                               'link' => url::page(CONTROLLER.'/usun-wezwanie-do-zaplaty/'.$wezwanie['id_wezwania']),
                               'rel' => 'potwierdzenie');

            forms::item(array('actions' => $actions,
                              'icon' => 'document',
                              'id' => $wezwanie['id_wezwania'],
                              'subTitle' => 'Dla klienta: '.$wezwanie['adresat_nazwa'].' &nbsp;&bull;&nbsp; Data wezwania: '.texts::nice_date($wezwanie['data_wezwania']).'  &nbsp;&bull;&nbsp; Kwota do zapłaty: '.number_format($wezwanie['pozostala_kwota'], 2, '.', ' ').' zł',
                              'title' => 'Dla '.$wezwanie['adresat_nazwa'].' z dnia '.texts::nice_date($wezwanie['data_wezwania'])));
        }
    }

    forms::itemsClose(0);

    $this -> load -> view('footer');
}
?>