<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Entita {
    
    protected
            $db     = null,
            $cache  = null,
            $_v     = [],
            $_cacheable = true;
    
    private static
            $_t     = 'nomeEntita',
            $_dt    = null;
    
    public
            $id;
    
    public function __construct ( $id = null ) {
        global $db, $cache;
        $this->db = $db;
        if ( $this->_cacheable ) {
            $this->cache = $cache;
        }
        /* Check esistenza */
        if ( self::_esiste($id) ) {
            /* Scaricamento */
            $this->id = $id;
            if ( $this->cache ) {
                if ( $this->_v = unserialize( $this->cache->get( $conf['db_hash'] . static::$_t . ':' . $id . ':___campi') ) ) {
                    return;
                }
            }
            $q = $this->db->prepare("
                SELECT * FROM ". static::$_t ." WHERE id = :id");
            $q->bindParam(':id', $this->id);
            $q->execute();
            $this->_v = $q->fetch(PDO::FETCH_ASSOC);
            if ( $this->cache ) {
                $this->cache->set($conf['db_hash'] . static::$_t . ':' . $id . ':___campi', serialize($this->_v));
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
    
    public static function by($_nome, $_valore) {
        $r = static::filtra([[$_nome, $_valore]], 'id LIMIT 0,1');
        if (!$r) { return false; }
        return $r[0];
    }

    /*
     * Ottiene un elenco di tutti gli hash delle query in cache per l'oggetto
     */
    public static function _elencoCacheQuery() {
        global $cache, $conf;
        if ( !$cache ) { return []; }
        $get = $cache->get($conf['db_hash'] . static::$_t . ':query_cache');
        if (!$get) { return []; }
        return json_decode($get);
    }
    
    /*
     * Aggiunge un determinato hash all'elenco delle query in cache
     */
    public static function _aggiungiElencoCacheQuery($hash) {
        global $cache, $conf;
        $r = static::_elencoCacheQuery();
        $r[] = $hash;
        $cache->set($conf['db_hash'] . static::$_t . ':query_cache', json_encode($r));
        return true;
    }
    
    /*
     * Dato hash della query e array di oggetti, lo aggiunge
     */
    public static function _cacheQuery($hash, $valori) {
        global $cache, $conf;
        $r = [];
        foreach ( $valori as $valore ) {
            $r[] = $valore->oid();
        }
        $r = json_encode($r);
        $cache->set($conf['db_hash'] . static::$_t . ':query:' . $hash, $r);
        static::_aggiungiElencoCacheQuery($hash);
        return true;
    }
    
    /*
     * Dato un hash vede se esiste e torna il risultato
     */
    public static function _ottieniQuery($hash) {
        global $cache, $conf;
        if ( $r = $cache->get($conf['db_hash'] . static::$_t . ':query:' . $hash) ) {
            $k = [];
            foreach ( json_decode($r) as $j ) {
                $k[] = Entita::daOid($j);
            }
            return $k;
        } else {
            return false;
        }
    }

    /*
     * Invalida tutta la cache query
     */
    protected static function _invalidaCacheQuery() {
        global $cache, $conf;
        /* Cancella prima tutte le query che sono state cacheate */
        foreach ( static::_elencoCacheQuery() as $hash ) {
            $cache->delete($conf['db_hash'] . static::$_t . ':query:' . $hash);
        }
        /* Cancella poi l'elenco stesso in cache */
        $cache->delete($conf['db_hash'] . static::$_t . ':query_cache');
        return true;
    }
    
    public static function filtra($_array, $_order = null) {
        global $db, $conf, $cache;
        $entita = get_called_class();
        $_condizioni = [];
        foreach ( $_array as $_elem ) {
            if ( $_elem[1] === null ) {
                $_condizioni[] = "{$_elem[0]} IS NULL OR {$_elem[0]} = 0";
            } else {
                if ( is_int($_elem[1]) ) {
                    $_condizioni[] = "{$_elem[0]} = {$_elem[1]}";
                } else {
                    $_condizioni[] = "{$_elem[0]} = '{$_elem[1]}'";
                }
            }
        }
        $stringa = implode(' AND ', $_condizioni);
        if ( $_order ) {
            $_order = 'ORDER BY ' . $_order;
        }
        $where = ''; // Permette query senza condizioni
        if ( $_condizioni ) {
            $where = 'WHERE';
        }
        $query = "
            SELECT id FROM ". static::$_t . " $where $stringa $_order";
        
        /*
         * Controlla se la query è già in cache
         */
        $hash = null;
        if ( $cache ) {
            $hash = sha1($query);
            $r = static::_ottieniQuery($hash);
            if ( $r !== false  ) {
                $cache->increment($conf['db_hash'] . '__re');
                return $r;
            }
        }
        
        $q = $db->prepare($query);
        $q->execute();
        $t = [];
        while ( $r = $q->fetch(PDO::FETCH_NUM) ) {
            $t[] = new $entita($r[0]);
        }
        
        /*
         * Mette in cache la query
         */
        if ( $cache ) {
            static::_cacheQuery($hash, $t);
        }
        
        return $t;
    }
    
    public static function elenco($ordine = '') {
        return static::filtra([], $ordine);
    }
    
    public static function cercaFulltext($query, $campi, $limit = 20, $altroWhere = '') {
        global $db;
        $entita = get_called_class();
        //var_dump(count($campi), str_word_count($campi[0]));
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
    
    public static function _esiste ( $id = null ) {
        if (!$id) { return false; }
        global $db, $cache, $conf;
        if ($cache) {
            if ( $cache->get($conf['db_hash'] . static::$_t . ':' . $id) ) {
                return true;
            }
        }
        $q = $db->prepare("
            SELECT id FROM ". static::$_t ." WHERE id = :id");
        $q->bindParam(':id', $id);
        $q->execute();
        $y = (bool) $q->fetch(PDO::FETCH_NUM);
        if ($cache && $y) {
            $cache->set($conf['db_hash'] . static::$_t . ':' . $id, 'true');
        }
        return $y;
    }
    
    protected function generaId() {
        $q = $this->db->prepare("
            SELECT MAX(id) FROM ". static::$_t );
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        if (!$r) { $r[0] = 0; }
        return (int) $r[0] + 1;
    }
    
    protected function _crea () { 
        global $me;

        $this->id = $this->generaId();
        $q = $this->db->prepare("
            INSERT INTO ". static::$_t ."
            (id) VALUES (:id)");
        $q->bindParam(':id', $this->id);
        $e = $q->execute();

        /* PROCEDURA DI LOGGING SELVAGGIO */
        $file = './upload/log/estremo.' . date('Ymd') . '.txt';
        $testo  = date('YmdHis') . ',';
        $testo .= $this->oid() . ',';
        $testo .= base64_encode(serialize($_POST)) . ',';
        $testo .= base64_encode(serialize($_GET)) . ',';
        $testo .= base64_encode(print_r($me->id, true)) . ',';
        $testo .= base64_encode(serialize($_SERVER)) . "\n";
        file_put_contents($file, $testo, FILE_APPEND);

        static::_invalidaCacheQuery();
        return $e;
    }
    
    public function __get ( $_nome ) {
        global $conf;
        if ( $this->cache ) {
            $r = $this->cache->get($conf['db_hash'] . static::$_t . ':' . $this->id . ':' . $_nome);
            if ( $r !== false ) {
                return $r;
            }
        }
        if (array_key_exists($_nome, $this->_v) ) {
            /* Proprietà interna */
            $q = $this->db->prepare("
                SELECT $_nome FROM ". static::$_t ." WHERE id = :id");
            $q->bindParam(':id', $this->id);
            $q->execute();
            $r = $q->fetch(PDO::FETCH_NUM);
            $r = $r[0];

        } else {
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
            $this->cache->set($conf['db_hash'] . static::$_t . ':' . $this->id . ':' . $_nome, $r);
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
            $this->cache->set($conf['db_hash'] . static::$_t . ':' . $this->id . ':' . $_nome, $_valore);
            static::_invalidaCacheQuery();
        }
    }
    
    public function cancella() {
        global $conf;
        $this->cancellaDettagli();
        $q = $this->db->prepare("
            DELETE FROM ". static::$_t ." WHERE id = :id");
        $q->bindParam(':id', $this->id);
        $q->execute();
        if ( $this->cache ) {
            static::_invalidaCacheQuery();
            $this->cache->delete($conf['db_hash'] . static::$_t . ':' . $this->id);
        }
    }
    
    protected function cancellaDettagli() {
        if ( !static::$_dt ) { return true; }
        $q = $this->db->prepare("
            DELETE FROM ". static::$_dt ." WHERE id = :id");
        $q->bindParam(':id', $this->id);
        return $q->execute();
    }
    
    public function oid() {
        $c = get_called_class();
        return "{$c}:{$this->id}";
    }
    
    public static function daOid($oid) {
        $obj = explode(':', $oid);
        $cl = $obj[0];
        return new $cl($obj[1]);
    }

}
