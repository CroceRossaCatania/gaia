<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

/**
 * Rappresenta un errore sul database degli errori
 */
class MErrore extends MEntita {

	/**
	 * Cronjob: Cancella gli errori piu' vecchi di una settimana
	 * @return int Numero di errori cancellati
	 */
	public static function pulisci() {
		$limite = strtotime('-1 weeks');
		return MErrore::remove([
			'$or' => [
				[ 'timestamp' => [ '$exists' => false   ] ],
				[ 'timestamp' => [ '$lte' 	 => $limite ] ],
			]
		])['n'];
	}
}