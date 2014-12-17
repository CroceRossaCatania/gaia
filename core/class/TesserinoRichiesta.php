<?php

/*
 * ©2012 Croce Rossa Italiana
 * 
 */

class TesserinoRichiesta extends Entita {
    
    protected static
        $_t     = 'tesserinoRichiesta',
        $_dt    = null;

    use EntitaCache;

    public function data() {
        return DT::daTimestamp($this->tRichiesta);
    }

    public function dataUltimaLavorazione() {
        return DT::daTimestamp($this->timestamp);
    }

    public function struttura() {
        return GeoPolitica::daOid($this->struttura);
    }

    public function utente() {
        return Utente::id($this->volontario);
    }

    /**
     * Genera il nuovo tesserino su base della richiesta
     * Nota: necessaria fototessera
     * @return bool(false)|File     Il tesserino del volontario, o false in caso di fallimento
     */
    public function generaTesserino() {
        $utente = $this->utente();

        // Verifica l'assegnazione di un codice al tesserino
        if ( !$this->haCodice() ){
            $codice = $this->assegnaCodice();
        }else{
            $codice = $this->codice;
        }

        if (!$utente->fototessera() || $utente->fototessera()->stato == FOTOTESSERA_PENDING)
            return false;

        $f = new PDF('tesserini', "Tesserino_{$codice}.pdf");
        $f->formato         =  'cr80';
        $f->orientamento    = ORIENTAMENTO_ORIZZONTALE;
        $f->_NOME           = $utente->nome;
        $f->_COGNOME        = $utente->cognome;
        $f->_CODICEFISCALE  = $utente->codiceFiscale;
        $f->_COMITATO       = $utente->unComitato()->locale()->formattato;

        $int = "Croce Rossa Italiana<br />{$utente->unComitato()->locale()->nome}";
        $f->_INTESTAZIONE = $int;
        
        $volontario = 'VOLONTARIA';
        if ( $utente->sesso == UOMO )
            $volontario = 'VOLONTARIO';
        $f->_VOLONTARIO = $volontario;

        $f->_AVATAR     = $utente->fototessera()->file(80);
        $f->_INGRESSO   = $utente->ingresso()->format('d/m/Y');
        $f->_CODICE     = $codice;
        $scadenza = $this->timestamp + (5 * ANNO);
        $f->_SCADENZA   = date('m/Y', $scadenza);

        $barcode = new Barcode;
        $barcode->genera($codice);

        $f->_BARCODE    = $barcode->percorso();

        return $f->salvaFile();
    }

    /**
     * Genera il nuovo tesserino per il socio ordinario sulla base della richiesta
     * @return bool(false)|File     Il tesserino del volontario, o false in caso di fallimento
     */
    public function generaTesserinoOrdinario() {
        $utente = $this->utente();

        // Verifica l'assegnazione di un codice al tesserino
        if ( !$this->haCodice() ){
            $codice = $this->assegnaCodice();
        }else{
            $codice = $this->codice;
        }

        $f = new PDF('tesseriniordinari', "Tesserino_{$codice}.pdf");
        $f->formato         =  'cr80';
        $f->orientamento    = ORIENTAMENTO_ORIZZONTALE;
        $f->_NOME           = $utente->nome;
        $f->_COGNOME        = $utente->cognome;
        $f->_CODICEFISCALE  = $utente->codiceFiscale;
        $f->_COMITATO       = $utente->unComitato(MEMBRO_ORDINARIO)->locale()->formattato;

        $int = "Croce Rossa Italiana<br />{$utente->unComitato(MEMBRO_ORDINARIO)->locale()->nome}";
        $f->_INTESTAZIONE = $int;
        
        $socio = 'SOCIA';
        if ( $utente->sesso == UOMO )
            $socio = 'SOCIO';
        $f->_SOCIO = $socio;

        $f->_INGRESSO   = $utente->ingresso()->format('d/m/Y');
        $f->_CODICE     = $codice;
        $scadenza = $this->timestamp + (5 * ANNO);
        $f->_SCADENZA   = date('m/Y', $scadenza);

        $barcode = new Barcode;
        $barcode->genera($codice);

        $f->_BARCODE    = $barcode->percorso();

        return $f->salvaFile();
    }

    /**
     * Controlla se il tesserino ha un codice assegnato
     * @return bool
     */
    public function haCodice() {
        return (bool) $this->codice;
    }

    /**
     * Genera un nuovo codice e lo salva sulla richiesta tesserino
     * Disclaimer: SOVRASCRIVE EVENTUALI CODICI PRESENTI!
     * @return string Codice generato
     */
    public function assegnaCodice() {
        $nuovoCodice = avvolgiCodicePubblico(
            rand(10000000, 99999999)
        );
        if ( static::by('codice', $nuovoCodice) )
            $this->assegnaCodice();
        $this->codice = $nuovoCodice;
        return $this->codice;
    }

    /**
     * Controlla se la pratica di generazione del tesserino è aperta
     * @return bool Stato della pratica
     */
    public function praticaAperta() {
        return (bool) ($this->stato == RICHIESTO || $this->stato == STAMPATO);
    }

    /**
     * Controlla se la pratica di generazione del tesserino per soci ordinari è aperta
     * @return bool Stato della pratica
     */
    public function praticaApertaOrdinario() {
        if (($this->stato == RICHIESTO || $this->stato == STAMPATO) && $this->utente()->ultimaAppartenenza(MEMBRO_ORDINARIO)){
            return true;
        }else{
            return false;
        }
    }

     /**
     * Controlla se un tesserino è valido
     * @return bool Stato del tesserino
     */
    public function valido() {
        if (!$this->haCodice()) {
            return false;
        }
        if($this->stato < STAMPATO) {
            return false;
        }
        if($this->stato > SPEDITO_COMITATO) {
            return false;
        }
        if(!$this->utente()) {
            return false;
        }
        return true;
    }

}
