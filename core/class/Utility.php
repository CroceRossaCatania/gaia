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
        
        switch (strtolower($ruolo)){

            case 'docente': return '#ffff00';
            case 'istruttore': return '#ff00ff';
            case 'formatore': return '#00ffff';
            default : return '#cccccc';
        }
        
    }
}
