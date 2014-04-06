<?php

/*
 * ©2012 Croce Rossa Italiana
 * 
 */

class TesserinoRichiesta extends Entita {
    
    protected static
        $_t     = 'tesserinoRichiesta',
        $_dt    = null;

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

    /*
     * Genera il nuovo tesserino su base della richiesta
     * Nota: necessariafototessara
     * @return bool(false)|File     Il tesserino del volontario, o false in caso di fallimento
     */
    public function generaTesserino() {
        $utente = $this->utente();

        // Verifica l'assegnazione di un codice al tesserino
        if ( !$this->haCodice() )
            $codice = $this->assegnaCodice();

        if (!$utente->fototessera() || $utente->fototessera()->stato == FOTOTESSERA_PENDING)
            return false;

        $f = new PDF('tesserini', "Tesserino_{$utente->codicePubblico()}.pdf");
        $f->_NOME       = $utente->nome;
        $f->_COGNOME    = $utente->cognome;
        $f->_NASCITA    = date('d/m/y', $utente->dataNascita) .
                          ", {$this->comuneNascita}";

        $int = "Croce Rossa Italiana<br />{$utente->unComitato()->locale()->nome}<br />";
        if ( $utente->sesso == UOMO )
            $int .= 'Volontario';
        else
            $int .= 'Volontaria';
        $f->_INTESTAZIONE = $int;

        $f->_AVATAR     = $utente->fototessera()->file(20);
        $f->_INGRESSO   = $utente->ingresso()->format('d/m/Y');
        $f->_CODICE     = $codice;

        $barcode = new Barcode;
        $barcode->genera($codice);

        $f->_BARCODE    = $barcode->percorso();

        return $f->salvaFile();
    }


    /*
     * Controlla se il tesserino ha un codice assegnato
     * @return bool
     */
    public function haCodice() {
        return (bool) $this->codice;
    }

    /*
     * Genera un nuovo codice e lo salva sulla richiesta tesserino
     * Disclaimer: SOVRASCRIVE EVENTUALI CODICI PRESENTI!
     * @return string Codice generato
     */
    public function assegnaCodice() {
        $this->codice = avvolgiCodicePubblico(
            generaStringaCasuale(
                8,
                DIZIONARIO_NUMERICO,
                function ( $numeri ) {
                    $codice = avvolgiCodicePubblico($numeri);
                    return (bool) static::by('codice', $codice);
                }
            )
        );
        return $this->codice;
    }

    /*
     * Ottiene codice tesserino volontario (codicePubblico) DAMIGLIORARE
     * @return bool(false)|string Codice se presente, alternativamente false
     */
    public function codicePubblico() {
        if ( $this->codicePubblico )
            return $this->codicePubblico;

        // Generazione codice
        $this->codicePubblico = '80142' . rand(1000000, 9999999);
        $this->codicePubblico = $this->codicePubblico . ean_checkdigit($this->codicePubblico);
        return $this->codicePubblico;
    }

}
