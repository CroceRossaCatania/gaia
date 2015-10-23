<?php
/*
 * ©2015 Croce Rossa Italiana
 */
paginaPresidenziale(null, null, APP_OBIETTIVO, OBIETTIVO_1);

controllaParametri(['id','direttore'], 'admin.corsi.crea&err');

$c = $direttore = null;
try {
    $c = Corso::id(intval($_POST['id']));
    
    if (!$c->modificabile() /*|| !$c->modificabileDa($me)*/ ) {
        redirect('formazione.corsi.riepilogo&id='.$c->id.'&err=1');
    }

    $direttore = Volontario::id(intval($_POST['direttore']));
    
    if (empty($c) || empty($direttore)) {
        throw new Exception('Manomissione');
    }
} catch (Exception $e) {
    redirect('admin.corsi.crea&err');
}

$c->direttore = $direttore->id;

$c->aggiornaStato();
    
$partecipazione = new PartecipazioneCorso();
$partecipazione->aggiungi($c, $direttore, CORSO_RUOLO_DIRETTORE);

if (!empty($_POST['wizard'])) {
    redirect('formazione.corsi.docenti&id='.$c->id.'&wizard=1');
    die;
}

redirect('formazione.corsi.riepilogo&id='.$c->id);

?>
