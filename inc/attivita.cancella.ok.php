<?php

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(array('id'));

$a = Attivita::id($_GET['id']);
paginaAttivita($a);

$g = Gruppo::by('attivita', $a);
if($g){
    $g = Gruppo::id($g);
    $g->cancella();
}
$a->cancella();

redirect('attivita');
