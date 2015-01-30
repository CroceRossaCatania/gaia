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
    
    public function cancella() {
        foreach ( static::filtra([['donazione', $this->id]]) as $t ) {
            $t->cancella();
        }
        parent::cancella();
    }


}
