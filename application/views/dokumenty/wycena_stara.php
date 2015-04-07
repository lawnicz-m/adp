<html>
    <body>

        <h1 align="center"><?php if($jako_zalacznik){ ?>Załącznik nr 1 do umowy nr 1/P/<?php echo $klient['id_klienta'];?>/<?php echo date("Y");?><?php }else{ ?>Wycena pozycjonowania strony: <i><?php echo $klient['adres_strony'];?></i><?php } ?></h1>

        <br /><br />

        <div>

        <?php if($frazy){ ?>

        <?php
            $frazy_ryczalt = false;
            $frazy_top_10 = false;
            foreach($frazy as $fraza){
                if($fraza['typ'] == 1) $frazy_top_10 = true;
                if($fraza['typ'] == 2) $frazy_ryczalt = true;
            }
        ?>

        <?php if($frazy_ryczalt){ ?>
            <?php if($klient['umowa_czas_okreslony']){ ?><h2>Lista pozycjonowanych fraz</h2><?php }else{ ?><h2>Wariant ryczałtowy</h2><?php } ?>
            <ol>
            <?php foreach($frazy as $fraza){ ?>
                <?php if($fraza['typ'] == 2){ ?>
                <li>
                    <?php echo $fraza['nazwa'];?>
                </li>
                <?php } ?>
            <?php } ?>
            </ol>
            <p>Opłata miesięczna za pozycjonowanie wszystkich powyższych fraz: <?php echo $klient['kwota_ryczaltu'];?> zł</p>
            <br /><br />
        <?php } ?>

        <?php if($frazy_top_10 && !$klient['umowa_czas_okreslony']){ ?>
            <h2>Wariant PIERWSZA STRONA</h2>
        <?php
            $suma_1 = $suma_2 = $suma_3 = 0;
        ?>
        <table border="1" cellpadding="10" cellspacing="0" class="top_10">
            <tr>
                <td bgcolor="#555" color="#FFF">Fraza</td>
                <td align="center" bgcolor="#555" color="#FFF">Koszt</td>
                <?php /*<td align="center" bgcolor="#555" color="#FFF">Pozycje <?=$klient['top_10_1_od'];?>-<?=$klient['top_10_1_do'];?></td>
                <? if($klient['top_10_2_od'] && $klient['top_10_2_do']){ ?><td align="center" bgcolor="#555" color="#FFF">Pozycje <?=$klient['top_10_2_od'];?>-<?=$klient['top_10_2_do'];?></td><? } ?>
                <? if($klient['top_10_3_od'] && $klient['top_10_3_do']){ ?><td align="center" bgcolor="#555" color="#FFF">Pozycje <?=$klient['top_10_3_od'];?>-<?=$klient['top_10_3_do'];?></td><? } ?>*/?>
            </tr>
            <?php foreach($frazy as $fraza){ ?>
                <?php if($fraza['typ'] == 1){ ?>
            <tr>
                <td>
                    <?php echo $fraza['nazwa'];?>
                </td>
                <?php /*<td align="center">
                    <?
                        echo $kwota = round($fraza['kwota_za_fraze']);
                        $suma_1 = $suma_1 + $kwota;
                    ?> zł
                </td>*/?>
                <?php if($klient['top_10_2_od'] && $klient['top_10_2_do']){ ?>
                <td align="center">
                    <?php
                        echo $kwota = round(($fraza['kwota_za_fraze'] / 3) * 2);
                        $suma_2 = $suma_2 + $kwota;
                    ?> zł
                </td>
                <?php } ?>
                <?php /*<? if($klient['top_10_3_od'] && $klient['top_10_3_do']){ ?>
                <td align="center">
                    <?
                        echo $kwota = round($fraza['kwota_za_fraze'] / 3);
                        $suma_3 = $suma_3 + $kwota;
                    ?> zł
                </td>
                <? } ?>*/?>
            </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <td bgcolor="#EDEDED">
                    Opłata miesięczna
                </td>
                <?php /*<td align="center" bgcolor="#EDEDED">
                    <?=$suma_1;?> zł
                </td>*/?>
                <?php if($klient['top_10_2_od'] && $klient['top_10_2_do']){ ?>
                <td align="center" bgcolor="#EDEDED">
                    <?php echo $suma_2;?> zł
                </td>
                <?php } ?>
                <?php /*<? if($klient['top_10_3_od'] && $klient['top_10_3_do']){ ?>
                <td align="center" bgcolor="#EDEDED">
                    <?=$suma_3;?> zł
                </td>
                <? } ?>*/?>
            </tr>
        </table>
        <?php } ?>

        </div>

            <?php if(!$jako_zalacznik){ ?>

            <?php if($klient['komentarz_do_wyceny']){ ?>
            <p><?php echo nl2br($klient['komentarz_do_wyceny']);?></p>
            <?php } ?>

            <hr />

            <small color="#AAA">
                <p>Niniejsze zestawienie stanowi ofertę handlową w rozumieniu przepisów Kodeksu Cywilnego oraz innych właściwych przepisów prawnych.</p>
                <p>Podane ceny są cenami netto. Należy doliczyć 23% podatku VAT.</p>
            </small>
            <?php } ?>

        <?php } ?>

    </body>
</html>