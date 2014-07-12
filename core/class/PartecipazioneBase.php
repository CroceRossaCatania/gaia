<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class PartecipazioneBase extends Entita {

    protected static
        $_t  = 'partecipazioniBase',
        $_dt = 'datiPartecipazioniBase';

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

    public function concedi($com = null) {
        global $sessione;
        if($this->aggiorna(ISCR_CONFERMATA)) {
            $u = $this->utente();

            if($com && !$u->appartenenzaAttuale(MEMBRO_ORDINARIO)){
                $a = new Appartenenza();
                $a->volontario  = $this->volontario;
                $a->comitato    = $com;
                $a->inizio      = time();
                $a->fine        = PROSSIMA_SCADENZA;
                $a->timestamp   = time();
                $a->stato       = MEMBRO_ORDINARIO;
                $a->conferma    = $essione->utente()->id();
            }
            return true;
        }
        return false;
    }
    
    public function nega() {
        return $this->aggiorna(ISCR_NEGATA);
    }

    public function aggiorna( $s = ISCR_CONFERMATA ) {
        global $sessione;
        $u = $sessione->utente;
        if($this->stato == ISCR_RICHIESTA){
            $this->stato = (int) $s;
            $this->pConferma = $u;
            $this->tConferma = time();
            return true;
        }
        return false;
    }

    public function haConclusoCorso() {
        return $this->promosso() || $this->bocciato();
    }

    public function promosso() {
        return $this->stato == ISCR_SUPERATO;
    }

    public function bocciato() {
        return $this->stato == ISCR_BOCCIATO;
    }
}
