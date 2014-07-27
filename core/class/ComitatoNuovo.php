<?php

/*
 * ©2014 Croce Rossa Italiana
 */


/*
 * 1) spostare i comitati e i loro dati dentro alla ComitatoNuovo
 * 2) nel caso rinominare il comitatoNuovo in comitato
 * 3) modificare i riferimenti nelle altre tabelle aggiornando gli id
 *    basandosi su vecchio_id 
 * Tabelle con roba dei comitati dentro che va modificata
 * appartenenza
 * delegato
 * attivita
 * aree
 * corsibase
 * dimissioni (?)
 * estensioni (cProvenienza)
 * gruppi
 * gruppiPersonali
 * reperibilità
 * trasferimenti (cProvenienza)
 * 
 * 4) verificare che tutto funzioni
 * 5) ricostruire i selettori dei comitati che non funzioneranno più
 */


class ComitatoNuovo extends GeoPolitica {
        
    protected static
        $_t  = 'comitatiNuovi',
        $_dt = 'datiComitatiNuovi';

    /**
     * Sovrascrive metodo __get se unita' principale
     * ref. https://github.com/CroceRossaCatania/gaia/issues/360
     */ 
    public function __get ($_attributo) {
        $nonSovrascrivere = ['id', 'nome', 'principale', 'superiore'];
        if ( parent::__get('principale') && !in_array($_attributo, $nonSovrascrivere) ) {
            return $this->superiore()->{$_attributo};
        }
        return parent::__get($_attributo);
    }

    public function superiore() {
    	if ($this->superiore) {
    		return ComitatoNuovo::id($this->superiore);
    	}
    	return null;
    }

    public function figli() {
    	$figli = ComitatoNuovo::filtra([
    		['superiore', $this->id]
    		]);
    	return $figli;
    }

    public function unPresidente() {
    	if ($this->estensione == EST_UNITA) {
    		return $this->superiore()->unPresidente();
    	}
    	parent::unPresidente();
    }

    // ritorna il vecchio oid
    public function oid() {
    	return "{$conf[$this->estensione]}:{$this->vecchio_id}";
    }

    // le appartenenze contengono il vecchio id... da aggiornare!
    public function membriAttuali($stato = MEMBRO_ESTESO) {
        $q = $this->db->prepare("
            SELECT
                anagrafica.id
            FROM
                appartenenza, anagrafica
            WHERE
                anagrafica.id = appartenenza.volontario
            AND
                ( fine >= :ora OR fine IS NULL OR fine = 0) 
            AND
                comitato = :comitato
            AND
                appartenenza.stato    >= :stato
            ORDER BY
                 cognome ASC, nome ASC");
        $q->bindValue(':ora', time());
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->bindParam(':stato',    $stato, PDO::PARAM_INT);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }

    // problema sugli id
    public function membriData($data) {
        $q = $this->db->prepare("
            SELECT
                anagrafica.id
            FROM
                appartenenza, anagrafica
            WHERE
                anagrafica.id = appartenenza.volontario
            AND
                (   appartenenza.fine >= :data OR 
                    appartenenza.fine IS NULL OR 
                    appartenenza.fine = 0) 
            AND
                appartenenza.inizio <= :data 
            AND
                appartenenza.comitato = :comitato
            AND 
                (   appartenenza.stato <= :passati OR 
                    appartenenza.stato = :ordinario OR
                    appartenenza.stato = :volontario)

            ORDER BY
                 cognome ASC, nome ASC            
        ");
        $q->bindParam(':data', $data, PDO::PARAM_INT);
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->bindValue(':passati',    MEMBRO_ORDINARIO_DIMESSO);
        $q->bindValue(':ordinario',  MEMBRO_ORDINARIO);
        $q->bindValue(':volontario', MEMBRO_VOLONTARIO);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }

    public function membriGiovani() {
        $v = $this->membriAttuali();
        $r = [];
        foreach ($v as $_v) {
            if ($_v->giovane())
                $r[] = $_v;
        }
        return $r;
    }

    public function membriRiserva() {
        $q = $this->db->prepare("
            SELECT
                riserve.volontario
            FROM
                appartenenza, riserve
            WHERE
                riserve.stato >= :statoRis
            AND
                riserve.appartenenza = appartenenza.id
            AND
                appartenenza.stato = :stato
            AND
                appartenenza.comitato = :comitato
            ORDER BY
                riserve.inizio ASC");
        $q->bindValue(':statoRis', RISERVA_OK, PDO::PARAM_INT);
        $q->bindValue(':stato', MEMBRO_VOLONTARIO);
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }

}
