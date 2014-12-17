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

if ( $_POST['inputDataattivazione'] && (!$corso->finito() || $me->admin())) {
    $data = DT::daFormato($_POST['inputDataattivazione'], 'd/m/Y');
    $corso->dataAttivazione = $data->getTimestamp();
    $corso->opAttivazione   = $_POST['inputOpattivazione'];
}

if ( $_POST['inputDataconvocazione'] && (!$corso->finito() || $me->admin())) {
    $data = DT::daFormato($_POST['inputDataconvocazione'], 'd/m/Y');
    $corso->dataConvocazione = $data->getTimestamp();
    $corso->opConvocazione   = $_POST['inputOpconvocazione'];
}

if ( $_POST['inputInvioEmail'] ) {
    redirect('formazione.corsibase.email.aspiranti&id=' . $corso->id);
}

redirect('formazione.corsibase.scheda&id=' . $corso->id);
