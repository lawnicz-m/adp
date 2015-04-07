<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::title(array('title' => 'Potwierdzenie opłacenia faktury '.texts::numer_faktury($faktura).' dla '.$klient['nazwa']));

    if($historia_wplat){
        forms::line(0);

        $brakujaca_kwota = round($faktura['kwota_brutto'] - $suma_dotychczasowych_wplat, 2);

        forms::title(array('title' => 'Suma wpłat: '.$suma_dotychczasowych_wplat.' zł'));
        forms::title(array('title' => 'Brakująca kwota: '.$brakujaca_kwota.' zł'));

        forms::line(0);

        forms::title(array('title' => 'Historia wpłat'));

        ?><table border="0" cellpadding="0" cellspacing="0" class="base" style="width: auto;">
            <tr>
                <th>Data wpłaty</th>
                <th>Kwota wpłaty</th>
                <th>Forma zapłaty</th>
                <th>Osoba pobierajacą gotówkę</th>
            </tr>
            <?php $i = 0; foreach($historia_wplat as $wpis){ ?>
            <tr class="<?php if(!$i){ ?>odd<?php } $i++; if($i == 2){ $i = 0; } ?>">
                <td><?php echo texts::nice_date($wpis['data_wplaty']);?></td>
                <td><?php echo $wpis['wplacona_kwota'];?> zł</td>
                <td><?php echo $wpis['forma_zaplaty'];?></td>
                <td><?php echo $wpis['osoba_pobierajaca_gotowke'];?></td>
            </tr>
            <?php } ?>
        </table><?php

        forms::line(0);
    }

    forms::open(array('action' => url::page(CONTROLLER.'/potwierdz-oplate-2/'.PARAM.'/'.PARAM_2)));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Data zapłaty',
                      'name' => 'data_zaplaty',
                      'required' => 1,
                      'value' => date("Y-m-d")));

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Wpłacona kwota',
                      'name' => 'wplacona_kwota',
                      'required' => 1,
                      'subLabel' => 'Kwota niższa niż kwota na fakturze spowoduje oznaczenie jej jako zapłaconej częściowo, a prowizje nie zostaną przelane na salda partnerów.',
                      'value' => isset($brakujaca_kwota) ? $brakujaca_kwota : $faktura['kwota_brutto']));

    $finalne_formy_zaplaty = array();
    $finalne_formy_zaplaty[] = array('nazwa' => 'Przelew');
    $finalne_formy_zaplaty[] = array('nazwa' => 'Gotówka');

    forms::select(array('data' => $finalne_formy_zaplaty,
                        'fieldClass' => 'widthQuarter',
                        'label' => 'Forma zapłaty',
                        'labels' => 'nazwa',
                        'name' => 'finalna_forma_zaplaty',
                        'values' => 'nazwa'));  

    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Osoba pobierająca gotówkę',
                      'name' => 'osoba_pobierajaca_gotowke',
                      'subLabel' => 'Wypełnij to pole w przypadku, gdy faktura jest opłacana gotówką.'));

    forms::submit(array('label' => 'Potwierdź'));

    forms::close(0);

    $this -> load -> view('footer');
?>