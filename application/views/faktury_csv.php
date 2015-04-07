<?php
    header("Content-type: application/x-download");
    header("Content-disposition: attachment; filename=faktury_".date("YmdHis").".csv");  
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Pragma: public");
    header("Expires: 0");

    if($faktury){
        $uslugi = $this -> load -> model('faktury') -> towary_i_uslugi(0);

        echo "Numer\tKlient\tTermin zapłaty\tKwota netto\tKwota VAT\tKwota brutto\tStan\tWysłana mailem\tFinalna forma zapłaty\tOsoba pobierająca gotówkę";
        foreach($faktury as $faktura){
            echo "\n".texts::numer_faktury($faktura)."\t";
            echo (isset($faktura['nazwa']) ? $faktura['nazwa'] : $klient['nazwa'])."\t";
            echo $faktura['termin_zaplaty']."\t";
            echo $faktura['kwota_netto']."\t";
            echo $faktura['kwota_podatku']."\t";
            echo $faktura['kwota_brutto']."\t";

            // oplacona
            if($faktura['status']){
                $stan ='opłacona';
            }

            // nie opłacona
            else{

                // przekroczona
                if(date("Y-m-d") >= $faktura['termin_zaplaty']){
                    $stan = 'nieopłacona';
                }

                // oczekująca
                else{
                    $stan = 'oczekiwanie';
                }

                // częściowa
                if($faktura['wplacona_kwota'] < $faktura['kwota_brutto'] && $faktura['wplacona_kwota'] != '0.00'){
                    $stan ='opłacona częściowo';
                }
                
            }

            echo $stan."\t";

            echo ($faktura['wyslana_mailem'] ? 'tak' : 'nie')."\t";

            echo $faktura['finalna_forma_zaplaty']."\t";

            echo $faktura['osoba_pobierajaca_gotowke'];
        }

    }

?>