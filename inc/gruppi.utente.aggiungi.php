<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
$id = $_GET['id'];
$g = new Gruppo ($id);
foreach ( $_POST['volontari'] as $v ) {
    
    $v = new Volontario($v);
    $gp = AppartenenzaGruppo::filtra([['volontario',$v],['gruppo',$g->id],['fine', NULL]]);
    if ( $gp ) { continue; }
    
    $t = new AppartenenzaGruppo();
    $t->volontario = $v;
    $t->comitato = $g->comitato();
    $t->gruppo = $g;
    $t->inizio      = time();
    $t->timestamp   = time();
    
    $m = new Email('aggiuntogruppo', "Aggiunto al gruppo di lavoro  {$g->nome}");
    $m->a               = $v;
    $m->da              = $me;
    $m->_NOME           = $v->nomeCompleto();
    $m->_GRUPPO         = $g->nome;
    $m->_REFERENTE      = $g->referente()->nomecompleto();
    $m->_CELLREFERENTE  = $g->referente()->cellulare();
    $m->invia();
    
}

redirect("gruppi.dash");