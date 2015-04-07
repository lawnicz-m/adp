<?php

    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

?>
<style type="text/css">
body {
	margin-bottom: 70px;
	margin-top: 80px;
}
.pasek_sprawdzania {
	background: #FFF;
	border-bottom: 1px solid #CCC;
	height: 80px;
	top: 0px;
	left: 0px;
	position: fixed;
	width: 100%;
	z-index: 1000000;
}
.guziki_zapisu {
	background: #FFF;
	border-top: 1px solid #CCC;
	bottom: 0px;
	left: 0px;
	position: fixed;
}
</style>
<script type="text/javascript">

    function window.open(theURL,winName,features)  {
	   var width = 700;
    var height = 450;
    var left = parseInt((screen.availWidth/2) - (width/2));
    var top = parseInt((screen.availHeight/2) - (height/2));
    var windowFeatures = "width=" + width + ",height=" + height + ",status,resizable,left=" + left + ",top=" + top + "screenX=" + left + ",screenY=" + top;
	
	

  window.open(theURL,winName,windowFeatures);
}
		
		
</script>
<?php

    forms::title(array('title' => 'Wyniki na dzień '.texts::nice_date($data)));

    if($frazy){

        // lista fraz do sprawdzajki
        $frazy_do_sprawdzajki = '';
        foreach($frazy as $fraza){ $frazy_do_sprawdzajki .= $fraza['id_frazy'].'|'.$fraza['nazwa'].'||'; }
        $frazy_do_sprawdzajki = substr($frazy_do_sprawdzajki, 0, -2);
		
		// lista fraz do gotlink
		$frazy_do_gotlink = '';
		foreach($frazy as $frazas){ $frazy_do_gotlink .=$frazas['nazwa'].'|'; $frazy_do_gotlink .=$frazas['fraza_link'].'|'; }
        $frazy_do_gotlink = substr($frazy_do_gotlink, 0, -1);
        ?>
<div class="pasek_sprawdzania">
  <?php
        forms::open(array('action' => '',
                          'target' => 'ramka_sprawdzajka'));

        forms::select(array('data' => $this -> load -> model('frazy') -> serwery_sprawdzajace(1),
                            'fieldClass' => 'width_auto',
                            'id' => 'serwer_sprawdzajacy',
                            'label' => 'Serwer',
                            'labels' => 'etykieta',
                            'name' => 'serwer_sprawdzajacy',
                            'values' => 'wartosc'));
							
							
        forms::select(array('data' => $this -> load -> model('frazy') -> serwery_sprawdzajace_ip(),
                            'fieldClass' => 'width_auto',
                            'id' => 'serwer_sprawdzajacy_ip',
                            'label' => 'IP / Kraj',
                            'labels' => 'nazwa',
                            'name' => 'ip',
                            'values' => 'ip'));

        forms::hidden(array('id' => 'nazwa_pliku',
                            'name' => 'nazwa_pliku',
                            'value' => ''));

        forms::hidden(array('id' => 'adres_strony',
                            'name' => 'adres_strony',
                            'value' => ''));

        forms::hidden(array('id' => 'frazy',
                            'name' => 'frazy',
                            'value' => ''));

        forms::button(array('fieldClass' => 'width_auto',
                            'link' => '#',
                            'rel' => 'sprawdz_wszystkie',
                            'style' => 'float: left; margin: 17px 15px 0 0;',
                            'value' => 'Sprawdź'));

        forms::button(array('value' => '&#171; Wcześn',
                            'link' => url::page('frazy/pozycje/'.$klient['id_klienta'].'/'.date('Y-m-d', strtotime('-1 day', strtotime($data)))),
                            'style' => 'float: left; margin: 17px 15px 0 0;'));

        forms::button(array('value' => 'Późn &#187;',
                            'link' => url::page('frazy/pozycje/'.$klient['id_klienta'].'/'.date('Y-m-d', strtotime('+1 day', strtotime($data)))),
                            'style' => 'float: left; margin: 17px 15px 0 0;'));

        forms::info(array('fieldClass' => 'width_auto',
                          'value' => '<iframe class="floatLeft" src="'.url::page('klienci/panel/'.$klient['id_klienta']).'" name="ramka_sprawdzajka" style="border: 1px solid #CCC; height: 50px; overflow: hidden; width: 150px;" scrolling="no"></iframe>'));
						  
   /*forms::select(array('data' => $this -> load -> model('frazy') -> rodzaj_kat(),
                            'fieldClass' => 'width_auto',
                            'id' => 'rodzaj_kat',
                            'label' => 'Kategoria',
                         'labels' => 'nazwa',
                            'name' => 'rk',
                            'values' => 'rk'));
							
				 forms::button(array('fieldClass' => 'width_auto',
                            'link' => url::page('gotlink.php?frazy='.$frazy_do_gotlink),
                            //'rel' => 'pisz_gotlink',
							
                            'style' => 'float: left; margin: 17px 15px 0 0;',
                            'value' => 'Gotlink'));	*/
							
							
        forms::close(0);
		

if(($uzytkownik['typ'] == 'admin' && $uzytkownik['id'] == '1' || $uzytkownik['id'] == '4' || $uzytkownik['id'] == '6' || $uzytkownik['id'] == '126')){
?>
<table>
	<tr>
		<td>
			<form action="../../gotlink.php" method="GET" target="formtarget" onSubmit="window.open('about:blank','formtarget','scrollbars=1, width=775,height=700')">
    			<div class="formField width_auto">
			    <!--<select class="formSelect" id="rodzaj_kat" name="rk" >
			          <option value="1">Gry</option>
			          <option value="2" selected="selected">Handel, Biznes, Ekonomia</option>
			          <option value="3">Internet i Komputery</option>
			          <option value="4">Katalogi Stron i Fora</option>
			          <option value="5">Kultura i Sztuka</option>
			          <option value="6">Loga, Dzwonki, Sms</option>
			          <option value="7">Motoryzacja</option>
			          <option value="8">Nauka, Edukacja, Przyroda</option>
			          <option value="9">Media, Polityka, Spoleczenstwo</option>
			          <option value="10">Obcojezyczne</option>
			          <option value="11">Rozrywka i Hobby</option>
			          <option value="12">Turystyka, Sport, Zdrowie</option>
			          <option value="13">Inne</option>
			        </select>-->
			        <input type="hidden" name="rk" value="2"/>
			        <input type="hidden" name="frazy" value="<?php echo $frazy_do_gotlink; ?>"/>
			        
				</div>
    			<input type=submit value="Generator"/>
  			</form>
  		</td>
  		<td>
  			<form action="../../gotlink.php" method="GET" target="formtarget" onSubmit="window.open('about:blank','formtarget','width=260,height=520')">
  				<input type="hidden" name="frazy" value="<?php echo $frazy_do_gotlink; ?>"/>
  				<input type=submit value="Lista fraz"/>
  			</form>
  		</td>
  		<td>
  			<form action="../../gotlink.php" method="GET" target="formtarget" onSubmit="window.open('about:blank','formtarget','width=900,height=200')">
  				<input type="hidden" name="frazy" value="<?php echo $frazy_do_gotlink; ?>"/>
  				<input type="hidden" name="link" value="<?php echo $klient['hash'];?>"/>
  				<input type="hidden" name="key" value="1"/>
  				<input type=submit value="Meta Robots"/>
  			</form>
  		</td>
  	</tr>
</table>
<?php
} else {
?>
<table>
	<tr>
		<td>
			<form action="../../gotlink.php" method="GET" target="formtarget" onSubmit="window.open('about:blank','formtarget','width=775,height=700')">
				<input type="hidden" name="frazy" value="<?php echo $frazy_do_gotlink; ?>"/>
				<input type=submit value="frazy"/>
			</form>
		</td>
		<td>
			<form action="../../gotlink.php" method="GET" target="formtarget" onSubmit="window.open('about:blank','formtarget','width=775,height=700')">
				<input type="hidden" name="frazy" value="<?php echo $frazy_do_gotlink; ?>"/>
				<input type="hidden" name="link" value="<?php echo $klient['hash'];?>"/>
				<input type="hidden" name="key" value="1"/>
				<input type=submit value="key"/>
			</form>
		</td>
	</tr>
</table>
<?php } ?>
</div>
<?php

        forms::open(array('action' => url::page(CONTROLLER.'/zapisz-pozycje/'.$klient['id_klienta'].'/'.$data)));

        ?>
<style type="text/css">
            .pozycja_google{
                background: #DEDEDE;
            }
            .pierwsza_strona_pole{
                left: -50px;
                position: relative;
            }
        </style>
<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
  <tr>
    <td class="center"></td>
    <td class="center" style="width: 15%;">Wcześniejsza</td>
    <td class="center"></td>
    <td class="center" style="width: 15%;"><?php echo texts::nice_date($data);?></td>
    <td class="center"></td>
    <td class="center" style="width: 15%;">Google</td>
    <td class="center"></td>
    <td class="center"></td>
  </tr>
  <?php
        foreach($frazy as $fraza){
            $suma_pozycji = 0;
            ?>
  <tr>
    <?php
            ?>
    <td><?php

            ?>
      <div style="font-size: 16px; padding: 19px 0px; text-align: right;"><a class="noCover" href="http://www.google.pl/search?hl=pl&amp;q=<?php echo $fraza['nazwa'];?>&amp;hl=pl&amp;newwindow=1&amp;num=10&amp;lr=lang_pl" rel="external">
        <?php echo $fraza['nazwa'];?>
        </a></div>
      <?php

            ?></td>
    <td><?php

            forms::text(array('fieldClass' => 'stary_wynik',
                              'id' => 'wczesniejsza_pozycja_frazy_'.$fraza['id_frazy'],
                              'name' => 'wczesniejsze_pozycje['.$fraza['id_frazy'].']',
                              'readOnly' => 1,
                              'value' => isset($wczesniejsze_pozycje[$fraza['id_frazy']]) ? $wczesniejsze_pozycje[$fraza['id_frazy']] : 0));

            ?></td>
    <td><?php

            $w_ps = isset($wczesniejsze_pierwsze_strony[$fraza['id_frazy']]) ? $wczesniejsze_pierwsze_strony[$fraza['id_frazy']] : 0;
            forms::checkbox(array('checked' => $w_ps,
                                  'fieldClass' => 'pierwsza_strona_pole',
                                  'id' => 'wczesniejsza_pierwsza_strona_'.$fraza['id_frazy'],
                                  'label' => '',
                                  'name' => 'wczesniejsze_pierwsze_strony['.$fraza['id_frazy'].']'));

            ?></td>
    <td><?php

            $a_p = isset($aktualne_pozycje[$fraza['id_frazy']]) ? $aktualne_pozycje[$fraza['id_frazy']] : 0;
            $suma_pozycji = $suma_pozycji + $a_p;
            forms::text(array('id' => 'pozycje_'.$fraza['id_frazy'],
                              'name' => 'pozycje['.$fraza['id_frazy'].']',
                              'value' => $a_p));

            ?></td>
    <td><?php

            $a_ps = isset($aktualne_pierwsze_strony[$fraza['id_frazy']]) ? $aktualne_pierwsze_strony[$fraza['id_frazy']] : 0;
            forms::checkbox(array('checked' => $a_ps,
                                  'fieldClass' => 'pierwsza_strona_pole',
                                  'id' => 'pierwsza_strona_'.$fraza['id_frazy'],
                                  'label' => '',
                                  'name' => 'pierwsze_strony['.$fraza['id_frazy'].']'));

            ?></td>
    <td><?php

            forms::text(array('fieldClass' => 'oficjalny_wynik pozycja_google r5',
                              'id' => 'sprawdzajka_'.$fraza['id_frazy'],
                              'name' => 'sprawdzajka['.$fraza['id_frazy'].']',
                              'readOnly' => 1));

            ?></td>
    <td><?php

            forms::checkbox(array('checked' => 0,
                                  'fieldClass' => 'pierwsza_strona_pole',
                                  'id' => 'sprawdzajka_pierwsza_strona_'.$fraza['id_frazy'],
                                  'label' => '',
                                  'name' => 'sprawdzajka_pierwsze_strony['.$fraza['id_frazy'].']'));

            ?></td>
    <?php

            ?>
    <td style="padding: 0 0 0 20px;"><a class="pojedyncze_sprawdzenie" href="#" rel="<?php echo ($fraza['id_frazy'].'|'.$fraza['nazwa']);?>">Sprawdź</a></td>
    <?php

            ?>
  </tr>
  <?php
        }
        ?>
</table>
<?php

        forms::submit(array('fieldClass' => 'guziki_zapisu',
                            'keepEditing' => 1));

        forms::close(0);

    ?>
	
		
<script type="text/javascript">
		
		
        function sprawdz(frazy_do_sprawdzenia){
            preloader();
            var adres_strony = '<?php echo $klient['adres_strony'];?><?php if($klient['adres_strony_2']){ ?>,<?php echo $klient['adres_strony_2'];?><?php } ?>';
            $('#adres_strony').val(adres_strony);
            $('#frazy').val(frazy_do_sprawdzenia);
            nazwa_pliku = '<?php echo $klient['id_klienta'];?>' + new Date().getTime() +'-ok-'+ '.txt';
            $('#nazwa_pliku').val(nazwa_pliku);
            $('form[target="ramka_sprawdzajka"]').attr('action', 'http://' + $('#serwer_sprawdzajacy option:selected').text() + '/fm33/szukanie.php');
            sprawdzaj(nazwa_pliku);
            $('form[target="ramka_sprawdzajka"]').submit();
        }

        function sprawdzaj(nazwa_pliku){
            $.ajax({
              url: '<?php echo url::page('odczyt.php');?>?url=http://' + $('#serwer_sprawdzajacy option:selected').text() + '/fm33/wyniki/' + nazwa_pliku,
              type: "GET",
              dataType: "text",
              error: function(xhr, ajaxOptions, thrownError){
                  setTimeout("sprawdzaj_2();", 1000);
              },
              success: function(data) {
                var fraza = data.split('||');
                for(var i in fraza){
                    var id = fraza[i].split('|')[0];
                    var ciag = fraza[i].split('|')[1];
                    if(ciag){
                        var nowy_wynik = ciag.split('-')[0];
                        var pierwsza_strona = ciag.split('-')[1];
                        var stary_wynik = $('#pozycje_' + id).val();

                        $('#sprawdzajka_' + id + '_disabled').val(nowy_wynik);

                        if(pierwsza_strona == 1) $('#sprawdzajka_pierwsza_strona_' + id).attr('checked','checked');
                        else $('#sprawdzajka_pierwsza_strona_' + id).removeAttr('checked');

                        if(parseInt(stary_wynik) > 0){
                            var kolor = '#DEDEDE';
                            if(parseInt(nowy_wynik) > parseInt(stary_wynik)) kolor = '#FFDFDF';
                            if(parseInt(nowy_wynik) < parseInt(stary_wynik)) kolor = '#E1FFAF';
                            if(parseInt(nowy_wynik) == 0 && parseInt(stary_wynik) > 0) kolor = '#FFDFDF';
                            $('#field_sprawdzajka_' + id).css({backgroundColor: kolor});
                        }
                    }
                }
                wylacz_preloader();
              }
            });
        }

        function sprawdzaj_2(){
            sprawdzaj(nazwa_pliku);
        }

        var pressed = false;

        $(document).ready(function(){
            // kopiowanie pojedyńczej pozycji
            <?php foreach($frazy as $fraza){ ?>
            $('#field_sprawdzajka_<?php echo $fraza['id_frazy'];?>').click(function(e){
                if(e.shiftKey){
                    kopiuj_wszystkie();
                }else{
                    $('#pozycje_<?php echo $fraza['id_frazy'];?>').val($('#sprawdzajka_<?php echo $fraza['id_frazy'];?>_disabled').val());

                    if($('#sprawdzajka_pierwsza_strona_<?php echo $fraza['id_frazy'];?>').attr('checked') == true) $('#pierwsza_strona_<?php echo $fraza['id_frazy'];?>').attr('checked','checked');
                    else $('#pierwsza_strona_<?php echo $fraza['id_frazy'];?>').removeAttr('checked');
                }
            });
            $('#field_wczesniejsza_pozycja_frazy_<?php echo $fraza['id_frazy'];?>').click(function(e){
                if(e.shiftKey){
                    kopiuj_wszystkie_stare();
                }else{
                    $('#pozycje_<?php echo $fraza['id_frazy'];?>').val($('#wczesniejsza_pozycja_frazy_<?php echo $fraza['id_frazy'];?>_disabled').val());

                    if($('#wczesniejsza_pierwsza_strona_<?php echo $fraza['id_frazy'];?>').attr('checked') == true) $('#pierwsza_strona_<?php echo $fraza['id_frazy'];?>').attr('checked','checked');
                    else $('#pierwsza_strona_<?php echo $fraza['id_frazy'];?>').removeAttr('checked');
                }
            });
            <?php } ?>
            var suma_pozycji = <?php echo $suma_pozycji;?>;
            if(suma_pozycji == 0) kopiuj_wszystkie_stare();

            $('.pojedyncze_sprawdzenie').click(function(){
                sprawdz($(this).attr('rel'));
                return false;
            });

            $('a[rel="sprawdz_wszystkie"]').click(function(){
                sprawdz('<?php echo $frazy_do_sprawdzajki;?>');
                return false;
            });
			$('a[rel="pisz_gotlink"]').click(function(){
                pisz_gotlink('<?php echo $frazy_do_gotlink;?>');
                return false;
            });

        });

        // kopiowanie wszystkich pozycji
        function kopiuj_wszystkie(){
            $('.oficjalny_wynik').each(function(){
                var id = $(this).attr('id');
                id = id.replace('field_sprawdzajka_', '');
                var pozycja = $('#sprawdzajka_' + id + '_disabled').val();
                if(pozycja != ''){
                    $('#pozycje_' + id).val(pozycja);

                    if($('#sprawdzajka_pierwsza_strona_' + id).attr('checked') == true) $('#pierwsza_strona_' + id).attr('checked','checked');
                    else $('#pierwsza_strona_' + id).removeAttr('checked');
                }
            });
        }

        // kopiowanie wszystkich starych pozycji
        function kopiuj_wszystkie_stare(){
            $('.stary_wynik').each(function(){
                var id = $(this).attr('id');
                id = id.replace('field_wczesniejsza_pozycja_frazy_', '');
                var pozycja  = $('#wczesniejsza_pozycja_frazy_' + id + '_disabled').val();
                $('#pozycje_' + id).val(pozycja);

                if($('#wczesniejsza_pierwsza_strona_' + id).attr('checked') == true) $('#pierwsza_strona_' + id).attr('checked','checked');
                else $('#pierwsza_strona_' + id).removeAttr('checked');
            });
        }

        -->
    </script>
<?php

    }

    $this -> load -> view('footer');

?>
