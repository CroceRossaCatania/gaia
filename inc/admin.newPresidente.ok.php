<?php

/*
 * ©2012 Croce Rossa Italiana
 */

$t = $_GET['id'];
$c=$_POST['inputComitato'];
$f = Appartenenza::filtra([
  ['volontario', $t],['comitato',$c]
 ]);
if($f[0]!=''){
$f[0]->stato = MEMBRO_PRESIDENTE;
}else{
$f = Appartenenza::filtra([
['volontario', $t],
 ]);
$a = new Appartenenza();
$a->volontario  = $f[0]->volontario()->id;
$a->comitato    = $c;
$a->inizio      = time();
$a->fine        = strtotime('April 31');
$a->stato = MEMBRO_PRESIDENTE;
$a->conferma = $me->id;
$a->timestamp = time();
}

redirect('admin.Presidenti&new');

?>