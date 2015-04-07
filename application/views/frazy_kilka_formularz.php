<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::button(array('value' => '&#171; Powrót',
                        'link' => url::page(CONTROLLER.'/wszystkie/'.PARAM)));

    forms::title(array('title' => 'Dodaj wiele fraz'));

    forms::open(array('action' => url::page(CONTROLLER.'/zapisz-kilka/'.PARAM)));

    forms::textarea(array('fieldClass' => 'widthHalf',
                          'name' => 'frazy_top',
                          'label' => 'Frazy TOP 10',
                          'subLabel' => 'Oddzielone przecinkami lub każda w nowej linii, np: telewizor lcd, pralka, odtwarzacz dvd',
                          'value' => isset($frazy_top) ? $frazy_top : ''));

    forms::textarea(array('fieldClass' => 'widthHalf',
                          'name' => 'frazy_ryczalt',
                          'label' => 'Frazy ryczałtowe',
                          'subLabel' => 'Oddzielone przecinkami lub każda w nowej linii, np: telewizor lcd, pralka, odtwarzacz dvd',
                          'value' => isset($frazy_ryczalt) ? $frazy_ryczalt : ''));

    forms::submit(0);

    forms::close(0);

    $this -> load -> view('footer');

?>