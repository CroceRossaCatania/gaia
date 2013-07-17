<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$id     = $_GET['id'];
$a      = new Appartenenza($id); /* Qui col by */

if ( isset($_GET['si']) ) {
    
    $a->timestamp = time();
    $a->stato     = MEMBRO_VOLONTARIO;
    $a->conferma  = $me->id;    
    $m = new Email('appartenenzacomitato', 'Conferma appartenenza: ' . $a->comitato()->nome);
    $m->da = $me; 
    $m->a = $a->volontario();
    $m->_NOME       = $a->volontario()->nome;
    $m->_COMITATO   = $a->comitato()->nomeCompleto();
    $m->invia();
    redirect('presidente.appartenenzepending&app');
    
} elseif (isset($_GET['no'])) {
    
    $m = new Email('negazionecomitato', 'Negazione appartenenza: ' . $a->comitato()->nome);
    $m->da = $me; 
    $m->a = $a->volontario();
    $m->_NOME       = $a->volontario()->nome;
    $m->_COMITATO   = $a->comitato()->nomeCompleto();
    $m->invia();
    
    $a->fine    = time();
    
    redirect('presidente.appartenenzepending&neg');
}