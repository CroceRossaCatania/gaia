<?php

/*
 * ©2013 Croce Rossa Italiana
 */

?>

<div class="row-fluid">
    <div class="span4">
        <h2>
            <i class="icon-question-sign muted"></i>
            Perso la password?
        </h2>
        <p>
            Inserisci il tuo codice fiscale e l'indirizzo email che hai usato per iscriverti a Gaia.
        </p>
    </div>
    <div class="span8">
        <?php if ( isset($_GET['cf']) ) { ?>
          <div class="alert alert-block alert-error">
              <h4><i class="icon-exclamation-sign"></i> Codice Fiscale non registrato</h4>
              <p>Hai inserito un codice fiscale che non risulta registrato.<br />
                  È una parte essenziale del recupero password. Riprova.</p>
          </div>
        <?php }elseif ( isset($_GET['email']) ) { ?>
          <div class="alert alert-block alert-error">
              <h4><i class="icon-exclamation-sign"></i> Email non valida</h4>
              <p>Hai inserito un indirizzo email che non risulta registrato.<br />
                  È una parte essenziale del recupero password. Riprova.</p>
          </div>
        <?php }elseif ( isset($_GET['gia']) ) { ?>
          <div class="alert alert-block alert-error">
              <h4><i class="icon-exclamation-sign"></i> Richiesta già effettuata</h4>
              <p>La richiesta di reset della password è stata già effettuata controlla la tua casella di posta.</p>
          </div>
        <?php }elseif ( isset($_GET['sca']) ) { ?>
          <div class="alert alert-block alert-error">
              <h4><i class="icon-exclamation-sign"></i> Richiesta scaduta o non effettuata</h4>
              <p>La richiesta di reset della password è scaduta o non è mai stata effettuata, compila i campi sottostanti per effettuarne una nuova.</p>
          </div>
        <?php } ?>
        
        <hr />
          <form class="form-horizontal" action="?p=recuperaPassword.ok" method="POST">

          <div class="control-group">
            <label class="control-label" for="inputCodiceFiscale">Codice Fiscale</label>
            <div class="controls">
              <input autofocus class="input-large" type="text" id="inputCodiceFiscale" name="inputCodiceFiscale" placeholder="16 caratteri alfanumerici" required  pattern="[A-Za-z0-9]{16}" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputEmail">Email</label>
            <div class="controls">
              <input type="email" id="inputEmail" name="inputEmail" required placeholder="Es: mario.rossi@miamail.com" />
            </div>
          </div>

          <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-success">
                  Richiedi nuova password
                  <i class="icon-chevron-right"></i>
              </button>
            </div>
          </div>
        </form>

    </div>
</div>
