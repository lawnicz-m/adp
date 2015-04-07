<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    $partnerzy = $this -> load -> model('partnerzy') -> lista_do_selecta();
    $towary_i_uslugi = $this -> load -> model('faktury') -> towary_i_uslugi(1);

    if(isset($faktura) && $faktura['proforma'] == 1) $proforma = 1;

    forms::title(array('title' => !PARAM ? ($proforma ? 'Utwórz fakturę VAT proforma' : 'Utwórz fakturę VAT') : ($proforma ? 'Edytuj fakturę VAT proforma' : 'Edytuj fakturę VAT')));

    forms::open(array('action' => url::page(CONTROLLER.'/zapisz/'.PARAM.'/'.PARAM_2.'/'.$proforma)));

    
    
    
    $read_only = PARAM ? true : false;
    forms::text(array('fieldClass' => 'date_picker widthQuarter',
                      'label' => 'Data wystawienia',
                      'name' => 'data_wystawienia',
                      'readOnly' => $read_only,
                      'required' => 1,
                      'value' => isset($faktura['data_wystawienia']) ? $faktura['data_wystawienia'] : date("Y-m-d")));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Data sprzedaży',
                      'name' => 'data_sprzedazy',
                      'readOnly' => $read_only,
                      'required' => 1,
                      'value' => isset($faktura['data_sprzedazy']) ? $faktura['data_sprzedazy'] : date("Y-m-d")));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Termin zapłaty',
                      'name' => 'termin_zaplaty',
                      'required' => 1,
                      'value' => isset($faktura['termin_zaplaty']) ? $faktura['termin_zaplaty'] : date("Y-m-d", strtotime("+7 days"))));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Miejscowość',
                      'name' => 'miejsce_sprzedazy',
                      'required' => 1,
                      'value' => isset($faktura['miejsce_sprzedazy']) ? $faktura['miejsce_sprzedazy'] : INVOICE_COMPANY_ADDRESS_CITY));

    forms::line(0);

    ?><table border="0" cellpadding="0" cellspacing="0" style="width: 100%;"><tr><?php
    ?><td style="vertical-align: top; width: 50%;"><h3 style="margin: 0 0 0 5px;">Nabywca</h3><?php    
    
    forms::text(array('label' => 'Nazwa',
                      'name' => 'nabywca_nazwa',
                      'required' => 1,
                      'value' => isset($faktura['nabywca_nazwa']) ? $faktura['nabywca_nazwa'] : $klient['faktura_nazwa']));

    forms::text(array('label' => 'Adres',
                      'name' => 'nabywca_adres',
                      'required' => 1,
                      'value' => isset($faktura['nabywca_adres']) ? $faktura['nabywca_adres'] : $klient['faktura_adres']));

    forms::text(array('label' => 'Kod pocztowy',
                      'name' => 'nabywca_kod_pocztowy',
                      'required' => 1,
                      'value' => isset($faktura['nabywca_kod_pocztowy']) ? $faktura['nabywca_kod_pocztowy'] : $klient['faktura_kod_pocztowy']));

    forms::text(array('label' => 'Miejscowość',
                      'name' => 'nabywca_miejscowosc',
                      'required' => 1,
                      'value' => isset($faktura['nabywca_miejscowosc']) ? $faktura['nabywca_miejscowosc'] : $klient['faktura_miejscowosc']));

    forms::text(array('label' => 'NIP',
                      'name' => 'nabywca_nip',
                      'required' => 1,
                      'value' => isset($faktura['nabywca_nip']) ? $faktura['nabywca_nip'] : $klient['nip']));

    ?></td><td style="vertical-align: top; width: 50%;"><h3 style="margin: 0 0 0 5px;">Sprzedawca</h3><?php

    forms::text(array('label' => 'Nazwa',
                      'name' => 'sprzedawca_nazwa',
                      'required' => 1,
                      'value' => isset($faktura['sprzedawca_nazwa']) ? $faktura['sprzedawca_nazwa'] : INVOICE_COMPANY_NAME));

    forms::text(array('label' => 'Adres',
                      'name' => 'sprzedawca_adres',
                      'required' => 1,
                      'value' => isset($faktura['sprzedawca_adres']) ? $faktura['sprzedawca_adres'] : INVOICE_COMPANY_ADDRESS_STREET));

    forms::text(array('label' => 'Kod pocztowy',
                      'name' => 'sprzedawca_kod_pocztowy',
                      'required' => 1,
                      'value' => isset($faktura['sprzedawca_kod_pocztowy']) ? $faktura['sprzedawca_kod_pocztowy'] : INVOICE_COMPANY_ADDRESS_POSTAL_CODE));

    forms::text(array('label' => 'Miejscowość',
                      'name' => 'sprzedawca_miejscowosc',
                      'required' => 1,
                      'value' => isset($faktura['sprzedawca_miejscowosc']) ? $faktura['sprzedawca_miejscowosc'] : INVOICE_COMPANY_ADDRESS_CITY));

    forms::text(array('label' => 'NIP',
                      'name' => 'sprzedawca_nip',
                      'required' => 1,
                      'value' => isset($faktura['sprzedawca_nip']) ? $faktura['sprzedawca_nip'] : INVOICE_COMPANY_TAX_NUMBER));

    ?></td><?php
    ?></tr></table><?php

    forms::line(0);

    ?><a class="headButtons" href="#" id="dodaj_wiersz">Dodaj kolejną usługę</a>
    
<script type="text/javascript">
</script>
    
    <div
    	id="pozycjonowanie_popup"
    	class="hidden"
    	style="margin: 5px; border-radius: 5px; border: solid 1px black; background-color: white; position: fixed; width: 500px; height: 150px; left:20%; top:20%;">
    
    <h1>Podliczenie fraz</h1>
    <form>
    
    <?php 
    	 forms::text(array('fieldClass' => 'date_picker widthQuarter',
                      'label' => 'Od',
                      'name' => 'data_top10_od',
                      'readOnly' => $read_only,
                      'required' => 1,
                      'value' => date("Y-m-d")));
    	 
    	 forms::text(array('fieldClass' => 'date_picker widthQuarter',
    	 	'label' => 'Do',
    	 	'name' => 'data_top10_do',
    	 	'readOnly' => $read_only,
    	 	'required' => 1,
    	 	'value' => date("Y-m-d")));
    	 
    	 ?>
    
	    <div id="dropbox" class="hidden"></div>
	    
	    <div style="clear: both;"></div>
	    	<a style="margin: 5px;" id="wylicz_b">Wylicz</a>
	    	<a style="margin: 5px;" id="anuluj_b">Anuluj</a>
    </div>
    
    <?php

    forms::title(array('title' => 'Towary i usługi'));

    ?>

<?php 
    
    
    echo '<script type="text/javascript">';
    echo 'var row = \'';
    echo '<tr>';

        // Nazwa
        echo '<td>';
            echo '<select class="id_towaru_lub_uslugi" name="id_towaru_lub_uslugi[]">';
            foreach($towary_i_uslugi as $towar_lub_usluga){
                echo '<option rel="'.$towar_lub_usluga['stawka_vat'].'|'.$towar_lub_usluga['jednostka_miary'].'|'.$towar_lub_usluga['pkwiu'].'" value="'.$towar_lub_usluga['id_towaru_lub_uslugi'].'">'.$towar_lub_usluga['nazwa'].'</option>';
            }
            echo '</select>';
        echo '</td>';

        // tytul
        echo '<td>';
            echo '<input class="tytul" name="tytul[]" type="text" value="" style="width: 120px;" />';
        echo '</td>';

        // jednostka miary
        echo '<td>';
            echo '<input class="jednostka_miary" name="jednostka_miary[]" type="text" value="" />';
        echo '</td>';

        // pkwiu
        echo '<td>';
            echo '<input class="pkwiu" name="pkwiu[]" type="text" value="" />';
        echo '</td>';

        // cena netto
        echo '<td>';
            echo '<input class="cena_netto" name="cena_netto[]" type="text" value="" />';
        echo '</td>';

        // ilość
        echo '<td>';
            echo '<input class="ilosc" name="ilosc[]" type="text" value="1" />';
        echo '</td>';

        // kwota netto
        echo '<td>';
            echo '<input class="kwota_netto" name="kwota_netto[]" type="text" value="" />';
        echo '</td>';

        // stawka vat
        echo '<td>';
            echo '<input class="stawka_vat" name="stawka_vat[]" type="text" value="" />';
        echo '</td>';

        // kwota podatku
        echo '<td>';
            echo '<input class="kwota_podatku" name="kwota_podatku[]" type="text" value="" />';
        echo '</td>';

        // kwota brutto
        echo '<td>';
            echo '<input class="kwota_brutto" name="kwota_brutto[]" type="text" value="" />';
        echo '</td>';

        echo '<td><table border="0" cellpadding="0" cellspacing="5" class="tabela_prowizji">';

        // partner 1
        echo '<tr>';
        echo '<td>Partner 1</td>';
        echo '<td>';
            echo '<select name="prowizja_id_partnera_1[]">';
                echo '<option value="0">Brak</option>';
            foreach($partnerzy as $partner){
                $selected = 0;
                if($partner['id_partnera'] == (isset($faktura['prowizja_id_partnera_1']) ? $faktura['prowizja_id_partnera_1'] : 0)) $selected = 1;
                echo '<option ';
                if($selected) echo 'selected="selected" ';
                echo 'value="'.$partner['id_partnera'].'">'.$partner['nazwa'].'</option>';
            }
            echo '</select>';
        echo '</td>';

        // partner 1 prowizja
        echo '<td>';
            echo '<input name="prowizja_partnera_1[]" class="prowizja_partnera_1" type="text" value="'.(isset($faktura['prowizja_partnera_1']) ? $faktura['prowizja_partnera_1'] : 0).'" />';
        echo '</td>';

        // partner 1 prowizja próg
        echo '<td>';
            echo '<input name="prowizja_partnera_1_prog[]" class="prowizja_partnera_1_prog" type="text" value="'.(isset($faktura['prowizja_partnera_1_prog']) ? $faktura['prowizja_partnera_1_prog'] : 0).'" />';
            echo '<input class="prowizja_partnera_1_zrzut" type="hidden" value="0" />';
        echo '</td>';
        echo '</tr>';

        // partner 2
        echo '<tr>';
        echo '<td>Partner 2</td>';
        echo '<td>';
            echo '<select name="prowizja_id_partnera_2[]">';
                echo '<option value="0">Brak</option>';
            foreach($partnerzy as $partner){
                $selected = 0;
                if($partner['id_partnera'] == (isset($faktura['prowizja_id_partnera_2']) ? $faktura['prowizja_id_partnera_2'] : 0)) $selected = 1;
                echo '<option ';
                if($selected) echo 'selected="selected" ';
                echo 'value="'.$partner['id_partnera'].'">'.$partner['nazwa'].'</option>';
            }
            echo '</select>';
        echo '</td>';

        // partner 2 prowizja
        echo '<td>';
            echo '<input name="prowizja_partnera_2[]" class="prowizja_partnera_2" type="text" value="'.(isset($faktura['prowizja_partnera_2']) ? $faktura['prowizja_partnera_2'] : 0).'" />';
        echo '</td>';

        // partner 2 prowizja próg
        echo '<td>';
            echo '<input name="prowizja_partnera_2_prog[]" class="prowizja_partnera_2_prog" type="text" value="'.(isset($faktura['prowizja_partnera_2_prog']) ? $faktura['prowizja_partnera_2_prog'] : 0).'" />';
            echo '<input class="prowizja_partnera_2_zrzut" type="hidden" value="0" />';
        echo '</td>';

        echo '</tr>';

        // wynagrodzenie wykonawcy
        echo '<tr>';

        echo '<td>Wykonawca</td>';

        echo '<td>';
            echo '<select name="wynagrodzenie_wykonawcy_id_partnera[]">';
                echo '<option value="0">Brak</option>';
            foreach($partnerzy as $partner){
                echo '<option value="'.$partner['id_partnera'].'">'.$partner['nazwa'].'</option>';
            }
            echo '</select>';
        echo '</td>';

        // wykonawca wynagrodzenie
        echo '<td colspan="2">';
            echo '<input name="wynagrodzenie_wykonawcy_kwota[]" type="text" value="0" />';
        echo '</td>';

        echo '</tr>';

        echo '</table></td>';

        // usuń
        echo '<td>';
        echo '<a href="#" class="usun_wiersz"><img alt="" class="floatLeft" src="'.url::base().'/inc/cms/img/crystalClear/20/delete.gif" /></a>';
        echo '</td>';
    echo '</tr>';
    echo '\';';
    echo '</script>';

    echo '<div style="padding: 10px;"><table border="0" cellpadding="0" cellspacing="1" id="faktura_uslugi">';
        echo '<thead><tr>';
            echo '<td>Nazwa towaru / usługi</td>';
            echo '<td>Informacja dodatkowa</td>';
            echo '<td>J.m.</td>';
            echo '<td>PKWiU</td>';
            echo '<td>Cena netto</td>';
            echo '<td>Ilość</td>';
            echo '<td>Kwota netto</td>';
            echo '<td>% VAT</td>';
            echo '<td>Kwota VAT</td>';
            echo '<td>Kwota brutto</td>';
            echo '<td>Prowizje i wynagrodzenia<br />P1: <span id="partner_1_wyliczona_prowizja"></span>, P2: <span id="partner_2_wyliczona_prowizja"></span></td>';
            echo '<td></td>';
        echo '</tr></thead><tbody>';

    if(isset($faktura['pozycje']) && $faktura['pozycje'] && $towary_i_uslugi){
        $i = 0; foreach($faktura['pozycje'] as $pozycja){ $i++;
            echo '<tr>';

                // Nazwa
                echo '<td>';
                    echo '<select id="id_towaru_lub_uslugi" class="id_towaru_lub_uslugi" name="id_towaru_lub_uslugi[]">';
                    foreach($towary_i_uslugi as $towar_lub_usluga){
                        $selected = 0;
                        if($towar_lub_usluga['id_towaru_lub_uslugi'] == (isset($pozycja['id_towaru_lub_uslugi']) ? $pozycja['id_towaru_lub_uslugi'] : 1)) $selected = 1;
                        echo '<option rel="'.$towar_lub_usluga['stawka_vat'].'|'.$towar_lub_usluga['jednostka_miary'].'|'.$towar_lub_usluga['pkwiu'].'" ';
                        if($selected) echo 'selected="selected" ';
                        echo 'value="'.$towar_lub_usluga['id_towaru_lub_uslugi'].'">'.$towar_lub_usluga['nazwa'].'</option>';
                    }
                    echo '</select>';
                echo '</td>';

                // tytul
                echo '<td>';
                    echo '<input class="tytul" name="tytul[]" type="text" value="'.(isset($pozycja['tytul']) ? $pozycja['tytul'] : '').'" style="width: 120px;" />';
                echo '</td>';

                // jednostka miary
                echo '<td>';
                    echo '<input class="jednostka_miary" name="jednostka_miary[]" type="text" value="'.(isset($pozycja['jednostka_miary']) ? $pozycja['jednostka_miary'] : 0).'" />';
                echo '</td>';

                // pkwiu
                echo '<td>';
                    echo '<input class="pkwiu" name="pkwiu[]" type="text" value="'.(isset($pozycja['pkwiu']) ? $pozycja['pkwiu'] : 0).'" />';
                echo '</td>';

                // cena netto
                echo '<td>';
                    echo '<input class="cena_netto" name="cena_netto[]" type="text" value="'.(isset($pozycja['cena_netto']) ? $pozycja['cena_netto'] : 0).'" />';
                echo '</td>';

                // ilość
                echo '<td>';
                    echo '<input class="ilosc" name="ilosc[]" type="text" value="'.(isset($pozycja['ilosc']) ? $pozycja['ilosc'] : 0).'" />';
                echo '</td>';

                // kwota netto
                echo '<td>';
                    echo '<input class="kwota_netto" name="kwota_netto[]" type="text" value="'.(isset($pozycja['kwota_netto']) ? $pozycja['kwota_netto'] : 0).'" />';
                echo '</td>';

                // stawka vat
                echo '<td>';
                    echo '<input class="stawka_vat" name="stawka_vat[]" type="text" value="'.(isset($pozycja['stawka_vat']) ? $pozycja['stawka_vat'] : 0).'" />';
                echo '</td>';

                // kwota podatku
                echo '<td>';
                    echo '<input class="kwota_podatku" name="kwota_podatku[]" type="text" value="'.(isset($pozycja['kwota_podatku']) ? $pozycja['kwota_podatku'] : 0).'" />';
                echo '</td>';

                // kwota brutto
                echo '<td>';
                    echo '<input class="kwota_brutto" name="kwota_brutto[]" type="text" value="'.(isset($pozycja['kwota_brutto']) ? $pozycja['kwota_brutto'] : 0).'" />';
                echo '</td>';

                echo '<td><table border="0" cellpadding="0" cellspacing="5" class="tabela_prowizji">';

                // partner 1
                echo '<tr>';
                echo '<td>Partner 1</td>';
                echo '<td>';
                    echo '<select name="prowizja_id_partnera_1[]">';
                        echo '<option value="0">Brak</option>';
                    foreach($partnerzy as $partner){
                        $selected = 0;
                        if($partner['id_partnera'] == (isset($pozycja['prowizja_id_partnera_1']) ? $pozycja['prowizja_id_partnera_1'] : $faktura['prowizja_id_partnera_1'])) $selected = 1;
                        echo '<option ';
                        if($selected) echo 'selected="selected" ';
                        echo 'value="'.$partner['id_partnera'].'">'.$partner['nazwa'].'</option>';
                    }
                    echo '</select>';
                echo '</td>';

                // partner 1 prowizja
                echo '<td>';
                    echo '<input name="prowizja_partnera_1[]" class="prowizja_partnera_1" type="text" value="'.(isset($pozycja['prowizja_partnera_1']) ? $pozycja['prowizja_partnera_1'] : $faktura['prowizja_partnera_1']).'" />';
                echo '</td>';

                // partner 1 prowizja próg
                echo '<td>';
                    echo '<input name="prowizja_partnera_1_prog[]" class="prowizja_partnera_1_prog" type="text" value="'.(isset($pozycja['prowizja_partnera_1_prog']) ? $pozycja['prowizja_partnera_1_prog'] : $faktura['prowizja_partnera_1_prog']).'" />';
                    echo '<input class="prowizja_partnera_1_zrzut" type="hidden" value="0" />';
                echo '</td>';

                echo '</tr>';

                // partner 2
                echo '<tr>';

                echo '<td>Partner 2</td>';

                echo '<td>';
                    echo '<select name="prowizja_id_partnera_2[]">';
                        echo '<option value="0">Brak</option>';
                    foreach($partnerzy as $partner){
                        $selected = 0;
                        if($partner['id_partnera'] == (isset($pozycja['prowizja_id_partnera_2']) ? $pozycja['prowizja_id_partnera_2'] : $faktura['prowizja_id_partnera_2'])) $selected = 1;
                        echo '<option ';
                        if($selected) echo 'selected="selected" ';
                        echo 'value="'.$partner['id_partnera'].'">'.$partner['nazwa'].'</option>';
                    }
                    echo '</select>';
                echo '</td>';

                // partner 2 prowizja
                echo '<td>';
                    echo '<input name="prowizja_partnera_2[]" class="prowizja_partnera_2" type="text" value="'.(isset($pozycja['prowizja_partnera_2']) ? $pozycja['prowizja_partnera_2'] : $faktura['prowizja_partnera_2']).'" />';
                echo '</td>';

                // partner 2 prowizja próg
                echo '<td>';
                    echo '<input name="prowizja_partnera_2_prog[]" class="prowizja_partnera_2_prog" type="text" value="'.(isset($pozycja['prowizja_partnera_2_prog']) ? $pozycja['prowizja_partnera_2_prog'] : $faktura['prowizja_partnera_2_prog']).'" />';
                    echo '<input class="prowizja_partnera_2_zrzut" type="hidden" value="0" />';
                echo '</td>';

                echo '</tr>';

                // wynagrodzenie wykonawcy
                echo '<tr>';

                echo '<td>Wykonawca</td>';

                echo '<td>';
                    echo '<select name="wynagrodzenie_wykonawcy_id_partnera[]">';
                        echo '<option value="0">Brak</option>';
                    foreach($partnerzy as $partner){
                        $selected = 0;
                        if($partner['id_partnera'] == (isset($pozycja['wynagrodzenie_wykonawcy_id_partnera']) ? $pozycja['wynagrodzenie_wykonawcy_id_partnera'] : '')) $selected = 1;
                        echo '<option ';
                        if($selected) echo 'selected="selected" ';
                        echo 'value="'.$partner['id_partnera'].'">'.$partner['nazwa'].'</option>';
                    }
                    echo '</select>';
                echo '</td>';

                // wykonawca wynagrodzenie
                echo '<td colspan="2">';
                    echo '<input name="wynagrodzenie_wykonawcy_kwota[]" type="text" value="'.(isset($pozycja['wynagrodzenie_wykonawcy_kwota']) ? $pozycja['wynagrodzenie_wykonawcy_kwota'] : 0).'" />';
                echo '</td>';

                echo '</tr>';
                
                echo '</table></td>';

                // usuń
                echo '<td>';
                echo '<a href="#" class="usun_wiersz"><img alt="" class="floatLeft" src="'.url::base().'/inc/cms/img/crystalClear/20/delete.gif" /></a>';
                echo '</td>';
            echo '</tr>';
        }
    }
    echo '</tbody></table></div>';

    forms::line(0);

    $formy_zaplaty = array();
    $formy_zaplaty[] = array('nazwa' => 'Przelew');
    $formy_zaplaty[] = array('nazwa' => 'Gotówka');

    forms::select(array('data' => $formy_zaplaty,
                        'fieldClass' => 'widthQuarter',
                        'label' => 'Wybierz formę zapłaty',
                        'labels' => 'nazwa',
                        'name' => 'forma_zaplaty',
                        'required' => 1,
                        'value' => isset($faktura['forma_zaplaty']) ? $faktura['forma_zaplaty'] : 'Przelew',
                        'values' => 'nazwa'));

    if(!$proforma){
        forms::checkbox(array('checked' => isset($faktura['zaliczka']) ? $faktura['zaliczka'] : 0,
                              'fieldClass' => 'widthQuarter',
                              'label' => 'Faktura zaliczkowa',
                              'name' => 'zaliczka'));

        if($faktury_zaliczkowe = $this -> load -> model('faktury') -> lista_faktur_zaliczkowych_dla_klienta($klient['id_klienta'])){
            $f = array();
            $i = 0;
            foreach($faktury_zaliczkowe as $faktura_zaliczkowa){
                $f[$i] = $faktura_zaliczkowa;
                $f[$i]['nazwa'] = texts::numer_faktury($faktura_zaliczkowa).' z dnia '.texts::nice_date($faktura_zaliczkowa['data_wystawienia']).', Kwota brutto: '.$faktura_zaliczkowa['kwota_brutto'].' zł';
                $i++;
            }
            $faktury_zaliczkowe = $f;

            forms::select(array('data' => $faktury_zaliczkowe,
                                'default' => 'Wybierz...',
                                'fieldClass' => 'widthQuarter',
                                'label' => 'Faktura końcowa dla faktury',
                                'labels' => 'nazwa',
                                'name' => 'id_faktury_zaliczkowej',
                                'required' => 1,
                                'subLabel' => 'Wybierz w przypadku, gdy wystawiasz fakturę końcową dla klienta, który wcześniej otrzymał fakturę zaliczkową.',
                                'value' => isset($faktura['id_faktury_zaliczkowej']) ? $faktura['id_faktury_zaliczkowej'] : 0,
                                'values' => 'id_faktury'));
        }
    }

    forms::line(0);

    forms::title(array('title' => 'Adnotacje'));

    forms::textarea(array('name' => 'adnotacje',
                          'value' => isset($faktura['adnotacje']) ? $faktura['adnotacje'] : ''));

    forms::submit(array('keepEditing' => 1));

    forms::close(0);

?>
<script type="text/javascript">
    <!--
    $(document).ready(function(){
        <?php if(!isset($faktura['pozycje'])){ ?>
        dodaj_wiersz();
        <?php } ?>



		$('#anuluj_b').click(function(){
				$('#pozycjonowanie_popup').addClass('hidden');
    		});

        // dodawanie wiersza
        $('#dodaj_wiersz').click(function(){
            dodaj_wiersz();
            
            return false;
        });

        function dodaj_wiersz(){
            $('#faktura_uslugi tbody:first').append(row);
            usuwanie();
            nasluchuj();
        }

        // usuwanie wiersza
        function usuwanie(){
            $('.usun_wiersz').click(function(){
                if($('.usun_wiersz').size() > 1) $(this).parent().parent().remove();
                przelicz($(this).parent().parent());
                return false;
            });
        }
        usuwanie();


        function nasluchuj(){
            $('.id_towaru_lub_uslugi, .tytul, .jednostka_miary, .pkwiu, .cena_netto, .ilosc, .kwota_netto, .stawka_vat, .kwota_podatku, .kwota_brutto, .prowizja_partnera_1, .prowizja_partnera_1_prog, .prowizja_partnera_2, .prowizja_partnera_2_prog').change(function(){
                przelicz($(this).parent().parent());
            });

            $('.cena_netto').click(function() {
                
            	var towar = $(this).parent().parent().find('.id_towaru_lub_uslugi').val();

				var retTarget = $(this);
                
                if(towar == 1) {
            		$('#pozycjonowanie_popup').removeClass('hidden');
            		
            		$('#wylicz_b').click(function() {
                		var id_klienta = <?php echo $klient['id_klienta'] ?>;

                		var t10od = $('#data_top10_odId').val();
                		var t10do = $('#data_top10_doId').val();
                		
            			wycenFrazy(t10od, t10do, id_klienta, retTarget);

            		});
            		
            	}

            });                
        }
        nasluchuj();

        $('.cena_netto').each(function(){
            przelicz($(this).parent().parent());
        });
    });
    
    function wycenFrazy(t10od, t10do, id_klienta, target) {
        $('#dropbox').load('/wycenfrazy.php?id_klienta='+id_klienta+'&od='+t10od+'&do='+t10do,
                function () {
        	$('#pozycjonowanie_popup').addClass('hidden');
        	var razem = $('#dropbox').html();
            
            target.val(razem);
            przelicz(target.parent().parent());
        });

        
    }

    function przelicz(el){
        var parametry = el.find('.id_towaru_lub_uslugi option:selected').attr('rel').split('|');
        var stawka_podatku = parametry[0];
        var jednostka_miary = parametry[1];
        var pkwiu = parametry[2];
        var cena_netto = round_float(el.find('.cena_netto').val(), 2);
        var kwota_netto = round_float(el.find('.ilosc').val() * cena_netto, 2);
        var kwota_podatku = round_float(parseFloat(kwota_netto) * (parseFloat(stawka_podatku) / 100), 2);
        var kwota_brutto = round_float(parseFloat(kwota_netto) + parseFloat(kwota_podatku), 2);

        // prowizje
        var w_1 = wylicz_prowizje(kwota_netto, el.find('.prowizja_partnera_1').val(), el.find('.prowizja_partnera_1_prog').val());
        el.find('.prowizja_partnera_1_zrzut').val(w_1);

        var w_2 = wylicz_prowizje(kwota_netto, el.find('.prowizja_partnera_2').val(), el.find('.prowizja_partnera_2_prog').val());
        el.find('.prowizja_partnera_2_zrzut').val(w_2);

        //console.debug(w_1, w_2);

        // zapis
        el.find('.jednostka_miary').val(jednostka_miary);
        el.find('.pkwiu').val(pkwiu);
        el.find('.stawka_vat').val(stawka_podatku ? stawka_podatku : 0);
        el.find('.cena_netto').val(cena_netto ? cena_netto : 0);
        el.find('.kwota_netto').val(kwota_netto ? kwota_netto : 0);
        el.find('.kwota_podatku').val(kwota_podatku ? kwota_podatku : 0);
        el.find('.kwota_brutto').val(kwota_brutto ? kwota_brutto : 0);

        podlicz_wszystkie_prowizje();
    }

    function round_float(x,n){
      if(!parseInt(n))
      	var n=0;
      if(!parseFloat(x))
      	return false;
      return Math.round(x*Math.pow(10,n))/Math.pow(10,n);
    }

    function wylicz_prowizje(kwota_netto, procent, prog){
        //console.debug(kwota_netto, procent, prog);
        if(prog == 0 && procent == 0){
            return 0;
        }else if(prog == 0){
            return round_float(parseFloat(kwota_netto) * (parseFloat(procent) / 100), 2);
        }else{
            if(parseFloat(kwota_netto) <= parseFloat(prog)) return round_float(parseFloat(kwota_netto) * (parseFloat(procent) / 100), 2);
            else return round_float(parseFloat(100) + ((parseFloat(kwota_netto) - parseFloat(prog)) / 2), 2);
        }
    }

    function podlicz_wszystkie_prowizje(){                 
        var p_1 = 0;
        $('.prowizja_partnera_1_zrzut').each(function(){
            p_1 = parseFloat(p_1) + parseFloat($(this).val());
        });
        $('#partner_1_wyliczona_prowizja').html('<b>' + (p_1 ? round_float(p_1, 2) : 0) + '</b> zł');
        //console.debug(p_1);

        var p_2 = 0;
        $('.prowizja_partnera_2_zrzut').each(function(){
            p_2 = parseFloat(p_2) + parseFloat($(this).val());
        });
        $('#partner_2_wyliczona_prowizja').html('<b>' + (p_2 ? round_float(p_2, 2) : 0) + '</b> zł');
        //console.debug(p_2);
    }
    -->
</script>
<?php

    $this -> load -> view('footer');
?>