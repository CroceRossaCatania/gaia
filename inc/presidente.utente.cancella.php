<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
if($me->id !=$_GET['id']){
$t = $_GET['id'];
$f = Appartenenza::filtra([
  ['volontario', $t]
]);
$f[0]->cancella();
$f = TitoloPersonale::filtra([
  ['volontario', $t]
]);
for ($i = 0, $ff = count($f); $i < $ff;$i++) {
    $f[$i]->cancella();
}
$t = new Persona($t);
$t->cancella();
redirect('presidente.utenti&ok');
}else{
redirect('presidente.utenti&e');    
}
?>