<?php
    header("Content-type: application/x-download");
    header("Content-disposition: attachment; filename=raport_".$miesiac.".csv");  
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Pragma: public");
    header("Expires: 0");

    $liczba_dni_miesiacu = date("t", strtotime($miesiac));

    echo "Fraza / Dzień\t";
    
    for($i = 1; $i <= $liczba_dni_miesiacu; $i++){
        $dzien = $i < 10 ? '0'.$i : $i;
        echo $dzien."\t";
    }

    foreach($frazy as $fraza){
        echo "\n";
        echo $fraza['nazwa']."\t";
        for($i = 1; $i <= $liczba_dni_miesiacu; $i++){
            $dzien = $i < 10 ? '0'.$i : $i;
            echo isset($dane[$fraza['id_frazy']]) ? ($dane[$fraza['id_frazy']][$dzien] ? $dane[$fraza['id_frazy']][$dzien] : '') : '';
            echo "\t";
        }
    }

    echo "\n";
    echo "Odsetek fraz na pierwszej stronie Google\t";

    for($i = 1; $i <= $liczba_dni_miesiacu; $i++){
        $dzien = $i < 10 ? '0'.$i : $i;
        echo $odsetek_na_pierwszej_stronie[$i]."\t";
    }
?>