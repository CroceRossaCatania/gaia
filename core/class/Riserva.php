<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Riserva extends Entita {

    protected static
    $_t  = 'riserve',
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
    
    public function presaInCarico() {
        if ( $this->protNumero && $this->protData ) {
            return true;
        } else {
            return false;
        }
    }

    public function rispondi($risposta = RISERVA_OK, $motivo = null, $auto = false) {
        if (!auto) {
            global $sessione;    
            $this->pConferma = $sessione->utente()->id;
        }
        $this->stato = $risposta;
        $this->tConferma = time();
        $this->negazione = $motivo;
    }
    
    public function concedi() {
        $this->rispondi(RISERVA_OK);
    }
    
    public function nega($motivo) {
        $this->rispondi(RISERVA_NEGATA, $motivo);
    }

    public function auto() {
        $this->rispondi(RISERVA_AUTO, null, true);
        $v = $this->volontario();
        $destinatari = [$v, $v->unComitato()->unPresidente];
        foreach ($destinatari as $destinatario) {
            $m = new Email('richiestaRiservaAuto', 'Approvata richiesta riserva');          
            $m->a = $destinatario;
            $m->_NOME       = $v->nome;
            $m->_INIZIO = date('d/m/Y', $this->inizio);
            $m->_FINE = date('d/m/Y', $this->fine);
            $m->invia();
        }
    }
    
    /* Riserva è ancora attuale? */
    public function attuale() {
       /* Vero se la fine è dopo, o non c'è fine! */
       return ( ( ( $this->fine > time() ) || ( !$this->fine ) ) && ( $this->stato!=RISERVA_SCAD ) && ( $this->stato!=RISERVA_NEGATA) );
    }

    public function inizio() {
       return DT::daTimestamp($this->inizio);
    }

    public function fine() {
       return DT::daTimestamp($this->fine);
    }

    public static function daAutorizzare() {
        $ris = Riserva::filtra([
            ['stato', RISERVA_INCORSO]
            ]);
        $r = [];
        $unmesefa = time() - MESE;
        foreach ($ris as $_ris) {
            if ($_ris->timestamp < $unmesefa)
                $r[] = $_ris;
        }
        return $r;
    }

    public static function inScadenza() {
        $risok = Riserva::filtra([
            ['stato', RISERVA_OK]
        ]);
        $risauto = Riserva::filtra([
            ['stato', RISERVA_AUTO]
        ]);
        $ris = array_merge($risok, $risauto);
        $r = [];
        $traunmese = time() + MESE;
        $ora       = time();
        foreach ($ris as $_ris) {
            if ($_ris->fine > $ora && $_ris->fine < $traunmese)
                $r[] = $_ris;
        }
        return $r;
    }

    public function termina() {
       $this->fine = time();
       $this->stato = RISERVA_INT;
    }

    public function annulla() {
        $v = $this->volontario();
        $destinatari = [$v, $v->unComitato()->unPresidente];
        $this->fine = time();
        $this->stato = RISERVA_ANN;
        foreach ($destinatari as $destinatario) {
            $m = new Email('richiestaRiservaAnnullamento', 'Annullata richiesta riserva');          
            $m->a = $destinatario;
            $m->_NOME = $v->nomeCompleto();
            $m->_INIZIO = date('d/m/Y', $r->inizio);
            $m->_FINE = date('d/m/Y', $r->fine);
            $m->invia();
        }

    }
}
?>
