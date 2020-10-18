<?php
class Pacijent
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        
        $izraz = $veza->prepare("SELECT * FROM pacijent;");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function dodajNovi($pacijent)
    {
        $veza = DB::getInstanca();        
        $izraz = $veza->prepare('insert into pacijent (ime, prezime, mbo) values (:ime, :prezime, :mbo);');
        $izraz->execute($pacijent);
    }

    public static function brisanje($sifra)
    {
        $veza = DB::getInstanca();        
        $izraz = $veza->prepare('delete from pacijent where sifra=:sifra;');
        $izraz->execute(['sifra'=>$sifra]);
    }
}