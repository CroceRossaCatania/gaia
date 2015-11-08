<?php
/*
 * ©2013 Croce Rossa Italiana
 */
/**
 * Rappresenta un Corso.
 */
class RuoloFormazione extends Entita {

    protected static
        $_t  = 'crs_ruoli';
            
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

    public static function elencoRuoli() {
        global $db;
        $list = array();

        $query = $db->prepare("SELECT id FROM ".static::$_t);
        $query->execute();
        while ($row = $query->fetch(PDO::FETCH_NUM)) {
            array_push($list, new RuoloFormazione($row[0]));
        }
        return $list;
    }
    
}