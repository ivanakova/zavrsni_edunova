<?php

class TerminController extends AutorizacijaController
{

    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'termin' . DIRECTORY_SEPARATOR;

    public function index()
        {          

            $this->view->render($this->viewDir . 'index',[
                'termini'=>Termin::ucitajSve()
            ]);
        }

        public function novi()
        {
            $this->view->render($this->viewDir . 'novi');
        }

        public function brisanje()
    {
        Termin::brisanje($_GET['sifra']);

        $this->index(); 

    }
}