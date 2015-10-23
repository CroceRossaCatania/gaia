<?php
/*
 * ©2015 Croce Rossa Italiana
 */
//paginaAdmin();
//paginaPresidenziale();
//paginaPresidenziale(null, null, APP_OBIETTIVO, OBIETTIVO_1);
//
//controllaParametri(['inizio','partecipanti','luogo','certificato','organizzatore'], 'admin.corsi.crea&err');

//if(!DT::controlloDataOra($_POST['inizio'])){ redirect('admin.corsi.crea&err='.CORSO_ERRORE_DATA_NON_CORRETTA); }


$corso = intval($_POST['corso']);
$nome = addslashes($_POST['titolo']);
$note = addslashes($_POST['note']);
$luogo = addslashes($_POST['luogo']);
$inizio = DT::createFromFormat('d/m/Y H:i', $_POST['inizio']);

$_POST['id'] = intval(@$_POST['id']);
if (empty($_POST['id'])) {
    $c = new GiornataCorso();
} else {
    $c = GiornataCorso::id($_POST['id']);
    if (!$c->modificabile() /* || !$c->modificabileDa($me)*/ ) {
        //redirect('formazione.corsi.riepilogo&id='.$c->id.'&err=1');
    }
}

$c->data = $inizio->getTimeStamp();
$c->luogo = $luogo;
$c->nome = $nome;
$c->corso = $corso;
$c->note = $note;

/*
$c->certificato = (int) intval($_POST['certificato']);
$c->organizzatore = $comitato;
$c->responsabile = $me->id;
$c->luogo = $luogo;
$c->inizio = ;
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
 * 
 */

print_r($c);
?>
