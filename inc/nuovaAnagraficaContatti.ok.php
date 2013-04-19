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

$p = $sessione->utente();

$p->email               = $email;
$p->cellulare           = $cell;
$p->cellulareServizio   = $cells;

if ( $sessione->tipoRegistrazione == VOLONTARIO ) {
    redirect('nuovaAnagraficaAccesso');
} else {
    redirect('mailAspirante');
}
