<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaModale();

$comitati = $me->comitatiDiCompetenza();

if ( count($comitati) == 1 ) {
  $comitato = $comitati[0];
  redirect('attivita.idea&c=' . $comitato->oid());
}

?>

  <form action="?p=attivita.idea" method="GET">

    <input type="hidden" name="p" value="formazione.corsibase.idea" />
    <div class="modal fade automodal">
      <div class="modal-header">
        <h3><i class="icon-group muted"></i> Organizzatore</h3>
      </div>
      <div class="modal-body">
        <p>Seleziona l'unità organizzatrice del Corso Base.</p>
        <select name="c" class="input-xxlarge">
          <?php foreach ( $comitati as $comitato ) { ?>
          <option value="<?php echo $comitato->oid(); ?>"><?php echo $comitato->nomeCompleto(); ?></option>
          <?php } ?>
        </select>
        <p class="muted">Non sarà facilmente modificabile in seguito.</p>

      </div>
      <div class="modal-footer">
        <a href="javascript:history.go(-1);" class="btn">Annulla</a>
        <button type="submit" class="btn btn-primary">Avanti</button>
      </div>
    </div>
    
  </form>

  