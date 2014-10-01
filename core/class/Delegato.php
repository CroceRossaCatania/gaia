<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Delegato extends Entita {
    
    protected static
        $_t  = 'delegati',
        $_dt = null;

    use EntitaCache;
    
    public function volontario() {
        return Volontario::id($this->volontario);
    }

    public function comitato() {
        return GeoPolitica::daOid($this->comitato);
    }
    
    public function estensione() {
        return $this->comitato()->estensione();
    }

    public function attuale() {
	$ora = time();
        if (
	    ( !$this->fine || $this->fine > $ora )
	      && $this->inizio <= $ora ) {
            return true;
        } else {
            return false;
        }
    }
    
    public function inizio() {
        return DT::daTimestamp($this->inizio);
    }    
    
    public function fine() {
        return DT::daTimestamp($this->fine);
    }
    
    public function pConferma() {
        return Volontario::id($this->pConferma);
    }
 

    /**
     * In caso di cancellazione o rimozione delegato utente, 
     * mette come delegato il presidente
     * @param $num numero dell'obiettivo strategico
     */
    public function dimettiDelegatoObiettivo($num){
        $c = $this->comitato();
        $this->fine = time();

        $area = Area::filtra([
            ['comitato', $c->oid()],
            ['nome', 'Generale'],
            ['obiettivo', $num]
        ]); 
    
        if ($area) {
            $area = $area[0];
            if($area->attivita()) {
                $area->responsabile = $c->primoPresidente()->id;    
            } else {
                $area->cancella();
            }
            
        } else {
            /* Per compatibilità con le aree cancellate, se l'area non c'è più la ricreo*/
            $a = new Area();
            $a->comitato    = $c->oid();
            $a->obiettivo   = $num;
            $a->nome        = 'Generale';
            $a->responsabile= $c->primoPresidente()->id;
        } 
        return;
    }   
}
