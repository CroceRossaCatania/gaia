<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$id     =   $_GET['id'];
$gruppo =   new Gruppo($id);
$gruppo->cancella();

redirect('gruppi.dash&cancellato');
