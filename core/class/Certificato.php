<?php
/*
 * ©2013 Croce Rossa Italiana
 */
/**
 * Rappresenta un Corso.
 */
class Certificato extends Entita {

    protected static
        $_t  = 'certificati',
        $_view  = 'certificati',
        $_dt = 'dettagliCertificati';

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

    /**
     * Se il corso base è attivo e non ci sono partecipanti
     * allora è cancellabile
     * @return bool
     */
    public function cancellabile() {
        /*
        if ($this->stato == CORSO_S_DACOMPLETARE) {
            return true;
        }
        */
        return (bool) ($this->stato == CORSO_S_ATTIVO && $this->numIscritti() == 0);
    }


}