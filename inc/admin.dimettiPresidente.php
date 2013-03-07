<?php

/*
 * ©2012 Croce Rossa Italiana
 */

$t = $_GET['id'];
$f = new Appartenenza($t);
$f->fine = time();

if ( Appartenenza::filtra([
    ['volontario',  $f->volontario],
    ['comitato',    $f->comitato],
    ['fine',        $f->inizio]
])) {
    $a = new Appartenenza();
    $a->comitato    = $f->comitato;
    $a->stato       = MEMBRO_VOLONTARIO;
    $a->inizio      = time(); 
    $a->fine        = PROSSIMA_SCADENZA;
    $a->conferma    = $me->id;
    $a->timestamp   = time();
}

redirect('admin.Presidenti&ok');
