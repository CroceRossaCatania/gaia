<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/**
 * Rappresenta un Corso Base.
 */
class CorsoMock { //extends GeoEntita {

    public function __construct($tmp) 
    {
        $this->tmp = $tmp;
        
        $this->titolo = 'Corso BLSD FULL MOCK' . ' - Formazione CRI su Gaia';
        $this->descrizione = 'Ravenna' . ' || Aperto a: ' . 'BLABLABLA'.' || Organizzato da ' . 'Marco Radossi';
        $this->luogo = 'Ravenna';
        $this->timestamp = date("t");
        $this->comitato = 'Comitato:'.$tmp;
    }
    
    public function oid()
    {
        return 1;
    }
    
    public function area()
    {
        return Area::id(5);
    }
    
    public function referente()
    {
        return Volontario::id(3);
    }
    
    public function postiLiberi()
    {
        return 20;
    }
    
    public function linkMappa()
    {
        return "http://".$_SERVER['SERVER_NAME'].'?'.$_SERVER['QUERY_STRING'];
    }
    
}