<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Riserva extends Entita {
    
    protected static
        $_t  = 'riserve',
        $_dt = null;
    
    public function volontario() {
        return new Volontario($this->volontario);
    }
    
    public function appartenenza() {
        return new Appartenenza($this->appartenenza);
    }
    
    public function comitato() {
        return $this->appartenenza()->comitato();
    }
    
    public function presaInCarico() {
        if ( $this->protNumero && $this->protData ) {
            return true;
        } else {
            return false;
        }
    }
        
    public function rispondi($risposta = RISERVA_OK, $motivo = null) {
        global $sessione;
        $this->stato = $risposta;
        $this->pConferma = $sessione->utente()->id;
        $this->tConferma = time();
        $this->negazione = $motivo;
    }
    
    public function concedi() {
        $this->rispondi(RISERVA_OK);
    }
    
    public function nega($motivo) {
        $this->rispondi(RISERVA_NEGATA, $motivo);
    }
    
/* Riserva è ancora attuale? */
   public function attuale() {
       /* Vero se la fine è dopo, o non c'è fine! */
       return ( ( ( $this->fine > time() ) || ( !$this->fine ) ) && ( $this->stato!=RISERVA_SCAD ) && ( $this->stato!=RISERVA_NEGATA) );
   }

   public function inizio() {
       return DT::daTimestamp($this->inizio);
   }

   public function fine() {
       return DT::daTimestamp($this->fine);
   }
}