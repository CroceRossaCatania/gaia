<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/* Carico la configurazione */
$_conf = [
    'database', 'smtp', 'costanti', 'sessioni',
    'generale', 'errori', 'autopull', 'captcha'
];

foreach ( $_conf as $_load ) {
    require('./core/conf/' . $_load . '.conf.php');
}

/* Creo hash database */
$conf['db_hash'] = substr( md5($conf['database']['dns']), 2, 8) . ':';

/* Carico le librerie */
$_lib = ['sicurezza', 'stringhe', 'pagine', 'http', 'captcha'];
foreach ( $_lib as $_load ) {
    require('./core/inc/'. $_load .'.lib.php');
}


/* Imposto l'autoloader della classe */
spl_autoload_register(function($_class) { 
    if ( is_readable ( './core/class/' . $_class . '.class.php' ) ) {
        require('./core/class/' . $_class . '.class.php');
        return true;
    } else {
        return false;
    }
});

/* Mostra errori */
ini_set('display_errors', (int) $conf['debug']);
error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);

/* Imposta il timezone */
date_default_timezone_set($conf['timezone']);

/* Connetto alla cache */
if (class_exists('Redis') ) {
    $cache = new Redis();
    $cache->pconnect('127.0.0.1');
}

try {
    /* Connetto al database */
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

