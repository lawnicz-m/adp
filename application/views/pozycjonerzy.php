<?php if($uzytkownik['typ'] == 'admin' && $uzytkownik['id'] == '1'){
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::button(array('value' => 'Dodaj pozycjonera',
                        'link' => url::page(CONTROLLER.'/form/0')));

    forms::title(array('title' => 'Pozycjonerzy'));

    forms::itemsOpen(0);

    if($pozycjonerzy){
        foreach($pozycjonerzy as $pozycjoner){

            $actions = array();

            $actions[] = array('icon' => url::page('inc/cms/img/crystalClear/35/edit.gif'),
                               'label' => 'Edytuj',
                               'link' => url::page(CONTROLLER.'/form/'.$pozycjoner['id_pozycjonera']));

            forms::item(array('actions' => $actions,
                              'icon' => 'arrow',
                              'id' => $pozycjoner['id_pozycjonera'],
                              'subTitle' => 'ID: '.$pozycjoner['id_pozycjonera'].' &nbsp;&bull;&nbsp; Login: '.$pozycjoner['login'],
                              'title' => $pozycjoner['nazwa']));
        }
    }

    forms::itemsClose(0);

    $this -> load -> view('footer');
}
?>