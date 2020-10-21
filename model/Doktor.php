<?php
class Doktor
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        
        $izraz = $veza->prepare('select b.sifra, b.ime, b.prezime, b.iban, a.naziv from ordinacija a right join doktor b on a.sifra= b.ordinacija;');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca( );
        
        $izraz = $veza->prepare('SELECT b.sifra, b.ime, b.prezime, b.iban, a.naziv from ordinacija a 
                                right join doktor b on a.sifra= b.ordinacija where b.sifra=:sifra');
        $izraz->execute(['sifra'=>$sifra]);
        $entitet=$izraz->fetch();

        return $entitet;

    }

    public function novi()
    {
        if($_SERVER['REQUEST_METHOD']==='GET')
        {
            $entitet = new stdClass();
            $entitet->ime='';
            $entitet->prezime='';
            $entitet->iban='';
            $entitet->ordinacija='';
            $this->novoView('Unesite tražene podatke!', $entitet);
            
            return;
        }

        $entitet = (object)$_POST;
        
        if(!$this->kontrolaIme($entitet,'novoView')){return;}
        Doktor::dodajNovi($_POST);        

        $this->index();  
        
        //unese i ostavi te s svim podacima na trenutnoj stranici
        //$this->novoView('Pacijent unesen, nastavite s unosom novih podataka',$_POST);
    }

    public static function dodajNovi($entitet)
    {
        print_r($entitet);
        $veza = DB::getInstanca(); 
        $veza->beginTransaction();       
        $izraz = $veza->prepare('insert into doktor (ime, prezime, iban, ordinacija) values (:ime, :prezime, :iban, :ordinacija);');

        $izraz->execute($entitet);

        print_r($entitet);
    }

    public static function brisanje($sifra)
    {
        $veza = DB::getInstanca();        
        $izraz = $veza->prepare('delete from doktor where sifra=:sifra;');
        $izraz->execute(['sifra'=>$sifra]);
    }

    public static function promjena($doktor)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();

        $izraz = $veza->prepare('select ordinacija from doktor where sifra=:sifra;');

        $izraz->execute(['sifra'=>$entitet['sifra']]);
        $sifraOrdinacija = $izraz->fetchColumn();

        $izraz = $veza->prepare('update ordinacija set naziv=:naziv where sifra=:sifra');

        $izraz->execute([
            'naziv'=>$entitet['naziv'],
            'sifra'=>$sifraOrdinacija
        ]);

        $izraz = $veza->prepare('update doktor set ime=:ime, prezime=:prezime, iban=:iban where sifra=:sifra');

        $izraz->execute([
            'sifra'=>$entitet['sifra'],
            'ime'=>$entitet['ime'],
            'prezime'=>$entitet['prezime'],
            'iban'=>$entitet['iban']
        ]);

        $veza->commit();
    }

    
}