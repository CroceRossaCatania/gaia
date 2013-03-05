<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Utente extends Persona {
    
    /*
     * @param string $password dell'utente
     * @return bool
     */
    public function login($password) {
        if ( $this->password == criptaPassword($password) ) {
            return true;
        } else {
            return false;
        }
    }

    public static function listaAdmin() {
        global $db;
        $q = $db->prepare("
            SELECT
                id
            FROM
                anagrafica
            WHERE
                admin > 0
            ORDER BY
                nome ASC, cognome ASC");
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Utente($k[0]);
        }
        return $r;
    }
    
    public function nomeCompleto() {
        return $this->nome . ' ' . $this->cognome;
    }
    
    public function cambiaPassword($nuova) {
        $this->password = criptaPassword($nuova);
        return true;
    }
    
    public function appartenenze() {
        $a = Appartenenza::filtra([
            ['volontario',  $this->id]
        ]);
        return $a;
    }
    
    public function storico() {
        $q = $this->db->prepare("
            SELECT id FROM appartenenza WHERE volontario = :id
            ORDER BY inizio DESC");
        $q->bindParam(':id', $this->id);
        $q->execute();
        $r = [];
        while ( $f = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Appartenenza($f[0]);
        }
        return $r;
    }
    
    public function appartenenzePendenti() {
        $q = $this->db->prepare("
            SELECT id FROM appartenenza WHERE
            volontario = :id AND stato = :stat");
        $q->bindParam(':id', $this->id);
        $stat = MEMBRO_PENDENTE;
        $q->bindParam(':stat', ($stat));
        $q->execute();
        $r = [];
        while ( $x = $q->fetch(PDO::FETCH_NUM)) {
            $r[] = new Appartenenza($x[0]);
        }
        return $r;
    }
    
    public function in(Comitato $c) {
        $a = Appartenenza::filtra([
            ['volontario',  $this->id],
            ['comitato',    $c->id]
        ]); 
        return (bool) $a;
    }
    public function volontario() {
        return new Volontario($this->id);
    }
    
    public function admin() {
        if ( $this->admin) {
            return true;
        } else {
            return false;
        }
    }
    
    public function titoli() {
        return TitoloPersonale::filtra([
            ['volontario',  $this->id]
        ]);
    }    
    public function titoliPersonali() {
        $r = [];
        foreach (TitoloPersonale::filtra([
            ['volontario',  $this->id]
        ]) as $titolo) {
            if ( $titolo->titolo()->tipo == TITOLO_PERSONALE ) {
                $r[] = $titolo;
            }
        }
        return $r;
    }    
    public function titoliTipo( $tipoTitoli ) {
        $r = [];
        foreach (TitoloPersonale::filtra([
            ['volontario',  $this->id]
        ]) as $titolo) {
            if ( $titolo->titolo()->tipo == $tipoTitoli ) {
                $r[] = $titolo;
            }
        }
        return $r;
    }

    public function haTitolo ( Titolo $titolo ) {
        $t = $this->titoli();
        foreach ( $t as $x ) {
            if ( $x->titolo() == $titolo ) {
                return true;
            }
        }
        return false;
    }
    
    public function toJSON() {
        return [
            'id'        =>  $this->id,
            'nome'      =>  $this->nome,
            'cognome'   =>  $this->cognome
        ];
    }

    public function calendarioAttivita(DT $inizio, DT $fine) {
        $c = $this->appartenenze();
        $t = [];
        foreach ( $c as $x ) {
            foreach ( $x->comitato()->calendarioAttivitaPrivate($inizio, $fine) as $a ) {
                $t[] = $a;
            }
        }
        foreach ( Attivita::filtra([['pubblica',  ATTIVITA_PUBBLICA]]) as $a ) {
            $t[] = $a;
        }
        return $t;
    }
    
    public function appartenenzeAttuali($tipo = MEMBRO_VOLONTARIO) {
        $q = $this->db->prepare("
            SELECT
                appartenenza.id
            FROM
                appartenenza
            WHERE
                stato >= :tipo
            AND
                volontario = :me
            AND
                ( appartenenza.fine < 1
                 OR
                appartenenza.fine > :ora )");
        $q->bindParam(':tipo', $tipo);
        $ora = time();
        $q->bindParam(':ora',  $ora);
        $q->bindParam(':me', $this->id);
        $q->execute();
        $r = [];
        while ( $x = $q->fetch(PDO::FETCH_NUM ) ) {
            $r[] = new Appartenenza($x[0]);
        }
        return $r;
    }
    
    public function numeroAppartenenzeAttuali($tipo = MEMBRO_VOLONTARIO) {
        $q = $this->db->prepare("
            SELECT
                COUNT( appartenenza.id )
            FROM
                appartenenza
            WHERE
                stato >= :tipo
            AND
                volontario = :me
            AND
                ( appartenenza.fine < 1 
                 OR
                appartenenza.fine > :ora )");
        $q->bindParam(':tipo', $tipo);
        $q->bindParam(':me', $this->id);
        $ora = time();
        $q->bindParam(':ora',  $ora);
        $q->execute();
        $q = $q->fetch(PDO::FETCH_NUM);
        return $q[0];
    }
    
    /*
     * Ritorna le appartenenze delle quali si è presidente.
     */
    public function presidenziante() {
        return $this->appartenenzeAttuali(MEMBRO_PRESIDENTE);
    }
    
    public function presiede() {
        return (bool) $this->numeroAppartenenzeAttuali(MEMBRO_PRESIDENTE);
    }
    
    /* Avatar */
    public function avatar() {
        $a = Avatar::by('utente', $this->id);
        if ( $a ) {
            return $a;
        } else {
            $a = new Avatar();
            $a->utente = $this->id;
            return $a;
        }
    }
    
    public function cancella() {
        $this->avatar()->cancella();
        parent::cancella();
    }
    
}