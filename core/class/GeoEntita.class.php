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
    
    public function latlng() {
        return $this->coordinate()[0].', '.$this->coordinate()[1];
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

        /* PROCEDURA DI LOGGING SELVAGGIO */
        $file = './upload/log/estremo.geoentita.' . date('Ymd') . '.txt';
        $testo  = date('YmdHis') . ',';
        $testo .= $this->oid() . ',';
        $testo .= base64_encode(serialize($_POST)) . ',';
        $testo .= base64_encode(serialize($_GET)) . ',';
        $testo .= base64_encode(print_r($me->id, true)) . ',';
        $testo .= base64_encode(serialize($_SERVER)) . "\n";
        file_put_contents($file, $testo, FILE_APPEND);

        $q = $this->db->prepare("
            INSERT INTO ". static::$_t ."
            (id, geo) VALUES (:id, GeomFromText('POINT (0 0)'))");
        $q->bindParam(':id', $this->id);
        return $q->execute();
    }
    
}
