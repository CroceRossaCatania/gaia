<?php
/*
 * ©2015 Croce Rossa Italiana
 */
paginaPresidenziale();
controllaParametri(['id','insegnanti'], 'admin.corsi.crea&err');

$c = null;
$insegnanti = $daAggiungere = $daEliminare = [];

try {
    $c = Corso::id(intval($_POST['id']));
    
    if (!$c->modificabile() /*|| !$c->modificabileDa($me) */) {
        redirect('formazione.corsi.riepilogo&id='.$c->id.'&err=1');
    }

    if (empty($c) || !is_array($insegnanti)) {
        throw new Exception('Manomissione');
    }
    
    if (is_array($_POST['insegnanti'])) {
        $insegnanti = $c->insegnanti();

        // setta tutti i vecchi come da eliminare
        foreach ($insegnanti as $i) {
            $daEliminare[$i->id] = true;
        }
        unset($insegnanti); // non serve più e spreca solo memoria

        // cicla sui nuovi
        foreach ($_POST['insegnanti'] as $id) {
            if (isset($daEliminare[$id])) {
                // se il nuovo è anche tra i vecchi, lo toglie dalla lista di quelli da eliminare
                unset($daEliminare[$id]);
            } else {
                // se il nuovo non è tra i vecchi, lo aggiunge dalla lista di quelli da aggiungere
                $daAggiungere[$id] = true;
            }
        }

        $daAggiungere = array_keys($daAggiungere);
        $daEliminare = array_keys($daEliminare);
        foreach ($daEliminare as $id) {
            PartecipazioneCorso::id($id)->cancella();
        }
        
        foreach ($daAggiungere as $id) {
            $insegnante = Volontario::id($id);
            
            // aggiungere verifica del fatto che sia effettivamente un insegnante
            
            $p = new PartecipazioneCorso();
            $p->aggiungi($c, $insegnante, CORSO_RUOLO_INSEGNANTE);
        }

        $c->aggiornaStato();
    }
} catch (Exception $e) {
    redirect('admin.corsi.crea&err');
}


if (!empty($_POST['wizard'])) {
    redirect('formazione.corsi.discenti&id='.$c->id);
    die;
}

redirect('formazione.corsi.riepilogo&id='.$c->id);

?>
