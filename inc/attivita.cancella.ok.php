<?php

/*
 * ©2013 Croce Rossa Italiana
 */
if (isset($_GET['id'])) {
	$a = Attivita::id($_GET['id']);
	paginaAttivita($a);

	$g = Gruppo::by('attivita', $a);
	if($g){
		$g = Gruppo::id($g);
		$g->cancella();
	}
	$a->cancella();
}
redirect('attivita');