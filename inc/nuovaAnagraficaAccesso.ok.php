<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
if ($sessione->utente()->unComitato(SOGLIA_APPARTENENZE)) {
    redirect('errore.permessi&cattivo');
} elseif ($sessione->utente()->ordinario()) {
    redirect('utente.me');
}

$parametri = array('inputDataIngresso');
controllaParametri($parametri, 'nuovaAnagraficaAccesso&err');

$comitato     = $_POST['inputComitato'];
if ( !$comitato ) {
    redirect('nuovaAnagraficaAccesso&c');
}
$comitato = Comitato::id($comitato);

$inizio = DT::createFromFormat('d/m/Y', $_POST['inputDataIngresso']);

/*
 * Scrive i dati nella sessione 
 */
$sessione->inizio = $_POST['inputDataIngresso'];

/*
 * Esegue i check sui dati
 */
if(!DT::controlloData($_POST['inputDataIngresso'])){
	redirect('nuovaAnagraficaAccesso&data');
}

$gia = Appartenenza::filtra([
	['volontario', $sessione->utente()->id],
	['comitato', $comitato->id]
]);

/* Richiede appartenenza al gruppo */
if(!$gia){
	$a = new Appartenenza();
	$a->volontario  = $sessione->utente()->id;
	$a->comitato    = $comitato->id;
	$a->inizio      = $inizio->getTimestamp();
	$a->fine        = PROSSIMA_SCADENZA;
	$a->richiedi();
}

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