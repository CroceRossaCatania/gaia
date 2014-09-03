<?php

/*
 * ©2014 Croce Rossa Italiana
 */

class Like extends Entita {
    
    protected static
        $_t         = 'mipiace',
        $_dt        = null,
        $_cacheable = false;    // Risorsa modificata in modo intenso, 
                                // quindi la cache su Redis e' inutile.
        
    /**
     * Ottiene il volontario collegato all'oggetto like
     * @return Volontario
     */
    public function volontario() {
        return Volontario::id($this->volontario);
    }

    /**
     * Ottiene l'oggetto del Like (OID)
     * @return Entita
     */
    public function oggetto() {
        return Entita::daOid($this->oggetto);
    }
    
    /**
     * Ottiene quando apposto il like
     * @return DT
     */ 
    public function timestamp() {
        return DT::daTimestamp($this->timestamp);
    }
     
}