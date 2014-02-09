<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class PartecipazioneBase extends Entita {

    protected static
        $_t  = 'partecipazioniBase',
        $_dt = null;

    public function utente() {
        return Utente::id($this->volontario);
    }
    
    public function corsoBase() {
        return CorsoBase::id($this->corsoBase);
    }
    
    public function organizzatore() {
        return $this->corsoBase->organizzatore();
    }
    
    public function confermata() {
        return (bool) $this->stato == ISCR_CONFERMATA;
    }

    /* TODO: implementare cancellazione presenze al corso*/
    public function cancella() {
        // qui
        parent::cancella();
    }

    public function attiva() {
        if ((int) $this->stato >= ISCR_RICHIESTA)
            return true;
        return false;
    }

}
