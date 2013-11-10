<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$comitato     = $_POST['inputComitato'];
if ( !$comitato ) {
    redirect('nuovaAnagraficaAccesso&c');
}
$comitato     = new Comitato($comitato);

$inizio   = mktime(0, 0, 0, $_POST['inputMese'], $_POST['inputGiorno'], $_POST['inputAnno']);

/* Richiede appartenenza al gruppo */
$a = new Appartenenza();
$a->volontario  = $sessione->utente()->id;
$a->comitato    = $comitato->id;
$a->inizio      = $inizio;
$a->fine        = PROSSIMA_SCADENZA;
$a->richiedi();

/* Invia la mail */
$m = new Email('registrazioneVolontario', 'Benvenuto su Gaia');
$m->a = $sessione->utente();
$m->_NOME       = $sessione->utente()->nome;
$m->invia();

/* Installazione: Se sono il primo utente... */
if ( ! Utente::listaAdmin() ) {
    $me->admin = time();
}

redirect('utente.me');