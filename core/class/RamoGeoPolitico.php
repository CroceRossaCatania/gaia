<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/**
 * Rappresenta un ramo dell'albero GeoPolitico
 */
class RamoGeoPolitico extends ArrayIterator {

	public $array;

	/**
	 * Costruisce un iteratore sul ramogeopolitico.
	 * @param $geoinsieme 	GeoPolitica o array di GeoPolitica.
	 * @param $esplorazione	Opzionale. Modalita' di esplorazione. Una di ESPLORA_*
	 * @param $estensione	Opzionale. Estensione massima
	 */
	public function __construct(
		$geoinsieme,
		$esplorazione	= ESPLORA_RAMI,
		$estensione  	= EST_UNITA
	) {

		if ( !is_array($geoinsieme ) )
			$geoinsieme = [$geoinsieme];

		if ( $esplorazione == NON_ESPLORARE ) {
			$array = $geoinsieme;

		} else {
			$array = [];
			foreach ( $geoinsieme as $i ) {
				$array = array_merge($array, $i->esplora($estensione, $esplorazione));
			}
		}
		$this->array = $array;
		parent::__construct($array);
	}

	/**
	 * Esegue il metodo su ogni elemento dell'iteratore e ritorna il risultato
	 */
	public function __call($metodo, $argomenti = []) {
		$r = [];
		foreach ( $this->array as $i ) {
			$y = call_user_func_array([$i, $metodo], $argomenti);
			if (!is_array($y))
				$y = [$y];
			$r = array_merge($r, $y);
		}
		return $r;
	}

}