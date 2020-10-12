<?php
class Pacijent
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        
        $izraz = $veza->prepare("SELECT * FROM pacijent");
        $izraz->execute();
        return $izraz->fetchAll();
    }
}