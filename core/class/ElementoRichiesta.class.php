<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class ElementoRichiesta extends Entita {
        protected static
            $_t  = 'elementiRichieste',
            $_dt = null;
        
        public function titolo() {
            return Titolo::id($this->titolo);
        }
}