<?php
/*
 * ©2015 Croce Rossa Italiana
 */
//paginaAdmin();
paginaPresidenziale(null, null, APP_OBIETTIVO, OBIETTIVO_1);

controllaParametri(['inizio','partecipanti','luogo','tipo','organizzatore'], 'admin.corsi.crea&err');
if(!DT::controlloDataOra($_POST['inizio'])) {
    redirect('admin.corsi.crea&err='.CORSO_ERRORE_DATA_NON_CORRETTA); 
}

$organizzatore = intval($_POST['organizzatore']);
$partecipanti = intval($_POST['partecipanti']);
$descrizione = addslashes($_POST['descrizione']);
$luogo = addslashes($_POST['luogo']);
$tipocorsoId = (int) intval($_POST['tipo']);


$comitato = Comitato::id($organizzatore)->oid();

$inizio = DT::createFromFormat('d/m/Y H:i', $_POST['inizio']);

$_POST['id'] = intval(@$_POST['id']);
if (empty($_POST['id'])) {
    $c = new Corso();
} else {
    $c = Corso::id($_POST['id']);
    
    if (!$c->modificabile() /* || !$c->modificabileDa($me)*/ ) {
       redirect('formazione.corsi.riepilogo&id='.$c->id.'&err='.CORSO_ERRORE_CORSO_NON_MODIFICABILE);
    }
    
}

print "A";
$c->tipo = $tipocorsoId;
$c->organizzatore = $comitato;
$c->responsabile = $me->id;
$c->luogo = $luogo;
$c->inizio = $inizio->getTimeStamp();
$c->anno = $inizio->format('Y');
$c->partecipanti = $partecipanti;
$c->descrizione = $descrizione;
$c->stato = CORSO_S_DACOMPLETARE;

print "B";
$c->assegnaProgressivo();

print "C";
$c->aggiornaStato();

print "D";
$c->inviaCreazioneCorso();

if (!empty($_POST['wizard'])) {
    redirect('formazione.corsi.direttore&id='.$c->id.'&wizard=1');
} else {
    redirect('formazione.corsi.riepilogo&id='.$c->id);
}
?>