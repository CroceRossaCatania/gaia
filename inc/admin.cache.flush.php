<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

if ( !$cache ) {
    die('Gaia non sta usando la cache.');
}

$cache->flushAll();

redirect('admin.cache&flush');