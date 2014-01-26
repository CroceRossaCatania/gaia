<?php  

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();
controllaParametri(['ruolo']);

global $sessione;

$ruolo = $_GET['ruolo'];

$d = Delegato::id($ruolo);

if($d && $d->attuale() && $d->volontario == $me->id) {
	$sessione->ambito = $d->id;
	redirect('utente.me');
}


