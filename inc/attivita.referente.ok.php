<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaAttivita();
paginaModale();

$attivita = $_POST['id'];
$attivita = new Attivita($attivita);

$referente = $_POST['inputReferente'];
$referente = new Volontario($referente);

$attivita->referente    = $referente;

$m = new Email('referenteAttivita', 'Referente attività');
$m->_NOME       = $referente->nome;
$m->_ATTIVITA   = $attivita->nome;
$m->_COMITATO   = $attivita->comitato()->nomeCompleto();
$m->a = $referente;
$m->invia();

if ( $me->id == $referente->id ) {
    redirect('attivita.modifica&id=' . $attivita->id);
} else {
    redirect('attivita.grazie&id=' . $attivita->id);
}