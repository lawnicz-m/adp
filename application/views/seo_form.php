<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));
    
	$key = "bWaIvexnHHMj9J1E62Kd";
  	$method = "cast5-cfb";
    $cms_login = $klient['cms_login'];
    $decrypted_cms_login = openssl_decrypt($cms_login, $method, $key);
    $cms_haslo = $klient['cms_haslo'];
    $decrypted_cms_haslo = openssl_decrypt($cms_haslo, $method, $key);
    $ftp_login = $klient['ftp_login'];
    $decrypted_ftp_login = openssl_decrypt($ftp_login, $method, $key);
    $ftp_haslo = $klient['ftp_haslo'];
    $decrypted_ftp_haslo = openssl_decrypt($ftp_haslo, $method, $key);
    $pozycjonerzy = $this -> load -> model('pozycjonerzy');
	$pozycjoner = $pozycjonerzy -> jeden($klient['id_pozycjonera']);
			
	forms::title(array('title' => 'Dane klienta'));
	forms::open(array('action' => url::page('seo/zapisz/'.PARAM)));?>
		
		<table border="0" cellpadding="50" cellspacing="1" id="dane_klienta" style="width: 100%;">
			<tr>
				<td style="vertical-align: top; width: 33%;">Nazwa klienta:<br /><b><?php echo $klient['nazwa'];?></b></td>
				<td style="vertical-align: top; width: 34%;">Nazwa strony:<br /><b><a href="http://<?php echo $klient['adres_strony'];?>" rel="external"><?php echo $klient['adres_strony'];?></a></b></td>
				<td style="vertical-align: top; width: 33%;">"informatyk":<br /><b><?php echo $pozycjoner['nazwa'];?></a></b></td>
			</tr>
		</table>
		<?php
forms::line(0);
forms::line(0);
forms::checkbox(array('checked' => $klient['reczna_filtr'],
                          'fieldClass' => 'width_20',
                          'label' => 'Ręczna lub Filtr?',
                          'name' => 'reczna_filtr'));
forms::line(0);
forms::line(0);

forms::checkbox(array('checked' => $klient['katalogi'],
                          'fieldClass' => 'width_20',
                          'label' => 'Zakatalogowany ?',
                          'name' => 'katalogi'));
						  
forms::text(array('fieldClass' => 'width_10',
                      'label' => 'Katalogi od:',
                      'name' => 'data_katalogi_start',
                      'value' => $klient['data_katalogi_start']));
					  
forms::text(array('fieldClass' => 'width_10',
                      'label' => 'Katalogi do:',
                      'name' => 'data_katalogi_end',
                      'value' => $klient['data_katalogi_end']));
						  
						  

forms::line(0);

forms::checkbox(array('checked' => $klient['SWL'],
                          'fieldClass' => 'width_20',
                          'label' => 'SWL ?',
                          'name' => 'SWL'));
						  
forms::text(array('fieldClass' => 'width_10',
                      'label' => 'SWL od:',
                      'name' => 'data_SWL_start',
                      'value' => $klient['data_SWL_start']));
					  
forms::text(array('fieldClass' => 'width_10',
                      'label' => 'SWL do:',
                      'name' => 'data_SWL_end',
                      'value' => $klient['data_SWL_end']));
						  
forms::line(0);

forms::checkbox(array('checked' => $klient['zaplecza'],
                          'fieldClass' => 'width_20',
                          'label' => 'Zaplecza ?',
                          'name' => 'zaplecza'));

forms::text(array('fieldClass' => 'width_10',
                      'label' => 'Zaplecza od:',
                      'name' => 'data_zaplecza',
                      'value' => $klient['data_zaplecza']));
					  
forms::text(array('fieldClass' => 'width_10',
                          'label' => 'Numer fali:',
                          'name' => 'zaplecza_fala',
						  'value' => $klient['zaplecza_fala']));
						  
forms::line(0);
   
forms::line(0);

	forms::checkbox(array('checked' => $klient['dostepy'],
                          'fieldClass' => 'width_20',
                          'label' => 'Dostęp FTP?',
                          'name' => 'dostepy'));
	
	forms::checkbox(array('checked' => $klient['dostepy_cms'],
                          'fieldClass' => 'width_20',
                          'label' => 'Dostęp CMS?',
                          'name' => 'dostepy_cms'));
	
	forms::checkbox(array('checked' => $klient['niebonie'],
                          'fieldClass' => 'width_20',
                          'label' => 'Nie, bo nie?',
                          'name' => 'niebonie'));
	
forms::line(0);
forms::line(0);
	forms::text(array('fieldClass' => 'width_10',
                          'label' => 'Data OPT TECH',
                          'name' => 'opt_data',
						  'value' => $klient['opt_data']));
	forms::checkbox(array('checked' => $klient['optymalizacja'],
                          'fieldClass' => 'width_20',
                          'label' => 'OPT Techniczna?',
                          'name' => 'optymalizacja'));
	
	forms::text(array('fieldClass' => 'width_10',
                          'label' => 'Data OPT META',
                          'name' => 'opt_meta_data',
						  'value' => $klient['opt_meta_data']));
						  
	
	forms::checkbox(array('checked' => $klient['opt_meta'],
                          'fieldClass' => 'width_20',
                          'label' => 'OPT META?',
                          'name' => 'opt_meta'));
	

	
	forms::checkbox(array('checked' => $klient['poprawa'],
                          'fieldClass' => 'width_20',
                          'label' => 'Nieznany PROBLEM?',
                          'name' => 'poprawa'));

forms::line(0);		
forms::line(0);				  
						  
    forms::checkbox(array('checked' => $klient['google_ana'],
                          'fieldClass' => 'width_20',
                          'label' => 'Google Analytics',
                          'name' => 'google_ana'));
						  
    forms::checkbox(array('checked' => $klient['web_tool'],
                          'fieldClass' => 'width_20',
                          'label' => 'Google Webmaster Tools',
                          'name' => 'web_tool'));
	
	forms::text(array(	'fieldClass' => 'width_40',
                          'label' => 'Adres mapki w tych Gugielach',
                          'name' => 'google_mapa',
						  'value' => $klient['google_mapa']));

forms::line(0);		
forms::line(0);				  
    
	forms::checkbox(array('checked' => $klient['teksty'],
                          'fieldClass' => 'width_20',
                          'label' => 'Teksty do wymiany?',
                          'name' => 'teksty'));
						  
	forms::text(array(	'fieldClass' => 'width_40',
                          'label' => 'Link do CS:',
                          'name' => 'cs_link',
						  'value' => $klient['cs_link']));
						  
	forms::text(array(  'fieldClass' => 'width_10',
                          'label' => 'Data zrobienia CS',
                          'name' => 'cs_data',
						  'value' => $klient['cs_data']));
						  
	forms::line(0);
	
	forms::checkbox(array('checked' => $klient['host_zly'],
                          'fieldClass' => 'width_20',
                          'label' => 'Hosting do dupy?',
                          'name' => 'host_zly'));
	forms::checkbox(array('checked' => $klient['strona_zla'],
                          'fieldClass' => 'width_20',
                          'label' => 'Strona całkiem zła?',
                          'name' => 'strona_zla'));
	forms::checkbox(array('checked' => $klient['strona_popr'],
                          'fieldClass' => 'width_20',
                          'label' => 'Strona do odpłatnej poprawy?',
                          'name' => 'strona_popr'));
	forms::line(0);
    forms::line(0);                      
	forms::title(array('title' => 'Dane strony klienta'));
    ?>
    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
    <tr>
    <td style="vertical-align: top; width: 50%;"><h3 style="margin: 0 0 0 5px;">CMS</h3>
	<?php

    forms::text(array('label' => 'Adres CMSa',
                      'name' => 'cms_adres',
                      'value' => $klient['cms_adres']));
               
    forms::text(array('label' => 'Login do CMSa',
                      'name' => 'cms_login',
                      'value' => $decrypted_cms_login));
                      
    forms::text(array('label' => 'Hasło do CMSa',
                      'name' => 'cms_haslo',
                      'value' => $decrypted_cms_haslo));

    ?></td>
    <td style="vertical-align: top; width: 50%;"><h3 style="margin: 0 0 0 5px;">Klient FTP</h3>
	<?php

    forms::text(array('label' => 'Serwer FTP',
                      'name' => 'ftp_server',
                      'value' => $klient['ftp_server']));
               
    forms::text(array('label' => 'Login do FTP',
                      'name' => 'ftp_login',
                      'value' => $decrypted_ftp_login));
                      
    forms::text(array('label' => 'Hasło do FTP',
                      'name' => 'ftp_haslo',
                      'value' => $decrypted_ftp_haslo));

    ?></td>
    </tr>
    <tr><td>
	<?php
			forms::textarea(array('label' => 'Dodatkowe Informacje',
                          'name' => 'seo_inne',
                          'value' => $klient['seo_inne']));        
    ?></td><td><?php forms::submit(0); ?></td></tr></table>
	<?php
             
    forms::close(0);

    $this -> load -> view('footer');
?>