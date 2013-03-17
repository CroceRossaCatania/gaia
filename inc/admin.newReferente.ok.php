<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$t = $_GET['id'];
$c = $_POST['inputComitato'];
$a = $_POST['inputApplicazione'];
$d = $_POST['inputDominio'];


$x = new Delegato();
$x->comitato = $c;
$x->volontario = $t;
$x->applicazione = $a;
$x->dominio = $d;
$x->inizio = time();
$x->fine = 0;
$x->tConferma = time();
$x->pConferma = $me->id;

redirect('admin.Referenti&new');
