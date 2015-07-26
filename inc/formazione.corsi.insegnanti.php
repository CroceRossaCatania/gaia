<?php
/*
 * ©2015 Croce Rossa Italiana
 */
paginaPresidenziale();

controllaParametri(['id'], 'admin.corsi.crea&err');

// try catch da usare per evitare stampa dell'errore e poter fare redirect 
$id = intval($_GET['id']);
try {
    $c = Corso::id($id);
    if (empty($c)) {
        throw new Exception('Manomissione');
    }
    $certificato = Certificato::by('id', intval($c->certificato));

} catch(Exception $e) {
    redirect('admin.corsi.crea&err');
}

if (!$c->modificabile()) {
    redirect('formazione.corsi.riepilogo&id='.$id);
}

// calcola il numero massimo di insegnanti per il corso
$maxInsegnanti = $c->numeroInsegnantiNecessari();

// recupera gli id di insegnanti già presenti per il corso
// per popolare automaticamente la lista in caso di pagina di modifica
$_insegnanti = Partecipazione::filtra([
    ['corso', $c->id],
    ['ruolo', CORSO_RUOLO_INSEGNANTE]
]);
$insegnanti = [];
foreach ($_insegnanti as $i) {
    $insegnanti[] = $i->id;
}
unset($_insegnanti);

// carica i selettori
caricaSelettoreInsegnante();
caricaSelettoreInsegnanteInAffiancamento();

$d = new DateTime('@' . $c->inizio);

?>

<div class="row-fluid">

    <div class="span8">
        <h2><i class="icon-plus-square icon-calendar muted"></i> Corso di formazione</h2>
        <form action="?p=formazione.corsi.insegnanti.ok" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <div class="alert alert-block alert-success">
                <div class="row-fluid">
                    <h4><i class="icon-question-sign"></i> Insegnanti per <?php echo $certificato->nome ?> del <?php echo $d->format('d/m/Y'); ?></h4>
                </div>
                <hr>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="dataFine"><i class="icon-user"></i> Insegnanti</label>
                    </div>
                    <div class="span8">
                        <a data-selettore-insegnante="true" 
                           data-input="insegnanti" 
                           data-multi="<?php echo $maxInsegnanti ?>"
                           class="btn btn-block btn-large">
                            Aggiungi <?php echo $maxInsegnanti ?> insegnanti... <i class="icon-pencil"></i>
                        </a>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="dataFine"><i class="icon-user"></i> Insegnanti in affiancamento</label>
                    </div>
                    <div class="span8">
                        <a data-selettore-insegnante-affiancamento="true" 
                           data-input="insegnanti-affiancamento" 
                           data-multi="<?php echo $maxInsegnanti ?>"
                           class="btn btn-block btn-large">
                            Aggiungi <?php echo $maxInsegnanti ?> insegnanti in affiancamento... <i class="icon-pencil"></i>
                        </a>
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
                        Eliminare il corso --> annulla
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