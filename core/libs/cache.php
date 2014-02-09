<?php

/*
 * (c)2014 Croce Rossa Italiana
 */

/* Connetto alla cache */
if (!class_exists('Redis') )
    die("ERRORE: Estensione PHP per Redis non disponibile.\n");

$cache = new Redis();
$cache->pconnect($conf['redis']['host']);
