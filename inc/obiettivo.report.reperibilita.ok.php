<?php

/*
 * ©2013 Croce Rossa Italiana
 */


$oid = $_POST['oid'];
$g = GeoPolitica::daOid($oid);
$unita = $g->estensione();
$inizio = DT::createFromFormat('d/m/Y', $_POST['datainizio']);
$fine = DT::createFromFormat('d/m/Y', $_POST['datafine']);

paginaApp([ APP_PRESIDENTE, APP_OBIETTIVO ]);

 
$excel = new Excel();

$excel->intestazione([
    'Nome',
    'Cognome',
    'Data nascita',
    'Comitato',
    'Inizio reperibilità',
    'Fine reperibilità'
]);

foreach ( $unita as $comitato ) {
    foreach($comitato->reperibilitaReport($inizio,$fine) as $v) { 
    
    $excel->aggiungiRiga([
        $v->volontario()->nome,
        $v->volontario()->cognome,
        date('d/m/Y', $v->volontario()->dataNascita),
        $comitato->nomeCompleto(),
        date('d/m/Y H:i', $v->inizio),
        date('d/m/Y H:i', $v->fine)
    ]);
    
}
    }

$excel->genera('Report reperibilita.xls');
$excel->download();
