<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaModale();
paginaAttivita();

$comitati = $me->comitatiAreeDiCompetenza();

if ( count($comitati) == 1 ) {
    $comitato = $comitati[0];
    redirect('attivita.idea&c=' . $comitato->id);
}

/* Se non ci sono Aree create... */
if (!$comitati) {
?>


<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-ambulance"></i> C'è stato un problema...</h3>
        </div>
        <div class="modal-body">
          <p class="text-error"><i class="icon-warning-sign"></i> Impossibile creare attività finché non viene stabilito uno dei seguenti:<br/><strong>Delegati obiettivi</strong> e/oppure <strong>Aree di intervento</strong>.</p>
          <hr />
          <p>Niente panico. Come risolvere:</p>
          <ul>
              
              <li>
                  <strong>Nomina un delegato obiettivo strategico</strong><br />
                  Così facendo, verrà creata un'area di intervento per l'obiettivo.<br />
                  Puoi anche creare più Aree di Intervento per lo stesso obiettivo strategico.
              </li>      
          </ul>
                        
        </div>
        <div class="modal-footer">
          <a href="javascript:history.go(-1);" class="btn">Torna</a>
          <a href="?p=presidente.dash" class="btn btn-danger">Apri il pannello presidente per risolvere</a>
        </div>
</div>
    

<?php } else { ?>

<form action="?p=attivita.idea" method="GET">

<input type="hidden" name="p" value="attivita.idea" />
<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-group muted"></i> Organizzatore</h3>
        </div>
        <div class="modal-body">
          <p>Seleziona l'unità organizzatrice dell'attività.</p>
          <select name="c" class="input-xxlarge">
              <?php foreach ( $comitati as $comitato ) { ?>
              <option value="<?php echo $comitato->id; ?>"><?php echo $comitato->nomeCompleto(); ?></option>
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
<?php } ?>