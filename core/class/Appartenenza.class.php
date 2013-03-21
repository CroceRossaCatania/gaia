<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Appartenenza extends Entita {
        protected static
            $_t  = 'appartenenza',
            $_dt = null;
        
        public function richiedi() {
            $this->timestamp = time();
            $this->stato     = MEMBRO_PENDENTE;
            $this->conferma  = 0;
        }

        public function inizio() {
            return new DT('@'. $this->inizio);
        }

        public function fine() {
            return new DT('@'. $this->fine);
        }

        public function comitato() {
            return new Comitato($this->comitato);
        }
        
        public function volontario() {
            return new Volontario($this->volontario);
        }
        
        /* L'appartenenza è ancora attuale? */
        public function attuale() {
            /* Vero se la fine è dopo, o non c'è fine! */
            return ( ( $this->fine > time() ) || ( !$this->fine ) );
        }
}