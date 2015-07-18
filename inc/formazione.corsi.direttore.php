<?php
/*
 * ©2015 Croce Rossa Italiana
 */
controllaParametri(['id'], 'admin.corsi.crea&err');

$t = Corso::id(intval($_GET['id']));
if (empty($t)) {
    redirect('admin.corsi.crea&err');
}

// controllare che l'utente possa modificare questo dannatissimo corso 
paginaCorso($t);
caricaSelettoreDirettore();

$certificato = Certificato::by('id', intval($t->certificato));

?>

<div class="row-fluid">

    <div class="span8">
        <h2><i class="icon-plus-square icon-calendar muted"></i> Corso di formazione</h2>
        <form action="?p=formazione.corsi.crea.ok" method="POST">
            <input value="1" name="idCorso" id="idCorso" type="hidden">
            <div class="alert alert-block alert-success">
                <div class="row-fluid">
                    <h4><i class="icon-question-sign"></i> Direttore per <?php echo $certificato->nome ?></h4>
                </div>
                <hr>
                <div class="row-fluid">
                    <div class="span12">
                        <ul>
                            <li>Punto di riferimento per gli aspiranti volontari che vogliono partecipare al corso base e per i docenti;</li>
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
                        <a data-selettore-direttore="true" 
                           data-input="direttore" 
                           class="btn btn-block btn-large">
                            Seleziona un direttore... <i class="icon-pencil"></i>
                        </a>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4 offset8">
                        <button type="submit" class="btn btn-success">
                            <i class="icon-plus"></i>
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