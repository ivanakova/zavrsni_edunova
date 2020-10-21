<?php

class DoktorController extends AutorizacijaController
{

    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'doktor' . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'entiteti'=>Doktor::ucitajSve(),
            'ordinacije'=>Ordinacija::ucitajSve()
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
            $entitet->ordinacija = '';
            $this->novoView('Unesite tražene podatke!', $entitet, Ordinacija::ucitajSve());
            return; 
        }

        $entitet = (object)$_POST;

        //if(!$this->kontrolaIme($entitet,'novoView')){return;}        

        Doktor::dodajNovi($_POST);
        $this->index();
    }

    public function promjena()
    {
        $entitet= Doktor::ucitaj($_GET['sifra']);

        if ($_SERVER['REQUEST_METHOD']==='GET'){
            $this->promjenaView('Promjenite željene podatke',
            $entitet);
            return;
        }

        $entitet=(object)$_POST;
        
        Doktor::promjena($_POST);
        $this->index();
    }

    public function brisanje()
    {
        Doktor::brisanje($_GET['sifra']);

        $this->index(); 

    }

    public function novoView($poruka, $entitet, $ordinacije)
    {
        $this->view->render($this->viewDir . 'novi',[
            
            'entitet' => $entitet,
            'poruka' => $poruka,
            'ordinacije' => $ordinacije
        ]);
    }

    private function promjenaView($poruka, $entitet)
        {
            $this->view->render($this->viewDir . 'promjena', [
                'poruka' => $poruka,
                'entitet' => $entitet
            ]);
        }
    /*
    public function kontrolaIme($entitet, $view)
    {
        if(strlen(trim($entitet->ime))===0)
        {
            $this->$view('Obavezan unos imena', $entitet);

            return false;
        }

        return true;
    }
*/
    

    

    

        
}