<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(['inputNome'], 'admin.certificato.nuovo&err');

$x = Certificato::by('nome', $_POST['inputNome']);
if (!$x){
    $t = new Certificato();
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

    $t->ruoloProprietario = $_POST['inputRuoloProprietario'];
    $t->ruoloDirettore = $_POST['inputRuoloDirettore'];
    $t->ruoloDocenti = $_POST['inputRuoloDocenti'];
    $t->ruoloAffiancamento = $_POST['inputRuoloAffiancamento'];
    $t->ruoloDiscenti = $_POST['inputRuoloDiscenti'];
    redirect('admin.certificati&new');
} else {
    redirect('admin.certificati&dup');
}

?>
