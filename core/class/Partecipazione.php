<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Partecipazione extends Entita {

    protected static
        $_t  = 'partecipazioni',
        $_dt = null;

    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    public function turno() {
        return Turno::id($this->turno);
    }
    
    public function attivita() {
        return $this->turno()->attivita();
    }

    public function comitatoAppartenenza() {
        $oid = $this->turno()->attivita()->comitato;
        return GeoPolitica::daOid($oid);
    }

    public function autorizzazioni() {
        return Autorizzazione::filtra([
            ['partecipazione',  $this->id]
        ]);
    }
    
    public function confermata() {
        return (bool) $this->stato == AUT_OK;
    }

    public function toJSON() {
        global $conf;
        $a = [];
        foreach ( $autorizzazioni as $_a) {
            $a[] = $_a->toJSON();
        }
        return [
            'id'        =>  $this->id,
            'turno'     =>  $this->turno()->toJSON(),
            'attivita'  =>  [
                'id'        =>  $this->turno()->attivita,
                'nome'      =>  $this->turno()->attivita()->nome,
            ],
            'stato'     =>  [
                'id'        =>  (int) $this->stato,
                'nome'      =>  $conf['partecipazione'][$this->stato]
            ],
            'autorizzazioni'    =>  $a
        ];
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
        if ( $this->comitatoAppartenenza()->contieneVolontario($this->volontario()) ) {
            
            /* Allora come da accordi, genero
             * una sola Autorizzazione al referente
             * del comitato organizzatore...
             */
            $a = new Autorizzazione();
            $a->partecipazione = $this->id;
            $a->volontario     = $this->turno()->attivita()->referente()->id;
            $a->richiedi();
            
            $m = new Email('richiestaAutorizzazione', 'Richiesta autorizzazione partecipazione attività');
            $m->da           = $this->volontario();
            $m->a            = $this->turno()->attivita()->referente();
            $m->_NOME        = $this->turno()->attivita()->referente()->nome;
            $m->_ATTIVITA    = $this->turno()->attivita()->nome;
            $m->_VOLONTARIO  = $this->volontario()->nomeCompleto();
            $m->_TURNO       = $this->turno()->nome;
            $m->_DATA        = date('d/m/Y H:i',$this->turno()->inizio);
            $m->invia();
            
        } else {
            
            /*
             * Se chiedo partecipazione in un comitato differente,
             * faccio richiesta al mio presidente ed al referente.
             */
            
            // Al suo...
            $a = new Autorizzazione();
            $a->partecipazione = $this->id;
            $a->volontario     = $this->turno()->attivita()->referente()->id;
            $a->richiedi();
            
            $m = new Email('richiestaAutorizzazione', 'Richiesta autorizzazione partecipazione attività');
            $m->da = $me;
            $m->a            = $this->turno()->attivita()->referente();
            $m->_NOME        = $this->turno()->attivita()->referente()->nome;
            $m->_ATTIVITA    = $this->turno()->attivita()->nome;
            $m->_VOLONTARIO  = $this->volontario()->nomeCompleto();
            $m->_TURNO       = $this->turno()->nome;
            $m->_DATA        = $a->timestamp()->format('d-m-Y H:i');
            $m->invia();
            
            // Al mio...
            
            /* HOTFIX TEMPORANEO "MA GRAN PORCO CAZZO"
            $a = new Autorizzazione();
            $a->partecipazione = $this->id;
            $a->volontario     = $this->volontario()->unComitato()->unPresidente()->id;
            $a->richiedi();
            
            -- Questa roba non funziona se l'estensione dell'attivita' e' cazzo provinciale o superiore...
            -- o comunque superiore alla territoriale. Insomma da rivedere.
            -- Per ora meglio non generare la seconda autorizzazione che generarne una a minchia.
            
            $m = new Email('richiestaAutorizzazione', 'Richiesta autorizzazione partecipazione attività');
            $m->a            = $this->volontario()->unComitato()->unPresidente();
            $m->_NOME        = $this->volontario()->unComitato()->unPresidente()->nome;
            $m->_ATTIVITA    = $this->turno()->attivita()->nome;
            $m->_VOLONTARIO  = $this->volontario()->nomeCompleto();
            $m->_TURNO       = $this->turno()->nome;
            $m->_DATA        = $a->timestamp()->format('d-m-Y H:i');
            $m->invia();
            */
             
        }
        
    }

    public function poteri(){

        return (bool) Delegato::filtra([
                ['partecipazione', $this], 
                ['volontario', $this->volontario()]
                ]);

    }
    
    public function  ritirabile(){
    	if($this->stato == PART_PENDING && $this->turno()->inizio >= time()){
    		return true;
    	}
    	return false;
    }

    public function ritira() {
    	if ( !$this->ritirabile() )
    		return false;
        $v = $this->volontario();
        $m = new Email('volontarioRitirato', 'Un volontario si è ritirato');
        $m->a = $this->attivita()->referente();
        $m->_NOME           = $this->attivita()->referente()->nome;
        $m->_VOLONTARIO     = $v->nomeCompleto();
        $m->_ATTIVITA       = $this->attivita()->nome;
        $m->_TURNO          = $this->turno()->nome;
        $m->_DATA           = $this->turno()->inizio()->inTesto();
        $m->invia();
        $v->numRitirati = ( (int) $v->numRitirati ) + 1;
        $this->cancella();
        return true;
    }

}
