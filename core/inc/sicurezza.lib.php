<?php

/*
 * ©2012 Croce Rossa Italiana
 */

function criptaPassword ( $password ) {
    $password = sha1 ( md5 ( $password ) . '@CroceRossa' );
    return $password;
}

function debugOnly() {
    global $conf;
    if (!$conf['debug']) {
        throw new Errore(1009);
    }
}