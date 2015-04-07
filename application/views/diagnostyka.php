<?php

    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    forms::title(array('title' => 'Diagnostyka dla strony '.$adres_strony));

    if($frazy){

        ?><style type="text/css">
            body{
                margin-bottom: 70px;
                margin-top: 80px;
            }
            .pasek_sprawdzania{
                background: #FFF;
                border-bottom: 1px solid #CCC;
                height: 80px;
                top: 0px;
                left: 0px;
                position: fixed;
                width: 100%;
                z-index: 1000000;
            }
            .guziki_zapisu{
                background: #FFF;
                border-top: 1px solid #CCC;
                bottom: 0px;
                left: 0px;
                position: fixed;
            }
        </style><?php

        // lista fraz do sprawdzajki
        $frazy_do_sprawdzajki = '';
        foreach($frazy as $fraza){
            $frazy_do_sprawdzajki .= $fraza['id_frazy'].'|'.$fraza['nazwa'].'||';
        }
        $frazy_do_sprawdzajki = substr($frazy_do_sprawdzajki, 0, -2);

        ?><div class="pasek_sprawdzania"><?php
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

        forms::info(array('fieldClass' => 'width_auto',
                          'value' => '<iframe class="floatLeft" src="" name="ramka_sprawdzajka" style="border: 1px solid #CCC; height: 50px; overflow: hidden; width: 150px;" scrolling="no"></iframe>'));

        forms::close(0);

        ?></div><?php

        forms::open(array('action' => url::page(CONTROLLER)));

        ?>
        <style type="text/css">
            .pozycja_google .i, .pierwsza_strona_pole .i{
                padding: 5px;
            }
            .pozycja_google input{
                border: 0;
                text-align: center;
                padding: 0;
                width: 30px;
            }
            .pierwsza_strona_pole{

            }
        </style>
        <div class="center">
        <table border="1" bordercolor="#CCC" cellpadding="0" cellspacing="0" style="margin: auto; width: auto;">
        <?php
        foreach($frazy as $fraza){
            ?><tr><?php
            ?><td style="padding: 0 10px;"><?php

            ?><div style="font-size: 16px; text-align: right;"><a class="noCover" href="http://www.google.pl/search?hl=pl&amp;q=<?php echo $fraza['nazwa'];?>&amp;hl=pl&amp;newwindow=1&amp;num=10&amp;lr=lang_pl" rel="external" style="text-decoration: none;"><?php echo $fraza['nazwa'];?></a></div><?php

            ?></td><td><?php

            forms::text(array('fieldClass' => 'oficjalny_wynik pozycja_google',
                              'id' => 'sprawdzajka_'.$fraza['id_frazy'],
                              'name' => 'sprawdzajka['.$fraza['id_frazy'].']'));

            ?></td><td><?php

            forms::checkbox(array('checked' => 0,
                                  'fieldClass' => 'pierwsza_strona_pole',
                                  'id' => 'sprawdzajka_pierwsza_strona_'.$fraza['id_frazy'],
                                  'label' => '',
                                  'name' => 'sprawdzajka_pierwsze_strony['.$fraza['id_frazy'].']'));

            ?></td><?php

            ?><td style="padding: 0 10px;"><a class="pojedyncze_sprawdzenie" href="#" rel="<?php echo ($fraza['id_frazy'].'|'.$fraza['nazwa']);?>">Sprawdź</a></td><?php

            ?></tr><?php
        }
        ?></table></div><?php

        forms::close(0);

    ?>
    <script type="text/javascript">
        <!--
        var nazwa_pliku = '';
        function sprawdz(frazy_do_sprawdzenia){
            preloader();
            var adres_strony = '<?php echo $adres_strony;?>';
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
                  setTimeout("sprawdzaj_2();", 2000);
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

                        $('#sprawdzajka_' + id ).val(nowy_wynik);

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
           $('.pojedyncze_sprawdzenie').click(function(){
                sprawdz($(this).attr('rel'));
                return false;
            });

            $('a[rel="sprawdz_wszystkie"]').click(function(){
                sprawdz('<?php echo $frazy_do_sprawdzajki;?>');
                return false;
            });

        });
        -->
    </script>
    <?php

    }else{

        ?><style type="text/css">
            #meta_tags_extractor{
                float: left;
                padding-top: 40px;
                width: 50%;
            }
        </style><?php

        forms::open(array('action' => url::page(CONTROLLER)));

        forms::text(array('fieldClass' => 'widthHalf',
                          'id' => 'adres_strony',
                          'label' => 'Adres strony',
                          'name' => 'adres_strony',
                          'required' => 1,
                          'subLabel' => 'W formacie: onet.pl, wp.pl (bez http://www, www)'));
        if(($uzytkownik['typ'] == 'admin' || $uzytkownik['typ'] == 'partner') && $uzytkownik['id'] == '1'){
        ?>
        <div id="meta_tags_extractor">
            <a href="#">Pobierz słowa kluczowe ze strony</a>
        </div>
        <?php
        }

        forms::textarea(array('name' => 'frazy',
                              'id' => 'frazy',
                              'label' => 'Frazy',
                              'required' => 1,
                              'subLabel' => 'Każda w nowej linii'));

        forms::submit(array('label' => 'Sprawdź'));

        forms::close(0);

        ?>
        <script type="text/javascript">
            <!--
            $(document).ready(function(){
                $('#meta_tags_extractor a').click(function(){
                    var adres = $('#adres_strony').val();
                    if(adres){
	                      $.ajax({url: '<?php echo url::base();?>diagnostyka/pobierz_slowa_kluczowe/' + adres,
	                              type: 'POST',
	                              success: function(responseText){
	                                  if(responseText == ''){
	                                      alert('Nie znaleziono fraz. Spróbuj wpisać frazy ręcznie.')
	                                  }else{
	                                      $('#frazy').val(responseText);
	                                  }
	                              }
	                      });
                    }else{
                        alert('Nie wpisano adresu!');
                    }
                    return false;
                });
            });
            -->
        </script>
        <?php

    }

    $this -> load -> view('footer');

?>