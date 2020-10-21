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
            $entitet->ime = '';
            $entitet->prezime = '';
            $entitet->mbo = '';
            $entitet->ordinacija = '';
            $entitet->doktor = '';
            $entitet->termin = '';
            $this->novoView('Unesite tražene podatke!', $entitet, Ordinacija::ucitajSve(), Doktor::ucitajSve(), Pacijent::ucitajSve());
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
        $entitet->termin=str_replace(' ', 'T', $entitet->termin);

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
            'ordinacije' => Ordinacija::ucitajSve(),
            'doktori' => Doktor::ucitajSve()
        ]);
    }

    private function promjenaView($poruka, $entitet)
        {
            $this->view->render($this->viewDir . 'promjena', [
                'poruka' => $poruka,
                'entitet' => $entitet,
                'ordinacije' => Ordinacija::ucitajSve(),
                'doktori' => Doktor::ucitajSve()
            ]);
        }
}