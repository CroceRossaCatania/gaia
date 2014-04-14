<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

/*
 * Sessione utente necessaria
 */

if ($sessione->utente()->email) {
  redirect('errore.permessi&cattivo');
} elseif($sessione->utente()->ordinario()) {
  redirect('utente.me');
}

paginaPrivata();
controllaParametri(['inputEmail', 'inputEmail2'], 'nuovaAnagraficaContatti&err');

/*
 * Normalizzazione dei dati
 */
$email      		= minuscolo($_POST['inputEmail']);
$email2      		= minuscolo($_POST['inputEmail2']);
$cell       		= normalizzaNome($_POST['inputCellulare']);
$cells      		= normalizzaNome(@$_POST['inputCellulareServizio']);
$sessione->email 	= $email;
$sessione->email2 	= $email2;
$sessione->cell 	= $cell;
$sessione->cells 	= $cells;

/* Cerca eventuali utenti con la stessa email... */
$e = Utente::by('email', $email);
if ( $e and $e->password ) {
    /* Se l'utente esiste, ed ha già pure una password */
    redirect('nuovaAnagraficaContatti&email');
}

if($email != $email2) {
	redirect('nuovaAnagraficaContatti&match');
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	redirect('nuovaAnagraficaContatti&emailnon');
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
}

$m = new Email('registrazioneAspirante', 'Grazie futuro volontario');
$m->a     = $sessione->utente();
$m->_NOME = $sessione->utente()->nome;
$m->invia();
redirect('aspirante.registra');

