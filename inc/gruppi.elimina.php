<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'), 'gruppi.dash&err');
$id     =   $_GET['id'];
$gruppo =   Gruppo::id($id);

proteggiClasse($gruppo, $me);

$appartenenti = AppartenenzaGruppo::filtra([['gruppo', $gruppo]]);

foreach ( $appartenenti as $appartenente ){
	$appartenente->cancella();
}

$gruppo->cancella();

redirect('gruppi.dash&cancellato');
