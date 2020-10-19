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

    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca( );
        
        $izraz = $veza->prepare("SELECT * FROM ordinacija where sifra=:sifra;");
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function promjena($ordinacija)
    {
        $veza = DB::getInstanca();        
        $izraz = $veza->prepare('update ordinacija set naziv=:naziv where sifra=:sifra;');
        $izraz->execute($ordinacija);
    }

    public static function brisanje($sifra)
    {
        $veza = DB::getInstanca();        
        $izraz = $veza->prepare('delete from ordinacija where sifra=:sifra;');
        $izraz->execute(['sifra'=>$sifra]);
    }
}
