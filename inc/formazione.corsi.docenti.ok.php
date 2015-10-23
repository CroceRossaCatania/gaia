<?php
/*
 * ©2015 Croce Rossa Italiana
 */

paginaPresidenziale(null, null, APP_OBIETTIVO, OBIETTIVO_1);
controllaParametri(['id','docenti'], 'admin.corsi.crea&err');

$c = null;
$docenti = $daAggiungere = $daEliminare = [];

try {
    $c = Corso::id(intval($_POST['id']));
    
    if (!$c->modificabile() /*|| !$c->modificabileDa($me) */) {
        redirect('formazione.corsi.riepilogo&id='.$c->id.'&err=1');
    }

    if (empty($c) || !is_array($docenti)) {
        throw new Exception('Manomissione');
    }
    
    if (is_array($_POST['docenti']) && !empty($_POST['docenti'])) {
        $docenti = array_merge($c->docenti(), $c->docentiPotenziali());

        // setta tutti i vecchi come da eliminare
        foreach ($docenti as $i) {
            $daEliminare[$i->id] = true;
        }
        unset($docenti); // non serve più e spreca solo memoria

        // cicla sui nuovi
        foreach ($_POST['docenti'] as $id) {
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
            $docente = Volontario::id($id);
            
            // aggiungere verifica del fatto che sia effettivamente un docente
            
            $p = new PartecipazioneCorso();
            $p->aggiungi($c, $docente, CORSO_RUOLO_DOCENTE);
        }

    } else {
        throw new Exception('Manomissione');
    }
    
    $c->aggiornaStato();
    
} catch (Exception $e) {
    die($e->getMessage());
    redirect('admin.corsi.crea&err');
}


if (!empty($_POST['wizard'])) {
    redirect('formazione.corsi.affiancamenti&id='.$c->id.'&wizard=1');
    die;
}

redirect('formazione.corsi.riepilogo&id='.$c->id);

?>
