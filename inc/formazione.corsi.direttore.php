<?php
/*
 * ©2015 Croce Rossa Italiana
 */
paginaPresidenziale(null, null, APP_OBIETTIVO, OBIETTIVO_1);

controllaParametri(['id'], 'admin.corsi.crea&err');

// try catch da usare per evitare stampa dell'errore e poter fare redirect 
$id = intval($_GET['id']);
$wizard = intval($_GET['wizard']);
try {
    $c = Corso::id($id);
    if (empty($c)) {
        throw new Errore('Manomissione');
    }
} catch(Exception $e) {
    redirect('admin.corsi.crea&err');
}

if (!$c->modificabile()) {
    redirect('formazione.corsi.riepilogo&id='.$id);
}

$maxDirettori = 1;

// recupera gli id di discenti già presenti per il corso
// per popolare automaticamente la lista in caso di pagina di modifica
$partecipazioni = PartecipazioneCorso::filtra([
    ['corso', $c->id],
    ['ruolo', CORSO_RUOLO_DIRETTORE]
]);
$direttori = [];
foreach ($partecipazioni as $p) {
    $direttori[] = $p->volontario();
}
unset($partecipazioni);


// controllare che l'utente possa modificare questo dannatissimo corso 
//paginaCorso($c);
caricaSelettoreDirettore([
    'max_selected_options' => $maxDirettori,
    'no_results_text' => 'Ricerca direttore in corso...',
]);

// non dovrebbe mai essere vuoto a meno di crash nella pagina precedente di creazione

$tipocorso = TipoCorso::id(intval($c->tipo));
$d = new DateTime('@' . $c->inizio);


$ruolo = $tipocorso->ruoloDirettore;
$qualifica = $tipocorso->qualifica;
?>

<div class="row-fluid">

    <div class="span8">
        <h2><i class="icon-plus-square icon-calendar muted"></i> Corso di formazione</h2>
        <form action="?p=formazione.corsi.direttore.ok" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <input value="<?php echo empty($wizard) ? 0 : 1 ?>" name="wizard" type="hidden">
            <div class="alert alert-block alert-success">
                <div class="row-fluid">
                    <h4><i class="icon-question-sign"></i> Direttore per <?php echo $certificato->nome ?> del <?php echo $d->format('d/m/Y'); ?></h4>
                </div>
                <hr>
                <div class="row-fluid">
                    <div class="span12">
                        <ul>
                            <li>Punto di riferimento per gli aspiranti volontari che vogliono partecipare al corso e per i docenti;</li>
                            <li>I suoi contatti verranno divulgati agli aspiranti volontari interessati al corso;</li>
                            <li>Generalmente è presente durante le lezioni e conosce i docenti.</li>
                        </ul>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="dataFine"><i class="icon-user-md"></i> Direttore</label>
                    </div>
                    <div class="span8">
                        <select name="direttori[]" 
                                data-ruolo="<?php echo $ruolo;?>"
                                data-qualifica="<?php echo $qualifica;?>"
                                data-insert-page="formazione.corsi.direttore.nuovo" data-placeholder="Scegli un direttore..." multiple class="chosen-select direttori">
                            <?php 
                                foreach ($direttori as $i ) {
                                ?>
                                <option value="<?php echo $i->id ?>" selected><?php echo $i->nomeCompleto() ?></option>
                                <?php
                                }
                            ?>
                        </select>
                        <span>Seleziona un direttore</span>
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
        <h4 style="line-height:40px">Azioni</h4>
        <nav>
            <ul style="list-style-type: none">
                <li>
                    <a class="btn btn-danger" href="?p=utente.me">
                        <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                        Eliminare
                    </a>
                </li>
                <li>
                    <a class="btn btn-danger" href="?p=utente.me">
                        <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                        Convalidare
                    </a>
                </li>
                <li>
                    <a class="btn btn-danger" href="?p=utente.me">
                        <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                        richiedi iscrizione
                    </a>
                </li>
                <li>
                    <a class="btn btn-danger" href="?p=utente.me">
                        <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                        chiudi corso -> valutazione
                    </a>
                </li>
            </ul>
        </nav>

    </div>
</div>