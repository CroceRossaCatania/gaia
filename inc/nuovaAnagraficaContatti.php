<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

if ($sessione->utente()->email) {
  redirect('errore.permessi&cattivo');
} elseif($sessione->utente()->ordinario()) {
  redirect('utente.me');
}

?>

<div class="row-fluid">
    <div class="span12 centrato">
            <h2><?php echo $sessione->utente()->nome; ?><span class="muted">, ci siamo quasi.</span></h2>
        <hr />
    </div>
</div>

<?php if ( isset($_GET['esistente'] ) ) { ?>
<div class="alert alert-success">
    <h4>Stai completando la tua registrazione</h4>
    <p>La tua anagrafica è già presente sul nostro database. Ultima la registrazione.</p>
</div>
<?php } ?>



<div class="row-fluid">
    <div class="span4">
        <h2>
            <i class="icon-phone"></i>
            Contatti
        </h2>
        <p>
            Inserisci i tuoi dati di contatto.
        </p>
        <p>
            <i class="icon-key"></i> Inserisci inoltre la password che userai per accedere.
        </p>
        <p>Scegli una password che abbia tra <strong>8 e 15 caratteri</strong> e usa, se possibile, lettere maiuscole,
          minuscole e numeri.</p>
        <p>Ti consigliamo di non usare la password che giù utilizzi per altri account.</p>
        <p>La password che hai inserito è <strong><span id="strength_human">non sicura</span></strong>  </p> 
        <div class="progress span10 centrato">
          <div class="bar bar-danger" style="width: 0%" id="strength_score"></div>
        </div>
    </div>
    <div class="span8">
          <?php if ( isset($_GET['email'] ) ) { ?>
              <div class="alert alert-block alert-error">
                  <h4>Email già in uso</h4>
                  <p>Questa email è già usata da un altro utente.</p>
                  <p>Devi avere un indirizzo email univoco in quanto questo viene usato per 
                     comunicazioni personali ed al momento dell'accesso.</p>
              </div>
          <?php } ?>
          <?php if ( isset($_GET['match'] ) ) { ?>
              <div class="alert alert-block alert-error">
                  <h4>Le email non coincidono</h4>
                  <p>Le email che hai inserito non coincidono, per favore riprova.</p>
              </div>
          <?php } ?>
          <?php if ( isset($_GET['emailnon'] ) ) { ?>
              <div class="alert alert-block alert-error">
                  <h4>Email non valida</h4>
                  <p>Devi avere un indirizzo email valido in quanto questo viene usato per 
                     comunicazioni personali ed al momento dell'accesso.</p>
              </div>
          <?php } ?>
          <?php if (isset($_GET['e'])) { ?>
              <div class="alert alert-block alert-error">
                  <h4>Inserisci una password complessa</h4>
                  <p>Le password complesse sono più difficili da indovinare.</p>
                  <p>Scegli una password tra 8 e 15 caratteri.</p>
              </div>
          <?php } ?>
          <?php if (isset($_GET['dis'])) { ?>
              <div class="alert alert-block alert-error">
                  <h4>Password non coincidenti</h4>
                  <p>Le due password che hai inserito non sono coincidenti.</p>
                  <p>Reinserici correttamente le password.</p>
              </div>
          <?php } ?>
          <?php if (isset($_GET['err'])) { ?>
              <div class="alert alert-block alert-error">
                  <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
                  <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
              </div> 
          <?php } ?>
        <form class="form-horizontal" action="?p=nuovaAnagraficaContatti.ok" method="POST">
          <div class="control-group input-prepend">
            <label class="control-label" for="inputEmail">Email</label>
            <div class="controls">
              <span class="add-on"><i class="icon-envelope"></i></span>
              <input type="email" id="inputEmail" name="inputEmail" autofocus required value="<?php echo $sessione->email; ?>" autocomplete="off" />
            </div>
          </div>
          <div class="control-group input-prepend">
            <label class="control-label" for="inputEmail2">Ripeti email</label>
            <div class="controls">
              <span class="add-on"><i class="icon-envelope"></i></span>
              <input type="email" id="inputEmail2" name="inputEmail2" required value="<?php echo $sessione->email2; ?>" autocomplete="off"/>
            </div>
          </div>
          <div class="control-group input-prepend">
            <label class="control-label" for="inputCellulare">Cellulare</label>
            <div class="controls ">
              <span class="add-on">+39</span>
              <input type="text" id="inputCellulare" name="inputCellulare" pattern="[0-9]{9,11}" autocomplete="off"/>
            </div>
          </div>
          <hr />
          <div class="control-group input-prepend">
              <label class="control-label" for="inputPassword">Password</label>
              <div class="controls ">
                  <span class="add-on"><i class="icon-key"></i></span>
                  <input type="password" id="inputPassword" name="inputPassword" required pattern=".{8,15}" />
              </div>
          </div>
          <div class="control-group input-prepend">
              <label class="control-label" for="inputPassword2">Ripeti Password</label>
              <div class="controls ">
                  <span class="add-on"><i class="icon-key"></i></span>
                  <input type="password" id="inputPassword2" name="inputPassword2" required pattern=".{8,15}" />
              </div>
          </div>
          
              <br /><br />
          <hr/>
          <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-success">
                  <i class="icon-ok"></i>
                  Avanti
              </button>
            </div>
          </div>
        </form>

    </div>
</div>