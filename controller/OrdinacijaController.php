<?php 

    class OrdinacijaController extends AutorizacijaController
    {
        private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'ordinacija' . DIRECTORY_SEPARATOR;

        public function index()
    {
        $this->view->render($this->viewDir . 'index');
        // manje loše rješenje dovlačenja podataka iz baze je da ovdje se spojimo
        // i dovučemo podatke
        $this->view->render($this->viewDir . 'index',[
            'ordinacije'=>Ordinacija::ucitajSve()
        ]);
    }

    }
?>