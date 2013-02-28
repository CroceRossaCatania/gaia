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

if ( Utente::by('email', $email) ) {
    redirect('nuovaAnagraficaContatti&email');
}

$p = $sessione->utente();

$p->email               = $email;
$p->cellulare           = $cell;
$p->cellulareServizio   = $cells;

if ( $sessione->tipoRegistrazione == VOLONTARIO ) {
    redirect('nuovaAnagraficaAccesso');
} else {
    redirect('grazieAspirante');
}
