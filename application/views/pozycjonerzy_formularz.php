<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::button(array('value' => '&#171; Powrót',
                        'link' => url::page(CONTROLLER)));

    forms::title(array('title' => !PARAM ? 'Dodaj pozycjonera' : 'Edytuj pozycjonera'));

    forms::open(array('action' => url::page(CONTROLLER.'/zapisz/'.PARAM)));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Login',
                      'name' => 'login',
                      'required' => 1,
                      'value' => $pozycjoner['login']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Nazwa (Imię i nazwisko / Firma)',
                      'name' => 'nazwa',
                      'required' => 1,
                      'value' => $pozycjoner['nazwa']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'E-mail',
                      'name' => 'mail',
                      'required' => 1,
                      'value' => $pozycjoner['mail']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Hasło',
                      'name' => 'haslo',
                      'required' => 1,
                      'value' => $pozycjoner['haslo']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Data utworzenia',
                      'name' => 'data_utworzenia',
                      'required' => 1,
                      'value' => $pozycjoner['data_utworzenia'] ? $pozycjoner['data_utworzenia'] : date("Y-m-d")));

    forms::submit(array('keepEditing' => 1));

    forms::close(0);

    $this -> load -> view('footer');
?>