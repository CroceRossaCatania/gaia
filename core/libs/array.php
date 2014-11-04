<?php

/*
 * ©2014 Croce Rossa Italiana
 */

/**
 * Cerca $ago in $pagliaio 
 * 
 * Compatibile con in_array, ma prevede comparazione OID in caso di Entita
 * @todo 	Con Entita viene effettuata una scansione lineare (anche se non ricorsiva)
 * @param 	mixed 	$ago 		L'elemento da cercare
 * @param 	array 	$pagliaio	L'array nel quale ricercare
 * @return 	bool 				True se elemento trovato, False altrimenti
 */
function contiene($ago, $pagliaio) {
	if ( ! $ago instanceOf Entita )
		return in_array($ago, $paiaio);
	if ( !is_array($pagliaio) ) 
		return false;
	$oid = $ago->oid();
	foreach ( $pagliaio as $x ) {
		if ( !$x instanceOf Entita )
			continue;
		if ( $x->oid() === $oid )
			return true;
	}
	return false;
}
