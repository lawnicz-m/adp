<?php                                     
    define('URL_API', 'http://nazwa_domeny.pl/');

    $data = isset($_GET['data']) ? $_GET['data'] : date("Y-m-d");
    $id_klienta = isset($_GET['id_klienta']) ? $_GET['id_klienta'] : 0;

    include 'funkcje.php';
    header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, noarchive, nosnippets" />
        <link href="style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="jquery.tablesorter.min.js"></script>
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
        <title>Wyniki pozycjonowania</title>
    </head>
    <body>

        <div id="header">

            <img alt="" class="logo" src="logo.png" />

        </div>

        <table border="0" id="page" cellpadding="0" cellspacing="0">
            <tr>
                <td id="side">

                    <h3>Pozycje fraz na dzień <?php echo czytelna_data($data);?></h3>
                    <?php $zapytanie = pobierz_dane(URL_API.'api/pobierz_pozycje_na_dzien/'.$id_klienta.'/'.$data); ?>
                    <?php if($zapytanie['status'] == 1){ $aktualne_pozycje = $zapytanie['dane']; ?>

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
                            <?php $i = 0; foreach($aktualne_pozycje as $fraza){ ?>
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
                        <?php echo $zapytanie['dane'];?>
                    <?php } ?>

                    <div class="center">
                        <br />
                        <br />
                        <a href="<?php echo '?id_klienta='.$id_klienta.'&amp;data='.date('Y-m-d', strtotime('-1 day', strtotime($data)));?>">&#171; Poprzedni dzień</a>
                        &nbsp; | &nbsp;
                        <a href="<?php echo '?id_klienta='.$id_klienta.'&amp;data='.date('Y-m-d', strtotime('+1 day', strtotime($data)));?>">Następny dzień &#187;</a>

                        
                    </div>
                 
                </td>
                <td id="content">

                    <?php $zapytanie = pobierz_dane(URL_API.'api/pobierz_odsetek_fraz_na_pierwszej_stronie_na_miesiac/'.$id_klienta.'/'.$data); ?>
                    <?php if($zapytanie['status'] == 1){ $odsetek_na_pierwszej_stronie = $zapytanie['dane']; ?>

                    <div class="floatRight">
                        <a href="<?php echo '?id_klienta='.$id_klienta.'&amp;data='.date('Y-m-01', strtotime('-1 month', strtotime(substr($data, 0, -3).'-01')));?>">&#171; Poprzedni miesiąc</a>
                        &nbsp; | &nbsp;
                        <a href="<?php echo '?id_klienta='.$id_klienta.'&amp;data='.date('Y-m-01', strtotime('+1 month', strtotime(substr($data, 0, -3).'-01')));?>">Następny miesiąc &#187;</a>
                    </div>

                    <h2><?php echo ucfirst(czytelny_miesiac(substr($data, 0, -3), 2));?></h2>
                    <h3>Odsetek fraz na 1 stronie Google</h3>

                    <table border="0" cellpadding="0" cellspacing="0" class="tabela_slupkowa">
                        <tr>
                            <?php for($i = 1; $i <= count($odsetek_na_pierwszej_stronie); $i++){ ?>
                            <td>
                                <div style="height: <?php echo $odsetek_na_pierwszej_stronie[$i];?>px;"></div>
                                <span style="font-size: 10px;"><?php echo $odsetek_na_pierwszej_stronie[$i];?></span><br />
                                <a href="<?php echo '?id_klienta='.$id_klienta.'&amp;data='.substr($data, 0, -3).'-'.($i < 10 ? '0'.$i : $i);?>">
                                    <?php echo $i;?>
                                </a>
                            </td>
                            <?php } ?>
                        </tr>
                    </table>

                    <?php } ?>

                </td>
            </tr>
        </table>

    </body>
</html>