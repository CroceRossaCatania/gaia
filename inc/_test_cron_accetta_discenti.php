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

if ($c->stato != CORSO_S_DACOMPLETARE) {
    throw new Exception('Il corso non è nello stato '.$conf[CORSO_S_DACOMPLETARE]);
}


//    $certificato = TipoCorso::by('id', intval($c->certificato));
$partecipazioni = $c->partecipazioniPotenziali();
foreach ($partecipazioni as $p) {
    $p->stato = PARTECIPAZIONE_ACCETTATA;
}

$partecipazioni = $c->partecipazioniPotenziali();
if (empty($partecipazioni)) {
    $ret = $c->aggiornaStato();
    if ($ret) {
        echo "errore [$ret]<br/>\r\n";
        foreach ($conf['validazione_corsi'] as $err => $txt) {
            echo "test $err:<br/>\r\n";
            if ($ret & $err) { 
                echo $txt."<br/>\r\n";
            }
        }
    } else {
        echo "Stato del corso aggiornato a ".$conf['corso_stato'][$c->stato];
    }
} else {
    echo '<pre>';
    var_dump($partecipazioni);
    echo '</pre>';
    throw new Exception('Impossibiler aggiornare lo stato di tutte le partecipazioni '.$conf[CORSO_S_DACOMPLETARE]);
}
    
die;

?>