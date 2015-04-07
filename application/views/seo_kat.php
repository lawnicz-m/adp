<?php

	$this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));
	$acl = $this -> acl -> get('acl_frazy');

	$_frazy = $this -> load -> model('frazy');
    $frazy = $_frazy -> wszystkie($klient['id_klienta']);
?>
	<table border="0" cellpadding="50px" cellspacing="1ox" id="dane_klienta" style="width: 100%;">
		<tr>
			<td width="25%">Nazwa klienta:<br /><b><?php echo $klient['nazwa'];?></b></td>
			<td width="25%">Nazwa strony:<br /><b><a href="http://<?php echo $klient['adres_strony'];?>" rel="external"><?php echo $klient['adres_strony'];?></a></b></td>
			<td width="25%">Prowadzący "informatyk":<br /><b><a href="mailto:<?php echo $pozycjoner['mail'];?>?subject=W sprawie Klienta: <?php echo $klient['adres_strony']?>"><?php echo $pozycjoner['nazwa'];?></a></b></td>
			<td width="25%">Handlowiec prowadzący:<br /><b><a href="mailto:<?php echo $partner['mail'];?>?subject=W sprawie Klienta: <?php echo $klient['adres_strony']?>"><?php echo $partner['nazwa'];?></a></b></td>
		</tr>
	</table>
<?php ?>
	<h3>Generator wpisów</h3>
	<?php 
	forms::open(array('action' => url::page(CONTROLLER.'/dodaj_tresci/'.PARAM)));
		forms::textarea(array(	'fieldClass' => 'widthQuarter',
								'name' => 'tresciraw',
								'required' => 1));
		forms::line(0);
		$kategorie = array();
            $kategorie[] = array('etykieta' => 'Budownictwo', 'wartosc' => 'budownictwo');
            $kategorie[] = array('etykieta' => 'Sklepy', 'wartosc' => 'sklepy');
            $kategorie[] = array('etykieta' => 'Zdrowie', 'wartosc' => 'zdrowie');
            $kategorie[] = array('etykieta' => 'Przemysł', 'wartosc' => 'przemysl');
            $kategorie[] = array('etykieta' => 'Opakowania', 'wartosc' => 'opakowania');
            $kategorie[] = array('etykieta' => 'Oprogramowanie', 'wartosc' => 'oprogramowanie');
            $kategorie[] = array('etykieta' => 'Aranżacje', 'wartosc' => 'aranzacje');
            $kategorie[] = array('etykieta' => 'Chłodnictwo', 'wartosc' => 'chlodnictwo');
            $kategorie[] = array('etykieta' => 'Noclegi', 'wartosc' => 'noclegi');
            $kategorie[] = array('etykieta' => 'Transport', 'wartosc' => 'transport');
            $kategorie[] = array('etykieta' => 'Jedzienie', 'wartosc' => 'jedzenie');
            $kategorie[] = array('etykieta' => 'Nauka', 'wartosc' => 'nauka');
            $kategorie[] = array('etykieta' => 'Czystość', 'wartosc' => 'czystosc');
            $kategorie[] = array('etykieta' => 'Usługi', 'wartosc' => 'uslugi');
        
        
        foreach ($frazy as $fraza) { echo "<input type=\"checkbox\" name=\"".$fraza['id_frazy']."\" value=\"Yes\" checked/>".$fraza['nazwa']."<br />"; } 
        echo "<br /><input type=\"checkbox\" name=\"mixy\" value=\"Yes\" checked/>Frazy poboczne";
        forms::line(0);

        forms::select(array('data' => $kategorie,
                            'default' => 'Wybierz kategorię',
                            'fieldClass' => 'width_auto',
                            'labels' => 'etykieta',
                            'name' => 'kategoria',
                            'values' => 'wartosc'));
		forms::hidden(array('name' => 'nazwa_klienta',
							'value' => $klient['faktura_nazwa']));
		forms::hidden(array('name' => 'kod_pocztowy',
							'value' => $klient['faktura_kod_pocztowy']));
		forms::hidden(array('name' => 'miasto',
							'value' => $klient['faktura_miejscowosc']));
		forms::hidden(array('name' => 'adres',
							'value' => $klient['faktura_adres']));
		forms::hidden(array('name' => 'telefon',
							'value' => $klient['telefon']));
		forms::hidden(array('name' => 'url',
							'value' => $klient['adres_strony']));
		forms::submit(0);
	forms::close(0);
	$this -> load -> view('footer'); ?>