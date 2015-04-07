<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::title(array('title' => 'Nowa wiadomość'));

    forms::open(array('action' => url::page(CONTROLLER.'/wyslij')));

    forms::select(array('data' => $odbiorcy,
                        'label' => 'Odbiorca',
                        'labels' => 'nazwa',
                        'name' => 'id_odbiorcy',
                        'required' => 1,
                        'value' => $wiadomosc['id_odbiorcy'],
                        'values' => isset($odbiorcy[0]['id_admina']) ? 'id_admina' : 'id_partnera'));

    forms::text(array('label' => 'Tytuł',
                      'name' => 'tytul',
                      'required' => 1,
                      'value' => $wiadomosc['tytul']));

    forms::textarea(array('name' => 'tresc',
                          'label' => 'Treść',
                          'required' => 1,
                          'value' => $wiadomosc['tresc']));

    forms::submit(array('label' => 'Wyślij'));

    forms::close(0);

    $this -> load -> view('footer');
?>