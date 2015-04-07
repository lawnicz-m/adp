<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::title(array('title' => 'Tworzenie wezwania do zapłaty dla '.$klient['nazwa']));

    forms::open(array('action' => url::page(CONTROLLER.'/wezwanie-do-zaplaty/'.PARAM)));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Data wezwania',
                      'name' => 'data_wezwania',
                      'required' => 1,
                      'value' => date("Y-m-d")));

    forms::line(0);

    forms::title(array('title' => 'Zaznacz faktury, których dotyczy wezwanie:'));

    foreach($faktury as $faktura){
        forms::checkbox(array('id' => $faktura['id_faktury'],
                              'label' => texts::numer_faktury($faktura).' z dnia '.texts::nice_date($faktura['data_wystawienia']).'<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kwota brutto: '.$faktura['kwota_brutto'].' zł<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Termin płatności na dzień '.texts::nice_date($faktura['termin_zaplaty']).' minął: '.texts::ile_dni_minelo($faktura['termin_zaplaty'], date("Y-m-d")).' temu',
                              'name' => 'faktury[]',
                              'value' => $faktura['id_faktury']));
    }

    forms::submit(array('label' => 'Wygeneruj wezwanie'));

    forms::close(0);

    $this -> load -> view('footer');
?>