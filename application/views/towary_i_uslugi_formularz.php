<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::title(array('title' => !PARAM ? 'Utwórz towar lub usługę' : 'Edytuj towar lub usługę'));

    forms::open(array('action' => url::page(CONTROLLER.'/zapisz/'.PARAM)));

    forms::text(array('fieldClass' => 'width_25',
                      'label' => 'Nazwa',
                      'name' => 'nazwa',
                      'required' => 1,
                      'value' => $towar_lub_usluga['nazwa']));

    forms::text(array('fieldClass' => 'width_25',
                      'label' => 'Jednostka miary',
                      'name' => 'jednostka_miary',
                      'required' => 1,
                      'value' => $towar_lub_usluga['jednostka_miary']));

    forms::text(array('fieldClass' => 'width_25',
                      'label' => 'Numer PKWiU',
                      'name' => 'pkwiu',
                      'required' => 1,
                      'value' => $towar_lub_usluga['pkwiu']));

    forms::text(array('fieldClass' => 'width_25',
                      'label' => 'Stawka VAT',
                      'name' => 'stawka_vat',
                      'required' => 1,
                      'value' => $towar_lub_usluga['stawka_vat']));

    forms::submit(array('keepEditing' => 1));

    forms::close(0);

    $this -> load -> view('footer');
?>