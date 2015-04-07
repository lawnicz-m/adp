<ul id="navigation">
    <li>
        <a class="main" href="<?php echo url::page('klienci/lista');?>">
            Wszyscy klienci
        </a>
    </li>
    <li>
       <a class="main" href="<?php echo url::page('klienci/breakdown');?>/<?php echo date('Y-m-d'); ?>/<?php echo date('Y-m-d'); ?>">
            Lista szczegółowa
        </a>
    </li>
    <li>
        <a class="main noCover" href="#">
            Klienci według dnia
        </a>
        <ul>
            <li>
                <a href="<?php echo url::page('klienci/zalegajacy');?>">
                    Zalegający
                </a>
            </li>
            <li>
                <a href="<?php echo url::page('klienci/na-dzis');?>">
                    Na dziś
                </a>
            </li>
            <li>
                <a class="last" href="<?php echo url::page('klienci/na-jutro');?>">
                    Na jutro
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a class="main noCover" href="#">
            Klienci według etapu
        </a>
        <ul>
            <?php $etapy = $this -> load -> model('klienci') -> etapy(1); ?>
            <?php foreach($etapy as $etap){ ?>
            <li>
                <a href="<?php echo url::page('klienci/etap/'.$etap['wartosc']);?>">
                    <?php echo $etap['etykieta'];?>
                </a>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php if($uzytkownik['typ'] == 'admin' && $uzytkownik['id'] == '1' || $uzytkownik['id'] == '4' || $uzytkownik['id'] == '5' || $uzytkownik['id'] == '6' || $uzytkownik['id'] == '9' || $uzytkownik['id'] == '3'){?>
    <li>
        <a class="main" href="<?php echo url::page('partnerzy');?>">
            Partnerzy
        </a>
    </li>
    <li>
        <a class="main" href="<?php echo url::page('pozycjonerzy');?>">
            Pozycjonerzy
        </a>
    </li>
    <li>
        <a class="main" href="<?php echo url::page('admini');?>">
            Admini
        </a>
    </li>
    <li>
        <a class="main noCover" href="#">
            Faktury
        </a>
        <ul>
            <li>
                <a href="<?php echo url::page('towary_i_uslugi');?>">
                    Towary i usługi
                </a>
            </li>
            <li>
                <a href="<?php echo url::page('faktury/lista');?>">
                    Faktury
                </a>
            </li>
            <li>
                <a href="<?php echo url::page('faktury/wezwania-do-zaplaty');?>">
                    Wezwania do zapłaty
                </a>
            </li>
        </ul>
    </li>
    <?php } ?>
    <?php if($uzytkownik['typ'] == 'partner'){ ?>

    <?php if($this -> load -> model('faktury') -> czy_partner_wykonywal_zlecenia($uzytkownik['id'])){ ?>
    <li>
        <a class="main" href="<?php echo url::page('faktury_za_wykonane_uslugi');?>">
            Faktury za wykonane usługi
        </a>
    </li>
    <?php } ?>

    <li>
        <a class="main" href="<?php echo url::page('partnerzy/saldo');?>">
            Saldo
        </a>
    </li>
    <?php } ?>

    <?php /*if($uzytkownik['typ'] != 'pozycjoner'){ ?>
    <li>
        <a class="main" href="#">
            Wiadomości
        </a>
        <ul>
            <li>
                <a href="<?php echo url::page('wiadomosci/index/odebrane/nieprzeczytane');?>">
                    Odebrane
                </a>
            </li>
            <li>
                <a href="<?php echo url::page('wiadomosci/index/wyslane/nieprzeczytane');?>">
                    Wysłane
                </a>
            </li>
        </ul>
    </li>
    <?php }*/ ?>

    <li>
        <a class="main" href="<?php echo url::page('diagnostyka');?>">
            Diagnostyka
        </a>
    </li>

</ul>