<?php 
    $tabela = $this -> db -> table('klienci');
    $id_klienta = $klient['id_klienta'];
    $baza_umowa_arr = $tabela -> select('umowa_czas_okreslony_od')
    		                -> where('id_klienta','=',$id_klienta)
    		                -> execute();    
    $baza_umowa 	= ($baza_umowa_arr[0]["umowa_czas_okreslony_od"]);
    $data = explode("-", $baza_umowa); 
    $umowa_rok = $data[0];
?>

<html>
    <body>

        <h1 align="center"><?php if($jako_zalacznik){ ?>Załącznik nr 1 do umowy nr 1/P/<?php echo $klient['id_klienta'];?>/2014<?php }else{ ?>Wycena pozycjonowania strony: <i><?php echo $klient['adres_strony'];?></i><?php } ?></h1>

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
            <h2>Wariant ryczałtowy</h2>
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

        <?php if($frazy_top_10 && ($klient['top_10_1_od']!=$klient['top_10_1_do'])){ ?>
            <h2>Wariant Pierwsza Strona</h2>
        <?php
            $suma_1 = $suma_2 = $suma_3 = 0;
        ?>
        <table border="1" cellpadding="10" cellspacing="0" class="top_10">
            <tr>
                <td bgcolor="#555" color="#FFF">Fraza</td>
                <td align="center" bgcolor="#555" color="#FFF">Pozycje <?php echo $klient['top_10_1_od'];?>-<?php echo $klient['top_10_1_do'];?></td>
                <?php if($klient['top_10_2_od'] && $klient['top_10_2_do']){ ?><td align="center" bgcolor="#555" color="#FFF">Pozycje <?php echo $klient['top_10_2_od'];?>-<?php echo $klient['top_10_2_do'];?></td><?php } ?>
                <?php if($klient['top_10_3_od'] && $klient['top_10_3_do']){ ?><td align="center" bgcolor="#555" color="#FFF">Pozycje <?php echo $klient['top_10_3_od'];?>- koniec 1 str.</td><?php } ?>
            </tr>
            <?php foreach($frazy as $fraza){ ?>
                <?php if($fraza['typ'] == 1){
                	
                	$top10_1_kwota = (float)$fraza['top10_1_kwota'];
                	$top10_2_kwota = (float)$fraza['top10_2_kwota'];
                	$top10_3_kwota = (float)$fraza['top10_3_kwota'];
                	
                	if($fraza['top10_procentowo']) {
                		$top10_1_kwota *= ($fraza['kwota_za_fraze'] / 100.0);
                		$top10_2_kwota *= ($fraza['kwota_za_fraze'] / 100.0);
                		$top10_3_kwota *= ($fraza['kwota_za_fraze'] / 100.0);
                	}
                	?>
            <tr>
                <td>
                    <?php echo $fraza['nazwa'];?>
                </td>
                <td align="center">
                    <?php
                        echo $kwota = round($top10_1_kwota);
                        $suma_1 = $suma_1 + $kwota;
                    ?> zł
                </td>
                <?php if($klient['top_10_2_od'] && $klient['top_10_2_do']){ ?>
                <td align="center">
                    <?php
                        echo $kwota = round($top10_2_kwota);
                        $suma_2 = $suma_2 + $kwota;
                    ?> zł
                </td>
                <?php } ?>
                <?php if($klient['top_10_3_od'] && $klient['top_10_3_do']){ ?>
                <td align="center">
                    <?php
                        echo $kwota = round($top10_3_kwota);
                        $suma_3 = $suma_3 + $kwota;
                    ?> zł
                </td>
                <?php } ?>
            </tr>
                <?php } ?>
            <?php } ?>
            <!--<tr>
                <td bgcolor="#EDEDED">
                    Opłata miesięczna
                </td>
                <td align="center" bgcolor="#EDEDED">
                    <?php echo $suma_1;?> zł
                </td>
                <?php if($klient['top_10_2_od'] && $klient['top_10_2_do']){ ?>
                <td align="center" bgcolor="#EDEDED">
                    <?php echo $suma_2;?> zł
                </td>
                <?php } ?>
                <?php if($klient['top_10_3_od'] && $klient['top_10_3_do']){ ?>
                <td align="center" bgcolor="#EDEDED">
                    <?php echo $suma_3;?> zł
                </td>
                <?php } ?>
            </tr> -->
        </table>
        <?php } ?>

 <?php if($frazy_top_10 && ($klient['top_10_1_od']==$klient['top_10_1_do'])){ ?>
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
                <td align="center">
                    <?php
                        echo $kwota = round($fraza['kwota_za_fraze']);
                        $suma_1 = $suma_1 + $kwota;
                    ?> zł
                </td>
               
                
            </tr>
                <?php } ?>
            <?php } ?>
           <!-- <tr>
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
            </tr> -->
        </table>
		
        <?php } ?>


    </div>

          

            <?php if($klient['komentarz_do_wyceny']){ ?>
            <p><?php echo nl2br($klient['komentarz_do_wyceny']);?></p>
            <?php } ?>
	<table>

    <tr>

        <td>

            <p align="center"><br />ZLECAJĄCY:</p>

        </td>

        <td>

            <p align="center"><br />WYKONAWCA:<br />Artur Stanejko</p>

        </td>

    </tr>

</table>

  <?php if(!$jako_zalacznik){ ?>
            <hr />

            <small color="#AAA">
                <p>Niniejsze zestawienie stanowi ofertę handlową w rozumieniu przepisów Kodeksu Cywilnego oraz innych właściwych przepisów prawnych.</p>
                <p>Podane ceny są cenami netto. Należy doliczyć 23% podatku VAT.</p>
            </small>
            <?php } ?>

        <?php } ?>

    </body>
</html>