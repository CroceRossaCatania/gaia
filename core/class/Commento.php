<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Commento extends Entita {
    
    protected static
        $_t  = 'commenti',
        $_dt = null;

    use EntitaCache;
        
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    public function autore() {
        return $this->volontario();
    }
        
    public function quando() {
        return DT::daTimestamp($this->tCommenta);
    }
    
    public function risposte() {
        return Commento::filtra([
            ['upCommento',  $this->id]
        ], 'tCommenta DESC');
    }
    
    /**
     * Ottiene quanti mi piace ha ricevuto commento
     * @return Count
     */ 
    public function miPiace() {
        return count(Like::filtra([['commento', $this],['stato', PIACE]]));
    }

    /**
     * Ottiene quanti non mi piace ha ricevuto commento
     * @return Count
     */ 
    public function nonMiPiace() {
        return count(Like::filtra([['commento', $this],['stato', NON_PIACE]]));
    }

    /**
     * Ottiene l'attività a cui si riferisce il commento
     * @return Attivita
     */ 
    public function attivita() {
        return Attivita::id($this->attivita);
    }
}