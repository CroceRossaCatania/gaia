<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class DT extends DateTime {
    
    /* Controlla se è in un determinato periodo */
    public function in (DateTime $min, DateTime $max) {
        return ( $this > $min && $this < $max );
    }

    public function toJSON () {
        /* ISO 8601 is the way */
    	return $this->format('c');
    }
    
    public static function daTimestamp($timestamp) {
        $x = new DT();
        $x->setTimestamp($timestamp);
        return $x;
    }
    
    public static function daISO($dataISO) {
        return new DT($dataISO);
    }
    
    public static function daNativo(DateTime $nativo) {
        global $conf;
        $x = new DT();
        $x->setTimestamp( $nativo->getTimestamp() );
        $x->setTimezone( new DateTimeZone ( $conf['timezone'] ) );
        return $x;
    }
    
    public function __toString() {
        return $this->getTimestamp();
    }
    
    public function inTesto($conOra = true) {
        $mesi = [false, 'gen', 'feb', 'mar', 'apr', 'mag', 'giu',
                'lug', 'ago', 'set', 'ott', 'nov', 'dic'];
        $base = new DT();
        $oggi = $base->format('Ymd');
        $ieri = $base->modify('-1 day')->format('Ymd');
        $avantieri = $base->modify('-1 day')->format('Ymd');
        $domani = $base->modify('+3 day')->format('Ymd');
        $dopodomani = $base->modify('+1 day')->format('Ymd');
        
        switch ( $this->format('Ymd') ) {
            case $oggi:
                $giorno = 'oggi';
                break;
            case $ieri:
                $giorno = 'ieri';
                break;
            case $avantieri:
                $giorno = 'avantieri';
                break;
            case $domani:
                $giorno = 'domani';
                break;
            case $dopodomani:
                $giorno = 'dopodomani';
                break;
            default:
                $giorno = $this->format('d');
                $m = (int) $this->format('m');
                $giorno .= ' ' . $mesi[$m] . ' ';
                $giorno .= $this->format('Y');
                break;
        }
        
        if ( $conOra ) {
            $giorno .= ' alle ' . $this->format('H:i');
        }
        
        return $giorno;
        
    }

    /**
    * Controlla validità di una data in formato ed esistenza
    * @param $data data in formato gg/mm/aaaa
    * @return false se data errata, true se corretta
    */
    public static function controlloData($data){
        if(DT::createFromFormat('d/m/Y', $data)){
            return true;
        }else{
            return false;
        }
    }
    /**
     * Tenta di istanziare un oggetto DateTime e controlla che non ci siano
     * errori sotto al tappeto
     * @param $data data nel formato selezionato
     * @param $formato string struttura della data (es 'd/m/Y')
     * @return false se la creazione non funziona, DT altrimenti
     */
    public static function daFormato($data, $formato = 'd/m/Y') {
        if (!$date = DateTime::createFromFormat($formato, $data)) {
            return false;
        }
        if(DateTime::getLastErrors()['warning_count'] > 0){
            return false;
        }
        return DT::daNativo($date);
    }
}