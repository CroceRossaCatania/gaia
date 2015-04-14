<?php

/*
 * ©2012 Croce Rossa Italiana
 * 
 */

class DonazionePersonale extends Entita {
    
    public static
        $_t     = 'donazioni_personali',
        $_dt    = null;
    
    public function confermato() {
        return (bool) $this->tConferma;
    }
    
    public function donazione() {
        return Donazione::id($this->donazione);
    }
    
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    public function pConferma() {
        return Volontario::id($this->pConferma);
    }
    
    
    public function tConferma() {
        return DT::daTimestamp($this->tConferma);
    }

    public function data() {
            return DT::daTimestamp($this->data);
    }
    
    public static function pendenti() {
        global $db;
        $q = $db->prepare("SELECT id FROM donazioni_personali WHERE tConferma IS NULL");
        $q->execute();
        $t = [];
        while ( $r = $q->fetch(PDO::FETCH_ASSOC) ) {
            $t[] = new static($r['id'], $r);
        }
        return $t;
    }
    
}