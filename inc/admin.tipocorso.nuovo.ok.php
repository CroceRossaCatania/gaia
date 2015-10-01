<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(['inputNome'], 'admin.tipocorso.nuovo&err');

$x = TipoCorso::by('nome', $_POST['inputNome']);
if (!$x){
    $t = new TipoCorso();
    $t->nome = maiuscolo( $_POST['inputNome'] );
    $t->minimoPartecipanti = intval($_POST['inputMinimoPartecipanti']);
    $t->massimoPartecipanti = intval($_POST['inputMassimoPartecipanti']);
    $t->durata = intval($_POST['inputDurata']);
    $t->giorni = intval($_POST['inputGiorni']);
    $t->limitePerIscrizione = intval($_POST['inputLimitePerIscrizione']);
    $t->tipoValutazione = $_POST['inputTipoValutazione'];
    $t->attestato =  $_POST['inputAttestato'];
    $t->proporzioneAffiancamento =  intval($_POST['inputProporzioneAffiancamento']);
    $t->punizione = intval($_POST['inputPunizione']);
    $t->proporzioneIstruttori =  intval($_POST['inputProporzioneIstruttori']);

    $t->ruoloProprietario = $_POST['inputRuoloProprietario'];
    $t->ruoloDirettore = $_POST['inputRuoloDirettore'];
    $t->ruoloDocenti = $_POST['inputRuoloDocenti'];
    $t->ruoloAffiancamento = $_POST['inputRuoloAffiancamento'];
    $t->ruoloDiscenti = $_POST['inputRuoloDiscenti'];
    redirect('admin.tipocorso&new');
} else {
    redirect('admin.tipocorso&dup');
}

?>
