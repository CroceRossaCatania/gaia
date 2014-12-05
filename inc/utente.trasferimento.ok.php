<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
richiediComitato();

$parametri = array('inputComitato', 'inputMotivo');
controllaParametri($parametri);

$c   = $_POST['inputComitato'];

$gia = Trasferimento::filtra([['volontario', $me],['stato', TRASF_INCORSO]]);
if ( !$c ) { 
    redirect('utente.trasferimento');
}

if ( $gia ){ 
    redirect('utente.trasferimento&gia');
}

$m = $_POST['inputMotivo'];

/* Cerco appartenenze al comitato specificato */
$f = Appartenenza::filtra([
  ['volontario',    $me],
  ['comitato',      $c],
  ['stato', MEMBRO_VOLONTARIO]
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
        $a->volontario  = $me;
        $a->comitato    = $c;
        $a->stato =     TRASF_INCORSO;
        $a->timestamp = time();
        $a->inizio    = time();
        
        $t = new Trasferimento();
        $t->stato = TRASF_INCORSO;
        $t->appartenenza = $a;
        $t->volontario = $me;
        $t->motivo = $m;
        $t->timestamp = time();
        $t->cProvenienza = $me->unComitato()->id;
        

        $sessione->inGenerazioneTrasferimento = time();
        redirect('presidente.trasferimentoRichiesta.stampa&id=' . $t);
        
        continue;
    }
    
}
                               