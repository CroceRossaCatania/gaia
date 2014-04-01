<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

ini_set('memory_limit', '512M');

$f = $me->fototessera();

if(!isset($_FILES['fototessera'])) {
    redirect('utente.anagrafica&tesserr');
}

if ($f) {
    try {
        $f->caricaFile($_FILES['fototessera']);
    } catch (Exception $e) {
        redirect('utente.anagrafica&tesserr');

    }
} else {
    $f = new Fototessera();
    $f->utente = $me;
    try {
        $f->caricaFile($_FILES['fototessera']);
    } catch (Exception $e) {
        $f->cancella();
        redirect('utente.anagrafica&tesserr');
    }
    $f->stato = FOTOTESSERA_PENDING;
}

redirect('utente.anagrafica&tessok');
    
