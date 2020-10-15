<?php

class AdminController extends AutorizacijaController
{
    public function __construct()
    {
        parent::__construct();

        if($_SESSION['autoriziran']->uloga !== 'admin')
        {
            unset($_SESSION['autoriziran']);
            session_destroy();

            $this->view->render('login', [                
                'email' => '',
                'poruka' => 'Prvo se autorizirajte s ulogom koja ima ovlasti za rad sa sustavom'
            ]);
            exit;
        }        
    }
}