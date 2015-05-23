<?php

/**
 * (c)2015 Croce Rossa Italiana
 */

paginaAdmin();

$g = $_GET['oid'];
$g = GeoPolitica::daOid($g);

$n = (int) !((bool) $g->attivo);

// Attiva/disattiva
$g->attivo = $n;

// Attiva/disattiva tutti i figli
foreach ( $g->esplora(EST_UNITA, ESPLORA_RAMI, true) as $x ) {
	$x->attivo = $n;
}

redirect('admin.comitati&ad');