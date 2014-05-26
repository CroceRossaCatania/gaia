<?php

/*
 * ©2012 Croce Rossa Italiana
 * 
 */

class DonazioneSedi extends Entita {
    
    protected static
        $_t     = 'donazioniSedi',
        $_dt    = null;

    public function cancella() {
        foreach ( DonazioneSedi::filtra([['donazione', $this->id]]) as $t ) {
            $t->cancella();
        }
        parent::cancella();
    }


}
