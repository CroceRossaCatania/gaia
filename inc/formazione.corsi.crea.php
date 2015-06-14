<?php
/*
 * ©2014 Croce Rossa Italiana
 */
paginaPrivata();
caricaSelettore();

$tipologie = Certificato::elenco();

?>

<div class="row-fluid">

    <div class="span8">
        <h2><i class="icon-plus-square icon-calendar muted"></i> Corso di formazione</h2>
        <form action="?p=formazione.corsi.crea.ok" method="POST">
            <input value="1" name="idTitolo" id="idTitolo" type="hidden">
            <div class="alert alert-block alert-success">
                <div class="row-fluid">
                    <h4><i class="icon-question-sign"></i> Dati del corso...</h4>
                </div>
                <hr>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="tipologia"><i class="icon-certificate"></i> Tipologia</label>
                    </div>
                    <div class="span8">
                        <select>
                            <?php foreach ($tipologie as $t) { ?>
                                <option><?php echo $t->nome ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="tipologia"><i class="icon-building"></i> Luogo</label>
                    </div>
                    <div class="span8">
                        <input id="luogo" class="span12" name="luogo" value="" type="text">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="dataInizio"><i class="icon-calendar"></i> Data Di inizio</label>
                    </div>
                    <div class="span8">
                        <input id="dataInizio" class="span12 hasDatepicker" name="dataInizio" value="" type="text">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="dataFine"><i class="icon-calendar"></i> Data Di Fine</label>
                    </div>
                    <div class="span8">
                        <input id="dataFine" class="span12 hasDatepicker" name="dataFine" value="" type="text">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="dataFine"><i class="icon-user-md"></i> Direttore</label>
                    </div>
                    <div class="span8">
                        <a data-selettore="true" 
                           data-input="inputDirettore" 
                           data-autosubmit="true" 
                           data-comitati="<?php echo $corso->organizzatore; ?>"
                           class="btn btn-block btn-large">
                            Seleziona un direttore... <i class="icon-pencil"></i>
                        </a>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="dataFine"><i class="icon-user"></i> Istruttori</label>
                    </div>
                    <div class="span8">
                        <a data-selettore="true" 
                           data-input="inputDirettore" 
                           data-autosubmit="true" 
                           data-comitati="<?php echo $corso->istruttori; ?>"
                           class="btn btn-block btn-large">
                            Aggiungi un istruttore... <i class="icon-pencil"></i>
                        </a>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="dataFine"><i class="icon-user"></i> Istruttori aiuto</label>
                    </div>
                    <div class="span8">
                        <a data-selettore="true" 
                           data-input="inputDirettore" 
                           data-autosubmit="true" 
                           data-comitati="<?php echo $corso->istruttoriAiuto; ?>"
                           class="btn btn-block btn-large">
                            Aggiungi un istruttore... <i class="icon-pencil"></i>
                        </a>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4 offset8">
                        <button type="submit" class="btn btn-success">
                            <i class="icon-plus"></i>
                            Crea il corso
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