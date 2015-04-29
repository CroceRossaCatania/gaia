<?php

/*
 * ©2012 Croce Rossa Italiana
 * 
 */

class Donazione extends Entita {
    
    protected static
        $_t     = 'donazioni',
        $_dt    = null;

    use EntitaCache;
    
    public function cancella() {
        DonazionePersonale::cancellaTutti([
            ['donazione', $this->id]
        ]);
        parent::cancella();
    }

}
