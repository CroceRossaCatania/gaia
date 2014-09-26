<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

if ( isset($_GET['single'])) {

    controllaParametri(array('id','corso'), 'errore.fatale');

    $iscritto = $_GET['id'];
    $corso = $_GET['corso'];

    $iscritto = Utente::id($iscritto);
    $corso = CorsoBase::id($corso);

    $f = $corso->generaScheda($iscritto);
    $f->download();

}else{

    controllaParametri(array('id'), 'errore.fatale');

    $corso = $_GET['id'];
    $corso = CorsoBase::id($corso);

    $zip = new Zip();

    foreach($corso->partecipazioni(ISCR_SUPERATO) as $pb){

        $iscritto = $pb->utente();
        $f = $corso->generaScheda($iscritto);
        $zip->aggiungi($f);

    }

    $zip->comprimi("Verbale e schede corso base.zip");
    $zip->download();

}