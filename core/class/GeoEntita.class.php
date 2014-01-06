<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/**
 * Rappresenta una entita' con una posizione nello
 * spazio (coordinate polari).
 *
 * ATTENZIONE: Deve avere campo
 *  geo point
 * Nella tabella principale del database
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
        $coordinate = $this->coordinate();
        if ( $coordinate[0] === false ) {
            return '0.0, 0.0';
        }
        return $coordinate[0].', '.$coordinate[1];
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
     * @param string    $order  Opzionale. Eventuale ordine (espresso come in SQL)
     * @return  array   Un array di oggetti trovati, od un array vuoto
     */
    public static function filtraRaggio ( $lat, $lng, $raggio, $_array = [], $order = 'distanza ASC') {
        global $db;
        $entita = get_called_class();
        if ( $order ) { $order = " ORDER BY $order"; }
        $distanza = static::formulaDistanzaEuclidea($lat, $lng); 
        $query  = "SELECT id, ";
        $query .= static::formulaDistanzaEuclidea($lat, $lng) . " as distanza ";
        $query .= "FROM ". static::$_t . " WHERE";
        $query .= static::formulaDistanzaEuclidea($lat, $lng) . " < "
                  . static::raggioInRadiani($raggio);
        $query .= static::preparaCondizioni($_array);
        $query .= " ORDER BY {$order}";
        $q = $db->query($q);
        $t = [];
        while ( $r = $q->fetch(PDO::FETCH_NUM) ) {
            $t[] = $entita::id($r[0]);
        }
        return $t;
    }

    /**
     * Ritorna l'espressione SQL della distanza euclidea di un oggetto da un PUNTO (Lat, Lng)
     * @param float $x Latitudine del punto
     * @param float $y Longitudine del punto     
     * @return string Stringa SQL
     */
    public static function formulaDistanzaEuclidea($x, $y, $prefisso = '') {
        $x = (double) $x;
        $y = (double) $y;
        if ( $prefisso ) {
            $prefisso = "{$prefisso}.";
        }
        $punto = "GeomFromText(\"POINT({$x} {$y})\")";
        return " SQRT(POW(ABS(X({$prefisso}geo)-X({$punto})),2)+POW(ABS(Y({$prefisso}geo)-Y({$punto})),2)) ";
    }

    /**
     * Ritorna l'espressione SQL della distanza euclidea di un oggetto da un PUNTO (GeoEntita)
     * @param GeoEntita $punto Un punto in database
     * @return string Stringa SQL
     */
    public static function formulaDistanzaEuclideaPunto(GeoEntita $punto, $prefisso = '') {
        $coordinate = $punto->coordinate();
        return static::formulaDistanzaEuclidea($coordinate[0], $coordinate[1], $prefisso);
    }

    /**
     * Converte il raggio da RADIANI in KM (se si scrive cosi')
     * @todo Questa roba e' molto ma molto approssimativa
     * @param float $km In km
     * @return double $rad 
     */
    public static function raggioInRadiani($km) {
        return (float) $km / 69;
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

    /**
     * Ottiene tutti gli oggetti all'interno di una data circonferenza
     * @param GeoCirco      $circo          La circonferenza
     * @param array         $_condizioni    Eventuali condizioni aggiuntive
     * @param string        $_ordine        Ordine come query SQL
     * @return array Un array di oggetti
     */
    public static function contenutiIn (
        GeoCirco $circo,
        $_condizioni = [],
        $_ordine = 'distanza ASC'
    ) {
        global $db;
        $raggio = (float) $circo->raggio;
        $query  = "SELECT " . static::$_t. ".id, ";
        $query .= static::formulaDistanzaEuclideaPunto($circo, static::$_t) . 'as distanza ';
        $query .= 'FROM '. static::$_t .', ' . $circo::$_t . ' WHERE ';
        $query .= "ST_CONTAINS( ";
        $query .=   "BUFFER(".$circo::$_t.".geo, {$raggio}),";
        $query .=   static::$_t . ".geo";
        $query .= ") ";
        $query .= " AND " . $circo::$_t . ".id = {$circo->id} ";
        $query .= static::preparaCondizioni($_condizioni);
        $query .= "ORDER BY {$_ordine}";
        $query = $db->query($query);
        $r = [];
        while ( $k = $query->fetch(PDO::FETCH_NUM) ) {
            $r[] = static::id($k[0]);
        }
        return $r;
    }

    public function linkMappa() {
        $n = urlencode($this->luogo);
        $c = $this->coordinate();
        $c = $c[0] . ',' . $c[1];
        return "http://maps.google.com/?q={$n}@{$c}";
    }

    
}
