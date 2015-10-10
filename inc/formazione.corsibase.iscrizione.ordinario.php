<?php

/*
* ©2014 Croce Rossa Italiana
*/

controllaParametri(['id'], 'presidente.soci.ordinari&err');
paginaPrivata();
paginaModale();

$u = Utente::id($_GET['id']);
proteggiDatiSensibili($u, [APP_SOCI, APP_PRESIDENTE]);
paginaApp([APP_SOCI , APP_PRESIDENTE]);

/* Prendo un comitato da cui partire
a cercare per vedere se ci sono corsi base 
e faccio un po' di merda visto che copernico non c'è */

$comitato = $u->unComitato(MEMBRO_ORDINARIO);
if (!$comitato) {
    $comitato = $u->unComitato(MEMBRO_EXORDINARIO);
}


$start = $comitato->superiore();
if($start->nomeCompleto() == $start->superiore()->nomeCompleto()) {
    $start = $start->superiore();
}

$ramo = new RamoGeoPolitico($start);

$corsi = [];

foreach($ramo as $c) {
    $corso = $c->corsiBase(false, true);
    $corsi = array_merge($corsi, $corso);
}

if(!$corsi) {
    redirect("presidente.soci.ordinari&noCorsi");
}

?>

<form action="?p=formazione.corsibase.iscrizione.ordinario.ok" method="GET">
    <input type="hidden" name="p" value="formazione.corsibase.iscrizione.ordinario.ok" />
    <input type="hidden" name="id" value="<?= $u->id; ?>" />

    <div class="modal fade automodal">
        <div class="modal-header">
            <h3><i class="icon-group muted"></i> Corso base a cui iscrivere <?= $u->nome; ?></h3>
        </div>
        <div class="modal-body">

            <p>Selezione il corso base a cui <?= $u->nomeCompleto(); ?> sarà iscritto come partecipante.</p>
            <p>Questa operazione è fondamentale perchè da questo punto in poi la persona figurerà
            tra gli iscritti a questo corso base.</p>
            <p> Verrà inviata comunicazione al direttore del corso e verranno inviate a <?= $u->nome ?>
            le indicazioni per partecipare.</p>
            <select id="corso" name="corso" class="input-xxlarge">
                <?php foreach ( $corsi as $corso ) { ?>
                <option value="<?php echo $corso->id; ?>"><?= $corso->progressivo() ?> - <?php echo $corso->nome(); ?></option>
                <?php } ?>
            </select>
            <p class="muted">Attenzione! Ciò che scegli non sarà facilmente modificabile in seguito.</p>
        </div>
        <div class="modal-footer">
            <a href="javascript:history.go(-1);" class="btn">Annulla</a>
            <button type="submit" class="btn btn-success">
                <i class="icon-check"></i> Iscrivi
            </button>
        </div>
    </div>
</form>
