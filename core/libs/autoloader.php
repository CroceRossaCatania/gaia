<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

function _gaia_autoloader($_class) { 
    if ( is_readable ( './core/class/' . $_class . '.php' ) ) {
        require_once './core/class/' . $_class . '.php';
        return true;
    } else {
        return false;
    }
}