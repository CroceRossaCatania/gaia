<?php

/*
 * ©2012 Croce Rossa Italiana
 */

$t = $_GET['id'];
$c = $_POST['inputComitato'];

/* Cerco appartenenze allo stesso comitato */
$f = Appartenenza::filtra([
  ['volontario',    $t],
  ['comitato',      $c]
]);

/* Se sono già appartenente *ora*,
 * termino l'appartenenza vecchia!
 */
foreach ( $f as $_f ) {
    if ( $_f->attuale() ) {
        $_f->fine = time();
    }
}

/* Creo la nuova appartenenza... */
$a = new Appartenenza();
$a->comitato    = $c;
$a->inizio      = time();
$a->fine        = strtotime('April 31');
$a->stato       = MEMBRO_PRESIDENTE;
$a->conferma    = $me->id;
$a->timestamp   = time();

redirect('admin.Presidenti&new');
