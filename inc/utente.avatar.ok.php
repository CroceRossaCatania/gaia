<?php

/*
 * ©2013 Croce Rossa Italiana
 */
ini_set('memory_limit', '512M');

$a = $me->avatar();

try {
    $a->caricaFile($_FILES['avatar']);
} catch (Exception $e) {
    redirect('utente.anagrafica&aerr');

}

    redirect('utente.anagrafica&aok');


