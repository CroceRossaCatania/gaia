<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Utility {

    
    /**
     * Creo un array con valori unici in base ad un attributo dei 
     * dati extra dei corsi
     */
    public static function elencoByAttributoDiCorso($attributo) {
        global $db;
        $list = array();

        $query = $db->prepare("
           SELECT DISTINCT valore FROM dettagliCorsi WHERE nome = :attributo WHERE valore != '' ORDER BY valore ASC
        ");

        $query->bindParam(':attributo', $attributo);
        $query->execute();
        while ($row = $query->fetch(PDO::FETCH_NUM)) {
            array_push($list, $row[0]);
        }
        return $list;
    }

    /**
     * Creo un array con valori unici in base ad un attributo dei 
     * dati extra dei comitati
     */
    public static function elencoByAttributoDiComitato($attributo) {
        global $db;
        $list = array();

        $query = $db->prepare("
            SELECT DISTINCT valore
                FROM (
                    SELECT valore FROM datiProvinciali WHERE nome = :attributo
                    UNION
                    SELECT valore FROM datiRegionali WHERE nome = :attributo
                ) AS tutte_le_provincie
            WHERE valore != ''
                ORDER BY valore ASC;
            ");

        $query->bindParam(':attributo', $attributo);
        $query->execute();
        while ($row = $query->fetch(PDO::FETCH_NUM)) {
            array_push($list, $row[0]);
        }
        return $list;
    }

    /**
     * Prendo l'elenco delle province dai dati di dettaglio dei comitati
     */
    public static function elencoProvincie() {
        $list = Utility::elencoByAttributoDiComitato("provincia");
        return $list;
    }

    /**
     * Prendo l'elenco delle province dai dati di dettaglio dei comitati
     */
    public static function colorByRuolo($ruolo){          
        switch ($ruolo){
            case CORSO_RUOLO_CREATORE: 
                return '#000000';
            case CORSO_RUOLO_DELEGATO_CREATORE: 
                return '#0000ff';
            case CORSO_RUOLO_DIRETTORE: 
                return '#00ff00';
            case CORSO_RUOLO_DOCENTE: 
                return '#00ffff';
            case CORSO_RUOLO_AFFIANCAMENTO: 
                return '#ff0000';
            case CORSO_RUOLO_DISCENTE: 
                return '#ff00ff';     
            default: 
                return '#cccccc';
        } 
    }
    
    /**
     * Prendo l'elenco delle province dai dati di dettaglio dei comitati
     */
    public static function colorByStato($stato){
        switch (strtolower($stato)){
            case CORSO_S_ANNULLATO: 
                return '#ffff00';
            case CORSO_S_DACOMPLETARE: 
                return '#ff00ff';
            case CORSO_S_CONCLUSO: 
                return '#00ffff';
            case CORSO_S_ATTIVO: 
                return '#cccccc';
                
            default: 
                return '#cccccc';
        } 
    }
}
