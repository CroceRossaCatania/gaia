<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$id     =   $_GET['id'];
$gruppo =   Gruppo::id($id);
$gruppo->cancella();

redirect('gruppi.dash&cancellato');
