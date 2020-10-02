<?php

class App
{
    public static function start()
    {
        $route = Request::getRoute();

        //echo $route;

        $parts=explode('/', $route);

        $klasa='';

        if(!isset($parts[1]) || $parts[1]===''){
            $klasa='Index';
        }else {
            $klasa=ucfirst($parts[1]);
        }

        $klasa .= 'Controller';

        //echo $klasa;


        $funkcija='';

        if(!isset($parts[2]) || $parts[2]===''){
            $funkcija='index';
        }else {
            $funkcija=$parts[2];
        }

        //echo $klasa . '-&gt' . $funkcija;

        if(class_exists($klasa) && method_exists($klasa, $funkcija)){
            $instanca = new $klasa();
            $instanca->$funkcija();
        }else{
            $ic=new IndexController();
            $ic->notfound('Kreirati funkciju unutar klase ' . $klasa. '-&gt' . $funkcija);
            //echo 'Kreirati funkciju unutar klase ' . $klasa. '-&gt' . $funkcija;
        }        
    }

    
    public static function config($kljuc)
    {
        $datoteka = BP . 'konfiguracija.php';
        $konfiguracija = include $datoteka;
    

        if(array_key_exists($kljuc, $konfiguracija))
        {
            return $konfiguracija[$kljuc];
        } else  if($konfiguracija['dev'])
        {
            return 'Ključ ' . $kljuc . ' ne postoji u ' . $datoteka;
        } else {
            {
                return 'Ključ ' . $kljuc . ' ne postoji';
            }
        }
    }
}