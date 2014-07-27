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

    /*
     * Membri in estensione
     * @return estensioni dal comitato $this
     */
    // solito problema
    public function membriInEstensione() {
        $q = $this->db->prepare("
            SELECT 
                estensioni.id
            FROM
                anagrafica, estensioni
            WHERE
                estensioni.cProvenienza = :comitato
            AND
                estensioni.volontario = anagrafica.id
            AND
                estensioni.stato >= :stato
            ORDER BY
                anagrafica.cognome ASC,
                anagrafica.nome ASC");
        $q->bindValue(':stato', EST_OK);
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Estensione::id($k[0]);
        }
        return $r;
    }

    /*
     * Volontari che alla data $elezioni hanno certa $anzianita
     */
    // idem
    public function elettoriAttivi(DateTime $elezioni, $anzianita = ANZIANITA) {
        $q = $this->db->prepare("
            SELECT  DISTINCT( anagrafica.id )
            FROM    appartenenza, anagrafica
            WHERE   
              appartenenza.comitato     = :comitato
            AND
              appartenenza.stato        = :stato
            AND
              appartenenza.volontario   = anagrafica.id 
            AND
              ( inizio <= :minimo )
            AND
              appartenenza.volontario IN (
                SELECT volontario FROM appartenenza
                WHERE comitato = :comitato AND
                stato = :stato AND
                fine = 0 OR fine > :elezioni
              )
            ORDER BY
              anagrafica.cognome     ASC,
              anagrafica.nome        ASC");
        $minimo = clone $elezioni;
        $anzianita = (int) $anzianita;
        $minimo->modify("-{$anzianita} years");
        $q->bindValue(':comitato',  $this->vecchio_id);
        $q->bindValue(':stato',  MEMBRO_VOLONTARIO);
        $q->bindParam(':elezioni',  $elezioni->getTimestamp(), PDO::PARAM_INT);
        $q->bindParam(':minimo',    $minimo->getTimestamp(), PDO::PARAM_INT);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }   

    /*
     * Volontari del comitato che alla data $elezioni
     * hanno certa anzianità e 18 anni.
     */

    // idem
    public function elettoriPassivi(DateTime $elezioni, $anzianita = ANZIANITA) {
        $elettori   = $this->elettoriAttivi($elezioni, $anzianita);
        $eta        = clone $elezioni;
        $eta->modify("-18 years");
        $eta        = $eta->getTimestamp();
        $r = [];
        foreach ( $elettori as $elettore ) {
            if ( $elettore->dataNascita > $eta ) { continue; }
            $r[] = $elettore;
        }
        return $r;
    }

    /*
     * Membri dimessi
     * @return dimissioni dal comitato $this
     */
    // idem
    public function membriDimessi() {
        $q = $this->db->prepare("
            SELECT
                anagrafica.id
            FROM
                appartenenza, anagrafica
            WHERE
                anagrafica.id = appartenenza.volontario
            AND
                comitato = :comitato
            AND
                appartenenza.stato = :stato
            ORDER BY
                cognome ASC, nome ASC");
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->bindValue(':stato', MEMBRO_DIMESSO);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }

    /*
     * Membri trasferiti
     * @return trasferiti dal comitato $this
     */
    // idem
    public function membriTrasferiti() {
        $q = $this->db->prepare("
            SELECT 
                trasferimenti.id
            FROM
                anagrafica, trasferimenti
            WHERE
                trasferimenti.cProvenienza = :comitato
            AND
                trasferimenti.volontario = anagrafica.id
            AND
                trasferimenti.stato >= :stato
            ORDER BY
                anagrafica.cognome ASC,
                anagrafica.nome ASC");
        $q->bindValue(':stato', TRASF_OK);
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Trasferimento::id($k[0]);
        }
        return $r;
    }

    /*
     * Membri ordinari
     * @return ordinari del comitato $this
     */
    // idem
    public function membriOrdinari() {
        $q = $this->db->prepare("
            SELECT
                anagrafica.id
            FROM
                appartenenza, anagrafica
            WHERE
                anagrafica.id = appartenenza.volontario
            AND
                comitato = :comitato
            AND
                appartenenza.stato = :stato
            ORDER BY
                cognome ASC, nome ASC");
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->bindValue(':stato', MEMBRO_ORDINARIO);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }

    /*
     * Membri ordinari dimessi
     * @return ordinari dimessi del comitato $this
     */
    // idem
    public function membriOrdinariDimessi() {
        $q = $this->db->prepare("
            SELECT
                anagrafica.id
            FROM
                appartenenza, anagrafica
            WHERE
                anagrafica.id = appartenenza.volontario
            AND
                comitato = :comitato
            AND
                appartenenza.stato = :stato
            ORDER BY
                cognome ASC, nome ASC");
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->bindValue(':stato', MEMBRO_ORDINARIO_DIMESSO);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }

    /*
     * Numero membri ordinari dimessi
     * @return int numero ordinari dimessi del comitato $this
     */
    // idem
    public function numMembriOrdinariDimessi() {
        $q = $this->db->prepare("
            SELECT
                COUNT(volontario)
            FROM
                appartenenza
            WHERE
                ( fine >= :ora OR fine IS NULL OR fine = 0) 
            AND
                comitato = :comitato
            AND
                stato    = :stato
            ORDER BY
                inizio ASC");
        $q->bindValue(':ora', time());
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->bindValue(':stato',    MEMBRO_ORDINARIO_DIMESSO);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        return (int) $r[0];
    }

    /*
     * Numero membri ordinari
     * @return int numero dimessi del comitato $this
     */
    // idem
    public function numMembriOrdinari() {
        $q = $this->db->prepare("
            SELECT
                COUNT(volontario)
            FROM
                appartenenza
            WHERE
                ( fine >= :ora OR fine IS NULL OR fine = 0) 
            AND
                comitato = :comitato
            AND
                stato    = :stato
            ORDER BY
                inizio ASC");
        $q->bindValue(':ora', time());
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->bindValue(':stato',    MEMBRO_ORDINARIO);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        return (int) $r[0];
    }

    /*
     * Numero membri attuali
     * @return int numero attuali del comitato $this
     */
    // idem
    public function numMembriAttuali($stato = MEMBRO_ESTESO) {
        $q = $this->db->prepare("
            SELECT
                COUNT(volontario)
            FROM
                appartenenza
            WHERE
                ( fine >= :ora OR fine IS NULL OR fine = 0) 
            AND
                comitato = :comitato
            AND
                stato    >= :stato
            ORDER BY
                inizio ASC");
        $q->bindValue(':ora', time());
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->bindParam(':stato',    $stato);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        return (int) $r[0];
    }

}
