<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Sessione extends Entita {
    
    protected static
            $_t  = 'sessioni',
            $_dt = 'datiSessione',
            $_cacheable = false;        // Non memorizzare in cache!
    
    public function __construct ( $id = null ) {
        try {
           /* Carica */
           parent::__construct($id);
        } catch ( Errore $e ) {
           /* Se non esiste crea */
           $this->__construct(null);
        }
        if (!$this->valida()) {
            /* Se non valida cancella */
            $this->utente = null;
        }
        $this->touch();
    }

    
    public function utente() {
        if ( $this->utente ) {
            return new Utente($this->utente);
        } else {
            return null;
        }
    }
    
    public function logout() {
        $this->utente = null;
    }
    
    protected function generaId() {
        do {
            $n = sha1( microtime() . rand(100, 999) ) . rand(100, 999);
        } while (self::_esiste($n));
        return $n;
    }
    
    public function touch() {
        $this->azione = time();
    }
    
    public function valida() {
        global $conf;
        if ( $this->azione + $conf['sessioni']['durata'] < time() ) {
            /* $this->cancella(); */
            return false;
        } else {
            return true;
        }
    }
    
    public function toJSON () {
        if ( $this->utente ) {
            $u = $this->utente()->toJSON();
        } else {
            $u = false;
        }
        return [
            'id'            =>  $this->id,
            'identificato'  =>  (bool) $u,
            'utente'        =>  $u,
            'scadenza'       =>  DT::daTimestamp(                
                $this->azione + $conf['sessioni']['durata'] 
            )->toJSON()
        ];
    }
    
    
    public static function scadute() {
        global $db, $conf;
        $q = $db->prepare("
            SELECT id FROM sessioni WHERE azione <= :massimo ");
        $q->bindValue(':massimo', time() - $conf['sessioni']['durata']);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Sessione($k[0]);
        }
        return $r;
    }
    
}