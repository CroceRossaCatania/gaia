<?php
/*
 * ©2015 Croce Rossa Italiana
 */
//paginaAdmin();
paginaPresidenziale();

controllaParametri(['inizio','partecipanti','luogo','certificato','organizzatore'], 'admin.corsi.crea&err');

if(!DT::controlloDataOra($_POST['inizio'])){ redirect('admin.corsi.crea&err'); }

$organizzatore = intval($_POST['organizzatore']);
$partecipanti = intval($_POST['partecipanti']);
$descrizione = addslashes($_POST['descrizione']);
$luogo = addslashes($_POST['luogo']);


$certificato = Certificato::by('id', intval($_POST['certificato']));
$comitato = Comitato::id($organizzatore)->oid();

$inizio = DT::createFromFormat('d/m/Y H:i', $_POST['inizio']);

$_POST['id'] = intval(@$_POST['id']);
if (empty($_POST['id'])) {
    $c = new Corso();
} else {
    $c = Corso::id($_POST['id']);
    if (!$c->modificabile() /* || !$c->modificabileDa($me)*/ ) {
        redirect('formazione.corsi.riepilogo&id='.$c->id.'&err=1');
    }
}

$c->certificato = (int) intval($_POST['certificato']);
$c->organizzatore = $comitato;
$c->responsabile = $me->id;
$c->luogo = $luogo;
$c->inizio = $inizio->getTimeStamp();
$c->anno = $inizio->format('Y');
$c->partecipanti = $partecipanti;
$c->descrizione = $descrizione;
$c->stato = CORSO_S_DACOMPLETARE;

$c->assegnaProgressivo();
$c->aggiornaStato();

if (!empty($_POST['wizard'])) {
    redirect('formazione.corsi.direttore&id='.$c->id.'&wizard=1');
} else {
    redirect('formazione.corsi.riepilogo&id='.$c->id);
}
?>
