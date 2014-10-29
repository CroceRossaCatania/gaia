<?php

/*
* ©2014 Croce Rossa Italiana
*/


paginaPrivata();
controllaParametri(['id']);

$corso = CorsoBase::id($_POST['id']);
paginaCorsoBase($corso);

if (!$corso->daCompletare()) {
    redirect("formazione.corsibase.scheda&id={$corso}");
}

$corso->stato = CORSO_S_ATTIVO;

$aspiranti = $corso->potenzialiAspiranti();
$r = [];
foreach($aspiranti as $aspirante) {
    try {
        $utente = $aspirante->utente();
    } catch (Exception $e) {
        $aspirante->cancella();
        continue;
    }
    $r[] = $utente;
}

foreach ($r as $utente) {
    $m = new Email('corsoBaseAttivato', 'Nuovo Corso per Volontari CRI');
    $m->a = $utente;
    $m->da = $corso->direttore();
    $m->_ASPIRANTE = $utente->nome;
    $m->_DESCRIZIONE = $corso->descrizione;
    $m->_COMITATO = $corso->organizzatore()->nomeCompleto();
    $m->_INIZIO = $corso->inizio()->inTesto(true, false);
    $m->accoda();
}

redirect('formazione.corsibase.scheda&id=' . $corso->id);