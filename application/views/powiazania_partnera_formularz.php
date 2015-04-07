<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::button(array('value' => '&#171; Powrót do listy partnerów',
                        'link' => url::page('partnerzy')));

    forms::title(array('title' => 'Powiązania partnera'));

    forms::open(array('action' => url::page(CONTROLLER.'/zapisz-powiazania/'.PARAM)));

    forms::select(array('data' => $this -> load -> model('partnerzy') -> lista_do_selecta(PARAM),
                        'default' => 'Brak partnera polecającego',
                        'fieldClass' => 'widthQuarter',
                        'label' => 'Partner polecający',
                        'labels' => 'nazwa',
                        'name' => 'id_partnera_polecajacego',
                        'required' => 1,
                        'value' => $partner['id_partnera_polecajacego'],
                        'values' => 'id_partnera'));

    forms::submit(array('keepEditing' => 1));

    forms::close(0);

    $this -> load -> view('footer');
?>