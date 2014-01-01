<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaPrivata();

controllaParametri(array('id'), 'gruppi.dash&err');
$id     =   $_GET['id'];
$gruppo =   Gruppo::id($id);

proteggiClasse($gruppo, $me);

$gruppo->cancella();

redirect('gruppi.dash&cancellato');
