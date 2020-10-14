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
            $this->view->render($this->viewDir . 'novi');
        }

        public function promjena()
        {

        }

        public function brisanje()
        {

        }

    }
?>