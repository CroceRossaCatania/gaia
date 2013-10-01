<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/**
 * Rappresenta una entita' con posizione nello spazio
 * e raggio (una circonferenza)
 *
 * ATTENZIONE: Deve avere campo
 *  raggio float
 * Nella tabella principale del database
 */
abstract class GeoCirco extends GeoEntita {
    
    /**
     * Ottiene tutti gli oggetti che hanno estensione in un dato punto
     * @param GeoEntita 	$punto 			Il punto per il quale cercare oggetti
     * @param array 		$_condizioni 	Eventuali condizioni aggiuntive
     * @param string 		$_ordine 		Ordine come query SQL
     * @return array Un array di oggetti
     */
    public static function chePassanoPer (
    	GeoEntita $punto,
    	$_condizioni = [],
    	$_ordine = 'distanza ASC'
    ) {
        global $db;
        $query  = "SELECT id, ";
        $query .= static::formulaDistanzaEuclideaPunto($punto) . 'as distanza';
        $query .= 'FROM '. static::$_t .' WHERE ';
        $query .= "ST_CONTAINS( ";
        $query .=   "BUFFER(GEOMFROMTEXT('POINT({$this->latlng()})'), raggio),";
        $query .=   "GEOMFROMTEXT('POINT({$punto->latlng()})')";
        $query .= ") ";
        $query .= static::preparaCondizioni($_condizioni);
        $query .= "ORDER BY {$_ordine}";
        $query = $db->query($query);
        $r = [];
        while ( $k = $query->fetch(PDO::FETCH_NUM) ) {
            $r[] = static::id($k[0]);
        }
        return $r;
    }

    /**
     * Ottiene tutti gli oggetti che intersecano un altro GeoCirco
     * @todo Da implementare!
     * @param GeoCirco      $circo          Circonferenza che deve essere intersecata
     * @param array         $_condizioni    Eventuali condizioni aggiuntive
     * @return array Un array di oggetti
     */
    public static function cheIntersecano(
        GeoCirco $circo,
        $_condizioni = []
    ) { }


}
