<?php

class Provvedimento extends Entita {
        
    protected static
        $_t  = 'provvedimenti',
        $_dt = null;

    use EntitaCache;
    
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    public function appartenenza() {
        return Appartenenza::id($this->appartenenza);
    }
    
    public function comitato() {
        return $this->appartenenza()->comitato();
    } 

    /*
     *  Determina se il provvedimento è attuale
     *  @return bool true or false
     */ 
    public function attuale() {
        /* Vero se la fine è dopo, o non c'è fine! */
        return ( ( $this->fine > time() ) || ( !$this->fine ) );
    }

    /*
     * Partecipazione attività provvedimento
     */
    public function noPartecipare(){
        if($this->stato >= PROV_SOSPENSIONE && $this->attuale())
            return true;
        return false;
    } 
}