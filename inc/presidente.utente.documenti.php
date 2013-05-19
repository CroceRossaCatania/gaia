<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$v = new Volontario($_GET['id']);
$v->zipDocumenti()->download();