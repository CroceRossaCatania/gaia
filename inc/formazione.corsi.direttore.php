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
        throw new Errore('Manomissione');
    }
} catch(Exception $e) {
    redirect('admin.corsi.crea&err');
}

if (!$c->modificabile()) {
    redirect('formazione.corsi.riepilogo&id='.$id);
}

// visto sopra, non dovrebbe mai scattare, ma chissà!

// controllare che l'utente possa modificare questo dannatissimo corso 
//paginaCorso($c);
caricaSelettoreDirettore();

// non dovrebbe mai essere vuoto a meno di crash nella pagina precedente di creazione
$certificato = Certificato::by('id', intval($c->certificato));

$d = new DateTime('@' . $c->inizio);

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
<?php if(!$me->admin) { ?>
                        <p>data-selettore-direttore="<?php echo $me->delegazioneAttuale()->comitato()->oid() ?>"</p>
<?php } ?>
                        <a data-selettore-direttore="true" 
                           data-input="direttore" 
                           class="btn btn-block btn-large">
                            Seleziona un direttore... <i class="icon-pencil"></i>
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