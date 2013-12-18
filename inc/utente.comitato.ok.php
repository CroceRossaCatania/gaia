<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$c = $_POST['inputComitato'];

/* Verifico appartenenza */
if($me->appartenenzaValida()) {
  redirect('errore.permessi');
}
           
/*Se non sono appartenente allora avvio la procedura*/

$inizio = DateTime::createFromFormat('d/m/Y', $_POST['dataIngresso']);
if ( $_POST['dataIngresso'] ) {
    if ( $inizio ) {
        $inizio = @$inizio->getTimestamp();
    } else {
        $inizio = time();
    }
}
$a = new Appartenenza();
$a->volontario  = $me;
$a->comitato    = $c;
$a->stato 		= MEMBRO_PENDENTE;
$a->timestamp 	= time();
$a->inizio    	= $inizio;
$a->fine      	= Null;

redirect('utente.me');