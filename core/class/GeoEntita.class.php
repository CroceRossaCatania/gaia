<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/**
 * Rappresenta una entita' con una posizione nello
 * spazio (coordinate polari).
 */
abstract class GeoEntita extends Entita {
    
    /**
     * Ottiene le coordinate polari di un oggetto
     * @return array    Un array di coordinate polari [float x, float y]
     *                  Se non ha posizione, [false, false]
     */
    public function coordinate() {
        $q = $this->db->prepare("
            SELECT X(geo), Y(geo) FROM ". static::$_t . " WHERE id = :id");
        $q->bindParam(':id', $this->id);
        $q->execute();
        if ( $r = $q->fetch(PDO::FETCH_NUM) ) {
            return [$r[0], $r[1]];
        } else {
            return [false, false];
        }
    }
    
    /**
     * Ottiene una stringa che rappresenta le coordinate polari di un oggetto
     * @return string "x, y" es. "1.23, 4.56"
     */
    public function latlng() {
        return $this->coordinate()[0].', '.$this->coordinate()[1];
    }
    
    /**
     * Assegna le coordinate polari all'oggetto
     * @param float $x Latitudine
     * @param float $y Longitudine
     */
    public function localizzaCoordinate($x, $y) {
        $x = (double) $x;
        $y = (double) $y;
        $q = $this->db->prepare("
            UPDATE ". static::$_t . " SET geo = GeomFromText('POINT({$x} {$y})') WHERE id = :id");
        $q->bindParam(':id', $this->id);
        return $q->execute();
    }
    
    /**
     * Assegna una posizione attraverso un indirizzo-stringa da Geocodificare
     * @param string $stringa Un indirizzo che si assume ben formattato
     */
    public function localizzaStringa($stringa) {
        $g = new Geocoder($stringa);
        if (!$g->risultati) { return false; }
        return $this->localizzaCoordinate($g->risultati[0]->lat, $g->risultati[0]->lng);
    }
    
    /**
     * Elenca tutti gli oggetti dati un centro, un raggio, eventuali condizioni ed ordine
     * @param float     $lat    Latitudine del centro della ricerca
     * @param float     $lng    Longitudine del centro della ricerca
     * @param float     $raggio Raggio di ricerca
     * @param array     $_array Opzionale. Array associativo delle condizioni da soddisfare
     * @param string    $order  Opzionale. Eventuale ordine (espresso come ORDER BY <$order> in SQL)
     * @return  array   Un array di oggetti trovati, od un array vuoto
     */
    public static function filtraRaggio ( $lat, $lng, $raggio, $_array = [], $order = null) {
        $lat = (double) $lat;
        $lng = (double) $lng;
        $raggio = (float) $raggio0 / 69;
        global $db;
        $entita = get_called_class();
        $_condizioni = [];
        foreach ( $_array as $_elem ) {
            if ( $_elem[1] == null ) {
                $_condizioni[] = "{$_elem[0]} IS NULL";
            } else {
                $_condizioni[] = "{$_elem[0]} = '{$_elem[1]}'";
            }
        }
        $stringa = implode(' AND ', $_condizioni);
        if ( $order ) { $order = " ORDER BY $order"; }
        $centro = "GeomFromText(\"POINT({$lat} {$lng})\")"; 
        $q = $db->prepare("
            SELECT id FROM ". static::$_t . " WHERE 
                SQRT(POW( ABS( X(geo) - X($centro)), 2) + POW( ABS(Y(geo) - Y($centro)), 2 )) < $raggio
              AND
                $stringa
                $order");
        $q->execute();
        $t = [];
        while ( $r = $q->fetch(PDO::FETCH_NUM) ) {
            $t[] = new $entita($r[0]);
        }
        return $t;
    }
    
    /**
     * Controlla se l'oggetto ha una posizione assegnata o meno
     * @return bool Se l'oggetto ha posizione/coordinate o meno
     */
    public function haPosizione() {
        $c = $this->coordinate();
        if ( $c[0] == 0 && $c[1] == 0 ) {
            return false; 
        } else {
            return true;
        }
    }
    
    protected function _crea () { 
        global $me;
        $this->id = $this->generaId();

        $q = $this->db->prepare("
            INSERT INTO ". static::$_t ."
            (id, geo) VALUES (:id, GeomFromText('POINT (0 0)'))");
        $q->bindParam(':id', $this->id);
        $r = $q->execute();
        
        static::_invalidaCacheQuery();
        return $r;
    }
    
}
