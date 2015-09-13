<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class RisultatoCorso extends Entita {

    protected static
        $_t  = 'crs_risultati_corsi',
        $_dt = null;

    use EntitaCache;

    
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    
    public function modificabile() {
        /*
        if (!$this->inizio || !$this->corso) {
            return false;
        }

        try {
            $c = Corso::id($this->corso);
        } catch(Exception $e) {
            return false;
        }
        
        $inizio = $c->inizio;
        $oggi = (new DT())->getTimestamp();
        $buffer = GIORNI_PARTECIPAZIONE_NON_MODIFICABILE * 86400;
        
        return (($oggi-$inizio) > $buffer);
        */
        return false;
    }
    
}
