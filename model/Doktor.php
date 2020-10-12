<?php
class Doktor
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        
        $izraz = $veza->prepare("SELECT * FROM doktor");
        $izraz->execute();
        return $izraz->fetchAll();
    }
}