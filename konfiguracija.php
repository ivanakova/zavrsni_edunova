<?php

$dev=$_SERVER['REMOTE_ADDR'] === '127.0.0.1' ? true : false;

if($dev)
{
    $baza = [
        'server'=>'localhost',
        'baza'=>'dentalclinic',
        'korisnik'=>'ivana',
        'lozinka'=>'ivana'
    ];
} else {
    $baza = [
        'server'=>'localhost',
        'baza'=>'persefon_edunovaPP19',
        'korisnik'=>'persefon_edunova',
        'lozinka'=>'ivana0404'
    ];
}


return [
    'dev' => $dev, 
    'nazivAPP' => 'Dental Clinic',
    'url' => 'http://polaznik24.edunova.hr/',
    'baza'=>$baza
];