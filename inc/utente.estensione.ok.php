<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['id'];
$c = $_POST['inputComitato'];
if ( !$c ) { 
    redirect('utente.estensione');
}
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
        redirect('utente.estensione&e'); 
        break;
    } 
}
                                     
/*Se non sono appartenente allora avvio la procedura*/


        
$a = new Appartenenza();
$a->volontario  = $me->id;
$a->comitato    = $c;
$a->stato =     MEMBRO_EST_PENDENTE;
$a->timestamp = time();
$a->inizio    = time();
$a->fine      = time() + ANNO;

        
$e = new Estensione();
$e->stato = EST_INCORSO;
$e->appartenenza = $a;
$e->volontario = $me->id;
$e->motivo = $m;
$e->timestamp = time();   

$sessione->inGenerazioneEstensione = time();
redirect('presidente.estensioneRichiesta.stampa&id=' . $e);



                               
