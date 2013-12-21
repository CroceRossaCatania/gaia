<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

if(!isset($_GET['id'])) {
    redirect('presidente.appartenenzepending&err');
}
$id     = $_GET['id'];
$a      = Appartenenza::id($id);

if ( isset($_GET['si']) ) {
    
    $a->conferma($me);   

    $m = new Email('appartenenzacomitato', 'Conferma appartenenza: ' . $a->comitato()->nome);
    $m->da = $me; 
    $m->a = $a->volontario();
    $m->_NOME       = $a->volontario()->nome;
    $m->_COMITATO   = $a->comitato()->nomeCompleto();
    $m->invia();
    
    redirect('presidente.appartenenzepending&app');
    
} elseif (isset($_GET['no'])) {

    $a->nega($me);

    $m = new Email('negazionecomitato', 'Negazione appartenenza: ' . $a->comitato()->nome);
    $m->da = $me; 
    $m->a = $a->volontario();
    $m->_NOME       = $a->volontario()->nome;
    $m->_COMITATO   = $a->comitato()->nomeCompleto();
    $m->invia();
    
    redirect('presidente.appartenenzepending&neg');
} 
redirect('presidente.appartenenzepending&err');

?>
