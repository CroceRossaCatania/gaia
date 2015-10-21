<?php
/*
 * ©2015 Croce Rossa Italiana
 */
paginaPresidenziale();

controllaParametri(['id'], 'admin.corsi.crea&err');

// try catch da usare per evitare stampa dell'errore e poter fare redirect 
$id = intval($_GET['id']);
$wizard = intval($_GET['wizard']);
try {
    $c = Corso::id($id);
    if (empty($c)) {
        throw new Exception('Manomissione');
    }
    $certificato = TipoCorso::by('id', intval($c->certificato));

} catch(Exception $e) {
    redirect('admin.corsi.crea&err='.CORSO_ERRORE_CORSO_NON_TROVATO);
}

if (!$c->modificabile()) {
    redirect('formazione.corsi.riepilogo&id='.$id);
}

// calcola il numero massimo di discenti per il corso
$maxDiscenti = $c->numeroDocentiNecessari() * $certificato->proporzioneIstruttori;

// recupera gli id di discenti già presenti per il corso
// per popolare automaticamente la lista in caso di pagina di modifica
$partecipazioni = PartecipazioneCorso::filtra([
    ['corso', $c->id],
    ['ruolo', CORSO_RUOLO_DISCENTE]
]);
$discenti = [];
foreach ($partecipazioni as $p) {
    $discenti[] = $p->volontario();
}
unset($partecipazioni);

caricaSelettoreDiscente([
    'max_selected_options' => $maxDiscenti,
    'no_results_text' => 'Ricerca discenti in corso...',
    
]);

$d = new DateTime('@' . $c->inizio);

?>

<div class="row-fluid">

    <div class="span8">
        <h2><i class="icon-plus-square icon-calendar muted"></i> Corso di formazione</h2>
        <form action="?p=formazione.corsi.discenti.ok" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <input value="<?php echo empty($wizard) ? 0 : 1 ?>" name="wizard" type="hidden">
            <div class="alert alert-block alert-success">
                <div class="row-fluid">
                    <h4><i class="icon-question-sign"></i> Discenti per <?php echo $certificato->nome ?> del <?php echo $d->format('d/m/Y'); ?></h4>
                </div>
                <hr>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="dataFine"><i class="icon-user"></i> Discenti</label>
                    </div>
                    <div class="span8">
                        <select name="discenti[]" data-insert-page="formazione.corsi.discente_popolazione.nuovo" data-placeholder="Scegli un discente..." multiple class="chosen-select discenti">
                            <?php 
                                foreach ($discenti as $i ) {
                                ?>
                                <option value="<?php echo $i->id ?>" selected><?php echo $i->nomeCompleto() ?></option>
                                <?php
                                }
                            ?>
                        </select>
                        <span>Inserisci il testo necessario per ricercare il volontario (nome, cognome, email o codice fiscale),<br/>
                            premi INVIO per aggiornare la lista e scegli un volontario dalla lista che appare.</span><br/>
                        <span>Aggiungi fino a <strong><?php echo $maxDiscenti ?> discenti</strong></span>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4 offset4">
                        <button type="submit" class="btn btn-success">
                            <i class="icon-ok"></i>
                            Procedi
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="span4">
        <?php /* include "formazione.corsi.discente_popolazione.nuovo.php" */ ?>
    </div>
</div>