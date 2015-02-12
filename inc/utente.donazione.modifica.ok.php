<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('d'));

$d = $_GET['d'];
$tp = DonazionePersonale::id($d);
$tp = $tp->donazione();

$p = DonazionePersonale::id($d);
$p->volontario  = $me;
$p->donazione   = $tp;

$data = @DateTime::createFromFormat('d/m/Y', $_POST['data']);
$data = @$data->getTimestamp();
$p->data = $data;

$p->luogo = normalizzaNome($_POST['sede']);

redirect('utente.donazioni&d=' . $tp->tipo);
