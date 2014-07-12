<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(['id'], 'formazione.corsibase&err');
$corso = CorsoBase::id($_GET['id']);
paginaCorsoBase($corso);

$excel = new Excel();

if ( isset($_GET['preiscrizioni'])){

    $part = $corso->partecipazioni(ISCR_RICHIESTA);

        $excel->intestazione([
            'Nome',
            'Cognome',
            'C. Fiscale',
            'Data Nascita',
            'Luogo Nascita',
            'eMail',
            'Cellulare'
            ]);
        
        foreach ( $part as $p ) { 
            $iscritto = $p->utente();

            $excel->aggiungiRiga([
                $iscritto->nome,
                $iscritto->cognome,
                $iscritto->codiceFiscale,
                date('d/m/Y', $iscritto->dataNascita),
                $iscritto->comuneNascita,
                $iscritto->email,
                $iscritto->cellulare
                ]);
        }

    $excel->genera('Aspiranti preiscritti.xls');
    $excel->download();

}elseif ( isset($_GET['iscrizioni'])){

    $part = $corso->partecipazioni(ISCR_CONFERMATA);

        $excel->intestazione([
            'Nome',
            'Cognome',
            'C. Fiscale',
            'Data Nascita',
            'Luogo Nascita',
            'eMail',
            'Cellulare'
            ]);
        
        foreach ( $part as $p ) { 
            $iscritto = $p->utente();

            $excel->aggiungiRiga([
                $iscritto->nome,
                $iscritto->cognome,
                $iscritto->codiceFiscale,
                date('d/m/Y', $iscritto->dataNascita),
                $iscritto->comuneNascita,
                $iscritto->email,
                $iscritto->cellulare
                ]);
        }

    $excel->genera('Aspiranti iscritti.xls');
    $excel->download();
}