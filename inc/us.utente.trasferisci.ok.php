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
        redirect('us.utente.trasferisci&e'); 
        break;
    } 
}
                                     
/*Se non sono appartenente allora avvio la procedura*/

foreach ( $t->storico() as $app ) {
    
    if ($app->attuale()) {
        
        $a = new Appartenenza();
        $a->volontario  = $t;
        $a->comitato    = $c;
        $a->stato =     TRASF_INCORSO;
        $a->timestamp = time();
        $a->inizio    = time();
        
        $x = new Trasferimento();
        $x->stato = TRASF_INCORSO;
        $x->appartenenza = $a;
        $x->volontario = $t;
        $x->motivo = $m;
        $x->timestamp = time();
        $x->cProvenienza = $t->unComitato()->id;
        
        redirect('us.dash&trasfok');

    }
    
}
                               
