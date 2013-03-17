<?php

$id = $_POST['id'];
$a = new Attivita($id);

$a->nome        = normalizzaNome($_POST['inputNome']);
$a->comitato    = $_POST['inputComitato'];
$a->referente   = $_POST['inputReferente'];
$a->descrizione = $_POST['inputDescrizione'];
$a->pubblica    = $_POST['inputPubblica'];
$a->tipo        = $_POST['inputTipo'];
$a->timestamp   = time();

$turni = $a->turni();
foreach ( $turni as $t ) {
    $t->nome    = normalizzaNome($_POST["{$t->id}_nome"]);
    $inizio     = DT::createFromFormat('d/m/Y H:i', $_POST["{$t->id}_inizio"]);
    $fine       = DT::createFromFormat('d/m/Y H:i', $_POST["{$t->id}_fine"]);
    $t->inizio  = $inizio->getTimestamp();
    $t->fine    = $fine->getTimestamp();
    $t->minimo  = (int) $_POST["{$t->id}_minimo"];
    $t->massimo = (int) $_POST["{$t->id}_massimo"];
    
}

if ( $_POST['azione'] == 'aggiungiTurno' ) {
    $num = count($turni) + 1;
    $t = new Turno();
    $t->attivita    = $a->id;
    $t->inizio      = $fine->getTimestamp();
    $t->fine        = strtotime('+2 hours', $fine->getTimestamp());
    $t->nome        = "Turno $num";
    $t->minimo      = 1;
    $t->massimo     = 4;
    redirect('attivita.nuova&id=' . $a->id);
}

if ( $a->haPosizione() ) {
    redirect('schedaAttivita&id=' . $a->id);
} else {
    redirect('attivita.localita&id=' . $a->id);
}