<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

ini_set('memory_limit', '512M');

$a = $_GET['id'];
$u = Volontario::id($a);
$v = $u->fototessera();

if(!isset($_FILES['fototessera'])) {
    redirect('presidente.utente.visualizza&tesserr&id=' . $a);
}

if ($v) {
    try {
        $v->caricaFile($_FILES['fototessera']);
    } catch (Exception $e) {
        redirect('presidente.utente.visualizza&tesserr&id=' . $a);

    }
} else {
    $v = new Fototessera();
    $v->utente = $u;
    try {
        $v->caricaFile($_FILES['fototessera']);
    } catch (Exception $e) {
        $v->cancella();
        redirect('presidente.utente.visualizza&tesserr&id=' . $a);
    } 
}

redirect('presidente.utente.visualizza&tessok&id=' . $a);
    
