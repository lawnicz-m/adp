<?php
if($uzytkownik['typ'] == 'admin' && ($uzytkownik['id'] == '1' || $uzytkownik['id'] == '10')){
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::button(array('value' => 'Dodaj admina',
                        'link' => url::page(CONTROLLER.'/form/0')));

    forms::title(array('title' => 'Admini'));

    forms::itemsOpen(0);

    if($admini){
        foreach($admini as $admin){

            $actions = array();

            $actions[] = array('icon' => url::page('inc/cms/img/crystalClear/35/edit.gif'),
                               'label' => 'Edytuj',
                               'link' => url::page(CONTROLLER.'/form/'.$admin['id_admina']));

            forms::item(array('actions' => $actions,
                              'icon' => 'arrow',
                              'id' => $admin['id_admina'],
                              'subTitle' => 'ID: '.$admin['id_admina'].' &nbsp;&bull;&nbsp; Login: '.$admin['login'],
                              'title' => $admin['nazwa']));
        }
    }

    forms::itemsClose(0);

    $this -> load -> view('footer');
}
?>