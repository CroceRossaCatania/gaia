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
        $this->rispondi(TRASF_NEGATO, $motivo);
        /* recuperare appartenenza giusta e sistemare*/
        $t=Appartenenza::filtra([
            ['volontario', $v],
            ['stato', TRASF_INCORSO]
            ]);
        
        foreach ($t as $a ) { 
            if ($a->attuale()) 
            {
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
        }
    }
    
    public function auto() {
        $this->trasferisci(true);
    }

    public function trasferisci($auto = false) 
    {
        $v = $this->volontario();
        if ($auto)
            $this->tConferma = time();
            $this->stato = TRASF_AUTO;

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

        $a = Appartenenza::filtra([
            ['volontario', $v],
            ['stato', MEMBRO_VOLONTARIO]
            ]);


        foreach ($a as $_a ) { 
            if ($_a->attuale()) 
            {
                // perchè la ricreo?? $a = new Appartenenza($_a);
                $c = new Comitato($_a->comitato);
                $_a->timestamp = time();
                if (!auto)
                    $_a->conferma  = $sessione->utente()->id;
                else
                    $_a->conferma  = 0; 
                $_a->fine = time();

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
        }

        $t = Appartenenza::filtra([
            ['volontario', $v],
            ['stato', TRASF_INCORSO]
            ]);

        foreach ($t as $a ) { 
            if ($a->attuale()) 
            {
                $a = new appartenenza($a);
                $a->timestamp = time();
                $a->stato     = MEMBRO_PENDENTE;
                $a->conferma = $me->id;
                $a->inizio = time();
                $a->fine = PROSSIMA_SCADENZA;
                $m = new Email('richiestaTrasferimentook', 'Richiesta trasferimento approvata: ' . $a->comitato()->nome);
                $m->da = $me; 
                $m->a = $a->volontario();
                $m->_NOME       = $a->volontario()->nome;
                $m->_COMITATO   = $a->comitato()->nomeCompleto();
                $m-> _TIME = date('d-m-Y', $t->protData);
                $m->invia();
                break;
            }
        }
    }

    public static function daAutorizzare() {
        $t = Trasferimento::filtra([
            ['stato', EST_INCORSO]
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