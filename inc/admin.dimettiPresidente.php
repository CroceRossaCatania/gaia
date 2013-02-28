<?php

/*
 * ©2012 Croce Rossa Italiana
 */

$t = $_GET['id'];
$f = new Appartenenza($t);
$f->fine = time();
$a = new Appartenenza();
$a->volontario  = $f->volontario()->id;
$a->comitato    = $f->comitato()->id;
$a->inizio      = time();
$a->fine        = strtotime('April 31');
$a->stato =     MEMBRO_VOLONTARIO;
$a->conferma =  $me->id;
$a->timestamp = time();

redirect('admin.Presidenti&ok');

?>