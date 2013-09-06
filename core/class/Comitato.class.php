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

    private function generaColore() { 
    	$r = 100 + rand(0, 155);
    	$g = 100 + rand(0, 155);
    	$b = 100 + rand(0, 155);
    	$r = dechex($r);
    	$g = dechex($g);
    	$b = dechex($b);
    	$this->colore = $r . $g . $b;
    }

    public function calendarioAttivitaPrivate() {
        return Attivita::filtra([
            ['comitato',  $this->id]
        ]);
    }
    
    public function haMembro ( Persona $tizio, $stato = MEMBRO_VOLONTARIO ) {
        $membri = [];
        foreach ( $this->membriAttuali($stato) as $m ) {
            $membri[] = $m->id;
        }
        if ( in_array($tizio->id, $membri) ) {
            return true;
        } else {
            return false;
        }
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
        $q->bindParam(':stato',    $stato);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Volontario($k[0]);
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
            $r[] = new Volontario($k[0]);
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
              appartenenza.volontario   = anagrafica.id 
            AND
              ( inizio <= :minimo )
            AND
              appartenenza.volontario IN (
                SELECT volontario FROM appartenenza
                WHERE comitato = :comitato AND
                fine = 0 OR fine > :elezioni
              )
            ORDER BY
              anagrafica.cognome     ASC,
              anagrafica.nome        ASC");
        $minimo = clone $elezioni;
        $anzianita = (int) $anzianita;
        $minimo->modify("-{$anzianita} years");
        $q->bindValue(':comitato',  $this->id);
        $q->bindParam(':elezioni',  $elezioni->getTimestamp(), PDO::PARAM_INT);
        $q->bindParam(':minimo',    $minimo->getTimestamp(), PDO::PARAM_INT);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Volontario($k[0]);
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
            $r[] = new Volontario($k[0]);
        }
        return $r;
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
        $stato = MEMBRO_PENDENTE;
        $q->bindValue(':stato',  $stato);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Appartenenza($k[0]);
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
            $r[] = new TitoloPersonale($k[0]);
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
            $r[] = new Trasferimento($k[0]);
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
            $r[] = new Riserva($k[0]);
        }
        return $r;
    }
    
    public function locale() {
        return new Locale($this->locale);
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
                ['comitato',    $this->id],
                ['obiettivo',   $obiettivo]
            ], 'obiettivo ASC'); 
        } else {
            return Area::filtra([
                ['comitato',    $this->id]
            ], 'obiettivo ASC');
        }
    }
    
    public function attivita() {
        return Attivita::filtra([
            ['comitato', $this->id]
        ]);
    }
    
    public function gruppi() {
        return Gruppo::filtra([
            ['comitato',    $this->id]
        ], 'nome ASC');
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
            $r[] = new Reperibilita($k[0]);
        }
        return $r;
    }
    
    public function estensione() {
        return [$this];
    }
    
    public function quoteSi() {
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
                quote.timestamp BETWEEN :anno AND :ora
            ORDER BY
              anagrafica.cognome     ASC,
              anagrafica.nome  ASC");
        $q->bindValue(':comitato',  $this->id);
        $stato = MEMBRO_VOLONTARIO;
        $q->bindValue(':stato',  $stato);
        $q->bindValue(':ora',  time());
        $anno = date ('Y', time());
        $anno = mktime(0, 0, 0, 1, 1, $anno);
        $q->bindValue(':anno',    $anno);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Volontario($k[0]);
        }
        return $r;
    }
    
     public function quoteNo() {
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
                ( fine < 1 OR fine > :ora 
                OR 
                fine IS NULL ) 
         AND 
                appartenenza.id 
         NOT IN 
                ( 
                SELECT 
                    appartenenza 
                FROM 
                    quote 
                WHERE 
                timestamp BETWEEN :anno AND :ora )
        ORDER BY
              anagrafica.cognome     ASC,
              anagrafica.nome  ASC");
        $q->bindValue(':comitato',  $this->id);
        $q->bindValue(':ora',  time());
        $anno = date ('Y', time());
        $anno = mktime(0, 0, 0, 1, 1, $anno);
        $q->bindValue(':anno',    $anno);
        $stato = MEMBRO_VOLONTARIO;
        $q->bindValue(':stato', $stato);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Volontario($k[0]);
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
            $r[] = new Volontario($k[0]);
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
            $r[] = new PatentiRichieste($k[0]);
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
                dettagliPersona.nome LIKE  'datanascita'
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
            $r[] = new Reperibilita($k[0]);
        }
        return $r;
    }
}
