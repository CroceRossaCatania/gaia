<?php

/*
 * ©2014 Croce Rossa Italiana
 */

class Veicolo extends Entita {

	protected static
        $_t     = 'veicoli',
        $_dt    = 'dettagliVeicolo';

    /**
     * Ritorna oggetto volontario che ha dichiarato fuoriuso
     * @return Object Volontatario
     */
    public function pFuoriuso() {
        return Volontario::id($this->pFuoriuso);
    }

     /**
     * Ritorna collocazione attuale
     * @return nome collocazione o testo mancata collocazione
     */
    public function collocazione() {
        foreach ( Collocazione::filtra([['veicolo', $this]]) as $collocazione ){
        	if ( ( $collocazione->fine > time() ) || ( !$collocazione->fine ) ) {
        		return Autoparco::id($collocazione->autoparco)->nome;
        	}
        }

        return "Veicolo non collocato";
    }

    /**
     * Ritorna id fermotecnico se veicolo in fermotecnico
     * @return id fermotecnico se veicolo in fermo tecnico, null se non in fermotecnico
     */
    public function fermoTecnico() {
        return $this->fermotecnico;
    }

    /**
     * Ritorna i dettagli del fermo tecnico
     * @return text
     */
    public function fermoTecnicoDettagli() {
        $fermotecnico = $this->fermotecnico;
        if ( $fermotecnico ){
            $fermotecnico = Fermotecnico::id($fermotecnico);
            if ( $fermotecnico->attuale()){
                return date('d/m/Y H:i', $fermotecnico->inizio);
            }else{
                return "Attivo";
            }
        }elseif( !$fermotecnico ){
            return "Attivo";
        }
    }

    /**
     * Ritorna timestamp ultima revisione veicolo
     * @return timestamp o null
     */
    public function ultimaRevisione() {
        $revisione = Manutenzione::filtra([['veicolo', $this],['tipo', MAN_REVISIONE]], 'tIntervento ASC');
        if ( $revisione ){
            return $revisione[0]->tIntervento;
        }else{
            return $this->primaImmatricolazione;
        }
    }
    
    /**
     * Ritorna timestamp ultima manutenzione veicolo
     * @return timestamp o null
     */
    public function ultimaManutenzione() {
        global $db;
        $q = $db->prepare("
            SELECT
                id
            FROM
                manutenzioni
            WHERE
                veicolo = :veicolo
            AND
                tipo != :tipo
            ORDER BY
                tIntervento DESC");
        $q->bindValue(':tipo', MAN_REVISIONE);
        $q->bindParam(':veicolo', $this);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Manutenzione::id($k[0]);
        }
        if ( $r[0] ){
            return $r[0]->tIntervento;
        }else{
            return $this->primaImmatricolazione;
        }
    }
}