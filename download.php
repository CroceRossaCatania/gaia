<?php

/*
 * ©2012 Croce Rossa Italiana
 */

require('./core.inc.php');

$f = $_GET['id'];
if (!$f) { die('Specificare ID del file da scaricare.'); }
$f = new File($f);
$f->download = $f->download + 1;

if ( $f->mime ) {
    header('Content-type: ' . $f->mime);
} 

header("Content-Description: File Transfer");

if ( !isset($_GET['anteprima']) )
	header("Content-Disposition: attachment; filename=\"{$f->nome}\"");

readfile($f->percorso());
