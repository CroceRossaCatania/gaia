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
    
    public function figliOID() {
        $r = [];
        foreach ( $this->figli() as $figlio ) {
            $r[] = $figlio->oid();
        }
        return $r;
    }
    
    /*
     * Ritorna se questa entità sovrasta/contiene un'altra GeoPolitica
     * a un livello qualsiasi di profondità, esplorando ricorsivamente
     */
    public function contiene( GeoPolitica $comitato ) {
        if ( $this->oid() == $comitato->oid() ) { return true; } // contengo me stesso
        foreach ( $this->figli() as $figlio ) {
            if ( 
                    $comitato->oid() == $figlio->oid()
                    or
                    $figlio->contiene($comitato)
                    ) {
                return true;
            }
        }
        return false;
    }
    
    public function unPresidente() {
        $p = $this->presidenti();
        if ( !$p ) { return false; }
        shuffle($p);
        return $p[0]->volontario();
    }
    
    public function delegati($app = null, $storico = false) {
        if ( $app ) {
            $app = (int) $app;
            $k = Delegato::filtra([
                ['comitato',        $this->id],
                ['estensione',      $this->_estensione()],
                ['applicazione',    $app]
            ], 'inizio DESC');
        } else {
            $k = Delegato::filtra([
                ['comitato',    $this->id],
                ['estensione',  $this->_estensione()]
            ], 'inizio DESC');
        }
        if ( $storico ) { return $k; }
        $r = [];
        foreach ( $k as $u ) {
            if ( $u->attuale() ) {
                $r[] = $u;
            }
        }
        return $r;
    }

    public function volontariDelegati($app = null) {
        if ( $app ) {
            $app = (int) $app;
            $k = Delegato::filtra([
                ['comitato',        $this->id],
                ['estensione',      $this->_estensione()],
                ['applicazione',    $app]
            ], 'inizio DESC');
        } else {
            $k = Delegato::filtra([
                ['comitato',    $this->id],
                ['estensione',  $this->_estensione()]
            ], 'inizio DESC');
        }
        $r = [];
        foreach ( $k as $u ) {
            if ( $u->attuale() ) {
                $r[] = $u->volontario;
            }
        }
        return array_unique($r);
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

    /** Fix #406 
     * Per gli alti livelli (non unita'), elenco aree 
     */
    public function aree() {
        $r = [];
        foreach ( $this->estensione() as $c ) {
            $r = array_merge($r, $c->aree());
        }
        return array_unique($r);
    }

    public function tuttiVolontari() {
        $a = [];
        foreach ( $this->estensione() as $unita ) {
            $a = array_merge($unita->membriAttuali(), $a);
        }
        return array_unique($a);
    }

    public function estensioneComma() {
        return implode(',', $this->estensione());
    }

    public function cercaVolontari( $query ) {
        $campi = ['nome', 'cognome', 'email', 'codiceFiscale'];
        $ora = time(); $stato = MEMBRO_VOLONTARIO; $est = $this->estensioneComma();
        return Volontario::cercaFulltext($query, $campi, 100000,
            "AND id IN (
                    SELECT DISTINCT(volontario) FROM appartenenza
                    WHERE  (fine > {$ora} OR fine = 0 OR fine IS NULL)
                    AND    inizio < {$ora} AND stato = {$stato}
                    AND    comitato IN ({$est})
                )");
    }
    
}