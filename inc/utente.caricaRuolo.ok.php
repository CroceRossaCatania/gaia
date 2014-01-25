<?php  

/*
 * ©2014 Croce Rossa Italiana
 */

controllaParametri(['ruolo']);

global $sessione;

$ruolo = $_GET['ruolo'];

$d = Delegato::id($ruolo);

if($d && $d->attuale() && $d->volontario == $me->id) {
	$sessione->applicazione = $d->id;
	redirect('utente.me');
}


