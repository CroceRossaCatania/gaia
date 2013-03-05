<?php

paginaPrivata();

$t = $_POST['tipo'];
$f = $_FILES['file'];

/* Qual è il vecchio documento? */
$prec = $me->documento($t);

try {
    $d = new Documento();
    $d->volontario = $me->id;
    $d->tipo = $t;
    $d->caricaFile($f);
} catch (Exception $e) {
    $d->cancella();
    redirect('documenti&err');
}

/* Cancella il vecchio documento... */
if ( $prec ) {
    $prec->cancella();
}

redirect('documenti&ok');