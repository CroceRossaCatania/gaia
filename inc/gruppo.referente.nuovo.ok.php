<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$g = $_POST['id'];
$g = Gruppo::id($g);
$referente = $_POST['inputReferente'];
$referente = Volontario::id($referente);
$g->referente   =   $referente;

redirect('gruppi.dash&newref');
?>
