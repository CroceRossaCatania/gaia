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
    
	public static function filtraDistinctSedi( $_dettaglio, $_where = null ) {
		global $db, $conf;


		if ( $_where ) {
            $_where = static::preparaCondizioni($_where, 'WHERE');
        }

        $query = "SELECT $_dettaglio, id FROM ". static::$_t . " $_where GROUP BY $_dettaglio ORDER BY $_dettaglio";
        
        /*
         * Controlla se la query è già in cache
         */        
        $q = $db->prepare($query);
        $q->execute();
        $t = $c = [];
        while ( $r = $q->fetch(PDO::FETCH_ASSOC) ) {
            $t[$r['id']] = $r[$_dettaglio];
            if ( false )
                $c[] = $r;
        }
        
        return $t;
    }

    public function cancella() {
        DonazionePersonale::cancellaTutti([
            ['luogo', $this->id]
        ]);
        parent::cancella();
    }


}
