<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Estensione extends Entita {
    
    protected static
        $_t  = 'estensioni',
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
        $a = new Appartenenza($a);
        $a->timestamp = time();
        $a->conferma  = $me->id;    
        $a->stato = MEMBRO_ESTESO;
    }
    
    public function nega($motivo) {
        $this->rispondi(EST_NEGATA, $motivo, false);
    }
    
    public function auto() {
        $this->concedi(true);
    }

    public function termina() {
        $ora = time();
        $this->timestamp = $ora;
        $this->stato = EST_CONCLUSA;
        $app = new Appartenenza($this->appartenenza);
        $app->stato = MEMBRO_EST_TERMINATA;
        $app->fine = time();
        $c = new Comitato($app->comitato);
        $v = new Volontario($this->volontario);

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
            ['comitato', $c->od]
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
    }

    public static function daAutorizzare() {
        $e = Estensione::filtra([
            ['stato', EST_INCORSO]
        ]);
        $r = [];
        $unmesefa = time() - MESE;
        foreach ($e as $_e) {
            if ($_e->appartenenza->inizio < $unmesefa)
                $r[] = $_e;
        }
        return $r;
    }

    public static function daChiudere() {
        $e = Estensione::filtra([
            ['stato', EST_OK]
        ]);
        $r = [];
        $ora = time();
        foreach ($e as $_e) {
            if ($_e->appartenenza()->fine < $ora)
                $r[] = $_e;
        }
        return $r;
    }
        
}
