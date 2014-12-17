<?php

/*
* ©2014 Croce Rossa Italiana
*/

controllaParametri(array('id', 'asp'), 'formazione.corsibase');
paginaPrivata();
paginaModale();

$part = PartecipazioneBase::id($_GET['id']);
$corso = $part->corsoBase();
$comitato = $corso->organizzatore();
$u = Utente::id($_GET['asp']);

paginaCorsoBase($corso);

if(!$corso->iniziato()) {
    redirect("formazione.corsibase.scheda&id={$corso}&err");
}

$comitati = new RamoGeoPolitico($comitato, ESPLORA_SOLO_FOGLIE, EST_UNITA);
?>

<script type="text/javascript"><?php require './assets/js/formazione.corsibase.scheda.js'; ?></script>
<div class="modal fade automodal">
    <div class="modal-header">
        <h3><i class="icon-group muted"></i> Stai iscrivendo <?= $u->nome; ?> come Socio Ordinario</h3>
    </div>
    <div class="modal-body">
        <p>Accettare una preiscrizione significa iscrivere nel ruolo di <strong>Socio Ordinario</strong> una persona
        che ne ha fatto richiesta. Per favore conferma che l'aspirante Volontario sia in regola
        con quanto segue:</p>
        <ul>
            <li> <input type="checkbox"  name="condizioni" value="1"> <?= $u->nomeCompleto(); ?> ha chiesto di diventare
            Socio Ordinario della Croce Rossa Italiana </li>
            <li> <input type="checkbox"  name="condizioni" value="2"> <?= $u->nomeCompleto(); ?> ha preso visione dello
            Statuto della Croce Rossa Italiana </li>
            <li> <input type="checkbox"  name="condizioni" value="3"> <?= $u->nomeCompleto(); ?> ha preso visione del
            Codice di Condotta per il personale della Croce Rossa Italiana </li>
            <li> <input type="checkbox"  name="condizioni" value="4"> <?= $u->nomeCompleto(); ?> è in regola con quanto
            previsto dal regolamento per l'accesso al ruolo di Socio Ordinario della Croce Rossa Italiana </li>
        </ul>
        <div class="nascosto" id="altreInfo">
        <p>Seleziona ora l'unità CRI dove <?= $u->nomeCompleto(); ?> sarà iscritto come Socio Ordinario.</p>
        <p>Questa operazione è fondamentale perchè da questo punto in poi la persona diventerà un
            socio CRI a tutti gli effetti e potrà essere registrato il pagamento della quota.</p>
        <select id="com" name="com" class="input-xxlarge">
            <?php foreach ( $comitati as $com ) { ?>
            <option value="<?php echo $com->id; ?>"><?php echo $com->nomeCompleto(); ?></option>
            <?php } ?>
        </select>
        <p class="muted">Attenzione! Ciò che scegli non sarà facilmente modificabile in seguito.</p>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:history.go(-1);" class="btn">Annulla</a>
        <a id="bottoneAccetta" data-iscrizione="<?php echo $part->id; ?>" data-accetta="1" class="btn btn-success nascosto">
            <i class="icon-check"></i> Iscrivi
        </a>
    </div>
</div>
