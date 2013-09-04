<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['id'];
$g = $_POST['inputGruppo'];
$g = new Gruppo($g);
/* Cerco se già iscritto a gruppo */
$x = AppartenenzaGruppo::filtra([
  ['volontario',    $t],
  ['gruppo',    $g]
]);

/* Se sono già appartenente *ora*,
 * restituisco errore
 */

foreach ( $x as $app ) {
    if ($app->attuale()) { 
        redirect('utente.gruppo&e'); 
        break;
    } 
}
                         
/*Se non sono appartenente allora avvio la procedura*/

$t = new AppartenenzaGruppo();
$t->volontario = $me;
$t->comitato = $g->comitato();
$t->gruppo = $g;
$t->inizio      = time();
$t->timestamp   = time();

redirect('utente.gruppo&ok');
