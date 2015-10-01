<?php
/*
 * ©2013 Croce Rossa Italiana
 */
/**
 * Rappresenta un Corso.
 */
class TipoCorso extends Entita {

    protected static
        $_t  = 'crs_tipoCorsi';
            
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

    public static function limiteMinimoPerIscrizione() {
        global $db;

        $q = $db->query("SELECT MIN(limitePerIscrizione) FROM ". static::$_t." WHERE limitePerIscrizione IS NOT NULL");
        $row = $q->fetch();
        return intval($row[0]);
    }
    
}