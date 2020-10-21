<?php
class Termin
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();        
        $izraz = $veza->prepare("select concat_ws (' ', a.ime, a.prezime) as pacijent, 
                                        concat_ws (' ', b.ime, b.prezime) as doktor, c.datum, c.sifra from pacijent a
                                inner join termin c on a.sifra=c.pacijent
                                left join doktor b on b.sifra=c.doktor");
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
        if($entitet['datum']==''){
            $entitet['datum']=null;
        }else{
            $entitet['datum']=str_replace('T',' ',$entitet['datum']);
        }

        $veza = DB::getInstanca();      
        $izraz = $veza->prepare('insert into termin (pacijent, doktor, datum) values (:pacijent, :doktor, :datum);');
        
        $izraz->execute($entitet);
    }

    public static function brisanje($sifra)
    {
        $veza = DB::getInstanca();        
        $izraz = $veza->prepare('delete from termin where sifra=:sifra;');
        $izraz->execute(['sifra'=>$sifra]);
    }

        
}