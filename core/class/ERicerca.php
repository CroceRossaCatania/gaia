<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/**
 * Rappresenta una ricerca/elenco sull'archivio della posta
 */
class ERicerca {

    public
        $risultati      = [],
        $totale         = 0,
        $tempo          = 0.00,          
        $direzione      = POSTA_INGRESSO,       // POSTA_INGRESSO, POSTA_USCITA
        $casella        = null,                 // Casella (id utente), null = tutta
        $pagina         = 1,
        $perPagina      = 10,

        // Ordine di default: timestamp decrescente
        // ref. http://docs.mongodb.org/manual/reference/object-id/
        $ordine         = 'timestamp DESC';


    /**
     * Esegue una ricerca fulltext dei volontari all'interno dei comitati
     * specificati, se non specificata una query ritorna un elenco.
     */
    public function esegui() {
        global $db;
        $inizio = microtime(true);

        $query = $this->generaQuery();

        $offset = max((($pagina - 1) * $perPagina), 0);
        $perPagina = (int) $this->perPagina;

        $numQ = $db->prepare("SELECT COUNT(id) {$query}");
        $risQ = $db->prepare("SELECT * {$query} LIMIT {$offset}, {$perPagina}");
        $numQ->bindValue(':casella', $this->casella);
        $risQ->bindValue(':casella', $this->casella);
        $numQ->execute();
        $risQ->execute();
        $numQ = $numQ->fetch(PDO::FETCH_NUM);

        $this->totale = (int) $numQ[0];

        $pagine = ceil( $this->totale / $this->perPagina );
        if($pagine == 0) {
            $pagine = 1;
        } 

        $this->pagine = $pagine;

        $r = [];
        while ( $ris = $risQ->fetch(PDO::FETCH_ASSOC) ) {
            $x = new MEmail($ris['id'], $ris);
            $r[] = $x->toJSON(
                    $this->direzione == POSTA_USCITA
                ?   false
                :   $this->casella
            );
        }
        $this->risultati = $r;

        $fine = microtime(true);
        $this->tempo = round($fine - $inizio, 6);
        return true;
    }

    private function generaQuery() {

        // Caso posta globale (casella null)
        if ($this->casella == null)
            return false;

        // POSTA IN INGRESSO
        if ($this->direzione == POSTA_USCITA)
            return "FROM email WHERE mittente_id = :casella";

        // POSTA IN USCITA
        else
            return "FROM email WHERE id IN (SELECT email FROM email_destinatari WHERE dest = :casella)";
    
    }



}
