Jaka jest nowa kwota fak-tury? Jaki numer fak-tury?
<?php

forms::open(array('action' => url::page('faktury/pobierz_pdf/' . PARAM . '/korygujaca')));
forms::text(array('fieldClass' => 'widthQuarter',
'name' => 'kwota_kor',
'required' => 1,
'value' => $kwota_kor));
forms::text(array('fieldClass' => 'widthQuarter',
'name' => 'numer_kor',
'required' => 1,
'value' => $numer_kor));
forms::submit(0);
forms::close(0);
?>
