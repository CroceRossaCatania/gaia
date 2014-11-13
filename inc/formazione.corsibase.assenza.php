<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();
controllaParametri(['id']);

$admin = $me->admin();

$lezione = Lezione::id($_GET['id']);
$corso = $lezione->corso();


paginaCorsoBase($corso);
?>

<?php if ( isset($_GET['date']) ) { ?>
<div class="alert alert-error">
    <i class="icon-warning-sign"></i> <strong>Data non valida</strong>.
    Hai inserito una data non valida. Non possono essere modificate date passate, per correggere
    contatta il supporto.
</div>
<?php } ?>
<a href="?p=formazione.corsibase.scheda&id=<?= $corso ?>" class="btn btn-small btn-primary">
    <i class="icon-reply"></i> Torna alla Scheda del Corso
</a>

<h3 class="allinea-centro"><?= $corso->nome(); ?></h3>
<h2 class="allinea-centro text-success"><i class="icon-calendar"></i> Gestione delle assenze</h2>
<h4 class="allinea-centro"><?= $lezione->nome ?> - giorno: <?= $lezione->inizio()->inTesto(false) ?></h4>
<hr />

<div class="row-fluid">
    <div class="span12">
        <form method="POST" action="?p=formazione.corsibase.assenza.ok" class="form-horizontal" id="verbale">
            <input type="hidden" name="id" value="<?= $lezione ?>">
            <table class="table table-striped table-bordered" id="tabellaUtenti">
                <thead>
                    <th>Nominativo</th>
                    <th>Presente</th>
                    <th>Assente</th>
                </thead>
                <tbody>
                <?php
                $part = $corso->partecipazioni(ISCR_CONFERMATA);
                foreach ( $part as $p ) { 
                    $iscritto = $p->utente(); 
                    $assente = (bool) AssenzaLezione::filtra([['utente', $iscritto], ['lezione', $lezione]]); ?>
                    <tr>
                        <td><?= $iscritto->nomeCompleto() ?></td>
                        <td><input type="radio" name="assenza_<?= $iscritto ?>" value="1" 
                            <?php if(!$assente) echo("checked"); ?> /></td>
                        <td><input type="radio" name="assenza_<?= $iscritto ?>" value="2"
                            <?php if($assente) echo("checked"); ?> /></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php if(!$corso->concluso()){ ?>
            <button class="btn btn-block btn-large btn-success">
                Salva
            </button>
            <?php } ?>
        </form>
    </div>
</div>