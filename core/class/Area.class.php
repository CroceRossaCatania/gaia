<?php

class Area extends Entita {
        
    protected static
        $_t  = 'aree',
        $_dt = null;
    
    public function comitato() {
        return new Comitato($this->comitato);
    }
    
    public function responsabile() {
        return new Volontario($this->responsabile);
    }
    
}