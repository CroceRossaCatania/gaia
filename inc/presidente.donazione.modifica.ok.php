<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$parametri = array('t', 'v');
controllaParametri($parametri, 'presidente.donazioni&err');

$t = $_GET['t'];
$id = $_GET['v']; 
$v= Volontario::id($id);
$tp = DonazionePersonale::id($t);
$tp = $tp->donazione;

$p = DonazionePersonale::id($t);
$p->volontario  = $v->id;
$p->donazione      = $tp;

    $data = @DateTime::createFromFormat('d/m/Y', $_POST['data']);
        $data = @$data->getTimestamp();
        $p->data = $data;

$p->luogo = normalizzaNome($_POST['sede']);

$p->tConferma = time();
$p->pConferma = $me->id;

redirect('presidente.utente.visualizza&id=' . $v->id);
