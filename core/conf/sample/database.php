<?php
 
/*
 * ©2012 Croce Rossa Italiana
 */

/*
 * === INSTALLAZIONE DI GAIA ===
 * Questa è una configurazione di esempio per Gaia.
 * 1. Copiare il file in /core/conf/database.conf.php.
 * 2. Modificare DATABASE_NAME, DATABASE_USER e DATABASE_PASSWORD.
 */
 
/* Configurazione del database */
$conf['database'] = [
 
    'dns'   =>  'mysql:host=127.0.0.1;dbname=DATABASE_NAME',
    'user'  =>  'DATABASE_USER',
    'pass'  =>  'DATABASE_PASSWORD',
    
    /* Connessione persistente? */
    'persistent'    =>  false
 
];