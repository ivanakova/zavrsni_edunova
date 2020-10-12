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
}
