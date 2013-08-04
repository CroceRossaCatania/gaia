<?php

/*
 * ©2012 Croce Rossa Italiana
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

$anno = $_POST['inputAnno'];

/* Richiede appartenenza al gruppo */
$a = new Appartenenza();
$a->volontario  = $sessione->utente()->id;
$a->comitato    = $comitato->id;
$a->inizio      = mktime(1, 0, 0, 1, 1, $anno);
$a->fine        = PROSSIMA_SCADENZA;
$a->richiedi();

/* Imposta la password */
$password     = $_POST['inputPassword'];
$sessione->utente()->cambiaPassword($password);

/* Abilita il volontario */
$sessione->utente()->stato    = VOLONTARIO;

/* Invia la mail */
$m = new Email('registrazioneVolontario', 'Benvenuto su Gaia');
$m->a = $sessione->utente();
$m->_NOME       = $sessione->utente()->nome;
$m->_PASSWORD   = $password;
$m->invia();

/* Installazione: Se sono il primo utente... */
if ( ! Utente::listaAdmin() ) {
    $me->admin = time();
}

redirect('utente.me');