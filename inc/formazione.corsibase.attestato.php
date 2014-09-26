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

$pb = PartecipazioneBase::filtra([
    ['volontario', $iscritto],
    ['corsoBase', $corso],
    ['stato', ISCR_SUPERATO]
    ]);

$pb = $pb[0];

$p = new PDF('attestato', 'Attestato.pdf');
$p->_COMITATO     = $corso->organizzatore()->nomeCompleto();
$p->_CF           = $iscritto->codiceFiscale;
$p->_VOLONTARIO   = $iscritto->nomeCompleto();
$p->_DATAESAME    = date('d/m/Y', $pb->tAttestato);
$p->_DATA         = date('d/m/Y', time());
$p->_LUOGO        = $corso->organizzatore()->comune;
$f = $p->salvaFile();
$f->download();