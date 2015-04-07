<html>
    <body>
        <h1 align="center">Raport wykonania usługi pozycjonowania strony <i><?php echo $klient['adres_strony'];?></i> pozycje zajmowane w <?php echo texts::czytelny_miesiac($miesiac);?></h1>

        <table border="1" cellpadding="2" cellspacing="0">
            <?php
                $liczba_dni_miesiacu = date("t", strtotime($miesiac));
                $szerkosc_wyniku = 2.5;
                $szerkosc_fraz = 100 - ($liczba_dni_miesiacu * $szerkosc_wyniku);
                $rozmiar_czcionki = 8;
            ?>
            <tr>
                <td align="center" bgcolor="#CCC" width="<?php echo $szerkosc_fraz;?>%">
                    <font size="<?php echo $rozmiar_czcionki;?>">Fraza / Dzień</font>
                </td>
                <?php for($i = 1; $i <= $liczba_dni_miesiacu; $i++){ ?>
                <?php $dzien = $i < 10 ? '0'.$i : $i; ?>
                <td align="center" bgcolor="#CCC" width="<?php echo $szerkosc_wyniku;?>%">
                    <font size="<?php echo $rozmiar_czcionki;?>"><?php echo $dzien;?></font>
                </td>
                <?php } ?>
            </tr>
            <?php $i2 = 0; foreach($frazy as $fraza){ ?>
            <tr>
                <td<?php if($i2 == 1){ ?> bgcolor="#ECECEC"<?php } ?> width="<?php echo $szerkosc_fraz;?>%">
                    <font size="<?php echo $rozmiar_czcionki;?>"><?php echo $fraza['nazwa'];?></font>
                </td>
                <?php for($i = 1; $i <= $liczba_dni_miesiacu; $i++){ ?>
                <?php $dzien = $i < 10 ? '0'.$i : $i; ?>
                <td align="center"<?php if($i2 == 1){ ?> bgcolor="#ECECEC"<?php } ?> width="<?php echo $szerkosc_wyniku;?>%">
                    <font size="<?php echo $rozmiar_czcionki;?>"><?php echo isset($dane[$fraza['id_frazy']]) ? ($dane[$fraza['id_frazy']][$dzien] ? $dane[$fraza['id_frazy']][$dzien] : '') : '';?></font>
                </td>
                <?php } ?>
            </tr>
            <?php $i2++; if($i2 == 2){ $i2 = 0; } ?>                
            <?php } ?>
            <tr>
                <td align="center" bgcolor="#CCC" width="<?php echo $szerkosc_fraz;?>%">
                    <font size="<?php echo $rozmiar_czcionki;?>">Odsetek fraz na pierwszej stronie Google</font>
                </td>
                <?php for($i = 1; $i <= $liczba_dni_miesiacu; $i++){ ?>
                <?php $dzien = $i < 10 ? '0'.$i : $i; ?>
                <td align="center" bgcolor="#CCC" width="<?php echo $szerkosc_wyniku;?>%">
                    <font size="<?php echo $rozmiar_czcionki;?>"><?php echo $odsetek_na_pierwszej_stronie[$i];?></font>
                </td>
                <?php } ?>
            </tr>
        </table>

    </body>
</html>