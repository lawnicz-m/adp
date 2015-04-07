<?php
    $acl = $this -> acl -> get('acl_frazy');

    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    if($acl -> is_allowed($uzytkownik['typ'], 'dodaj_fraze_etap_'.$klient['etap'])){
        forms::button(array('value' => 'Dodaj jedną frazę',
                            'link' => url::page(CONTROLLER.'/form/0/'.$klient['id_klienta'])));

        forms::button(array('value' => 'Dodaj wiele fraz',
                            'link' => url::page(CONTROLLER.'/form-kilka/'.$klient['id_klienta'])));
    }

    if($acl -> is_allowed($uzytkownik['typ'], 'skasuj_wycene_etap_'.$klient['etap'])){
        forms::button(array('value' => 'Skasuj wycenę',
                            'link' => url::page(CONTROLLER.'/skasuj-wycene/'.$klient['id_klienta'])));
    }

    if($acl -> is_allowed($uzytkownik['typ'], 'anuluj_prosbe_o_wycene_etap_'.$klient['etap'])){
        forms::button(array('value' => 'Anuluj test',
                            'link' => url::page(CONTROLLER.'/anuluj-prosbe-o-wycene/'.$klient['id_klienta'])));
    }
	

    if($acl -> is_allowed($uzytkownik['typ'], 'popros_o_rozpoczecie_etap_'.$klient['etap'])){
        forms::button(array('value' => 'Klient po teście zrezygnował',
                            'link' => url::page(CONTROLLER.'/popros-o-rozpoczecie/'.$klient['id_klienta'])));
    }
	
    if($klient['etap']!='5' && $klient['etap']!='6' && ($uzytkownik['id']=='9' || $uzytkownik['id']=='1')){
        forms::button(array('value' => 'Klient podpisał umowę',
                            'link' => url::page(CONTROLLER.'/rozpocznij/'.$klient['id_klienta'])));
    }

    if($acl -> is_allowed($uzytkownik['typ'], 'zawies_etap_'.$klient['etap'])){
        forms::button(array('value' => 'Zawieś pozycjonowanie',
                            'link' => url::page(CONTROLLER.'/zawies/'.$klient['id_klienta'])));
    }

    if($acl -> is_allowed($uzytkownik['typ'], 'wznow_etap_'.$klient['etap'])){
        forms::button(array('value' => 'Wznów pozycjonowanie',
                            'link' => url::page(CONTROLLER.'/wznow/'.$klient['id_klienta'])));
    }
	if($klient['etap']=='5' && $uzytkownik['typ']==admin && $uzytkownik['id']=='1' || $uzytkownik['id']=='9'){
	forms::button(array('value' => 'Mail rozpoczęcie pozycjonowania',
                            'link' => url::page('ciec/wyslij_email_do_ciecia/'.$klient['id_klienta'])));
	}
	
	if($acl -> is_allowed($uzytkownik['typ'], 'generuj_pary')) {
		forms::button(array('value' => 'Generuj pary',
		'link' => url::page(CONTROLLER.'/genpairs/'.$klient['id_klienta']),
		'target' => 'blank'
		));
	}
	
    forms::title(array('title' => 'Frazy ('.($frazy ? count($frazy) : 0).')'));

    forms::itemsOpen(0);

    if($frazy){
        $typy = $this -> load -> model('frazy') -> typy();
        $frazy_ryczaltowe = 0;

        foreach($frazy as $fraza){
            $actions = array();

            if($acl -> is_allowed($uzytkownik['typ'], 'edytuj_fraze_etap_'.$klient['etap'])){
                $actions[] = array('icon' => url::page('inc/cms/img/crystalClear/35/edit.gif'),
                                   'label' => 'Edytuj',
                                   'link' => url::page(CONTROLLER.'/form/'.$fraza['id_frazy'].'/'.$klient['id_klienta']));
            }

            if($acl -> is_allowed($uzytkownik['typ'], 'usun_fraze_etap_'.$klient['etap'])){
                $actions[] = array('icon' => url::page('inc/cms/img/crystalClear/35/delete.gif'),
                                   'label' => 'Usuń',
                                   'link' => url::page(CONTROLLER.'/usun/'.$fraza['id_frazy'].'/'.$klient['id_klienta']));
            }
            $pod_tytul = '';
            $pod_tytul .= '<div style="float: left;">';
            $pod_tytul .= 'Typ pozycjonowania: <b style="color: #333;">'.$typy[$fraza['typ']].'</b>';
            $pod_tytul .= '<br />';
            if($fraza['typ'] == 2){
                $frazy_ryczaltowe++;
                $pod_tytul .= 'Link: <a href="'.$fraza['fraza_link'].'" rel="external">'.$fraza['fraza_link'].'</a>&nbsp;<br />';
                $pod_tytul .= 'Kwota za wszystkie frazy ryczałtowe: <b style="color: #333;">'.$klient['kwota_ryczaltu'].' zł</b>';
            }else{
                $pod_tytul .= 'Link: <a href="'.$fraza['fraza_link'].'" rel="external">'.$fraza['fraza_link'].'</a>';
                $pod_tytul .= '<br />';
                $pod_tytul .= 'Kwota dla klienta: <b style="color: #333;">'.$fraza['kwota_za_fraze'].' zł</b>';
            }
            $pod_tytul .= '</div>';
            if($fraza['typ'] == 1 && $fraza['kwota_za_fraze'] > 0){
                $pod_tytul .= '<div style="float: left; margin: 0 0 0 40px;">';

                $pod_tytul .= '<table border="1" cellpadding="3" cellspacing="0" style="border-collapse: collapse; width: 300px;">';
                $pod_tytul .= '<tr>';
                $pod_tytul .= '<td class="center" style="width: 100px;">'.$klient['top_10_1_od'].'-'.$klient['top_10_1_do'].'</td>';
                if($klient['top_10_2_od'] && $klient['top_10_2_do']) $pod_tytul .= '<td class="center" style="width: 100px;">'.$klient['top_10_2_od'].'-'.$klient['top_10_2_do'].'</td>';
                if($klient['top_10_3_od'] && $klient['top_10_3_do']) $pod_tytul .= '<td class="center" style="width: 100px;">'.$klient['top_10_3_od'].'-'.$klient['top_10_3_do'].'</td>';
			

                                        
				
                $pod_tytul .= '<td>pierwsza strona</td>';
				$pod_tytul .= '<td><a class="noCover" href="http://www.google.pl/search?hl=pl&amp;q='.$fraza['nazwa'].'&start='.$start.'">pozycja</a></td>';
                $pod_tytul .= '</tr>';
                
                $kwota_top10_1 = 0;
                $kwota_top10_2 = 0;
                $kwota_top10_3 = 0;
                
              
                if($fraza['top10_procentowo']) {
                	$kwota_top10_1 = $fraza['kwota_za_fraze'] * $fraza['top10_1_kwota'] / 100;
                	$kwota_top10_2 = $fraza['kwota_za_fraze'] * $fraza['top10_2_kwota'] / 100;
                	$kwota_top10_3 = $fraza['kwota_za_fraze'] * $fraza['top10_3_kwota'] / 100;
                } else {
                	$kwota_top10_1 = $fraza['top10_1_kwota'];
                	$kwota_top10_2 = $fraza['top10_2_kwota'];
                	$kwota_top10_3 = $fraza['top10_3_kwota'];
                }
                
                
                $pod_tytul .= '<tr>';
                $pod_tytul .= '<td class="center" style="width: 100px;">'.round($kwota_top10_1).' zł</td>';
                if($klient['top_10_2_od'] && $klient['top_10_2_do']) $pod_tytul .= '<td class="center" style="width: 100px;">'.round($kwota_top10_2).' zł</td>';
                if($klient['top_10_3_od'] && $klient['top_10_3_do']) $pod_tytul .= '<td class="center" style="width: 100px;">'.round($kwota_top10_3).' zł</td>';
                if($fraza['top10_pierwsza_strona']) {
                	$pod_tytul .= '<td>TAK</td>';
                } else {
                	$pod_tytul .= '<td>NIE</td>';
                }
                $pod_tytul .= '</tr>';
                $pod_tytul .= '</table>';

                $pod_tytul .= '</div>';
            }

            $frazeczka= "<a href=\"https://www.google.pl/search?site=&source=hp&q=site%3A".$klient['adres_strony']."+".$fraza['nazwa']."\" target=\"_blank\">".$fraza['nazwa']."</a>";

            forms::item(array('actions' => $actions,
                              'hideActive' => 1,
                              'hideEdit' => 1,
                              'hideDelete' => 1,
                              'icon' => 'arrow',
                              'id' => $fraza['id_frazy'],
                              'subTitle' => $pod_tytul,
                              'title' => $frazeczka));
        }
    }

    forms::itemsClose(0);


    if($frazy){
        // ryczałt
        ?><div class="text" style="padding-top: 0;"><?php

        if($acl -> is_allowed($uzytkownik['typ'], 'popros_o_wycene_etap_'.$klient['etap'])) forms::open(array('action' => url::page(CONTROLLER.'/popros-o-wycene/'.PARAM)));
        if($acl -> is_allowed($uzytkownik['typ'], 'zatwierdz_wycene_etap_'.$klient['etap'])) forms::open(array('action' => url::page(CONTROLLER.'/zatwierdz-wycene/'.PARAM)));
        if($acl -> is_allowed($uzytkownik['typ'], 'zapisz_wycene_etap_'.$klient['etap'])) forms::open(array('action' => url::page(CONTROLLER.'/zapisz-wycene/'.PARAM)));
  
        if($frazy_ryczaltowe){

            forms::line(0);

            forms::title(array('title' => 'Ryczałt'));

            forms::text(array('fieldClass' => 'widthQuarter',
                              'label' => 'Oficjalna kwota ryczałtu dla klienta [w zł]',
                              'name' => 'kwota_ryczaltu',
                              'value' => $klient['kwota_ryczaltu']));
			
        }
		forms::text(array('fieldClass' => 'widthQuarter',
                              'label' => 'Max potencjalna kwota TOP lub kwota limitu',
                              'name' => 'top_max',
                              'value' => $klient['top_max']));
		forms::submit(array('label' => 'Zapisz/Popraw wycenę'));
        if($acl -> is_allowed($uzytkownik['typ'], 'popros_o_wycene_etap_'.$klient['etap'])) forms::submit(array('label' => 'Rozpocznij test'));
        if($acl -> is_allowed($uzytkownik['typ'], 'zatwierdz_wycene_etap_'.$klient['etap'])) forms::submit(array('label' => 'Zakończ test'));
        

        forms::close(0);
		
        ?></div><?php
	    }
		forms::button(array('value' => 'Usuń info o grupie GL',
                            'link' => url::page('gl/usun_nfo_grupa_gl/'.$klient['id_klienta'])));
		forms::button(array('value' => 'Na etap Usługi',
                            'link' => url::page('frazy/na_uslugi/'.$klient['id_klienta'])));
		forms::button(array('value' => 'Klient dla Handlowca',
                            'link' => url::page('frazy/dla_handlowca/'.$klient['id_klienta'])));
if($klient['etap']!='5' &&  $uzytkownik['id']=='1'){
							forms::button(array('value' => 'Na etap Pozycjonowanie',
                          'link' => url::page('frazy/podpisz_umowe/'.$klient['id_klienta'])));}
		forms::button(array('value' => 'Na etap Po Teście',
                            'link' => url::page('frazy/zakoncz_bez_testu/'.$klient['id_klienta'])));
		forms::button(array('value' => 'Na etap Nowy Klient',
                            'link' => url::page('frazy/od_nowa/'.$klient['id_klienta'])));
		forms::button(array('value' => 'Weź spierdalaj',
                            'link' => url::page('wypierdalaj.swf'),
							'rel' => 'external'));
    $this -> load -> view('footer');
?>