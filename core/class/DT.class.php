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
}