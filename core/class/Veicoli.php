<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Veicoli extends Oggetto {
  
    public function comitato() {
        if ( $this->comitato ) {
            return Comitato::id($this->comitato);
        } else {
            return false;
        }
    }
    
}