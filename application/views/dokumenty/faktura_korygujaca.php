<?php
    include('slownie.php');

    function czytelna_data($data){
        $d = explode('-', $data);
        return $d[2].'.'.$d[1].'.'.$d[0];
    }
?>
<table border="1" cellpadding="10" cellspacing="3" class="naglowek">
    <tr>
        <td>

        </td>
        <td>
            <h1 align="center">Faktura</h1>
            <h3 align="center">korygująca nr <?php echo $numer_kor; ?>/2014</h2>
            <h4 align="center">do faktury <?php echo texts::numer_faktury($faktura);?></h4>
			<h4 align="center">wystawionej dnia: <?php echo czytelna_data($faktura['data_wystawienia']);?></h4>
        </td>
        <td>
            Miejscowość: <?php echo $faktura['miejsce_sprzedazy'];?><br /><?php if($typ != 'duplikat'){ ?><br /><?php } ?>
            Data wystawienia: <?php echo date("d.m.Y");?><br />
        </td>
    </tr>
</table>

<table border="1" cellpadding="10" cellspacing="3" class="strony">
    <tr>
        <td class="glowna">
            <h3>SPRZEDAWCA</h3>
            <table border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="25%">
                        Firma:
                    </td>
                    <td width="75%">
                        <?php echo $faktura['sprzedawca_nazwa'];?>
                    </td>
                </tr>
                <tr>
                    <td width="25%">
                        Adres:
                    </td>
                    <td width="75%">
                        <?php echo $faktura['sprzedawca_adres'];?><br />
                        <?php echo $faktura['sprzedawca_kod_pocztowy'];?> <?php echo $faktura['sprzedawca_miejscowosc'];?>
                    </td>
                </tr>
                <tr>
                    <td width="25%">
                        NIP:
                    </td>
                    <td width="75%">
                        <?php echo $faktura['sprzedawca_nip'];?>
                    </td>
                </tr>
            </table>
        </td>
        <td class="glowna">
            <h3>NABYWCA</h3>
            <table border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="25%">
                        Firma:
                    </td>
                    <td width="75%">
                        <?php echo $faktura['nabywca_nazwa'];?>
                    </td>
                </tr>
                <tr>
                    <td width="25%">
                        Adres:
                    </td>
                    <td width="75%">
                        <?php echo $faktura['nabywca_adres'];?><br />
                        <?php echo $faktura['nabywca_kod_pocztowy'];?> <?php echo $faktura['nabywca_miejscowosc'];?>
                    </td>
                </tr>
                <tr>
                    <td width="25%">
                        NIP:
                    </td>
                    <td width="75%">
                        <?php echo $faktura['nabywca_nip'];?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br />
Było:<br />
<table border="1" cellpadding="5" cellspacing="0" class="wykaz">
    <tr class="naglowki">
        <td align="center" bgcolor="#EDEDED" width="5%">
            <font size="7">L.p</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="27%">
            <font size="7">Nazwa</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="5%">
            <font size="7">J.m.</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="6%">
            <font size="7">Ilość</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="12%">
            <font size="7">Cena netto</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="12%">
            <font size="7">Kwota netto</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="10%">
            <font size="7">Stawka VAT</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="11%">
            <font size="7">Kwota VAT</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="12%">
            <font size="7">Wartość brutto</font>
        </td>
    </tr>
    <?php $uslugi = $this -> load -> model('faktury') -> towary_i_uslugi(0); ?>
    <?php if($faktura['pozycje']){ ?>
    <?php $i = 1; foreach($faktura['pozycje'] as $pozycja){ 
	$nowa_cnetto = $kwota_kor;
	$nowa_knetto = $pozycja['ilosc'] * $nowa_cnetto;
	$nowa_vat = $nowa_knetto * 0.23;
	$nowa_brutto = 1.23 * $nowa_knetto;
	$roznica_netto = $pozycja['kwota_netto'] - $nowa_knetto;
	$roznica_vat = $pozycja['kwota_podatku'] - $nowa_vat;
	$roznica_brutto = $pozycja['kwota_brutto'] - $nowa_brutto; ?>
    <tr>
        <td align="center" class="center" width="5%">
            <font size="9"><?php echo $i++;?></font>
        </td>
        <td width="27%">
            <font size="9"><?php if($faktura['zaliczka']){ ?>Zaliczka - <?php } ?><?php echo $uslugi[$pozycja['id_towaru_lub_uslugi']];?><?php echo $pozycja['id_towaru_lub_uslugi'] ? ' '.$pozycja['tytul'] : '';?></font>
        </td>
        <td align="right" class="right" width="5%">
            <font size="8"><?php echo $pozycja['jednostka_miary'];?></font>
        </td>
        <td align="center" class="center" width="6%">
            <font size="9"><?php echo str_replace('.00', '', $pozycja['ilosc']);?></font>
        </td>
        <td align="right" class="right" width="12%">
            <font size="9"><?php echo str_replace('.00', '', number_format($pozycja['cena_netto'], 2, '.', ' '));?></font>
        </td>
        <td align="right" class="right" width="12%">
            <font size="9"><?php echo str_replace('.00', '', number_format($pozycja['kwota_netto'], 2, '.', ' '));?></font>
        </td>
        <td align="center" class="center" width="10%">
            <font size="9"><?php echo $pozycja['stawka_vat'];?>%</font>
        </td>
        <td align="right" class="right" width="11%">
            <font size="9"><?php echo str_replace('.00', '', number_format($pozycja['kwota_podatku'], 2, '.', ' '));?></font>
        </td>
        <td align="right" class="right" width="12%">
            <font size="9"><?php echo str_replace('.00', '', number_format($pozycja['kwota_brutto'], 2, '.', ' '));?></font>
        </td>
    </tr>
    <?php } ?>
    <?php } ?>
</table>

<table border="1" cellpadding="7" cellspacing="0">
    <tr>
        <td bgcolor="#EDEDED" width="70%">
            <font size="8">Do zapłaty słownie</font>
        </td>
        <td align="right" class="right" bgcolor="#EDEDED" width="30%">
            <font size="8">Do zapłaty</font>
        </td>
    </tr>
    <tr>
        <td width="70%">
            <?php
                $klasa_slownie = new slownie;
                echo ucfirst(trim($klasa_slownie -> pokaz($faktura['kwota_brutto']))); 
            ?>
        </td>
        <td align="right" class="right wartosc" width="30%">
            <font size="13"><b><?php echo str_replace('.00', '', number_format($faktura['kwota_brutto'], 2, '.', ' '));?> PLN</b></font>
        </td>
    </tr>
</table>
<br />
Jest:<br />
<table border="1" cellpadding="5" cellspacing="0" class="wykaz">
    <tr class="naglowki">
        <td align="center" bgcolor="#EDEDED" width="5%">
            <font size="7">L.p</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="27%">
            <font size="7">Nazwa</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="5%">
            <font size="7">J.m.</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="6%">
            <font size="7">Ilość</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="12%">
            <font size="7">Cena netto</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="12%">
            <font size="7">Kwota netto</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="10%">
            <font size="7">Stawka VAT</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="11%">
            <font size="7">Kwota VAT</font>
        </td>
        <td align="center" bgcolor="#EDEDED" width="12%">
            <font size="7">Wartość brutto</font>
        </td>
    </tr>
    <?php $uslugi = $this -> load -> model('faktury') -> towary_i_uslugi(0); ?>
    <?php if($faktura['pozycje']){ ?>
    <?php $i = 1; foreach($faktura['pozycje'] as $pozycja){ ?>
    <tr>
        <td align="center" class="center" width="5%">
            <font size="9"><?php echo $i++;?></font>
        </td>
        <td width="27%">
            <font size="9"><?php if($faktura['zaliczka']){ ?>Zaliczka - <?php } ?><?php echo $uslugi[$pozycja['id_towaru_lub_uslugi']];?><?php echo $pozycja['id_towaru_lub_uslugi'] ? ' '.$pozycja['tytul'] : '';?></font>
        </td>
        <td align="right" class="right" width="5%">
            <font size="8"><?php echo $pozycja['jednostka_miary'];?></font>
        </td>
        <td align="center" class="center" width="6%">
            <font size="9"><?php echo str_replace('.00', '', $pozycja['ilosc']);?></font>
        </td>
        <td align="right" class="right" width="12%">
            <font size="9"><?php echo str_replace('.00', '', number_format($nowa_cnetto, 2, '.', ' '));?></font>
        </td>
        <td align="right" class="right" width="12%">
            <font size="9"><?php echo str_replace('.00', '', number_format($nowa_knetto, 2, '.', ' '));?></font>
        </td>
        <td align="center" class="center" width="10%">
            <font size="9"><?php echo $pozycja['stawka_vat'];?>%</font>
        </td>
        <td align="right" class="right" width="11%">
            <font size="9"><?php echo str_replace('.00', '', number_format($nowa_vat, 2, '.', ' '));?></font>
        </td>
        <td align="right" class="right" width="12%">
            <font size="9"><?php echo str_replace('.00', '', number_format($nowa_brutto, 2, '.', ' '));?></font>
        </td>
    </tr>
    <?php } ?>
    <?php } ?>
</table>

<table border="1" cellpadding="7" cellspacing="0">
    <tr>
        <td bgcolor="#EDEDED" width="70%">
            <font size="8">Do zapłaty słownie</font>
        </td>
        <td align="right" class="right" bgcolor="#EDEDED" width="30%">
            <font size="8">Do zapłaty</font>
        </td>
    </tr>
    <tr>
        <td width="70%">
            <?php
                $klasa_slownie = new slownie;
                echo ucfirst(trim($klasa_slownie -> pokaz($nowa_brutto))); 
            ?>
        </td>
        <td align="right" class="right wartosc" width="30%">
            <font size="13"><b><?php echo str_replace('.00', '', number_format($nowa_brutto, 2, '.', ' '));?> PLN</b></font>
        </td>
    </tr>
</table>
<br />
Razem:<br />
<table border="1" cellpadding="5" style="font-size:7;">
<tr>
<td width="31%" bgcolor="#EDEDED">
Kwota (brutto) do zwrotu nabywcy:
</td>
<td width="19%">
<?php echo $roznica_brutto; ?>
</td>
<td width="31%" bgcolor="#EDEDED">
Kwota (brutto) do zapłaty przez nabywcę:
</td>
<td width="19%">

</td>
</tr>
<tr>
<td width="31%" bgcolor="#EDEDED">
Kwota zmniejszenia ceny bez podatku (netto):
</td>
<td width="19%">
<?php echo $roznica_netto; ?>
</td>
<td width="31%" bgcolor="#EDEDED">
Kwota zwiększenia ceny bez podatku (netto):
</td>
<td width="19%">
</td>
</tr>
<tr>
<td width="31%" bgcolor="#EDEDED">
Kwota zmniejszenia podatku należnego:
</td>
<td width="19%">
<?php echo $roznica_vat; ?>
</td>
<td width="31%" bgcolor="#EDEDED">
Kwota zwiększenia podatku należnego:
</td>
<td width="19%">
</td>
</tr>
<tr>
<td width="31%" bgcolor="#EDEDED">
Forma płatności: 
</td>
<td width="69%">Przelew</td>
</tr>
</table>
<br /><br />
<?php if($faktura['forma_zaplaty'] == 'Przelew'){ ?>
<table border="1" cellpadding="7" cellspacing="0">
    <tr>
        <td bgcolor="#EDEDED" width="20%">
            Sposób zapłaty
        </td>
        <td width="20%">
            <?php echo ucfirst($faktura['forma_zaplaty']);?>
        </td>
        <td bgcolor="#EDEDED" width="20%">
            W Banku:
        </td>
        <td width="40%">
            <?php echo PAYMENTS_TRANSFER_BANK_NAME;?>
        </td>
    </tr>
    <tr>
        <td bgcolor="#EDEDED" width="20%">
            Termin zapłaty
        </td>
        <td width="20%">
            
        </td>
        <td bgcolor="#EDEDED" width="20%">
            Nr konta:
        </td>
        <td width="40%">
            <?php echo PAYMENTS_TRANSFER_ACCOUNT_NUMBER;?>
        </td>
    </tr>
</table>
<?php }else{ ?>
<table border="1" cellpadding="7" cellspacing="0">
    <tr>
        <td bgcolor="#EDEDED" width="20%">
            Sposób zapłaty
        </td>
        <td width="20%">
            
        </td>
    </tr>
</table>
<?php } ?>

<br /><br />
<table border="1" cellpadding="10" cellspacing="3">
    <tr>
        <td>
            Powód korekty:<br />
            <?php echo $faktura['adnotacje'] ? nl2br($faktura['adnotacje']) : '<br />';?>
        </td>
    </tr>
</table>

<br /><br />

<table border="1" cellpadding="10" cellspacing="3" class="podpisy">
    <tr>
        <td>
            Podpis odbiorcy
            <br /><br /><br />
        </td>
        <td>
            Podpis wystawcy
            <br /><br /><br />
        </td>
    </tr>
</table>

<p class="ustawa"><font align="center" color="#777" size="8">Podstawą do wystawiania faktur VAT bez podpisu osoby uprawnionej do jej wystawienia oraz odbioru, jest §9 Rozporządzenia Ministra Finansów z dnia 25 maja 2005 r. Dz. U. Nr 95/2005 poz. 798</font></p>
