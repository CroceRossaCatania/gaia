<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_CO , APP_PRESIDENTE]);

$parametri = array('v', 't');
controllaParametri($parametri, 'co.attivita&err');

$t = $_GET['t'];
$v = $_GET['v'];
    
if (isset($_GET['monta'])) {
    $c = new Coturno();
    $v = Volontario::id($v);
    $c->volontario = $v;
    $c->appartenenza = $v->unComitato();
    $c->turno = $t;
    $c->pMonta = $me;
    $c->monta();
    
redirect('co.attivita&monta');  
}

if (isset($_GET['smonta'])) {
    $c = Coturno::filtra([['volontario', $v],['turno',$t]]);
    $c = Coturno::id($c[0]);
    $c->volontario = $v;
    $c->pSmonta = $me;
    $c->smonta();
    
redirect('co.attivita&smonta');  
}

redirect('co.attivita&err');

?>