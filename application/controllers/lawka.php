<?php

/**
 * Created by PhpStorm.
 * User: mm
 * Date: 09.04.15
 * Time: 00:32
 */
class controller
{

    public function index()
    {
        $uzytkownik = $this->load->model('uzytkownik')->zalogowany();
        $adres_strony = $this->input->post('adres_strony');

        $this->load->view('lawka', array('adres_strony' => $adres_strony,
            'uzytkownik' => $uzytkownik));
    }

    public function dodajFraze()
    {
        $form = $this->input->post('fraza');
        var_dump($form);
        die;
    }
}

?>