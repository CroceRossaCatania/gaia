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

$pb = array_merge( $pb, PartecipazioneBase::filtra([
    ['volontario', $iscritto],
    ['corsoBase', $corso],
    ['stato', ISCR_BOCCIATO]
    ]));

$pb = array_unique($pb);
$pb = $pb[0];

if ($pb->p1){
	$p1 = "Idoneo";
}else{
	$p1 = "Non idoneo";
}

if ($pb->p2){
	$p2 = "Idoneo";
}else{
	$p2 = "Non idoneo";
}

$p = new PDF('schedabase', 'Scheda valutazione.pdf');
$p->_COMITATO     = $corso->organizzatore()->nomeCompleto();
$p->_SCHEDANUM    = "scheda";
$p->_VERBALENUM   = "scheda";
$p->_DATAESAME    = $pb->tAttestato;
$p->_UNOESITO     = $p1;
$p->_DUEESITO     = $p2;
$p->_NOMECOMPLETO = $iscritto->nomeCompleto();
$p->_LUOGONASCITA = $iscritto->comuneNascita;
$p->_DATANASCITA  = date('d/m/Y', $iscritto->dataNascita);
$f = $p->salvaFile();
$f->download();