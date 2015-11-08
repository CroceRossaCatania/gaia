<?php
/*
 * ©2015 Croce Rossa Italiana
 */
//paginaAdmin();
paginaPresidenziale(null, null, APP_OBIETTIVO, OBIETTIVO_1);

controllaParametri(['inizio','partecipanti','luogo','tipo','organizzatore'], 'formazione.corsi.crea&err');
if(!DT::controlloDataOra($_POST['inizio'])) {
    redirect('formazione.corsi.crea&err='.CORSO_ERRORE_DATA_NON_CORRETTA); 
}

$organizzatore = intval($_POST['organizzatore']);
$partecipanti = intval($_POST['partecipanti']);
$descrizione = ($_POST['descrizione']);
$luogo = ($_POST['luogo']);
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
       die;
    }
    
}

$c->tipo = $tipocorsoId;
$c->organizzatore = $comitato;
$c->responsabile = $me->id;
$c->luogo = $luogo;
$c->inizio = $inizio->getTimeStamp();
$c->anno = $inizio->format('Y');
$c->partecipanti = $partecipanti;
$c->descrizione = $descrizione;
$c->stato = CORSO_S_DACOMPLETARE;


$tipoCorso = TipoCorso::id($c->tipo);
// corso di una giornata sola => aggiunta automatica della giornata
if ($tipoCorso->giorni<=1) {
    $l = new GiornataCorso();
    $l->corso 	= $c->id;
    $l->nome 	= $tipoCorso->nome;
    $l->data        = $c->inizio;
    $l->luogo 	= $c->luogo;
    $l->note 	= $c->descrizione;
    $l->docente 	= 0;
}

$c->assegnaProgressivo();

$c->aggiornaStato();

$c->inviaCreazioneCorso();

if (!empty($_POST['wizard'])) {
    redirect('formazione.corsi.direttore&id='.$c->id.'&wizard=1');
} else {
    redirect('formazione.corsi.riepilogo&id='.$c->id);
}
?>