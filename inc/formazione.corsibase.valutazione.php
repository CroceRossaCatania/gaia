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

        $f = $corso->generaScheda($iscritto);
        $a = $corso->generaAttestato($iscritto);
        $zip->aggiungi($f);
        $zip->aggiungi($a);
    }

    $tabella.= "</tbody></table>";

    $p = new PDF('verbaleEsame', 'Verbale esame.pdf');
    $p->_COMITATO   = $corso->organizzatore()->nomeCompleto();
    $p->_GIORNO     = date('d', $corso->tEsame);
    $p->_MESE       = date('m', $corso->tEsame);
    $p->_ANNO       = date('Y', $corso->tEsame);
    $p->_LUOGO      = $corso->organizzatore()->comune;
    $p->_VIA        = $corso->organizzatore()->indirizzo;
    $p->_CIVICO     = $corso->organizzatore()->civico;
    $p->_NUMASP     = $corso->numIscritti();
    $p->_NONIDONEI  = count($corso->partecipazioni(ISCR_BOCCIATO));
    $p->_IDONEI     = count($corso->partecipazioni(ISCR_SUPERATO));
    $p->_TABELLA    = $tabella;
    $f = $p->salvaFile(null,true);
    $zip->aggiungi($f);

    $zip->comprimi("Verbale e schede corso base.zip");
    $zip->download();

}