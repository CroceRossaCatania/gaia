<?php

/*
 * ©2012 Croce Rossa Italiana
 * 
 */

class DonazionePersonale extends Entita {
    
    public static
        $_t     = 'donazioni_personale',
        $_dt    = null;
    
    use EntitaCache;
    
    public function confermato() {
        return (bool) $this->tConferma;
    }
    
    public function donazione() {
        return Donazione::id($this->donazione);
    }
    
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    public function pConferma() {
        return Volontario::id($this->pConferma);
    }
    
    
    public function tConferma() {
        return DT::daTimestamp($this->tConferma);
    }

    public function data() {
            return DT::daTimestamp($this->data);
    }
    
    public static function pendenti() {
        return static::filtra([
            ['tConferma', null, OP_NULL]
        ]);
    }
    
}
