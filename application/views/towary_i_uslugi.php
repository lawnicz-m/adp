<?php
if($uzytkownik['typ'] == 'admin' && $uzytkownik['id'] == '1' || $uzytkownik['id'] == '9'){
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::button(array('value' => 'Utwórz towar lub usługę',
                        'link' => url::page(CONTROLLER.'/form/0')));

    forms::title(array('title' => 'Towary i usługi'));

    forms::itemsOpen(0);

    if($towary_i_uslugi){
        foreach($towary_i_uslugi as $towar_lub_usluga){

            $actions = array();

            $actions[] = array('icon' => url::page('inc/cms/img/crystalClear/35/edit.gif'),
                               'label' => 'Edytuj',
                               'link' => url::page(CONTROLLER.'/form/'.$towar_lub_usluga['id_towaru_lub_uslugi']));

            forms::item(array('actions' => $actions,
                              'icon' => 'document',
                              'id' => $towar_lub_usluga['id_towaru_lub_uslugi'],
                              'subTitle' => 'ID: '.$towar_lub_usluga['id_towaru_lub_uslugi'].' &nbsp;&bull;&nbsp; Jednostka miary: '.$towar_lub_usluga['jednostka_miary'].' &nbsp;&bull;&nbsp; PKWiU: '.$towar_lub_usluga['pkwiu'].' &nbsp;&bull;&nbsp; Stawka VAT: '.$towar_lub_usluga['stawka_vat'],
                              'title' => $towar_lub_usluga['nazwa']));
        }
    }

    forms::itemsClose(0);

    $this -> load -> view('footer');
}
?>