<?php

/*
 * ©2014 Croce Rossa Italiana
 */

/**
 * Rappresenta una Entita generica in cache (redis)
 */
abstract class REntita {
    
    protected
            $cache      = null,
            $_v         = [];

    /** 
     * L'ID dell'oggetto caricato 
     */
    public           $id;
    
    /**
     * Ottiene il prefisso chiave per questa entita
     */
    public static function _prefisso() {
        return strtolower( get_called_class() );
    }

    public function __construct ( $id = null ) {
        global $cache, $conf;
        $this->cache = $cache;
        /* Check esistenza */
        if ( self::_esiste($id) ) {
            // Esiste, tutto ok
            $this->id = $id;

        } elseif ( $id === null ) {
            /* Creazione nuovo */
            $this->_crea();
            $this->__construct($this->id);
        } else {
            /* Errore non esistente! */
            $e = new Errore(1003);
            $e->extra = static::_prefisso(). ':' . $id;
            throw $e;
        }
    }

    /**
     * Imposta scadenza all'entita' in secondi
     */
    public function impostaScadenza($secondi) {
        $secondi = (int) $secondi;
        $chiavi = $this->cache->keys("{$this->_prefisso()}:{$this->id}:*");
        foreach ( $chiavi as $chiave ) {
            $this->cache->setTimeout($chiave, $secondi);
        }
        $this->cache->setTimeout("{$this->_prefisso()}:{$this->id}", $secondi);
        return true;
    }

    /**
     * Ottiene un elemento per ID oppure lancia un'eccezione
     * @param mixed $id L'ID univoco dell'oggetto
     * @return static Un oggetto
     * @throws Errore in caso di non esistente
     */
    public static function id($id = null) {
        if ( $id === null ) {
            // Non creero' un nuovo oggetto, ID mancante!
            throw new Errore(1011);
        }
        return new static($id);
    }
  
    /**
     * Ritorna un elenco di tutti gli oggetti nel database
     *
     * @param string $ordine    Opzionale. Ordine in SQL
     * @return array            Array di oggetti
     */
    public static function elenco($ordine = '') {
        global $cache;
        $r = [];
        $prefisso = static::_prefisso();
        $chiavi = $cache->keys("{$prefisso}:*");
        foreach ( $chiavi as $chiave ) {
            $id = explode(':', $chiave);
            $r[] = static::id($id[1]);
        }
        return array_unique($r);
    }

    /*
     * Ricerca (lentissima) per uguaglianza, compatibile con Entita::filtra()
     * @param array(mixed) $pars Array di parametri come da Entita::filtra()
     * @return array(static) Array di elementi
     */
    public static function filtra($pars) {
        global $cache;
        $prefisso = static::_prefisso();
        $primaIterazione = true;
        $vecchiRisultati = [];
        foreach ( $pars as $par ) {
            $risultati  = [];
            $nome       = $par[0];
            $valore     = $par[1];
            $chiavi = $cache->keys("{$prefisso}:*:{$nome}");
            foreach ( $chiavi as $chiave ) {
                if ( $cache->get($chiave) == $valore ) {
                    $id = explode(':', $chiave)[1];
                    $risultati[] = $id;
                }
            }
            if ( !$primaIterazione ) {
                $risultati = array_intersect($vecchiRisultati, $risultati);
            }
            $vecchiRisultati = $risultati;
            $primaIterazione = false;
        }
        foreach ( $vecchiRisultati as &$r ) {
            $r = static::id($r);
        }
        return $vecchiRisultati;
    }
    
    public function __toString() {
        return $this->id;
    }
    
    /**
     * Controlla l'esistenza dell'oggetto con un dato ID
     *
     * @param mixed $id     L'ID dell'oggetto da verificare
     * @return bool         Esistenza dell'oggetto
     */
    public static function _esiste ( $id = null ) {
        if (!$id) { return false; }
        global $cache;
        $prefisso = static::_prefisso();
        return (bool) $cache->get("{$prefisso}:{$id}");
    }
    
    /**
     * Metodo di generazione dell'ID per l'oggetto. Sovrascrivibile.
     *
     * @return int  ID numerico progressivo
     */
    protected function generaId() {
        do {
            $id = sha1( microtime() . rand(100, 999) );
        } while (static::_esiste($id));
        return $id;
    }
    
    /**
     * Inizializza un nuovo oggetto e ne aggiunga la riga al database
     */
    protected function _crea () { 
        global $me;
        $this->id = $this->generaId();
        return $this->cache->set(
            "{$this->_prefisso()}:{$this->id}",
            true
        );
    }
    
    public function __get ( $_nome ) {
        return $this->cache->get(
            "{$this->_prefisso()}:{$this->id}:{$_nome}"
        );
        return $r;
    }
    

    public function __set ( $_nome, $_valore ) {
        if ( $_valore === null ) {
            $this->cache->delete(
                "{$this->_prefisso()}:{$this->id}:{$_nome}"
            );
        } else {
            $this->cache->set(
                "{$this->_prefisso()}:{$this->id}:{$_nome}",
                $_valore
            );
        }
    }
    
    /**
     * Cancella l'oggetto ed eventuali dettagli
     */
    public function cancella() {
        $this->cancellaDettagli();
        return $this->cache->delete("{$this->_prefisso()}:{$this->id}");
    }
    
    /**
     * Cancella i dettagli dell'oggetto nella tabella associata
     */
    protected function cancellaDettagli() {
        $chiavi = $this->cache->keys("{$this->_prefisso()}:{$this->id}:*");
        foreach ( $chiavi as $chiave ) {
            $this->cache->delete($chiave);
        }
        return true;
    }
    
    /**
     * Ottiene l'OID dell'oggetto come stringa. Es. 'Utente:15'
     *
     * @return string   OID dell'oggetto
     */
    public function oid() {
        return "{$this->_prefisso()}:{$this->id}";
    }
    
    /**
     * Ritorna un oggetto dall'OID specificato
     *
     * @return static  Oggetto
     */
    public static function daOid($oid) {
        $obj = explode(':', $oid);
        $cl = $obj[0];
        $obj = $cl::id($obj[1]);
        if ( ! $obj instanceOf static ) {
            throw new Errore(1013);
        }
        return $obj;
    }

}
