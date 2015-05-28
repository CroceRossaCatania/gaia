<?php
/*
 * ©2014 Croce Rossa Italiana
 */
$_titolo = "Calencario dei Corsi";
?>

<div class="row-fluid">

    <div class="span8">
        <h2><i class="icon-plus-square icon-calendar muted"></i> Competenze personali</h2>
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
                            <option>tipologia</option>
                        </select>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="tipologia"><i class="icon-building"></i> Sede</label>
                    </div>
                    <div class="span8">
                        <select>
                            <option>tipologia</option>
                        </select>
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
                        <select>
                            <option>tipologia</option>
                        </select>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="dataFine"><i class="icon-user"></i> Istruttori</label>
                    </div>
                    <div class="span8">
                        <select class="chosen-select">
                            <option>tipologia</option>
                        </select>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="dataFine"><i class="icon-user"></i> Istruttori aiuto</label>
                    </div>
                    <div class="span8">
                        <select class="chosen-select">
                            <option>tipologia</option>
                        </select>
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