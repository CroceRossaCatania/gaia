<?php
/*
 * ©2015 Croce Rossa Italiana
 */

(var_dump($_POST));
controllaParametri(['id','idoneita','affiancamenti'], 'admin.corsi.crea&err');

$idoneita = filter_input(INPUT_POST, 'idoneita', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$affiancamenti = filter_input(INPUT_POST, 'affiancamenti', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$segnalazioni = filter_input(INPUT_POST, 'segnalazioni', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
(var_dump($idoneita));
(var_dump($affiancamenti));
(var_dump($segnalazioni));

$c = null;
try {
    $c = Corso::id(intval($_POST['id']));
    
    // controllare che l'utente attuale sia il direttore del corso 

    $size = $c->numeroDiscenti();
    if (    empty($c) 
            || !is_array($idoneita) 
            || !is_array($affiancamenti)
            || sizeof($idoneita) != $size
            || sizeof($affiancamenti) != $size 
            || array_keys($affiancamenti) != array_keys($idoneita)
       ) {
        throw new Exception('Manomissione');
    }
    
    if (!$c->concluso()) {
        redirect('formazione.corsi.riepilogo&id='.$c->id.'&err='.CORSO_ERRORE_NON_ANCORA_CONCLUSO);
    }

} catch (Exception $e) {
    die($e->getMessage());
    redirect('admin.corsi.crea&err');
}

$now = new DT();
$insegnanti = $c->insegnanti();
$idInsegnanti = array();
foreach ($insegnanti as $i) {
    $idInsegnanti[] = $i->volontario;
}
unset($insegnanti);

foreach ($idoneita as $volontario => $idoneita) {
    $r = new RisultatoCorso();
    $r->corso = $c->id;
    $r->volontario = intval($volontario);
    $r->idoneita = intval($idoneita);
    $r->affiancamenti = ($r->idoneita >= CORSO_RISULTATO_IDONEO) ? intval($affiancamenti[$volontario]) : 0;
    
    if (!empty($segnalazioni[$volontario]) && is_array($segnalazioni[$volontario])) {
        

        $size = sizeof($segnalazioni[$volontario]);
        for ($idx = 0; $idx < $size; ++$idx) {
            
            if (!in_array(intval($segnalazioni[$volontario][$idx]), $idInsegnanti) ) {
                throw new Exception('Manomissione');
            }
            
            $r->{'segnalazione_0'.($idx+1)} = intval($segnalazioni[$volontario][$idx]);
        }
    }
    $r->timestamp = $now->getTimestamp();
    $r->note = $r->note  . "\r\n".'['.$now->format('d.M.Y H:i:s').'] creazione da parte di '.$c->direttore()->nomeCompleto();
}
die();

redirect('formazione.corsi.riepilogo&id='.$c->id);

?>
