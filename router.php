<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/*
 * [SVILUPPO]
 * Script di routing.
 * Delega index.php se il file non esiste.
*/

$file = $_SERVER['REQUEST_URI'];
$file = explode('?', $file);
$file = trim($file[0], '/');

if ( is_readable($file) ) {
    /*
     * Ritornando falso, il server cercherà il file.
     */
    return false;
} else {
    require 'index.php';
}
