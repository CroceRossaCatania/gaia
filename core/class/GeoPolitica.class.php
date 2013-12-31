<?php

/*
 * ©2013 Croce Rossa Italiana
 */

abstract class GeoPolitica extends GeoEntita {
    
    abstract public function nomeCompleto();
    abstract public function estensione();
    abstract public function figli();    
    abstract public function piva();
    abstract public function cf();

    /**
     * Rigenera l'albero e lo salva in JSON per utilizzi futuri
     *
     * @return bool Tutto fatto?
     */
    public static function rigeneraAlbero() {
        $r = [];
        foreach ( Nazionale::elenco() as $n ) {
            $r[] = $n->toJSON();
        }
        $r = json_encode($r);
        return file_put_contents('./upload/setup/albero.json', $r);
    }

    /**
     * Ottiene l'ultima copia dell'albero.
     * Se questa non esiste, viene ricreata
     * @param bool $json Ritornare in JSON?
     * @return array|string L'albero come stringa o JSON
     */
    public static function ottieniAlbero( $comeJSON = false ) {
        $json = @file_get_contents('./upload/setup/albero.json');
        if ( !$json ) {
            static::rigeneraAlbero();
            return static::ottieniAlbero($comeJSON);
        }
        if ( $comeJSON ) {
            return $json;
        }
        return json_decode($json);
        // @TODO: Ricorsivamente, ricreare gli oggetti
    }

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

    abstract public function superiore();

    public function primoPresidente () {
        $comitato = $this;
        do {
            $presidente = $comitato->unPresidente();
            if ( $presidente ) { break; }
        } while ( $comitato = $this->superiore() );
        return $presidente;
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

    /*
     * Brutto stronzo ti ho fottuto!
     * ora controllo se il comitato di appartenenza del volontario sta nel sottoalbero
     */
    public function contieneVolontario($v) {
        $c = $v->comitati();
        if (!$c) {
            return false;
        }
        foreach($c as $comitato) {
            $g = GeoPolitica::daOid($comitato->oid());
            if ($this->contiene($g)) {
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
                ['comitato',        $this->oid()],
                ['applicazione',    $app]
            ], 'inizio DESC');
        } else {
            $k = Delegato::filtra([
                ['comitato',    $this->oid()]
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
                ['comitato',        $this->oid()],
                ['applicazione',    $app]
            ], 'inizio DESC');
        } else {
            $k = Delegato::filtra([
                ['comitato',    $this->oid()]
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


    public function obiettivi_delegati($ob = OBIETTIVO_1, $storico = false) {
        $r = [];
        foreach ( $this->delegati(APP_OBIETTIVO, $storico) as $d ) {
            if ( $d->dominio == $ob ) {
                $r[] = $d;
            }
        }
        return $r;
    }
    
    public function obiettivi($ob = OBIETTIVO_1, $storico = false) {
        $r = [];
        foreach ( $this->obiettivi_delegati($ob, $storico) as $d ) {
            $r[] = $d->volontario();
        }
        return $r;
    }

    public function aree( $obiettivo = null, $espandiLocali = false ) {
        if ( $obiettivo ) {
            $obiettivo = (int) $obiettivo;
            return Area::filtra([
                ['comitato',    $this->oid()],
                ['obiettivo',   $obiettivo]
            ], 'obiettivo ASC'); 
        } else {
            return Area::filtra([
                ['comitato',    $this->oid()]
            ], 'obiettivo ASC');
        }
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

    public function attivita() {
        return Attivita::filtra([
            ['comitato', $this->oid()]
        ],'nome ASC');
    }

    public function calendarioAttivitaPrivate() {
        return Attivita::filtra([
            ['comitato',  $this->oid()]
        ]);
    }
    
}