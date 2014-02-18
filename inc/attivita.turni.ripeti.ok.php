<?php

/* 
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$parametri = array('t', 'inputGiorni');
controllaParametri($parametri);

$t = $_GET['t'];
$x = Turno::id($t);
$a = $x->attivita();

paginaAttivita($a);

$volte = $_POST['inputGiorni'];

if ($volte>=16){
    redirect('attivita.turni.ripeti&max&t=' . $x->id);
}
for($i=1; $i<=$volte;$i++){
    $turni = $a->turni();
    $num = count($turni) + 1;
    $t = new Turno();
    $t->attivita    = $a->id;
    $t->nome        = $x->nome;
    $t->minimo      = $x->minimo;
    $t->massimo     = $x->massimo;
    $t->inizio      = strtotime("+$i day", $x->inizio);
    $t->fine        = strtotime("+$i day", $x->fine);
    $t->prenotazione= strtotime("+$i day", $x->prenotazione);
}

redirect('attivita.turni&id=' . $a->id);