<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['id'];
$g = $_POST['inputGruppo'];

/* Cerco se già iscritto a gruppo */
$g = Appartenenzagruppo::filtra([
  ['volontario',    $t],
  ['gruppo',    $g]
]);

/* Se sono già appartenente *ora*,
 * restituisco errore
 */

foreach ( $g as $app ) {
    if ($app->attuale()) { 
        redirect('utente.gruppo&e'); 
        break;
    } 
}
   
foreach ( $me->storico() as $app ) { 
                         if ($app->attuale()) 
                                    {
                             $c = $app;
                         }
                         } 
                         
/*Se non sono appartenente allora avvio la procedura*/

        $t = new Appartenenzagruppo();
        $t->volontario = $me->id;
        $t->appartenenza = $c;
        $t->gruppo = 1;
        $t->inizio = time();
        $t->timestamp=time();
        
        redirect('utente.gruppo&ok');
