<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::button(array('value' => '&#171; Powrót',
                        'link' => url::page(CONTROLLER.'/wszystkie/'.PARAM_2)));

    forms::title(array('title' => !PARAM ? 'Utwórz umowę' : 'Edytuj umowę'));

    forms::open(array('action' => url::page(CONTROLLER.'/zapisz/'.PARAM.'/'.PARAM_2)));

    $typy_umowy = array();
    $typy_umowy[] = array('nazwa' => 'Umowa na wykonanie witryny internetowej', 'wartosc' => 'umowa_na_wykonanie_witryny_internetowej');
    $typy_umowy[] = array('nazwa' => 'Umowa na serwis witryny internetowej', 'wartosc' => 'umowa_na_serwis_witryny_internetowej');

    $typy_umowy[] = array('nazwa' => 'Zaproszenie do testu', 'wartosc' => 'zaproszenie_do_testu');
	
	$typy_umowy[] = array('nazwa' => 'Zakończenie testu', 'wartosc' => 'zakonczenie_testu');
$typy_umowy[] = array('nazwa' => 'Podziękowanie za kontakt', 'wartosc' => 'podziekowanie');

    forms::select(array('data' => $typy_umowy,
                        'fieldClass' => 'widthQuarter typ_umowy',
                        'label' => 'Typ umowy',
                        'labels' => 'nazwa',
                        'id' => 'typ_umowy',
                        'name' => 'typ_umowy',
                        'value' => PARAM ? $umowa['typ_umowy'] : 'umowa_na_wykonanie_witryny_internetowej',
                        'values' => 'wartosc'));

    ?><div class="clear"></div><?php

    forms::text(array('fieldClass' => 'widthQuarter umowa_na_wykonanie_witryny_internetowej umowa_na_serwis_witryny_internetowej zaproszenie_do_testu zakonczenie_testu podziekowanie',
                      'label' => 'Nazwa',
                      'name' => 'nazwa',
                      'required' => 1,
                      'subLabel' => 'Będzie nazwą pobieranego pliku PDF',
                      'value' => $umowa['nazwa']));

    ?><div class="clear"></div><?php

    forms::text(array('fieldClass' => 'widthQuarter umowa_na_wykonanie_witryny_internetowej umowa_na_serwis_witryny_internetowej zaproszenie_do_testu zakonczenie_testu podziekowanie',
                      'label' => 'Numer umowy',
                      'name' => 'numer',
                      'required' => 1,
                      'subLabel' => 'W formacie X/P/'.$klient['id_klienta'].'/'.date("Y"),
                      'value' => $umowa['numer']));

    ?><div class="clear"></div><?php

    $typy_realizacji = array();
    $typy_realizacji[] = array('nazwa' => 'Serwis Internetowy', 'wartosc' => 'Serwisu Internetowego');
    $typy_realizacji[] = array('nazwa' => 'Portal Internetowy', 'wartosc' => 'Portalu Internetowego');
    $typy_realizacji[] = array('nazwa' => 'Sklep Internetowy', 'wartosc' => 'Sklepu Internetowego');

    forms::select(array('data' => $typy_realizacji,
                        'fieldClass' => 'widthQuarter umowa_na_wykonanie_witryny_internetowej',
                        'label' => 'Typ realizacji',
                        'labels' => 'nazwa',
                        'name' => 'typ_realizacji',
                        'value' => $umowa['typ_realizacji'],
                        'values' => 'wartosc'));

    ?><div class="clear"></div><?php

    $terminy_realizacji = array();
    $terminy_realizacji[] = array('nazwa' => '7 dni', 'wartosc' => '7');
    $terminy_realizacji[] = array('nazwa' => '14 dni', 'wartosc' => '14');
    $terminy_realizacji[] = array('nazwa' => '21 dni', 'wartosc' => '21');
    $terminy_realizacji[] = array('nazwa' => '30 dni', 'wartosc' => '30');
    $terminy_realizacji[] = array('nazwa' => '45 dni', 'wartosc' => '45');
    $terminy_realizacji[] = array('nazwa' => '60 dni', 'wartosc' => '60');

    forms::select(array('data' => $terminy_realizacji,
                        'fieldClass' => 'widthQuarter umowa_na_wykonanie_witryny_internetowej',
                        'label' => 'Termin realizacji',
                        'labels' => 'nazwa',
                        'name' => 'termin_realizacji',
                        'value' => PARAM ? $umowa['termin_realizacji'] : '14',
                        'values' => 'wartosc'));

    ?><div class="clear"></div><?php

    forms::text(array('fieldClass' => 'widthQuarter umowa_na_wykonanie_witryny_internetowej umowa_na_serwis_witryny_internetowej',
                      'label' => 'Wysokość wynagrodzenia',
                      'name' => 'wynagrodzenie',
                      'required' => 1,
                      'subLabel' => 'W formacie 123.45',
                      'value' => PARAM ? $umowa['wynagrodzenie'] : '1000.00'));

    ?><div class="clear"></div><?php

    $wysokosci_zadatku = array();
    $wysokosci_zadatku[] = array('nazwa' => '30%', 'wartosc' => '30');
    $wysokosci_zadatku[] = array('nazwa' => '40%', 'wartosc' => '40');
    $wysokosci_zadatku[] = array('nazwa' => '50%', 'wartosc' => '50');
    $wysokosci_zadatku[] = array('nazwa' => '60%', 'wartosc' => '60');

    forms::select(array('data' => $wysokosci_zadatku,
                        'fieldClass' => 'widthQuarter umowa_na_wykonanie_witryny_internetowej',
                        'label' => 'Wysokość zadatku',
                        'labels' => 'nazwa',
                        'name' => 'wysokosc_zadatku',
                        'value' => PARAM ? $umowa['wysokosc_zadatku'] : '40',
                        'values' => 'wartosc'));

    ?><div class="clear"></div><?php

    $terminy_platnosci = array();
    $terminy_platnosci[] = array('nazwa' => '3 dni', 'wartosc' => '3');
    $terminy_platnosci[] = array('nazwa' => '5 dni', 'wartosc' => '5');
    $terminy_platnosci[] = array('nazwa' => '7 dni', 'wartosc' => '7');

    forms::select(array('data' => $terminy_platnosci,
                        'fieldClass' => 'widthQuarter umowa_na_wykonanie_witryny_internetowej',
                        'label' => 'Termin płatności',
                        'labels' => 'nazwa',
                        'name' => 'termin_platnosci',
                        'value' => PARAM ? $umowa['termin_platnosci'] : '3',
                        'values' => 'wartosc'));

    ?><div class="clear"></div><?php

    forms::text(array('fieldClass' => 'widthQuarter umowa_na_serwis_witryny_internetowej zaproszenie_do_testu',
                      'label' => 'Data rozpoczęcia',
                      'name' => 'data_rozpoczecia',
                      'required' => 1,
                      'value' => PARAM ? $umowa['data_rozpoczecia'] : date("Y-m-d")));
    ?><div class="clear"></div><?php

    forms::text(array('fieldClass' => 'widthQuarter  zakonczenie_testu',
                      'label' => 'Data zakończenia',
                      'name' => 'data_rozpoczecia',
                      'required' => 1,
                      'value' => PARAM ? $umowa['data_rozpoczecia'] : date("Y-m-d")));


    ?><div class="clear"></div><?php

    forms::submit(array('fieldClass' => 'submit',
                        'keepEditing' => 1));

    forms::close(0);

?><script type="text/javascript">
    function zmien_typ(){
        var aktualny_typ = $('#typ_umowy').val();
        $('.formField').hide();
        $('.typ_umowy, .submit, .' + aktualny_typ).show();
        //alert(aktualny_typ);
    }
    $(document).ready(function(){
        zmien_typ();
        $('#typ_umowy').change(function(){
            zmien_typ();
        });
    });
</script><?php

    $this -> load -> view('footer');

?>