<?php

    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::button(array('value' => 'Utwórz umowę',
                        'link' => url::page(CONTROLLER.'/form/0/'.$klient['id_klienta'])));

    forms::title(array('title' => 'Umowy'));

    forms::itemsOpen(0);

    if($umowy){
        foreach($umowy as $umowa){
            $actions = array();

            $actions[] = array('icon' => url::page('inc/cms/img/crystalClear/35/pdf.gif'),
                               'label' => 'Pobierz PDF',
                               'link' => url::page(CONTROLLER.'/pobierz-pdf/'.$umowa['id_umowy']));

            $actions[] = array('icon' => url::page('inc/cms/img/crystalClear/35/edit.gif'),
                               'label' => 'Edytuj',
                               'link' => url::page(CONTROLLER.'/form/'.$umowa['id_umowy'].'/'.$klient['id_klienta']));

            $actions[] = array('icon' => url::page('inc/cms/img/crystalClear/35/delete.gif'),
                               'label' => 'Usuń',
                               'link' => url::page(CONTROLLER.'/usun/'.$umowa['id_umowy'].'/'.$klient['id_klienta']));

            forms::item(array('actions' => $actions,
                              'hideActive' => 1,
                              'hideEdit' => 1,
                              'hideDelete' => 1,
                              'icon' => 'agreement',
                              'id' => $umowa['id_umowy'],
                              'subTitle' => $umowa['nazwa'].'.pdf',
                              'title' => $umowa['numer']));
        }
    }

    forms::itemsClose(0);

    $this -> load -> view('footer');
?>