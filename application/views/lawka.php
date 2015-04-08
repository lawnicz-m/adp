<?php

/**
 * Created by PhpStorm.
 * User: mm
 * Date: 09.04.15
 * Time: 00:32
 */

$this->load->view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

forms::title(array('title' => 'Frazy ogólne '));

?>
    <table border="0" cellpadding="0" cellspacing="0" style="width: 33%;">
        <tr>
            <td style="vertical-align: top; width: 50%;">
                <h3 style="margin: 0 0 0 5px;">Formularz dodawania fraz ogólnych</h3>
                <?php
                    forms::open(array('action' => url::page(CONTROLLER . '/dodajFraze/' . PARAM)));

                    forms::text(array('label' => 'Fraza',
                        'name' => 'fraza',
                        'required' => 1,
                    ));
                ?>
            </td>
            <td style="vertical-align: bottom;">
                <?php forms::submit(array('label' => 'Dodaj frazę')); ?>
            </td>
                <?php
                    forms::close(0);
                    $this->load->view('footer');
                ?>