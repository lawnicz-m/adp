<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    $dane_partnera = !PARAM && $uzytkownik['typ'] == 'partner' && $uzytkownik['indywidualny'] ? true : false;

    forms::title(array('title' => !PARAM ? 'Dodaj klienta' : 'Edytuj klienta'));

    forms::open(array('action' => url::page(CONTROLLER.'/zapisz/'.PARAM)));
	forms::submit(array('keepEditing' => 1));
	
    if($uzytkownik['typ'] != 'admin'){
        forms::hidden(array('name' => 'id_partnera',
                            'value' => $klient['id_partnera'] ? $klient['id_partnera'] : $uzytkownik['id']));
		forms::checkbox(array('checked' => $klient['faktury_za_pozycjonowanie'],
                              'fieldClass' => 'widthQuarter',
                              'label' => 'Rozliczaj klienta za pozycjonowanie',
                              'name' => 'faktury_za_pozycjonowanie'));

        forms::line(0);
		forms::hidden(array('name' => 'id_1_partnera',
                            'value' => $klient['id_1_partnera']));
		forms::hidden(array('name' => 'vip',
                            'value' => $klient['vip']));
							
		forms::hidden(array('name' => 'priorytet',
                            'value' => $klient['priorytet']));
		forms::hidden(array('name' => 'kategoria',
                            'value' => $klient['kategoria']));
    }else{
        forms::select(array('data' => $this -> load -> model('partnerzy') -> lista_do_selecta(),
                            'default' => 'Wybierz partnera...',
                            'fieldClass' => 'widthQuarter',
                            'label' => 'Partner klienta',
                            'labels' => 'nazwa',
                            'name' => 'id_partnera',
                            'required' => 1,
                            'value' => $klient['id_partnera'],
                            'values' => 'id_partnera'));
        forms::select(array('data' => $this -> load -> model('pozycjonerzy') -> lista_do_selecta(),
                            'default' => 'Wybierz pozycjonera...',
                            'fieldClass' => 'widthQuarter',
                            'label' => 'Pozycjoner klienta',
                            'labels' => 'nazwa',
                            'name' => 'id_pozycjonera',
                            'required' => 1,
                            'value' => $klient['id_pozycjonera'],
                            'values' => 'id_pozycjonera'));
		if($uzytkownik['id'] == 1)
		{                    
		forms::select(array('data' => $this -> load -> model('partnerzy') -> lista_do_selecta(),
                            'default' => 'Wybierz 1 partnera...',
                            'fieldClass' => 'widthQuarter',
                            'label' => '1 Partner klienta',
                            'labels' => 'nazwa',
                            'name' => 'id_1_partnera',
                            'required' => 1,
                            'value' => $klient['id_1_partnera'],
                            'values' => 'id_partnera'));
		}
		else
		{
		forms::hidden(array('name' => 'id_1_partnera',
                            'value' => $klient['id_1_partnera']));
		}

        forms::checkbox(array('checked' => $klient['faktury_za_pozycjonowanie'],
                              'fieldClass' => 'widthQuarter',
                              'label' => 'Rozliczaj klienta za pozycjonowanie',
                              'name' => 'faktury_za_pozycjonowanie'));

        forms::line(0);
    }

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Nazwa',
                      'name' => 'nazwa',
                      'required' => 1,
                      'value' => $klient['nazwa']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'E-mail',
                      'name' => 'mail',
                      'required' => 1,
                      'value' => $dane_partnera ? $uzytkownik['mail'] : $klient['mail']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Adres strony',
                      'name' => 'adres_strony',
                      'required' => 1,
                      'value' => $klient['adres_strony']));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Inne adresy strony',
                      'name' => 'adres_strony_2',
                      'subLabel' => 'Jeśli istnieją. W formie: wp.pl,onet.pl,interia.pl',
                      'value' => $klient['adres_strony_2']));

    forms::hidden(array('name' => 'data_utworzenia',
                        'value' => $klient['data_utworzenia'] ? $klient['data_utworzenia'] : date("Y-m-d")));

    forms::hidden(array('name' => 'data_pierwszego_kontaktu',
                        'value' => $klient['data_pierwszego_kontaktu'] ? $klient['data_pierwszego_kontaktu'] : date("Y-m-d")));

    forms::text(array('fieldClass' => 'width_20',
                      'label' => 'Data następnego kontaktu',
                      'name' => 'data_nastepnego_kontaktu',
                      'required' => 1,
                      'value' => $klient['data_nastepnego_kontaktu'] ? $klient['data_nastepnego_kontaktu'] : date("Y-m-d")));

    forms::text(array('fieldClass' => 'width_20',
                      'label' => 'Notatka do następnego kontaktu',
                      'name' => 'notatka_do_nastepnego_kontaktu',
                      'required' => 1,
                      'value' => $klient['notatka_do_nastepnego_kontaktu']));
	

    forms::hidden(array('name' => 'data_rozpoczecia_pozycjonowania',
                        'value' => $klient['data_rozpoczecia_pozycjonowania'] ? $klient['data_rozpoczecia_pozycjonowania'] : '0000-00-00'));

    forms::checkbox(array('checked' => $klient['hosting'],
                          'fieldClass' => 'width_15',
                          'label' => 'Umowa na Hosting Strony WWW?',
                          'name' => 'hosting'));
						  
	forms::checkbox(array('checked' => $klient['poczta'],
                          'fieldClass' => 'width_15',
                          'label' => 'Umowa na hosting poczty?',
                          'name' => 'poczta'));
						  
	forms::text(array('fieldClass' => 'width_10',
                          'label' => 'Kwota za hosting/rok',
                          'name' => 'cena_hosting',
						  'value' => $klient['cena_hosting'] ));
	if($uzytkownik['typ'] == 'admin'){
	forms::text(array('fieldClass' => 'width_10',
                          'label' => 'Priorytet',
                          'name' => 'priorytet',
						  'value' => $klient['priorytet'] ));
						  
	forms::select(array('data' => $this -> load -> model('pozycjonerzy') -> lista_do_selecta_kat(),
                            
                            'fieldClass' => 'width_10',
                            'label' => 'Kategoria',
                            'labels' => 'nazwa',
                            'name' => 'kategoria',
                            'value' => $klient['kategoria'],
                            'values' => 'numer_kat'));
	
	
	forms::checkbox(array('checked' => $klient['vip'],
                          'fieldClass' => 'width_10',
                          'label' => 'VIP?',
                          'name' => 'vip'));
	
	forms::checkbox(array('checked' => $klient['nowe_teksty'],
                          'fieldClass' => 'width_10',
                          'label' => 'Umowa z tekstami?',
                          'name' => 'nowe_teksty'));
	
	forms::checkbox(array('checked' => $klient['nowa_strona'],
                          'fieldClass' => 'width_10',
                          'label' => 'Umowa ze stroną?',
                          'name' => 'nowa_strona'));
	
	forms::text(array('fieldClass' => 'width_10',
                          'label' => 'Umowa na ile miesięcy?',
                          'name' => 'okres_umowy',
						  'value' => $klient['okres_umowy'] ));
	}					  
	forms::line(0);

    forms::title(array('title' => 'Dane kontaktowe'));
    ?><table border="0" cellpadding="0" cellspacing="0" style="width: 100%;"><tr><?php
    ?><td style="vertical-align: top; width: 33%;"><h3 style="margin: 0 0 0 5px;">Dane do kontaktu</h3><?php

    forms::text(array('label' => 'Osoba kontaktowa',
                      'name' => 'osoba_kontaktowa',
                      'required' => 1,
                      'value' => $dane_partnera ? $uzytkownik['osoba_kontaktowa'] : $klient['osoba_kontaktowa']));

    forms::text(array('label' => 'Telefon',
                      'name' => 'telefon',
                      'required' => 1,
                      'value' => $dane_partnera ? $uzytkownik['telefon'] : $klient['telefon']));

    forms::textarea(array('label' => 'Inne dane kontaktowe',
                          'name' => 'dane_kontaktowe',
                          'value' => $dane_partnera ? $uzytkownik['dane_kontaktowe'] : $klient['dane_kontaktowe']));
if($uzytkownik['typ'] == 'admin' || $klient['etap'] > 2){
    forms::text(array('label' => 'Osoba reprezentująca (do umowy)',
                      'name' => 'reprezentant',
                      'value' => $dane_partnera ? $uzytkownik['reprezentant'] : $klient['reprezentant']));
	forms::text(array('label' => 'Pesel osoby reprezentującej',
                      'name' => 'pesel',
                      'value' => $klient['pesel']));

    ?></td><td style="vertical-align: top; width: 34%;"><h3 style="margin: 0 0 0 5px;">Dane do faktury</h3><?php

    forms::text(array('label' => 'NIP',
                      'name' => 'nip',
                      'value' => $dane_partnera ? $uzytkownik['nip'] : $klient['nip']));

    forms::text(array('label' => 'Regon',
                      'name' => 'regon',
                      'value' => $dane_partnera ? $uzytkownik['regon'] : $klient['regon']));

    forms::text(array('label' => 'Nazwa',
                      'name' => 'faktura_nazwa',
                      'value' => $dane_partnera ? $uzytkownik['faktura_nazwa'] : $klient['faktura_nazwa']));

    forms::text(array('label' => 'Adres',
                      'name' => 'faktura_adres',
                      'value' => $dane_partnera ? $uzytkownik['faktura_adres'] : $klient['faktura_adres']));

    forms::text(array('label' => 'Kod pocztowy',
                      'name' => 'faktura_kod_pocztowy',
                      'value' => $dane_partnera ? $uzytkownik['faktura_kod_pocztowy'] : $klient['faktura_kod_pocztowy']));

    forms::text(array('label' => 'Miejscowość',
                      'name' => 'faktura_miejscowosc',
                      'value' => $dane_partnera ? $uzytkownik['faktura_miejscowosc'] : $klient['faktura_miejscowosc']));

    ?></td><td style="vertical-align: top; width: 33%;"><h3 style="margin: 0 0 0 5px;">Korespondencja</h3><div class="clear"></div><div style="height: 107px;"></div><?php

    forms::checkbox(array('checked' => $dane_partnera ? $uzytkownik['faktura_papierowa'] : $klient['faktura_papierowa'],
                          'label' => 'Klient wymaga faktury papierowej',
                          'name' => 'faktura_papierowa'));

    forms::text(array('label' => 'Nazwa',
                      'name' => 'korespondencja_nazwa',
                      'value' => $dane_partnera ? $uzytkownik['korespondencja_nazwa'] : $klient['korespondencja_nazwa']));

    forms::text(array('label' => 'Adres',
                      'name' => 'korespondencja_adres',
                      'value' => $dane_partnera ? $uzytkownik['korespondencja_adres'] : $klient['korespondencja_adres']));

    forms::text(array('label' => 'Kod pocztowy',
                      'name' => 'korespondencja_kod_pocztowy',
                      'value' => $dane_partnera ? $uzytkownik['korespondencja_kod_pocztowy'] : $klient['korespondencja_kod_pocztowy']));

    forms::text(array('label' => 'Miejscowość',
                      'name' => 'korespondencja_miejscowosc',
                      'value' => $dane_partnera ? $uzytkownik['korespondencja_miejscowosc'] : $klient['korespondencja_miejscowosc']));

    ?></td><?php
    ?></tr></table><?php

    forms::line(0);

    forms::title(array('title' => 'Typ umowy na pozycjonowanie'));

    forms::checkbox(array('checked' => $klient['umowa_czas_okreslony'],
                          'fieldClass' => 'widthThird',
                          'label' => 'Umowa na czas określony',
                          'name' => 'umowa_czas_okreslony'));

    forms::text(array('fieldClass' => 'widthThird',
                      'label' => 'Data rozpoczęcia',
                      'name' => 'umowa_czas_okreslony_od',
                      'value' => $klient['umowa_czas_okreslony_od']));

    forms::text(array('fieldClass' => 'widthThird',
                      'label' => 'Data zakończenia',
                      'name' => 'umowa_czas_okreslony_do',
                      'value' => $klient['umowa_czas_okreslony_do']));

    forms::title(array('title' => 'Przedziały TOP'));
}

    forms::text(array('fieldClass' => 'width_15',
                      'label' => 'Przedział 1 od',
                      'name' => 'top_10_1_od',
                      
                      'value' => $klient ? $klient['top_10_1_od'] : '1'));

    forms::text(array('fieldClass' => 'width_15',
                      'label' => 'Przedział 1 do',
                      'name' => 'top_10_1_do',
                      
                      'value' => $klient ? $klient['top_10_1_do'] : '3'));

    forms::text(array('fieldClass' => 'width_15',
                      'label' => 'Przedział 2 od',
                      'name' => 'top_10_2_od',
                      
                      'value' => $klient ? $klient['top_10_2_od'] : '4'));

    forms::text(array('fieldClass' => 'width_15',
                      'label' => 'Przedział 2 do',
                      'name' => 'top_10_2_do',
                      
                      'value' => $klient ? $klient['top_10_2_do'] : '6'));

    forms::text(array('fieldClass' => 'width_15',
                      'label' => 'Przedział 3 od',
                      'name' => 'top_10_3_od',
                     
                      'value' => $klient ? $klient['top_10_3_od'] : '7'));

    forms::text(array('fieldClass' => 'width_15',
                      'label' => 'Przedział 3 do',
                      'name' => 'top_10_3_do',
                      
                      'value' => $klient ? $klient['top_10_3_do'] : '10'));
	forms::close(0);

    $this -> load -> view('footer');
?>