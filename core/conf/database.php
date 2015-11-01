<?php
 
/*
 * ©2012 Croce Rossa Italiana
 */

/*
 * === INSTALLAZIONE DI GAIA ===
 * Questa è una configurazione di esempio per Gaia.
 * 1. Copiare il file in /core/conf/database.conf.php.
 * 2. Modificare u_pietro1, u_pietro1 e pietro.gaia.7871.
 */
 
/* Configurazione del database  
$conf['database'] = [
    'dns'   =>  'mysql:host=127.0.0.1;dbname=u_pietro1',
    'user'  =>  'u_pietro1',
    'pass'  =>  'pietro.gaia.7871',  
    'persistent'    =>  false
];
 *
 */

$conf['database'] = [ 
    //'dns'   =>  'mysql:host=95.141.44.102;dbname=gaia',
    'dns'   =>  'mysql:host=127.0.0.1;dbname=gaia',
    'user'  =>  'gaia',
    'pass'  =>  'nHcOefCOs7',
    'persistent'    =>  false
];

$conf['database'] = [ 
    'dns'   =>  'mysql:host=127.0.0.1;dbname=gaia',
    'user'  =>  'gaia',
    'pass'  =>  'gaia',
    'persistent'    =>  false
];
