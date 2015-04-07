<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, noarchive, nosnippets" />
        <link href="<?php echo url::base();?>inc/cms/css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo url::base();?>inc/cms/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo url::base();?>inc/cms/js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#frazy").tablesorter({
                    widgets: ['zebra'],
                    sortList: [[1,1]],
                    headers: { 1: { sorter: 'digit' },
                               2: { sorter: 'digit' },
                               3: { sorter: 'digit' }
                             }
                });

                $('a[rel="external"]').attr('target', '_blank');
            });
        </script>
        <style type="text/css">
            form#ga{
                background: #EDEDED;
                border: 1px solid #ccc;
                padding: 10px;
                width: 210px;
            }
            form#ga label{
                display: block;
                width: 100px;
                margin: 6px;
            }
            form#ga input{
                display: block;
                width: 200px;
                margin: 3px;
            }
            form#ga .submit{
                width: 100px;
                margin: 10px 0 0 55px;
            }
            table.graph{
                border:0;
                border-collapse: collapse;
                width: 100%;
            }
            table.graph td{
                padding: 5px;
                border-top: 1px solid #EDEDED;
            }
            table.graph .bar{
                height: 10px;
                background: orange;
            }
        </style>
        <title><?php echo APP_NAME;?></title>
    </head>
    <body>

        <div id="header">

            <img alt="" class="logo" src="<?php echo url::base();?>inc/logo.png" />

            <?php if($klient['etap'] == 6){ ?>
            <b style="color: red; font-size: 16px;">Pozycjonowanie zawieszone</b>
            &nbsp; &nbsp;
            <?php } ?>
            Witaj <b><?php echo $klient['nazwa'];?></b>!
            &nbsp; &nbsp;

		    <div class="clear"></div>

        </div>

        <?php
            $pokazuj_akceptacje = false;
            if($pokazuj_akceptacje){
                $typ_fraz = $this -> load -> model('frazy') -> sprawdz_jakie_sa_frazy($klient['id_klienta']);
                if($typ_fraz == 3 || $typ_fraz == 1){
                    $frazy = false;
        ?>
        <div class="text">
            <div style="border: 1px solid #CCC; height: 300px; overflow: auto; width: 600px;">
                <div style="padding: 15px;">

                    <h3>Akceptacja zmian w rozliczaniu za wyniki</h3>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus id ante purus. Duis tristique tempor magna, ut pellentesque arcu suscipit a. Aliquam eget urna at lorem pretium euismod. Donec et sem arcu, sit amet vestibulum lectus. Phasellus in nisi libero, a feugiat metus. Suspendisse dignissim nunc id nibh dignissim accumsan. Mauris id lacus metus. Nunc neque massa, pretium ac fringilla faucibus, tincidunt a ante. Curabitur sit amet mauris magna. Sed sagittis ultricies velit, a suscipit ante vehicula in. Curabitur fringilla ante id massa euismod quis tristique lorem pretium.</p>

                    <p>Nullam facilisis egestas pretium. Duis odio libero, luctus nec luctus dignissim, congue non tortor. Integer nunc lacus, egestas eu cursus ac, feugiat a ante. Praesent magna eros, viverra vitae lobortis sit amet, placerat posuere libero. Sed vel hendrerit eros. Vivamus nisi quam, congue non pretium vel, elementum interdum felis. Curabitur vulputate hendrerit odio, quis sollicitudin nibh blandit sit amet. Phasellus tristique porta turpis, ut sollicitudin leo luctus at. Aenean non sollicitudin nulla. Praesent eros lorem, aliquam ut pellentesque non, molestie eu enim. Curabitur non turpis ipsum, eu vestibulum ipsum. Nulla ac elementum ligula. Aliquam condimentum turpis ut lectus volutpat sit amet laoreet enim convallis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed eget nisl non elit dapibus blandit sit amet quis dolor. Nam condimentum sollicitudin mi sed ultrices. Maecenas pellentesque ligula in turpis congue consequat.</p>

                    <p>Suspendisse at urna nibh, non facilisis mauris. Integer ullamcorper mattis risus, et pharetra ipsum dictum nec. Quisque fringilla eros sit amet dolor consequat malesuada. Nulla facilisi. Duis ultricies, urna in adipiscing pulvinar, lorem nulla malesuada justo, vel placerat neque nulla quis risus. Nunc pellentesque, libero quis ultricies egestas, turpis sapien dignissim ipsum, vitae fringilla lorem turpis ut metus. Cras erat est, facilisis consequat hendrerit ac, mattis molestie elit. Nullam quis elit in nibh varius varius vel eu neque. Donec laoreet scelerisque massa, quis ullamcorper odio tincidunt a. Donec eu mi turpis, a sagittis velit. Mauris eget odio ut mi venenatis fringilla vitae ut lectus. In hac habitasse platea dictumst. </p>

                </div>
            </div>

            <form action="<?php echo url::page('klient/akceptacja_zmiany_na_pierwsza_strone/'.$klient['hash']);?>" method="post">
                <p>
                    <input name="akceptacja" id="akceptacja_tak" type="radio" value="tak" />
                    <label for="akceptacja_tak" style="color: green;">&nbsp;Akceptuję wyżej wymienione warunki</label>
                </p>
                <p>
                    <input name="akceptacja" id="akceptacja_nie" type="radio" value="nie" />
                    <label for="akceptacja_nie" style="color: red;">&nbsp;Nie akceptuję wyżej wymienionych warunków</label>
                </p>
                <p>
                    <input type="submit" value="Zatwierdź wybór" />
                </p>
            </form>
        </div>
        <?php
                }
            }
        ?>

        <table id="page">
            <tr>
                <td id="menu">
                    <div id="side">
                        <h3>Pozycje fraz na dzień <?php echo texts::nice_date($data);?></h3>
                    <?php if($aktualne_pozycje['status'] == 1){ ?>

                        <table border="0" cellpadding="0" cellspacing="0" id="frazy">
                            <thead>
                                <tr>
                                    <th>Fraza</th>
                                    <th>Pozycja</th>
                                    <th>Zmiana</th>
                                    <th>Best</th>
                                    <th>1&nbsp;str.</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; foreach($aktualne_pozycje['dane'] as $fraza){ ?>
                                <tr<?php if($i){ ?> class="odd"<?php } ?>>
                                    <td class="fraza">
                                        <?php
                                            $start = 0;
                                            if($fraza['pozycja']) $start = $fraza['pozycja'] - $fraza['pozycja'][strlen($fraza['pozycja']) - 1];
                                            if($fraza['pierwsza_strona']) $start = 0;
                                        ?>
                                        <a class="noLine" href="http://www.google.pl/search?hl=pl&amp;q=<?php echo $fraza['nazwa']?>&amp;hl=pl&amp;num=10<?php if($start){ ?>&amp;start=<?php echo $start;?><?php } ?>" rel="external">
                                            <?php echo $fraza['nazwa'];?>
                                        </a>
                                    </td>
                                    <td style="background-color: <?php if($fraza['pierwsza_strona']){ ?>#88DF29<?php }else{ ?>#FFF6CF<?php } ?>; border-bottom: 1px solid #FFF;">
                                        <?php echo $fraza['pozycja'];?>
                                    </td>
                                    <td style="color: <?php if(!$fraza['zmiana']){ echo'#4E92F6'; }else{ echo $fraza['tenedencja'] == '+' ? 'green' : 'red'; } ?>;">
                                        <?php echo ($fraza['zmiana'] ? $fraza['tenedencja'].$fraza['zmiana']: 0);?>
                                    </td>
                                    <td>
                                        <?php echo $fraza['najlepsza_pozycja'];?>
                                    </td>
                                    <td>
                                        <?php echo $fraza['pierwsza_strona'] ? 'tak' : 'nie';?>
                                    </td>
                                </tr>
                            <?php $i++; if($i == 2){ $i = 0; } } ?>
                            </tbody>
                        </table>
                        
                    <?php }else{ ?>
                        <?php echo $aktualne_pozycje['dane'];?>
                    <?php } ?>
<br /><br />
<?php
    forms::button(array('value' => 'Późniejsze &#187;',
                        'link' => url::page('klient/wyniki/'.$klient['hash'].'/'.date('Y-m-d', strtotime('+1 day', strtotime($data))))));

    forms::button(array('value' => '&#171; Wcześniejsze',
                        'link' => url::page('klient/wyniki/'.$klient['hash'].'/'.date('Y-m-d', strtotime('-1 day', strtotime($data))))));
?>
<br />
<br />
<br />
<strong>Powyższe okno pokazuje nam<br />
aktualne pozycje fraz na dany dzień.</strong><br />
<br />
<strong>Nagłówki oznaczają :</strong><br />
<br />
<strong>Fraza</strong> – słowo kluczowe lub fraza której pozycję badamy;<br /><br />
<strong>Pozycja</strong> – aktualna pozycja danej frazy w wyszukiwarce;<br /><br />
<strong>Zmiana</strong> – pokazuje czy była zmiana pozycji w stosunku do dnia poprzedniego, jeżeli tak to o ile pozycji w górę lub w dół;<br /><br />
<strong>Best</strong> – najlepsza pozycja w wyszukiwarce jaką zajmowała strona dla danego słowa kluczowego lub frazy;<br /><br />
<strong>Pierwsza strona (tak/nie)</strong> – informacja czy dana fraza jest na pierwszej stronie wyników. Warto zwrócić uwagę, że po zmianach w algorytmach wyświetlania wyszukiwarki, na pierwszej stronie może być wyświetlanych więcej niż 10 wyników wyszukiwania. Może to być przykładowo 12, 15 i więcej;<br />
<br />
Najeżdżając kursorem i klikając dany nagłówek możemy uzyskać uporządkowanie wyników wg. wskazanego nagłówka : alfabetycznie wg fraz lub słów kluczowych, zajmowanej pozycji, zmiany pozycji, najlepszego wyniku.<br />
<br />
Pamiętany jest każdy dzień wyników od momentu włączenia danej strony do naszego systemu. Na dole listy wyników widoczne są przyciski oznaczone Wcześniejszy i Późniejszy. Pozwalają one na przeglądanie zapamiętanej historii wyników pozycjonowania dzień po dniu.<br />
                    <br />
					</div>
                </td>
                <td id="content">

                    <div class="text">
                        <?php if($globalny_komunikat_dla_klientow) { ?>
                        <div style="-moz-border-radius: 5px; -webkit-border-radius: 5px; background: url('<?php echo url::base();?>inc/cms/img/headerBackground.png') repeat-x scroll center top #FFFFFF; border: 1px solid #CCC; margin-bottom: 20px; padding: 10px;">
                            <h3>Informacja</h3>
                            <?php echo nl2br($globalny_komunikat_dla_klientow);?>
                        </div>
                        <?php } ?>

                        <?php
                        /*
                         * if($klient['komentarz_do_wynikow']){ ?>
                        <div style="-moz-border-radius: 5px; -webkit-border-radius: 5px; background: url('<?php echo url::base();?>inc/cms/img/headerBackground.png') repeat-x scroll center top #FFFFFF; border: 1px solid #CCC; margin-bottom: 20px; padding: 10px;">
                            <h3>Informacja</h3>
                            <?php echo nl2br($klient['komentarz_do_wynikow']);?>
                        </div>
                        <?php }
                        */
                        ?>

                        <?php if($odsetek_na_pierwszej_stronie['status'] == 1){
                            $odsetek_na_pierwszej_stronie = $odsetek_na_pierwszej_stronie['dane'];

                            forms::button(array('value' => '&#187;',
                                                'link' => url::page('klient/wyniki/'.$klient['hash'].'/'.date('Y-m-01', strtotime('+1 month', strtotime($miesiac.'-01')))
                                         )));

                            forms::button(array('value' => '&#171;',
                                                'link' => url::page('klient/wyniki/'.$klient['hash'].'/'.date('Y-m-01', strtotime('-1 month', strtotime($miesiac.'-01')))
                                         )));
?>

                        <a class="headButtons" href="<?php echo url::page('pdf/generuj.php?input_file='.url::page('klient/raport-miesieczny/'.$klient['hash'].'/'.$miesiac.'/pdf') . '&amp;output_file=raport_'.$miesiac.'_'.$klient['adres_strony'].'.pdf&amp;page_orientation=L');?>" rel="external">Pobierz raport w PDF</a>
                        <a class="headButtons" href="<?php echo url::page('klient/raport-miesieczny/'.$klient['hash'].'/'.$miesiac.'/csv');?>" target="_blank">Pobierz raport w CSV</a>

                        <h2><?php echo ucfirst(texts::czytelny_miesiac($miesiac, 2));?></h2>
                        <h3>Odsetek fraz na 1 stronie Google</h3>

                        <table border="0" cellpadding="0" cellspacing="0" class="tabela_slupkowa">
                            <tr>
                                <?php for($i = 1; $i <= count($odsetek_na_pierwszej_stronie); $i++){ ?>
                                <td>
                                    <div style="height: <?php echo $odsetek_na_pierwszej_stronie[$i];?>px;"></div>
                                    <span style="font-size: 10px;"><?php echo $odsetek_na_pierwszej_stronie[$i];?>%</span><br />
                                    <a href="<?php echo url::page('klient/wyniki/'.$klient['hash'].'/'.$miesiac.'-'.($i < 10 ? '0'.$i : $i));?>">
                                        <?php echo $i;?>
                                    </a>
                                </td>
                                <?php } ?>
                            </tr>
                        </table>

                        <div class="clear"></div>
                        
                        <br /><hr /><br />
						<strong>PANEL WYNIKÓW: INSTRUKCJA OBSŁUGI</strong><br />
						<strong>Przyciski :</strong/><br />
<strong>Pobierz raport w CSV</strong> – historia wyników pozycjonowania bieżącego miesiąca w formacie CSV;<br />
<strong>Pobierz raport w PDF</strong> – raport j/w w formacie Acrobat Adobe;<br />
<strong>Strzałki w Lewo lub w Prawo</strong> – zmiana aktualnie wyświetlanego miesiąca.<br />
<br />
<strong>Panel z wykresem słupkowym:</strong><br />
Odsetek fraz na 1 stronie Google – wykres miesięczny pokazuje ile % fraz jest na pierwszej stronie wyszukiwarki. Trzeba pamiętać, że po ostatnich zmianach, na pierwszej stronie często jest więcej niż 10 najlepszych wyników wyszukiwania. Najeżdżając kursorem na numer dnia na wykresie prezentującym Odsetek fraz na 1 stronie i klikając możesz od razu wyświetlić w okienku z prawej strony listę wyników pozycjonowania w danym dniu.<br />
						
                        <?php } ?>

                        <div class="clear"></div>
                    </div>

                </td>
            </tr>
        </table>

    </body>
</html>