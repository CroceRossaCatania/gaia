<?php

class Area extends Entita {
        
    protected static
        $_t  = 'aree',
        $_dt = null;
    
    public function comitato() {
        return GeoPolitica::daOid($this->comitato);
    }
    
    public function responsabile() {
        return Volontario::id($this->responsabile);
    }
    
    public function attivita($apertura = ATT_APERTA) {
        return Attivita::filtra([
            ['area',    $this->id],
            ['apertura', $apertura]
        ]);
    }
    
    public function nomeCompleto() {
        global $conf;
        $obiettivo = (int) $this->obiettivo;
        return $conf['obiettivi'][$obiettivo] . ': ' . $this->nome;
    }
    
    /**
     * In caso di cancellazione o rimozione referente d'area utente, 
     * mette come responsabile d'area o il delegato di obiettivo o il presidente
     */
    public function dimettiReferente(){
        $c = $this->comitato();
        $nuovoRef = $c->obiettivi($this->obiettivo)[0];
        if(!$nuovoRef) {
            $nuovoRef = $c->primoPresidente();
        }
        $this->responsabile = $nuovoRef->id;
        return;
    }
}