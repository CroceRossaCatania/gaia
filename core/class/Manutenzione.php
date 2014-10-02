<?php

/*
 * ©2014 Croce Rossa Italiana
 */

class Manutenzione extends Entita {

	protected static
        $_t     = 'manutenzioni',
        $_dt    = null;

    /**
     * Ritorna veicolo
     * @return Object Veicolo
     */
    public function veicolo() {
        return Veicolo::id($this->veicolo);
    }

    /**
     * Ritorna autoparco
     * @return Object Autoparco
     */
    public function autoparco() {
        return Autoparco::id($this->veicolo()->autoparco);
    }

    /**
     * Ritorna la data di manutenzione
     * @return DT
     */
    public function data() {
        return date('d/m/Y', $this->tIntervento);
    }

    /**
     * Ritorna oggetto volontario che ha registrato la manutenzione
     * @return Object Volontatario
     */
    public function pRegistra() {
        return Volontario::id($this->pRegistra);
    }
    
    /**
     * Ritorna l'azienda o testo non specificato
     * @return text
     */
    public function azienda() {
        $azienda = $this->azienda;
        if ( $azienda ){
            return $this->azienda;
        }else{
            return "Non specificato";
        }
    }

    /**
     * Ritorna il numero fattura o testo non specificato
     * @return text
     */
    public function fattura() {
        $fattura = $this->fattura;
        if ( $fattura ){
            return $this->fattura;
        }else{
            return "Non specificato";
        }
    }
}