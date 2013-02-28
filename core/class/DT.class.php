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
    
}