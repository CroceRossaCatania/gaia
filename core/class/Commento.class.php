<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Commento extends Entita {
        protected static
            $_t  = 'commenti',
            $_dt = null;
        
        public function volontario() {
            return new Volontario($this->volontario);
        }
        
        public function quando() {
        return DT::daTimestamp($this->tCommenta);
    }
     
}