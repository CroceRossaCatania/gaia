<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Appartenenza extends Entita {
        protected static
            $_t  = 'appartenenza',
            $_dt = null;

        use EntitaCache;
        
        /**
         * Richiede l'appartenenza mettendo come stato membro pendente
         * impostando il timestamp alla data e ora attuali, e resettando la conferma a 0
         */
        public function richiedi() {
            $this->timestamp = time();
            $this->stato     = MEMBRO_PENDENTE;
            $this->conferma  = 0;
        }

        /**
         * Richiede l'estensione mettendo come stato membro estensione pendente
         * impostando il timestamp alla data e ora attuali, e resettando la conferma a 0
         */
        public function richiediEstensione() {
            $this->timestamp = time();
            $this->stato     = MEMBRO_EST_PENDENTE;
            $this->conferma  = 0;
        }

        /**
         * Ritorna la data di inizio appartenenza 
         * @return DT inizio appartenenza
         */
        public function inizio() {
            return DT::daTimestamp($this->inizio);
        }

        /**
         * Ritorna la data di fine appartenenza 
         * @return DT fine appartenenza
         */
        public function fine() {
            return DT::daTimestamp($this->fine);
        }

        /**
         * Ritorna l'oggetto comitato relativo all'appartenenza 
         * @return Comitato Ritorna id del comitato
         */
        public function comitato() {
            return Comitato::id($this->comitato);
        }
        
        /**
         * Ritorna l'oggetto volontario relativo all'appartenenza 
         * @return Volontario
         */
        public function volontario() {
            return Volontario::id($this->volontario);
        }
        

        /* L'appartenenza è ancora attuale? */
        public function attuale() {
            /* Vero se la fine è dopo, o non c'è fine! */
            return ( ( $this->fine > time() ) || ( !$this->fine ) );
        }

        /**
         * Ritorna l'oggetto trasferimento relativo all'appartenenza 
         * @return Trasferimento
         */
        public function trasferimento(){
            return Trasferimento::by('appartenenza', $this);
        }

        /**
         * Ritorna l'oggetto estensione relativo all'appartenenza 
         * @return Estensione
         */
        public function estensione(){
            return Estensione::by('appartenenza', $this);
        }

        /**
         * Ritorna l'oggetto dimissione relativo all'appartenenza 
         * @return Dimissione
         */
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
            $this->volontario()->stato = VOLONTARIO;
            return;
        }

        /**
         * Le appartenenze valide per anzianità sono quelle dei 
         * membri trasferiti o quelle dei membri volontari
         * @return bool True se valida, False altrimenti
         */
        public function validaPerAnzianita($stato = VOLONTARIO) {
            if ($stato == VOLONTARIO) {
                if($this->stato == MEMBRO_VOLONTARIO || $this->stato == MEMBRO_TRASFERITO) {
                    return true;
                }
            } elseif ($stato == PERSONA) {
                if($this->stato == MEMBRO_ORDINARIO) {
                    return true;
                } 
                if($this->stato == MEMBRO_DIMESSO) {
                    return true;
                }
                if($this->stato == MEMBRO_ORDINARIO_DIMESSO) {
                    return true;
                } 
            } elseif ($stato == ASPIRANTE) {
                if($this->stato == MEMBRO_ORDINARIO) {
                    return true;
                }
            }
            return false;
        }

        /**
         * Data un'appartenenza ritorna la tipologia di socio di riferimento
         * @return int|null Costante dello stato socio, null se non primario
         */
        public function statoSocio() {
            switch ($this->stato) {
                case MEMBRO_ORDINARIO_DIMESSO:
                    return PERSONA;
                case MEMBRO_ORDINARIO:
                    return PERSONA;
                case MEMBRO_VOLONTARIO:
                    return VOLONTARIO;
                case MEMBRO_DIMESSO:
                    return VOLONTARIO;
                case MEMBRO_TRASFERITO:
                    return VOLONTARIO;                
                default:
                    return null;
            }
            return null;
        }

}