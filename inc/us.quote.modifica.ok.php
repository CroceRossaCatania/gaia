<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$parametri = ['id', 'inputImporto', 'inputData'];
controllaParametri($parametri, 'us.dash&err');

$id = $_POST['id'];
$q = Quota::by('id', $id);


$u = $q->volontario();

if($q->annullata()) {
    redirect('us.quote.visualizza&annullata&id='.$u->id);
}

$attivo = false;
if ($u->stato == VOLONTARIO) {
  $attivo = true;
}
if (!$t = Tesseramento::by('anno', $q->anno)) {
  $t = new StdClass();
  $t->attivo = 8;
  $t->ordinario = 16;
}

$importo = (float) $_POST['inputImporto'];
$importo = round($importo, 2);

$quotaMin = $attivo ? $t->attivo : $t->ordinario;

if ($importo < $quotaMin) {
    redirect('us.quote.modifica&id='.$id.'&importo');
}

$app = $q->appartenenza();
$quotaBen = $quotaMin + (float) $app->comitato()->quotaBenemeriti();
$anno = date('Y');

$time = DT::createFromFormat('d/m/Y', $_POST['inputData']);


$q->tConferma = $time->getTimestamp();
$q->quota = $importo;
if ($importo > $quotaBen) {
    $q->benemerito = BENEMERITO_SI;
} else {
    $q->benemerito = BENEMERITO_NO;
}

redirect('us.quote.visualizza&id='.$u->id);
