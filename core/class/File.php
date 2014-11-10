<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class File extends Entita {
    
    public static
            $_t     = 'file',
            $_dt    = null;

    use EntitaCache;
    
    public function autore() {
        return Utente::id($this->autore);
    }
    
    public function __construct($id = null) {
        if (!$id) {
            parent::__construct();
            $this->creazione = time();
            $this->scadenza  = strtotime('+1 days');
        } else {
            parent::__construct($id);
        }
    }
    
    protected function generaId() {
        do {
            $n = sha1( microtime() . rand(100, 999) ) . rand(100, 999);
        } while (self::_esiste($n));
        if ( !is_dir('./upload/get') )
            mkdir('./upload/get');
        return $n;
    }
    
    public function scadenza() {
        return DT::daTimestamp($this->scadenza);
    }
    
    public function creazione() {
        return DT::daTimestamp($this->creazione);
    }
    
    public function esiste() {
        return is_readable($this->percorso());
    }
    
    public function percorso() {
        return './upload/get/' . $this->id;
    }
    
    public function download() {
        header('Location: ./download.php?id=' . $this->id );
        exit(0);
    }

    public function url() {
        return './download.php?anteprima&id=' . $this->id;
    }
    
    public function anteprima() {
        header('Location: ./download.php?anteprima&id=' . $this->id );
        exit(0);
    }
    
    public static function scaduti() {
        global $db;
        $q = $db->prepare("
            SELECT id FROM file WHERE scadenza <= :ora ");
        $q->bindValue(':ora', time());
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new File($k[0]);
        }
        return $r;
    }
    
    public function cancella() {
        if(is_file($this->percorso())) {
            unlink(realpath($this->percorso()));
        }
        parent::cancella();
    }
}