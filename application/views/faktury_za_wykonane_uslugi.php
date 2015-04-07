<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::title(array('title' => 'Faktury za wykonane usługi'));

    if($faktury){
        $uslugi = $this -> load -> model('faktury') -> towary_i_uslugi(0);

        echo '<table border="0" cellpadding="0" cellspacing="0" class="base">';
            echo '<tr>';
                echo '<th>Numer</th>'; $ilosc_faktur = 0;
                echo '<th>Data wystawienia</th>';
                echo '<th>Klient</th>';
                echo '<th>&nbsp;&nbsp;&nbsp;&nbsp;</th>';
                echo '<th>Termin zapłaty</th>';
                echo '<th>Wynagrodzenie</th>';
            echo '</tr>';
            $i = 0; foreach($faktury as $faktura){
            echo $i == 1 ? '<tr>' : '<tr class="odd">';
                $i++;
                if($i == 2) $i = 0;
                echo '<td class="nobr">'.texts::numer_faktury($faktura);
                if($faktura['zaliczka']) echo ' (Zaliczkowa)';
                if($faktura['id_faktury_zaliczkowej']) echo ' (Końcowa)';
                $ilosc_faktur++;
                echo'</td>';
                echo '<td class="nobr">'.texts::nice_date($faktura['data_wystawienia']).'</td>';
                echo '<td>';
                echo texts::short($faktura['nabywca_nazwa'], 40);
                echo '</td>';

                $nieoplacona = 0;

                // oplacona
                if($faktura['status']){
                    $stan = 'opłacona';
                    if($faktura['data_zaplaty'] != '0000-00-00') $stan .= '<br />'.texts::nice_date($faktura['data_zaplaty']);
                    if($faktura['osoba_pobierajaca_gotowke']) $stan .= '<br />Pobrane przez: '.$faktura['osoba_pobierajaca_gotowke'];
                    $stan_2 = 'opłacona';
                }

                // nie opłacona
                else{

                    // przekroczona
                    if(date("Y-m-d") >= $faktura['termin_zaplaty']){
                        $nieoplacona = 1;
                        $stan = 'nieopłacona';
                        $stan_2 = 'nieopłacona';
                    }

                    // oczekująca
                    else{
                        $stan = 'oczekiwanie';
                        $stan_2 = 'oczekiwanie';
                    }

                    // częściowa
                    if($faktura['wplacona_kwota'] < $faktura['kwota_brutto'] && $faktura['wplacona_kwota'] != '0.00'){
                        $stan ='opłacona częściowo';
                        $stan_2 = 'opłacona częściowo';
                    }
                    
                }

                if($stan_2 == 'nieopłacona') $stan_kolor = 'red';
                else if($stan_2 == 'opłacona') $stan_kolor = 'green';
                else if($stan_2 == 'opłacona częściowo') $stan_kolor = 'orange';
                else if($stan_2 == 'oczekiwanie') $stan_kolor = 'gray';

                echo '<td class="szczegoly_platnosci" style="background: '.$stan_kolor.'; border-bottom: 1px solid #FFF; padding: 2px; width: 1%;">';
                echo '<div style="background: #FFF; text-align: center; padding: 2px 6px 5px 6px;">'.$stan_2.'</div>';
                echo '</td>';

                echo '<td class="nobr">'.texts::nice_date($faktura['termin_zaplaty']).'</td>';
                echo '<td class="nobr">'.str_replace('.00', '', number_format($faktura['suma_kwot_wynagrodzenia_za_wykonanie'], 2, '.', ' ')).'</td>'; 
            echo '</tr>';
        }

        echo '</table>';

    }

    $this -> load -> view('footer');
?>