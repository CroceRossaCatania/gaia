<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'));

$t = $_GET['id'];

/* Cerco i gruppi a cui appartengo attualmente */
$g = $me->contaGruppi();

/* Se appartengo solo ad un gruppo non dimetto
 */
if($g == 1)
    redirect('utente.gruppo&last');             

/*Se non sono appartenente allora avvio la procedura*/

$t = AppartenenzaGruppo::id($t);

if ( $me->id != $t->volontario()->id )
	redirect('errore.permessi');
	
$t->fine = time();
$t->motivazione = "Abbandono spontaneo del gruppo";
$t->tNega = time();
$t->pNega = $me;

redirect('utente.gruppo&del');