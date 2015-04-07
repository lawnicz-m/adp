<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::button(array('value' => '&#171; Powrót',
                        'link' => url::page(CONTROLLER)));

    forms::title(array('title' => !PARAM ? 'Dodaj partnera' : 'Edytuj partnera'));

    forms::open(array('action' => url::page(CONTROLLER.'/zapisz/'.PARAM)));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Login',
                      'name' => 'login',
                      'required' => 1,
                      'value' => $partner['login']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Nazwa (Imię i nazwisko / Firma)',
                      'name' => 'nazwa',
                      'required' => 1,
                      'value' => $partner['nazwa']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'E-mail',
                      'name' => 'mail',
                      'required' => 1,
                      'value' => $partner['mail']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Hasło',
                      'name' => 'haslo',
                      'required' => 1,
                      'value' => $partner['haslo']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Telefon',
                      'name' => 'telefon',
                      'required' => 1,
                      'value' => $partner['telefon']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Adres strony',
                      'name' => 'adres_strony',
                      'value' => $partner['adres_strony']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Data utworzenia',
                      'name' => 'data_utworzenia',
                      'required' => 1,
                      'value' => $partner['data_utworzenia'] ? $partner['data_utworzenia'] : date("Y-m-d")));

    forms::checkbox(array('checked' => $partner['indywidualny'],
                          'fieldClass' => 'widthQuarter',
                          'label' => 'Partner działa samodzielnie (poza firmą)',
                          'name' => 'indywidualny'));
						  
	forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'E-mail Nozbe',
                      'name' => 'mail_nozbe',
                      'required' => 1,
                      'value' => $partner['mail_nozbe']));

    forms::line(0);

    forms::title(array('title' => 'Dane kontaktowe (jeśli partner działa indywidualnie)'));
    ?><table border="0" cellpadding="0" cellspacing="0" style="width: 100%;"><tr><?php
    ?><td style="vertical-align: top; width: 33%;"><h3 style="margin: 0 0 0 5px;">Dane do kontaktu</h3><?php

    forms::text(array('label' => 'Osoba kontaktowa',
                      'name' => 'osoba_kontaktowa',
                      'value' => $partner['osoba_kontaktowa']));

    forms::textarea(array('label' => 'Inne dane kontaktowe',
                          'name' => 'dane_kontaktowe',
                          'value' => $partner['dane_kontaktowe']));

    forms::text(array('label' => 'Osoba reprezentująca (do umowy)',
                      'name' => 'reprezentant',
                      'value' => $partner['reprezentant']));

    ?></td><td style="vertical-align: top; width: 34%;"><h3 style="margin: 0 0 0 5px;">Dane do faktury</h3><?php

    forms::text(array('label' => 'NIP',
                      'name' => 'nip',
                      'value' => $partner['nip']));

    forms::text(array('label' => 'Regon',
                      'name' => 'regon',
                      'value' => $partner['regon']));

    forms::text(array('label' => 'Nazwa',
                      'name' => 'faktura_nazwa',
                      'value' => $partner['faktura_nazwa']));

    forms::text(array('label' => 'Adres',
                      'name' => 'faktura_adres',
                      'value' => $partner['faktura_adres']));

    forms::text(array('label' => 'Kod pocztowy',
                      'name' => 'faktura_kod_pocztowy',
                      'value' => $partner['faktura_kod_pocztowy']));

    forms::text(array('label' => 'Miejscowość',
                      'name' => 'faktura_miejscowosc',
                      'value' => $partner['faktura_miejscowosc']));

    ?></td><td style="vertical-align: top; width: 33%;"><h3 style="margin: 0 0 0 5px;">Korespondencja</h3><div class="clear"></div><div style="height: 107px;"></div><?php

    forms::checkbox(array('checked' => $partner['faktura_papierowa'],
                          'label' => 'Klient wymaga faktury papierowej',
                          'name' => 'faktura_papierowa'));

    forms::text(array('label' => 'Nazwa',
                      'name' => 'korespondencja_nazwa',
                      'value' => $partner['korespondencja_nazwa']));

    forms::text(array('label' => 'Adres',
                      'name' => 'korespondencja_adres',
                      'value' => $partner['korespondencja_adres']));

    forms::text(array('label' => 'Kod pocztowy',
                      'name' => 'korespondencja_kod_pocztowy',
                      'value' => $partner['korespondencja_kod_pocztowy']));

    forms::text(array('label' => 'Miejscowość',
                      'name' => 'korespondencja_miejscowosc',
                      'value' => $partner['korespondencja_miejscowosc']));

    ?></td><?php
    ?></tr></table><?php

    forms::submit(array('keepEditing' => 1));

    forms::close(0);

    $this -> load -> view('footer');
?>