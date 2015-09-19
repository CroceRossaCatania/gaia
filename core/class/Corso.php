<?php
/*
 * ©2013 Croce Rossa Italiana
 */
/**
 * Rappresenta un Corso.
 */
class Corso extends GeoEntita {

    protected static
        $_t  = "crs_corsi",
        $_dt = "crs_dettagliCorsi",
        $_jt_iscrizioni = "crs_partecipazioni_corsi";

    use EntitaCache;

    /*
    public function __construct($tmp) 
    {
        $this->tmp = $tmp;
        
        $this->titolo = 'Corso BLSD FULL MOCK' . ' - Formazione CRI su Gaia';
        $this->descrizione = 'Ravenna' . ' || Aperto a: ' . 'BLABLABLA'.' || Organizzato da ' . 'Marco Radossi';
        $this->luogo = 'Ravenna';
        $this->timestamp = date("t");
        $this->comitato = 'Comitato:'.$tmp;
    }
     * 
     */
    
    public function verificato($correggi=false) {
        
        if (!is_numeric($this->partecipanti)) {
            if ($correggi) {
                $this->partecipanti = 0;
            }
            return false;
        }
    }
    
    /**
     * Genera il codice numerico progressivo del corso sulla base dell'anno attuale
     *
     * @return int|false $progressivo     Il codice progressivo, false altrimenti 
     */
    public function assegnaProgressivo() {
        if ($this->progressivo) {
            return false;
        }
        $anno = $this->inizio()->format('Y');
        $progressivo = $this->generaProgressivo('progressivo', [["anno", $anno]]);
        $this->progressivo = $progressivo;
        return $progressivo;
    }
    
    /**
     * Aggiorna lo stato interno in base ai dati posseduti
     */
    public function aggiornaStato() {
        
        switch ($this->stato) {
            case CORSO_S_ANNULLATO:
            case CORSO_S_CONCLUSO:
            case CORSO_S_ATTIVO:
                return;
                break;
            case CORSO_S_DACOMPLETARE:
                $update = true;
                if (!empty($this->organizzatore) &&
                    !empty($this->responsabile) &&
                    !empty($this->direttore) &&
                    ($this->partecipanti == $this->numeroDiscenti()) &&
                    ($this->numeroInsegnantiNecessari() == $this->numeroInsegnanti()) &&
                    ($this->numeroInsegnantiNecessari() >= $this->numeroAffiancamenti())
                    )
                    $this->stato = CORSO_S_ATTIVO;
                break;
        }
    }

    /*
    public function area()
    {
        return Area::id(5);
    }
    
    public function postiLiberi()
    {
        return 20;
    }
    
    public function filtraPerDati($tipologie, $province)
    {
        return "http://".$_SERVER['SERVER_NAME'].'?'.$_SERVER['QUERY_STRING'];
    }
    
    public function trovaVicini($latitude, $longitudine, $raggio = 50)
    {
        return "http://".$_SERVER['SERVER_NAME'].'?'.$_SERVER['QUERY_STRING'];
    }
    
    public function linkMappa()
    {
        return "http://".$_SERVER['SERVER_NAME'].'?'.$_SERVER['QUERY_STRING'];
    }
    */
    
    /**
     * Ritorna l'organizzatore del corso base
     * @return GeoPolitica
     */
    public function organizzatore() {
    	return GeoPolitica::daOid($this->organizzatore);
    }

    /**
     * Ritorna il responsabile del corso
     * @return GeoPolitica
     */
    public function responsabile() {
    	return Volontario::id($this->responsabile);
    }

    /**
     * Ritorna la data di inizio del corso base
     * @return DT
     */
    public function inizio() {
    	return DT::daTimestamp($this->inizio);
    }

    /**
     * Ritorna la data dell'esame
     * @return DT
     */
    public function fine() {
        return DT::daTimestamp($this->tEsame);
    }

    /**
     * Ritorna la data dell'esame in epoch time
     * @return int
     */
    public function fineDate() {
        return $this->tEsame;
    }

    /**
     * Controlla se il corso e' futuro (non iniziato)
     * @return bool
     */
    public function modificabile() {
        if (!$this->inizio) {
            return false;
        }

        $inizio = intval($this->inizio);
        $oggi = (new DT())->getTimestamp();
        $buffer = GIORNI_CORSO_NON_MODIFICABILE * 86400;
        return (($inizio-$oggi) > $buffer);
    }

    /**
     * Controlla se il corso e' futuro (non iniziato)
     * @return bool
     */
    public function modificabileFinoAl() {
        if (!$this->inizio) {
            return false;
        }

        $inizio = $this->inizio;
        $buffer = GIORNI_CORSO_NON_MODIFICABILE * 86400;
        
        return new DT('@'.($inizio - $buffer));
    }

    /**
     * True se il corso è attivo e non iniziato
     * @return bool     stato del cors
     */
    public function accettaIscrizioni() {
        if (!$this->inizio) {
            return false;
        }

        $inizio = $this->inizio;
        $oggi = (new DT())->getTimestamp();
        $buffer = GIORNI_CORSO_ISCRIZIONI_CHIUSE * 86400;
        
        return (($oggi-$inizio) > $buffer);
    }
    
    /**
     * Controlla se il corso e' futuro (non iniziato)
     * @return bool
     */
    public function futuro() {
    	return $this->inizio() > new DT;
    }

    /**
     * Controlla se il corso e' iniziato
     * @return bool
     */
    public function iniziato() {
    	return !$this->futuro();
    }

    /**
     * Controlla se il corso e' finito
     * @return bool
     */
    public function finito() {
        return $this->fine() < new DT; 
    }

    /**
     * Controlla se il corso e' concluso (finito e fatto esame)
     * @return bool
     */
    public function concluso() {
        //return $this->finito() && 
        return $this->stato == CORSO_S_CONCLUSO; 
    }

    /**
     * Controlla se il corso e' da completare (email non mandata)
     * @return bool
     */
    public function daCompletare() {
        return (bool) ($this->stato == CORSO_S_DACOMPLETARE); 
    }

    /**
     * Localizza nella sede del comitato organizzatore
     *
    public function localizzaInSede() {
    	$sede = $this->organizzatore()->coordinate();
    	$this->localizzaCoordinate($sede[0], $sede[1]);
    }//*/
    
    /**
     * Restituisce il nome del corso
     * @return string     il nome del corso
     */
    public function nome() {
        $certificato = Certificato::id($this->certificato);
        return "Corso di ".$certificato->nome;
    }

    /**
     * Informa se un corso è non concluso
     * @return bool     false se concluso, true altrimenti
     */
    public function attuale() {
        if($this->stato > CORSO_S_CONCLUSO)
            return true;
        return false;
    }

    /**
     * Informa se un corso è modificabile da un determianto utente
     * @return bool 
     */
    public function modificabileDa(Utente $u) {
        if($u->admin()) return true;
        return (bool) (
                $u->id == $this->direttore
            ||  contiene($this->id, 
                    array_map(function($x) {
                        return $x->id;
                    }, $u->corsiInGestione())
                )
        );

    }

    /**
     * Informa se un corso è cancellabile da un determianto utente
     * @return bool 
     */
    public function cancellabileDa(Utente $u) {
        return (bool) contiene($this, $u->corsiInGestione());
    }

    /**
     * Restituisce il direttore di un corso
     * @return Volontario 
     */
    public function direttore() {
        if ($this->direttore) {
            return Volontario::id($this->direttore);    
        }
        return null;
    }

    /**
     * Restituisce l'area di un corso
     * @return Area 
     */
    public function area() {
        return Area::id($this->area);
    }
    
    /**
     * Restituisce il progressivo del corso in questione, se
     * mancante lo genera
     * @return string|false 
     */
    public function progressivo() {
        if ( !$this->progressivo )
            $this->assegnaProgressivo();
        if($this->progressivo) {
            return 'CORSO-'.$this->anno.'/'.$this->progressivo;
        }
        return null;
    }


    /**
     * Verfica se un utente è iscritto o no al corso
     * @return bool
     */
    public function iscritto(Utente $u) {
        $p = PartecipazioneCorso::filtra([
            ['volontario', $u->id],
            ['corso', $this->id]
            ]);
        foreach($p as $_p) {
            if($_p->attiva()) {
                return true;
            }
        }
        return false;
    }

    
    /**
     * Elenco delle partecipazioni (con qualsiasi ruolo)
     * @return PartecipazioneCorso elenco delle partecipazioni dei discenti 
     */
    public function partecipazioni($stato = null) {
        return PartecipazioneCorso::filtra([
            ['corso', $this->id],
            ['stato', PARTECIPAZIONE_ACCETTATA, OP_GTE]
        ]);
    }

    
    /**
     * Elenco delle partecipazioni (con qualsiasi ruolo)
     * @return PartecipazioneCorso elenco delle partecipazioni dei discenti 
     */
    public function partecipazioniPotenziali($stato = null) {
        return PartecipazioneCorso::filtra([
            ['corso', $this->id],
            ['stato', PARTECIPAZIONE_RICHIESTA]
        ]);
    }

    
    /**
     * Elenco dei discenti ad un corso 
     * @return Utente elenco dei discenti 
     */
    public function discenti() {
        return PartecipazioneCorso::filtra([
            ['corso', $this->id],
            ['ruolo', CORSO_RUOLO_DISCENTE],
            ['stato', PARTECIPAZIONE_ACCETTATA, OP_GTE]
        ]);
    }

    
    /**
     * Elenco dei discenti ad un corso 
     * @return Utente elenco dei discenti 
     */
    public function discentiPotenziali() {
        return PartecipazioneCorso::filtra([
            ['corso', $this->id],
            ['ruolo', CORSO_RUOLO_DISCENTE],
            ['stato', PARTECIPAZIONE_RICHIESTA]
        ]);
    }

    
    /**
     * Numero dei discenti ad un corso 
     * @return int numero dei discenti 
     */
    public function numeroDiscenti() {
        return PartecipazioneCorso::conta([
            ['corso', $this->id],
            ['ruolo', CORSO_RUOLO_DISCENTE],
            ['stato', PARTECIPAZIONE_ACCETTATA, OP_GTE]
        ]);
    }

    
    /**
     * Numero dei discenti ad un corso 
     * @return int numero dei discenti 
     */
    public function postiLiberi() {
        return $this->partecipanti - PartecipazioneCorso::conta([
            ['corso', $this->id],
            ['ruolo', CORSO_RUOLO_DISCENTE],
            ['stato', PARTECIPAZIONE_ACCETTATA, OP_GTE]
        ]);
    }

    
    public function numeroInsegnanti() {
        return PartecipazioneCorso::conta([
            ['corso', $this->id],
            ['ruolo', CORSO_RUOLO_INSEGNANTE],
            ['stato', PARTECIPAZIONE_ACCETTATA, OP_GTE]
        ]);
    }

    
    /**
     * Numero dei discenti ad un corso 
     * @return int numero dei discenti 
     */
    public function numeroInsegnantiMancanti() {
        return $this->numeroInsegnantiNecessari() - $this->numeroInsegnanti();
    }

    
    public function numeroInsegnantiNecessari() {
        return ceil( $this->partecipanti / max(1,$this->certificato()->proporzioneIstruttori) );
    }
    
    
    /*
     * Funzione repository per recuperare insegnanti di un corso
     */
    public function insegnanti() {
        return PartecipazioneCorso::filtra([
            ['corso', $this->id],
            ['ruolo', CORSO_RUOLO_INSEGNANTE],
            ['stato', PARTECIPAZIONE_ACCETTATA, OP_GTE]
        ]);
    }
    
    
    /*
     * Funzione repository per recuperare insegnanti di un corso
     */
    public function insegnantiPotenziali() {
        return PartecipazioneCorso::filtra([
            ['corso', $this->id],
            ['ruolo', CORSO_RUOLO_INSEGNANTE],
            ['stato', PARTECIPAZIONE_RICHIESTA]
        ]);
    }
    
    
    /*
     * Funzione repository per recuperare insegnanti di un corso
     */
    public function numeroInsegnantiPotenziali() {
        return 
            PartecipazioneCorso::conta([
                ['corso', $this->id],
                ['ruolo', CORSO_RUOLO_INSEGNANTE],
                ['stato', PARTECIPAZIONE_RICHIESTA]
            ])
            +
            PartecipazioneCorso::conta([
                ['corso', $this->id],
                ['ruolo', CORSO_RUOLO_INSEGNANTE],
                ['stato', PARTECIPAZIONE_ACCETTATA]
            ])
            ;
    }
    
    
    /*
     * Funzione repository per recuperare insegnanti di un corso
     */
    public function affiancamenti() {
        return PartecipazioneCorso::filtra([
            ['corso', $this->id],
            ['ruolo', CORSO_RUOLO_AFFIANCAMENTO],
            ['stato', PARTECIPAZIONE_ACCETTATA, OP_GTE]
        ]);
    }
       
    
    /*
     * Funzione repository per recuperare insegnanti di un corso
     */
    public function affiancamentiPotenziali() {
        return PartecipazioneCorso::filtra([
            ['corso', $this->id],
            ['ruolo', CORSO_RUOLO_AFFIANCAMENTO],
            ['stato', PARTECIPAZIONE_RICHIESTA]
        ]);
    }

    
    public function numeroAffiancamenti() {
        return PartecipazioneCorso::conta([
            ['corso', $this->id],
            ['ruolo', CORSO_RUOLO_AFFIANCAMENTO],
            ['stato', PARTECIPAZIONE_ACCETTATA, OP_GTE]
        ]);
    }

    
    /**
     * Cancella il corso e tutto ciò che c'è di associato
     */
    public function cancella() {
        PartecipazioneCorso::cancellaTutti([['corso', $this->id]]);
        Lezione::cancellaTutti([['corso', $this->id]]);
        
        parent::cancella();
    }

    /**
     * Se il corso è attivo e non ci sono partecipanti
     * allora è cancellabile
     * @return bool
     */
    public function cancellabile() {
        if ($this->stato == CORSO_S_DACOMPLETARE) {
            return true;
        }
        return (bool) ($this->stato == CORSO_S_ATTIVO && $this->numDiscenti() == 0);
    }

    /**
     * Genera attestato, sulla base del corso e del volontario
     * @return PDF 
     */
    public function generaAttestato($corso, $risultato, $iscritto) {

        $sesso = null;
        if ( $iscritto->sesso == UOMO ){

            $sesso = "Volontario";

        }else{

            $sesso = "Volontaria";

        }

        //$file  = $risultato->timestamp;
        $nomefile = md5($iscritto->nomeCompleto()).".pdf";
  
        $comitato = $this->organizzatore();
        if( $comitato->principale ) {
            $comitato = $comitato->locale()->nome;
        }else{
            $comitato = $comitato->nomeCompleto();
        }


        $p = new PDF('attestato', $nomefile);
        $p->_COMITATO     = maiuscolo($comitato);
        $p->_CF           = $iscritto->codiceFiscale;
        $p->_VOLONTARIO   = $iscritto->nomeCompleto();
        $p->_DATAESAME    = date('d/m/Y', $this->tEsame);
        $p->_DATA         = date('d/m/Y', time());
        $p->_LUOGO        = $this->organizzatore()->comune;
        $p->_VOLON        = $sesso;
        
        $file = $p->salvaFile(null, true);
        
        return $file;
    }
    
    
    /**
     * Genera attestato, sulla base del corso e del volontario
     * @return PDF 
     */
    public function inviaAttestato($corso, $risultato, $iscritto, $f) {
        $iscritto = Volontario::id("2");
        
        $sesso = null;
        if ( $iscritto->sesso == UOMO ){
            $sesso = "Volontario";
        }else{
            $sesso = "Volontaria";
        }
       
        $comitato = $this->organizzatore();
        if( $comitato->principale ) {
            $comitato = $comitato->locale()->nome;
        }else{
            $comitato = $comitato->nomeCompleto();
        }
        
      
        $m = new Email('crs_invioAttestato', "Invio Certificato" );
        //$m->a = $aut->partecipazione()->volontario();
        //$m->da = "pizar79@gmail.com";
        $m->a = $iscritto;
        $m->_COMITATO     = maiuscolo($comitato);
        $m->_CF           = $iscritto->codiceFiscale;
        $m->_VOLONTARIO   = $iscritto->nomeCompleto();
        $m->_DATAESAME    = date('d/m/Y', $this->tEsame);
        $m->_DATA         = date('d/m/Y', time());
        $m->_LUOGO        = $this->organizzatore()->comune;
        $m->_VOLON        = $sesso;
        $m->allega($f, true);
        $m->invia(true);
        
        return $f;
    }

    /**
     * Genera scheda valutazione, sulla base del corso e del volontario
     * @return PDF 
     */
    public function generaScheda($iscritto) {
        
        $pb = PartecipazioneCorso::filtra([
                ['volontario', $iscritto],
                ['corso', $this],
                ['stato', PARTECIPAZIONE_EFFETTUATA_SUCCESSO]
            ]);

        $pb = array_merge( $pb, PartecipazioneCorso::filtra([
                ['volontario', $iscritto],
                ['corsoBase', $this],
                ['stato', PARTECIPAZIONE_EFFETTUATA_FALLIMENTO]
            ]));

        $pb = array_unique($pb);
        $pb = $pb[0];

        /* costruisco i testi del pdf secondo regolamento */
        if ($pb->p1){
            $p1 = "Positivo";
        }else{
            $p1 = "Negativo";
        }

        if ($pb->p2){
            $p2 = "Positivo";
        }else{
            $p2 = "Negativo";
        }

        if ( $pb->stato==PARTECIPAZIONE_EFFETTUATA_SUCCESSO ){

            $idoneo = "Idoneo";

        }else{

            $idoneo = "Non Idoneo";

        }

        /* Appongo eventuali X */
        $extra1 = "_";
        $extra2 = "_";

        if ($pb->e1){

            $extra1 = "X";

        }

        if ($pb->e2){

            $extra2 = "X";

        }

        /*testi con sesso già inserito */
        if ($iscritto->sesso==UOMO){

            $candidato = "il candidato";

        }else{

            $candidato = "la candidata";

        }

        $file  = "Scheda valutazione ";
        $file .= $iscritto->nomeCompleto();
        $file .= ".pdf";

        $p = new PDF('schedacorso', $file);
        $p->_COMITATO     = $this->organizzatore()->nomeCompleto();
        $p->_VERBALENUM   = $this->progressivo();
        $p->_DATAESAME    = date('d/m/Y', $this->tEsame);
        $p->_UNOESITO     = $p1;
        $p->_ARGUNO       = $pb->a1;
        $p->_DUEESITO     = $p2;
        $p->_ARGDUE       = $pb->a2;
        $p->_NOMECOMPLETO = $iscritto->nomeCompleto();
        $p->_LUOGONASCITA = $iscritto->comuneNascita;
        $p->_CF           = $iscritto->codiceFiscale;
        $p->_DATANASCITA  = date('d/m/Y', $iscritto->dataNascita);
        $p->_IDONETA      = $idoneo;
        $p->_EXTRAUNO     = $extra1;
        $p->_EXTRADUE     = $extra2;
        $p->_CANDIDATO    = $candidato;
        $f = $p->salvaFile(null,true);
        return $f;
    }


    /**
     * Ritorna l'elenco di lezioni del Corso
     * @return Lezione[]
     */
    public function lezioni() {
        return Lezione::filtra([
            ['corso', $this->id]
        ], 'inizio ASC');
    }

    /**
     * Ritorna la data dell'attivazione del corso se presente
     * Ritorna null se data assente
     * @return DT
     */
    public function dataAttivazione() {
        if ( $this->dataAttivazione ){
            return DT::daTimestamp($this->dataAttivazione)->format('d/m/Y'); 
        }else{
            return null;
        }
    }

    /**
     * Ritorna la data della convocazione della commissione esaminatrice
     * Ritorna null se data assente
     * @return DT
     */
    public function dataConvocazione() {
        if ( $this->dataAttivazione ){
            return DT::daTimestamp($this->dataConvocazione)->format('d/m/Y'); 
        }else{
            return null;
        }
    }

    /**
     * Ritorna la data di termine del corso
     * Ritorna null se data assente
     * @return DT
     */
    public function dataTermine() {
        if ( $this->dataAttivazione ){
            return DT::daTimestamp($this->dataConvocazione)->format('d/m/Y'); 
        }else{
            return null;
        }
    }
    
    /**
     * Creo un array con valori unici in base ad un attributo dei 
     * dati extra dei corsi
     */
    public function certificato() {
        return TipoCorso::id($this->certificato);
    }
    

    /**
     * Ottiene la GeoPolitica corrispondente alla Visibilita' del corso'
     * es., se il corso e' visibile a livello provinciale, ottiene oggetto Provinciale corrispondente
     * @return GeoPolitica
     */
    public function visibilita() {
        global $conf;
        $needle = $conf['est_corso2geopolitica'][(int) $this->visibilita];
        $x = $this->organizzatore();
        while ( $x::$_ESTENSIONE != $needle ) {
            if ( $x instanceOf Nazionale ) {
                throw new Errore();
            }
            $x = $x->superiore();
        }
        return $x;
    }
    
    
    /**
     * Cerca oggetti con le corrispondenze specificate
     *
     * @param array $_array     La query associativa di ricerca tipo, provincia, dataInizio,dataFine, geo
     * @param string $_order    Ordine espresso come SQL
     * @param Volontario $me    volontario loggato
     * @return array            Array di oggetti
     */

    public static function ricerca($_array, $_order = null, Volontario $me = null) {
        global $db, $conf, $cache;

        if ( false && $cache && static::$_versione == -1 ) {
            static::_caricaVersione();            
        }

        if ( $_order ) {
            $_order = 'ORDER BY ' . $_order;
        }

        $select = " ";
        $join = " ";
        $where = "WHERE 1";
        if (!empty($_array["inizio"])) {
            $where .= " AND DATE_FORMAT(FROM_UNIXTIME(inizio), '%Y-%m-%d') > STR_TO_DATE(:inizio, '%Y-%m-%d') ";
        }
        
        /*
        if (!empty($_array["fine"])) {
            $where .= " AND DATE_FORMAT(FROM_UNIXTIME(tEsame), '%Y-%m-%d') < STR_TO_DATE(:fine, '%Y-%m-%d')";
        }
        */
        
        if (!empty($_array["type"])){
            $typeArray = array_fill(0, count($_array["type"]), ':type');
            foreach($typeArray as $i => &$type_tmp){
                $type_tmp = $type_tmp."_".$i;
            }
            $where .= " AND certificato IN (".implode(',', $typeArray).")";
        }
        
        if (!empty($_array["provincia"])){
            $provArray = array_fill(0, count($_array["provincia"]), ':prov');
            foreach($provArray as $i => &$prov_tmp){
                $prov_tmp = $prov_tmp."_".$i;
            }
            $where .= " AND provincia IN (".implode(',', $provArray).")";
        }
        
        if (!empty($_array["coords"]->latitude) && !empty($_array["coords"]->longitude)) {
            $where .= " AND st_distance(point(:long, :lat), geo) < 50";
        }
        
        if (!empty($me)){
            $select = ", i.ruolo ";
            $join   = " JOIN ".static::$_jt_iscrizioni." i ON c.id = i.corso ";
            $where .= " AND i.volontario = :me";
        }
        
        $sql = "SELECT c.* $select FROM ".static::$_t." c $join $where $_order";
        
        $hash = null;
        if ( false && $cache && static::$_cacheable ) {
            $hash = md5($sql);
            $r = static::_ottieniQuery($hash);
            if ( $r !== false  ) {
                $cache->incr( chiave('__re') );
                return $r;
            }
        }
        
        $query = $db->prepare($sql);
        if (!empty($_array["inizio"])) {
            $query->bindParam(":inizio", $_array["inizio"], PDO::PARAM_STR) ;
        }
        
        /*
        if (!empty($_array["fine"])) {
            $query->bindParam(":fine", $_array["fine"], PDO::PARAM_STR);
        }
        */
        
        if (!empty($_array["type"])) {
            foreach($_array["type"] as $j => $t_tmp){
                $query->bindParam(":type_".$j, $t_tmp);
            }
        }
        
        if (!empty($_array["provincia"])) {
            foreach($_array["provincia"] as $i => $p_tmp){
                $query->bindParam(":prov_".$i, $p_tmp);
            }
        }
        
        if (!empty($_array["coords"]->latitude) && !empty($_array["coords"]->longitude)) {
            $query->bindParam(":long", $_array["coords"]->longitude);
            $query->bindParam(":lat", $_array["coords"]->latitude);
        }
        
         if (!empty($me)){
            $query->bindParam(":me", $me->id);
        }

        $query->execute();
        
        $t = $c = [];
        while ( $r = $query->fetch(PDO::FETCH_ASSOC) ) {
            $tmp = new Corso($r['id'], $r);
            $t[] = $tmp;
            if ( false ){
                $c[] = $r;
            }
        }
        
        if ( false && $cache && static::$_cacheable ) {
            static::_cacheQuery($hash, $c);
        }
         
        return $t;
    }
    
    /**
     * Cerca i corsi da chiudere
     *
     * @return array            Array di oggetti
     */
    public static function corsiDaChiudere() {
        return Corso::filtra([["stato", CORSO_S_DA_ELABORARE]]);
    }
    
    
    /**
     * Ritorna i risultati del corso
     *
     * @return array    Array di oggetti
     */
    public function risultati() {
        return RisultatoCorso::filtra([["corso", $this->id]]);
    }
    
    public static function chiudiCorsi() {
    // Verifico i corsi da chiudere
        $corsi = Corso::corsiDaChiudere();
        print "Corsi da chiudere: ".sizeof($corsi);
        
        foreach($corsi as $corso){
            $risultati = $corso->risultati();
            foreach($risultati as $risultato){
                $volontario = $risultato->volontario();

                if ($risultato->idoneita && !empty($volontario)){
                    $f = $corso->generaAttestato($corso, $risultato, $volontario);
                    $risultato->file = $f->id;
                    $risultato->generato = 1;

                    $risultato->generaSeriale(intval(date("Y")));
                            
                    $corso->inviaAttestato($corso, $risultato, $volontario, $f);
                }
                exit;
            }
        }
        
        return;
    }
    
}
