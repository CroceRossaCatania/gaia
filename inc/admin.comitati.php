<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaAdmin();

$id     = $_GET['id'];
$a = Appartenenza::by('id', $id); /* Qui col by */

if (isset($_GET['si'])) {
    $a->timestamp = time();
    $a->stato     = MEMBRO_VOLONTARIO;
    $a->conferma  = $me->id;    
    $m = new Email('appartenenzacomitato', 'Conferma appartenenza: ' . $a->comitato()->nome);
    $m->a = $a->volontario();
    $m->_NOME       = $a->volontario()->nome;
    $m->_COMITATO   = $a->comitato()->nome;
    $m->invia();
}elseif(isset($_GET['no'])){
    $m = new Email('negazionecomitato', 'Negazione appartenenza: ' . $a->comitato()->nome);
    $m->a = $a->volontario();
    $m->_NOME       = $a->volontario()->nome;
    $m->_COMITATO   = $a->comitato()->nome;
    $m->invia();
    $v= $a->volontario()->id;
    $a->cancella();    
    $f = TitoloPersonale::filtra([
    ['volontario', $v]
    ]);
    for ($i = 0, $ff = count($f); $i < $ff;$i++) {
        $f[$i]->cancella();
    }
    $v = new Persona($v);
    $v->cancella();
}
redirect('admin.comitatiPending');