<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::title(array('title' => 'Zmiana hasła'));

    forms::open(array('action' => url::page(CONTROLLER.'/zapisz')));

    forms::text(array('fieldClass' => 'widthThird',
                      'inputType' => 'password',
                      'label' => 'Aktualne hasło',
                      'name' => 'stare_haslo',
                      'required' => 1));

    forms::text(array('fieldClass' => 'widthThird',
                      'inputType' => 'password',
                      'label' => 'Nowe hasło',
                      'name' => 'nowe_haslo',
                      'required' => 1));

    forms::text(array('fieldClass' => 'widthThird',
                      'inputType' => 'password',
                      'label' => 'Powtórz nowe hasło',
                      'name' => 'nowe_haslo_2',
                      'required' => 1));

    forms::submit(array('label' => 'Zmień hasło'));

    forms::close(0);

    $this -> load -> view('footer');
?>