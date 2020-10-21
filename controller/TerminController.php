<?php

class TerminController extends AutorizacijaController
{

    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'termin' . DIRECTORY_SEPARATOR;

    public function index()
    {          

        $this->view->render($this->viewDir . 'index',[
            'entiteti'=>Termin::ucitajSve()
        ]);
    }   

    public function novi()
    {
        if($_SERVER['REQUEST_METHOD']==='GET')
        {
            $entitet = new stdClass();
            $entitet->pacijent = 0;
            $entitet->doktor = 0;
            $entitet->datum = '';
            $this->novoView('Unesite tražene podatke!', $entitet);
            return; 
        }

        $entitet = (object)$_POST;

        //if(!$this->kontrolaIme($entitet,'novoView')){return;}        

        Termin::dodajNovi($_POST);
        $this->index();
    }

    public function promjena()
    {
        $entitet= Termin::ucitaj($_GET['sifra']);
        $entitet->datum=str_replace(' ', 'T', $entitet->datum);

        if ($_SERVER['REQUEST_METHOD']==='GET'){
            $this->promjenaView('Promjenite željene podatke',
            $entitet);
            return;
        }

        $entitet=(object)$_POST;
        
        Termin::promjena($_POST);
        $this->index();
    }

    public function brisanje()
    {
        Termin::brisanje($_GET['sifra']);

        $this->index(); 

    }

    public function novoView($poruka, $entitet)
    {
        $this->view->render($this->viewDir . 'novi',[
            
            'entitet' => $entitet,
            'poruka' => $poruka,
            'pacijenti' => Pacijent::ucitajSve(),
            'doktori' => Doktor::ucitajSve()
        ]);
    }

    private function promjenaView($poruka, $entitet)
        {
            $this->view->render($this->viewDir . 'promjena', [
                'poruka' => $poruka,
                'entitet' => $entitet,
                'doktori' => Doktor::ucitajSve()
            ]);
        }
}