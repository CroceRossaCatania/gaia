<?php

/*
 * ©2014 Croce Rossa Italiana
 */

class Veicolo extends Entita {

	protected static
        $_t     = 'veicoli',
        $_dt    = 'dettagliVeicolo';

    use EntitaCache;

    /**
     * Ritorna oggetto volontario che ha dichiarato fuoriuso
     * @return Volontatario
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
        $revisione = Manutenzione::filtra([['veicolo', $this],['tipo', MAN_REVISIONE]], 'tIntervento DESC');
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
                tipo <> :tipo
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

    /**
     * Ritorna i km percorsi dal veicoli estraendoli dai fogli carburante
     * @return Number
     */
    public function kmPercorsi() {
        $ultimokm = Rifornimento::filtra([['veicolo', $this]],'km DESC LIMIT 0,2');
        $primokm  = Rifornimento::filtra([['veicolo', $this]],'km ASC LIMIT 0,2');
        $km       = $ultimokm[0]->km - $primokm[0]->km;
        return $km;
    }

    /**
     * Ritorna consumo medio del veicoli estraendoli dai fogli carburante
     * @return Number
     */
    public function consumoMedio() {
        $rifornimenti = Rifornimento::filtra([['veicolo', $this]],'km DESC');
        if ( count($rifornimenti) > 1 ){
            $litri   = 0;
            $consumo = 0;
            foreach ( $rifornimenti as $rifornimento ){ 
                    $litri    = $litri + $rifornimento->litri;
            }
            $ultimilitri = Rifornimento::filtra([['veicolo', $this]],'km DESC LIMIT 0,2');
            $consumo  = (($litri-$ultimilitri[0]->litri)*100)/$this->kmPercorsi();
        }else{
            $consumo = "<i>Dati non sufficienti</i>";
        }
        return round($consumo,2);
    }

    /**
     * Ritorna true or false se veicolo fuori uso
     * @return True or False
     */
    public function fuoriuso() {
        if ( $this->stato == VEI_FUORIUSO){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Ritorna id ultimo rifornimento
     * @return Rifornimento
     */
    public function ultimoRifornimento() {
        $rifornimento = Rifornimento::filtra([['veicolo', $this]],'km DESC LIMIT 0,2');
        return $rifornimento[0];
    }

    /**
     * Ritorna il rifornimento appena precedente al chilometraggio fornito
     * @param int $km               Chilometraggio
     * @return Rifornimento|false   Il Rifornimento o False se nessuno presente
     */
    public function primaRifornimento($km) {
        global $db;
        $q = $db->prepare("
            SELECT
                id
            FROM
                rifornimento
            WHERE
                veicolo = :veicolo
            AND
                km < :km
            ORDER BY
                km DESC
            LIMIT 0,1");
        $q->bindParam(':km', $km);
        $q->bindParam(':veicolo', $this);
        $q->execute();
        $k = $q->fetch(PDO::FETCH_NUM);
        if ( $k ) {
            return Rifornimento::id($k[0]);
        } else {
            return false;
        }
    }

    /**
     * Ritorna il rifornimento appena successivo al chilometraggio fornito
     * @param int $km               Chilometraggio
     * @return Rifornimento|false   Il Rifornimento o False se nessuno presente
     */
    public function dopoRifornimento($km) {
        global $db;
        $q = $db->prepare("
            SELECT
                id
            FROM
                rifornimento
            WHERE
                veicolo = :veicolo
            AND
                km > :km
            ORDER BY
                km ASC
            LIMIT 0,1");
        $q->bindParam(':km', $km);
        $q->bindParam(':veicolo', $this);
        $q->execute();
        $k = $q->fetch(PDO::FETCH_NUM);
        if ( $k ) {
            return Rifornimento::id($k[0]);
        } else {
            return false;
        }
    }

    /**
     * Valida rifornimento
     * @return true or false se rifornimento valido
     */
    public function validaRifornimento($data, $km) {
        $prima = $this->primaRifornimento($km);
        $dopo  = $this->dopoRifornimento($km);
        return (
            (
                !$prima or  
                ( 
                    $prima and $prima->km <= $km  
                    and $prima->data <= $data 
                )
            ) 
            and
            (
                !$dopo or 
                ( 
                    $dopo and $dopo->km >= $km 
                    and $dopo->data >= $data 
                )
            )
        );
    }

    /**
     * Ritorna comitato
     * @return nome comitato o testo nessun comitato
     */
    public function comitato() {
        $comitato = $this->comitato;
        if ( $comitato ){

            $comitato = GeoPolitica::daOid($comitato);
            return $comitato->nomeCompleto();

        }else{

            return "Nessun Comitato";

        }
    }
}