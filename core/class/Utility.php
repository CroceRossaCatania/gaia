<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Utility {
    
    public static function elencoByAttributoDiCorso($attributo) {
        global $db;
        $list = array();
        
        $query = $db->prepare("
           SELECT DISTINCT valore FROM dettagliCorsi WHERE nome = :attributo
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

    public static function elencoProvincie() {
        $list = Utility::elencoByAttributoDiComitato("provincia");
        return $list;
    }
    
    
     public static function elencoTipologieCorsi() {
        $list = Utility::elencoByAttributoDiCorso("tipo");
        return $list;
    }

}
