<?php

class PacijentController extends AutorizacijaController
{

    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'pacijent' . DIRECTORY_SEPARATOR;

    public function index()
    {       
        $this->view->render($this->viewDir . 'index',[
            'pacijenti'=>Pacijent::ucitajSve()
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


        Pacijent::dodajNovi($_POST);

        $this->index();        

    }

    public function promjena()
    {

    }

    public function brisanje()
    {

    }
}