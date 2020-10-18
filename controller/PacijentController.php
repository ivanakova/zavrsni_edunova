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
            $pacijent = new stdClass();
            $pacijent->ime='';
            $pacijent->prezime='';
            $pacijent->mbo='';
            $this->novoView('Unesite tražene podatke!', $pacijent);
            
            return;
        }

        $pacijent = (object)$_POST;

        

        Pacijent::dodajNovi($_POST);
        if(!$this->kontrolaIme($pacijent,'promjenaView')){return;}

        $this->index();  
        
        //unese i ostavi te s svim podacima na trenutnoj stranici
        //$this->novoView('Pacijent unesen, nastavite s unosom novih podataka',$_POST);
    }

    public function promjena()
    {
        //echo $_GET['sifra'];

        //print_r(Pacijent::ucitaj($_GET['sifra']));

        if($_SERVER['REQUEST_METHOD']==='GET')
        {
            $this->promjenaView('Promijenite željene podatke!', Pacijent::ucitaj($_GET['sifra']));

            return;
        }

        $pacijent = (object)$_POST;
        if(!$this->kontrolaIme($pacijent,'promjenaView')){return;}

        Pacijent::promjena($_POST);

        $this->index();
    }

    public function brisanje()
    {
        Pacijent::brisanje($_GET['sifra']);

        $this->index(); 

    }

    private function novoView($poruka, $pacijent)
    {
        $this->view->render($this->viewDir . 'novi', [
            'poruka' => $poruka,
            'pacijent' => $pacijent
        ]);
        return; 
    }

    private function promjenaView($poruka, $pacijent)
    {
        $this->view->render($this->viewDir . 'promjena', [
            'poruka' => $poruka,
            'pacijent' => $pacijent
        ]);
    }

    private function kontrolaIme($pacijent, $view)
    {
        if(strlen(trim($pacijent->ime))===0)
        {
            $this->novoView('Obavezno unesite ime!', $pacijent);
            return false;
        }

        return true;
    }
}