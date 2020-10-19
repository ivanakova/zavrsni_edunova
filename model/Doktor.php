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

    private function novoView($poruka,$entitet)
    {
        $this->view->render($this->viewDir . 'novo',[
            'poruka'=>$poruka,
            'entitet' => $entitet
        ]);
    }

    public static function brisanje($sifra)
    {
        $veza = DB::getInstanca();        
        $izraz = $veza->prepare('delete from doktor where sifra=:sifra;');
        $izraz->execute(['sifra'=>$sifra]);
    }
}