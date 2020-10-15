<?php
class IndexController extends Controller
{
    public function index()
    {
        $this->view->render('pocetna', [
            'kljuc1' => 'Vrijednost1',
            'kljuc2' => [1,2,7,9]
        ]);
    }

    public function onama()
    {
        $this->view->render('onama');
    }

    public function kontakt()
    {
        $this->view->render('kontakt');
    }

    
    
    public function notfound($poruka)
    {
        $this->view->render('notfound', ['poruka' => $poruka]);
    }

    public function login()
    {
        if(isset($_SESSION['autoriziran']))
        {
            $np=new NadzornaplocaController();
            $np->index();
            return;
        }

        $this->loginView('', 'Popunite tražene podatke');        
    }

    public function logout()
    {
        unset($_SESSION['autoriziran']);

        session_destroy();

        $this->index();
    }

    public function autorizacija()
    {
        if(isset($_SESSION['autoriziran']))
        {
            $np=new NadzornaplocaController();
            $np->index();
            return;
        }


        if(!isset($_POST['email']) || !isset($_POST['lozinka'])){
            $this->login();
            return;
        }


        if(strlen(trim($_POST['email']))===0)
        {
            $this->loginView(trim($_POST['email']), 'Obavezan unos email-a');            
            return;
        }

        if(strlen(trim($_POST['lozinka']))===0)
        {
            $this->loginView(trim($_POST['email']), 'Obavezan unos lozinke');            
            return;
        }

        $veza = DB::getInstanca();
        $izraz =$veza->prepare('select * from operater where email=:email');
        $izraz->execute(['email'=>$_POST['email']]);
        $rezultat = $izraz->fetch();
        
        if($rezultat==null)
        {
            $this->loginView(trim($_POST['email']), 'Unesena email adresa ne postoji u sustavu');            
            return;
        }

        if(!password_verify($_POST['lozinka'], $rezultat->lozinka))
        {
            $this->loginView(trim($_POST['email']), 'Za uneseni email nije ispravna lozinka');            
            return; 
        }

        //ovdje sam autoriziran
        unset($rezultat->lozinka);  //rezultat zapisi u session

        $_SESSION['autoriziran']=$rezultat;
        $np=new NadzornaplocaController();
        $np->index();
    }

    private function loginView($email, $poruka )
    {
        $this->view->render('login',  [
            'email' => $email,
            'poruka' => $poruka
        ]);
        return;
    }

    public function test()
    {
        echo password_hash("d", PASSWORD_BCRYPT);
    }
}  