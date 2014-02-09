<?php

/*
 * (c)2014 Croce Rossa Italiana
 */

// CONNESSIONE AL DATABASE MYSQL

try {
    $db = new ePDO(
            $conf['database']['dns'],
            $conf['database']['user'],
            $conf['database']['pass'],
            [
                PDO::ATTR_PERSISTENT => 
                    $conf['database']['persistent']
            ]
    );
} catch ( PDOException $e ) {
    throw new Errore(1900);
}


// CREAZIONE HASH DATABASE

$conf['db_hash'] = substr( md5($conf['database']['dns']), 2, 8) . ':';
