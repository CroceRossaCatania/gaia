<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class ERicerca {

    public
        $risultati      = [],
        $totale         = 0,
        $tempo          = 0.00,
        $mittente       = null,
        $destinatario   = null,
        $pagina         = 1,
        $perPagina      = 10;




    /*
     * Esegue una ricerca fulltext dei volontari all'interno dei comitati
     * specificati, se non specificata una query ritorna un elenco.
     */
    public function esegui() {

        $inizio = microtime(true);

        $query = $this->generaQuery();
        $qRisultati = MEmail::find($query);
        $this->totale = MEmail::count($query);
        $this->pagine = ceil( $this->totale / $this->perPagina );

        $this->risultati = $this->ordinaLimitaQuery($qRisultati);

        $fine = microtime(true);
        $this->tempo = round($fine - $inizio, 6);

        return true;
    }

    private function generaQuery() {

        $mittente       = $this->mittente;
        $destinatario   = $this->destinatario;
        $query          = [];

        if ($mittente) {
            $query = ['mittente' => $mittente];
        } elseif ($destinatario) {
            $query = ['destinatari' => [ 
                        '$elemMatch' => ['id' => $destinatario]
                     ]
            ];
        }

        return $query;
    }

    private function ordinaLimitaQuery($query) {
        $minimo     = ($this->pagina - 1) * $this->perPagina;
        $perPagina  = (int) $this->perPagina;
        $query->sort(['_id' => -1])->skip($minimo)->limit($perPagina);
        return $query;
    }

}
