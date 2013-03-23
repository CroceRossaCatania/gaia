<?php

/*
 * ©2012 Croce Rossa Italiana
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
        redirect('trasferimento&e'); 
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
        
        $m = new Email('richiestaTrasferimento', 'Richiesta trasferimento: ' . $t->comitato()->nome);
        $m->a = $me;
        $m->_NOME       = $me->nome;
        $m->_COMITATO   = $t->comitato()->nome;
        $m-> _TIME = date('d-m-Y', $t->timestamp);
        $m->invia();
        redirect('trasferimento&ok');
        
        continue;
    }
    
}
                               
