<?php
    forms::button(array('value' => 'Zamknij',
                        'link' => '#close_modal'));

    forms::title(array('title' => 'Historia wpłat'));

    if($historia_wplat){
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

        forms::title(array('title' => 'Suma wpłat: '.$suma_dotychczasowych_wplat.' zł'));
        $brakujaca_kwota = round($faktura['kwota_brutto'] - $suma_dotychczasowych_wplat, 2);
        if($brakujaca_kwota) forms::title(array('title' => 'Brakująca kwota: '.$brakujaca_kwota.' zł'));
    }else{
        echo 'Brak wpisów w historii.';
    }
?>