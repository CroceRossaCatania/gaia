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

    public function superiore($estensione = null) {
        if (!$estensione && $this->superiore) {
            return ComitatoNuovo::id($this->superiore);
        }
        if ($estensione && $estensione > $this->estensione && $this->superiore) {
             return $this->superiore()->superiore($estensione);
        }
        if ($estensione && $estensione == $this->estensione) {
            return $this;
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
        global $conf;
        $oid = $conf['oid'][$this->estensione];
        return "{$oid}:{$this->vecchio_id}";
    }

    public function nomeCompleto() {
        if($this->estensione == EST_UNITA)
            return $this->superiore()->nome . ': ' . $this->nome;
        return $this->nome;
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

    /*
     * Appartenenze pendenti
     * @return appartenenze pendenti del comitato $this
     */
    // idem
    public function appartenenzePendenti() {
        $q = $this->db->prepare("
            SELECT
                id
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
        $q->bindValue(':stato',  MEMBRO_PENDENTE);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Appartenenza::id($k[0]);
        }
        return $r;
    }

    /*
     * Titoli pendenti del comitato in oggetto
     * @return array tit pendenti per dato comitato
     */
    public function titoliPendenti() {
        $q = $this->db->prepare("
            SELECT 
                titoliPersonali.id
            FROM
                titoliPersonali, appartenenza
            WHERE
                titoliPersonali.volontario = appartenenza.volontario
            AND
                titoliPersonali.pConferma IS NULL
            AND
                appartenenza.comitato = :comitato
            AND
                (appartenenza.fine >= :ora
                 OR appartenenza.fine is NULL
                 OR appartenenza.fine = 0)");
        $q->bindValue(':ora', time());
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = TitoloPersonale::id($k[0]);
        }
        return $r;
    }
    
    /*
     * Trasferimenti del comitato in oggetto
     * @return array trasferimenti per dato comitato
     */
    public function trasferimenti($stato = null) {
        $stato = (int) $stato;
        $q = "
            SELECT
                trasferimenti.id
            FROM
                trasferimenti, appartenenza
            WHERE
                trasferimenti.appartenenza = appartenenza.id
            AND
                appartenenza.comitato = :id";
        if ( $stato ) {
            $q .= " AND trasferimenti.stato = $stato";
        }
        $q .= " ORDER BY trasferimenti.timestamp DESC";
        $q = $this->db->prepare($q);
        $q->bindParam(':id', $this->vecchio_id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Trasferimento::id($k[0]);
        }
        return $r;
    }
    
    /*
     * Riserve del comitato in oggetto
     * @return array riserve per dato comitato
     */
    public function riserve($stato = null) {
        $pStato = ' ';
        if ($stato) {
            $pStato = " AND riserve.stato = {$stato} ";
        }
        $q = "
            SELECT
                riserve.id
            FROM
                riserve, appartenenza
            WHERE
                riserve.volontario = appartenenza.volontario
            {$pStato}
            AND
                appartenenza.stato = :stato
            AND
                appartenenza.comitato = :id
            ORDER BY 
                riserve.timestamp DESC";
        $q = $this->db->prepare($q);
        $q->bindParam(':id', $this->vecchio_id);
        $q->bindValue(':stato', MEMBRO_VOLONTARIO);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Riserva::id($k[0]);
        }
        return $r;
    }

    public function locale() {
        if($this->estensione > EST_LOCALE) {
            return null;
        }
        return $this->superiore(EST_LOCALE);
    }
    
    public function provinciale() {
        if($this->estensione > EST_PROVINCIALE) {
            return null;
        }
        return $this->superiore(EST_PROVINCIALE);
    }
    
    public function regionale() {
        if($this->estensione > EST_REGIONALE) {
            return null;
        }
        return $this->superiore(EST_REGIONALE);
    }
    
    public function nazionale() {
        return $this->superiore(EST_NAZIONALE);
    }

    // lavora coi vecchi oid che vanno sistemati...
    public function aree( $obiettivo = null, $espandiLocali = false ) {
        if ( $obiettivo ) {
            $obiettivo = (int) $obiettivo;
            return Area::filtra([
                ['comitato',    $this->oid()],
                ['obiettivo',   $obiettivo]
            ], 'obiettivo ASC'); 
        } else {
            return Area::filtra([
                ['comitato',    $this->oid()]
            ], 'obiettivo ASC');
        }
    }

    /**
     * Elenco delle unità territoriali
     * @return array Comitati con estensione = EST_UNITA
     */
    public static function unita() {
        return ComitatoNuovo::filtra([
            ['estensione', EST_UNITA]
            ]);
    }

    /**
     * Elenco dei locali
     * @return array Comitati con estensione = EST_LOCALE
     */
    public static function locali() {
        return ComitatoNuovo::filtra([
            ['estensione', EST_LOCALE]
            ]);
    }

    /**
     * Elenco dei provinciali
     * @return array Comitati con estensione = EST_PROVINCIALE
     */
    public static function provinciali() {
        return ComitatoNuovo::filtra([
            ['estensione', EST_PROVINCIALE]
            ]);
    }

    /**
     * Elenco dei regionali
     * @return array Comitati con estensione = EST_REGIONALE
     */
    public static function regionali() {
        return ComitatoNuovo::filtra([
            ['estensione', EST_REGIONALE]
            ]);
    }

    /**
     * Elenco dei nazionali
     * @return array Comitati con estensione = EST_NAZIONALE
     */
    public static function nazionali() {
        return ComitatoNuovo::filtra([
            ['estensione', EST_NAZIONALE]
            ]);
    }
    
    // dovrebbe funzionare (ritorna 0 sui livelli superiori al comitato nel count)
    public function toJSON() {
        return [
            'id'            =>  $this->id,
            'nome'          =>  $this->nome,
            'indirizzo'     =>  $this->formattato,
            'coordinate'    =>  $this->coordinate(),
            'telefono'      =>  $this->telefono,
            'email'         =>  $this->email,
            'volontari'     =>  count($this->membriAttuali()),
            'oid'           =>  $this->oid()
        ];
    }

    public function toJSONRicerca() {
        return [
            'id'            =>  $this->id,
            'nome'          =>  $this->nome,
            'nomeCompleto'  =>  $this->nomeCompleto()
        ];
    }
    
    /*
     * Reperibili del comitato in oggetto
     * @return array reperibili per dato comitato
     */
    public function reperibili() {
        $q = "
            SELECT
                reperibilita.id
            FROM
                reperibilita
            WHERE
                reperibilita.comitato = :id";
        $q .= " ORDER BY reperibilita.inizio ASC";
        $q = $this->db->prepare($q);
        $q->bindParam(':id', $this->vecchio_id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Reperibilita::id($k[0]);
        }
        return $r;
    }
    
    /*
     * Estensione di un comitato usando l'albertatore lr
     * @return array comitati sottostanti
     */
    public function estensione() {
        $q = "
            SELECT
                comitatiNuovi.id
            FROM
                comitatiNuovi
            WHERE
                comitatiNuovi.lft > :lft
            AND
                comitatiNuovi.rgt < :rgt
            ORDER BY 
                comitatiNuovi.lft ASC";
        $q = $this->db->prepare($q);
        $q->bindParam(':lft', $this->lft);
        $q->bindParam(':rgt', $this->rgt);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = ComitatoNuovo::id($k[0]);
        }
        return $r;
    }

    // questa fa cagare... va sistemata agressivamente
    public function quoteSi($anno , $stato=MEMBRO_VOLONTARIO) {
        $statiPossibili = [MEMBRO_VOLONTARIO, MEMBRO_DIMESSO, MEMBRO_TRASFERITO]; 
        if($stato == MEMBRO_ORDINARIO) {
            $statiPossibili = [MEMBRO_ORDINARIO, MEMBRO_ORDINARIO_DIMESSO];
        }
        $stati = implode(',', $statiPossibili);
        $q = $this->db->prepare("
            SELECT  
                anagrafica.id
            FROM    
                appartenenza, anagrafica
            WHERE
                appartenenza.comitato = :comitato
            AND
                anagrafica.id = appartenenza.volontario
            AND
                appartenenza.stato IN ( ". $stati ." )
            AND
                ( anagrafica.id IN 
                    ( SELECT
                            appartenenza.volontario
                        FROM
                            quote, appartenenza
                        WHERE
                            quote.appartenenza = appartenenza.id
                        AND
                            quote.anno = :anno
                        AND 
                            quote.pAnnullata IS NULL
                    )
                )
            ORDER BY
              anagrafica.cognome     ASC,
              anagrafica.nome  ASC");
        $q->bindParam(':comitato',  $this->vecchio_id);
        $q->bindValue(':anno',    $anno);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }
    

    // idem
    public function quoteNo($anno , $stato=MEMBRO_VOLONTARIO) {
        $q = $this->db->prepare("
            SELECT 
                anagrafica.id 
            FROM    
                anagrafica, appartenenza 
            WHERE         
                anagrafica.id = appartenenza.volontario 
            AND
                appartenenza.comitato = :comitato
            AND
                appartenenza.stato = :stato
            AND 
                ( appartenenza.fine < 1 OR appartenenza.fine > :ora OR appartenenza.fine IS NULL)
            AND 
                ( anagrafica.id NOT IN 
                    ( SELECT 
                            appartenenza.volontario 
                        FROM 
                            quote, appartenenza
                        WHERE
                            quote.appartenenza = appartenenza.id 
                        AND
                            anno = :anno
                        AND
                            pAnnullata IS NULL
                    )
                ) 
                
            ORDER BY
                anagrafica.cognome     ASC,
                anagrafica.nome  ASC");
        $q->bindParam(':comitato',  $this->vecchio_id);
        $q->bindParam(':ora',  time());
        $q->bindParam(':anno', $anno);
        $q->bindParam(':stato', $stato);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }
    
    /*
     * @param $titoli Array di elementi Titolo
     */
    public function ricercaMembriTitoli( $titoli = [], $stato = MEMBRO_ESTESO ) {
        $daFiltrare = $this->membriAttuali($stato);
        foreach ( $titoli as $titolo ) {
            $filtrato = [];
            foreach ( $daFiltrare as $volontario ) {
                if ( $t = TitoloPersonale::filtra([
                    ['titolo',      $titolo->id],
                    ['volontario',  $volontario]
                ])){
                    if(
                        $t[0]->confermato()){
                            $filtrato[] = $volontario;
                            }
                }
            }
            $daFiltrare = $filtrato;
        }
        return $daFiltrare;
    }
    
    // non ho capito questa funzione dentro a comitato???
    public function ricercaPatente($ricerca) {
        $q = $this->db->prepare("
            SELECT DISTINCT (anagrafica.id)
            FROM 
                titoli, titoliPersonali, anagrafica, appartenenza
            WHERE 
                anagrafica.id = titoliPersonali.volontario
            AND 
                titoli.id = titoliPersonali.titolo
            AND 
                titoli.nome LIKE :ricerca
            ORDER BY 
                anagrafica.cognome, 
                anagrafica.nome");
        $q->bindValue ( ":ricerca", $ricerca );
        $q->execute();
        var_dump($q->errorInfo());
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }   
    
    //idem
    public function pratichePatenti() {
        $q = $this->db->prepare("
            SELECT
                patentiRichieste.id
            FROM
                appartenenza, anagrafica, patentiRichieste
            WHERE
                patentiRichieste.appartenenza = appartenenza.id
            AND
                anagrafica.id = appartenenza.volontario
            AND
                appartenenza.comitato = :comitato
            ORDER BY
                 cognome ASC, nome ASC");
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = PatentiRichieste::id($k[0]);
        }
        return $r;
    }

    /*
     * manca il fetch del sesso della persona
     */ 
    public function etaSessoComitato() {
        $q = $this->db->prepare("
            SELECT 
                dettagliPersona.valore, anagrafica.codiceFiscale
            FROM  
                dettagliPersona, anagrafica, appartenenza
            WHERE 
                dettagliPersona.id = anagrafica.id
            AND 
                anagrafica.id = appartenenza.volontario
            AND 
                dettagliPersona.nome = 'dataNascita'
            AND
                appartenenza.comitato = :comitato");
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->execute();
        
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $sesso = Utente::sesso($k[1]);
            $r[] = ['data'=>$k[0],'sesso'=>$sesso];
        }

        return $r;
        
    }

    public function anzianitaMembri($stato = MEMBRO_VOLONTARIO) {
        $q = $this->db->prepare("
            SELECT 
                appartenenza.inizio, anagrafica.codiceFiscale
            FROM  
                anagrafica, appartenenza
            WHERE 
                anagrafica.id = appartenenza.volontario
            AND
                appartenenza.comitato = :comitato
            AND
                appartenenza.stato = :stato");
        $q->bindParam(':comitato', $this->vecchio_id);
        $q->bindParam(':stato', $stato);
        $q->execute();
        
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $sesso = Utente::sesso($k[1]);
            $r[] = ['ingresso'=>$k[0],'sesso'=>$sesso];
        }

        return $r;
    }
    

    public function informazioniVolontariJSON() {
        $datesesso = $this->etaSessoComitato();
        $anzianita = $this->anzianitaMembri();

        $r = [  'datesesso'=>$datesesso,
                'anzianita'=>$anzianita];
        return json_encode($r);
    }

    public function reperibilitaReport(DateTime $inizio, DateTime $fine) {
        $q = $this->db->prepare("
            SELECT  id
            FROM    reperibilita
            WHERE   
              comitato     = :comitato
            AND
              ( inizio >= :minimo )
            AND
              ( fine <= :massimo )");
        $q->bindValue(':comitato',  $this->vecchio_id);
        $q->bindValue(':minimo',    $inizio->getTimestamp());
        $q->bindValue(':massimo',    $fine->getTimestamp());
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Reperibilita::id($k[0]);
        }
        return $r;
    }

    public static function comitatiNull() {
        global $db;
        $q = $db->prepare("
            SELECT 
                id 
            FROM
                comitatiNuovi
            WHERE 
                nome IS NULL
            ");
        $r = $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = $k[0];
        }
        return $r;
    }
     
    public function coTurni() {
        global $db;
        $q = $db->prepare("
            SELECT
                turni.id
            FROM
                attivita, turni
            WHERE
                attivita.comitato = :comitato
            AND
                attivita.stato = :stato
            AND
                turni.attivita = attivita.id
            AND
                turni.inizio <= :inizio
            ORDER BY
                turni.inizio ASC");
        $inizio = time()+3600;
        $q->bindValue(':inizio', $inizio);
        $q->bindValue(':stato', ATT_STATO_OK);
        $q->bindParam(':comitato', $this->oid());
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Turno::id($k[0]);
        }
            return $r;
    }

    /**
     * Partita iva del comitato di riferimento
     * @return string   Partita iva
     */
    public function piva($inTesto = false) {
        if ($this->estensione === 0) {
            return $this->superiore()->piva($inTesto);
        }
        $piva = $this->piva;
        if ($this->estensione > EST_PROVINCIALE) {
            $piva = PIVA;
        }
        if ($this->nome == "Comitato Provinciale di Trento"
            or $this->nome == "Comitato Provinciale di Bolzano")
            $piva = PIVA;
        if ($inTesto && $piva) {
            return "P.IVA: {$piva}";
        }
        return $piva;

    }

    /**
     * Codice fiscale del locale di riferimento
     * @return string   CF
     */
    public function cf($inTesto = false) {
        if ($this->estensione === 0) {
            return $this->superiore()->cf($inTesto);
        }
        $cf = $this->cf;
        if ($this->estensione > EST_PROVINCIALE) {
            $cf = CF;
        }
        if ($this->nome == "Comitato Provinciale di Trento"
            or $this->nome == "Comitato Provinciale di Bolzano")
            $cf = CF;
        if ($inTesto && $cf) {
            return "P.IVA: {$cf}";
        }
        return $cf;
    }

    /**
     * Ritorna lo stato del comitato
     * @return bool  True se privato
     */
    public function privato() {
        if ($this->estensione === 0) {
            $this->superiore()->privato();
        }
        $privato = true;
        if ($this->estensione > EST_PROVINCIALE) {
            $privato = false;
        }
        if ($this->nome == "Comitato Provinciale di Trento"
            or $this->nome == "Comitato Provinciale di Bolzano")
            $privato = true;
        return $privato;
    }

    /**
     * Infermiere Volontarie in comitato
     * @return array   Anagrafica id IV
     */
    public function membriIv() {
        $v = $this->membriAttuali();
        $r = [];
        foreach ($v as $_v) {
            if ($_v->iv())
                $r[] = $_v;
        }
        return $r;
    }

    /**
     * Corpo Militare in comitato
     * @return array   Anagrafica id CM
     */
    public function membriCm() {
        $v = $this->membriAttuali();
        $r = [];
        foreach ($v as $_v) {
            if ($_v->cm())
                $r[] = $_v;
        }
        return $r;
    }

}
