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
foreach($f as $_f){
$_f->cancella();
}
$f = TitoloPersonale::filtra([
  ['volontario', $t]
]);
foreach ($f as $_f) {
    $f->cancella();
}
$f = Trasferimento::filtra([
    ['volontario', $t]
]);
foreach($f as $_f){
    $_f->cancella();
}
$f = Riserva::filtra([
    ['volontario', $t]
]);
foreach($f as $_f){
    $_f->cancella();
}
$f = Reperibilita::filtra([
    ['volontario', $t]
]);
foreach($f as $_f){
    $_f->cancella();
}
$t = Persona::id($t);
$t->cancella();
redirect('presidente.utenti&ok');
}else{
redirect('presidente.utenti&e');    
}
?>