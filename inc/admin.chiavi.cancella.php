<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();

$chiave = APIKey::id($_GET['id']);
$chiave->cancella();

redirect('admin.chiavi');