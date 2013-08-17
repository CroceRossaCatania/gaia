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
        if ($auto) {
            global $sessione;
            $this->pConferma = $sessione->utente()->id;    
        } 
        $this->stato = $risposta;
        $this->tConferma = time();
        $this->negazione = $motivo;
    }
    
    public function concedi() {
        $this->rispondi(EST_OK);
        $a = $this->appartenenza;
        $a = new Appartenenza($a);
        $a->timestamp = time();
        $a->conferma  = $me->id;    
        $a->stato = MEMBRO_ESTESO;
    }
    
    public function nega($motivo) {
        $this->rispondi(EST_NEGATA, $motivo);
    }
    
    public function auto() {
        $this->rispondi($risposta = EST_AUTO, $auto = true);
        $this->concedi();
    }

    public function termina() {
        $this->timestamp = time();
        $this->stato = EST_CONCLUSA;
        $app = new Appartenenza($this->appartenenza);
        $app->stato = MEMBRO_EST_TERMINATA;
        $app->fine = time();
        $c = new Comitato($app->comitato);
        $v = new Volontario($this->volontario);

        // chiudo le deleghe su quel comitato
        $d = $v->delegazioni($comitato = $c->id);
        foreach ($d as $_d) {
            $_d->fine();
        }
        // chiudo le attività referenziate
        $a = Attivita::filtra([
            ['referente', $v->id],
            ['comitato', $c->id]
            ]);
        $presidente = $c->unPresidente();
        foreach ($a as $_a) {
            $_a->referente = $presidente->id;
        }

        //togliere i turni?
    }

    public function daAutorizzare() {
        $e = Estensione::filtra(['stato', EST_INCORSO]);
        $r = [];
        $unmesefa = time() - MESE;
        foreach ($e as $_e) {
            if ($_e->appartenenza->inizio < $unmesefa)
                $r[] = $_e;
        }
        return $r;
    }

    public function daChiudere() {
        $e = Estensione::filtra(['stato', EST_OK]);
        $r = [];
        $ora = time();
        foreach ($e as $_e) {
            if ($_e->appartenenza->fine > $ora)
                $r[] = $_e;
        }
        return $r;
    }
        
}
