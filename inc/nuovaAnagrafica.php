<?php

/*
 * ©2013 Croce Rossa Italiana
 */

if ( !($sessione->stoRegistrando) ) {
  redirect('riconoscimento&e2');
}

$p = new Persona($sessione->stoRegistrando);
if ( ($p->password) ) {
  redirect('giaRegistrato');
}

?>

<div class="row-fluid">
    <div class="span12 centrato">
        <?php if ( $sessione->tipoRegistrazione == VOLONTARIO ) { ?>
            <h2>Ciao, volontario. <span class="muted">Croce Rossa si rinnova.</span></h2>
        <?php } else { ?>
            <h2>Ciao, aspirante. <span class="muted">Croce Rossa si rinnova.</span></h2>
        <?php } ?>
        <hr />
    </div>
</div>



<div class="row-fluid">
    <div class="span4">
        <h2>
            <i class="icon-pencil"></i>
            Completa
        </h2>
        <?php if ( $sessione->tipoRegistrazione == VOLONTARIO ) { ?>
        <p>
            Ti permetterà di accedere ai servizi online.
        </p>
        <?php } ?>
        <p>
            Completa e conferma la registrazione inserendo i tuoi dettagli anagrafici.
        </p>

        <div class="alert alert-block alert-info">
            <h4>Attenzione!</h4>
            <p>Sono necessari 14 anni per essere volontari di Croce Rossa e iscriversi a Gaia.</p>
        </div>

    </div>
    <div class="span8">
      <?php if (isset($_GET['data'])) { ?>
        <div class="alert alert-block alert-error">
            <h4>Data di nascita errata</h4>
            <p>La data di nascita che hai inserito non è corretta.</p>
            <p>Il formato corretto della data di nascita è gg/mm/aaaa.</p>
        </div>
      <?php } ?>
      <?php if (isset($_GET['eta'])) { ?>
        <div class="alert alert-block alert-error">
            <h4>Ci dispiace molto!</h4>
            <p>Sono necessari 14 anni per essere volontari di Croce Rossa.</p>
        </div>
      <?php } ?>
      <?php if (isset($_GET['err'])) { ?>
          <div class="alert alert-block alert-error">
              <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
              <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
          </div> 
      <?php } ?>
          <form class="form-horizontal" action="?p=nuovaAnagrafica.ok" method="POST">
          <input type="hidden" name="id" value="<?php echo $p->id; ?>" />
          <div class="control-group">
            <label class="control-label" for="inputNome">Nome</label>
            <div class="controls">
              <input value="<?php echo $sessione->nome; ?>" type="text" id="inputNome" name="inputNome" placeholder="es.: Mario" required autofocus pattern=".{2,}" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputCognome">Cognome</label>
            <div class="controls">
              <input value="<?php echo $sessione->cognome; ?>" type="text" id="inputCognome" name="inputCognome" placeholder="es.: Rossi" required pattern=".{2,}" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputSesso">Sesso</label>
            <div class="controls">
                <select class="input-small" id="inputSesso" name="inputSesso" required>
                <?php
                    foreach ( $conf['sesso'] as $numero => $tipo ) { ?>
                    <option value="<?php echo $numero; ?>"><?php echo $tipo; ?></option>
                    <?php } ?>
                </select>   
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputCodiceFiscale">Cod. Fiscale</label>
            <div class="controls">
              <input value="<?php echo $p->codiceFiscale; ?>" class="input-large" readonly="readonly" type="text" id="inputCodiceFiscale" name="inputCodiceFiscale" required  pattern="[A-Za-z0-9]{16}" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputDataNascita">Data di nascita</label>
            <div class="controls">
              <input value="<?php echo $sessione->dnascita; ?>" class="input-small" type="text" id="inputDataNascita" name="inputDataNascita" required />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputProvinciaNascita">Provincia di Nascita</label>
            <div class="controls">
              <input value="<?php echo $sessione->prnascita; ?>" class="input-mini" type="text" id="inputProvinciaNascita" name="inputProvinciaNascita" required pattern="[A-Za-z]{2}" />
              &nbsp; <span class="muted">ad es.: CT</span>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputComuneNascita">Comune di Nascita</label>
            <div class="controls">
              <input value="<?php echo $sessione->conascita; ?>" type="text" id="inputComuneNascita" name="inputComuneNascita" required />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputIndirizzo">Indirizzo</label>
            <div class="controls">
              <input value="<?php echo $sessione->indirizzo; ?>" type="text" id="inputIndirizzo" name="inputIndirizzo" required />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputCivico">Civico</label>
            <div class="controls">
              <input value="<?php echo $sessione->civico; ?>" type="text" id="inputCivico" name="inputCivico" class="input-small" required />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputComuneResidenza">Comune di residenza</label>
            <div class="controls">
              <input value="<?php echo $sessione->coresidenza; ?>" type="text" id="inputComuneResidenza" name="inputComuneResidenza" required />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputCAPResidenza">CAP di residenza</label>
            <div class="controls">
              <input value="<?php echo $sessione->caresidenza; ?>" class="input-small" type="text" id="inputCAPResidenza" name="inputCAPResidenza" required pattern="[0-9]{5}" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputProvinciaResidenza">Provincia di residenza</label>
            <div class="controls">
              <input value="<?php echo $sessione->prresidenza; ?>" class="input-mini" type="text" id="inputProvinciaResidenza" name="inputProvinciaResidenza" required pattern="[A-Za-z]{2}" />
              &nbsp; <span class="muted">ad es.: CT</span>
            </div>
          </div>
          <div class="control-group">
                <label class="checkbox" for="inputConsenso">
                    <input type="checkbox" id="inputConsenso" name="inputConsenso" required>Acconsento al trattamento sui dati personali nel rispetto delle attuali <a href="javascript:" onclick="window.open('/inc/public.disclaimer.php', 'disclaimer', 'width=600, height=500, resizable, status, scrollbars=1, location');"><i class="icon-link"></i>normative vigenti</a>.
                </label>
          </div>
          <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-success">
                  <i class="icon-ok"></i>
                  Registrati
              </button>
            </div>
          </div>
        </form>

    </div>
</div>