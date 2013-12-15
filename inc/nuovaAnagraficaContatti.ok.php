<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/*
 * Sessione utente necessaria
 */
paginaPrivata();

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

if ( strlen($_POST['inputPassword']) < 6 || strlen($_POST['inputPassword']) > 15 ) {
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
    redirect('mailAspirante');
}

?>
