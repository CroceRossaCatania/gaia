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

    public function rispondi($risposta = TRASF_OK, $motivo = null) {
        global $sessione;
        $this->stato = $risposta;
        $this->pConferma = $sessione->utente()->id;
        $this->tConferma = time();
        $this->negazione = $motivo;
    }
    
    public function concedi() {
        $this->rispondi(TRASF_OK);
    }
    
    public function nega($motivo) {
        $v = $this->volontario();
        $this->rispondi(TRASF_NEGATO, $motivo);

        /* rimetto a posto l'appartenenza attuale */

        $a = $v->appartenenzaAttuale(); 
        $a->timestamp = time();
        $a->stato     = TRASF_NEGATO;
        $a->conferma  = $me->id;    
        $a->inizio = time();
        $a->fine = time();
        $m = new Email('richiestaTrasferimentono', 'Richiesta trasferimento negata: ' . $a->comitato()->nome);
        $m->da = $sessione->utente()->id;   
        $m->a = $a->volontario();
        $m->_NOME       = $a->volontario()->nome;
        $m->_COMITATO   = $a->comitato()->nomeCompleto();
        $m-> _TIME = date('d-m-Y', $a->timestamp);
        $m-> _MOTIVO = $_POST['motivo'];
        $m->invia();

        
    }
    
    public function auto() {
        $this->trasferisci(true);
    }

    public function trasferisci($auto = false) 
    {
        $v = $this->volontario();
        $a = $v->appartenenzaAttuale();
        $c = new Comitato($a->comitato);
        
        if ($auto) {
            $this->tConferma = time();
            $this->stato = TRASF_AUTO;
        }
        

        /* Chiusura delle estensioni in corso*/
        $e = Estensione::filtra([
            ['volontario', $v],
            ['stato', EST_OK]
            ]);

        foreach ($e as $_e){
            $_e = new Estensione($_e);
        }

        /* Chiudo eventuale riserva in corso*/
        $r = Riserva::filtra([
            ['volontario', $v],
            ['stato', RISERVA_OK]
            ]);

        foreach ($r as $_r)
        {
            $r->fine = time();
            $r->stato = RISERVA_INT;
        }
        

        /* Chiudo tutto ciò che è legato all'appartenenza attuale */

        $a->timestamp = time();
        if (!auto)
            $a->conferma  = $sessione->utente()->id;
        else
            $a->conferma  = 0; 
        $a->fine = time();

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
            $_ag->fine = $ora;
        }

        // chiudo le reperibilità
        $r = Reperibilita::filtra([
            ['volontario', $v->id],
            ['comitato', $c->id]
            ]);
        
        foreach ($r as $_r) {
            if ($_r->fine > $ora)
            {
                $_r->fine = $ora;
                if ($_r->inizio > $_r->fine)
                    $_r->inizio = $ora;
            }
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

        /* A questo punto chiudo l'appartenenza in corso */
        
        $nuovaApp = new Appartenenza($t->appartenenza);
        $nuovaApp->timestamp = time();
        $nuovaApp->stato     = MEMBRO_VOLONTARIO;
        if (!auto) 
        {
            $nuovaApp->conferma = $sessione->utente()->id;
        }
        $nuovaApp->inizio = time();
        $nuovaApp->fine = PROSSIMA_SCADENZA;
        $destinatari = [$nuovaApp->volontario(), $c->unPresidente(), $nuovaApp->comitato()->unPresidente];
        foreach ($destinatari as $destinatario) {
            $m = new Email('richiestaTrasferimentook', 'Approvata richiesta trasferimento verso: ' . $nuovaApp->comitato()->nome);
            if (!auto)
            {
                $m->da = $sessione->utente()->id; 
            }            
            $m->a = $destinatario;
            $m->_NOME       = $nuovaApp->volontario()->nome;
            $m->_COMITATO   = $nuovaApp->comitato()->nomeCompleto();
            $m-> _TIME = date('d-m-Y', $t->protData);
            $m->invia();
        }        
    }

    public static function daAutorizzare() {
        $t = Trasferimento::filtra([
            ['stato', TRASF_INCORSO]
            ]);
        $r = [];
        $unmesefa = time() - MESE;
        foreach ($t as $_t) {
            if ($_t->appartenenza->inizio < $unmesefa)
                $r[] = $_t;
        }
        return $r;
    }
}