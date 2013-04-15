<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Partecipazione extends Entita {

    protected static
        $_t  = 'partecipazioni',
        $_dt = null;

    public function volontario() {
        return new Volontario($this->volontario);
    }
    
    public function turno() {
        return new Turno($this->turno);
    }
    
    public function attivita() {
        return $this->turno()->attivita();
    }

    public function comitatoAppartenenza() {
        return $this->turno()->attivita()->comitato();
    }

    public function autorizzazioni() {
        return Autorizzazione::filtra([
            ['partecipazione',  $this->id]
        ]);
    }
    
    public function confermata() {
        return (bool) $this->stato == AUT_OK;
    }

    public function aggiornaStato() {
        $stato = AUT_OK;
        foreach ( $this->autorizzazioni() as $a ) {
            if ( $a->stato == AUT_PENDING ) {
                $stato = AUT_PENDING;
            } elseif ( $a->stato == AUT_NO ) {
                $stato = AUT_NO;
                break;
            }
        }
        $this->stato = $stato;
        return $stato;
    }

    public function cancella() {
        foreach ( $this->autorizzazioni() as $aut ) {
            $aut->cancella();
        }
        parent::cancella();
    }
    
    public function generaAutorizzazioni() {
        
        /* IMPORTANTE: Logica generazione autorizzazioni */
        
        // Se richiedo part., nello stesso comitato
        if ( $this->comitatoAppartenenza()->haMembro($this->volontario()) ) {
            
            /* Allora come da accordi, genero
             * una sola Autorizzazione al presidente
             * del comitato organizzatore...
             */
            $a = new Autorizzazione();
            $a->partecipazione = $this->id;
            $a->volontario     = $this->turno()->attivita()->referente()->id;
            $a->richiedi();
            
        } else {
            
            /*
             * Se chiedo partecipazione in un comitato differente,
             * faccio richiesta al mio ed al suo presidente.
             */
            
            // Al suo...
            $a = new Autorizzazione();
            $a->partecipazione = $this->id;
            $a->volontario     = $this->turno()->attivita()->referente()->id;
            $a->richiedi();
            
            // Al mio...
            $a = new Autorizzazione();
            $a->partecipazione = $this->id;
            $a->volontario     = $this->volontario()->unComitato()->unPresidente()->id;
            $a->richiedi();
            
        }
        
    }

}