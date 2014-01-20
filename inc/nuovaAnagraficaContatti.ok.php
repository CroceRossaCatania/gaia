<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/*
 * Sessione utente necessaria
 */

if ($sessione->utente()->email) {
  redirect('errore.permessi&cattivo');
} elseif($sessione->utente()->ordinario()) {
  redirect('utente.me');
}

paginaPrivata();
controllaParametri(array('inputEmail'), 'nuovaAnagraficaContatti&err');

/*
 * Normalizzazione dei dati
 */
$email      		= minuscolo($_POST['inputEmail']);
$cell       		= normalizzaNome($_POST['inputCellulare']);
$cells      		= normalizzaNome(@$_POST['inputCellulareServizio']);
$sessione->email 	= $email;
$sessione->cell 	= $cell;
$sessione->cells 	= $cells;

/* Cerca eventuali utenti con la stessa email... */
$e = Utente::by('email', $email);
if ( $e and $e->password ) {
    /* Se l'utente esiste, ed ha già pure una password */
    redirect('nuovaAnagraficaContatti&email');
}

if ( strlen($_POST['inputPassword']) < 8 || strlen($_POST['inputPassword']) > 15 ) {
	redirect('nuovaAnagraficaContatti&e');
}

if ( $_POST['inputPassword'] != $_POST['inputPassword2'] ) {
	redirect('nuovaAnagraficaContatti&dis');
}

$p = $sessione->utente();

$p->email               = $email;
$p->cellulare           = $cell;
$p->cellulareServizio   = $cells;

/* Imposta la password */
$password     		= $_POST['inputPassword'];
$sessione->utente()->cambiaPassword($password);


if ( $sessione->tipoRegistrazione == VOLONTARIO ) {
    redirect('nuovaAnagraficaAccesso');
} else {
    $m = new Email('registrazioneAspirante', 'Grazie futuro volontario');
	$m->a     = $sessione->utente();
	$m->_NOME = $sessione->utente()->nome;
	$m->invia();
	$sessione->utente = NULL;
	redirect('utente.me');
}

?>
