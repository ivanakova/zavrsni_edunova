<?php

class DoktorController extends AutorizacijaController
{

    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'doktor' . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'doktori'=>Doktor::ucitajSve()
        ]);
    }

    public function novi()
    {
        if($_SERVER['REQUEST_METHOD']==='GET')
        {
            $this->view->render($this->viewDir . 'novi', [
                'poruka'=>'Unesite tražene podatke!'
            ]);
            return; 
        }


        Doktor::dodajNovi($_POST);

        $this->index();        

    }
}