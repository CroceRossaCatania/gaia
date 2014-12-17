<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/**
 * Rappresenta una Entita generica nel database
 *
 * COME CREARE UNA NUOVA ENTITA':
 * 1. Creare una nuova classe che estende Entita (extends Entita)
 * 2. Dichiarare il nome della tabella principale (protected static $_t = 'nome_tabella';)
 * 3. Dichiarare il nome della tabella secondaria (protected static $_dt = 'secondaria'; / protected static $_dt = null;)
 * 4. Aggiungere il trait "EntitaCache" o "EntitaNoCache" (use EntitaCache; / use EntitaNoCache;)
 */
abstract class Entita {
    
    protected
            $db         = null,
            $cache      = null;

    public
            $_v         = [];
    
    /**
     * Il nome della tabella in database 
     */
    protected static $_t     = 'entita';

    /**
     * Il nome della tabella associata all'entita'.
     *
     * Struttura:
     *  id      int,
     *  nome    varchar(64),
     *  valore  text,
     * PRIMARY KEY (id, nome)
     */
    protected static $_dt    = 'entita_dettagli';
    
    /** 
     * L'ID dell'oggetto caricato 
     */
    public          $id;

    
    public function __construct ( $id = null, $caricaDati = false ) {
        global $db, $cache, $conf;

        if ( false && static::$_versione == -1 ) {
            static::_caricaVersione();            
        }

        $this->db = $db;
        if ( false && static::$_cacheable ) {
            $this->cache = $cache;
        }

        if ( $caricaDati !== false ) {
            $this->id = $id;
            $this->_v = $caricaDati;
            return;
        }

        /* Check esistenza */
        if ( self::_esiste($id, $this->_v) ) {
            /* Scaricamento */
            $this->id = $id;
            if ( $this->_v ) {
                return;
            }
            $q = $this->db->prepare("
                SELECT * FROM ". static::$_t ." WHERE id = :id");
            $q->bindParam(':id', $this->id);
            $q->execute();
            $this->_v = $q->fetch(PDO::FETCH_ASSOC);
            if ( $this->cache ) {
                $this->cache->set(static::_chiave($id . ':___campi', false), serialize($this->_v));
            }
        } elseif ( $id === null ) {
            /* Creazione nuovo */
            $this->_crea();
            $this->__construct($this->id);
        } else {
            /* Errore non esistente! */
            $e = new Errore(1003);
            $e->extra = static::$_t. ':' . $id;
            throw $e;
        }
    }
    
    /**
     * Ottiene un singolo elemento per un parametro univoco
     * @param string $_nome Il nome del parametro
     * @param string $_valore Il suo valore
     * @return static|false Un elemento o false
     */
    public static function by($_nome, $_valore) {
        $r = static::filtra([[$_nome, $_valore]], 'id LIMIT 0,1');
        if (!$r) { return false; }
        return $r[0];
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
     * Dato hash della query e array di oggetti, salva in cache
     *
     * @param string $hash Hash md5 della query SQL
     * @param array $valori Array di Entita da salvare come risultato query
     */
    public static function _cacheQuery($hash, $valori) {
        global $cache, $conf;
        $r = serialize($valori);
        $cache->set  ( static::_chiave('query:' . $hash) , $r);
        $cache->rPush( static::_chiave('lista_query'), $hash);
        $cache->incr ( static::_chiave('num_query') );
        return true;
    }

    /**
     * Numero di query in cache per un determinato oggetto
     *
     * @return int Il numero di query in cache
     */
    public static function _numQueryCache() {
        global $cache, $conf;
        return (int) $cache->get( static::_chiave('num_query') );
    }
    
    /**
     * Dato un hash di query SQL ne ritorna il risultato o false se non in cache
     *
     * @param string $hash Hash md5 della query SQL da recuperare
     */
    public static function _ottieniQuery($hash) {
        global $cache, $conf;
        if ( $r = $cache->get( static::_chiave('query:' . $hash) ) ) {
            $k = [];
            foreach ( unserialize($r) as $j ) {
                $k[] = new static($j['id'], $j);
            }
            return $k;
        } else {
            return false;
        }
    }

    /**
     * Invalida le query in cache per questo tipo di oggetto
     */
    protected static function _invalidaCacheQuery() {
        global $cache, $conf;
        if ( !$cache ) { return false; }
        
        static::_incrementaVersione();
        return true;
    }

    /**
     * Cerca oggetti con le corrispondenze specificate
     *
     * @param array $_array     La query associativa di ricerca
     * @param string $_order    Ordine espresso come SQL
     * @return array            Array di oggetti
     */
    public static function filtra($_array, $_order = null) {
        global $db, $conf, $cache;
        $entita = get_called_class();

        if ( false && $cache && static::$_versione == -1 ) {
            static::_caricaVersione();            
        }

        if ( $_order ) {
            $_order = 'ORDER BY ' . $_order;
        }

        $where = static::preparaCondizioni($_array, 'WHERE');

        $query = "SELECT * FROM ". static::$_t . " $where $_order";
        
        /*
         * Controlla se la query è già in cache
         */
        $hash = null;
        if ( false && $cache && static::$_cacheable ) {
            $hash = md5($query);
            $r = static::_ottieniQuery($hash);
            if ( $r !== false  ) {
                $cache->incr( chiave('__re') );
                return $r;
            }
        }
        
        $q = $db->prepare($query);
        $q->execute();
        $t = $c = [];
        while ( $r = $q->fetch(PDO::FETCH_ASSOC) ) {
            $t[] = new $entita($r['id'], $r);
            if ( false )
                $c[] = $r;
        }
        
        if ( false && $cache && static::$_cacheable ) {
            static::_cacheQuery($hash, $c);
        }
        
        return $t;
    }

    /**
     * Conta oggetti con le corrispondenze specificate
     *
     * @param array $_array     La query associativa di ricerca
     * @return int              Numero di risultati
     */
    public static function conta($_array = []) {
        global $db, $conf, $cache;
        $entita = get_called_class();

        $where = static::preparaCondizioni($_array, 'WHERE');

        $query = "SELECT COUNT(id) FROM ". static::$_t . " $where";
        
        $q = $db->prepare($query);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        if ( $r && !((int) $r[0]) ) {
            return 0;
        } else {
            return (int) $r[0];
        }
    }
    
    /**
     * Ritora espressioni SQL (per WHERE clause) da un array associativo
     * @param array $_array Array associativo
     * @param string $prefisso Opzionale. Se c'e' almeno una condizione, premetti questa stringa
     * @return string Stringa SQL
     */
    public static function preparaCondizioni($_array, $prefisso = 'AND') {
        if (!$_array) { return ' '; }
        $_condizioni = [];
        foreach ( $_array as $_elem ) {
            
            if ( $_elem[1] === null ) {
                $_condizioni[] = "{$_elem[0]} IS NULL OR {$_elem[0]} = 0";

            } else {

                if ( isset($_elem[2]) && $_elem[2] != OP_EQ )
                    $op = $_elem[2];
                else
                    $op = OP_EQ;

                if ( $op == OP_SQL ) {
                    $_condizioni[] = "{$_elem[0]}";
                } else if ( is_int($_elem[1]) || is_float($_elem[2]) ) {
                    $_condizioni[] = "{$_elem[0]} {$op} {$_elem[1]}";
                } else {
                    $_condizioni[] = "{$_elem[0]} {$op} '{$_elem[1]}'";
                }

            }
        }
        $stringa = implode(' AND ', $_condizioni);
        $stringa = " {$prefisso} {$stringa} ";
        return $stringa;
    }

    /**
     * Ritorna un elenco di tutti gli oggetti nel database
     *
     * @param string $ordine    Opzionale. Ordine in SQL
     * @return array            Array di oggetti
     */
    public static function elenco($ordine = '') {
        return static::filtra([], $ordine);
    }
    
    /**
     * Effettua una ricerca MySQL FULLTEXT sui campi specificati
     *
     * @param string $query         La query di ricerca.
     * @param array  $campi         Array contenente i campi sui quali effettuare la ricerca
     * @param int    $limit         Opzionale. Default 20. Numero di risultati da ritornare.
     * @param string $altroWhere    Opzionale. Espressione SQL aggiuntiva nel WHERE. Deve iniziare con operatore logico.
     */
    public static function cercaFulltext($query, $campi, $limit = 20, $altroWhere = '') {
        global $db;
        $entita = get_called_class();
        if (count($campi) == 1 AND str_word_count($query) == 1) {
            $stringa = " WHERE {$campi[0]} LIKE :stringa";
            $query = '%' . $query . '%';
        } else {
            foreach ( $campi as &$campo ) {
                $campo = "`{$campo}`";
            }
            $q = $db->quote($query);
            $stringa = " WHERE MATCH (" . implode(', ', $campi) .") AGAINST (:stringa)";
        }
        $q = $db->prepare("
            SELECT id FROM ". static::$_t . " ". $stringa . " " . $altroWhere . " LIMIT 0,$limit");
        $q->bindParam(':stringa', $query);
        $q->execute();
        $t = [];
        while ( $r = $q->fetch(PDO::FETCH_NUM) ) {
            $t[] = new $entita($r[0]);
        }
        return $t;
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
    public static function _esiste ( $id = null, &$scaricaDati = null ) {
        if (!$id) { return false; }
        global $db, $cache, $conf;
        if (false && $cache && static::$_cacheable) {
            if ( $scaricaDati = unserialize($cache->get( static::_chiave($id . ':___campi', false) )) ) {
                return true;
            }
        }

        if ( $scaricaDati === null ) 
            $q = $db->prepare("SELECT id FROM ". static::$_t ." WHERE id = :id");
        else
            $q = $db->prepare("SELECT * FROM ". static::$_t ." WHERE id = :id");

        
        $q->bindParam(':id', $id);
        $q->execute();

        if ( $scaricaDati === null )
            return (bool) $q->fetch(PDO::FETCH_NUM);
        
        $scaricaDati = $q->fetch(PDO::FETCH_ASSOC);
        return (bool) $scaricaDati;
    }
    
    /**
     * Metodo di generazione dell'ID per l'oggetto. Sovrascrivibile.
     *
     * @return int  ID numerico progressivo
     */
    protected function generaId() {
        $q = $this->db->prepare("
            SELECT MAX(id) FROM ". static::$_t );
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        if (!$r) { $r[0] = 0; }
        return (int) $r[0] + 1;
    }

    /**
     * Metodo di generazione di un progressivo
     * @param string $progressivo   il valore che si vuole incrementare
     * @param array $_condizioni    WHERE a=b AND c=d" per array[[a, b], [c, d], ...]
     * @return int valore numerico progressivo
     */
    protected function generaProgressivo($progressivo, $_condizioni = []) {
        $condizioni = static::preparaCondizioni($_condizioni, 'WHERE');
        $q = $this->db->prepare("
            SELECT MAX({$progressivo}) 
            FROM ". static::$_t ."{$condizioni}");
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        if (!$r) { $r[0] = 0; }
        return (int) $r[0] + 1;
    }
    
    /**
     * Inizializza un nuovo oggetto e ne aggiunga la riga al database
     */
    protected function _crea () { 
        global $me;

        $this->id = $this->generaId();
        $q = $this->db->prepare("
            INSERT INTO ". static::$_t ."
            (id) VALUES (:id)");
        $q->bindParam(':id', $this->id);
        $e = $q->execute();

        static::_invalidaCacheQuery();
        return $e;
    }
    
    public function __get ( $_nome ) {
        global $conf;

        if (array_key_exists($_nome, $this->_v)) {
            /* Proprietà interna */
            return $this->_v[$_nome];

        } else {

            if ( $this->cache ) {
                $r = $this->cache->get( static::_chiave($this->id . ':' . $_nome, false) );
                if ( $r !== null && $r !== false && $r !== '' ) {
                    $this->_v[$_nome] = $r;
                    return $r;
                }
            }

            /* Proprietà collegata */
            $q = $this->db->prepare("
                SELECT valore FROM ". static::$_dt ." WHERE id = :id AND nome = :nome");
            $q->bindParam(':id', $this->id);
            $q->bindParam(':nome', $_nome);
            $q->execute();
            $r = $q->fetch(PDO::FETCH_NUM);
            if ($r) {
                $r = $r[0];
            } else {
                $r = null;
            }
        }
        if ( $this->cache ) {
            $this->cache->set(static::_chiave($this->id . ':' . $_nome, false), $r);
        }
        return $r;
    }    

    public function __set ( $_nome, $_valore ) {
        global $conf;
        if ( array_key_exists($_nome, $this->_v) ) {
            /* Proprietà interna */
            $q = $this->db->prepare("
                UPDATE ". static::$_t ." SET $_nome = :valore WHERE id = :id");
            $q->bindParam(':valore', $_valore);
            $q->bindParam(':id', $this->id);
            $q->execute();
            $this->_v[$_nome] = $_valore;
            if ( $this->cache ) {
                $this->cache->set(static::_chiave($this->id . ':___campi', false), serialize($this->_v));
            }

        } else {
            /* Proprietà collegata */
            if ( $_valore === null ) {
                /* Cancella */
                $q = $this->db->prepare("
                    DELETE FROM ". static::$_dt ." WHERE id = :id AND nome = :nome");
                $q->bindParam(':id', $this->id);
                $q->bindParam(':nome', $_nome);
                $q->execute();
            } else {
                $prec = $this->$_nome;
                if ( $prec === null ) {
                    /* Insert! */
                    $q = $this->db->prepare("
                        INSERT INTO ". static::$_dt ."
                        (id, nome, valore)
                        VALUES
                        (:id, :nome, :valore)");
                } else {
                    /* Update */
                    $q = $this->db->prepare("
                        UPDATE ". static::$_dt ." SET
                        valore = :valore
                        WHERE id = :id
                        AND   nome = :nome");
                }
                $q->bindParam(':id', $this->id);
                $q->bindParam(':nome', $_nome);
                $q->bindParam(':valore', $_valore);
                $q->execute();                
            }

        }
        if ( $this->cache ) {
            $this->cache->set(static::_chiave($this->id . ':' . $_nome, false), $_valore);
            static::_invalidaCacheQuery();

        }

    }
    
    /**
     * Cancella l'oggetto ed eventuali dettagli
     */
    public function cancella() {
        global $conf;
        $this->cancellaDettagli();
        $q = $this->db->prepare("
            DELETE FROM ". static::$_t ." WHERE id = :id");
        $q->bindParam(':id', $this->id);
        $q->execute();
        if ( $this->cache ) {
            static::_invalidaCacheQuery();
            $this->cache->delete( static::_chiave($this->id, false) );
        }
    }
    
    /**
     * Cancella i dettagli dell'oggetto nella tabella associata
     */
    protected function cancellaDettagli() {
        if ( !static::$_dt ) { return true; }
        $q = $this->db->prepare("
            DELETE FROM ". static::$_dt ." WHERE id = :id");
        $q->bindParam(':id', $this->id);
        return $q->execute();
    }
    
    /**
     * Ottiene l'OID dell'oggetto come stringa. Es. 'Utente:15'
     *
     * @return string   OID dell'oggetto
     */
    public function oid() {
        $c = get_called_class();
        return "{$c}:{$this->id}";
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

    /**
     * Carica il numero di versione per questa Entita dalla cache
     * @return int Numero di versione
     */
    protected static function _caricaVersione() {
        global $cache;
        if ( !static::$_cacheable ) 
            return -1;
        static::$_versione = (int) $cache->get(
            chiave('versione_cache:' . static::$_t)
        );
    }

    /**
     * Incrementa versione della cache per questa Entita 
     * @return int Nuovo numero di versione
     */
    protected static function _incrementaVersione() {
        global $cache;
        if ( !static::$_cacheable ) {
            return -1;
        }
        static::$_versione = (int) $cache->incr(
            chiave('versione_cache:' . static::$_t)
        );
    }

    /**
     * Ottiene il nome di chiave con o senza numero di versione
     * @param string $suffisso Il suffisso della chiave
     * @param bool $conVersione Includere il numero di versione?
     * @return string La chiave completa
     */
    protected static function _chiave($suffisso, $conVersione = true) {
        $c = chiave('e:' . static::$_t);
        if ( $conVersione )
            $c .= ':' . (int) static::$_versione;
        $c .= ':' . $suffisso;
        return $c;
    }

	/**
     * Ottiene numero di mi piace/ non mi piace per l'oggetto
     * @param int $tipo Uno tra costanti PIACE / NON_PIACE
     * @return int Numero di mi piace o non mi piace 
     */
    public function like($tipo = PIACE) {
        if ( $tipo !== PIACE && $tipo !== NON_PIACE ) {
            throw new Errore(1020);
        }
        return Like::conta([
            ['oggetto', $this->oid()],
            ['tipo',    $tipo]
        ]);
    }

    /**
     * Ottiene quanti mi piace ha ricevuto questo oggetto
     * @return Count
     */ 
    public function miPiace() {
        return $this->like(PIACE);
    }

    /**
     * Ottiene quanti non mi piace ha ricevuto questo oggetto
     * @return Count
     */ 
    public function nonMiPiace() {
        return $this->like(NON_PIACE);
    }
}
