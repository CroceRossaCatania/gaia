<?php

/*
 * ©2012 Croce Rossa Italiana
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
        <p>
            In ottemperanza alle norme nazionali sulla privacy, Croce Rossa Italiana - Comitato Provinciale di Catania tratta i dati personali nel rispetto delle <a href="javascript:" onclick="window.open('/inc/disclaimer.php', 'disclaimer', 'width=600, height=500, resizable, status, scrollbars=1, location');"><i class="icon-link"></i>normative vigenti</a>.
        </p>
        <p>Cliccando su Registrati accetti la nota sulla privacy.</p>
    </div>
    <div class="span8">
          <form class="form-horizontal" action="?p=nuovaAnagrafica.ok" method="POST">
          <input type="hidden" name="id" value="<?php echo $p->id; ?>" />
          <div class="control-group">
            <label class="control-label" for="inputNome">Nome</label>
            <div class="controls">
              <input value="<?php echo $p->nome; ?>" type="text" id="inputNome" name="inputNome" placeholder="es.: Mario" required autofocus pattern=".{2,}" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputCognome">Cognome</label>
            <div class="controls">
              <input value="<?php echo $p->cognome; ?>" type="text" id="inputCognome" name="inputCognome" placeholder="es.: Rossi" required pattern=".{2,}" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputCodiceFiscale">Cod. Fiscale</label>
            <div class="controls">
              <input value="<?php echo $p->codiceFiscale; ?>" class="input-large" readonly="readonly" type="text" id="inputCodiceFiscale" name="inputCodiceFiscale" required  pattern="[A-Za-z0-9]{16}" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Data di nascita</label>
            <?php $dataNascita = date('d-m-Y', $p->dataNascita); $array=explode('-',$dataNascita);?>
            <div class="controls ">
                <input type="number" required min="1" max="31" class="input-mini" value="<?php if($array[0]!=''){ echo $array[0];}else{ ?> 1 <?php }?>" name="inputGiorno"/>
                <select class="input-medium" name="inputMese">
                    <?php for ( $i = 1; $i <= 12; $i++ ) { ?>
                        <option value="<?php echo $i ?>" <?php if ( $i == $array[1] ) { ?>selected<?php } ?>><?php echo $conf['mesi'][$i]; ?></option>
                    <?php } ?>
                </select>
              <input type="number" required min="1900" max="2006" require value="<?php if($array[2]!=''){ echo $array[2];}else{ ?> 1994 <?php }?>" class="input-mini" name="inputAnno"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputProvinciaNascita">Provincia di Nascita</label>
            <div class="controls">
              <input value="<?php echo $p->ProvinciaNascita; ?>" class="input-mini" type="text" id="inputProvinciaNascita" name="inputProvinciaNascita" required pattern="[A-Za-z]{2}" />
              &nbsp; <span class="muted">ad es.: CT</span>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputComuneNascita">Comune di Nascita</label>
            <div class="controls">
              <input value="<?php echo $p->ComuneNascita; ?>" type="text" id="inputComuneNascita" name="inputComuneNascita" required />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputIndirizzo">Indirizzo</label>
            <div class="controls">
              <input value="<?php echo $p->indirizzo; ?>" type="text" id="inputIndirizzo" name="inputIndirizzo" required />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputCivico">Civico</label>
            <div class="controls">
              <input value="<?php echo $p->civico; ?>" type="text" id="inputCivico" name="inputCivico" class="input-small" required />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputComuneResidenza">Comune di residenza</label>
            <div class="controls">
              <input value="<?php echo $p->comuneResidenza; ?>" type="text" id="inputComuneResidenza" name="inputComuneResidenza" required />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputCAPResidenza">CAP di residenza</label>
            <div class="controls">
              <input value="<?php echo $p->CAPResidenza; ?>" class="input-small" type="text" id="inputCAPResidenza" name="inputCAPResidenza" required pattern="[0-9]{5}" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputProvinciaResidenza">Provincia di residenza</label>
            <div class="controls">
              <input value="<?php echo $p->provinciaResidenza; ?>" class="input-mini" type="text" id="inputProvinciaResidenza" name="inputProvinciaResidenza" required pattern="[A-Za-z]{2}" />
              &nbsp; <span class="muted">ad es.: CT</span>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputgruppoSanguigno">Gruppo Sanguigno</label>
            <div class="controls">
                <select class="input-small" id="inputgruppoSanguigno" name="inputgruppoSanguigno"  required>
                <?php
                    foreach ( $conf['sangue_gruppo'] as $numero => $gruppo ) { ?>
                    <option value="<?php echo $numero; ?>" <?php if ( $numero == $me->grsanguigno ) { ?>selected<?php } ?>><?php echo $gruppo; ?></option>
                    <?php } ?>
                </select>   
            </div>
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