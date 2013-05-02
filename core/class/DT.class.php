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
    	return $this->format('r');
    }
    
    public static function daTimestamp($timestamp) {
        $x = DT::createFromFormat('U', $timestamp);
        return self::daNativo($x);
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
}