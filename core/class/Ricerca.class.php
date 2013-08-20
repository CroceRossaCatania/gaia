<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Ricerca {

    public
        $comitati       = [],
        $risultati      = [],
        $totale         = 0,
        $tempo          = 0.00,
        $query          = null,
        $pagina         = 1,
        $perPagina      = 30,
        $stato          = MEMBRO_VOLONTARIO,
        $ordine         = [
            'pertinenza             DESC',
            'comitati.nome          ASC',
            'anagrafica.cognome     ASC',
            'anagrafica.nome        ASC'
        ];

    private
        $_dominio       = '';

    /*
     * Prepara il dominio di ricerca (elenco di comitati)
     * alla ricerca, eventualmente esplorando comitati
     * locali, provinciali, regionali, nazionali
     */
    private function ottimizzaDominio() {
        if ( !$this->comitati ) {
            $this->_dominio = '*';
            return -1;
        }
        $c = [];
        foreach ( $this->comitati as $comitato ) {
            $c = array_merge($c, $comitato->estensione());
        }
        $this->comitati = array_unique($c);
        $this->_dominio = implode(',', $this->comitati);
        return count($this->comitati);
    }

    /*
     * Esegue una ricerca fulltext dei volontari all'interno dei comitati
     * specificati, se non specificata una query ritorna un elenco.
     */
    public function esegui() {
        global $db;

        $inizio = microtime(true);

        $query = $this->generaQueryNonPreparata();

        $qConta = $this->creaContoQuery($query);
        $qConta = $db->query($qConta);
        $qConta = $qConta->fetch(PDO::FETCH_NUM);
        $this->totale = (int) $qConta[0];

        $this->pagine = ceil( $this->totale / $this->perPagina );

        $qRicerca = $this->ordinaLimitaQuery($query);
        $qRicerca = $db->query($qRicerca);
        $this->risultati = [];
        while ( $k = $qRicerca->fetch(PDO::FETCH_NUM) ) {
            $this->risultati[] = new Volontario($k[0]);
        }

        $fine = microtime(true);
        $this->tempo = round($fine - $inizio, 6);

        return true;
    }

    private function generaQueryNonPreparata() {
        global $db;

        $this->ottimizzaDominio();
        $dominio    = $this->_dominio;
        $query      = $this->query;
        $stato      = (int) $this->stato;
        $ora        = (int) time();

        if ( $dominio == '*' ) {
            $pDominio = '';
        } else {
            $pDominio = "AND appartenenza.comitato IN ({$dominio})";
        }

        if ( $query ) {
            $query = $db->quote($query);
            $pRicerca = " 
                    MATCH(
                        anagrafica.nome,
                        anagrafica.cognome,
                        anagrafica.email,
                        anagrafica.codiceFiscale
                    ) AGAINST ({$query})";
            $pPertinenza = "MAX({$pRicerca}) as pertinenza";
            $pRicerca = "AND {$pRicerca}";
        } else {
            $pPertinenza = "1 as pertinenza";
            $pRicerca = '';
        }

        $query = "
            SELECT
                anagrafica.id, {$pPertinenza}
            FROM
                anagrafica, appartenenza, comitati
            WHERE
                        anagrafica.id           =   appartenenza.volontario
                AND     appartenenza.comitato   =   comitati.id
                AND     appartenenza.stato      =   {$stato}
                AND     appartenenza.inizio     <=  {$ora}
                AND     ( 
                            appartenenza.fine  IS NULL 
                         OR appartenenza.fine  =   0
                         OR appartenenza.fine  >=  {$ora}
                    )
                {$pDominio}
                {$pRicerca}   
            GROUP BY    anagrafica.id

        ";
        return $query;
    }

    private function ordinaLimitaQuery($query) {
        $minimo     = ($this->pagina - 1) * $this->perPagina;
        $perPagina  = (int) $this->perPagina;
        $ordine     = implode(', ', $this->ordine);
        $query .= "
            ORDER BY   {$ordine}
            LIMIT      $minimo, {$perPagina}
        ";
        return $query;
    }

    private function creaContoQuery($query) {
        $s = "SELECT COUNT(*) as Numero FROM ({$query}) as Tabella";
        return $s;
    }

}