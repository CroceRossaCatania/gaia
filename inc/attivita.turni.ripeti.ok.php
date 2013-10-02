<?php

/* 
 * ©2013 Croce Rossa Italiana
 */

$t = $_GET['t'];
$x = Turno::id($t);
$a = $x->attivita();
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
}

redirect('attivita.turni&id=' . $a->id);