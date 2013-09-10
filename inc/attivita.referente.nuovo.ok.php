<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$attivita = $_POST['id'];
$attivita = new Attivita($attivita);

$referente = $_POST['inputReferente'];
$referente = new Volontario($referente);

$volontario = $attivita->referente();
$autorizzazioni = Autorizzazione::filtra([['volontario', $volontario],['stato', AUT_PENDING]]);
foreach ($autorizzazioni as $autorizzazione){
	$autorizzazione->volontario = $referente;
}

$attivita->referente    = $referente;

$m = new Email('referenteAttivita', 'Referente attività');
$m->_NOME       = $referente->nome;
$m->_ATTIVITA   = $attivita->nome;
$m->_COMITATO   = $attivita->comitato()->nomeCompleto();
$m->a = $referente;
$m->invia();

redirect('attivita.gestione&ok');