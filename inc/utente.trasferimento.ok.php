<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['id'];
$c = $_POST['inputComitato'];
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
        redirect('utente.trasferimento&e'); 
        break;
    } 
}
                                     
/*Se non sono appartenente allora avvio la procedura*/

foreach ( $me->storico() as $app ) {
    
    if ($app->attuale()) {
        
        $a = new Appartenenza();
        $a->volontario  = $me->id;
        $a->comitato    = $c;
        $a->stato =     TRASF_INCORSO;
        $a->timestamp = time();
        
        $t = new Trasferimento();
        $t->stato = TRASF_INCORSO;
        $t->appartenenza = $a;
        $t->volontario = $me->id;
        $t->motivo = $m;
        $t->timestamp = time();
        

        $sessione->inGenerazioneTrasferimento = time();
        redirect('presidente.trasferimentoRichiesta.stampa&id=' . $t);
        
        continue;
    }
    
}
                               
