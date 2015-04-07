<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    if(isset($klient) && $uzytkownik['typ'] == 'admin'){
        forms::button(array('value' => 'Nowa faktura',
                            'link' => url::page(CONTROLLER.'/form/0/'.PARAM)));

        forms::button(array('value' => 'Proforma',
                            'link' => url::page(CONTROLLER.'/form/0/'.PARAM.'/1')));

//         if($klient['faktury_za_pozycjonowanie'] && !$this -> load -> model('faktury') -> czy_faktura_na_pozycjonowanie_juz_jest($klient['id_klienta']) && $klient['etap'] >= 5){
            forms::button(array('value' => 'Faktura za TOP 10',
                                'link' => url::page(CONTROLLER.'/form/0/'.PARAM).'?pozycjonowanie=1&amp;tryb=top10'));
            forms::button(array('value' => 'Faktura za 1 str.',
                                'link' => url::page(CONTROLLER.'/form/0/'.PARAM).'?pozycjonowanie=1&amp;tryb=1str'));
//         }

        echo '<a class="headButtons" href="'.url::page(CONTROLLER).'/wezwanie-do-zaplaty/'.$klient['id_klienta'].'">Wezwanie do zapłaty</a>';
    }

    if(isset($klient) && $uzytkownik['typ'] == 'admin' && $klient['faktura_papierowa']){
    ?>
    <div id="faktura_papierowa_info" class="block warning floatRight" style="background: red; padding: 9px;">
        Klient wymaga wysyłania faktur papierowych
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            animuj();
        });
        function animuj(){
            setTimeout("animuj_1()", 1000);
        }
        function animuj_1(){
            $('#faktura_papierowa_info').fadeOut('slow', function(){ animuj_2(); })
        }
        function animuj_2(){
            $('#faktura_papierowa_info').fadeIn('slow', function(){ animuj(); });
        }
    </script>
    <?php
    }

    forms::title(array('title' => 'Faktury ('.($faktury ? count($faktury) : 0).')'));

    if(isset($filtry) && $uzytkownik['typ'] == 'admin'){
        forms::line(0);

        forms::open(array('action' => url::page(CONTROLLER.'/lista')));

        $typy = array();
        $typy[] = array('url' => 'Tylko normalne',
                        'wartosc' => 'normalne');
        $typy[] = array('url' => 'Tylko proformy',
                        'wartosc' => 'proformy');

        forms::select(array('data' => $typy,
                            'default' => 'Typy wszystkie',
                            'fieldClass' => 'width_10',
                            'labels' => 'url',
                            'name' => 'typ',
                            'value' => $this -> input -> cookie('filtr_faktury_typ'),
                            'values' => 'wartosc'));

        $stany = array();
        $stany[] = array('url' => 'Oczekujące na opłacenie',
                         'wartosc' => 'oczekujace');
        $stany[] = array('url' => 'Opłacone',
                         'wartosc' => 'oplacone');
        $stany[] = array('url' => 'Nieopłacone',
                         'wartosc' => 'nieoplacone');

        forms::select(array('data' => $stany,
                            'default' => 'Stany Wszystkie',
                            'fieldClass' => 'width_10',
                            'labels' => 'url',
                            'name' => 'stan',
                            'value' => $this -> input -> cookie('filtr_faktury_stan'),
                            'values' => 'wartosc'));

        $miesiace = array();
        $miesiace[] = array('url' => 'Styczeń',
                            'wartosc' => '01');
        $miesiace[] = array('url' => 'Luty',
                            'wartosc' => '02');
        $miesiace[] = array('url' => 'Marzec',
                            'wartosc' => '03');
        $miesiace[] = array('url' => 'Kwiecień',
                            'wartosc' => '04');
        $miesiace[] = array('url' => 'Maj',
                            'wartosc' => '05');
        $miesiace[] = array('url' => 'Czerwiec',
                            'wartosc' => '06');
        $miesiace[] = array('url' => 'Lipiec',
                            'wartosc' => '07');
        $miesiace[] = array('url' => 'Sierpień',
                            'wartosc' => '08');
        $miesiace[] = array('url' => 'Wrzesień',
                            'wartosc' => '09');
        $miesiace[] = array('url' => 'Październik',
                            'wartosc' => '10');
        $miesiace[] = array('url' => 'Listopad',
                            'wartosc' => '11');
        $miesiace[] = array('url' => 'Grudzień',
                            'wartosc' => '12');

        forms::select(array('data' => $miesiace,
                            'default' => 'Miesiące Wszystkie',
                            'fieldClass' => 'width_10',
                            'labels' => 'url',
                            'name' => 'miesiac',
                            'value' => $this -> input -> cookie('filtr_faktury_miesiac'),
                            'values' => 'wartosc'));

        $miesiace = array();
        $poczatkowy_rok = 2010;
        $aktualny_rok = date("Y");
        for($i = $poczatkowy_rok; $i <= $aktualny_rok; $i++){
            $lata[] = array('url' => $i,
                            'wartosc' => $i);
        }

        forms::select(array('data' => $lata,
                            'default' => 'Lata Wszystkie',
                            'fieldClass' => 'width_10',
                            'labels' => 'url',
                            'name' => 'rok',
                            'value' => $this -> input -> cookie('filtr_faktury_rok'),
                            'values' => 'wartosc'));

        forms::select(array('data' => $this -> load -> model('klienci') -> lista_do_selecta(),
                            'default' => 'Klienci Wszyscy',
                            'fieldClass' => 'width_10',
                            'labels' => 'nazwa',
                            'name' => 'klient',
                            'value' => $this -> input -> cookie('filtr_faktury_klient'),
                            'values' => 'id_klienta'));
		forms::select(array('data' => $this -> load -> model('partnerzy') -> lista_do_selecta(),
                            'default' => 'Partnerzy Wszyscy',
                            'fieldClass' => 'width_10',
                            'labels' => 'nazwa',
                            'name' => 'partner',
                            'value' => $this -> input -> cookie('filtr_faktury_partner'),
                            'values' => 'id_partnera'));

        $formy_zaplaty = array();
        $formy_zaplaty[] = array('url' => 'Gotówka',
                                 'wartosc' => 'Gotówka');
        $formy_zaplaty[] = array('url' => 'Przelew',
                                 'wartosc' => 'Przelew');
/*
        forms::select(array('data' => $formy_zaplaty,
                            'default' => 'Formy zapłaty Wszystkie',
                            'fieldClass' => 'width_10',
                            'labels' => 'url',
                            'name' => 'forma_zaplaty',
                            'value' => $this -> input -> cookie('filtr_forma_zaplaty'),
                            'values' => 'wartosc'));
*/
        forms::select(array('data' => $this -> load -> model('faktury') -> wszystkie_towary_i_uslugi(),
                            'default' => 'Usługi wszystkie',
                            'fieldClass' => 'width_10',
                            'labels' => 'nazwa',
                            'name' => 'typ_uslugi',
                            'value' => $this -> input -> cookie('filtr_typ_uslugi'),
                            'values' => 'id_towaru_lub_uslugi'));

        $sortowanie = array();
        $sortowanie[] = array('url' => 'Data wystawienia',
                              'wartosc' => 'data_wystawienia');

        $sortowanie[] = array('url' => 'Data sprzedaży',
                              'wartosc' => 'data_sprzedazy');

        $sortowanie[] = array('url' => 'Termin zapłaty',
                              'wartosc' => 'termin_zaplaty');

        $sortowanie[] = array('url' => 'Data utworzenia',
                              'wartosc' => 'data_utworzenia');
							  
		$sortowanie[] = array('url' => 'Data opłacenia',
                              'wartosc' => 'data_zaplaty');

        $sortowanie[] = array('url' => 'Numer faktury',
                              'wartosc' => 'numer_faktury');

        $sortowanie[] = array('url' => 'Kwota netto',
                              'wartosc' => 'kwota_netto');

        $sortowanie[] = array('url' => 'Kwota podatku',
                              'wartosc' => 'kwota_podatku');

        $sortowanie[] = array('url' => 'Kwota brutto',
                              'wartosc' => 'kwota_brutto');

        forms::select(array('data' => $sortowanie,
                            'fieldClass' => 'width_15',
                            'labels' => 'url',
                            'name' => 'sortowanie',
                            'value' => $this -> input -> cookie('filtr_faktury_sortowanie'),
                            'values' => 'wartosc'));

        $kierunek = array();
        $kierunek[] = array('url' => 'Malejąco',
                            'wartosc' => 'desc');
        $kierunek[] = array('url' => 'Rosnąco',
                            'wartosc' => 'asc');

        forms::select(array('data' => $kierunek,
                            'fieldClass' => 'width_10',
                            'labels' => 'url',
                            'name' => 'kierunek',
                            'value' => $this -> input -> cookie('filtr_faktury_kierunek'),
                            'values' => 'wartosc'));
		
		
        forms::submit(array('fieldClass' => 'floatLeft',
                            'label' => 'Filtruj'));

        forms::close(0);

       ?><div class="clear" style="height: 15px;"></div><?php
    }

    if($faktury){
        $uslugi = $this -> load -> model('faktury') -> towary_i_uslugi(0);
		$partnerzy = $this -> load -> model('partnerzy');
        if($uzytkownik['typ'] == 'admin') forms::open(array('action' => '#',
                                                            'onSubmit' => 'return multi_akcja($(this));'));

        echo '<table border="0" cellpadding="0" cellspacing="0" class="base">';
            echo '<tr>';
                if($uzytkownik['typ'] == 'admin') echo '<th><input id="zaznacz_wszystkie" type="checkbox" /></th>';
                echo '<th>Numer</th>'; $ilosc_faktur = 0;
				echo '<th>Handlwoiec</th>';
                echo '<th>Data wystawienia</th>';
                echo '<th>Klient</th>';
                echo '<th>&nbsp;&nbsp;&nbsp;&nbsp;</th>';
                echo '<th>Termin zapłaty</th>';
                echo '<th>Netto</th>'; $suma_netto = 0;
                echo '<th>VAT</th>'; $suma_podatku = 0;
                echo '<th>Brutto</th>'; $suma_brutto = 0;
                echo '<th>Wysłana mailem</th>';
                if($uzytkownik['typ'] == 'admin') echo '<th></th>';
            echo '</tr>';
            $i = 0; foreach($faktury as $faktura){
			$partner = $partnerzy -> jeden($faktura['id_partnera']);
            echo $i == 1 ? '<tr>' : '<tr class="odd">';
                $i++;
                if($i == 2) $i = 0;
                if($uzytkownik['typ'] == 'admin') echo '<td style="width: 1%;"><input name="id_faktur[]" type="checkbox" value="'.$faktura['id_faktury'].'" /></td>';
                echo '<td class="nobr"><a href="'.url::page('faktury/podglad/'.$faktura['id_faktury'].'/'.$faktura['id_klienta']).'">'.texts::numer_faktury($faktura).'</a>';
                if($faktura['zaliczka']) echo ' (Zaliczkowa)';
                if($faktura['id_faktury_zaliczkowej']) echo ' (Końcowa)';
                $ilosc_faktur++;
                echo'</td>';
				echo '<td class="nobr">'.$partner['nazwa'].'</td>';
                echo '<td class="nobr">'.texts::nice_date($faktura['data_wystawienia']).'</td>';
                echo '<td>';
                if(isset($faktura['nazwa'])) echo '<a href="'.url::page('klienci/profil/'.$faktura['id_klienta']).'">'.texts::short($faktura['nazwa'], 40).'</a>';
                else echo '<a href="'.url::page('klienci/profil/'.$klient['id_klienta']).'">'.texts::short($klient['nazwa'], 40).'</a>';
                echo '</td>';

                $nieoplacona = 0;

                // oplacona
                if($faktura['status']){
                    $stan = 'opłacona';
                    if($faktura['data_zaplaty'] != '0000-00-00') $stan .= '<br />'.texts::nice_date($faktura['data_zaplaty']);
                    if($faktura['osoba_pobierajaca_gotowke']) $stan .= '<br />Pobrane przez: '.$faktura['osoba_pobierajaca_gotowke'];
                    $stan_2 = 'opłacona';
                }

                // nie opłacona
                else{

                    // przekroczona
                    if(date("Y-m-d") >= $faktura['termin_zaplaty']){
                        $nieoplacona = 1;
                        $stan = 'nieopłacona';
                        $stan_2 = 'nieopłacona';
                    }

                    // oczekująca
                    else{
                        $stan = 'oczekiwanie';
                        $stan_2 = 'oczekiwanie';
                    }

                    // częściowa
                    if($faktura['wplacona_kwota'] < $faktura['kwota_brutto'] && $faktura['wplacona_kwota'] != '0.00'){
                        $stan ='opłacona częściowo';
                        if($faktura['data_zaplaty'] != '0000-00-00') $stan .= '<br />'.texts::nice_date($faktura['data_zaplaty']);                        
                        $stan .= '<br />Kwota: '.str_replace('.00', '', number_format($faktura['wplacona_kwota'], 2, '.', ' '));
                        if($faktura['osoba_pobierajaca_gotowke']) $stan .= '<br />Pobrane przez: '.$faktura['osoba_pobierajaca_gotowke'];
                        $stan_2 = 'opłacona częściowo';
                    }
                    
                }

                if($nieoplacona && $uzytkownik['typ'] == 'admin'){
                    $stan .= ' <span class="small">('.texts::ile_dni_minelo($faktura['termin_zaplaty'], date("Y-m-d")).' temu)';
                    if(!$faktura['wezwanie_mailowe_1']){
                        $stan .= '<br /><a href="'.url::page(CONTROLLER.'/wyslij-oryginal-do-klienta/'.$faktura['id_faktury'].'/wezwanie').'">wyślij wezwanie</a>';
                    }else{
                        $stan .= '<br />Wezwanie wysłano '.texts::nice_date($faktura['wezwanie_mailowe_1_data_wyslania']). ' ('.texts::ile_dni_minelo($faktura['wezwanie_mailowe_1_data_wyslania'], date("Y-m-d")).' temu)';
                        if(!$faktura['wezwanie_mailowe_2']){
                            $stan .= '<br /><a href="'.url::page(CONTROLLER.'/wyslij-oryginal-do-klienta/'.$faktura['id_faktury'].'/wezwanie_powtorne').'">wyślij powtórne wezwanie</a>';
                        }else{
                            $stan .= '<br />Powtórne wezwanie wysłano '.texts::nice_date($faktura['wezwanie_mailowe_2_data_wyslania']). ' ('.texts::ile_dni_minelo($faktura['wezwanie_mailowe_2_data_wyslania'], date("Y-m-d")).' temu)';
                        }
                    }
                }
                if($stan_2 == 'nieopłacona') $stan_kolor = 'red';
                else if($stan_2 == 'opłacona') $stan_kolor = 'green';
                else if($stan_2 == 'opłacona częściowo') $stan_kolor = 'orange';
                else if($stan_2 == 'oczekiwanie') $stan_kolor = 'gray';

                echo '<td class="szczegoly_platnosci" style="background: '.$stan_kolor.'; border-bottom: 1px solid #FFF; padding: 2px; width: 1%;">';
                echo '<div style="background: #FFF; ';
                if($uzytkownik['typ'] == 'admin') echo 'display: none; min-height: 80px; width: 150px; ';
                else echo 'text-align: center; ';
                echo 'padding: 2px 6px 5px 6px;">';
                echo $uzytkownik['typ'] == 'admin' ? $stan : $stan_2;
                echo '</div>';
                echo '</td>';

                echo '<td class="nobr">'.texts::nice_date($faktura['termin_zaplaty']).'</td>';
                echo '<td class="nobr">'.str_replace('.00', '', number_format($faktura['kwota_netto'], 2, '.', ' ')).'</td>'; $suma_netto = $suma_netto + $faktura['kwota_netto'];
                echo '<td class="nobr">'.str_replace('.00', '', number_format($faktura['kwota_podatku'], 2, '.', ' ')).'</td>'; $suma_podatku = $suma_podatku + $faktura['kwota_podatku'];
                echo '<td class="nobr">'.str_replace('.00', '', number_format($faktura['kwota_brutto'], 2, '.', ' ')).'</td>'; $suma_brutto = $suma_brutto + $faktura['kwota_brutto'];

                echo '<td><span style="color: '.($faktura['wyslana_mailem'] ? 'green' : 'red').';">'.($faktura['wyslana_mailem'] ? 'tak' : 'nie').'</span></td>';
                if($uzytkownik['typ'] == 'admin'){
                    echo '<td class="akcje"><div><span>';

                    $akcje = array();

                    if(!$faktura['status']){
                        $akcje[] = array('url' => url::page(CONTROLLER.'/potwierdz-oplate/'.$faktura['id_faktury'].'/'.$faktura['id_klienta']),
                                         'etykieta' => 'Potwierdź',
                                         'rel' => 'potwierdzenie');
                    }

                    $akcje[] = array('url' => url::page(CONTROLLER.'/form/'.$faktura['id_faktury'].'/'.$faktura['id_klienta']),
                                     'etykieta' => 'Edytuj');

                    $akcje[] = array('url' => url::page('faktury/pobierz_pdf/' . $faktura['id_faktury'] . '/oryginal'),
                                     'etykieta' => 'Oryginał',
                                     'rel' => 'external');

                    $akcje[] = array('url' => url::page('faktury/pobierz_pdf/' . $faktura['id_faktury'] . '/kopia'),
                                     'etykieta' => 'Kopia',
                                     'rel' => 'external');

                    $akcje[] = array('url' => url::page('faktury/pobierz_pdf/' . $faktura['id_faktury'] . '/duplikat'),
                                     'etykieta' => 'Duplikat',
                                     'rel' => 'external');

                    $akcje[] = array('url' => url::page('faktury/podglad/'.$faktura['id_faktury'].'/'.$faktura['id_klienta']),
                                     'etykieta' => 'Podgląd');

                    $akcje[] = array('url' => url::page(CONTROLLER.'/wyslij-oryginal-do-klienta/'.$faktura['id_faktury']),
                                     'etykieta' => 'Wyślij oryginał do klienta');

                    $akcje[] = array('url' => url::page(CONTROLLER.'/historia-wplat/'.$faktura['id_faktury'].'/'.$faktura['id_klienta']),
                                     'etykieta' => 'Historia wpłat',
                                     'rel' => 'modal');
					$akcje[] = array('url' => url::page('faktury/fak_kwota/' . $faktura['id_faktury']),
                                     'etykieta' => 'Korygująca',
                                     'rel' => 'modal');
					
					

                    /*echo '<select onchange="top.location.href=$(this).val();" name="akcje_'.$faktura['id_faktury'].'">';
                    echo '<option value="#">Wybierz akcję...</option>';
                    foreach($akcje as $akcja) echo '<option value="'.$akcja['url'].'">'.$akcja['etykieta'].'</option>';
                    echo '</select>';*/
                    foreach($akcje as $akcja){
                        echo '<a href="'.$akcja['url'].'"';
                        if(isset($akcja['rel'])) echo ' rel="'.$akcja['rel'].'"';
                        echo '>'.$akcja['etykieta'].'</a>';
                    }

                    echo '</span></div></td>';
                }
            echo '</tr>';
        }

        if($uzytkownik['typ'] == 'admin'){
            // podsumowanie
            echo '<tr>';
                if($uzytkownik['typ'] == 'admin') echo '<td style="background: #CCC;"></td>';
                echo '<td style="background: #CCC;">Ilość faktur w zestawieniu: '.$ilosc_faktur.'</td>';
                echo '<td style="background: #CCC;"></td>';
                echo '<td style="background: #CCC;"></td>';
                echo '<td style="background: #CCC;"></td>';
                echo '<td style="background: #CCC;"></td>';
                echo '<td class="nobr" style="background: #CCC;">'.str_replace('.00', '', number_format($suma_netto, 2, '.', ' ')).'</td>';
                echo '<td class="nobr" style="background: #CCC;">'.str_replace('.00', '', number_format($suma_podatku, 2, '.', ' ')).'</td>';
                echo '<td class="nobr" style="background: #CCC;">'.str_replace('.00', '', number_format($suma_brutto, 2, '.', ' ')).'</td>';
                echo '<td style="background: #CCC;"></td>';
                if($uzytkownik['typ'] == 'admin') echo '<td style="background: #CCC;"></td>';
            echo '</tr>';
        }

        echo '</table>';

        if($uzytkownik['typ'] == 'admin'){

            forms::line(0);

            echo '<b>Zaznaczone:</b>&nbsp; ';
            echo '<select class="formSelect width_auto" name="multi_akcja_wybor" id="multi_akcja_wybor">';
            echo '<option value="0">Wybierz...</option>';
            echo '<option value="wyslij_na_maila">Wyślij na e-mail (spakowane)</option>';
            echo '<option value="wyslij_na_maila_jeden_pdf">Wyślij na e-mail (jeden PDF)</option>';
            echo '<option value="wyslij_oryginaly_do_klientow">Wyślij oryginały do klientów</option>';
            echo '</select>';

            echo '<span class="hidden" id="dodatkowe_parametry">';
                echo ' &nbsp; &nbsp; &nbsp; ';

                echo '<input id="wyslij_oryginaly" name="wyslij_oryginaly" type="checkbox" value="1"><label for="wyslij_oryginaly"> Załącz oryginały</label>';

                echo ' &nbsp; &nbsp; &nbsp; ';

                echo '<input id="wyslij_kopie" name="wyslij_kopie" type="checkbox" value="1"><label for="wyslij_kopie"> Załącz kopie</label>';

                echo ' &nbsp; &nbsp; &nbsp; ';

                echo '<input id="zalacz_adresowki" name="zalacz_adresowki" type="checkbox" value="1"><label for="zalacz_adresowki"> Załącz stronę z adresem</label>';

                echo ' &nbsp; &nbsp; &nbsp; ';

                echo '<label for="mail">Adres e-mail </label><input id="mail" name="mail" type="text" />';
            echo '</span>';

            echo ' &nbsp; &nbsp; &nbsp; ';

            echo '<input class="formButton" type="submit" value="Wykonaj" />';

            if($faktury) echo '<hr /><a class="headButtons" href="'.url::page(CONTROLLER).'/lista/csv" target="_blank">Eksport listy do CSV</a>';

            forms::close(0);

            ?><script type="text/javascript">
                $(function(){
                    $('.szczegoly_platnosci').hover(
                        function(){
                            $(this).find('div').show();
                        },
                        function(){
                            $(this).find('div').hide();
                        }
                    );

                    $('.base tr').hover(
                        function(){
                            var position = $(this).position();
                            $(this).addClass('hover');
                            var cont = $(this).find('td.akcje div');
                            cont.show();
                            cont.css('top',position.top - cont.height() + $(this).height());
                        },
                        function(){
                            $(this).removeClass('hover');
                            $(this).find('td.akcje div').hide();
                        }
                    );

                    $('#zaznacz_wszystkie').click(function(){
                        if($(this).is(':checked')) $('input[type=checkbox]').attr('checked','checked');
                        else $('input[type=checkbox]').removeAttr('checked');
                    });
                });

                $('#multi_akcja_wybor').change(function(){
                    if($(this).val() == 'wyslij_na_maila' || $(this).val() == 'wyslij_na_maila_jeden_pdf') $('#dodatkowe_parametry').show();
                    else $('#dodatkowe_parametry').hide();
                });

                function multi_akcja(formularz){
                    if($('#multi_akcja_wybor').val() == 0){
                        alert('Wybierz rodzaj akcji.');
                        return false;
                    }else{
                        formularz.attr('action', '<?php echo url::page(CONTROLLER);?>/' + $('#multi_akcja_wybor').val());
                        preloader();
                        return true;
                    }
                }
        
            </script><?php

        }

    }

    $this -> load -> view('footer');
?>