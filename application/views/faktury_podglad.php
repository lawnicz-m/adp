<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    if($uzytkownik['typ'] == 'admin'){
        forms::button(array('value' => 'Edytuj',
                            'link' => url::page(CONTROLLER.'/form/'.$faktura['id_faktury'].'/'.$faktura['id_klienta'])));

        if(!$faktura['status']){
            forms::button(array('value' => 'Potwierdź opłatę',
                                'link' => url::page(CONTROLLER.'/potwierdz-oplate/'.$faktura['id_faktury'].'/'.$faktura['id_klienta']),
                                'rel' => 'potwierdzenie',
                                'style' => 'background-color: red; float: left; text-shadow: 0 0 0;'));
        }

        if($linki['nastepna_faktura']){
            forms::button(array('value' => 'Następna &#187;',
                                'link' => url::page(CONTROLLER.'/podglad/'.$linki['nastepna_faktura']['id_faktury'].'/'.$linki['nastepna_faktura']['id_klienta'])));
        }

        if($linki['poprzednia_faktura']){
            forms::button(array('value' => '&#171; Poprzednia',
                                'link' => url::page(CONTROLLER.'/podglad/'.$linki['poprzednia_faktura']['id_faktury'].'/'.$linki['poprzednia_faktura']['id_klienta'])));
        }

    }

    forms::button(array('value' => '&#171; Powrót do faktur klienta',
                        'link' => url::page(CONTROLLER.'/klienta/'.$faktura['id_klienta'])));

?>
<div class="clear" style="height: 20px;"></div>
<div id="podglad_faktury_outer">
    <div id="podglad_faktury">
<?php
	$this -> load -> view('dokumenty/faktura', array('faktura' => $faktura,
	                                                 'faktura_zaliczkowa' => $faktura_zaliczkowa,
	                                                 'typ' => $typ));
?>
    </div>
</div>
<?php
    $this -> load -> view('footer');
?>