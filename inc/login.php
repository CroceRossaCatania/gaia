<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPubblica();

$torna = @$sessione->torna;
if ( isset($_GET['back']) ) {
    $torna = base64_encode(serialize([ 'p' => $_GET['back'] ]));
}
$sessione->torna = null;

if ( isset($_GET['token']) ) {
  // PROCEDURA DI PREACCESSO DA API
  $token = Validazione::cercaValidazione($_GET['token']);
  $token->stato = VAL_CHIUSA;
  $token = json_decode($token->note);
  $sid    = $token->sid;
  $chiave = APIKey::id($token->app);
  $ip     = $token->ip;
  $nuovas = Sessione::id($sid);
  $nuovas->app_id = $chiave;
  $nuovas->app_ip = $ip;
  setcookie('sessione', $sid, time() + $conf['sessioni']['durata']);
  redirect("login&back=utente.applicazione");
}

?>


<div class="row-fluid">
    <div class="span12 centrato">
            <h2><span class="muted">Croce Rossa.</span> Persone in prima persona.</h2>
        <hr />
    </div>
</div>

<?php if ($sessione->app_id) { 
  /* ACCESSO TRAMITE API (APPLICAZIONE) */
  $app = APIKey::id($sessione->app_id);
  $ip  = $sessione->app_ip;
  ?>
  <div class="alert alert-block alert-info">
    <h4>
      <i class="icon-warning-sign"></i>
      Stai entrando su Gaia tramite <?php echo $app->nome; ?>
    </h4>
    <p>
      Tieni presente che <?php echo $app->nome; ?> (IP: <?php echo $ip; ?>) potr&agrave; accedere ai tuoi dati
      personali presenti su Gaia. Se non sei d'accordo, non continuare.
    </p>
  </div>
  

<?php } ?>


<div class="row-fluid">
 
    <div class="span6">
        <p>&nbsp;</p>
          <form class="form-horizontal" action="?p=login.ok" method="POST">
              
          <?php if (isset($_GET['email'])) { ?>
              <div class="alert alert-error">
                  <strong>Email non presente nei nostri sistemi</strong>.<br />
                  Controlla eventuali errori di scrittura.
              </div>
          <?php } elseif ( isset($_GET['password']) ) { ?>
              <div class="alert alert-error">
                  <strong>Password non corretta</strong>.<br />
                  Controlla che il tasto BLOC MAIUSC non sia inserito.
              </div>
          <?php } elseif ( isset($_GET['captcha']) ) { ?>
              <div class="alert alert-error">
                  <strong>Codice di verifica non corretto</strong>.<br />
                  Per favore inserisci attentamente il codice di verifica.
              </div>
          <?php } else { ?>
              <p>&nbsp;</p>
          <?php } ?>
          <div class="control-group">
            <label class="control-label" for="inputEmail">Email</label>
            <div class="controls">
              <input type="email" id="inputEmail" name="inputEmail" required autofocus />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputPassword">Password</label>
            <div class="controls">
              <input type="password" id="inputPassword" name="inputPassword" required pattern=".{3,15}" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputValida">
              
            </label>
            <div class="controls">
              <i class="icon-lock"></i> Per favore inserisci i caratteri nel campo sottostante:<br />
              <?php captcha_mostra(); ?>
            </div>
          </div>
              
              <input type="hidden" name="torna" value="<?php echo $torna; ?>" />
          
          <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-primary">
                  <i class="icon-ok"></i>
                  Accedi
              </button>
            </div>
          </div>
        </form>

    </div>
       
    <div class="span6 centrato">
        <hr class="display-phone" />
        <h2>
            <i class="icon-key"></i>
            Accedi
        </h2>
        <p>
            Inserisci la tua email e la password che hai fornito alla registrazione.
        </p>

        <?php if (!isset($_GET['app'])) { ?>
          <hr />
          <p><strong>Sei un volontario non ancora registrato?</strong></p>
          <a href="?p=riconoscimento&tipo=volontario" class="btn btn-success btn-large">
              Registrati ora
          </a>
        <?php } ?>
        <hr />
        <p>Se non ricordi la tua password, puoi richiederne una nuova.</p>
        <p><a href="?p=recuperaPassword" class="btn">Recupera password</a></p>
        
    </div>
</div>