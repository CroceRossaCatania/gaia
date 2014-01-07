<?php

/*
 * ©2012 Croce Rossa Italiana
 */

require('./core.inc.php');

// Attiva la compressione GZIP
ob_start('ob_gzhandler');

// Imposta la risposta in JSON
header('Content-type: application/json');

// Crea la sessione API
$api = new APIServer( @$_REQUEST['sid'] );
$api->par = array_merge($_POST);
echo $api->esegui($_GET['a']);
