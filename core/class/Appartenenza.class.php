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

        public function dimissione(){
            return Dimissione::by('appartenenza', $this);
        }

        /**
         * Nega l'appartenenza mettendo come stato appartenenza negata
         * inserisce la fine dell'appartenenza a time() e mette chi ha negato
         *
         */
        public function nega($v){
            $this->stato   = MEMBRO_APP_NEGATA;
            $this->fine    = time();
            $this->conferma  = $v->id; 
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

        /**
         * Le appartenenze valide per anzianità sono quelle dei 
         * membri trasferiti o quelle dei membri volontari
         * @return bool True se valida, False altrimenti
         */
        public function validaPerAnzianita() {
            if($this->stato == MEMBRO_VOLONTARIO || $this->statp == MEMBRO_TRASFERITO) {
                return true;
            }
            return false;
        }

}