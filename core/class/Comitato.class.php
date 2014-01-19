<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Comitato extends GeoPolitica {
        
    protected static
        $_t  = 'comitati',
        $_dt = 'datiComitati';

    public static 
        $_ESTENSIONE = EST_UNITA;

    /**
     * Sovrascrive metodo __get se unita' principale
     * ref. https://github.com/CroceRossaCatania/gaia/issues/360
     */ 
    public function __get ($_nome) {
        $nonSovrascrivere = ['id', 'nome', 'principale', 'locale'];
        if ( parent::__get('principale') && !in_array($_nome, $nonSovrascrivere) ) {
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

    public function membriGiovani() {
        $t = time()-GIOVANI;
        $v = $this->membriAttuali();
        $r = [];
        foreach ($v as $_v) {
            if ($t <= $_v->dataNascita)
                $r[] = $_v;
        }
        return $r;
    }
    
    public function membriRiserva() {
        $q = $this->db->prepare("
            SELECT DISTINCT
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
    
    /*
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
    
    public function riserve($stato = null) {
        $stato = (int) $stato;
        $q = "
            SELECT
                riserve.id
            FROM
                riserve, appartenenza
            WHERE
                riserve.volontario = appartenenza.volontario
            AND
                appartenenza.stato = :stato
            AND
                appartenenza.comitato = :id";
        if ( $stato ) {
            $q .= " AND riserve.stato = $stato";
        }
        $q .= " ORDER BY riserve.timestamp DESC";
        $q = $this->db->prepare($q);
        $q->bindParam(':id', $this->id);
        $q->bindValue('stato', MEMBRO_VOLONTARIO);
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
    
    public function aree( $obiettivo = null ) {
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
    
    
    
    public function gruppi() {
        $g = Gruppo::filtra([
            ['comitato',    $this->oid()]
        ], 'nome ASC');
        $c = $this->locale();
        $g = array_merge($g, Gruppo::filtra([['comitato', $c->oid()],['estensione', EST_GRP_LOCALE]]));
        $locali = $c->figli();

        /*
         * La parte qua sotto vuol dire che noi facciamo dei gruppo di attività di unità
         * aperte al comitato..... Ora..... perchè non facciamo attività aperte al comitato?
         */
        
        foreach ($locali as $loc){
            $loc = $loc->oid();
            $g = array_merge($g, Gruppo::filtra([['comitato', $loc],['estensione', EST_GRP_LOCALE]]));
        }
        return array_unique($g);
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
        $q = $this->db->prepare("
            SELECT  anagrafica.id
            FROM    appartenenza, anagrafica, quote
            WHERE
              appartenenza.comitato     = :comitato
            AND
                ( appartenenza.fine < 1
                 OR
                appartenenza.fine > :ora 
                OR
                appartenenza.fine IS NULL)
            AND
                anagrafica.id = appartenenza.volontario
            AND
                appartenenza.stato = :stato
            AND
                quote.appartenenza = appartenenza.id
            AND
                quote.anno = :anno
            AND
                quote.pAnnullata IS NULL
            ORDER BY
              anagrafica.cognome     ASC,
              anagrafica.nome  ASC");
        $q->bindParam(':comitato',  $this->id);
        $q->bindValue(':stato',  $stato);
        $q->bindParam(':ora',  time());
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
                ( appartenenza.id NOT IN 
                    ( SELECT 
                            appartenenza 
                        FROM 
                            quote 
                        WHERE 
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
        global $db;
        $q = $db->prepare("
            SELECT
                turni.id
            FROM
                attivita, turni
            WHERE
                attivita.stato = :stato
            AND
                attivita.comitato = :comitato
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
     * Partita iva del locale di riferimento
     * @return string   Partita iva
     */
    public function piva() {
        return $this->superiore()->piva();
    }

    /**
     * Codice fiscale del locale di riferimento
     * @return string   CF
     */
    public function cf() {
        return $this->superiore()->cf();
    }

    /**
     * Ritorna lo stato del comitato
     * @return bool  True se privato
     */
    public function privato() {
        return $this->superiore()->privato();
    }

}
