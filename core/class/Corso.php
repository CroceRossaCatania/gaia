<?php
/*
 * ©2013 Croce Rossa Italiana
 */
/**
 * Rappresenta un Corso.
 */
class Corso extends GeoEntita {

    protected static
        $_t  = 'corsi',
        $_dt = 'dettagliCorsi';

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

    /*
    public function area()
    {
        return Area::id(5);
    }
    
    public function referente()
    {
        return Volontario::id(3);
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
     * Ritorna la data di inizio del corso base
     * @return DT
     */
    public function inizio() {
    	return DT::daTimestamp($this->inizio);
    }

    /**
     * Ritorna la data di inizio del corso base in epoch time
     * @return int
     */
    public function inizioDate() {
        return $this->inizio;
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
        return $this->finito() && $this->stato == CORSO_S_CONCLUSO; 
    }

    /**
     * Controlla se il corso e' da completare (email non mandata)
     * @return bool
     */
    public function daCompletare() {
        return (bool) ($this->stato == CORSO_S_DACOMPLETARE); 
    }

    /**
     * Ottiene l'elenco di aspiranti nella zona
     * (non deve essere visibile da nessuno!)
     * @return Aspirante[]
     */
    public function potenzialiAspiranti() {
    	return Aspirante::chePassanoPer($this);
    }

    /**
     * Localizza nella sede del comitato organizzatore
     */
    public function localizzaInSede() {
    	$sede = $this->organizzatore()->coordinate();
    	$this->localizzaCoordinate($sede[0], $sede[1]);
    }
    
    /**
     * Restituisce il nome del corso
     * @return string     il nome del corso
     */
    public function nome() {
        return "Corso Base del ".$this->organizzatore()->nomeCompleto();
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
                    }, $u->corsiBaseDiGestione())
                )
        );

    }

    /**
     * Informa se un corso è cancellabile da un determianto utente
     * @return bool 
     */
    public function cancellabileDa(Utente $u) {
        return (bool) contiene($this, $u->corsiBaseDiGestione());
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
     * Restituisce il progressivo del corso in questione, se
     * mancante lo genera
     * @return string|false 
     */
    public function progressivo() {
        if ( !$this->progressivo )
            $this->assegnaProgressivo();
        if($this->progressivo) {
            return 'BASE-'.$this->anno.'/'.$this->progressivo;
        }
        return null;
    }

    /**
     * True se il corso è attivo e non iniziato
     * @return bool     stato del cors
     */
    public function accettaIscrizioni() {
        return (bool) ($this->futuro()
            and $this->stato == CORSO_S_ATTIVO);
    }

    /**
     * Verfica se un utente è iscritto o no al corso
     * @return bool
     */
    public function iscritto(Utente $u) {
        $p = PartecipazioneBase::filtra([
            ['volontario', $u->id],
            ['corsoBase', $this->id]
            ]);
        foreach($p as $_p) {
            if($_p->attiva()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Elenco delle partecipazioni degli iscritti
     * @return PartecipazioneBase elenco delle partecipazioni degli iscritti 
     */
    public function partecipazioni($stato = null) {
        $p = PartecipazioneBase::filtra([
            ['corsoBase', $this->id]
            ]);
        $part = [];
        foreach($p as $_p) {
            if(!$stato && $_p->attiva()) {
                $part[] = $_p;
            } elseif($stato && $_p->stato == $stato) {
                $part[] = $_p;
            }
        }
        return $part;
    }

    /**
     * Elenco degli iscritti ad un corso base
     * @return Utente elenco degli iscritti 
     */
    public function iscritti() {
        $p = PartecipazioneBase::filtra([
            ['corsoBase', $this->id]
            ]);
        $iscritti = [];
        foreach($p as $_p) {
            if($_p->attiva()) {
                $iscritti[] = $_p->utente();
            }
        }
        return $iscritti;
    }

    /**
     * Numero degli iscritti ad un corso base
     * @return int numero degli iscritti 
     */
    public function numIscritti() {
        return count($this->iscritti());
    }

    /**
     * Cancella il corso base e tutto ciò che c'è di associato
     */
    public function cancella() {
        PartecipazioneBase::cancellaTutti([['corsoBase', $this->id]]);
        Lezione::cancellaTutti([['corso', $this->id]]);
        
        parent::cancella();
    }

    /**
     * Se il corso base è attivo e non ci sono partecipanti
     * allora è cancellabile
     * @return bool
     */
    public function cancellabile() {
        if ($this->stato == CORSO_S_DACOMPLETARE) {
            return true;
        }
        return (bool) ($this->stato == CORSO_S_ATTIVO && $this->numIscritti() == 0);
    }

    /**
     * Genera attestato, sulla base del corso e del volontario
     * @return PDF 
     */
    public function generaAttestato($iscritto) {

        $sesso = null;
        if ( $iscritto->sesso == UOMO ){

            $sesso = "Volontario";

        }else{

            $sesso = "Volontaria";

        }

        $file  = "Attestato ";
        $file .= $iscritto->nomeCompleto();
        $file .= ".pdf";
        $comitato = $this->organizzatore();
        if( $comitato->principale ) {
            $comitato = $comitato->locale()->nome;
        }else{
            $comitato = $comitato->nomeCompleto();
        }


        $p = new PDF('attestato', $file);
        $p->_COMITATO     = maiuscolo($comitato);
        $p->_CF           = $iscritto->codiceFiscale;
        $p->_VOLONTARIO   = $iscritto->nomeCompleto();
        $p->_DATAESAME    = date('d/m/Y', $this->tEsame);
        $p->_DATA         = date('d/m/Y', time());
        $p->_LUOGO        = $this->organizzatore()->comune;
        $p->_VOLON        = $sesso;
        $f = $p->salvaFile(null,true);

        return $f;
    }

    /**
     * Genera scheda valutazione, sulla base del corso e del volontario
     * @return PDF 
     */
    public function generaScheda($iscritto) {
        
        $pb = PartecipazioneBase::filtra([
                ['volontario', $iscritto],
                ['corsoBase', $this],
                ['stato', ISCR_SUPERATO]
            ]);

        $pb = array_merge( $pb, PartecipazioneBase::filtra([
                ['volontario', $iscritto],
                ['corsoBase', $this],
                ['stato', ISCR_BOCCIATO]
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

        if ( $pb->stato==ISCR_SUPERATO ){

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

        $p = new PDF('schedabase', $file);
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
     * Ritorna l'elenco di lezioni del Corso Base
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
     * Creo un array con valori unici in base ad un attributo dei 
     * dati extra dei corsi
     */
    public static function getAllCertificati() {
        global $db;
        $list = array();
        
        return Certificato::elenco();
/*
        $query = $db->prepare("SELECT DISTINCT certificato FROM corsi ORDER BY certificato ASC");
        $query->execute();
        while ($row = $query->fetch(PDO::FETCH_NUM)) {
            array_push($list, $row[0]);
        }
        return $list;
*/
    }
    
    /**
     * Cerca oggetti con le corrispondenze specificate
     *
     * @param array $_array     La query associativa di ricerca tipo, provincia, dataInizio,dataFine, geo
     * @param string $_order    Ordine espresso come SQL
     * @return array            Array di oggetti
     */

    public static function ricerca($_array, $_order = null) {
        global $db, $conf, $cache;

        if ( false && $cache && static::$_versione == -1 ) {
            static::_caricaVersione();            
        }

        if ( $_order ) {
            $_order = 'ORDER BY ' . $_order;
        }

        $where = "WHERE 1";
        if (!empty($_array["inizio"])){
            $where .= " AND DATE_FORMAT(FROM_UNIXTIME(inizio), '%Y-%m-%d') > STR_TO_DATE(:inizio, '%Y-%m-%d') ";
        }
        
        if (!empty($_array["fine"])){
            $where .= " AND DATE_FORMAT(FROM_UNIXTIME(tEsame), '%Y-%m-%d') < STR_TO_DATE(:fine, '%Y-%m-%d')";
        }
        
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
        
        if (!empty($_array["coords"]->latitude) && !empty($_array["coords"]->longitude)){
            $where .= " AND st_distance(point(:long, :lat), geo) < 50";
        }

        $sql = "SELECT * FROM ". static::$_t. " $where $_order";   

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
        if (!empty($_array["inizio"])){
            $query->bindParam(":inizio", $_array["inizio"], PDO::PARAM_STR) ;
        }
        
        
        if (!empty($_array["fine"])){
            $query->bindParam(":fine", $_array["fine"], PDO::PARAM_STR);
        }
        
        if (!empty($_array["type"])){
            foreach($_array["type"] as $j => $t_tmp){
                $query->bindParam(":type_".$j, $t_tmp);
            }
        }
        
        if (!empty($_array["provincia"])){
            foreach($_array["provincia"] as $i => $p_tmp){
                $query->bindParam(":prov_".$i, $p_tmp);
            }
        }
        
        if (!empty($_array["coords"]->latitude) && !empty($_array["coords"]->longitude)){
            $query->bindParam(":long", $_array["coords"]->longitude);
            $query->bindParam(":lat", $_array["coords"]->latitude);
        }

        $query->execute();
        
        $t = $c = [];
        while ( $r = $query->fetch(PDO::FETCH_ASSOC) ) {
            $t[] = new Corso($r['id'], $r);
            if ( false ){
                $c[] = $r;
            }
        }
        
        if ( false && $cache && static::$_cacheable ) {
            static::_cacheQuery($hash, $c);
        }
         
        return $t;
    }

}