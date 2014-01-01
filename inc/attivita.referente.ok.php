<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaAttivita();
paginaModale();

$parametri = array('id', 'inputReferente');
controllaParametri($parametri);

$attivita = $_POST['id'];
$attivita = Attivita::id($attivita);

paginaAttivita($attivita);

$referente = $_POST['inputReferente'];
$referente = Volontario::id($referente);

$attivita->referente    = $referente;

$m = new Email('referenteAttivita', 'Referente attività');
$m->_NOME       = $referente->nome;
$m->_ATTIVITA   = $attivita->nome;
$m->_COMITATO   = $attivita->comitato()->nomeCompleto();
$m->a = $referente;
$m->invia();

if(isset($_GET['g'])){
    $g = new Gruppo();
    $g->nome        =   $attivita->nome;
    $g->comitato    =   $attivita->comitato()->oid();
    $g->obiettivo   =   $attivita->area()->obiettivo;
    $g->area        =   $attivita->area();
    $g->referente   =   $referente;
    $g->attivita 	=	$attivita;
    if ($attivita->comitato()->_estensione() == EST_REGIONALE) {
        $g->estensione  =   EST_GRP_REGIONALE;    
    } elseif ($attivita->comitato()->_estensione() == EST_PROVINCIALE) {
        $g->estensione  =   EST_GRP_PROVINCIALE;
    } elseif ($attivita->comitato()->_estensione() == EST_LOCALE) {
        $g->estensione  =   EST_GRP_LOCALE;
    } else {
        $g->estensione  =   EST_GRP_UNITA;
    }
    
}
    
if ( $me->id == $referente->id ) {
    redirect('attivita.modifica&id=' . $attivita->id);
} else {
    redirect('attivita.grazie&id=' . $attivita->id);
}