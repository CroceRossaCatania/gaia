<?php

/*
 * ©2014 Croce Rossa Italiana
 */

class Rifornimento extends Entita {

	protected static
        $_t     = 'rifornimento',
        $_dt    =  null;

    /**
     * Ritorna veicolo
     * @return Veicolo
     */
    public function veicolo() {
        return Veicolo::id($this->veicolo);
    }

    /**
     * Ritorna volontario che ha registrato rifornimento
     * @return Volontario
     */
    public function volontario() {
        return Volontario::id($this->pRegistra);
    }

}