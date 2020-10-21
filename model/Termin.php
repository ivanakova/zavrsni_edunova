<?php
class Termin
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();        
        $izraz = $veza->prepare("select a.sifra, concat_ws(' ', a.ime, a.prezime) as pacijent, 
                                    b.sifra, concat_ws(' ', b.ime, b.prezime) as doktor, b.pregled from pacijent a 
                                inner join doktor b on a.pregled=b.pregled
                                left join termin c on pacijent=c.pacijent;");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca( );

        
        $izraz = $veza->prepare("select a.sifra, concat_ws(' ', a.ime, a.prezime) as pacijent, 
                                    b.sifra, concat_ws(' ', b.ime, b.prezime) as doktor, b.pregled from pacijent a 
                                inner join doktor b on a.pregled=b.pregled
                                left join termin c on pacijent=c.pacijent
                                where c.sifra=:sifra;");
                                        
        $izraz->execute(['sifra'=>$sifra]);
        $entitet=$izraz->fetch();

        return $entitet;

    }

    public static function dodajNovi($entitet)
    {
        print_r($entitet);
        if($entitet['datum']==''){
            $entitet['datum']=null;
        }else{
            $entitet['datum']=str_replace('T',' ',$entitet['datum']);
        }

        $veza = DB::getInstanca();      
        $izraz = $veza->prepare('update pacijent set pregled=:datum;');
        
        $izraz->execute($entitet);
    }

    public static function brisanje($sifra)
    {
        $veza = DB::getInstanca();        
        $izraz = $veza->prepare('delete from termin where sifra=:sifra;');
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