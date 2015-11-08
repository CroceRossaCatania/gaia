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
    
    public function filtraPerTipoComitato($permessi) {
        global $db;
        $lista = [];
        $permesso = "";

        foreach ($permessi as $nome => $value) {
            if ($value > 0) {
                $permesso = $nome;
            }
        }

        $q = $db->query("SELECT id FROM " . static::$_t . " WHERE abilita" . ucfirst($permesso) . " = 1");
        while ($row = $q->fetch(PDO::FETCH_NUM)) {
            $lista[] = TipoCorso::id($row[0]);
        }
        
        return $lista;
    }

    public static function limiteMinimoPerIscrizione() {
        global $db;

        $q = $db->query("SELECT MIN(limitePerIscrizione) FROM ". static::$_t." WHERE limitePerIscrizione IS NOT NULL");
        $row = $q->fetch();
        return max(GIORNI_CORSO_ISCRIZIONI_CHIUSE+1, intval($row[0])+1);
    }
    
}