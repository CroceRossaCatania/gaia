<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Appartenenza extends Entita {
        protected static
            $_t  = 'gruppi',
            $_dt = null;
        
        public function richiedi() {
            $this->timestamp = time();
            $this->inizio = time();
        }

        public function inizio() {
            return DT::daTimestamp($this->inizio);
        }

        public function fine() {
            return DT::daTimestamp($this->fine);
        }

        public function comitato() {
            return new Comitato($this->comitato);
        }
        
        public function volontario() {
            return new Volontario($this->volontario);
        }
        
        /* Sono ancora appartenente al gruppo di lavoro ? */
        public function attuale() {
            /* Vero se la fine è dopo, o non c'è fine! */
            return ( ( $this->fine > time() ) || ( !$this->fine ) );
        }
}