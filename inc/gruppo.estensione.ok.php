<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$g = $_POST['id'];
$g = new Gruppo($g);
$g->estensione=$_POST['inputEstensione'];

redirect('gruppi.dash&estok');
?>
