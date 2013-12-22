<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('oid'), 'admin.comitati&err');
$t = $_GET['oid'];
$t = GeoPolitica::daOid($t);
if($t->figli()){
	redirect('admin.comitati&figli');
}
if(Appartenenza::filtra([['comitato', $t]])){
	redirect('admin.comitati&evol');
}
$t->cancella();
redirect('admin.comitati&del');

?>
