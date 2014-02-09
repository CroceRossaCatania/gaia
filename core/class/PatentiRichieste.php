
<?php
/*
 * ©2013 Croce Rossa Italiana
 */

class Patentirichieste extends Entita {
    
    protected static
        $_t  = 'patentiRichieste',
        $_dt = null;
    
    public function volontario() {
        return Volontario::id($this->appartenenza()->volontario());
    }
    
    public function appartenenza() {
        return Appartenenza::id($this->appartenenza);
    }
    
    public function comitato() {
        return $this->appartenenza()->comitato();
    }
    
    public function titolo() {
        return $this->titolo;
    }
    
}
