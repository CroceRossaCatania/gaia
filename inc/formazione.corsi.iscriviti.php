<?php

/*
 * ©2013 Croce Rossa Italiana
 */

//paginaPubblica();
paginaModale();
//paginaCorsoBase();

$comitati = $me->comitatiAreeDiCompetenza();

//if ( count($comitati) == 1 ) {
//  $comitato = $comitati[0];
//  redirect('attivita.idea&c=' . $comitato->oid());
//}

if (!true) {
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
    <form action="?p=formazione.corsi.iscriviti.ok" method="POST">
        <div class="modal fade automodal">
            <div class="modal-header">
                <h3><i class="icon-group muted"></i>Iscrizione al corso</h3>
            </div>
            <div class="modal-body">

                <input type="hidden" name="p" value="formazione.corsi.iscriviti.ok" />
                <div class="control-group">
                    <label class="control-label" for="inputNome">Nome</label>
                    <div class="controls">
                        <input type="text" name="inputNome" id="inputNome" required="" <?php if ($me) echo 'readonly=""' ?> value="<?php echo $me->nome ?>">
                        <!--<acronym title="Per modificare, contatta supporto@gaia.cri.it">&nbsp; <i class="icon-lock icon-large"></i></acronym>-->
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputCognome">Cognome</label>
                    <div class="controls">
                        <input type="text" name="inputCognome" id="inputCognome" required="" <?php if ($me) echo 'readonly=""' ?> value="<?php echo $me->cognome ?>">
                        <!--<acronym title="Per modificare, contatta supporto@gaia.cri.it">&nbsp; <i class="icon-lock icon-large"></i></acronym>-->
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputTelefono">Recapito telefonico</label>
                    <div class="controls">
                        <input type="text" id="inputTelefono" name="inputTelefono" pattern="[0-9]{5,}" <?php if ($me) echo 'readonly=""' ?> value="<?php echo $me->cellulare ?>"><br/>
                        <span class="muted">Inserire solo cifre, senza spazi o altri caratteri</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Email</label>
                    <div class="controls">
                        <input type="email" id="inputEmail" name="inputEmail" required="" <?php if ($me) echo 'readonly=""' ?> value="<?php echo $me->email ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputRichiesta">Note</label>
                    <div class="controls">
                        <textarea  id="inputRichiesta" name="inputRichiesta" required="true" rows="10"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:history.go(-1);" class="btn">Annulla</a>
                <button type="submit" class="btn btn-primary">Avanti</button>
            </div>
        </div>
    </form>
  <?php } ?>
  