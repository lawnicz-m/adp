<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::open(array('action' => url::page(CONTROLLER.'/wgraj-zalacznik/'.$klient['id_klienta'])));

    forms::text(array('fieldClass' => 'filtr',
                      'id' => 'plik',
                      'name' => 'plik',
                      'inputType' => 'file'));

    forms::close(0);

    forms::title(array('title' => 'Załączniki'));

    $folder_1 = base::get_folder_number($klient['id_klienta']);
    $folder_2 = base::get_file_number($klient['id_klienta']);

    base::check_if_folder_exists('pliki');
    base::check_if_folder_exists('pliki/klienci');
    base::check_if_folder_exists('pliki/klienci/'.$folder_1);
    base::check_if_folder_exists('pliki/klienci/'.$folder_1.'/'.$folder_2);

    $sciezka = 'pliki/klienci/'.$folder_1.'/'.$folder_2.'/';

    if(count(glob($sciezka . "*"))){
        echo '<table border="0" cellpadding="0" cellspacing="0" class="base">';

            echo '<tr>';
                echo '<th>Nazwa pliku</th>';
                echo '<th>Ostatnia modyfikacja</th>';
                echo '<th>Rozmiar</th>';
                echo '<th></th>';
            echo '</tr>';

            $katalog = opendir($sciezka);

            $i = 0; while($plik = readdir($katalog)){
                if(($plik != ".") && ($plik != "..")){
                    echo $i == 1 ? '<tr>' : '<tr class="odd">';
                        $i++;
                        if($i == 2) $i = 0;
                        $stat = stat($sciezka.$plik);
                        echo '<td><a href="'.url::page(CONTROLLER.'/pobierz-zalacznik/'.$klient['id_klienta'].'?nazwa_pliku='.urlencode($plik)).'" rel="external">'.$plik.'</a></td>';
                        echo '<td>'.date("Y-m-d H:i:s", filemtime($sciezka.$plik)).'</td>';
                        echo '<td>'.texts::readable_file_size($stat['size']).'</td>';
                        echo '<td class="akcje">';
                            echo '<a href="'.url::page(CONTROLLER.'/usun-zalacznik/'.$klient['id_klienta'].'?nazwa_pliku='.urlencode($plik)).'" rel="potwierdzenie">Usuń</a>';
                        echo '</td>';
                    echo '</tr>';
                }
            }

            closedir($katalog);

        echo '</table>';
    }else{
        echo '<p>Brak załączników</p>';
    }

    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#plik').change(function(){
                $('form').submit();
            });
        });
    </script>
    <?php

    $this -> load -> view('footer');
?>