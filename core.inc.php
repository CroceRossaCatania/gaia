<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/*
 * Carica tutta la configurazione e le librerie
 */

/* Imposto l'autoloader delle classi */
require_once 'core/libs/autoloader.php';
spl_autoload_register('_gaia_autoloader');

$_load = ['conf', 'libs'];
foreach ( $_load as $_directory ) {
    $_dir   = "core/{$_directory}/";
    $_files = scandir($_dir);
    $_files = array_diff($_files, ['.', '..']);
    foreach ( $_files as $_file ) {
        $_file = $_dir . $_file;
        if ( is_dir($_file) ) { continue; }
        require_once $_file;
    }
}


if ( empty($conf) )
    die("ERRORE: La configurazione di Gaia non e\' stata caricata.\n");

/* Mostra errori */
ini_set('display_errors', (int) $conf['debug']);
error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);

/* Imposta il timezone */
date_default_timezone_set($conf['timezone']);

