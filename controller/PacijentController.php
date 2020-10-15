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
            $this->novoView('Unesite tražene podatke!', [
                'ime' => '',
                'prezime' => '',
                'mbo' => ''
            ]);
            return;
        }

        $pacijent = $_POST;

        if(strlen(trim($pacijent['ime']))===0)
        {
            $this->novoView('Obavezno unesite ime!', $_POST);
            return;
        }

        Pacijent::dodajNovi($_POST);

        $this->index();  
        
        //unese i ostavi te s svim podacima na trenutnoj stranici
        //$this->novoView('Pacijent unesen, nastavite s unosom novih podataka',$_POST);
    }

    public function promjena()
    {

    }

    public function brisanje()
    {

    }

    private function novoView($poruka, $pacijent)
    {
        $this->view->render($this->viewDir . 'novi', [
            'poruka' => $poruka,
            'pacijent' => $pacijent
        ]);
        return; 
    }
}