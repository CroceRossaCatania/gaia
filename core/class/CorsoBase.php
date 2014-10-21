<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/**
 * Rappresenta un Corso Base.
 */
class CorsoBase extends GeoEntita {

    protected static
        $_t  = 'corsibase',
        $_dt = 'dettagliCorsibase';

    /**
     * Genera il codice numerico progressivo del corso sulla base dell'anno attuale
     *
     * @return int|bool(false) $progressivo     Il codice progressivo, false altrimenti 
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
        return (bool) $this->stato == CORSO_S_DACOMPLETARE; 
    }

    /**
     * Ottiene l'elenco di aspiranti nella zona
     * (non deve essere visibile da nessuno!)
     * @return array(Aspirante)
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

    public function modificabileDa(Utente $u) {
        return (bool) (
                $u->id == $this->direttore
            ||  in_array($this, $u->corsiBaseDiGestione())
        );
    }

    public function cancellabileDa(Utente $u) {
        return (bool) in_array($this, $u->corsiBaseDiGestione());
    }

    public function direttore() {
        if ($this->direttore) {
            return Volontario::id($this->direttore);    
        }
        return null;
    }

    public function progressivo() {
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
        $p = PartecipazioneBase::filtra([
            ['corsoBase', $this->id]
            ]);
        foreach($p as $_p) {
            $_p->cancella();
        }
        foreach ( $this->lezioni() as $l ) {
            $l->cancella();
        }
        parent::cancella();

    }

    /**
     * Genera attestato, sulla base del corso e del volontario
     *
     * @return file 
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

        $p = new PDF('attestato', $file);
        $p->_COMITATO     = maiuscolo($this->organizzatore()->nomeCompleto());
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
     *
     * @return file 
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
        $extra1 = null;
        $extra2 = null;

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
     * @return array(Lezione)
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

}