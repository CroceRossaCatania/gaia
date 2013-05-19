<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$zip = new Zip();

foreach ( $me->comitatiDiCompetenza() as $c ) {
    
    foreach ( $c->membriAttuali() as $v ) {
        if (!$v->documenti()) { continue; }
        $f          = $v->zipDocumenti();
        $f->nome    = '/' . $c->nomeCompleto() . '/' . $f->nome;
        $zip->aggiungi($f);
    }
    
}

$zip->comprimi('Documenti volontari.zip');
$zip->download();