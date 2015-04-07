<?php
    forms::button(array('value' => 'Zamknij',
                        'link' => '#close_modal'));

    forms::title(array('title' => 'Statystyki klienta'));

?>

    Statystyki są dostępne pod tym adresem:<br />
    <a class="noCover" href="<?php echo url::page('klient/wyniki/'.$klient['hash']);?>" target="_blank"><?php echo url::page('klient/wyniki/'.$klient['hash']);?></a>

    <br /><br /><br />

    Kopiuj adres:<br />
    <textarea style="height: 14px; width: 100%;" onclick="$(this).select();"><?php echo url::page('klient/wyniki/'.$klient['hash']);?></textarea>