<?php


/*
 * ©2013 Croce Rossa Italiana
 */
paginaPrivata();

// Verifico i corsi da chiudere
$corsi = Corso::corsiDaChiudere();

foreach($corsi as $corso){
    $risultati = $corso->risultati();
    foreach($risultati as $risultato){
        if ($risultato->idoneita){
            print "<pre>";
            print_r($risultato);
            print "</pre>";
            
            $corso->generaAttestato($risultato->volontario());
            
        }
    }
}

?>