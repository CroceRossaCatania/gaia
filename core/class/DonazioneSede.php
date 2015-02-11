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
    
	public function getLocationSedi( $dettaglio ) {
		global $db, $conf, $cache;
        $entita = get_called_class();

        if ( false && $cache && static::$_versione == -1 ) {
            static::_caricaVersione();            
        }

        $query = "SELECT DISTINCT $dettaglio FROM ". static::$_t;
        
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
        $r = $q->execute();
        
        return $r;
    }

    public function cancella() {
        foreach ( static::filtra([['donazione', $this->id]]) as $t ) {
            $t->cancella();
        }
        parent::cancella();
    }


}
