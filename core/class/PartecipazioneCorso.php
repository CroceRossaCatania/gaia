<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class PartecipazioneCorso extends Entita {

    protected static
        $_t  = 'crs_partecipazioni_corsi',
        $_dt = null;

    use EntitaCache;

    
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    public static function md5($id){
        return md5(MODULO_FORMAZIONE_CORSI_SECUREKEY."_".$id);
    }
    
    public function modificabile() {
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
    }
    
    
    public function aggiungi(Corso $c, Volontario $v, $ruolo=0) {
        global $sessione;

        /*
        $comitato = Comitato::daOid($c->organizzatore);
        if (!$sessione->utente()->presiede($comitato)) { // N.B.: da estendere anche al delegato del presidente
            return false;
        }
        */

        $this->corso = $c->id;
        $this->volontario = $v->id;
        $this->stato = PARTECIPAZIONE_RICHIESTA;
        $this->ruolo = $ruolo;
        $this->md5 = PartecipazioneCorso::md5($this->id);
        $this->timestamp = (new DT())->getTimestamp();
        
        $this->inviaInvito($c);
        return true;
    }
    
    
     /**
     * Genera attestato, sulla base del corso e del volontario
     * @return PDF 
     */
    public function inviaInvito(Corso $c) {
        print "inviaInvito";
        $m = new Email('crs_invitoDocente', "Invito ".$this->id);

        $m->a = $this->volontario();
        //$m->da = "pizar79@gmail.com";
        //$m->a = $this->direttore();
        $m->_NOME = $this->volontario()->nomeCompleto();
        $m->_HOSTNAME = filter_input(INPUT_SERVER, "SERVER_NAME");
        $m->_CORSO = $c->nome();
        $m->_DATA = $c->inizio();
        $m->_ID = $this->id;
        $m->_MD5 = $this->md5;
        $m->invia();
        
        return $m;
    }
    
    public function richiedi() {
        /*
        $m = new Email('richiestaPartecipazioneCorso', 'È richiesta la tua partecipazione ad un corso');
        $m->a = $this->attivita()->referente();
        $m->_NOME           = $this->attivita()->referente()->nome;
        $m->_VOLONTARIO     = $v->nomeCompleto();
        $m->_ATTIVITA       = $this->attivita()->nome;
        $m->_TURNO          = $this->turno()->nome;
        $m->_DATA           = $this->turno()->inizio()->inTesto();
        if (!$m->invia())
            return false;
        */
        return true;
    }

    
    /*
     * Ritira la prenotazione ( da parte dell'organizzatore)
     * @return bool false se la prenotazione non e ritirabile, altrimenti true
     */
    public function ritira(String $motivo) {
        global $sessione;

        // DA CHIEDERE: 
        // se la partecipazione di un istruttore è ritirata
        // prima che partano i giorni "buffer", c'è ancora tempo per cercare altri istruttori
        // diversamente il corso viene annullato d'ufficio
        
        $comitato = Comitato::daOid($c->organizzatore);
        if (!$sessione->utente()->presiede($comitato)) { // N.B.: da estendere anche al delegato del presidente
            return false;
        }
        
        if (!$this->modificabile() &&
            $this->stato == PARTECIPAZIONE_ACCETTATA &&
            $this->ruolo == CORSO_RUOLO_DOCENTE
           ) {
            // cancellazione del corso e collegati, 
            // compreso il record db di questo oggetto PartecipazioneCorso
            
            // notifiche a chi di dovere
            return true;
        }
        
        // mettere corso in stato pending
            
        if (!empty($motivo)) {
            $this->note = $this->note .' Partecipazione ritirata dal presidente/delegato: "'.$motivo.'".';
        }
        $this->stato = PARTECIPAZIONE_RITIRATA;
        
        return true;
    }
    
    
    /**
     * Nega la presenza al corso
     * @return bool false se la prenotazione non è negata, altrimenti true
     */
    public function nega(String $motivo) {
        global $sessione;

        if ($this->stato != PARTECIPAZIONE_RICHIESTA) {
            return false;
        }
        
        if (!$this->modificabile()) {
            return false;
        }
            
        if ($sessione->utente()->id != $this->volontario) {
            return false;
        }
        
        if ( !empty($motivo) ) {
            $this->note = $this->note .' Partecipazione negata dal volontario: "'.$motivo.'".';
        }
        $this->stato = PARTECIPAZIONE_NEGATA;
        return true;
    }
    
    
    /**
     * Accetta di essere presente al corso
     * @return bool false se la prenotazione non è negata, altrimenti true
     */
    public function accetta($md5 = null) {
        global $sessione;
        if ($this->stato != PARTECIPAZIONE_RICHIESTA) {
            return false;
        }
        
        if (!$this->modificabile() && false) {
            return false;
        }
            
        if ($sessione->utente()->id != $this->volontario && $this->md5 != $md5) {
            return false;
        }

        $this->tConferma = time();
        $this->stato = PARTECIPAZIONE_ACCETTATA;
        return true;
    }
    
    
    /**
     * Annulla la conferma di presenza, generalmente per motivi imprevisti
     * @return bool false se la prenotazione non e ritirabile, altrimenti true
     */
    public function annulla($motivo) {
        global $sessione;

        if ($this->stato != PARTECIPAZIONE_ACCETTATA) {
            return false;
        }
        
        if (!$this->modificabile()) {
            return false;
        }
        
        if ($sessione->utente()->id != $this->volontario) {
            return false;
        }
        
        if ( !empty($motivo) ) {
            $this->note = $this->note .' Partecipazione attullata dal volontario: "'.$motivo.'".';
        }
        
        return true;
    }
    
    
    /**
     * Conferma la presenza al corso
     * @return bool false se la prenotazione non è confermata, altrimenti true
     */
    public function conferma() {
        global $sessione;

        if ($this->stato != PARTECIPAZIONE_ACCETTATA) {
            return false;
        }

        if (!$this->modificabile()) {
            return false;
        }
        
        try {
            $c = Corso::id($this->corso);
        } catch(Exception $e) {
            return false;
        }
        
        if (!$c->finito()) {
            return false;
        }
            
        if ($sessione->utente()->id != $c->direttore) {
            return false;
        }
        
        $this->stato = PARTECIPAZIONE_CONFERMATA;
        return true;
    }
}
