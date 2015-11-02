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
        throw new Exception('Manomissione');
    }
    $tipoCorso = TipoCorso::id($c->tipo);
    $lezioni = $c->giornateCorso();
    $ruolo = $tipoCorso->ruoloDocenti;
    $qualifica = $tipoCorso->qualifica;

} catch(Exception $e) {
    redirect('admin.corsi.crea&err='.CORSO_ERRORE_CORSO_NON_TROVATO);
}

if (!$c->modificabile()) {
    redirect('formazione.corsi.riepilogo&id='.$id);
}

$partecipazioni = PartecipazioneCorso::filtra([
    ['corso', $c->id],
    ['ruolo', CORSO_RUOLO_DOCENTE]
]);
$docenti = [];
foreach ($partecipazioni as $p) {
    $docenti[] = $p->volontario();
}
unset($partecipazioni);


// carica i selettori
caricaSelettoreDocente([
    'max_selected_options' => 1,
    'no_results_text' => 'Nessun docente trovato',
]);

?>
<?php if ( isset($_GET['date']) ) { ?>
<div class="alert alert-error">
    <i class="icon-warning-sign"></i> <strong>Data non valida</strong>.
    Hai inserito una data non valida. Non possono essere modificate date passate, per correggere
    contatta il supporto.
</div>
<?php } ?>
<script>
var minDateOffset = <?php echo TipoCorso::limiteMinimoPerIscrizione() ?>;
</script>
<h2 class="allinea-centro"><?= $tipoCorso->nome; ?></h2>
<h3 class="allinea-centro text-success"><i class="icon-calendar"></i> Gestione delle lezioni</h3>

<hr />

<div class="row">
    <div class="span12">

        <form action="?p=formazione.corsi.lezioni.aggiungi&id=<?= $c->id; ?>" method="POST">
        <table class="table table-bordered table-striped">
            <thead>
                    <th>Titolo</th>
                    <th>Luogo e Data</th>
                    <th>Dettagli</th>
                    <th>&nbsp;</th>
            </thead>
            <tbody>

                <?php foreach ( $lezioni as $lezione ) { ?>
                    <tr class="modificabile">
                        <td>
                            <?php echo $lezione->nome ?><br/>[<?php echo $lezione->docente()->nomeCompleto() ?>]
                        </td>
                        <td>
                            <?php echo $lezione->luogo ?><br/><?php echo $lezione->data()->inTesto() ?>
                        </td>
                        <td>
                            <?php echo $lezione->note ?>
                        </td>
                        <td>
                            <a href="?p=formazione.corsi.lezioni.cancella&id=<?= $lezione->id; ?>" class="btn btn-block btn-danger"
                                    data-conferma="Rimuovendo la lezione. Continuare?">
                                    <i class="icon-trash"></i>
                                    Rimuovi lezione
                            </a>
                        </td>
                    </tr>
                <?php } ?>

                <!-- Aggiunta di una nuova lezione -->
                <tr id="nuovo" class="success">
                    <td>
                        <input type="text" name="nome" class="input-block"
                            placeholder="Nome della nuova lezione" required maxlength="64" /><br/>
                        <select name="docenti[]" 
                                data-ruolo="<?php echo $ruolo; ?>"
                                data-qualifica="<?php echo $qualifica; ?>"
                                data-placeholder="Scegli un docente..." class="chosen-select docenti">
                            <?php 
                                foreach ($docenti as $i ) {
                                ?>
                                <option value="<?php echo $i->id ?>" selected><?php echo $i->nomeCompleto() ?></option>
                                <?php
                                }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="input-block" name="luogo" required placeholder="Luogo della lezione" /><br/>
                        <input type="text" class="input-block" name="data" id="data" required placeholder="Data della lezione" />
                    </td>
                    <td>
                        <textarea class="" name="note" required placeholder="Note per la lezione" ></textarea>
                    </td>
                    <td>
                        <button type="submit" name="azione" value="aggiungi"
                         class="btn btn-success btn-block">
                                <i class="icon-plus"></i>
                                Aggiungi Lezione
                        </button>
                    </td>
                </tr>

            </tbody>

        </table>
        </form>

    </div>
    <div class="span9">
    </div>
    <div class="span3">
        <?php
        if (!empty($_POST['wizard'])) {
            ?>
            <a href="?p=formazione.corsi.discenti&id=<?= $c->id; ?>" class="btn btn-block btn-success">
                Procedi
            </a>
            <?php
        } else {
            ?>
            <a href="?p=formazione.corsi.riepilogo&id=<?= $c->id; ?>" class="btn btn-block btn-success">
                Procedi
            </a>
            <?php
        }
        ?>
    </div>
</div>
        

