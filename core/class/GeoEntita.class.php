<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/* 
 * Una GeoEntità è un'entità che contiene Latitudine
 * e longitudine in un campo: geo POINT.
 */
class GeoEntita extends Entita {
    
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
    
    public function localizzaCoordinate($x, $y) {
        $x = (double) $x;
        $y = (double) $y;
        $q = $this->db->prepare("
            UPDATE ". static::$_t . " SET geo = GeomFromText('POINT({$x} {$y})') WHERE id = :id");
        $q->bindParam(':id', $this->id);
        return $q->execute();
    }
    
    public function localizzaStringa($stringa) {
        $g = new Geocoder($stringa);
        if (!$g->risultati) { return false; }
        return $this->localizzaCoordinate($g->risultati[0]->lat, $g->risultati[0]->lng);
    }
    
    public static function filtraRaggio ( $lat, $lng, $raggio, $_array ) {
        $lat = (double) $lat;
        $lng = (double) $lng;
        $raggio = (float) $raggio;
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
        $centro = "GeomFromText(\"POINT({$lat} {$lng})\")"; 
        $q = $db->prepare("
            SELECT id FROM ". static::$_t . " WHERE 
                SQRT(POW( ABS( X(geo) - X($centro)), 2) + POW( ABS(Y(geo) - Y($centro)), 2 )) < $raggio
              AND
                $stringa");
        $q->execute();
        $t = [];
        while ( $r = $q->fetch(PDO::FETCH_NUM) ) {
            $t[] = new $entita($r[0]);
        }
        return $t;
    }
    
}