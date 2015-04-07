<?php
    /*
        [1] Oferta
        [2] Wycena
        [3] Akceptacja
        [4] Oczekiwanie na rozpoczęcie pozycjonowania
        [5] Pozycjonowanie
    */

    // ACL rules
    $acl_frazy = $this -> acl -> create('acl_frazy');

    $acl_frazy -> role('admin');
    $acl_frazy -> role('pozycjoner');
    $acl_frazy -> role('partner');

    // FRAZY
    $acl_frazy -> resource('dodaj_fraze_etap_1');
    $acl_frazy -> allow('admin','dodaj_fraze_etap_1');
    $acl_frazy -> allow('pozycjoner','dodaj_fraze_etap_1');
    $acl_frazy -> allow('partner','dodaj_fraze_etap_1');

    $acl_frazy -> resource('dodaj_fraze_etap_2');
    $acl_frazy -> allow('admin','dodaj_fraze_etap_2');
    $acl_frazy -> allow('pozycjoner','dodaj_fraze_etap_2');
    $acl_frazy -> allow('partner','dodaj_fraze_etap_2');

    $acl_frazy -> resource('dodaj_fraze_etap_3');
    $acl_frazy -> allow('admin','dodaj_fraze_etap_3');
    $acl_frazy -> allow('pozycjoner','dodaj_fraze_etap_3');
    $acl_frazy -> allow('partner','dodaj_fraze_etap_3');

    $acl_frazy -> resource('dodaj_fraze_etap_4');
    $acl_frazy -> allow('admin','dodaj_fraze_etap_4');
    $acl_frazy -> allow('pozycjoner','dodaj_fraze_etap_4');
    $acl_frazy -> allow('partner','dodaj_fraze_etap_4');

    $acl_frazy -> resource('dodaj_fraze_etap_5');
    $acl_frazy -> allow('admin','dodaj_fraze_etap_5');
    $acl_frazy -> allow('pozycjoner','dodaj_fraze_etap_5');
    $acl_frazy -> allow('partner','dodaj_fraze_etap_5');

    $acl_frazy -> resource('dodaj_fraze_etap_6');
    $acl_frazy -> allow('admin','dodaj_fraze_etap_6');
    $acl_frazy -> allow('pozycjoner','dodaj_fraze_etap_6');
    $acl_frazy -> allow('partner','dodaj_fraze_etap_6');
	
	$acl_frazy -> resource('dodaj_fraze_etap_7');
    $acl_frazy -> allow('admin','dodaj_fraze_etap_7');
    $acl_frazy -> allow('pozycjoner','dodaj_fraze_etap_7');
    $acl_frazy -> allow('partner','dodaj_fraze_etap_7');
	
	$acl_frazy -> resource('dodaj_fraze_etap_8');
    $acl_frazy -> allow('admin','dodaj_fraze_etap_8');
    $acl_frazy -> allow('pozycjoner','dodaj_fraze_etap_8');
    $acl_frazy -> allow('partner','dodaj_fraze_etap_8');

    // edytuj frazę
    $acl_frazy -> resource('edytuj_fraze_etap_1');
    $acl_frazy -> allow('admin','edytuj_fraze_etap_1');
    $acl_frazy -> allow('pozycjoner','edytuj_fraze_etap_1');
    $acl_frazy -> allow('partner','edytuj_fraze_etap_1');

    $acl_frazy -> resource('edytuj_fraze_etap_2');
    $acl_frazy -> allow('admin','edytuj_fraze_etap_2');
    $acl_frazy -> allow('pozycjoner','edytuj_fraze_etap_2');
    $acl_frazy -> allow('partner','edytuj_fraze_etap_2');

    $acl_frazy -> resource('edytuj_fraze_etap_3');
    $acl_frazy -> allow('admin','edytuj_fraze_etap_3');
    $acl_frazy -> allow('pozycjoner','edytuj_fraze_etap_3');
    $acl_frazy -> allow('partner','edytuj_fraze_etap_3');

    $acl_frazy -> resource('edytuj_fraze_etap_4');
    $acl_frazy -> allow('admin','edytuj_fraze_etap_4');
    $acl_frazy -> allow('pozycjoner','edytuj_fraze_etap_4');
    $acl_frazy -> allow('partner','edytuj_fraze_etap_4');

    $acl_frazy -> resource('edytuj_fraze_etap_5');
    $acl_frazy -> allow('admin','edytuj_fraze_etap_5');
    $acl_frazy -> allow('pozycjoner','edytuj_fraze_etap_5');
    $acl_frazy -> allow('partner','edytuj_fraze_etap_5');

    $acl_frazy -> resource('edytuj_fraze_etap_6');
    $acl_frazy -> allow('admin','edytuj_fraze_etap_6');
    $acl_frazy -> allow('pozycjoner','edytuj_fraze_etap_6');
    $acl_frazy -> allow('partner','edytuj_fraze_etap_6');
	
	$acl_frazy -> resource('edytuj_fraze_etap_8');
    $acl_frazy -> allow('admin','edytuj_fraze_etap_8');
    $acl_frazy -> allow('pozycjoner','edytuj_fraze_etap_8');
    $acl_frazy -> allow('partner','edytuj_fraze_etap_8');

    // usun frazę
    $acl_frazy -> resource('usun_fraze_etap_1');
    $acl_frazy -> allow('admin','usun_fraze_etap_1');
    $acl_frazy -> allow('pozycjoner','usun_fraze_etap_1');
    $acl_frazy -> allow('partner','usun_fraze_etap_1');

    $acl_frazy -> resource('usun_fraze_etap_2');
    $acl_frazy -> allow('admin','usun_fraze_etap_2');
    $acl_frazy -> allow('pozycjoner','usun_fraze_etap_2');
    $acl_frazy -> allow('partner','usun_fraze_etap_2');

    $acl_frazy -> resource('usun_fraze_etap_3');
    $acl_frazy -> allow('admin','usun_fraze_etap_3');
    $acl_frazy -> allow('pozycjoner','usun_fraze_etap_3');
    $acl_frazy -> allow('partner','usun_fraze_etap_3');

    $acl_frazy -> resource('usun_fraze_etap_4');
    $acl_frazy -> allow('admin','usun_fraze_etap_4');
    $acl_frazy -> allow('pozycjoner','usun_fraze_etap_4');
    $acl_frazy -> allow('partner','usun_fraze_etap_4');

    $acl_frazy -> resource('usun_fraze_etap_5');
    $acl_frazy -> allow('admin','usun_fraze_etap_5');
    $acl_frazy -> allow('pozycjoner','usun_fraze_etap_5');
    $acl_frazy -> allow('partner','usun_fraze_etap_5');

    $acl_frazy -> resource('usun_fraze_etap_6');
    $acl_frazy -> allow('admin','usun_fraze_etap_6');
    $acl_frazy -> allow('pozycjoner','usun_fraze_etap_6');
    $acl_frazy -> allow('partner','usun_fraze_etap_6');
	
	$acl_frazy -> resource('usun_fraze_etap_7');
    $acl_frazy -> allow('admin','usun_fraze_etap_7');
    $acl_frazy -> allow('pozycjoner','usun_fraze_etap_7');
    $acl_frazy -> allow('partner','usun_fraze_etap_7');
	
	$acl_frazy -> resource('usun_fraze_etap_8');
    $acl_frazy -> allow('admin','usun_fraze_etap_8');
    $acl_frazy -> allow('pozycjoner','usun_fraze_etap_8');
    $acl_frazy -> allow('partner','usun_fraze_etap_8');

    // skasuj wycenę
    $acl_frazy -> resource('skasuj_wycene_etap_1');
    $acl_frazy -> deny('admin','skasuj_wycene_etap_1');
    $acl_frazy -> deny('pozycjoner','skasuj_wycene_etap_1');
    $acl_frazy -> deny('partner','skasuj_wycene_etap_1');

    $acl_frazy -> resource('skasuj_wycene_etap_2');
    $acl_frazy -> deny('admin','skasuj_wycene_etap_2');
    $acl_frazy -> deny('pozycjoner','skasuj_wycene_etap_2');
    $acl_frazy -> deny('partner','skasuj_wycene_etap_2');

    $acl_frazy -> resource('skasuj_wycene_etap_3');
    $acl_frazy -> deny('admin','skasuj_wycene_etap_3');
    $acl_frazy -> deny('pozycjoner','skasuj_wycene_etap_3');
    $acl_frazy -> deny('partner','skasuj_wycene_etap_3');

    $acl_frazy -> resource('skasuj_wycene_etap_4');
    $acl_frazy -> deny('admin','skasuj_wycene_etap_4');
    $acl_frazy -> deny('pozycjoner','skasuj_wycene_etap_4');
    $acl_frazy -> deny('partner','skasuj_wycene_etap_4');

    $acl_frazy -> resource('skasuj_wycene_etap_5');
    $acl_frazy -> deny('admin','skasuj_wycene_etap_5');
    $acl_frazy -> deny('pozycjoner','skasuj_wycene_etap_5');
    $acl_frazy -> deny('partner','skasuj_wycene_etap_5');

    $acl_frazy -> resource('skasuj_wycene_etap_6');
    $acl_frazy -> deny('admin','skasuj_wycene_etap_6');
    $acl_frazy -> deny('pozycjoner','skasuj_wycene_etap_6');
    $acl_frazy -> deny('partner','skasuj_wycene_etap_6');

    // anuluj prośbę o wycenę z 2 na 1
    $acl_frazy -> resource('anuluj_prosbe_o_wycene_etap_1');
    $acl_frazy -> deny('admin','anuluj_prosbe_o_wycene_etap_1');
    $acl_frazy -> deny('pozycjoner','anuluj_prosbe_o_wycene_etap_1');
    $acl_frazy -> deny('partner','anuluj_prosbe_o_wycene_etap_1');

    $acl_frazy -> resource('anuluj_prosbe_o_wycene_etap_2');
    $acl_frazy -> allow('admin','anuluj_prosbe_o_wycene_etap_2');
    $acl_frazy -> allow('pozycjoner','anuluj_prosbe_o_wycene_etap_2');
    $acl_frazy -> allow('partner','anuluj_prosbe_o_wycene_etap_2');

    $acl_frazy -> resource('anuluj_prosbe_o_wycene_etap_3');
    $acl_frazy -> deny('admin','anuluj_prosbe_o_wycene_etap_3');
    $acl_frazy -> deny('pozycjoner','anuluj_prosbe_o_wycene_etap_3');
    $acl_frazy -> deny('partner','anuluj_prosbe_o_wycene_etap_3');

    $acl_frazy -> resource('anuluj_prosbe_o_wycene_etap_4');
    $acl_frazy -> deny('admin','anuluj_prosbe_o_wycene_etap_4');
    $acl_frazy -> deny('pozycjoner','anuluj_prosbe_o_wycene_etap_4');
    $acl_frazy -> deny('partner','anuluj_prosbe_o_wycene_etap_4');

    $acl_frazy -> resource('anuluj_prosbe_o_wycene_etap_5');
    $acl_frazy -> deny('admin','anuluj_prosbe_o_wycene_etap_5');
    $acl_frazy -> deny('pozycjoner','anuluj_prosbe_o_wycene_etap_5');
    $acl_frazy -> deny('partner','anuluj_prosbe_o_wycene_etap_5');

    $acl_frazy -> resource('anuluj_prosbe_o_wycene_etap_6');
    $acl_frazy -> deny('admin','anuluj_prosbe_o_wycene_etap_6');
    $acl_frazy -> deny('pozycjoner','anuluj_prosbe_o_wycene_etap_6');
    $acl_frazy -> deny('partner','anuluj_prosbe_o_wycene_etap_6');

    // poproś o wycenę z 1 na 2
    $acl_frazy -> resource('popros_o_wycene_etap_1');
    $acl_frazy -> allow('admin','popros_o_wycene_etap_1');
    $acl_frazy -> allow('pozycjoner','popros_o_wycene_etap_1');
    $acl_frazy -> allow('partner','popros_o_wycene_etap_1');

    $acl_frazy -> resource('popros_o_wycene_etap_2');
    $acl_frazy -> deny('admin','popros_o_wycene_etap_2');
    $acl_frazy -> deny('pozycjoner','popros_o_wycene_etap_2');
    $acl_frazy -> deny('partner','popros_o_wycene_etap_2');

    $acl_frazy -> resource('popros_o_wycene_etap_3');
    $acl_frazy -> deny('admin','popros_o_wycene_etap_3');
    $acl_frazy -> deny('pozycjoner','popros_o_wycene_etap_3');
    $acl_frazy -> deny('partner','popros_o_wycene_etap_3');

    $acl_frazy -> resource('popros_o_wycene_etap_4');
    $acl_frazy -> deny('admin','popros_o_wycene_etap_4');
    $acl_frazy -> deny('pozycjoner','popros_o_wycene_etap_4');
    $acl_frazy -> deny('partner','popros_o_wycene_etap_4');

    $acl_frazy -> resource('popros_o_wycene_etap_5');
    $acl_frazy -> deny('admin','popros_o_wycene_etap_5');
    $acl_frazy -> deny('pozycjoner','popros_o_wycene_etap_5');
    $acl_frazy -> deny('partner','popros_o_wycene_etap_5');

    $acl_frazy -> resource('popros_o_wycene_etap_6');
    $acl_frazy -> deny('admin','popros_o_wycene_etap_6');
    $acl_frazy -> deny('pozycjoner','popros_o_wycene_etap_6');
    $acl_frazy -> deny('partner','popros_o_wycene_etap_6');

    // zatwierdz wycenę z 2 na 3
    $acl_frazy -> resource('zatwierdz_wycene_etap_1');
    $acl_frazy -> deny('admin','zatwierdz_wycene_etap_1');
    $acl_frazy -> deny('pozycjoner','zatwierdz_wycene_etap_1');
    $acl_frazy -> deny('partner','zatwierdz_wycene_etap_1');

    $acl_frazy -> resource('zatwierdz_wycene_etap_2');
    $acl_frazy -> allow('admin','zatwierdz_wycene_etap_2');
    $acl_frazy -> allow('pozycjoner','zatwierdz_wycene_etap_2');
    $acl_frazy -> allow('partner','zatwierdz_wycene_etap_2');

    $acl_frazy -> resource('zatwierdz_wycene_etap_3');
    $acl_frazy -> deny('admin','zatwierdz_wycene_etap_3');
    $acl_frazy -> deny('pozycjoner','zatwierdz_wycene_etap_3');
    $acl_frazy -> deny('partner','zatwierdz_wycene_etap_3');

    $acl_frazy -> resource('zatwierdz_wycene_etap_4');
    $acl_frazy -> deny('admin','zatwierdz_wycene_etap_4');
    $acl_frazy -> deny('pozycjoner','zatwierdz_wycene_etap_4');
    $acl_frazy -> deny('partner','zatwierdz_wycene_etap_4');

    $acl_frazy -> resource('zatwierdz_wycene_etap_5');
    $acl_frazy -> deny('admin','zatwierdz_wycene_etap_5');
    $acl_frazy -> deny('pozycjoner','zatwierdz_wycene_etap_5');
    $acl_frazy -> deny('partner','zatwierdz_wycene_etap_5');

    $acl_frazy -> resource('zatwierdz_wycene_etap_6');
    $acl_frazy -> deny('admin','zatwierdz_wycene_etap_6');
    $acl_frazy -> deny('pozycjoner','zatwierdz_wycene_etap_6');
    $acl_frazy -> deny('partner','zatwierdz_wycene_etap_6');

    // zapisz wycenę
    $acl_frazy -> resource('zapisz_wycene_etap_1');
    $acl_frazy -> deny('admin','zapisz_wycene_etap_1');
    $acl_frazy -> deny('pozycjoner','zapisz_wycene_etap_1');
    $acl_frazy -> deny('partner','zapisz_wycene_etap_1');

    $acl_frazy -> resource('zapisz_wycene_etap_2');
    $acl_frazy -> deny('admin','zapisz_wycene_etap_2');
    $acl_frazy -> deny('pozycjoner','zapisz_wycene_etap_2');
    $acl_frazy -> deny('partner','zapisz_wycene_etap_2');

    $acl_frazy -> resource('zapisz_wycene_etap_3');
    $acl_frazy -> allow('admin','zapisz_wycene_etap_3');
    $acl_frazy -> allow('pozycjoner','zapisz_wycene_etap_3');
    $acl_frazy -> allow('partner','zapisz_wycene_etap_3');

    $acl_frazy -> resource('zapisz_wycene_etap_4');
    $acl_frazy -> allow('admin','zapisz_wycene_etap_4');
    $acl_frazy -> allow('pozycjoner','zapisz_wycene_etap_4');
    $acl_frazy -> allow('partner','zapisz_wycene_etap_4');

    $acl_frazy -> resource('zapisz_wycene_etap_5');
    $acl_frazy -> allow('admin','zapisz_wycene_etap_5');
    $acl_frazy -> allow('pozycjoner','zapisz_wycene_etap_5');
    $acl_frazy -> allow('partner','zapisz_wycene_etap_5');

    $acl_frazy -> resource('zapisz_wycene_etap_6');
    $acl_frazy -> allow('admin','zapisz_wycene_etap_6');
    $acl_frazy -> allow('pozycjoner','zapisz_wycene_etap_6');
    $acl_frazy -> allow('partner','zapisz_wycene_etap_6');

    // poproś o rozpoczęcie z 3 na 4
    $acl_frazy -> resource('popros_o_rozpoczecie_etap_1');
    $acl_frazy -> deny('admin','popros_o_rozpoczecie_etap_1');
    $acl_frazy -> deny('pozycjoner','popros_o_rozpoczecie_etap_1');
    $acl_frazy -> deny('partner','popros_o_rozpoczecie_etap_1');

    $acl_frazy -> resource('popros_o_rozpoczecie_etap_2');
    $acl_frazy -> deny('admin','popros_o_rozpoczecie_etap_2');
    $acl_frazy -> deny('pozycjoner','popros_o_rozpoczecie_etap_2');
    $acl_frazy -> deny('partner','popros_o_rozpoczecie_etap_2');

    $acl_frazy -> resource('popros_o_rozpoczecie_etap_3');
    $acl_frazy -> allow('admin','popros_o_rozpoczecie_etap_3');
    $acl_frazy -> allow('pozycjoner','popros_o_rozpoczecie_etap_3');
    $acl_frazy -> allow('partner','popros_o_rozpoczecie_etap_3');

    $acl_frazy -> resource('popros_o_rozpoczecie_etap_4');
    $acl_frazy -> deny('admin','popros_o_rozpoczecie_etap_4');
    $acl_frazy -> deny('pozycjoner','popros_o_rozpoczecie_etap_4');
    $acl_frazy -> deny('partner','popros_o_rozpoczecie_etap_4');

    $acl_frazy -> resource('popros_o_rozpoczecie_etap_5');
    $acl_frazy -> deny('admin','popros_o_rozpoczecie_etap_5');
    $acl_frazy -> deny('pozycjoner','popros_o_rozpoczecie_etap_5');
    $acl_frazy -> deny('partner','popros_o_rozpoczecie_etap_5');

    $acl_frazy -> resource('popros_o_rozpoczecie_etap_6');
    $acl_frazy -> deny('admin','popros_o_rozpoczecie_etap_6');
    $acl_frazy -> deny('pozycjoner','popros_o_rozpoczecie_etap_6');
    $acl_frazy -> deny('partner','popros_o_rozpoczecie_etap_6');

    // rozpocznij z 4 na 5
    $acl_frazy -> resource('rozpocznij_etap_1');
    $acl_frazy -> allow('admin','rozpocznij_etap_1');
    $acl_frazy -> deny('pozycjoner','rozpocznij_etap_1');
    $acl_frazy -> allow('partner','rozpocznij_etap_1');

    $acl_frazy -> resource('rozpocznij_etap_2');
    $acl_frazy -> allow('admin','rozpocznij_etap_2');
    $acl_frazy -> deny('pozycjoner','rozpocznij_etap_2');
    $acl_frazy -> allow('partner','rozpocznij_etap_2');

    $acl_frazy -> resource('rozpocznij_etap_3');
    $acl_frazy -> allow('admin','rozpocznij_etap_3');
    $acl_frazy -> deny('pozycjoner','rozpocznij_etap_3');
    $acl_frazy -> allow('partner','rozpocznij_etap_3');

    $acl_frazy -> resource('rozpocznij_etap_4');
    $acl_frazy -> allow('admin','rozpocznij_etap_4');
    $acl_frazy -> allow('pozycjoner','rozpocznij_etap_4');
    $acl_frazy -> allow('partner','rozpocznij_etap_4');

    $acl_frazy -> resource('rozpocznij_etap_5');
    $acl_frazy -> deny('admin','rozpocznij_etap_5');
    $acl_frazy -> deny('pozycjoner','rozpocznij_etap_5');
    $acl_frazy -> deny('partner','rozpocznij_etap_5');

    $acl_frazy -> resource('rozpocznij_etap_6');
    $acl_frazy -> allow('admin','rozpocznij_etap_6');
    $acl_frazy -> deny('pozycjoner','rozpocznij_etap_6');
    $acl_frazy -> allow('partner','rozpocznij_etap_6');

    // zawies z 5 na 6
    $acl_frazy -> resource('zawies_etap_1');
    $acl_frazy -> allow('admin','zawies_etap_1');
    $acl_frazy -> deny('pozycjoner','zawies_etap_1');
    $acl_frazy -> allow('partner','zawies_etap_1');

    $acl_frazy -> resource('zawies_etap_2');
    $acl_frazy -> allow('admin','zawies_etap_2');
    $acl_frazy -> deny('pozycjoner','zawies_etap_2');
    $acl_frazy -> allow('partner','zawies_etap_2');

    $acl_frazy -> resource('zawies_etap_3');
    $acl_frazy -> allow('admin','zawies_etap_3');
    $acl_frazy -> deny('pozycjoner','zawies_etap_3');
    $acl_frazy -> allow('partner','zawies_etap_3');

    $acl_frazy -> resource('zawies_etap_4');
    $acl_frazy -> allow('admin','zawies_etap_4');
    $acl_frazy -> deny('pozycjoner','zawies_etap_4');
    $acl_frazy -> allow('partner','zawies_etap_4');

    $acl_frazy -> resource('zawies_etap_5');
    $acl_frazy -> allow('admin','zawies_etap_5');
    $acl_frazy -> allow('pozycjoner','zawies_etap_5');
    $acl_frazy -> allow('partner','zawies_etap_5');

    $acl_frazy -> resource('zawies_etap_6');
    $acl_frazy -> deny('admin','zawies_etap_6');
    $acl_frazy -> deny('pozycjoner','zawies_etap_6');
    $acl_frazy -> deny('partner','zawies_etap_6');

    // wznow z 6 na 5
    $acl_frazy -> resource('wznow_etap_1');
    $acl_frazy -> deny('admin','wznow_etap_1');
    $acl_frazy -> deny('pozycjoner','wznow_etap_1');
    $acl_frazy -> deny('partner','wznow_etap_1');

    $acl_frazy -> resource('wznow_etap_2');
    $acl_frazy -> deny('admin','wznow_etap_2');
    $acl_frazy -> deny('pozycjoner','wznow_etap_2');
    $acl_frazy -> deny('partner','wznow_etap_2');

    $acl_frazy -> resource('wznow_etap_3');
    $acl_frazy -> deny('admin','wznow_etap_3');
    $acl_frazy -> deny('pozycjoner','wznow_etap_3');
    $acl_frazy -> deny('partner','wznow_etap_3');

    $acl_frazy -> resource('wznow_etap_4');
    $acl_frazy -> deny('admin','wznow_etap_4');
    $acl_frazy -> deny('pozycjoner','wznow_etap_4');
    $acl_frazy -> deny('partner','wznow_etap_4');

    $acl_frazy -> resource('wznow_etap_5');
    $acl_frazy -> deny('admin','wznow_etap_5');
    $acl_frazy -> deny('pozycjoner','wznow_etap_5');
    $acl_frazy -> deny('partner','wznow_etap_5');

    $acl_frazy -> resource('wznow_etap_6');
    $acl_frazy -> allow('admin','wznow_etap_6');
    $acl_frazy -> allow('pozycjoner','wznow_etap_6');
    $acl_frazy -> allow('partner','wznow_etap_6');

    // generuj pary
    $acl_frazy -> resource('generuj_pary');
    $acl_frazy -> allow('admin','generuj_pary');
    $acl_frazy -> allow('pozycjoner','generuj_pary');
    $acl_frazy -> deny('partner','generuj_pary');


    // POZYCJE
    $acl_frazy -> resource('pozycje_etap_1');
    $acl_frazy -> allow('admin','pozycje_etap_1');
    $acl_frazy -> allow('pozycjoner','pozycje_etap_1');
    $acl_frazy -> allow('partner','pozycje_etap_1');

    $acl_frazy -> resource('pozycje_etap_2');
    $acl_frazy -> allow('admin','pozycje_etap_2');
    $acl_frazy -> allow('pozycjoner','pozycje_etap_2');
    $acl_frazy -> allow('partner','pozycje_etap_2');

    $acl_frazy -> resource('pozycje_etap_3');
    $acl_frazy -> allow('admin','pozycje_etap_3');
    $acl_frazy -> allow('pozycjoner','pozycje_etap_3');
    $acl_frazy -> allow('partner','pozycje_etap_3');

    $acl_frazy -> resource('pozycje_etap_4');
    $acl_frazy -> allow('admin','pozycje_etap_4');
    $acl_frazy -> allow('pozycjoner','pozycje_etap_4');
    $acl_frazy -> allow('partner','pozycje_etap_4');

    $acl_frazy -> resource('pozycje_etap_5');
    $acl_frazy -> allow('admin','pozycje_etap_5');
    $acl_frazy -> allow('pozycjoner','pozycje_etap_5');
    $acl_frazy -> allow('partner','pozycje_etap_5');

    $acl_frazy -> resource('pozycje_etap_6');
    $acl_frazy -> allow('admin','pozycje_etap_6');
    $acl_frazy -> allow('pozycjoner','pozycje_etap_6');
    $acl_frazy -> allow('partner','pozycje_etap_6');
	
	$acl_frazy -> resource('pozycje_etap_7');
    $acl_frazy -> allow('admin','pozycje_etap_7');
    $acl_frazy -> allow('pozycjoner','pozycje_etap_7');
    $acl_frazy -> allow('partner','pozycje_etap_7');
	
	$acl_frazy -> resource('pozycje_etap_8');
    $acl_frazy -> allow('admin','pozycje_etap_8');
    $acl_frazy -> allow('pozycjoner','pozycje_etap_8');
    $acl_frazy -> allow('partner','pozycje_etap_8');
	

    // DOKUMENTY
    $acl_dokumenty = $this -> acl -> create('acl_dokumenty');

    $acl_dokumenty -> role('admin');
    $acl_dokumenty -> role('pozycjoner');
    $acl_dokumenty -> role('partner');

    // lista
    $acl_dokumenty -> resource('lista_etap_1');
    $acl_dokumenty -> allow('admin','lista_etap_1');
    $acl_dokumenty -> allow('pozycjoner','lista_etap_1');
    $acl_dokumenty -> allow('partner','lista_etap_1');

    $acl_dokumenty -> resource('lista_etap_2');
    $acl_dokumenty -> allow('admin','lista_etap_2');
    $acl_dokumenty -> allow('pozycjoner','lista_etap_2');
    $acl_dokumenty -> allow('partner','lista_etap_2');

    $acl_dokumenty -> resource('lista_etap_3');
    $acl_dokumenty -> allow('admin','lista_etap_3');
    $acl_dokumenty -> allow('pozycjoner','lista_etap_3');
    $acl_dokumenty -> allow('partner','lista_etap_3');

    $acl_dokumenty -> resource('lista_etap_4');
    $acl_dokumenty -> allow('admin','lista_etap_4');
    $acl_dokumenty -> allow('pozycjoner','lista_etap_4');
    $acl_dokumenty -> allow('partner','lista_etap_4');

    $acl_dokumenty -> resource('lista_etap_5');
    $acl_dokumenty -> allow('admin','lista_etap_5');
    $acl_dokumenty -> allow('pozycjoner','lista_etap_5');
    $acl_dokumenty -> allow('partner','lista_etap_5');

    $acl_dokumenty -> resource('lista_etap_6');
    $acl_dokumenty -> allow('admin','lista_etap_6');
    $acl_dokumenty -> allow('pozycjoner','lista_etap_6');
    $acl_dokumenty -> allow('partner','lista_etap_6');
	
	$acl_dokumenty -> resource('lista_etap_7');
    $acl_dokumenty -> allow('admin','lista_etap_7');
    $acl_dokumenty -> allow('pozycjoner','lista_etap_7');
    $acl_dokumenty -> allow('partner','lista_etap_7');

?>