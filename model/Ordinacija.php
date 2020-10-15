<?php
class Ordinacija
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        
        $izraz = $veza->prepare("SELECT * FROM ordinacija");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function dodajNovi($ordinacija)
    {
        $veza = DB::getInstanca();
        
        $izraz = $veza->prepare('insert into ordinacija (naziv) values (:naziv);');
        $izraz->execute($ordinacija);
    }
}
