<?php
    include('slownie.php');

    function czytelna_data($data){
        $d = explode('-', $data);
        return $d[2].'.'.$d[1].'.'.$d[0];
    }

?>
<p align="right"><?php echo $wezwanie['miejscowosc_nadania'];?>, <?php echo czytelna_data($wezwanie['data_wezwania']);?></p>

<table border="0" cellpadding="10" cellspacing="3">
    <tr>
        <td>
            <h3>NADAWCA</h3>
            <?php echo $wezwanie['nadawca_nazwa'];?><br />
            <?php echo $wezwanie['nadawca_adres'];?><br />
            <?php echo $wezwanie['nadawca_kod_pocztowy'];?> <?php echo $wezwanie['nadawca_miejscowosc'];?>
        </td>
        <td></td>
        <td>
            <h3>ADRESAT</h3>
            <?php echo $wezwanie['adresat_nazwa'];?><br />
            <?php echo $wezwanie['adresat_adres'];?><br />
            <?php echo $wezwanie['adresat_kod_pocztowy'];?> <?php echo $wezwanie['adresat_miejscowosc'];?>
        </td>
    </tr>
</table>

<h1 align="center">WEZWANIE DO ZAPŁATY</h1>

<p>Stosownie do art. 476 Kodeksu Cywilnego ( Dz. U. z 1964r. nr.16, poz.93 z późn. zm.) wzywamy natychmiastowego uregulowania należnej sumy, zgodnie z poniższym zestawieniem. Wymienioną sumę prosimy przekazać na nasz rachunek bankowy ING 42 1050 1575 1000 0023 2143 7036 w ciągu 7 dni od daty otrzymania niniejszego wezwania. W przypadku nie przekazania należnej sumy w wyznaczonym terminie, skierujemy sprawę na drogę postępowania sądowego bez ponownego wezwania do zapłaty.<br />
W przypadku gdy dokonali już Państwo zapłaty, prosimy o przesłanie nam faksem kopii polecenia przelewu.</p>
<p align="right">Stan na dzień: <?php echo czytelna_data($wezwanie['data_wezwania']);?></p>
<br />                  
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <td align="center" bgcolor="#EDEDED" width="11%">
            Data faktury
        </td>
        <td align="center" bgcolor="#EDEDED" width="11%">
            Nr faktury
        </td>
        <td align="center" bgcolor="#EDEDED" width="11%">
            Kwota faktury
        </td>
        <td align="center" bgcolor="#EDEDED" width="11%">
            Zapłacono
        </td>
        <td align="center" bgcolor="#EDEDED" width="11%">
            Termin zapłaty
        </td>
        <td align="center" bgcolor="#EDEDED" width="11%">
            <font size="7">Ilość dni przeterminowanych</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="34%">
            Treść
        </td>
    </tr>
    <?php if($wezwanie['pozycje']){ ?>
    <?php $i = 1; foreach($wezwanie['pozycje'] as $pozycja){ ?>
    <tr>
        <td width="11%">
            <?php echo czytelna_data($pozycja['data_wystawienia_faktury']);?>
        </td>
        <td width="11%">
            <?php echo $pozycja['numer_faktury'];?>
        </td>
        <td align="right" width="11%">
            <?php echo number_format($pozycja['calkowita_kwota_faktury'], 2, '.', ' ');?>
        </td>
        <td align="right" width="11%">
            <?php echo number_format($pozycja['zaplacona_kwota_faktury'], 2, '.', ' ');?>
        </td>
        <td width="11%">
            <?php echo czytelna_data($pozycja['termin_zaplaty_faktury']);?>
        </td>
        <td align="center" width="11%">
            <?php echo $pozycja['ilosc_dni_przeterminowanych'];?>
        </td>
        <td width="34%">
            <?php echo $pozycja['tytul_faktury'];?>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <td align="right" bgcolor="#EDEDED" colspan="2" width="22%"></td>
        <td align="right" bgcolor="#EDEDED" width="11%">
            <font size="9"><?php echo number_format($wezwanie['kwota_do_zaplaty'], 2, '.', ' ');?></font>
        </td>
        <td align="right" bgcolor="#EDEDED" width="11%">
            <font size="9"><?php echo number_format($wezwanie['wplacona_kwota'], 2, '.', ' ');?></font>
        </td>
        <td align="right" bgcolor="#EDEDED" colspan="3" width="56%"></td>
    </tr>
    <?php } ?>
</table>
<p>&nbsp;</p>
<table border="1" cellpadding="7" cellspacing="0">
    <tr>
        <td bgcolor="#EDEDED" width="70%">
            <font size="8">Do zapłaty słownie</font>
        </td>
        <td align="right" bgcolor="#EDEDED" width="30%">
            <font size="8">Do zapłaty</font>
        </td>
    </tr>
    <tr>
        <td width="70%">
            <?php
                $klasa_slownie = new slownie;
                echo ucfirst(trim($klasa_slownie -> pokaz($wezwanie['pozostala_kwota']))); 
            ?>
        </td>
        <td align="right" width="30%">
            <font size="13"><b><?php echo number_format($wezwanie['pozostala_kwota'], 2, '.', ' ');?> PLN</b></font>
        </td>
    </tr>
</table>
<p> </p>
<p style="text-align: center; background-color: WhiteSmoke; color: red;" >Informujemy również, iż działając na podstawie Ustawy z dnia 14 lutego 2003r. „o udostępnianiu informacji gospodarczych” w przypadku braku zapłaty,<br />
po upływie miesiąca od daty wysłania niniejszego wezwania informacja o Państwa zobowiązaniach zostanie przekazana do:<br />
<br />
<b>Krajowego Rejestru Długów<br />
Biura Informacji Gospodarczej S.A.,<br />
z siedzibą we Wrocławiu przy ul. Armii Ludowej 21.</b></p>
<p> </p>
<table>
<tr>
	<td width="70%">
		
	</td>
	<td width="30%">
		(pieczęć i podpis wierzyciela)
	</td>
</tr>
</table>