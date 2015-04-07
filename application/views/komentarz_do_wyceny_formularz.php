<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::button(array('value' => '&#171; Powrót',
                        'link' => url::page(CONTROLLER.'/wszystkie/'.PARAM)));

    forms::title(array('title' => 'Komentarz do wyceny'));

    forms::open(array('action' => url::page(CONTROLLER.'/zapisz_komentarz_do_wyceny/'.PARAM)));

    forms::textarea(array('label' => 'Treść',
                          'name' => 'komentarz_do_wyceny',
                          'value' => $klient['komentarz_do_wyceny']));

    forms::submit(array('keepEditing' => 1));

    forms::close(0);

    $this -> load -> view('footer');
?>