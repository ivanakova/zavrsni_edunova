<?php
class Termin
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();        
        $izraz = $veza->prepare("SELECT * FROM termin");
        $izraz->execute();
        return $izraz->fetchAll();
    }
}