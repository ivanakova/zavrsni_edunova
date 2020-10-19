<?php
class Termin
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();        
        $izraz = $veza->prepare("select concat_ws(' ', a.ime, a.prezime) as pacijent, 
                                concat_ws(' ', b.ime, b.prezime) as doktor, b.pregled from pacijent a 
                                inner join doktor b on a.pregled=b.pregled where a.pregled=b.pregled;");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    
}