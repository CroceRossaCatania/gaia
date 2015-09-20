<?php


/*
 * ©2013 Croce Rossa Italiana
 */
paginaPubblica();

$filter = array();

$corsi  = Corso::ricerca($filter);
print_r($corsi);
?>