<?php

/**
 * (c)2015 Croce Rossa Italiana
 */

paginaAdmin();

$t = Titolo::id($_POST['id']);

$aggiungi = (bool) @$_POST['corso'];

$cfs = $_POST['codicifiscali'];
if (!$cfs) {
	redirect("admin.titolo.volontari&id={$t->id}");
}
$cfs = explode("\n", $cfs);
foreach ($cfs as &$cf) {
	$cf = maiuscolo($cf);
}

$tot = 0;

if ( $aggiungi ) {
	// Aggiunta

	foreach ($cfs as $cf) {

		// 1. Controlla che esista la persona
		$v = Utente::by('codiceFiscale', $cf);
		if (!$v) { echo "No CF"; continue; }

		// 2. Controlla che non abbia gia' il titolo
		if ( TitoloPersonale::filtra([
			['titolo', $t->id],
			['volontario', $v->id]
		]) ) {
			continue;
		}

		// Ok, aggiungi.
		
		$a = new TitoloPersonale;
		$a->volontario = $v->id;
		$a->titolo = $t->id;
		$a->inizio = strtotime($_POST['inizio']);
		$a->fine = $_POST['fine'] ? strtotime($_POST['fine']) : null;
		$a->pConferma = $_POST['pConferma'] ? $_POST['pConferma'] : $me->id;
		$a->tConferma = time();
		$a->luogo = $_POST['luogo'];
		$a->corso = maiuscolo($_POST['corso']);

		$tot++;

	}


} else {
	// Rimozione

	foreach ( $cfs as $cf ) {
		// 1. Controlla che esista la persona
		$v = Utente::by('codiceFiscale', $cf);
		if (!$v) { continue; }

		// 2. Controlla che non abbia gia' il titolo
		if ( $a = TitoloPersonale::filtra([
			['titolo', $t->id],
			['volontario', $v->id]
		]) ) {
			$a = $a[0];
			$a->cancella();
			$tot++;
		}

	}

}

redirect("admin.titolo.volontari&id={$t->id}&tot={$tot}");
