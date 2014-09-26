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

/* costruisco i testi del pdf secondo regolamento */
if ($pb->p1){
	$p1 = "Positivo";
}else{
	$p1 = "Negativo";
}

if ($pb->p2){
	$p2 = "Positivo";
}else{
	$p2 = "Negativo";
}

if ( $pb->stato==ISCR_SUPERATO ){

    $idoneo = "Idoneo";

}else{

    $idoneo = "Non Idoneo";

}

/* Appongo eventuali X */
$extra1 = null;
$extra2 = null;

if ($pb->e1){

    $extra1 = "X";

}

if ($pb->e2){

    $extra2 = "X";

}

/*testi con sesso già inserito */
if ($iscritto->sesso==UOMO){

    $candidato = "il candidato";

}else{

    $candidato = "la candidata";

}

$p = new PDF('schedabase', 'Scheda valutazione.pdf');
$p->_COMITATO     = $corso->organizzatore()->nomeCompleto();
$p->_SCHEDANUM    = "scheda";
$p->_VERBALENUM   = $corso->progressivo();
$p->_DATAESAME    = date('d/m/Y', $pb->tAttestato);
$p->_UNOESITO     = $p1;
$p->_ARGUNO       = $pb->a1;
$p->_DUEESITO     = $p2;
$p->_ARGDUE       = $pb->a2;
$p->_NOMECOMPLETO = $iscritto->nomeCompleto();
$p->_LUOGONASCITA = $iscritto->comuneNascita;
$p->_DATANASCITA  = date('d/m/Y', $iscritto->dataNascita);
$p->_IDONETA      = $idoneo;
$p->_EXTRAUNO     = $extra1;
$p->_EXTRADUE     = $extra2;
$p->_CANDIDATO    = $candidato;
$f = $p->salvaFile();
$f->download();