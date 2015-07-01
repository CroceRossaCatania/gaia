<?php

/*
 * ©2012 Croce Rossa Italiana
 * 
 */

class TitoloCorso extends Entita {
    
    protected static
        $_t     = 'titoliCorsi',
        $_dt    = null;

    use EntitaCache;
    
    public static function cerca($stringa) {
        return self::cercaFulltext($stringa, ['nome'], 20);
    }

    public function cancella() {
        parent::cancella();
    }

}
