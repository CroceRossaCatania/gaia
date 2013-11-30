<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$v = Volontario::id($_GET['id']);
$v->zipDocumenti()->download();