<?php

/*
 * ©2014 Croce Rossa Italiana
 */

class Autoparco extends GeoEntita {

	protected static
        $_t     = 'autoparchi',
        $_dt    = 'dettagliAutoparco';

    use EntitaCache;
    
    public function cancella() {
    	Collocazione::cancellaTutti([['autoparco', $this]]);
    	parent::cancella();
    }
}