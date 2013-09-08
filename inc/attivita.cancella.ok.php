<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$a = new Attivita($_GET['id']);
paginaAttivita($a);

$g = Gruppo::by('attivita', $a);
if($g){
	$g = new Gruppo($g);
	$g->cancella();
}
$a->cancella();

redirect('attivita');