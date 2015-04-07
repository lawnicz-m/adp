<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::title(array('title' => 'Powiązania klienta'));

    forms::open(array('action' => url::page(CONTROLLER.'/zapisz-powiazania/'.PARAM)));

    forms::select(array('data' => $this -> load -> model('pozycjonerzy') -> lista_do_selecta(),
                        'fieldClass' => 'widthQuarter',
                        'label' => 'Pozycjoner',
                        'labels' => 'nazwa',
                        'name' => 'id_pozycjonera',
                        'required' => 1,
                        'value' => $klient['id_pozycjonera'],
                        'values' => 'id_pozycjonera'));

    forms::submit(array('keepEditing' => 1));

    forms::close(0);

    $this -> load -> view('footer');
?>