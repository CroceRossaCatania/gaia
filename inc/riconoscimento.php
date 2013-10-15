<?php

/*
 * ©2012 Croce Rossa Italiana
 */


/* Registra sulla sessione il tipo della registrazione! */
if ( isset($_GET['tipo'] ) ) {
    switch ( $_GET['tipo'] ) {
        case 'volontario':
            $sessione->tipoRegistrazione = VOLONTARIO;
            break;
        case 'aspirante':
        default:
            $sessione->tipoRegistrazione = ASPIRANTE;
        break;
    }
} elseif ( empty($sessione->tipoRegistrazione) ) {
    $sessione->tipoRegistrazione = VOLONTARIO;
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
            <i class="icon-user"></i>
            Riconoscimento
        </h2>
        <p>
            Inserisci il tuo codice fiscale,<br />
            ci permetterà di aiutarti velocemente.
        </p>
    </div>
    <div class="span8">
        <?php if ( isset($_GET['e']) ) { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Codice Fiscale non valido</h4>
            <p>Hai inserito un codice fiscale che non risulta valido.<br />
                È una parte essenziale della registrazione. Riprova.</p>
        </div>
        <?php } else { ?>
        <div class="alert alert-block alert-info">
            <h4><i class="icon-question-sign"></i> Perché ti chiediamo il codice fiscale?</h4>
            <p>Controlleremo se sei già inserito nella nostra banca dati.</p>
        </div>
        <?php } ?>
        <hr />
          <form class="form-horizontal" action="?p=riconoscimento.ok" method="POST">

          <div class="control-group">
            <label class="control-label" for="inputCodiceFiscale">Cod. Fiscale</label>
            <div class="controls">
              <input autofocus class="input-large" type="text" id="inputCodiceFiscale" name="inputCodiceFiscale" placeholder="16 caratteri alfanumerici" required  pattern="[A-Za-z]{6}[0-9]{2}[A-Za-z][0-9]{2}[A-Za-z][0-9]{3}[A-Za-z]" />
            </div>
          </div>
          
          <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-success">
                  Avanti
                  <i class="icon-chevron-right"></i>
              </button>
            </div>
          </div>
        </form>

    </div>
</div>