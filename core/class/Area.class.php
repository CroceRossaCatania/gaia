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
    
    public function attivita() {
        return Attivita::filtra([
            ['area',    $this->id]
        ]);
    }
    
    public function nomeCompleto() {
        global $conf;
        $obiettivo = (int) $this->obiettivo;
        return $conf['obiettivi'][$obiettivo] . ': ' . $this->nome;
    }
    
}