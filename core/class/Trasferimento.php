<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Trasferimento extends Entita {

    protected static
        $_t  = 'trasferimenti',
        $_dt = null;

    use EntitaCache;
    
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    public function appartenenza() {
        return Appartenenza::id($this->appartenenza);
    }
    
    public function comitato() {
        return $this->appartenenza()->comitato();
    }
    
    /*  Restituisce il comitato di provenienza
     *  @return comitato di provenienza
     */
    public function provenienza(){
        return Comitato::id($this->cProvenienza);
    }

    public function presaInCarico() {
        if ( $this->protNumero && $this->protData ) {
            return true;
        } else {
            return false;
        }
    }

    public function dataRichiesta() {
        return DT::daTimestamp($this->protData);
    }

    public function nega($motivo) {
        global $sessione;    
        $v = $this->volontario();

        $this->tConferma = time();
        $this->pConferma = $sessione->utente();
        $this->negazione = $motivo;
        $this->stato     = TRASF_NEGATO;

        /* rimetto a posto l'appartenenza attuale */

        $a = Appartenenza::id($this->appartenenza);
        $a->timestamp = time();
        $a->stato     = MEMBRO_TRASF_NEGATO;
        $a->conferma  = $this->pConferma;    
        $a->inizio = time();
        $a->fine = time();
        $m = new Email('richiestaTrasferimentono', 'Richiesta trasferimento negata: ' . $a->comitato()->nome);
        $m->da = $this->pConferma;   
        $m->a = $a->volontario();
        $m->_NOME       = $v->nome;
        $m->_COMITATO   = $a->comitato()->nomeCompleto();
        $m->_TIME = $this->dataRichiesta()->format('d/m/Y');
        $m->_MOTIVO = $motivo;
        $m->invia();
    }
    
    public function auto() {
        $v = $this->volontario();
        $vecchioPresidente = $v->unComitato()->unPresidente();
        $this->trasferisci(true);
        $destinatari = [$v, $vecchioPresidente, $v->unComitato()->unPresidente];
        $m = new Email('richiestaTrasferimentoauto', 'Approvata richiesta trasferimento verso: ' . $v->unComitato()->nome);          
        $m->a = $destinatari;
        $m->_NOME       = $v->nome;
        $m->_COMITATO   = $v->unComitato()->nomeCompleto();
        $m->_TIME = $this->dataRichiesta()->format('d/m/Y');
        $m->accoda();
    }

    public function trasferisci($auto = false) 
    {
        $this->tConferma = time();
        if ($auto) {
            $this->stato = TRASF_AUTO;
        } else {
            global $sessione;    
            $this->stato = TRASF_OK;
            $this->pConferma = $sessione->utente();
        }
        
        $v = $this->volontario();
        $a = $v->appartenenzaAttuale();
        $c = $v->unComitato();

        /* Chiusura delle estensioni in corso*/
        $e = Estensione::filtra([
            ['volontario', $v],
            ['stato', EST_OK]
            ]);

        foreach ($e as $_e){
            $_e->termina();
        }

        /* Chiudo eventuale riserva in corso*/
        $r = Riserva::filtra([
            ['volontario', $v],
            ['stato', RISERVA_OK]
            ]);

        foreach ($r as $_r)
        {
            $_r->fine = time();
            $_r->stato = RISERVA_INT;
        }

        /* Chiudo tutto ciò che è legato all'appartenenza attuale */

        // chiudo le deleghe su quel comitato
        $d = $v->delegazioni(null, $c->id);
        foreach ($d as $_d) {
            $_d->fine = $ora;
        }

        // chiudo le attività referenziate
        $att = Attivita::filtra([
            ['referente',   $v->id],
            ['comitato',    $c->id]
            ]);
        
        $presidente = $c->primoPresidente();
        foreach ($att as $_att) {
            $_att->referente = $presidente->id;
        }

        // rimetto al presidente i gruppi
        $g = Gruppo::filtra([
            ['referente', $v->id],
            ['comitato', $c->id]
            ]);

        foreach ($g as $_g) 
        {
            $_g->referente = $presidente->id;
        }

        // chiudo l'appartenenza ad un gruppo
        $ag = AppartenenzaGruppo::filtra([
            ['volontario', $v->id],
            ['comitato', $c->id]
            ]);
        foreach ($ag as $_ag)
        {
            $_ag->cancella();
        }

        // chiudo le reperibilità
        $re = Reperibilita::filtra([
            ['volontario', $v->id],
            ['comitato', $c->id]
            ]);
        
        foreach ($re as $_re) {
            $_re->cancella();
        }

        // chiudo le partecipazioni
        $p = Partecipazione::filtra([
            ['volontario', $v->id]
            ]);
        foreach ($p as $_p) {
            if ( $_p->turno()->futuro()) {
                $_p->cancella();
            }
        }

        /* Chiudo eventuale richiesta di tesserini o invalido l'attuale */
        $motivo = "Trasferimento presso altro comitato";
        $v->invalidaTesserino($motivo);

        /* Posso chiudere definitivamente la vecchia appartenenza */

        $a->timestamp = time();
        $a->fine = time();
        $a->stato = MEMBRO_TRASFERITO;

        /* A questo punto rendo operativa la nuova appartenenza */
        
        $nuovaApp = $this->appartenenza();
        $nuovaApp->timestamp = time();
        $nuovaApp->stato     = MEMBRO_VOLONTARIO;
        if (!$auto) 
        {
            $nuovaApp->conferma = $sessione->utente()->id;
        }
        $nuovaApp->inizio = time();
        $nuovaApp->fine = PROSSIMA_SCADENZA;

        $destinatari = [$v, $presidente, $nuovaApp->comitato()->unPresidente()];
        $m = new Email('richiestaTrasferimentook', 'Approvata richiesta trasferimento verso: ' . $nuovaApp->comitato()->nome);
        if (!$auto)
        {
            $m->da = $sessione->utente();
        }            
        $m->a = $destinatari;
        $m->_NOME       = $nuovaApp->volontario()->nomeCompleto();
        $m->_COMITATO   = $nuovaApp->comitato()->nomeCompleto();
        $m->_TIME = $this->dataRichiesta()->format('d/m/Y');
        $m->accoda();

      
    }

    public static function daAutorizzare() {
        $t = Trasferimento::filtra([
            ['stato', TRASF_INCORSO]
            ]);
        $r = [];
        $unmesefa = time() - MESE;
        foreach ($t as $_t) {
            if ($_t->appartenenza()->inizio < $unmesefa)
                $r[] = $_t;
        }
        return $r;
    }

    public function annulla() {
        $a = $this->appartenenza();
        $ora = time();
        $a->fine = $ora;
        $a->timestamp = $ora;
        $a->stato = MEMBRO_TRASF_ANN;

        $this->stato = TRASF_ANN;
        $this->timestamp = $ora;

        $v = $this->volontario();

        $destinatari = [$v, $this->comitato()->unPresidente(), $v->unComitato()->unPresidente()];
        $m = new Email('richiestaTrasferimentoAnnullamento', 'Annullata richiesta trasferimento');          
        $m->a = $destinatari;
        $m->_NOME = $v->nomeCompleto();
        $m->_COMITATO = $this->comitato()->nomeCompleto();
        $m->accoda();

    }

    public function cancella() {
        $a = $this->appartenenza();
        $a->cancella();

        parent::cancella();
    }
}
?>