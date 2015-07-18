<?php

/*
 * ©2015 Croce Rossa Italiana
 */
//var_dump($_POST);
//die;
//paginaAdmin();
controllaParametri(['inizio','fine','luogo','certificato','organizzatore'], 'admin.corsi.crea&err');
if(!DT::controlloData($_POST['inizio'])){ redirect('admin.corsi.crea&err'); }
if(!DT::controlloData($_POST['fine'])){ redirect('admin.corsi.crea&err'); }

$organizzatore = intval($_POST['organizzatore']);
$descrizione = addslashes($_POST['descrizione']);
$luogo = addslashes($_POST['luogo']);

$certificato = Certificato::by('id', intval($_POST['certificato']));
$comitato = Comitato::id($organizzatore)->oid();

$inizio = DT::createFromFormat('d/m/Y', $_POST['inizio'])->getTimestamp();
$fine = DT::createFromFormat('d/m/Y', $_POST['fine'])->getTimestamp();

$t = new Corso();
$t->certificato = (int) intval($_POST['certificato']);
$t->organizzatore = $comitato;
$t->inizio = $inizio;
$t->descrizione = $descrizione;

redirect('formazione.corsi.direttore?id='.$t->id);

?>
