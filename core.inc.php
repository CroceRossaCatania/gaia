<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/*
 * Carica tutta la configurazione e le librerie
 */
$_load = ['conf', 'libs'];
foreach ( $_load as $_directory ) {
    $_dir   = "core/{$_directory}/";
    $_files = scandir($_dir);
    $_files = array_diff($_files, ['.', '..']);
    foreach ( $_files as $_file ) {
        $_file = $_dir . $_file;
        if ( is_dir($_file) ) { continue; }
        require $_file;
    }
}

if ( empty($conf) )
    die("ERRORE: La configurazione di Gaia non e\' stata caricata.\n");

/* Creo hash database */
$conf['db_hash'] = substr( md5($conf['database']['dns']), 2, 8) . ':';

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

