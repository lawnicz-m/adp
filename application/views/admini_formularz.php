<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::button(array('value' => '&#171; Powrót',
                        'link' => url::page(CONTROLLER)));

    forms::title(array('title' => !PARAM ? 'Dodaj admina' : 'Edytuj admina'));

    forms::open(array('action' => url::page(CONTROLLER.'/zapisz/'.PARAM)));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Login',
                      'name' => 'login',
                      'required' => 1,
                      'value' => $admin['login']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Imię i nazwisko',
                      'name' => 'nazwa',
                      'required' => 1,
                      'value' => $admin['nazwa']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'E-mail',
                      'name' => 'mail',
                      'required' => 1,
                      'value' => $admin['mail']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Hasło',
                      'name' => 'haslo',
                      'required' => 1,
                      'value' => $admin['haslo']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Data utworzenia',
                      'name' => 'data_utworzenia',
                      'required' => 1,
                      'value' => $admin['data_utworzenia'] ? $admin['data_utworzenia'] : date("Y-m-d")));

    forms::submit(array('keepEditing' => 1));

    forms::close(0);

    $this -> load -> view('footer');
?>