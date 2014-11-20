<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

ini_set('memory_limit', '512M');

$a = $_GET['id'];
$u = Volontario::id($a);

proteggiDatiSensibili($u, [APP_SOCI, APP_PRESIDENTE]);

$f = $u->fototessera();

if(isset($_GET['ok'])) {
    if($f && !$f->approvata()) {
        $f->approva();
        redirect('presidente.utente.visualizza&tessappr&id=' . $a);
    }
    redirect('presidente.utente.visualizza&err&id=' . $a);
}

if(isset($_GET['no'])) {
    if($f && !$f->approvata()) {
        $f->cancella();
        redirect('presidente.utente.visualizza&tessappr&id=' . $a);
    }
    redirect('presidente.utente.visualizza&err&id=' . $a);
}

if(!isset($_FILES['fototessera'])) {
    redirect('presidente.utente.visualizza&tesserr&id=' . $a);
}

if ($f) {
    try {
        $f->caricaFile($_FILES['fototessera']);
    } catch (Exception $e) {
        redirect('presidente.utente.visualizza&tesserr&id=' . $a);
    }
    redirect('presidente.utente.visualizza&tessok&id=' . $a);
} else {
    $f = new Fototessera();
    $f->utente = $u;
    try {
        $f->caricaFile($_FILES['fototessera']);
    } catch (Exception $e) {
        $f->cancella();
        redirect('presidente.utente.visualizza&tesserr&id=' . $a);
    }
    $f->stato = FOTOTESSERA_OK;
    redirect('presidente.utente.visualizza&tessok&id=' . $a);
}

redirect('presidente.utente.visualizza&err&id=' . $a);
    
