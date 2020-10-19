<?php

class DoktorController extends AutorizacijaController
{

    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'doktor' . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'entiteti'=>Doktor::ucitajSve()
        ]);
    }

    public function novi()
    {
        if($_SERVER['REQUEST_METHOD']==='GET')
        {
            $entitet = new stdClass();
            $entitet->ime = '';
            $entitet->prezime = '';
            $entitet->iban = '';
            $this->novoView('Unesite tražene podatke!', $entitet);
            return; 
        }

        $entitet = (object)$_POST;

        if(!$this->kontrolaIme($entitet,'novoView')){return;}        

        Doktor::dodajNovi($_POST);
        $this->index();
    }

    public function novoView($entitet)
    {
        $this->view->render($this->viewDir . 'novi',[
            
            'entitet' => $entitet
        ]);
    }

    public function kontrolaIme($entitet, $view)
    {
        if(strlen(trim($entitet->ime))===0)
        {
            $this->$view('Obavezan unos imena', $entitet);

            return false;
        }

        return true;
    }

    private function promjenaView($poruka, $entitet)
    {
        $this->view->render($this->viewDir . 'promjena', [
            'poruka' => $poruka,
            'entitet' => $entitet
        ]);
    }

    public function brisanje()
    {
        Doktor::brisanje($_GET['sifra']);

        $this->index(); 

    }
}