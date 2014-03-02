<?php

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(array('id', 'asp'), 'formazione.corsibase');
paginaPrivata();
paginaModale();

$corso = CorsoBase::id($_GET['id']);
$comitato = GeoPolitica::daOid($corso->organizzatore);
$u = Utente::id($_GET['asp']);

paginaCorsoBase($corso);

if ( $comitato instanceof Comitato ) {
  redirect("formazione.corsibase.assegna.comitato.ok&c={$comitato->oid()}&vol={$u->id}");
}
$comitati = new RamoGeoPolitico($comitato, ESPLORA_SOLO_FOGLIE);
?>

  <form action="?p=attivita.idea" method="GET">

    <input type="hidden" name="p" value="formazione.corsibase.assegna.comitato.ok?vol=<?= $u->id; ?>" />
    <div class="modal fade automodal">
      <div class="modal-header">
        <h3><i class="icon-group muted"></i> Unità dove sarà volontario <?= $u->nome; ?></h3>
      </div>
      <div class="modal-body">
        <p>Seleziona l'unità CRI dove <?= $u->nomeCompleto(); ?> sarà iscritto come Socio Ordinario.</p>
        <p>Questa operazione è fondamentale perchè da questo punto in poi la persona diventerà un
        socio CRI a tutti gli effetti e potrà pagare la quota.</p>
        <select name="c" class="input-xxlarge">
          <?php foreach ( $comitati as $comitato ) { ?>
          <option value="<?php echo $comitato->oid(); ?>"><?php echo $comitato->nomeCompleto(); ?></option>
          <?php } ?>
        </select>
        <p class="muted">Attenzione! Ciò che scegli non sarà facilmente modificabile in seguito.</p>

      </div>
      <div class="modal-footer">
        <a href="javascript:history.go(-1);" class="btn">Annulla</a>
        <button type="submit" class="btn btn-primary">Avanti</button>
      </div>
    </div>
    
  </form>

  