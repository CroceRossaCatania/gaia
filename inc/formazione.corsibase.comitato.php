<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();
paginaModale();

$comitati = $me->comitatiDiCompetenza();

if ( count($comitati) == 1 ) {
  $comitato = $comitati[0];
  redirect('formazione.corsibase.idea&c=' . $comitato->oid());
}

?>

  <form action="?p=formazione.corsibase.idea" method="GET">

    <input type="hidden" name="p" value="formazione.corsibase.idea" />
    <div class="modal fade automodal">
      <div class="modal-header">
        <h3><i class="icon-group muted"></i> Organizzatore</h3>
      </div>
      <div class="modal-body">
        <p>Seleziona la struttura organizzatrice del Corso Base.</p>
        <select name="c" class="input-xxlarge">
          <?php foreach ( $comitati as $comitato ) { ?>
          <option value="<?php echo $comitato->oid(); ?>"><?php echo $comitato->nomeCompleto(); ?></option>
          <?php } ?>
        </select>
        <p class="muted">Non sarà facilmente modificabile in seguito.</p>
        <div class="alert alert-info">
        <p><i class="icon-warning-sign"></i> Se la struttura selezionata non ha ancora un indirizzo valido, dovrai prima provvedere
        a risolvere inserirlo e poi rifare l'attivazione del Corso Base.</p>
        </div>

      </div>
      <div class="modal-footer">
        <a href="javascript:history.go(-1);" class="btn">Annulla</a>
        <button type="submit" class="btn btn-primary">Avanti</button>
      </div>
    </div>
    
  </form>

  