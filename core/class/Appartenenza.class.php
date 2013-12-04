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

        public function richiediEstensione() {
            $this->timestamp = time();
            $this->stato     = MEMBRO_EST_PENDENTE;
            $this->conferma  = 0;
        }

        public function inizio() {
            return DT::daTimestamp($this->inizio);
        }

        public function fine() {
            return DT::daTimestamp($this->fine);
        }

        public function comitato() {
            return Comitato::id($this->comitato);
        }
        
        public function volontario() {
            return Volontario::id($this->volontario);
        }
        
        /* L'appartenenza è ancora attuale? */
        public function attuale() {
            /* Vero se la fine è dopo, o non c'è fine! */
            return ( ( $this->fine > time() ) || ( !$this->fine ) );
        }

        public function trasferimento(){
            return Trasferimento::by('appartenenza', $this);
        }

        public function estensione(){
            return Estensione::by('appartenenza', $this);
        }

        /**
         * Nega l'appartenenza mettendo come stato appartenenza negata
         * e impostando la fine dell'appartenenza a time()
         *
         */
        public function nega(){
            $this->stato   = MEMBRO_APP_NEGATA;
            $this->fine    = time();
            return;
        }

        /**
         * Conferma l'appartenenza mettendo come stato membro volonatrio
         * e impostando il timestamp alla data e ora attuali
         * @param $v id volontario che esegue la conferma
         */
        public function conferma($v){
            $this->timestamp = time();
            $this->stato     = MEMBRO_VOLONTARIO;
            $this->conferma  = $v->id; 
            return;
        }

}