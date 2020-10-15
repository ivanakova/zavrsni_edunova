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

    public static function dodajNovi($doktor)
    {
        $veza = DB::getInstanca();        
        $izraz = $veza->prepare('insert into doktor (ime, prezime, iban) values (:ime, :prezime, :iban);');
        $izraz->execute($doktor);
    }
}