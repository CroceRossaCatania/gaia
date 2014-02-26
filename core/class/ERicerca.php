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
        $ordine         = [     
            '_id' => -1
        ];

    /**
     * Esegue una ricerca fulltext dei volontari all'interno dei comitati
     * specificati, se non specificata una query ritorna un elenco.
     */
    public function esegui() {
        $inizio = microtime(true);
        $query = $this->generaQuery();
        $qRisultati = MEmail::find($query);
        $qRisultati = $this->ordinaLimitaQuery($qRisultati);
        $this->risultati = mongo2array($qRisultati);
        $this->totale = (int) $qRisultati->count();
        $this->pagine = ceil( $this->totale / $this->perPagina );

        $fine = microtime(true);
        $this->tempo = round($fine - $inizio, 6);
        return true;
    }

    private function generaQuery() {

        // Caso posta globale (casella null)
        if ($this->casella == null)
            return [];

        // POSTA IN INGRESSO
        if ($this->direzione == POSTA_USCITA)
            return ['mittente.id' => (int) $this->casella];

        // POSTA IN USCITA
        else
            return ['destinatari' => [ 
                    '$elemMatch' => ['id' => (int) $this->casella]
                ]
            ];
    
    }

    private function ordinaLimitaQuery($query) {
        $minimo     = ($this->pagina - 1) * $this->perPagina;
        $perPagina  = (int) $this->perPagina;
        $query->sort($this->ordine)->skip($minimo)->limit($perPagina);
        return $query;
    }

}
