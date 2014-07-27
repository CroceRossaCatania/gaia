<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Dimissione extends Entita {
        protected static
            $_t  = 'dimissioni',
            $_dt = null;
        
        public function dimetti() {
            $this->tConferma  = time();
            $this->pConferma  = $me;
        }

        public function comitato() {
            return Comitato::id($this->comitato);
        }
        
        public function volontario() {
            return Volontario::id($this->volontario);
        }

        public function appartenenza() {
            return Appartenenza::id($this->appartenenza);
        }
     
        public function dimettente() {
            return Volontario::id($this->pConferma);
        }
}