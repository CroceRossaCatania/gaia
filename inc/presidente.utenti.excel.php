<?php

/*
 * ©2013 Croce Rossa Italiana
 */


$c = $_GET['comitato'];
$c = new Comitato($c);

paginaApp([APP_SOCI , APP_PRESIDENTE], [$c]);


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

$excel->genera('Volontari_dimessi.xls');
$excel->download();

}elseif(isset($_GET['giovani'])){
    
$excel = new Excel();

$excel->intestazione([
    'Nome',
    'Cognome',
    'C. Fiscale',
    'EMail',
    'Cellulare',
    'Cell. Servizio'
]);

foreach ( $c->membriDimessi(MEMBRO_VOLONTARIO) as $v ) {
    $t = time()-GIOVANI;
    if ($t <=  $v->dataNascita){
    
    $excel->aggiungiRiga([
        $v->nome,
        $v->cognome,
        $v->codiceFiscale,
        $v->email,
        $v->cellulare,
        $v->cellulareServizio
    ]);
    
}
}

$excel->genera('Volontari_giovani.xls');
$excel->download();

}elseif(isset($_GET['eleatt'])){
$time = $_GET['time'];
$time = DT::daTimestamp($time);

$excel = new Excel();

$excel->intestazione([
        'Nome',
        'Cognome',
        'Data Nascita',
        'Luogo Nascita',
        'Provincia Nascita',
        'C. Fiscale',
        'Ingresso in CRI'
]);

foreach ( $c->elettoriAttivi($time) as $v ) {
    
    $excel->aggiungiRiga([
        $v->nome,
        $v->cognome,
        date('d/m/Y', $v->dataNascita),
        $v->comuneNascita,
        $v->provinciaNascita,
        $v->codiceFiscale,
        $v->ingresso()->format("d/m/Y")
    ]);
    
}

$excel->genera("Elettorato_attivo.xls");
$excel->download();

}elseif(isset($_GET['elepass'])){
$time = $_GET['time'];
$time = DT::daTimestamp($time);

$excel = new Excel();

$excel->intestazione([
        'Nome',
        'Cognome',
        'Data Nascita',
        'Luogo Nascita',
        'Provincia Nascita',
        'C. Fiscale',
        'Ingresso in CRI'
]);

foreach ( $c->elettoriPassivi($time) as $v ) {
    
    $excel->aggiungiRiga([
        $v->nome,
        $v->cognome,
        date('d/m/Y', $v->dataNascita),
        $v->comuneNascita,
        $v->provinciaNascita,
        $v->codiceFiscale,
        $v->ingresso()->format("d/m/Y")
    ]);
    
}

$excel->genera("Elettorato_passivo.xls");
$excel->download();

}if(isset($_GET['quoteno'])){
    
$excel = new Excel();

$excel->intestazione([
        'Nome',
        'Cognome',
        'Data Nascita',
        'Luogo Nascita',
        'Provincia Nascita',
        'C. Fiscale',
        'Ingresso in CRI'
]);

foreach ( $c->quoteNo() as $v ) {
    
    $excel->aggiungiRiga([
        $v->nome,
        $v->cognome,
        date('d/m/Y', $v->dataNascita),
        $v->comuneNascita,
        $v->provinciaNascita,
        $v->codiceFiscale,
        $v->ingresso()->format("d/m/Y")
    ]);
    
}

$excel->genera('Volontari_quoteNo.xls');
$excel->download();

}if(isset($_GET['quotesi'])){
    
$excel = new Excel();

$excel->intestazione([
        'Nome',
        'Cognome',
        'Data Nascita',
        'Luogo Nascita',
        'Provincia Nascita',
        'C. Fiscale',
        'Ingresso in CRI'
]);

foreach ( $c->quoteSi() as $v ) {
    
    $excel->aggiungiRiga([
        $v->nome,
        $v->cognome,
        date('d/m/Y', $v->dataNascita),
        $v->comuneNascita,
        $v->provinciaNascita,
        $v->codiceFiscale,
        $v->ingresso()->format("d/m/Y")
    ]);
    
}

$excel->genera('Volontari_quoteSi.xls');
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