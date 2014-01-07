<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Utente extends Persona {
    
    /*
     * @param string $password dell'utente
     * @return bool
     */
    public function login($password) {
        if ( $this->password == criptaPassword($password) ) {
            $this->ultimoAccesso = time();
            return true;
        } else {
            return false;
        }
    }

    public static function sesso($cf) {
            if (intval(substr($cf, 9, 2)) < 40)
                return 'M';
            else
                return 'F';
    }


    public static function listaAdmin() {
        global $db;
        $q = $db->prepare("
            SELECT
                id
            FROM
                anagrafica
            WHERE
                admin > 0
            ORDER BY
                nome ASC, cognome ASC");
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Utente::id($k[0]);
        }
        return $r;
    }

    public static function senzaSesso() {
        global $db;
        $q = $db->prepare("
            SELECT
                id
            FROM
                anagrafica
            WHERE
                sesso IS NULL");
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = $k[0];
        }
        return $r;
    }
    
    public function nomeCompleto() {
        return $this->nome . ' ' . $this->cognome;
    }
    
    public function cambiaPassword($nuova) {
        $this->password = criptaPassword($nuova);
        return true;
    }
    
    public function appartenenze() {
        $a = Appartenenza::filtra([
            ['volontario',  $this->id]
        ]);
        return $a;
    }

    public function numAppartenenzeTotali($stato = SOGLIA_APPARTENENZE) {
        $q = $this->db->prepare("
            SELECT
                COUNT(*)
            FROM
                appartenenza
            WHERE
                volontario = :me
            AND
                stato > :stato");
        $q->bindParam(':me', $this->id);
        $q->bindParam(':stato', $stato);
        $q->execute();
        $q = $q->fetch(PDO::FETCH_NUM);
        return $q[0];
    }
    
    public function storico() {
        return Appartenenza::filtra([
            ['volontario', $this->id]
        ], 'INIZIO DESC');
    }
    
    public function appartenenzePendenti() {
        $r = [];
        foreach ( Appartenenza::filtra([
            ['volontario',  $this->id],
            ['stato',       MEMBRO_PENDENTE]
        ]) as $a ) {
            if ( !$a->attuale() ) { continue; }
            $r[] = $a;
        }
        return $r;
    }
    
    public function in(Comitato $c) {
        $a = Appartenenza::filtra([
            ['volontario',  $this->id],
            ['comitato',    $c->id]
        ]);
        foreach ($a as $_a) {
            if ($_a->stato >= MEMBRO_ESTESO)
                return True;
        }
        return False;
    }

    public function volontario() {
        return new Volontario($this->id);
    }
    
    public function admin() {
        global $sessione;
        if ( $this->admin && $sessione->adminMode ) {
            return true;
        } else {
            return false;
        }
    }
    
    public function titoli() {
        return TitoloPersonale::filtra([
            ['volontario',  $this->id]
        ]);
    }    
    public function titoliPersonali() {
        $r = [];
        foreach (TitoloPersonale::filtra([
            ['volontario',  $this->id]
        ]) as $titolo) {
            if ( $titolo->titolo()->tipo == TITOLO_PERSONALE ) {
                $r[] = $titolo;
            }
        }
        return $r;
    }    
    public function titoliTipo( $tipoTitoli ) {
        $r = [];
        foreach (TitoloPersonale::filtra([
            ['volontario',  $this->id]
        ]) as $titolo) {
            if ( $titolo->titolo()->tipo == $tipoTitoli ) {
                $r[] = $titolo;
            }
        }
        return $r;
    }

    public function haTitolo ( Titolo $titolo ) {
        $t = $this->titoli();
        foreach ( $t as $x ) {
            if ( $x->titolo() == $titolo ) {
                return true;
            }
        }
        return false;
    }
    
    public function toJSON() {
        return [
            'id'        =>  $this->id,
            'nome'      =>  $this->nome,
            'cognome'   =>  $this->cognome
        ];
    }

            
    public function toJSONRicerca() {
        $comitato = $this->unComitato();
        if ( $comitato ) {
            $comitato = $comitato->toJSONRicerca();
        } else {
            $comitato = false;
        }
        return [
            'id'            =>  $this->id,
            'cognome'       =>  $this->cognome,
            'nome'          =>  $this->nome,
            'email'         =>  $this->email,
            'codiceFiscale' =>  $this->codiceFiscale,
            'comitato'      =>  $comitato
        ];
    }

    public function calendarioAttivita(DT $inizio, DT $fine) {
        $c = $this->comitati();
        $t = [];
        foreach ( $c as $x ) {
            foreach ( $x->calendarioAttivitaPrivate($inizio, $fine) as $a ) {
                $t[] = $a;
            }
        }
        foreach ( Attivita::filtra([['pubblica',  ATTIVITA_PUBBLICA]]) as $a ) {
            $t[] = $a;
        }
        return $t;
    }
    
    public function appartenenzeAttuali($tipo = MEMBRO_ESTESO) {
        $q = $this->db->prepare("
            SELECT
                appartenenza.id
            FROM
                appartenenza
            WHERE
                stato >= :tipo
            AND
                volontario = :me
            AND
                ( appartenenza.fine < 1
                 OR
                appartenenza.fine > :ora 
                 OR
                appartenenza.fine IS NULL)");
        $q->bindParam(':tipo', $tipo);
        $ora = time();
        $q->bindParam(':ora',  $ora);
        $q->bindParam(':me', $this->id);
        $q->execute();
        $r = [];
        while ( $x = $q->fetch(PDO::FETCH_NUM ) ) {
            $r[] = Appartenenza::id($x[0]);
        }
        return $r;
    }
    
    public function comitati($tipo = MEMBRO_ESTESO) {
        $c = [];
        foreach ( $this->appartenenzeAttuali($tipo) as $a ) {
            $c[] = $a->comitato();
        }
        return $c;
    }
    
    public function unComitato($tipo = MEMBRO_VOLONTARIO) {
        $c = $this->comitati($tipo);
        if (!$c) { return false; }
        shuffle($c);
        return $c[0];
    }
    
    public function numeroAppartenenzeAttuali($tipo = MEMBRO_VOLONTARIO) {
        $q = $this->db->prepare("
            SELECT
                COUNT( appartenenza.id )
            FROM
                appartenenza
            WHERE
                stato >= :tipo
            AND
                volontario = :me
            AND
                ( appartenenza.fine < 1 
                 OR
                appartenenza.fine > :ora )");
        $q->bindParam(':tipo', $tipo);
        $q->bindParam(':me', $this->id);
        $ora = time();
        $q->bindParam(':ora',  $ora);
        $q->execute();
        $q = $q->fetch(PDO::FETCH_NUM);
        return $q[0];
    }
    
    public function primaAppartenenza() {
        $p = Appartenenza::filtra([
            ['volontario',  $this->id]
        ], 'inizio ASC');
        if ( !$p ) { return false; }
        $r = [];
        foreach ($p as $_p){
            if($_p->validaPerAnzianita()) {
                $r[] = $_p;
            }
        }
        return $r[0];
    }

    public function ultimaAppartenenza($stato = MEMBRO_VOLONTARIO) {
        $p = Appartenenza::filtra([
            ['volontario',  $this->id],
            ['stato', $stato]
        ], 'inizio DESC');
        if ( !$p ) { return false; }
        return $p[0];
    }

    public function appartenenzaAttuale() {
        return $this->ultimaAppartenenza(MEMBRO_VOLONTARIO);
    }
    
    public function ingresso() {
        $p = $this->primaAppartenenza();
        if ( !$p ) { return false; }
        return $p->inizio();
    }
    
    /*
     * Ritorna le appartenenze delle quali si è presidente.
     */
    public function presidenziante() {
        return $this->delegazioni(APP_PRESIDENTE);
    }
    
    public function comitatiPresidenzianti() {
        return $this->comitatiDelegazioni(APP_PRESIDENTE);
    }
    
    public function comitatiApp( $app , $soloComitati = true) {
        if (!is_array($app)) {
            $app = [$app];
        }
        if ( $this->admin() ) {
            return $this->comitatiDiCompetenza();
        }
        $r = [];
        foreach ( $app as $k ) {
            $r = array_merge($r, $this->comitatiDelegazioni($k, $soloComitati));
        }
        $r = array_unique($r);
        return $r;
    }
    
    public function comitatiAppComma ( $app ) {
        $app = $this->comitatiApp($app);
        return implode(', ', $app);
    }
    
    public function numVolontariDiCompetenza() {
        $n = 0;
        $comitati = $this->comitatiApp([ APP_SOCI, APP_PRESIDENTE, APP_CO, APP_OBIETTIVO ]);
        foreach($comitati as $_c) {
                $n += $_c->numMembriAttuali(MEMBRO_VOLONTARIO);          
        }
        return $n;
    }
    
    public function presiede( $comitato = null ) {
        if ( $comitato ) {
            if($comitato->unPresidente() == $this->id) {
                return true;
            }
        } else {
            return (bool) $this->comitatiApp([APP_PRESIDENTE], false);
        }
        return false;
    }
    
    /* Avatar */
    public function avatar() {
        $a = Avatar::by('utente', $this->id);
        if ( $a ) {
            return $a;
        } else {
            $a = new Avatar();
            $a->utente = $this->id;
            return $a;
        }
    }
    
    public function comitatiDiCompetenza() {
        if ( $this->admin() ) {
            return Comitato::elenco('locale ASC');
        } else {
            return $this->comitatiPresidenzianti();
        }
    }

    public function unitaDiCompetenza() {
        $c = $this->comitatiDiCompetenza();
        $r = [];
        foreach($c as $_c) {
            if($_c instanceof Comitato) {
                $r[] = $_c;
            }
        }
        return $r;
    }
    
    public function miCompete(Comitato $c) {
        return (bool) in_array($c, $this->comitatiDiCompetenza());
    }

    public function commenti ( $limita = null ) {
        if ( $limita ) {
            $limita = (int) $limita;
            return Commento::filtra([
                ['volontario', $this]
            ], "tCommenta DESC LIMIT 0, {$limita}");
        } else {
            return Commento::filtra([
                ['volontario', $this]
            ], "tCommenta DESC");
        }
    }

    public function cancella() {
        // 1. Cancella il mio avatar
        $this->avatar()->cancella();
        // 2. Cancella le mie appartenenze ai gruppi
        foreach ( $this->appartenenze() as $a ) {
            $a->cancella();
        }
        // 3. Cancella le mie partecipazioni
        foreach ( $this->partecipazioni() as $p ) {
            $p->cancella();
        }
        // 4. Elimina le autorizzazioni che mi sono state chieste
        foreach ( $this->autorizzazioniPendenti() as $a ) {
            $a->cancella();
        }
        // 5. Elimina tutte le delegazioni che mi sono associate
        foreach ( $this->storicoDelegazioni() as $d ) {
            $d->cancella();
        }
        // 6. Riassegna le Aree al primo presidente a salire l'albero
        foreach ( $this->areeDiResponsabilita() as $a ) {
            $a->responsabile = $a->comitato()->primoPresidente();
        }
        // 7. Commenti lasciati in giro
        foreach ( $this->commenti() as $c ) {
            $c->cancella();
        }
        // 8. Gruppi di cui sono referente
        foreach ( Gruppo::filtra([['referente',$this]]) as $g ) {
            $g->cancella();
        }
        // 9. Mie estensioni
        foreach ( Estensione::filtra([['volontario',$this]]) as $g ) {
            $g->cancella();
        }
        // 10. Mie Riserve
        foreach ( Riserva::filtra([['volontario',$this]]) as $g ) {
            $g->cancella();
        }
        // 11. Mie reperibilita'
        foreach ( Reperibilita::filtra([['volontario',$this]]) as $g ) {
            $g->cancella();
        }
        // 12. Sessioni in corso
        foreach ( Sessione::filtra([['utente',$this]]) as $g ) {
            $g->cancella();
        }
        // 13. Titoli personali
        foreach ( TitoloPersonale::filtra([['volontario',$this]]) as $g ) {
            $g->cancella();
        }
        parent::cancella();
    }
    
    public function numTitoliPending( $app = [ APP_PRESIDENTE ] ) {
        $comitati = $this->comitatiAppComma( $app );
        $q = $this->db->prepare("
            SELECT  COUNT(titoliPersonali.id)
            FROM    titoliPersonali, appartenenza
            WHERE   ( titoliPersonali.tConferma < 1 OR titoliPersonali.tConferma IS NULL )
            AND     titoliPersonali.volontario = appartenenza.volontario
            AND     ( appartenenza.fine < 1 
                    OR
                    appartenenza.fine > :ora )
            AND     appartenenza.comitato  IN
                ( {$comitati} )");
        $ora = time();
        $q->bindParam(':ora', $ora);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        return (int) $r[0];
    }
    
    public function numAppPending( $app = [ APP_PRESIDENTE ] ) {
        $comitati = $this->comitatiAppComma( $app );
        $q = $this->db->prepare("
            SELECT  COUNT(id)
            FROM    appartenenza
            WHERE   stato = :statoPendente
            AND     ( appartenenza.fine < 1 
                    OR
                    appartenenza.fine > :ora )
            AND     appartenenza.comitato  IN
                ( {$comitati} )");
        $q->bindValue(':statoPendente', MEMBRO_PENDENTE);
        $ora = time();
        $q->bindParam(':ora', $ora);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        return (int) $r[0];
    }
    
    public function numTrasfPending( $app = [ APP_PRESIDENTE ] ) {
        $comitati = $this->comitatiAppComma ( $app );
        $q = $this->db->prepare("
            SELECT  COUNT(trasferimenti.id)
            FROM    trasferimenti, appartenenza
            WHERE   trasferimenti.volontario = appartenenza.volontario
            AND     appartenenza.stato = :stato
            AND     trasferimenti.stato = :statoTrasferimento
            AND     appartenenza.comitato  IN
                ( {$comitati} )");
        $q->bindValue(':stato', MEMBRO_VOLONTARIO);
        $q->bindValue(':statoTrasferimento', TRASF_INCORSO);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        return (int) $r[0];
    }

    public function numEstPending( $app = [ APP_PRESIDENTE ] ) {
        $comitati = $this->comitatiAppComma ( $app );
        $q = $this->db->prepare("
            SELECT  COUNT(estensioni.id)
            FROM    estensioni, appartenenza
            WHERE   estensioni.volontario = appartenenza.volontario
            AND     appartenenza.stato = :stato
            AND     estensioni.stato = :statoEstensione
            AND     ( appartenenza.fine < 1 
                    OR
                    appartenenza.fine > :ora 
                    OR
                    appartenenza.fine IS NULL)
            AND     appartenenza.comitato  IN
                ( {$comitati} )");
        $q->bindValue(':stato', MEMBRO_VOLONTARIO);
        $q->bindValue(':statoEstensione', EST_INCORSO);
        $ora = time();
        $q->bindParam(':ora', $ora);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        return (int) $r[0];
    }
    
    public function numRisPending( $app = [ APP_PRESIDENTE ] ) {
        $comitati = $this->comitatiAppComma ( $app );
        $q = $this->db->prepare("
            SELECT  COUNT(riserve.id)
            FROM    riserve, appartenenza
            WHERE   riserve.stato = :statoPendente
            AND     riserve.volontario = appartenenza.volontario
            AND     appartenenza.stato = :stato
            AND     ( appartenenza.fine < 1 
                    OR
                    appartenenza.fine > :ora )
            AND     appartenenza.comitato  IN
                ( {$comitati} )");
        $q->bindValue(':statoPendente', RISERVA_INCORSO);
        $q->bindValue(':stato', MEMBRO_VOLONTARIO);
        $ora = time();
        $q->bindParam(':ora', $ora);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        return (int) $r[0];
    }
    
    public function documento($tipo = DOC_CARTA_IDENTITA) {
        $d = Documento::filtra([
            ['tipo',        $tipo],
            ['volontario',  $this->id]
        ]);
        if ( !$d ) { return false; }
        return $d[0];
    }
    
    public function documenti() {
        global $conf;
        $r = [];
        foreach ( $conf['docs_tipologie'] as $k => $doc ) {
            $d = $this->documento($k);
            if ( $d ) {
                $r[] = $d;
            }
        }
        return $r;
    }
    
    public function zipDocumenti() {
        $z = new Zip();
        foreach ( $this->documenti() as $d ) {
            $z->aggiungi ( $d->creaFile() );
        }
        $nome = $this->nomeCompleto();
        $z->comprimi("Documenti {$nome}.zip");
        return $z;
    }
    
    public function autorizzazioniPendenti() {
        return Autorizzazione::filtra([
            ['volontario',  $this->id],
            ['stato',       AUT_PENDING]
        ], 'timestamp ASC');
    }
    
    public function storicoDelegazioni($app = null, $comitato = null) {
        if ( $app ) {
            $app = (int) $app;
            if ( $comitato ) {
                return Delegato::filtra([
                    ['volontario',      $this->id],
                    ['applicazione',    $app],
                    ['comitato',        $comitato]
                ]);
            } else {
                return Delegato::filtra([
                    ['volontario',      $this->id],
                    ['applicazione',    $app]
                ]);
            }
        } else {
            if ( $comitato ) {
                return Delegato::filtra([
                    ['volontario',      $this->id],
                    ['comitato',        $comitato]
                ]);
            } else {
                return Delegato::filtra([
                    ['volontario',      $this->id]
                ]);
            }
        }
    }
    
    public function delegazioni($app = null, $comitato = null) {
        $t = $this->storicoDelegazioni($app, $comitato);
        $r = [];
        foreach ( $t as $k ) {
            if ( $k->attuale() ) {
                $r[] = $k;
            }
        }
        return $r;
    }
    /*
     * Restituisce i comitati che mi competono per una determinata delega
     * @return array di geopolitiche
     * @param $app array di delegazioni
     * @param $soloComitati per far restituire solo i comitati e non il resto
     * @param $espandi default ritorna le geopolitiche e la loro espansione
     */
    public function comitatiDelegazioni($app = null, $soloComitati = false, $espandi = true) {
        $d = $this->delegazioni($app);
        $c = [];
        foreach ( $d as $_d ) {
            $comitato = $_d->comitato();
            if (!$soloComitati || $comitato instanceof Comitato) {
                $c[] = $comitato;
            }
            if ($espandi && !$comitato instanceof Comitato) {
                $c = array_merge($comitato->estensione(), $c);
            }
        }
        return array_unique($c);
    }

    public function entitaDelegazioni($app = null) {
        /* Qualora fossi admin, ho tutto il nazionale... */
        if (
            $this->admin()
        ) { 
            return Nazionale::elenco('nome ASC');
        }
        
        $d = $this->delegazioni($app);
        $c = [];
        foreach ( $d as $k ) {
            $c[] = $k->comitato();
        }
        return array_unique($c);
    }

    public function dominiDelegazioni($app) {
        $d = $this->delegazioni($app);
        $c = [];
        foreach ( $d as $k ) {
            $c[] = $k->dominio;
        }
        return array_unique($c);
    }
    
    public function partecipazioni( $stato = false ) {
        if ( $stato ) {
            return Partecipazione::filtra([
                ['volontario',  $this->id],
                ['stato',       $stato]
            ], 'timestamp DESC');
        } else {
            return Partecipazione::filtra([
                ['volontario',  $this->id]
            ], 'timestamp DESC');
        }
    }
    
    
    public function trasferimenti($stato = null) {
        if ( $stato ) {
            return Trasferimento::filtra([
                ['volontario',  $this->id],
                ['stato',       $stato]
            ]);   
        } else {
            return Trasferimento::filtra([
                ['volontario',  $this->id]
            ]);
        }
    }
    
    public function inRiserva() {
        $rok = Riserva::filtra([
            ['volontario',  $this->id],
            ['stato',       RISERVA_OK]
        ]);
        $rauto = Riserva::filtra([
            ['volontario',  $this->id],
            ['stato',       RISERVA_AUTO]
        ]);
        $r = array_merge($rok, $rauto);

        foreach ($r as $_r) {
            if ($_r->inizio < time() && $_r->fine > time())
                return True;
        }
        return False;
    }
    
    public function riserve() {
        return Riserva::filtra([
            ['volontario',  $this->id]
        ]);
    }

    public function unaRiserva() {
        $r = $this->riserve();
        foreach ($r as $_r) {
            if ($_r->stato == RISERVA_OK || $_r->stato == RISERVA_AUTO)
                return $_r;
        }
        return NULL;
    }

    public function unaRiservaInSospeso() {
        $r = $this->riserve();
        foreach ($r as $_r) {
            if ($_r->stato == RISERVA_INCORSO)
                return $_r;
        }
        return NULL;
    }
    
    public function mieiGruppi() {
        return AppartenenzaGruppo::filtra([
            ['volontario',  $this->id]
        ]);
    }
    
    public function contaGruppi() {
        $q = $this->db->prepare("
            SELECT
                COUNT(volontario)
            FROM
                gruppiPersonali
            WHERE
                ( fine >= :ora OR fine IS NULL OR fine = 0) 
            AND
                volontario = :volontario
            ORDER BY
                inizio ASC");
        $q->bindValue(':ora', time());
        $q->bindParam(':volontario', $this->id);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        return (int) $r[0];
    }
    
     public function gruppoAttuale($g) {
        $q = $this->db->prepare("
            SELECT
                id
            FROM
                gruppiPersonali
            WHERE
                ( fine >= :ora OR fine IS NULL OR fine = 0)
            AND
                volontario = :volontario 
            AND
                gruppo = :gruppo
            ORDER BY
                inizio ASC");
        $q->bindValue(':ora', time());
        $q->bindParam(':volontario', $this->id);
        $q->bindParam(':gruppo', $g);
        $q->execute();
        $r = $q->fetch();
        $r = new AppartenenzaGruppo($r[0]);
        return $r;
    }
    
    public function mieReperibilita() {
        return Reperibilita::filtra([
            ['volontario',  $this->id]
        ]);
    }
    
    public function areeDiResponsabilita() {
        return Area::filtra([
            ['responsabile',    $this->id]
        ]);
    }
    
    public function areeDiCompetenza( $c = null , $espandiLocale = false) {
        if ( $c ) {
            if ( $this->admin() || $this->presiede($c) ) {
                return $c->aree();
            } elseif ( $o = $this->delegazioni(APP_OBIETTIVO, $c) ) {
                $r = [];
                foreach ( $o as $io ) {
                    $r = array_merge($r, $c->aree($io->dominio, $espandiLocale));
                }
                $r = array_unique($r);
                return $r;
            } else {
                return $this->areeDiResponsabilita();
            }
            
        } else {
            
            $r = [];
            foreach ( $this->comitatiDiCompetenza() as $c ) {
                $r = array_merge($r, $c->aree());
            }
            foreach ( $this->delegazioni(APP_OBIETTIVO) as $d ) {
                $comitato = $d->comitato();
                $r = array_merge($r, $comitato->aree($d->dominio));
                if ($comitato instanceof Locale) {
                    $comitati = $comitato->estensione();
                    foreach ($comitati as $_c) {
                        $r = array_merge($r, $_c->aree($d->dominio));
                    } 
                }
            }
            $r = array_merge($r, $this->areeDiResponsabilita());
            $r = array_unique($r);
            return $r;
            
        }
    }
    
    public function comitatiAreeDiCompetenza() {
        $a = $this->areeDiCompetenza(null, true);
        $r = [];
        foreach ($a as $ia) {
            $comitato = $ia->comitato();
            $r[] = $comitato;
            if ($comitato instanceof Locale) {
                $r = array_merge($r, $comitato->estensione());
            }
        }
        $r = array_unique($r);
        return $r;
    }
    
    
    public function attivitaReferenziate() {
        return Attivita::filtra([
            ['referente',   $this->id]
        ], 'nome ASC');
    }
            
    public function attivitaReferenziateDaCompletare() {
        return Attivita::filtra([
            ['referente',   $this->id],
            ['stato',       ATT_STATO_BOZZA]
        ]);
    }
    
    public function attivitaAreeDiCompetenza() {
        $r = [];
        foreach ( $this->areeDiCompetenza() as $area ) {
            $r = array_merge($r, $area->attivita());
        }
        $r = array_unique($r);
        return $r;
    }
    
    public function attivitaDiGestione() {
        $a = array_merge($this->attivitaReferenziate(), $this->attivitaAreeDiCompetenza());
        foreach ( $this->comitatiDiCompetenza() as $c ) {
            $a = array_merge($a, $c->attivita());
        }
        return array_unique($a);
    }
    
    public function cellulare() {
        if($this->cellulareServizio){
            return $this->cellulareServizio;
        }
        return $this->cellulare;
    }

    public function email() {
        if($this->emailServizio){
            return $this->emailServizio;
        }
        return $this->email;
    }
    
    public function giovane() {
        $u = time()-GIOVANI;
        if($u <=  $this->dataNascita){
            return true;
            }else{
                return false;
            }
    }
    
    public function gruppiDiCompetenza( $app = [ APP_PRESIDENTE, APP_SOCI, APP_OBIETTIVO ] ) {
        $gruppi = [];
        $comitati = $this->comitatiApp($app);
        $domini = $this->dominiDelegazioni(APP_OBIETTIVO);
        if ( $domini && !$this->admin() && !$this->presidenziante() ){
            foreach ($comitati as $comitato) {
                foreach ($domini as $d){
                    $gruppi = array_merge(
                        $gruppi,
                        Gruppo::filtra([
                            ['referente',$this],
                            ['obiettivo',$d]
                        ])
                    );
                    if (!$gruppi){
                        $gruppi = array_merge(
                            $gruppi,
                            Gruppo::filtra([
                            ['referente',$this]
                        ])
                        );
                    }
                }
            $gruppi = array_unique($gruppi);
            }
        }else{
            foreach ($comitati as $comitato) {
                $gruppi = array_merge($gruppi, $comitato->gruppi());
            }
            $gruppi = array_merge(
                    $gruppi,
                    Gruppo::filtra([
                        ['referente',$this]
                    ])
            );
            $gruppi = array_unique($gruppi);
            }
        return $gruppi;
    }

    public function inEstensione($c) {
        $app = Appartenenza::filtra([
            ['volontario', $this->id],
            ['stato', MEMBRO_ESTESO],
            ['comitato', $c]
        ]);
        return Estensione::filtra([
            ['appartenenza',  $app[0]->id],
            ['stato',       EST_OK]
        ]);
    }

    public function quote() {
        $q = [];
        foreach ( $this->storico() as $app ) {
            $q = array_merge($q, Quota::filtra([
            ['appartenenza', $app]], 
            'timestamp DESC'));
        }
        return $q;
    }

    public static function elencoId() {
         global $db;
        $q = $db->prepare("
            SELECT
                id
            FROM
                anagrafica
            WHERE
                stato >= :stato
            ORDER BY
                id ASC");
        $q->bindValue(':stato', PERSONA);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = $k[0];
        }
        return $r;
    }

    public function privacy() {
        $privacy = Privacy::by('volontario', $this);
        if ( !$privacy ) {
            $privacy = new Privacy;
            $privacy->volontario = $this;
            $privacy->contatti = PRIVACY_COMITATO;
            $privacy->mess = PRIVACY_COMITATO;
            $privacy->curriculum = PRIVACY_PRIVATA;
            $privacy->incarichi = PRIVACY_PRIVATA;
        }
        return $privacy;
    }

    public function consenso() {
        if(!$this->consenso) {
            return false;
        }
        return true;
    }

    public function pri_delegato() {
        if($this->presidenziante() || $this->attivitaReferenziate() || $this->delegazioni()){
            return true;
        }
        return false;
    }

    public function pri_smistatore($altroutente){
        if($this->presidenziante() || $this->delegazioni([APP_PRESIDENTE, APP_SOCI, APP_OBIETTIVO])){
            $comitati = $this->comitatiApp([APP_PRESIDENTE, APP_SOCI, APP_OBIETTIVO]);
            foreach ($comitati as $comitato){
                if($altroutente->in($comitato)){
                    return PRIVACY_RISTRETTA;            
                }
            }
            return PRIVACY_PUBBLICA;
        }elseif($this->areeDiResponsabilita()){
            $ar = $this->areeDiResponsabilita();
            foreach( $ar as $_a ){
                $c = $_a->comitato()->estensione();
                foreach ($c as $_c) {
                    if($altroutente->in($_c)){
                        return PRIVACY_RISTRETTA;
                    }
                }
            }
            redirect('public.utente&id=' . $id);
        }elseif($this->attivitaReferenziate()){
            $a = $this->attivitaReferenziate();
            $partecipazioni = $this->partecipazioni(PART_OK);
            foreach( $partecipazioni as $p ){
                if (in_array($p->attivita(), $a)) {
                    return PRIVACY_RISTRETTA;
                }
            }
            return PRIVACY_PUBBLICA;
        }
        return PRIVACY_PUBBLICA;
    }

	/*
     * @return età utente
     */
    public function eta(){
        $anno = date('Y', $this->dataNascita);
        $ora = date('Y', time());
        return $ora-$anno;
    }

    /*
     * @return bool restituisce true se oggi è il compleanno dell'utente
     */
    public function compleanno(){
        if( date('m', $this->dataNascita)==date('m', time()) && date('d', $this->dataNascita)==date('d', time())){
            return true;
        }else{
            return false;
        }
    }

    /*
     * @return true se se si è in una situazione in cui le appartenenze assegnate hanno senso.
     * Anche se la gestione del false non è fatta in maniera corretta nella pagina.
     */
    public function appartenenzaValida(){
        $attuali = $this->appartenenzeAttuali();
        $pendenti = $this->appartenenzePendenti();
        $inGenerale = $this->appartenenze();
        if(($attuali || $pendenti) && $this->stato == VOLONTARIO){
            return true;
        } elseif($inGenerale && $this->stato == PERSONA) {
            return true;
        } elseif (!$attuali && !$pendenti && $this->stato == ASPIRANTE) {
            return true;
        }
        return false;
    }

    /*
     * Verifica se un altro utente ha permessi in scrittura su me
     * @return bool modifica o non modifica
     * @param $altroUtente il modificatore
     */
    public function modificabileDa(Utente $altroUtente) {
        if ($altroUtente->admin()) {
            return true;
        }
        $comitatiGestiti = array_merge($altroUtente->comitatiDelegazioni(APP_PRESIDENTE, false, false), 
                               $altroUtente->comitatiDelegazioni(APP_SOCI, false, false)
                            );
        $comitatiGestiti = array_unique($comitatiGestiti);
        
        $c = $this->unComitato(MEMBRO_PENDENTE);
        if($c) {
            if(in_array($c->locale(), $comitatiGestiti) 
            || in_array($c, $comitatiGestiti)) {
            return true;
            }
        }
        return false;
    }

    /*
     * Visualizza ultimo accesso dell'utente
     * @return recentemente<5gg, 5gg< ultimo mese <30gg, piu di un mese >30gg
     */
    public function ultimoAccesso() {
        if(!$this->ultimoAccesso){
            return "Mai";
        } elseif ($this->ultimoAccesso >= time()-GIORNO*5) {
            return "Recentemente";
        } elseif ($this->ultimoAccesso >= time()-MESE) {
            return "Nell'ultimo mese";
        }
        return "Più di un mese fà";
    }
}
