<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::title(array('title' => 'Potwierdzenie usunięcia klienta '.$klient['nazwa']));

    forms::info(array('value' => '<b>Powód usunięcia:</b><br />'.$klient['powod_usuniecia']));

    if(!$pozwolenie_na_usuniecie) forms::info(array('value' => '<b style="color: red;">Nie można usunąć klienta, ponieważ ma on już wystawioną fakturę VAT i system musi utrzymać jego dane dla celów statystycznych.</b>'));

    forms::line(0);

    if($pozwolenie_na_usuniecie){
        forms::button(array('value' => 'Usuń klienta',
                            'style' => 'float: left;',
                            'link' => url::page(CONTROLLER.'/zatwierdz-usuniecie-klienta/'.PARAM)));
    }

    forms::button(array('value' => 'Anuluj prośbę o usunięcie',
                        'style' => 'float: left;',
                        'link' => url::page(CONTROLLER.'/anuluj-prosbe-o-usuniecie/'.PARAM)));

    $this -> load -> view('footer');
?>