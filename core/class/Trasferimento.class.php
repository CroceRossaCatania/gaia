<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Trasferimento extends Entita {

    protected static
    $_t  = 'trasferimenti',
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

    public function nega($motivo) {
        global $sessione;    
        $v = $this->volontario();

        $this->tCOnferma = time();
        $this->pConferma = $sessione->utente()->id;
        $this->negazione = $motivo;

        /* rimetto a posto l'appartenenza attuale */

        $a = new Appartenenza($this->appartenenza);
        $a->timestamp = time();
        $a->stato     = TRASF_NEGATO;
        $a->conferma  = $sessione->utente()->id;    
        $a->inizio = time();
        $a->fine = time();
        $m = new Email('richiestaTrasferimentono', 'Richiesta trasferimento negata: ' . $a->comitato()->nome);
        $m->da = $sessione->utente()->id;   
        $m->a = $a->volontario();
        $m->_NOME       = $v->nome;
        $m->_COMITATO   = $a->comitato()->nomeCompleto();
        $m-> _TIME = date('d-m-Y', $a->timestamp);
        $m-> _MOTIVO = $this->motivo;
        $m->invia();
    }
    
    public function auto() {
        $v = $this->volontario();
        $vecchioPresidente = $v->unComitato()->unPresidente();
        $this->trasferisci(true);
        $destinatari = [$v, $vecchioPresidente, $v->unComitato()->unPresidente];
        foreach ($destinatari as $destinatario) {
            $m = new Email('richiestaTrasferimentoauto', 'Approvata richiesta trasferimento verso: ' . $v->unComitato()->nome);          
            $m->a = $destinatario;
            $m->_NOME       = $v->nome;
            $m->_COMITATO   = $v->unComitato()->nomeCompleto();
            $m-> _TIME = date('d-m-Y', $t->protData);
            $m->invia();
        }
    }

    public function trasferisci($auto = false) 
    {
        $this->tConferma = time();
        if ($auto) {
            $this->stato = TRASF_AUTO;
        } else {
            global $sessione;    
            $this->stato = TRASF_OK;
            $this->pConferma = $sessione->utente()->id;
        }
        
        $v = $this->volontario();
        $a = $v->appartenenzaAttuale();
        $c = new Comitato($a->comitato);

        /* Chiusura delle estensioni in corso*/
        $e = Estensione::filtra([
            ['volontario', $v],
            ['stato', EST_OK]
            ]);

        foreach ($e as $_e){
            $_e = new Estensione($_e);
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
        
        $presidente = $c->unPresidente();
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
            if ( $_p->turno()->futuro() && $_p->turno()->attivita()->comitato() == $c->id) {
                $_p->cancella();
            }
        }

        /* Posso chiudere definitivamente la vecchia appartenenza */

        $a->timestamp = time();
        $a->fine = time();
        $a->stato = MEMBRO_TRASFERITO;

        /* A questo punto rendo operativa la nuova appartenenza */
        
        $nuovaApp = $this->appartenenza();
        $nuovaApp->timestamp = time();
        $nuovaApp->stato     = MEMBRO_VOLONTARIO;
        if (!auto) 
        {
            $nuovaApp->conferma = $sessione->utente()->id;
        }
        $nuovaApp->inizio = time();
        $nuovaApp->fine = PROSSIMA_SCADENZA;
        if (!auto) {
            $destinatari = [$nuovaApp->volontario(), $c->unPresidente(), $nuovaApp->comitato()->unPresidente];
            foreach ($destinatari as $destinatario) {
                $m = new Email('richiestaTrasferimentook', 'Approvata richiesta trasferimento verso: ' . $nuovaApp->comitato()->nome);
                if (!auto)
                {
                    $m->da = $sessione->utente()->id; 
                }            
                $m->a = $destinatario;
                $m->_NOME       = $nuovaApp->volontario()->nomeCompleto();
                $m->_COMITATO   = $nuovaApp->comitato()->nomeCompleto();
                $m-> _TIME = date('d-m-Y', $t->protData);
                $m->invia();
            } 
        }       
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
}
?>