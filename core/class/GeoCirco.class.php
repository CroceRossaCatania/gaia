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
    	
    }

    public static function cheIntersecano ( GeoCirco $circonferenza, $_condizioni = [] ) {}

}
