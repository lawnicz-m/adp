<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));
	$acl = $this -> acl -> get('acl_frazy');
    forms::title(array('title' => 'Dodaj notatkę'));
    forms::open(array('action' => url::page(CONTROLLER.'/zapisz/'.PARAM)));
	$notatka['tresc'] .= date("H:i").', ';
	$notatka['tresc'] .= $uzytkownik['nazwa'].'  Treść :    	  ';
    forms::textarea(array('fieldClass' => 'widthHalf',
                          'label' => 'Treść',
                          'name' => 'tresc',
                          'required' => 1,
						  'value' => $notatka['tresc']));
    ?><div class="clear"></div><?php
	$read_only = 1;
	forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Data następnego kontaktu',
                      'name' => 'data_nastepnego_kontaktu',
                      'value' => $klient['data_nastepnego_kontaktu'] ? $klient['data_nastepnego_kontaktu'] : date("Y-m-d")));
    forms::text(array('fieldClass' => 'widthQuarter',
                      'label' => 'Data utworzenia notatki',
                      'name' => 'data_utworzenia',
                      'readOnly' => $read_only,
                      'value' => $notatka['data_utworzenia'] ? $notatka['data_utworzenia'] : date("Y-m-d")));
	forms::checkbox(array('fieldClass' => 'width_20','label' => 'nozbe handlowiec','name' => 'mailnozbe_handl'));
	forms::checkbox(array('fieldClass' => 'width_20','label' => 'nozbe techniczny','name' => 'mailnozbe_techn'));
	forms::checkbox(array('fieldClass' => 'width_20','label' => 'nozbe copywriter','name' => 'mailnozbe_copywriter'));
	forms::submit(0);
    forms::close(0);
	/*?><div class="clear"></div><?php
	$email['temat'] = 'ADP Poland Sp. z o.o. Pozycjonowanie - W sprawie: ';
	forms::title(array('title' => 'Wyślij e-mail do Klienta'));
    forms::open(array('action' => url::page('frazy/wyslij_email/'.PARAM)));
	forms::text(array('fieldClass' => 'widthHalf',
                      'label' => 'Temat e-maila',
                      'name' => 'temat',
					  'value' => $email['temat']));
	?><div class="clear"></div><?php
    forms::textarea(array('fieldClass' => 'widthHalf',
                          'label' => 'Treść e-maila',
                          'name' => 'tresc_email',
                          'required' => 1));
    ?><div class="clear"></div><?php
	forms::hidden(array('name' => 'data_utworzenia',
                        'value' => $notatka['data_utworzenia'] ? $notatka['data_utworzenia'] : date("Y-m-d")));
	
	forms::submit(array('label' => 'Wyślij E-Mail do Klienta'));
    forms::close(0);*/
		
    $this -> load -> view('footer');
?>