<?php 

    class OrdinacijaController extends AutorizacijaController
    {
        private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'ordinacija' . DIRECTORY_SEPARATOR;

        public function index()
        {          

            $this->view->render($this->viewDir . 'index',[
                'ordinacije'=>Ordinacija::ucitajSve()
            ]);
        }

        public function novi()
        {
            if($_SERVER['REQUEST_METHOD']==='GET')
        {
            $ordinacija = new stdClass();
            $ordinacija->naziv='';
            $this->novoView('Unesite tražene podatke!', $ordinacija);
            
            return;
        }

        $ordinacija = (object)$_POST;
     

        Ordinacija::dodajNovi($_POST);
        if(!$this->kontrolaIme($ordinacija,'novoView')){return;}

        $this->index();  
        }

        public function promjena()
        {
            if($_SERVER['REQUEST_METHOD']==='GET')
            {
                $this->promjenaView('Promijenite željene podatke!', Ordinacija::ucitaj($_GET['sifra']));
    
                return;
            }
    
            $ordinacija = (object)$_POST;
            
    
            Ordinacija::promjena($_POST);
    
            $this->index();
        }

        public function brisanje()
        {
            Ordinacija::brisanje($_GET['sifra']);

            $this->index(); 

        }

        private function promjenaView($poruka, $ordinacija)
        {
            $this->view->render($this->viewDir . 'promjena', [
                'poruka' => $poruka,
                'ordinacija' => $ordinacija
            ]);
        }

        private function novoView($poruka, $ordinacija)
        {
            $this->view->render($this->viewDir . 'novi', [
                'poruka' => $poruka,
                'ordinacija' => $ordinacija
            ]);
            return; 
        }

        private function kontrolaIme($ordinacija, $view)
    {
        if(strlen(trim($ordinacija->naziv))===0)
        {
            $this->novoView('Obavezno unesite naziv!', $ordinacija);
            return false;
        }

        return true;
    }

    }
?>