<?php

/*
 * ©2012 Croce Rossa Italiana
 * 
 */

class TesserinoRichiesta extends Entita {
    
    protected static
        $_t     = 'tesserinoRichiesta',
        $_dt    = null;

    public function data() {
        return DT::daTimestamp($this->tRichiesta);
    }

    public function dataUltimaLavorazione() {
        return DT::daTimestamp($this->timestamp);
    }

    public function struttura() {
        return GeoPolitica::daOid($this->struttura);
    }

}
