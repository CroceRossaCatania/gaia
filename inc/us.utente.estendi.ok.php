<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

$t = $_POST['inputVolontario'];
$t = new Volontario($t);
$c = $_POST['inputComitato'];

if ( !$c ) {
    redirect('us.utente.trasferisci&c');
}

$c = new Comitato($c);
$m = $_POST['inputMotivo'];

/* Cerco appartenenze al comitato specificato */
$f = Appartenenza::filtra([
  ['volontario',    $t],
  ['comitato',      $c]
]);

/* Se sono già appartenente *ora*,
 * restituisco errore
 */

foreach ( $f as $app ) {
    if ($app->attuale()) { 
        redirect('us.utente.trasferisci&gia'); 
    } 
}
                                     
/*Se non sono appartenente allora avvio la procedura*/

$a = new Appartenenza();
$a->volontario  = $t->id;
$a->comitato    = $c;
$a->stato =     MEMBRO_EST_PENDENTE;
$a->timestamp = time();
$a->inizio    = time();
$a->fine      = time() + ANNO;

        
$e = new Estensione();
$e->stato = EST_INCORSO;
$e->appartenenza = $a;
$e->volontario = $t->id;
$e->motivo = $m;
$e->timestamp = time();
$e->cProvenienza = $t->unComitato()->id;

redirect('us.dash&estok');



                               
