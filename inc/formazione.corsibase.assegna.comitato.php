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

<script type="text/javascript"><?php require './js/formazione.corsibase.scheda.js'; ?></script>
<div class="modal fade automodal">
    <div class="modal-header">
        <h3><i class="icon-group muted"></i> Unità dove sarà volontario <?= $u->nome; ?></h3>
    </div>
    <div class="modal-body">

        <p>Seleziona l'unità CRI dove <?= $u->nomeCompleto(); ?> sarà iscritto come Socio Ordinario.</p>
        <p>Questa operazione è fondamentale perchè da questo punto in poi la persona diventerà un
            socio CRI a tutti gli effetti e potrà pagare la quota.</p>
        <select id="com" name="com" class="input-xxlarge">
            <?php foreach ( $comitati as $com ) { ?>
            <option value="<?php echo $com->id; ?>"><?php echo $com->nomeCompleto(); ?></option>
            <?php } ?>
        </select>
        <p class="muted">Attenzione! Ciò che scegli non sarà facilmente modificabile in seguito.</p>
    </div>
    <div class="modal-footer">
        <a href="javascript:history.go(-1);" class="btn">Annulla</a>
        <a data-iscrizione="<?php echo $part->id; ?>" data-accetta="1" class="btn btn-success">
            <i class="icon-check"></i> Iscrivi
        </a>
    </div>
</div>
