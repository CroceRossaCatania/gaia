<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$c = $_GET['comitato'];
$c = new Comitato($c);

if ( !$me->miCompete($c) ) {
    redirect('presidente.utenti');
}

if(isset($_GET['dimessi'])){
    
$excel = new Excel();

$excel->intestazione([
    'Nome',
    'Cognome',
    'C. Fiscale',
    'EMail',
    'Cellulare',
    'Cell. Servizio'
]);

foreach ( $c->membriDimessi(MEMBRO_DIMESSO) as $v ) {
    
    $excel->aggiungiRiga([
        $v->nome,
        $v->cognome,
        $v->codiceFiscale,
        $v->email,
        $v->cellulare,
        $v->cellulareServizio
    ]);
    
}

$excel->genera('Volontaridimessi.xls');
$excel->download();

}else{
    
$excel = new Excel();

$excel->intestazione([
    'Nome',
    'Cognome',
    'C. Fiscale',
    'EMail',
    'Cellulare',
    'Cell. Servizio'
]);

foreach ( $c->membriAttuali() as $v ) {
    
    $excel->aggiungiRiga([
        $v->nome,
        $v->cognome,
        $v->codiceFiscale,
        $v->email,
        $v->cellulare,
        $v->cellulareServizio
    ]);
    
}

$excel->genera('Volontari.xls');
$excel->download();
}