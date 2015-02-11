<?php

/*
 * ©2015 Croce Rossa Italiana
 * 
 */

class DonazioneSede extends Entita {
    
    protected static
        $_t     = 'donazioni_sedi',
        $_dt    = null;

    use EntitaCache;
    
	public function filtraDistinctSedi( $_dettaglio, $_where = null ) {
		global $db, $conf, $cache;

        if ( false && $cache && static::$_versione == -1 ) {
            static::_caricaVersione();            
        }

		if ( $_where ) {
            $_where = static::preparaCondizioni($_where, 'WHERE');
        }

        $query = "SELECT DISTINCT $_dettaglio, id FROM ". static::$_t . " $_where ORDER BY $_dettaglio";
        
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
            $t[] = $r[$_dettaglio];
            if ( false )
                $c[] = $r;
        }
        
        if ( false && $cache && static::$_cacheable ) {
            static::_cacheQuery($hash, $c);
        }
        
        return $t;
    }

    public function cancella() {
        foreach ( static::filtra([['donazione', $this->id]]) as $t ) {
            $t->cancella();
        }
        parent::cancella();
    }


}
