<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$c = $_POST['inputComitato'];

/* Verifico appartenenza */
if($me->appartenenze()){
	redirect('utente.me');
}
           
/*Se non sono appartenente allora avvio la procedura*/

$a = new Appartenenza();
$a->volontario  = $me;
$a->comitato    = $c;
$a->stato 		= MEMBRO_PENDENTE;
$a->timestamp 	= time();
$a->inizio    	= time();
$a->fine      	= Null;

redirect('utente.me');