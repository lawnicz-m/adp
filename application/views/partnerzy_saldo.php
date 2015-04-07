<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    if($uzytkownik['typ'] == 'admin'){
        forms::button(array('value' => '&#171; Powrót',
                            'link' => url::page(CONTROLLER)));
    }

    forms::title(array('title' => $uzytkownik['typ'] == 'admin' ? 'Saldo partnera '.$partner['nazwa'] : 'Saldo'));

    ?><div class="text">Saldo aktualnie wynosi:<br /><br /><h2><?php echo number_format($partner['saldo'], 2, '.', ' ');?> zł</h2></div><?php

	if($uzytkownik['typ'] == 'admin'){
        forms::line(0);

        forms::title(array('title' => 'Wypłaty'));

        forms::open(array('action' => url::page(CONTROLLER.'/saldo/'.$partner['id_partnera'])));
		
        forms::text(array('fieldClass' => 'widthQuarter',
                          'label' => 'Podstawa obciążenia',
                          'name' => 'podstawa_obciazenia',
                          'required' => 1,
                          'value' => $podstawa_obciazenia));

        forms::text(array('fieldClass' => 'widthQuarter',
                          'label' => 'Kwota obciążenia (kwota NETTO)',
                          'name' => 'kwota_obciazenia',
                          'required' => 1,
                          'value' => $kwota_obciazenia));

        forms::submit(array('label' => 'Obciąż saldo'));

        forms::close(0);
    }
    if($historia_salda){
        forms::line(0);

        forms::title(array('title' => 'Historia'));

        ?><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-spacing: 0px;">
            <?php foreach($historia_salda as $wpis){ ?>
            <?php $kolor = $wpis['status'] == '+' ? 'green' : 'red'; ?>
            <tr>
                <td colspan="2"><hr /></td>
            </tr>
            <tr>
                <td style="color: <?php echo $kolor;?>; padding: 10px;"><?php echo $wpis['data_utworzenia'];?></td>
                <td style="color: <?php echo $kolor;?>; padding: 10px;">
                    <?php if($wpis['id_faktury'] && $uzytkownik['typ'] == 'admin'){ ?>
                        <a href="<?php echo url::page('faktury/podglad/'.$wpis['id_faktury'].'/'.$wpis['id_klienta']);?>" style="color: <?php echo $kolor;?>;"><?php echo $wpis['tresc'];?></a>
                    <?php }else{ ?>
                        <?php echo $wpis['tresc'];?>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </table><?php

    }

    

    $this -> load -> view('footer');
?>