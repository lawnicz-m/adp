<?php
    forms::button(array('value' => 'Zamknij',
                        'link' => '#close_modal'));

    forms::title(array('title' => '"'.$klient['nazwa'].' " - notatki'));

    forms::itemsOpen(0);

    if($notatki){
        foreach($notatki as $notatka){
            forms::item(array('hideActive' => 1,
                              'hideEdit' => 1,
                              'hideDelete' => 1,
                              'icon' => 'arrow',
                              'id' => $notatka['id_notatki'],
                              'subTitle' => $notatka['tresc'],
                              'title' => texts::nice_date($notatka['data_utworzenia'])));
        }
    }

    forms::itemsClose(0);
?>