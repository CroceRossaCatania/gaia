<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Estensione extends Entita {
    
    protected static
        $_t  = 'estensioni',
        $_dt = null;
    
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    public function appartenenza() {
        return Appartenenza::id($this->appartenenza);
    }
    

    public function comitato() {
        return $this->appartenenza()->comitato();
    }

    public function provenienzaa() {
        return $this->cProvenienza->comitato();
    }

    public function presaInCarico() {
        if ( $this->protNumero && $this->protData ) {
            return true;
        } else {
            return false;
        }
    }
        
    public function rispondi($risposta = EST_OK, $motivo = null, $auto = false) {
        if (!$auto) {
            global $sessione;
            $this->pConferma = $sessione->utente()->id;    
        } 
        $this->stato = $risposta;
        $this->tConferma = time();
        $this->negazione = $motivo;
    }
    
    public function concedi($auto = false) {
        if (!$auto)
            $this->rispondi(EST_OK, null, false);
        else
            $this->rispondi(EST_AUTO, null, true);        
        $a = $this->appartenenza;
        $a = Appartenenza::id($a);
        $a->timestamp = time();
        if (!$auto) {
            global $sessione;
            $a->conferma  = $sessione->utente()->id;
        }
        $a->stato = MEMBRO_ESTESO;
    }
    
    public function nega($motivo) {
        $this->rispondi(EST_NEGATA, $motivo, false);
    }
    
    public function auto() {
        $this->concedi(true);
        $a = $this->appartenenza;
        $a = Appartenenza::id($a);
        $v = $a->volontario();
        $destinatari = [$v, $a->comitato()->unPresidente(), $v->unComitato()->unPresidente()];
        foreach ($destinatari as $destinatario) {
            $m = new Email('richiestaEstensioneauto', 'Richiesta estensione approvata: ' . $a->comitato()->nome);
            $m->a = $destinatario;
            $m->_NOME       = $a->volontario()->nomeCompleto();
            $m->_COMITATO   = $a->comitato()->nomeCompleto();
            $m-> _TIME = date('d/m/Y', $this->timestamp);
            $m->invia();
        }
    }

    public function termina() {
        $this->timestamp = time();
        $this->stato = EST_CONCLUSA;
        $app = $this->appartenenza();
        $app->stato = MEMBRO_EST_TERMINATA;
        $app->fine = time();
        $c = $app->comitato();
        $v = $this->volontario();

        // chiudo le deleghe su quel comitato
        $d = $v->delegazioni(null, $c->id);
        foreach ($d as $_d) {
            $_d->fine = $ora;
        }
        // chiudo le attività referenziate
        $a = Attivita::filtra([
            ['referente',   $v->id],
            ['comitato',    $c->id]
        ]);
        $presidente = $c->unPresidente();
        foreach ($a as $_a) {
            $_a->referente = $presidente->id;
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
        $r = Reperibilita::filtra([
            ['volontario', $v->id],
            ['comitato', $c->id]
            ]);
        foreach ($r as $_r) {
            $_r->cancella();
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

        // mando email per avvisare dello spiacevole evento :o(
        $destinatari = [$v, $app->comitato()->unPresidente(), $v->unComitato()->unPresidente()];
        foreach ($destinatari as $destinatario) {
            $m = new Email('richiestaEstensioneConclusa', 'Termine estensione: ' . $app->comitato()->nome);
            $m->a = $destinatario;
            $m->_NOME       = $app->volontario()->nomeCompleto();
            $m->_COMITATO   = $app->comitato()->nomeCompleto();
            $m->invia();
        }
    }

    public static function daAutorizzare() {
        $e = Estensione::filtra([
            ['stato', EST_INCORSO]
        ]);
        $r = [];
        $unmesefa = time() - MESE;
        foreach ($e as $_e) {
            if ($_e->appartenenza()->inizio < $unmesefa)
                $r[] = $_e;
        }
        return $r;
    }

    public static function daChiudere() {
        $eok = Estensione::filtra([
            ['stato', EST_OK]
        ]);
        $eauto = Estensione::filtra([
            ['stato', EST_AUTO]
        ]);
        $e = array_merge($eok, $eauto);
        $r = [];
        $ora = time();
        foreach ($e as $_e) {
            if ($_e->appartenenza()->fine < $ora)
                $r[] = $_e;
        }
        return $r;
    }

    public static function inScadenza() {
        $eok = Estensione::filtra([
            ['stato', EST_OK]
        ]);
        $eauto = Estensione::filtra([
            ['stato', EST_AUTO]
        ]);
        $e = array_merge($eok, $eauto);
        $r = [];
        $traunmese = time() + MESE;
        foreach ($e as $_e) {
            if ($_e->appartenenza()->fine < $traunmese)
                $r[] = $_ris;
        }
        return $r;
    }

    public function annulla() {
        $a = $this->appartenenza();
        $ora = time();
        $a->fine = $ora;
        $a->timestamp = $ora;
        $a->stato = MEMBRO_EST_ANN;

        $this->timestamp = $ora;
        $this->stato = EST_ANN;

        $v = $this->volontario();

        $destinatari = [$v, $this->comitato()->unPresidente(), $v->unComitato()->unPresidente()];
        foreach ($destinatari as $destinatario) {
            $m = new Email('richiestaEstensioneAnnullamento', 'Annullata richiesta estensione');          
            $m->a = $destinatario;
            $m->_NOME = $v->nomeCompleto();
            $m->_COMITATO = $this->comitato()->nomeCompleto();
            $m->invia();
        }
    }
        
}
