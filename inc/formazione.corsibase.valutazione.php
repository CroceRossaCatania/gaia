<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

if ( isset($_GET['single'])) {

    controllaParametri(array('id','corso'), 'errore.fatale');

    $iscritto = $_GET['id'];
    $corso = $_GET['corso'];

    $iscritto = Utente::id($iscritto);
    $corso = CorsoBase::id($corso);

    $f = $corso->generaScheda($iscritto);
    $f->download();

}else{

    controllaParametri(array('id'), 'errore.fatale');

    $corso = $_GET['id'];
    $corso = CorsoBase::id($corso);

    $zip = new Zip();

    $tabella = '<table border="1" style="width:100%">
                    <tbody>
                        <tr>
                            <td align="center"><b>Cognome e Nome</b></td>
                            <td align="center"><b>Luogo di nascita</b></td>
                            <td align="center"><b>Data di nascita</b></td>
                            <td align="center"><b>Esito</b></td>
                        </tr>';

    $x = 0;

    foreach($corso->partecipazioni(ISCR_SUPERATO) as $pb){

        $iscritto = $pb->utente();
        $dataNascita = date('d/m/Y', $iscritto->dataNascita);
        $esito = $conf['partecipazioneBase'][$pb->stato];
        $tabella .= "<tr>
                        <td>{$iscritto->nomeCompleto()}</td>
                        <td>{$iscritto->comuneNascita}</td>
                        <td>{$dataNascita}</td>
                        <td>{$esito}</td>
                    </tr>";

        if ( isset($_GET['iscritto']) && $x == 0 ) {

            $iscritto = Volontario::id($_GET['iscritto']);
            $f = $corso->generaScheda($iscritto);
            $a = $corso->generaAttestato($iscritto);
            $x++;

        }elseif( $x == 0 ){

            $f = $corso->generaScheda($iscritto);
            $a = $corso->generaAttestato($iscritto);

        }

        $zip->aggiungi($f);
        $zip->aggiungi($a);
    }

    $tabella.= "</tbody></table>";

    $part = new PDF('verbaleEsame', 'Verbale esame.pdf');
    $part->_COMITATO       = $corso->organizzatore()->nomeCompleto();
    $part->_GIORNO             = date('d', $corso->tEsame);
    $part->_MESE               = date('m', $corso->tEsame);
    $part->_ANNO               = date('Y', $corso->tEsame);
    $part->_LUOGO              = $corso->organizzatore()->comune;
    $part->_VIA                = $corso->organizzatore()->indirizzo;
    $part->_CIVICO             = $corso->organizzatore()->civico;
    $part->_OPATT              = $corso->opAttivazione;
    $part->_DATAATT            = $corso->dataAttivazione();
    $part->_OPCONVOCAZIONE     = $corso->opConvocazione;
    $part->_DATACONVOCAZIONE   = $corso->dataConvocazione();
    $part->_NUMASP             = $corso->numIscritti();
    $part->_NONIDONEI          = count($corso->partecipazioni(ISCR_BOCCIATO));
    $part->_IDONEI             = count($corso->partecipazioni(ISCR_SUPERATO));
    $part->_TABELLA            = $tabella;
    $f = $part->salvaFile(null,true);
    $zip->aggiungi($f);

    $zip->comprimi("Verbale e schede corso base.zip");
    $zip->download();

}