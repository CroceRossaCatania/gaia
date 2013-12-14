<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

if ( strlen($_POST['inputPassword']) < 6 || strlen($_POST['inputPassword']) > 15 ) {
	redirect('nuovaAnagraficaAccesso&e');
}

$comitato     = $_POST['inputComitato'];
if ( !$comitato ) {
    redirect('nuovaAnagraficaAccesso&c');
}
$comitato     = new Comitato($comitato);

// Volontario? => Appartenenza al gruppo
if ( $sessione->tipoRegistrazione == VOLONTARIO ) {
	$comitato     = Comitato::id($comitato);
	$anno = $_POST['inputAnno'];

	/* Richiede appartenenza al gruppo */
	$a = new Appartenenza();
	$a->volontario  = $sessione->utente()->id;
	$a->comitato    = $comitato->id;
	$a->inizio      = mktime(1, 0, 0, 1, 1, $anno);
	$a->fine        = PROSSIMA_SCADENZA;
	$a->richiedi();

}

/* Imposta la password */
$password     = $_POST['inputPassword'];
$sessione->utente()->cambiaPassword($password);

/* Abilita */
$sessione->utente()->stato    = $sessione->tipoRegistrazione;

/* Invia la mail */
if ( $sessione->tipoRegistrazione == VOLONTARIO ) {
	$m = new Email('registrazioneVolontario', 'Benvenuto su Gaia');
	$m->a = $sessione->utente();
	$m->_NOME       = $sessione->utente()->nome;
	$m->_PASSWORD   = $password;
} else {
	$m = new Email('registrazioneAspirante', 'Grazie futuro volontario');
	$m->a = $sessione->utente();
	$m->_NOME       = $sessione->utente()->nome;
}
$m->invia();

/* Installazione: Se sono il primo utente... */
if ( ! Utente::listaAdmin() ) {
    $me->admin = time();
}

redirect('utente.me');