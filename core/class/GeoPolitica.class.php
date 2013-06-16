<?php

/*
 * ©2013 Croce Rossa Italiana
 */

abstract class GeoPolitica extends GeoEntita {
    
    abstract public function nomeCompleto();
    abstract public function estensione();
    abstract public function figli();    
    
    /*
     * Ottiene il livello di estensione (costante EST_UNITA, EST_LOCALE, ecc)
     */
    public function _estensione() {
    	return static::$_ESTENSIONE;
    }

    public function presidenti() {
        return $this->delegati(APP_PRESIDENTE);
    }
    
    public function volontariPresidenti() {
        $del = $this->delegati(APP_PRESIDENTE);
        foreach ( $del as &$d ) {
            $d = $d->volontario();
        }
        return $del;
    }
    
    public function unPresidente() {
        $p = $this->presidenti();
        if ( !$p ) { return false; }
        shuffle($p);
        return $p[0]->volontario();
    }
    
    public function delegati($app = null) {
        if ( $app ) {
            $app = (int) $app;
            $k = Delegato::filtra([
                ['comitato',        $this->id],
                ['estensione',      $this->_estensione()],
                ['applicazione',    $app]
            ]);
        } else {
            $k = Delegato::filtra([
                ['comitato',    $this->id],
                ['estensione',  $this->_estensione()]
            ]);
        }
        $r = [];
        foreach ( $k as $u ) {
            if ( $u->attuale() ) {
                $r[] = $u;
            }
        }
        return $r;
    }


    public function obiettivi_delegati($ob = OBIETTIVO_1) {
        $r = [];
        foreach ( $this->delegati(APP_OBIETTIVO) as $d ) {
            if ( $d->dominio == $ob ) {
                $r[] = $d;
            }
        }
        return $r;
    }
    
    public function obiettivi($ob = OBIETTIVO_1) {
        $r = [];
        foreach ( $this->obiettivi_delegati($ob) as $d ) {
            $r[] = $d->volontario();
        }
        return $r;
    }

    /* HOTFIX: Calendario vuoto */
    public function aree() {
    	return [];
    }
    
}