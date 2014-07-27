<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaAttivita();
paginaModale();

if (!isset($_GET['c'])) {
    redirect('attivita.comitato');
}
$c = $_GET['c'];
$c = GeoPolitica::daOid($c);

$comitati = $me->comitatiAreeDiCompetenza();
$aree     = $me->areeDiCompetenza($c);

if (!in_array($c, $comitati)) {
    redirect('attivita.comitato&sicurezza');
}
?>
<form action="?p=attivita.idea.ok" method="POST">

    <input type="hidden" name="comitato" value="<?php echo $c->oid(); ?>" />

    <div class="modal fade automodal">
        <div class="modal-header">
          <h3>Nuova attività</h3>
      </div>
      <div class="modal-body">
        <p><strong>Organizzatore</strong><br />
            <?php echo $c->nomeCompleto(); ?></p>
            <hr />
            <p><strong>Area di intervento</strong></p>
            <p>È importante conoscere l'area di intervento di un'attività.<br />Questo permetterà a Gaia di categorizzarla.</p>
            <select name="inputArea" class="input-xxlarge">
              <?php foreach ( $aree as $area ) { ?>
              <option value="<?php echo $area->id; ?>"><?php echo $area->nomeCompleto(); ?></option>
              <?php } ?>
          </select>
          <?php if ( in_array($c, $me->comitatiDiCompetenza() ) ) { ?>
          <p><a href="?p=presidente.comitato&oid=<?php echo $c->oid(); ?>"><i class="icon-pencil"></i> Modifica od aggiungi aree dal pannello presidente</a>.</p>
          <?php } ?>
          <hr />
          <p><strong>Nome dell'attività</strong></p>
          <p>Ricorda: I nomi migliori son corti e memorabili.</p>
          <input type="text" required name="inputNome" class="input-xlarge" placeholder="es.: Aggiungi un posto a tavola" />
          <?php if($c->_estensione() < EST_NAZIONALE) { ?>
          <input type="hidden" name="inputGruppo" value="0" />
          <label>
              <input type="checkbox" name="inputGruppo" value="1" />
              <span class="muted">Opzionale &mdash;</span> Creare un <strong>Gruppo di lavoro</strong> per l'attività?
          </label>
          <?php } ?>
          
      </div>
      <div class="modal-footer">
          <a href="?p=attivita" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary">
              <i class="icon-asterisk"></i> Crea attività
          </button>
      </div>
  </div>
  
</form>
