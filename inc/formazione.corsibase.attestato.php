<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();


controllaParametri(array('id','corso'), 'errore.fatale');

$iscritto = $_GET['id'];
$corso = $_GET['corso'];

$iscritto = Utente::id($iscritto);
$corso = CorsoBase::id($corso);

if (PartecipazioneBase::filtra([['volontario', $iscritto],
        ['corsoBase', $corso],
        ['stato', ISCR_SUPERATO]
        ])){
    
    $f = $corso->generaAttestato($iscritto);
    $f->download();

}

redirect('formazione.corsibase.scheda&id='.$corso);