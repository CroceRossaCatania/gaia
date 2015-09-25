<?php
/*
 * ©2015 Croce Rossa Italiana
 */

controllaParametri(['id','discIdoneita','discAffiancamenti'], 'admin.corsi.crea&err');

$idoneitaDisc = filter_input(INPUT_POST, 'discIdoneita', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$idoneitaAff = filter_input(INPUT_POST, 'affIdoneita', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

$affiancamentiDisc = filter_input(INPUT_POST, 'discAffiancamenti', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$segnalazioniDisc = filter_input(INPUT_POST, 'discSegnalazioni', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);


//(var_dump($idoneita));
//(var_dump($affiancamenti));
//(var_dump($segnalazioni));
$c = null;
try {
    $c = Corso::id(intval($_POST['id']));
    
    // controllare che l'utente attuale sia il direttore del corso 

    $size = $c->numeroDiscenti();
    if (    empty($c) 
            || !is_array($idoneitaDisc) 
            || !is_array($affiancamentiDisc)
            || sizeof($idoneitaDisc) != $size
            || sizeof($affiancamentiDisc) != $size 
            || array_keys($affiancamentiDisc) != array_keys($idoneitaDisc)
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
$docenti = $c->docenti();
$idDocenti = array();
foreach ($docenti as $i) {
    $idDocenti[] = $i->volontario;
}
unset($docenti);

foreach ($idoneitaDisc as $volontario => $risultato) {
    $r = new RisultatoCorso();
    $r->corso = $c->id;
    $r->volontario = intval($volontario);
    $r->idoneita = intval($risultato);
    $r->affiancamenti = ($r->idoneita >= CORSO_RISULTATO_IDONEO) ? intval($affiancamenti[$volontario]) : 0;
    
    if (!empty($segnalazioniDisc[$volontario]) && is_array($segnalazioniDisc[$volontario])) {

        $size = sizeof($segnalazioniDisc[$volontario]);
        for ($idx = 0; $idx < $size; ++$idx) {
            
            if (!in_array(intval($segnalazioniDisc[$volontario][$idx]), $idDocenti) ) {
                throw new Exception('Manomissione');
            }
            
            $r->{'segnalazione_0'.($idx+1)} = intval($segnalazioniDisc[$volontario][$idx]);
        }
    }
    $r->timestamp = $now->getTimestamp();
    $r->note = $r->note  . "";
    
}

foreach ($idoneitaAff as $volontario => $risultato) {
    $r = new RisultatoCorso();
    $r->corso = $c->id;
    $r->volontario = intval($volontario);
    $r->idoneita = intval($risultato);
    $r->affiancamenti = ($r->idoneita >= CORSO_RISULTATO_IDONEO) ? intval($affiancamenti[$volontario]) : 0;
    
    if (!empty($segnalazioniDisc[$volontario]) && is_array($segnalazioniDisc[$volontario])) {

        $size = sizeof($segnalazioniDisc[$volontario]);
        for ($idx = 0; $idx < $size; ++$idx) {
            
            if (!in_array(intval($segnalazioniDisc[$volontario][$idx]), $idDocenti) ) {
                throw new Exception('Manomissione');
            }
            
            $r->{'segnalazione_0'.($idx+1)} = intval($segnalazioniDisc[$volontario][$idx]);
        }
    }
    $r->timestamp = $now->getTimestamp();
    $r->note = $r->note  . "";
    
}

/*
$c->stato = CORSO_S_DA_ELABORARE;
*/
$c->chiudi();

redirect('formazione.corsi.riepilogo&id='.$c->id);

?>
