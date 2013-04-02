<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$zip = new Zip();

foreach ( $me->comitatiDiCompetenza() as $c ) {

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

    $excel->genera("Volontari {$c->nome}.xls");
    
    $zip->aggiungi($excel);

}

$zip->comprimi("Anagrafica volontari.zip");
$zip->download();