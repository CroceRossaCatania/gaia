<?php

/* 
 * (c)2014 Croce Rossa Italiana
 */

class Cache extends Redis {

	const SCADENZA_DEFAULT = 86400;

	/**
	 * Riscrive la funzione set, con scadenza forzata automaticamente
	 * ad un giorno
	 */
	public function set($chiave, $valore, $scadenza = Cache::SCADENZA_DEFAULT) {
		if ( !$scadenza ) {
			parent::set($chiave, $valore);
		} else {
			parent::setex($chiave, $scadenza, $valore);
		}
	}

	public function incrBy($chiave, $valore = 1, $scadenza = Cache::SCADENZA_DEFAULT) {
		$x = parent::incrBy($chiave, $valore);
		if ( $scadenza ) 
			parent::expire($chiave, $scadenza);
		return $x;
	}

	public function incr($chiave, $scadenza = Cache::SCADENZA_DEFAULT) {
		return $this->incrBy($chiave, 1, $scadenza);
	}

	public static $count = 0;
	public function get($chiave) {
		//echo "GET:{$chiave}\n";
		static::$count++;
		return parent::get($chiave);
	}

}