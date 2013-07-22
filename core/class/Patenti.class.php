
<?php
/*
 * ©2013 Croce Rossa Italiana
 */

class Patenti extends Entita {
    
    protected static
        $_t  = 'patenti',
        $_dt = null;
    
    public function volontario() {
        return new Volontario($this->appartenenza()->volontario());
    }
    
    public function appartenenza() {
        return new Appartenenza($this->appartenenza);
    }
    
    public function comitato() {
        return $this->appartenenza()->comitato();
    }
    
     public function ricercaPatente() {
        $q = $this->db->prepare("
            SELECT DISTINCT (anagrafica.id)
            FROM 
                titoli, titoliPersonali, anagrafica
            WHERE 
                anagrafica.id = titoliPersonali.volontario
            AND 
                titoli.id = titoliPersonali.titolo
            AND 
                titoli.nome LIKE :ricerca
            ORDER BY 
                anagrafica.cognome, 
                anagrafica.nome");
        $q->bindValue ( ":ricerca", $ricerca );
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Volontario($k[0]);
        }
        return $r;
    }    
    
    
}
