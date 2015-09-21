<?php


/*
 * ©2013 Croce Rossa Italiana
 */
paginaPrivata();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, array('min_range'=>1));

// try catch da usare per evitare stampa dell'errore e poter fare redirect 
try {
    $c = Corso::id($id);
    if (empty($c)) {
        throw new Exception('Il corso non esiste');
    }
//    $certificato = Certificato::by('id', intval($c->certificato));

} catch(Exception $e) {
    throw new Exception('Errore nel recupero del corso');
}

if ($c->stato != CORSO_S_ATTIVO) {
    throw new Exception('Il corso non è nello stato '.$conf[CORSO_S_ATTIVO]);
}

$c->stato = CORSO_S_CONCLUSO;

echo "Stato del corso aggiornato a ".$conf['corso_stato'][$c->stato];
die;

?>