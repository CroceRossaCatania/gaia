<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class ElementoRichiesta extends Entita {
        protected static
            $_t  = 'elementiRichieste',
            $_dt = null;
        
        public function titolo() {
            return new Titolo($this->titolo);
        }

     	public function richiesta() {
            return new RichiestaTurno($this->richiesta);
        }

}