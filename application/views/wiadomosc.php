<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::title(array('title' => $wiadomosc['tytul'].($wiadomosc['data_potwierdzenia'] != '0000-00-00 00:00:00' ? ' <sup>[WYKONANE]</sup>' : '')));

    echo '<table border="0" cellpadding="0" cellspacing="10" style="border-collapse: separate; border-spacing: 10px; width: 100%;">';
    echo '<tr><td class="right" style="width: 1%;">Od:</td><td><b>'.$wiadomosc['nazwa_nadawcy'].'</b> ('.$wiadomosc['typ_nadawcy'].')</td></tr>';
    echo '<tr><td class="right">Do:</td><td><b>'.$wiadomosc['nazwa_odbiorcy'].'</b> ('.$wiadomosc['typ_odbiorcy'].')</td></tr>';
    echo '<tr><td class="right">Nadano:</td><td>'.$wiadomosc['data_wyslania'].'</td></tr>';
    if($wiadomosc['data_odczytania'] != '0000-00-00 00:00:00') echo '<tr><td class="right">Odczytano:</td><td>'.$wiadomosc['data_odczytania'].'</td></tr>';
    if($wiadomosc['data_potwierdzenia'] != '0000-00-00 00:00:00') echo '<tr><td class="right">Wykonano:</td><td>'.$wiadomosc['data_potwierdzenia'].'</td></tr>';
    echo '<tr><td colspan="2"><hr />'.nl2br($wiadomosc['tresc']).'<hr /></td></tr>';
    echo '</table>';

    forms::button(array('value' => 'Wróć do skrzynki',
                        'link' => url::page(CONTROLLER)));

    if($wiadomosc['data_potwierdzenia'] == '0000-00-00 00:00:00' && $uzytkownik['typ'] == $wiadomosc['typ_odbiorcy'] && $uzytkownik['id'] == $wiadomosc['id_odbiorcy']){
        forms::button(array('value' => 'Oznacz jako wykonane',
                            'link' => url::page(CONTROLLER.'/oznacz-jako-wykonane/'.PARAM)));
    }

    $this -> load -> view('footer');
?>