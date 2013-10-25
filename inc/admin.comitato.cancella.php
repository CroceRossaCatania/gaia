<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$t = $_GET['oid'];
$t = GeoPolitica::daOid($t);
if($t->figli()){
	redirect('admin.comitati&err');
}
if(Appartenenza::filtra([['comitato', $t]])){
	redirect('admin.comitati&evol');
}
$t->cancella();
redirect('admin.comitati&del');
