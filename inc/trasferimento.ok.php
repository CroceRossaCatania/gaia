<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['id'];
$c = $_POST['inputComitato'];

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
                redirect('trasferimento&e');  
                                 } 
                                     }
                                     
/*Se non sono appartenente allora avvio la procedura*/

foreach ( $me->storico() as $app ) {
                            if ($app->attuale()) {
                                                    $f = new Appartenenza($app);
                                                    $f->timestamp = time();
                                                    $a = new Appartenenza();
                                                    $a->volontario  = $me->id;
                                                    $a->comitato    = $c;
                                                    $a->stato =     '6';
                                                    $a->timestamp = time();
                                                    redirect('trasferimento&ok');
                                                             }
                                                            }
                               

                                      
?>



