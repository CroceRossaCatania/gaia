<?php
/*
 * ©2015 Croce Rossa Italiana
 */
paginaPresidenziale(null, null, APP_OBIETTIVO, OBIETTIVO_1);
controllaParametri(['id','discenti'], 'admin.corsi.crea&err');

$c = null;
$discenti = $daAggiungere = $daEliminare = [];

try {
    $c = Corso::id(intval($_POST['id']));
    
    if (empty($c) || !is_array($discenti)) {
        throw new Exception('Manomissione');
    }

    if (!$c->modificabile() /*|| !$c->modificabileDa($me)*/ ) {
        redirect('formazione.corsi.riepilogo&id='.$c->id.'&err=1');
    }

    if (is_array($_POST['discenti'])) {
        $discenti = $c->discenti();

        // setta tutti i vecchi come da eliminare
        foreach ($discenti as $i) {
            $daEliminare[$i->id] = true;
        }
        unset($discenti); // non serve più e spreca solo memoria

        // cicla sui nuovi
        foreach ($_POST['discenti'] as $id) {
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
var_dump($c);
var_dump($discenti);
var_dump($daAggiungere);
var_dump($daEliminare);
die;
        foreach ($daEliminare as $id) {
            PartecipazioneCorso::id($id)->cancella();
        }
        
        foreach ($daAggiungere as $id) {
            $discente = Volontario::id($id);
            
            // aggiungere verifica del fatto che sia effettivamente un istruttore
            
            $p = new PartecipazioneCorso();
            $p->aggiungi($c, $discente, CORSO_RUOLO_DISCENTE);
        }
        
    }

    $c->aggiornaStato();
} catch (Exception $e) {
    redirect('admin.corsi.crea&err');
}

redirect('formazione.corsi.riepilogo&id='.$c->id);

?>
