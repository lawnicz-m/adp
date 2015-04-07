<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::button(array('value' => '&#171; Powrót do listy partnerów',
                        'link' => url::page('partnerzy')));

    forms::title(array('title' => 'Prowizja partnera'));

    forms::open(array('action' => url::page(CONTROLLER.'/zapisz-prowizje/'.PARAM)));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Prowizja bazowa [w %]',
                      'name' => 'prowizja_partnera',
                      'required' => 1,
                      'value' => $partner['prowizja_partnera']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Kwota graniczna [w zł]',
                      'name' => 'prowizja_partnera_prog',
                      'required' => 1,
                      'value' => $partner['prowizja_partnera_prog']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Prowizja za klientów pośredników [w %]',
                      'name' => 'prowizja_partnera_polecajacego',
                      'required' => 1,
                      'value' => $partner['prowizja_partnera_polecajacego']));

    forms::submit(array('keepEditing' => 1));

    forms::close(0);

    $this -> load -> view('footer');
?>