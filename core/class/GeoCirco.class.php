<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/**
 * Rappresenta una entita' con posizione nello spazio
 * e raggio (una circonferenza)
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

        $query  = "SELECT id FROM ". static::$_t ." WHERE ";
        $query .= "ST_CONTAINS( ";
        $query .=   "BUFFER(GEOMFROMTEXT('POINT({$this->latlng()})'), raggio),";
        $query .=   "GEOMFROMTEXT('POINT({$punto->latlng()})')";
        $query .= ") ";
    	SET @point = BUFFER(GEOMFROMTEXT('POINT(1 0)'), 0.0001);
SET @poly = GEOMFROMTEXT('POLYGON((0 0,2 0,2 4,0 6,0 0))');
SELECT ST_CROSSES( @point, @poly);

    }

    public static function cheIntersecano ( GeoCirco $circonferenza, $_condizioni = [] ) {}

}
