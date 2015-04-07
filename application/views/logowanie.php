<?php
    $this -> load -> view('header', array('uzytkownik' => $uzytkownik, 'klient' => isset($klient) ? $klient : false));

    /*
    forms::title(array('title' => 'Logowanie'));
    */

    forms::open(array('action' => url::page('autoryzacja/zaloguj')));

?>
    <div id="formularz_logowania">
        <p>
            <label for="login">Login</label>
            <input class="text" id="login" name="login" type="text" />
        </p>

        <p>
            <label for="haslo">Hasło</label>
            <input class="text" id="haslo" name="haslo" type="password" />
        </p>

        <p class="center">
            <input class="formButton" name="typ" type="submit" value="Partner" />
            <input class="formButton" name="typ" type="submit" value="Pozycjoner" />
            <input class="formButton" name="typ" type="submit" value="Admin" />
        </p>
    </div>
<?php
    /*
    $typy = array();
    $typy[] = array('nazwa' => 'Admin',
                    'wartosc' => 'admin');

    $typy[] = array('nazwa' => 'Pozycjoner',
                    'wartosc' => 'pozycjoner');

    $typy[] = array('nazwa' => 'Partner',
                    'wartosc' => 'partner');

    forms::select(array('data' => $typy,
                        'inputStyle' => 'width: 33%;',
                        'label' => 'Typ użytkownika',
                        'labels' => 'nazwa',
                        'name' => 'typ',
                        'required' => 1,
                        'values' => 'wartosc'));

    forms::text(array('inputStyle' => 'width: 33%;',
                      'label' => 'Login lub numer ID',
                      'name' => 'login',
                      'required' => 1,
                      'value' => ''));

    forms::text(array('inputStyle' => 'width: 33%;',
                      'label' => 'Hasło',
                      'name' => 'haslo',
                      'inputType' => 'password',
                      'required' => 1,
                      'value' => ''));

    forms::submit(array('label' => 'Zaloguj'));

    */

    forms::close(0);

    $this -> load -> view('footer');
?>