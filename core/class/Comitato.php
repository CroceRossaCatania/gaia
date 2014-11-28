<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Comitato extends GeoPolitica {
        
    protected static
        $_t  = 'comitati',
        $_dt = 'datiComitati';

    use EntitaCache;

    public static 
        $_ESTENSIONE = EST_UNITA;

    /**
     * Sovrascrive metodo __get se unita' principale
     * ref. https://github.com/CroceRossaCatania/gaia/issues/360
     */ 
    public function __get ($_nome) {
        $nonSovrascrivere = ['id', 'nome', 'principale', 'locale'];
        if ( parent::__get('principale') && !contiene($_nome, $nonSovrascrivere) ) {
            return $this->locale()->{$_nome};
        }
        return parent::__get($_nome);
    }

    public function superiore() {
        return $this->locale();
    }

    public function figli() {
        return [];
    }
    
    public function colore() { 
    	$c = $this->colore;
    	if (!$c) {
            $this->generaColore();
            return $this->colore();
    	}
    	return $c;
    }

    public function unPresidente() {
        return $this->locale()->unPresidente();
    }

    private function generaColore() { 
    	$r = 100 + rand(0, 155);
    	$g = 100 + rand(0, 155);
    	$b = 100 + rand(0, 155);
    	$r = dechex($r);
    	$g = dechex($g);
    	$b = dechex($b);
    	$this->colore = $r . $g . $b;
    }
    
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
        $q->bindParam(':comitato', $this->id);
        $q->bindParam(':stato',    $stato, PDO::PARAM_INT);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }

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
        $q->bindParam(':comitato', $this->id);
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
        $q->bindParam(':comitato', $this->id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }
    
    /**
     * Membri in estensione
     * @return estensioni dal comitato $this
     */
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
        $q->bindParam(':comitato', $this->id);
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
        $q->bindValue(':comitato',  $this->id);
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
        $q->bindParam(':comitato', $this->id);
        $q->bindValue(':stato', MEMBRO_DIMESSO);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }
    
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
        $q->bindParam(':comitato', $this->id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Trasferimento::id($k[0]);
        }
        return $r;
    }

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
        $q->bindParam(':comitato', $this->id);
        $q->bindValue(':stato', MEMBRO_ORDINARIO);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }

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
        $q->bindParam(':comitato', $this->id);
        $q->bindValue(':stato', MEMBRO_ORDINARIO_DIMESSO);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }

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
        $q->bindParam(':comitato', $this->id);
        $q->bindValue(':stato',    MEMBRO_ORDINARIO_DIMESSO);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        return (int) $r[0];
    }

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
        $q->bindParam(':comitato', $this->id);
        $q->bindValue(':stato',    MEMBRO_ORDINARIO);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        return (int) $r[0];
    }

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
        $q->bindParam(':comitato', $this->id);
        $q->bindParam(':stato',    $stato);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        return (int) $r[0];
    }

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
        $q->bindParam(':comitato', $this->id);
        $q->bindValue(':stato',  MEMBRO_PENDENTE);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Appartenenza::id($k[0]);
        }
        return $r;
    }
    
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
        $q->bindParam(':comitato', $this->id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = TitoloPersonale::id($k[0]);
        }
        return $r;
    }
    
    
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
        $q->bindParam(':id', $this->id);
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
        $q->bindParam(':id', $this->id);
        $q->bindValue(':stato', MEMBRO_VOLONTARIO);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Riserva::id($k[0]);
        }
        return $r;
    }
    
    public function locale() {
        return Locale::id($this->locale);
    }
    
    public function provinciale() {
        return $this->locale()->provinciale();
    }
    
    public function regionale() {
        return $this->provinciale()->regionale();
    }
    
    public function nazionale() {
        return $this->regionale()->nazionale();
    }
    
    public function nomeCompleto() {
        return $this->locale()->nome . ': ' . $this->nome;
    }
    
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
    
    public function toJSON() {
        return [
            'id'            =>  $this->id,
            'nome'          =>  $this->nome,
            'indirizzo'     =>  $this->formattato,
            'coordinate'    =>  $this->coordinate(),
            'telefono'      =>  $this->telefono,
            'email'         =>  $this->email,
            'volontari'     =>  count($this->membriAttuali())
        ];
    }

    public function toJSONRicerca() {
        return [
            'id'            =>  $this->id,
            'nome'          =>  $this->nome,
            'nomeCompleto'  =>  $this->nomeCompleto()
        ];
    }
    
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
        $q->bindParam(':id', $this->id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Reperibilita::id($k[0]);
        }
        return $r;
    }
    
    public function estensione() {
        return [$this];
    }
    
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
        $q->bindParam(':comitato',  $this->id);
        $q->bindValue(':anno',    $anno);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }
    
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
        $q->bindParam(':comitato',  $this->id);
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
    
    /**
     * Restituisce elenco volontari in possesso di un dato titolo
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
        $q->bindParam(':comitato', $this->id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = PatentiRichieste::id($k[0]);
        }
        return $r;
    }

    /*
    manca il fetch del sesso della persona
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
        $q->bindParam(':comitato', $this->id);
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
        $q->bindParam(':comitato', $this->id);
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
        $q->bindValue(':comitato',  $this->id);
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
                comitati
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
        $attivita = Attivita::filtra([['comitato', $this->oid()],['stato', ATT_STATO_OK]]);
        $turni = [];
        $inizio = time()+3600;
        foreach ( $attivita as $att ){
            $turni = array_merge($turni, Turno::filtra([['attivita', $att],['inizio',$inizio,OP_LTE]]));
        }
        $turni = array_unique($turni);
        return $turni;
    }

    /**
     * Partita iva del locale di riferimento
     * @return string   Partita iva
     */
    public function piva($inTesto = false) {
        return $this->superiore()->piva($inTesto);
    }

    /**
     * Codice fiscale del locale di riferimento
     * @return string   CF
     */
    public function cf($inTesto = false) {
        return $this->superiore()->cf($inTesto);
    }

    /**
     * Ritorna lo stato del comitato
     * @return bool  True se privato
     */
    public function privato() {
        return $this->superiore()->privato();
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

    /**
     * Se l'unità è principale utilizza i dati del livello superiore
     * altrimenti usa la funzione standard
     */
    public function haPosizione() {
        if ($this->principale) {
            return $this->superiore()->haPosizione();
        }
        return parent::haPosizione();
    }

    /**
     * Se l'unità è principale utilizza i dati del livello superiore
     * altrimenti usa la funzione standard
     */
    public function linkMappa() {
        if ($this->principale) {
            return $this->superiore()->linkMappa();
        }
        return parent::linkMappa();
    }

    /**
     * Se l'unità è principale utilizza i dati del livello superiore
     * altrimenti usa la funzione standard
     */
    public function coordinate() {
        if ($this->principale) {
            return $this->superiore()->coordinate();
        }
        return parent::coordinate();
    }
    
    /**
     * Se l'unità è principale utilizza i dati del livello superiore
     * altrimenti usa la funzione standard
     */
    public function latlng() {
        if ($this->principale) {
            return $this->superiore()->latlng();
        }
        return parent::latlng();
    }
    
    /**
     * Se l'unità è principale utilizza i dati del livello superiore
     * altrimenti usa la funzione standard
     */
    public function localizzaCoordinate($x, $y) {
        if ($this->principale) {
            return $this->superiore()->localizzaCoordinate($x, $y);
        }
        return parent::localizzaCoordinate($x, $y);
    }
    
    /**
     * Se l'unità è principale utilizza i dati del livello superiore
     * altrimenti usa la funzione standard
     */
    public function localizzaStringa($stringa) {
        if ($this->principale) {
            return $this->superiore()->localizzaStringa($stringa);
        }
        return parent::localizzaStringa($stringa);
    }

    /**
     * Elenco di titoli personali in scadenza entro 30gg
     * @return TitoliPersonali
     */
    public function titoliScadenza($area) {
        $q = $this->db->prepare("
            SELECT 
                titoliPersonali.id
            FROM
                titoliPersonali, appartenenza, titoli
            WHERE
                titoliPersonali.volontario = appartenenza.volontario
            AND
                titoliPersonali.pConferma IS NULL
            AND
                appartenenza.comitato = :comitato
            AND
                (appartenenza.fine >= :ora
                 OR appartenenza.fine is NULL
                 OR appartenenza.fine = 0)
            AND
                titoliPersonali.fine > :ora 
            AND
                titoliPersonali.fine < :trenta 
            AND 
                titoliPersonali.titolo = titoli.id
            AND
                titoli.area = :area ");
        $q->bindValue(':ora', time());
        $trenta = time()+(GIORNO*30);
        $q->bindValue(':trenta', $trenta);
        $q->bindParam(':comitato', $this->id);
        $q->bindParam(':area', $area);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = TitoloPersonale::id($k[0]);
        }
        return $r;
    }
}
