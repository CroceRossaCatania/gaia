<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$t = GeoPolitica::daOid($_GET['oid']);
if($t->figli()){
	redirect('admin.comitati&err');
}
if(Appartenenza::filtra([['comitato', $t]])){
	redirect('admin.comitati&evol');
}
$t->cancella();
redirect('admin.comitati&del');
