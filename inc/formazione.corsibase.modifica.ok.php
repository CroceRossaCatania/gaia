<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();
controllaParametri(array('id'), 'formazione.corsibase&err');
$corso = CorsoBase::id($_POST['id']);
paginaCorsoBase($corso);

if ( isset($_POST['inputDescrizione']) ) {
    $corso->descrizione     = $_POST['inputDescrizione'];
    $corso->aggiornamento   = time();
}

if ( isset($_POST['inputDataInizio']) && (!$corso->iniziato() || $me->admin())) {
    $data = DT::daFormato($_POST['inputDataInizio'], 'd/m/Y H:i');
    if($data && $data < $corso->fine()) {
        $corso->inizio     = $data->getTimestamp();
        $corso->aggiornamento   = time();
    }
}

if ( isset($_POST['inputDataEsame']) && (!$corso->finito() || $me->admin())) {
    $data = DT::daFormato($_POST['inputDataEsame'], 'd/m/Y H:i');
    if($data && $data > $corso->inizio()) {
        $corso->tEsame     = $data->getTimestamp();
        $corso->aggiornamento   = time();
    }
}

if($corso->stato == CORSO_S_DACOMPLETARE){

    $corso->stato = CORSO_S_ATTIVO;

    $aspiranti = $corso->potenzialiAspiranti();

    foreach($aspiranti as $aspirante) {
        $m = new Email('corsoBaseAttivato', 'Nuovo Corso per Volontari CRI');
        $m->a = $aspirante;
        $m->_ASPIRANTE = $aspirante->nome;
        $m->_DESCRIZIONE = $corso->descrizione;
        $m->_COMITATO = $comitato->nomeCompleto();
        $m->_INIZIO = $data->inTesto();
        $m->accoda();
    }
}

redirect('formazione.corsibase.scheda&id=' . $corso->id);
