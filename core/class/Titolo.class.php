<?php

/*
 * ©2012 Croce Rossa Italiana
 * 
 */

class Titolo extends Entita {
    
    protected static
        $_t     = 'titoli',
        $_dt    = null;
    
    public static function cerca($stringa, $tipo = 0) {
        $tipo = (int) $tipo;
        return self::cercaFulltext($stringa, ['nome'], 20, "AND tipo = '$tipo'");
    }
}
