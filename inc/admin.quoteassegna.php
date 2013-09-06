<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$elenco = Quota::elenco();

foreach ( $elenco as $quota ){
        $data = date('d/m/Y', $quota->timestamp);
        $anno = date('Y', $quota->timestamp);
        $quota->anno = $anno;
        echo('Quota pagata il: '.$data.' anno di riferimento inserito : '.$quota->anno.'<br>');
}


