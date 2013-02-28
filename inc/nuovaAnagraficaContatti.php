<?php

/*
 * ©2012 Croce Rossa Italiana
 */

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
        <?php if ( $sessione->tipoRegistrazione == VOLONTARIO ) { ?>
        <p>
            Verrai informato sulle attività nel tuo territorio.
        </p>
        <?php } ?>
        <p>
            Inserisci i tuoi dati di contatto.
        </p>
    </div>
    <div class="span8">
          <form class="form-horizontal" action="?p=nuovaAnagraficaContatti.ok" method="POST">
          <?php if ( isset($_GET['email'] ) ) { ?>
              <div class="alert alert-block alert-error">
                  <h4>Email già in uso</h4>
                  <p>Questa email è già usata da un altro utente.</p>
                  <p>Devi avere un indirizzo email univoco in quanto questo viene usato per 
                     comunicazioni personali ed al momento dell'accesso.</p>
              </div>
          <?php } ?>
          <div class="control-group">
            <label class="control-label" for="inputEmail">Email</label>
            <div class="controls">
              <input type="email" id="inputEmail" name="inputEmail" autofocus required />
            </div>
          </div>
          <div class="control-group input-prepend">
            <label class="control-label" for="inputCellulare">Cellulare</label>
            <div class="controls ">
              <span class="add-on">+39</span>
              <input type="text" id="inputCellulare" name="inputCellulare" required pattern="[0-9]{9,11}" />
            </div>
          </div>
          <?php if ( $sessione->tipoRegistrazione == VOLONTARIO ) { ?>
          <div class="control-group input-prepend">
            <label class="control-label" for="inputCellulareServizio">Cell. servizio</label>
            <div class="controls">
              <span class="add-on">+39</span>
              <input type="text" id="inputCellulareServizio" name="inputCellulareServizio" pattern="[0-9]{9,11}" />
            </div>
          </div>
          <?php } ?>
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