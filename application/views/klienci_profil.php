<?php $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));
	$partnerzy = $this -> load -> model('partnerzy');
	$partner = $partnerzy -> jeden($klient['id_partnera']);
	$pierwszy_partner = $partnerzy -> jeden($klient['id_1_partnera']);

	$pozycjonerzy = $this -> load -> model('pozycjonerzy');
	$pozycjoner = $pozycjonerzy -> jeden($klient['id_pozycjonera']);?>
	
    <table border="0" cellpadding="0" cellspacing="0" style="margin: 5px 0 0 0; width: 100%;">
        <tr>
		<td style="padding: 10px; vertical-align: top; width: 50%;">
		<table border="0" cellpadding="0" cellspacing="1" id="dane_profilowe">
                    <tr>
                        <td colspan="2">
                            <h3>Dane ogólne</h3>
                        </td> 
                    </tr>
                    <tr>
                        <td class="right">Nazwa:</td>
                        <td><b><?php echo $klient['nazwa'];?></b></td>
                    </tr>
                    <tr>
                        <td class="right">Adres strony:</td>
                        <td><b><a href="http://<?php echo $klient['adres_strony'];?>" rel="external"><?php echo $klient['adres_strony'];?></a></b></td>
                    </tr>
                    <?php if($klient['adres_strony_2']){ ?>
                    <tr>
                        <td class="right">Inne adresy strony:</td>
                        <td><b><?php echo $klient['adres_strony_2'];?></b></td>
                    </tr>
                    <?php } ?>
					<tr>
                        <td class="right">E-mail Klienta:</td>
                        <td><b><a href="mailto:<?php echo $klient['mail'];?>?subject=ADP Poland Sp. z o.o. Pozycjonowanie: "><?php echo $klient['mail'];?></a></b></td>
                    </tr>
					<tr>
                        <td class="right">Handlowiec prowadzący:</td>
                        <td><b><a href="mailto:<?php echo $partner['mail'];?>?subject=W sprawie Klienta: <?php echo $klient['adres_strony']?>"><?php echo $partner['nazwa'];?></a></b></td>
                    </tr>
					<tr>
                        <td class="right">"informatyk" prowadzący:</td>
                        <td><b><a href="mailto:<?php echo $pozycjoner['mail'];?>?subject=W sprawie Klienta: <?php echo $klient['adres_strony']?>"><?php echo $pozycjoner['nazwa'];?></a></b></td>
                    </tr>
					<tr>
                        <td class="right">Klienta dodał:</td>
                        <td><b><?php echo $pierwszy_partner['nazwa'];?></b></td>
                    </tr>
                    
                    <tr>
                        <td class="right">Notatka do następnego kontaktu:</td>
                        <td><b><?php echo $klient['notatka_do_nastepnego_kontaktu'];?></b></td>
                    </tr>
					<?php if($klient['hosting'] != 0){ ?>
                    <tr>
                        <td class="right">Umowa na hosting Strony WWW:</td>
                        <td><b>TAK</b></td>
                    </tr>
                    <?php } ?>
					<?php if($klient['poczta'] != 0){ ?>
                    <tr>
                        <td class="right">Umowa na hosting Poczty:</td>
                        <td><b>TAK</b></td>
                    </tr>
                    <?php } ?>
					<?php if($klient['cena_hosting'] != 0){ ?>
                    <tr>
                        <td class="right">Kwota umowy na hosting:</td>
                        <td><b><?php echo $klient['cena_hosting'];?></b></td>
                    </tr>
                    <?php } ?>
					<tr>
                        <td class="right">Priorytet / VIP:</td>
                        <td><b><?php echo $klient['priorytet'];?> / <?php if ($klient['vip'] == 1){echo 'TAK';} else {echo 'nie';}?></b></td>
                    </tr>
					<tr>
                        <td class="right">Kategoria:</td>
                        <td><b><?php 
						
					if($klient['kategoria'] == 0){echo '<font color = "red">NIE PRZYDZIELONA</font>';}
					else if($klient['kategoria'] == 1){echo '('.$klient['kategoria'].')'.' Dom i ogród';}
					else if($klient['kategoria'] == 2){echo '('.$klient['kategoria'].')'.' Hobby i Wypoczynek';}
					else if($klient['kategoria'] == 3){echo '('.$klient['kategoria'].')'.' Uroda i fitness';}
					else if($klient['kategoria'] == 4){echo '('.$klient['kategoria'].')'.' Zdrowie';}
					else if($klient['kategoria'] == 5){echo '('.$klient['kategoria'].')'.' Prawo, finanse, ubezpieczenia';}
					else if($klient['kategoria'] == 6){echo '('.$klient['kategoria'].')'.' Rynki gospodarcze i przemysłowe';}
					else if($klient['kategoria'] == 7){echo '('.$klient['kategoria'].')'.' Kuchnia';}
					else if($klient['kategoria'] == 8){echo '('.$klient['kategoria'].')'.' Edukacja, praca, nauka';}
					else if($klient['kategoria'] == 9){echo '('.$klient['kategoria'].')'.' Turystyka';}
					else if($klient['kategoria'] == 10){echo '('.$klient['kategoria'].')'.' Motoryzacja';}
					else if($klient['kategoria'] == 11){echo '('.$klient['kategoria'].')'.' Zakupy';}
					else if($klient['kategoria'] == 12){echo '('.$klient['kategoria'].')'.' Ludzie i Społeczeństwo';}
					else if($klient['kategoria'] == 13){echo '('.$klient['kategoria'].')'.' Styl życia';}
					else if($klient['kategoria'] == 14){echo '('.$klient['kategoria'].')'.' Marketing';}
					else if($klient['kategoria'] > 14){echo '!! BŁĘDNA !!';}?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br /><hr />
                            <h3>Dane do kontaktu</h3>
                        </td> 
                    </tr>
                    <tr>
                        <td class="right">Osoba kontaktowa:</td>
                        <td><b><?php echo $klient['osoba_kontaktowa'];?></b></td>
                    </tr>
                    <tr>
                        <td class="right">Telefon:</td>
                        <td><b><?php echo $klient['telefon'];?></b></td>
                    </tr>
                    <tr>
                        <td class="right">Inne dane kontaktowe:</td>
                        <td><b><?php echo nl2br($klient['dane_kontaktowe']);?></b></td>
                    </tr>
                    <tr>
                        <td class="right">Osoba reprezentująca (do umowy):</td>
                        <td><b><?php echo $klient['reprezentant'];?></b></td>
                    </tr>
					<?php if($klient['optymalizacja']!=1){ ?>
                    <tr>
                        <td class="right"><b><font color = "red">Optymalizacja:</font></b></td>
                        <td><font color = "red"><b> !!! NIEZROBIONA !!!</b></font></td>
                    </tr>
                    <?php } ?>
					<?php if($klient['poprawa']==1){ ?>
                    <tr>
                        <td class="right"><b><font color = "red">Optymalizacja:</font></b></td>
                        <td><font color = "red"><b> !! DO POPRAWKI !!</b></font></td>
                    </tr>
                    <?php } ?>
					<?php if($klient['dostepy'] == false){ ?>
                    <tr>
                        <td class="right"><b><font color = "red">Dostępy:</font></b></td>
                        <td><font color = "red"><b> !! POTRZEBA !!</b></font></td>
                    </tr>
                    <?php } ?>
					<?php if($klient['teksty'] == true){ ?>
                    <tr>
                        <td class="right"><b><font color = "red">Teksty:</font></b></td>
                        <td><font color = "red"><b> !! POTRZEBNE !!</b></font></td>
                    </tr>
                    <?php } ?>
					
					
					                   
                </table>
		</td>
            <td style="padding: 10px; vertical-align: top; width: 50%;">
                <?php 
				forms::button(array('value' => 'Edytuj',
                            'link' => url::page(CONTROLLER.'/form/'.$klient['id_klienta'])));
				?>
                <table border="0" cellpadding="0" cellspacing="1" id="dane_profilowe">
                    <tr>
                        <td colspan="2">
                            <h3>Daty</h3>
                        </td> 
                    </tr>
                    <tr>
                        <td class="right">Data utworzenia klienta:</td>
                        <td><b><?php echo texts::nice_date($klient['data_utworzenia']);?></b></td>
                    </tr>
                <!--   
					<tr>
                        <td class="right">Data pierwszego kontaktu:</td>
                        <td><b><?php echo texts::nice_date($klient['data_pierwszego_kontaktu']);?></b></td>
                    </tr> 
				-->
                    <tr>
                        <td class="right">Data następnego kontaktu:</td>
                        <td><b><?php echo texts::nice_date($klient['data_nastepnego_kontaktu']);?></b></td>
                    </tr>
					<?php if($klient['umowa_czas_okreslony_od'] != '0000-00-00'){ ?>
                    <tr>
                        <td class="right">Data rozpoczęcia pozycjonowania na umowie:</td>
                        <td><b><?php echo texts::nice_date($klient['umowa_czas_okreslony_od']);?></b></td>
                    </tr>
                    <?php } ?>
                    <?php if($klient['data_rozpoczecia_pozycjonowania'] != '0000-00-00'){ ?>
                    <tr>
                        <td class="right">Na etapie pozycjonowanie od:</td>
                        <td><b><?php echo texts::nice_date($klient['data_rozpoczecia_pozycjonowania']);?></b></td>
                    </tr>
                    <?php } ?>
					                   

                    <tr>
                        <td colspan="2">
                            <br /><hr />
							
                            <h3>Dane do faktury</h3>
                        </td> 
                    </tr>
                    <tr>
                        <td class="right">NIP:</td>
                        <td><b><?php echo $klient['nip'];?></b></td>
                    </tr>
                    <tr>
                        <td class="right">Regon:</td>
                        <td><b><?php echo $klient['regon'];?></b></td>
                    </tr>
                    <tr>
                        <td class="right">Nazwa:</td>
                        <td><b><?php echo $klient['faktura_nazwa'];?></b></td>
                    </tr>
                    <tr>
                        <td class="right">Adres:</td>
                        <td><b><?php echo $klient['faktura_adres'];?></b></td>
                    </tr>
                    <tr>
                        <td class="right">Kod pocztowy:</td>
                        <td><b><?php echo $klient['faktura_kod_pocztowy'];?></b></td>
                    </tr>
                    <tr>
                        <td class="right">Miejscowość:</td>
                        <td><b><?php echo $klient['faktura_miejscowosc'];?></b></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <br /><hr />
                            <h3>Adres do korespondencji</h3>
                        </td> 
                    </tr>
                    <tr>
                        <td class="right">Nazwa:</td>
                        <td><b><?php echo $klient['korespondencja_nazwa'];?></b></td>
                    </tr>
                    <tr>
                        <td class="right">Adres:</td>
                        <td><b><?php echo $klient['korespondencja_adres'];?></b></td>
                    </tr>
                    <tr>
                        <td class="right">Kod pocztowy:</td>
                        <td><b><?php echo $klient['korespondencja_kod_pocztowy'];?></b></td>
                    </tr>
                    <tr>
                        <td class="right">Miejscowość:</td>
                        <td><b><?php echo $klient['korespondencja_miejscowosc'];?></b></td>
                    </tr>
<!--
                    <tr>
                        <td colspan="2">
                            <br /><hr />
                            <h3>Przedziały TOP</h3>
                        </td> 
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $klient['top_10_1_od'];?>-<?php echo $klient['top_10_1_do'];?>,
                            <?php echo $klient['top_10_2_od'];?>-<?php echo $klient['top_10_2_do'];?>,
                            <?php echo $klient['top_10_3_od'];?>-<?php echo $klient['top_10_3_do'];?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <br /><hr />
                            <h3>Usuwanie klienta</h3>
                        </td> 
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                                if($klient['powod_usuniecia']){
                                    echo 'Klient został zgłoszony do usunięcia z powodu:<br /><br /><i>'.$klient['powod_usuniecia'].'</i><br /><br />';
                                    echo '<a href="'.url::page(CONTROLLER.'/anuluj-prosbe-o-usuniecie/'.$klient['id_klienta']).'">Anuluj prośbę o usunięcie</a>';
                                }else{
                                    forms::open(array('action' => url::page(CONTROLLER.'/popros-o-usuniecie/'.$klient['id_klienta'])));

                                    forms::text(array('name' => 'powod_usuniecia',
                                                      'label' => 'Wpisz powód usunięcia w poniższe pole:'));

                                    forms::submit(array('label' => 'Poproś o usunięcie'));

                                    forms::close(0);
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <br /><hr />
							
                            <h3>Komentarz do wyników</h3>
                        </td> 
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                                forms::open(array('action' => url::page(CONTROLLER.'/zapisz-komentarz-do-wynikow/'.$klient['id_klienta'])));

                                forms::textarea(array('name' => 'komentarz_do_wynikow',
                                                      'label' => 'Treść komentarza',
                                                      'value' => $klient['komentarz_do_wynikow']));

                                forms::submit(array('label' => 'Zapisz komentarz'));

                                forms::close(0);
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <br /><hr />
                            <h3>Akceptacja opłaty za obecność na 1 stronie</h3>
                        </td> 
                    </tr>
-->
                </table>
            </td>
        </tr>
    </table>

<?php
    $this -> load -> view('footer');
?>