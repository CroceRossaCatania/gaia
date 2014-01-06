<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Partecipazione extends Entita {

    protected static
        $_t  = 'partecipazioniBase',
        $_dt = null;

    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    public function corsoBase() {
        return CorsoBase::id($this->corsoBase);
    }
    
    public function organizzatore() {
        return $this->corsoBase->organizzatore();
    }
    
    public function confermata() {
        return (bool) $this->stato == AUT_OK;
    }

    /* TODO: implementare cancellazione presente al corso*/
    public function cancella() {
        // qui
        parent::cancella();
    }

}
