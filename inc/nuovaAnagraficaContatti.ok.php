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
$email      = minuscolo($_POST['inputEmail']);
$cell       = normalizzaNome($_POST['inputCellulare']);
$cells      = normalizzaNome(@$_POST['inputCellulareServizio']);

/* Cerca eventuali utenti con la stessa email... */
$e = Utente::by('email', $email);
if ( $e and $e->password ) {
    /* Se l'utente esiste, ed ha già pure una password */
    redirect('nuovaAnagraficaContatti&email');
}

if ( strlen($_POST['inputPassword']) < 6 || strlen($_POST['inputPassword']) > 15 ) {
	redirect('nuovaAnagraficaContatti&e');
}

$p = $sessione->utente();

$p->email               = $email;
$p->cellulare           = $cell;
$p->cellulareServizio   = $cells;

/* Imposta la password */
$password     = $_POST['inputPassword'];
$sessione->utente()->cambiaPassword($password);
$sessione->password = $password;

/* Abilita il volontario */
$sessione->utente()->stato    = VOLONTARIO;

if ( $sessione->tipoRegistrazione == VOLONTARIO ) {

    redirect('nuovaAnagraficaAccesso');
} else {
    redirect('mailAspirante');
}
