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
                $this->view->render($this->viewDir . 'novi', [
                    'poruka'=>'Unesite tražene podatke!'
                ]);
                return; 
            }

            Ordinacija::dodajNovi($_POST);
            $this->index();  
        }

        public function promjena()
        {

        }

        public function brisanje()
        {

        }

    }
?>