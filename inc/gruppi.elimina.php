<?php

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(array('id'), 'gruppi.dash&err');
$id     =   $_GET['id'];
$gruppo =   Gruppo::id($id);
$gruppo->cancella();

redirect('gruppi.dash&cancellato');
