<?php

/*
 * ©2013 Croce Rossa Italiana
 */


/*
 * Normalizzazione dei dati
 */
$id         = $_GET['t'];

$dnascita = DT::createFromFormat('d/m/Y', $_POST['inputDataNascita']);
$dnascita = $dnascita->getTimestamp();
$prnascita= maiuscolo($_POST['inputProvinciaNascita']);
$conascita = normalizzaNome($_POST['inputComuneNascita']);
$coresidenza= normalizzaNome($_POST['inputComuneResidenza']);
$caresidenza= normalizzaNome($_POST['inputCAPResidenza']);
$prresidenza= maiuscolo($_POST['inputProvinciaResidenza']);
$indirizzo  = normalizzaNome($_POST['inputIndirizzo']);
$civico     = maiuscolo($_POST['inputCivico']);

$cell       = normalizzaNome($_POST['inputCellulare']);
$cells      = normalizzaNome(@$_POST['inputCellulareServizio']);

if ($me->admin()) {
	$nome       = normalizzaNome($_POST['inputNome']);
	$cognome    = normalizzaNome($_POST['inputCognome']);
	$sesso 		= $_POST['inputSesso'];
	$codiceFiscale = maiuscolo($_POST['inputCodiceFiscale']);
	$email      = minuscolo($_POST['inputEmail']);
}
/*
 * Controlla esistenza varia e ti porta dove dovrebbe 
 */
$p = Persona::id($id);

/*
 * Registrazione vera e propria...
 */

$p->dataNascita         = $dnascita;
$p->provinciaNascita =$prnascita;
$p->comuneNascita = $conascita;
$p->comuneResidenza     = $coresidenza;
$p->CAPResidenza        = $caresidenza;
$p->provinciaResidenza  = $prresidenza;
$p->indirizzo 		= $indirizzo;
$p->civico   		= $civico;
$p->cellulare           = $cell;
$p->cellulareServizio   = $cells;
$p->timestamp           = time();
$p->stato               = VOLONTARIO;

if ($me->admin()) {
	$p->nome                = $nome;
	$p->cognome             = $cognome;
	$p->sesso 				= ($sesso) ? UOMO : DONNA;
	$p->codiceFiscale = $codiceFiscale;
	$p->email               = $email;
}

redirect('presidente.utente.visualizza&ok&id='.$_GET['t']);