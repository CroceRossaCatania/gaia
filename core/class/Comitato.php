<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Comitato extends GeoPolitica {

    protected static
            $_t = 'comitati',
            $_dt = 'datiComitati';

    use EntitaCache;

    public static
            $_ESTENSIONE = EST_UNITA;

    /**
     * Sovrascrive metodo __get se unita' principale
     * ref. https://github.com/CroceRossaCatania/gaia/issues/360
     */
    public function __get($_nome) {
        $nonSovrascrivere = ['id', 'nome', 'principale', 'locale'];
        if (parent::__get('principale') && !contiene($_nome, $nonSovrascrivere)) {
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

    public function regione() {
        
        $sql  = " SELECT UPPER(REPLACE(r.nome, 'Comitato Regionale ','')) AS regione ";
        $sql .= " FROM comitati c, locali l, provinciali p, regionali r ";
        $sql .= " WHERE c.locale = l.id AND l.provinciale = p.id AND p.regionale = r.id ";
        $sql .= " AND c.id = :id";

        $q = $this->db->prepare($sql);
        $q->bindParam(':id', $this->id, PDO::PARAM_INT);
        $q->execute();

        while ($k = $q->fetch(PDO::FETCH_NUM)) {
            return(str_replace(' ','_', trim($k[0])));
        }
        return null;
    }

    public function provincia() {
        $sql  = " SELECT UPPER(REPLACE(p.nome, 'Comitato Provinciale Di','')) as provincia ";
        $sql .= " FROM comitati c, locali l, provinciali p, regionali r ";
        $sql .= " WHERE c.locale = l.id AND l.provinciale = p.id AND p.regionale = r.id ";
        $sql .= " AND c.id = :id";

        $q = $this->db->prepare($sql);
        $q->bindParam(':id', $this->id, PDO::PARAM_INT);
        $q->execute();

        while ($k = $q->fetch(PDO::FETCH_NUM)) {
            return(str_replace(' ','_', trim($k[0])));
        }
        return null;
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
        $q->bindParam(':stato', $stato, PDO::PARAM_INT);
        $q->execute();
        $r = [];
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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
        $q->bindValue(':passati', MEMBRO_ORDINARIO_DIMESSO);
        $q->bindValue(':ordinario', MEMBRO_ORDINARIO);
        $q->bindValue(':volontario', MEMBRO_VOLONTARIO);
        $q->execute();
        $r = [];
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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
        $q->bindValue(':comitato', $this->id);
        $q->bindValue(':stato', MEMBRO_VOLONTARIO);
        $q->bindParam(':elezioni', $elezioni->getTimestamp(), PDO::PARAM_INT);
        $q->bindParam(':minimo', $minimo->getTimestamp(), PDO::PARAM_INT);
        $q->execute();
        $r = [];
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
            $r[] = Volontario::id($k[0]);
        }
        return $r;
    }

    /*
     * Volontari del comitato che alla data $elezioni
     * hanno certa anzianità e 18 anni.
     */

    public function elettoriPassivi(DateTime $elezioni, $anzianita = ANZIANITA) {
        $elettori = $this->elettoriAttivi($elezioni, $anzianita);
        $eta = clone $elezioni;
        $eta->modify("-18 years");
        $eta = $eta->getTimestamp();
        $r = [];
        foreach ($elettori as $elettore) {
            if ($elettore->dataNascita > $eta) {
                continue;
            }
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
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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
            AND
                ( appartenenza.fine >= :ora OR appartenenza.fine IS NULL OR appartenenza.fine = 0 ) 
            ORDER BY
                cognome ASC, nome ASC");
        $q->bindValue(':ora', time());
        $q->bindParam(':comitato', $this->id);
        $q->bindValue(':stato', MEMBRO_ORDINARIO);

        $q->execute();
        $r = [];
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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
        $q->bindValue(':stato', MEMBRO_ORDINARIO_DIMESSO);
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
        $q->bindValue(':stato', MEMBRO_ORDINARIO);
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
        $q->bindParam(':stato', $stato);
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
        $q->bindValue(':stato', MEMBRO_PENDENTE);
        $q->execute();
        $r = [];
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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
        if ($stato) {
            $q .= " AND trasferimenti.stato = $stato";
        }
        $q .= " ORDER BY trasferimenti.timestamp DESC";
        $q = $this->db->prepare($q);
        $q->bindParam(':id', $this->id);
        $q->execute();
        $r = [];
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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

    public function aree($obiettivo = null, $espandiLocali = false) {
        if ($obiettivo) {
            $obiettivo = (int) $obiettivo;
            return Area::filtra([
                        ['comitato', $this->oid()],
                        ['obiettivo', $obiettivo]
                            ], 'obiettivo ASC');
        } else {
            return Area::filtra([
                        ['comitato', $this->oid()]
                            ], 'obiettivo ASC');
        }
    }

    public function toJSON() {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'indirizzo' => $this->formattato,
            'coordinate' => $this->coordinate(),
            'telefono' => $this->telefono,
            'email' => $this->email,
            'volontari' => count($this->membriAttuali())
        ];
    }

    public function toJSONRicerca() {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'nomeCompleto' => $this->nomeCompleto()
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
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
            $r[] = Reperibilita::id($k[0]);
        }
        return $r;
    }

    public function estensione() {
        return [$this];
    }

    /**
     * Ottiene una quota dato un numero ed un anno, se presente.
     * @param int $numero   Numero progressivo della quota.
     * @param int $anno     Anno di registrazione della quota.
     * @return Quota|false  Un oggetto Quota o false se la quota $numero/$anno non esiste per il comitato
     */
    public function ottieniQuota($numero, $anno) {
        $q = "
                SELECT 
                    quote.id
                FROM quote, appartenenza
                WHERE quote.appartenenza = appartenenza.id
                AND appartenenza.comitato = :comitato
                AND quote.progressivo = :numero
                AND quote.anno = :anno  
            ";
        $q = $this->db->prepare($q);
        $q->bindValue(':comitato', $this->id);
        $q->bindValue(':numero', (int) $numero);
        $q->bindValue(':anno', (int) $anno);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);

        if (!$r)
            return false;

        return Quota::id($r[0]);
    }

    /**
     * Ottiene elenco dei potenziali soci del comitato in un dato anno, al solo uso di
     * successiva verifica del pagamento della quota o meno nell'anno - NESSUN altro uso!
     * @param int $anno     Opzionale. Anno di riferimento. Default anno attuale.
     * @
     * @return array(Utente)
     */
    public function potenzialiSoci($anno = false, $stato = MEMBRO_VOLONTARIO) {
        global $conf;
        $anno = $anno ? (int) $anno : (int) date('Y');
        $minimo = (DT::createFromFormat('d/m/Y H:i', "1/1/{$anno} 00:00"));
        $minimo = $minimo->getTimestamp();
        $massimo = (DT::createFromFormat('d/m/Y H:i', "31/12/{$anno} 23:59"));
        $massimo = $massimo->getTimestamp();

        if (!is_array($stato)) {
            if (array_key_exists($stato, $conf['appartenenze_posteri']))
                $stato = $conf['appartenenze_posteri'][$stato];
            else
                $stato = [$stato];
        }

        foreach ($stato as &$s)
            $s = (int) $s;

        $stato = implode(', ', $stato);

        $query = "
            SELECT  anagrafica.id
            FROM    appartenenza, anagrafica
            WHERE   appartenenza.comitato = :comitato
            AND     anagrafica.id = appartenenza.volontario 
            AND     appartenenza.stato IN ({$stato})
            AND     appartenenza.inizio <= :massimo
            AND (
                        appartenenza.fine IS NULL
                    OR  appartenenza.fine = 0
                    OR  appartenenza.fine > :minimo
            )
        ";
        $q = $this->db->prepare($query);

        $q->bindParam(':comitato', $this->id, PDO::PARAM_INT);
        $q->bindParam(':minimo', $minimo, PDO::PARAM_INT);
        $q->bindParam(':massimo', $massimo, PDO::PARAM_INT);
        $q->execute();
        $r = [];
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
            $r[] = Utente::id($k[0]);
        }
        return $r;
    }

    /**
     * Ritorna tutti i Soci Attivi (coloro che han pagato la Quota Associativa)
     * che son stati appartenenti in un dato anno a questo comitato 
     * @param int $anno     Opzionale. Anno di riferimento. Default anno attuale.
     * @return array(Utente)
     */
    public function quoteSi($anno = false, $stato = MEMBRO_VOLONTARIO) {
        $r = [];
        $soci = $this->potenzialiSoci($anno, $stato);
        foreach ($soci as $p) {
            if ($p->socioAttivo($anno))
                $r[] = $p;
        }
        return $r;
    }

    /**
     * Ritorna tutti i Soci NON Attivi (coloro che, pur passibili, non hanno pagato la Quota Associativa)
     * che son stati appartenenti in un dato anno a questo comitato 
     * @param int $anno     Opzionale. Anno di riferimento. Default anno attuale.
     * @return array(Utente)
     */
    public function quoteNo($anno = false, $stato = MEMBRO_VOLONTARIO) {
        $r = [];
        foreach ($this->potenzialiSoci($anno, $stato) as $p) {
            if ($p->socioNonAttivo($anno))
                $r[] = $p;
        }
        return $r;
    }

    /**
     * Restituisce elenco volontari in possesso di un dato titolo
     * @param $titoli Array di elementi Titolo
     */
    public function ricercaMembriTitoli($titoli = [], $stato = MEMBRO_ESTESO) {
        $daFiltrare = $this->membriAttuali($stato);
        foreach ($titoli as $titolo) {
            $filtrato = [];
            foreach ($daFiltrare as $volontario) {
                if ($t = TitoloPersonale::filtra([
                            ['titolo', $titolo->id],
                            ['volontario', $volontario]
                        ])) {
                    if (
                            $t[0]->confermato()) {
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
        $q->bindValue(":ricerca", $ricerca);
        $q->execute();
        var_dump($q->errorInfo());
        $r = [];
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
            $sesso = Utente::sesso($k[1]);
            $r[] = ['data' => $k[0], 'sesso' => $sesso];
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
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
            $sesso = Utente::sesso($k[1]);
            $r[] = ['ingresso' => $k[0], 'sesso' => $sesso];
        }

        return $r;
    }

    public function informazioniVolontariJSON() {
        $datesesso = $this->etaSessoComitato();
        $anzianita = $this->anzianitaMembri();

        $r = [ 'datesesso' => $datesesso,
            'anzianita' => $anzianita];
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
        $q->bindValue(':comitato', $this->id);
        $q->bindValue(':minimo', $inizio->getTimestamp());
        $q->bindValue(':massimo', $fine->getTimestamp());
        $q->execute();
        $r = [];
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
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
        while ($k = $q->fetch(PDO::FETCH_NUM)) {
            $r[] = $k[0];
        }
        return $r;
    }

    public function coTurni() {
        $attivita = Attivita::filtra([['comitato', $this->oid()], ['stato', ATT_STATO_OK]]);
        $turni = [];
        $inizio = time() + 3600;
        foreach ($attivita as $att) {
            $turni = array_merge($turni, Turno::filtra([['attivita', $att], ['inizio', $inizio, OP_LTE]]));
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
     * Fototessere in attesa
     * @param comitato
     * @return Utente array
     */
    public function fototesserePendenti() {
        $filtrato = [];
        foreach ($this->membriAttuali(MEMBRO_VOLONTARIO) as $u) {
            if (!$u->fototessera()) {
                continue;
            }
            if ($u->fototessera()->approvata()) {
                continue;
            }
            $filtrato[] = $u;
        }
        return $filtrato;
    }

    /**
     * Tesserini in attesa di essere riconsegnati
     * @param comitato
     * @return Utente array
     */
    public function tesseriniNonRiconsegnati() {
        $filtrato = [];
        foreach ($this->membriDimessi() as $u) {
            $t = TesserinoRichiesta::filtra([
                        ['volontario', $u],
                        ['stato', INVALIDATO]], 'tConferma DESC'
            );
            $t = $t[0];
            if (!$t || $t->pRiconsegnato) {
                continue;
            }
            $filtrato[] = $u;
        }
        return $filtrato;
    }

    /**
     * Cancella il comitato con tutte le sue dipendenze
     * @param comitato
     */
    public function cancella() {

        /* Cancello aree e responsabili */
        $aree = Area::filtra([
                    ['comitato', $this]
        ]);
        foreach ($aree as $area) {
            $area->cancella();
        }

        /* Cancello le attività */
        $attivita = Attivita::filtra([
                    ['comitato', $this]
        ]);
        foreach ($attivita as $att) {
            $turni = Turno::filtra([['attivita', $att]]);
            foreach ($turni as $turno) {
                $partecipazioni = Partecipazione::filtra([['turno', $turno]]);
                foreach ($partecipazioni as $partecipazione) {
                    $autorizzazioni = Autorizzazione::filtra([['partecipazione', $partecipazione]]);
                    foreach ($autorizzazioni as $autorizzazione) {
                        $autorizzazione->cancella();
                    }
                    $partecipazione->cancella();
                }
                $coturni = Coturno::filtra([['turno', $turno]]);
                foreach ($coturni as $coturno) {
                    $coturno->cancella();
                }
                $turno->cancella();
            }
            $mipiaci = Like::filtra([['oggetto', $att->oid()]]);
            foreach ($mipiaci as $mipiace) {
                $mipiace->cancella();
            }
            $att->cancella();
        }

        /* Cancello le dimissioni */
        $dimissioni = Dimissione::filtra([
                    ['comitato', $this]
        ]);
        foreach ($dimissioni as $dimissione) {
            try {
                $appartenenza = $dimissione->appartenenza();
                $appartenenza->cancella();
            } catch (Exception $e) {
                
            }
            $dimissione->cancella();
        }

        /* Cancello le dimissioni */
        $estensioni = Estensione::filtra([
                    ['cProvenienza', $this]
        ]);
        foreach ($estensioni as $estensione) {
            try {
                $appartenenza = $estensione->appartenenza();
                $appartenenza->cancella();
            } catch (Exception $e) {
                
            }
            $estensione->cancella();
        }

        /* Cancello i gruppi personali */
        $appgruppi = AppartenenzaGruppo::filtra([
                    ['comitato', $this]
        ]);
        foreach ($appgruppi as $appgruppo) {
            $appgruppo->cancella();
        }

        /* Cancello reperibilità */
        $reperibilita = Reperibilita::filtra([
                    ['comitato', $t]
        ]);
        foreach ($reperibilita as $reperibile) {
            $reperibile->cancella();
        }

        /* Cancello appartenenze */
        $appartenenze = Appartenenza::filtra([['comitato', $this]]);
        foreach ($appartenenze as $appa) {
            $riserve = Riserva::filtra([['appartenenza', $appa]]);
            foreach ($riserve as $riserva) {
                $riserva->cancella();
            }

            $estensioni = Estensione::filtra([['appartenenza', $appa]]);
            foreach ($estensioni as $estensione) {
                $estensione->cancella();
            }

            $trasferimenti = Trasferimento::filtra([['appartenenza', $appa]]);
            foreach ($trasferimenti as $trasferimento) {
                $trasferimento->cancella();
            }
            $appa->cancella();
        }

        parent::cancella();
    }

}