<?php
/*
 * ©2013 Croce Rossa Italiana
 */
/**
 * Rappresenta un Corso.
 */
class TipoCorso extends Entita {

    protected static
        $_t  = 'tipoCorsi';
            
    use EntitaCache;

    /**
     * Cancella il corso base e tutto ciò che c'è di associato
     */
    public function cancella() {
        /*
        Corso::cancellaTutti([['corsoBase', $this->id]]);
        Lezione::cancellaTutti([['corso', $this->id]]);
        */
        parent::cancella();
    }

}