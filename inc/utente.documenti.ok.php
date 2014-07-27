<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('tipo'));

$t = $_POST['tipo'];
$f = $_FILES['file'];

if(!isset($_FILES['file'])) {
	redirect('utente.documenti&err');
}

/* Qual è il vecchio documento? */
$prec = $me->documento($t);

try {
    $d = new Documento();
    $d->volontario = $me->id;
    $d->tipo = $t;
    $d->caricaFile($f);
} catch (Exception $e) {
    $d->cancella();
    redirect('utente.documenti&err');
}

/* Cancella il vecchio documento... */
if ( $prec ) {
    $prec->cancella();
}

redirect('utente.documenti&ok');