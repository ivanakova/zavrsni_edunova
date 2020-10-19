<?php
class Doktor
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        
        $izraz = $veza->prepare("select b.sifra, b.ime, b.prezime, a.naziv from ordinacija a right join doktor b on a.sifra= b.ordinacija;");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function dodajNovi($entitet)
    {
        $veza = DB::getInstanca(); 
        $veza->beginTransaction();       
        $izraz = $veza->prepare('insert into ordinacija (naziv) values (:naziv);');
        $izraz->execute([
            'naziv'=>$entitet['ordinacija']
        ]);

        $zadnjaSifra=$veza->lastInsertId();
        $izraz= $veza->prepare('insert into doktor (ime, prezime, iban, ordinacija) values (:ime, :prezime, :iban, :ordinacija);');
        $izraz->execute([
            'ordinacija'=>$zadnjaSifra,
            'ime'=>$entitet['ime'],
            'prezime'=>$entitet['prezime'],
            'iban'=>$entitet['iban']
        ]);

        $veza->commit();
    }
}