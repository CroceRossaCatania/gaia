<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        <h2><i class="icon-key muted"></i> Password</h3>
        
        <?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Password salvata</strong>.
            La tua password è stata cambiata con successo.
        </div>
        <?php } elseif ( isset($_GET['ee']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Inserisci correttamente la <strong>Vecchia</strong> Password</h4>
            <p>Senza la vecchia password non possiamo confermare la tua identità</p>
        </div>
        <?php } elseif ( isset($_GET['e']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Inserisci una password complessa</h4>
            <p>Le password complesse sono più difficili da indovinare.</p>
            <p>Scegli una password tra 6 e 15 caratteri.</p>
        </div>
        <?php } elseif ( isset($_GET['en']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> La nuova password non coincide</h4>
            <p>Le password inserite non coincidono</p>
            <p>Inserisci correttamente la nuova password</p>
        </div>
        <?php } else { ?>
            <hr />
        <?php } ?>
        <form class="form-horizontal" action="?p=utente.password.ok" method="POST">

            
                <div class="alert alert-warning alert-block">
                    <h4><i class="icon-warning-sign"></i> Nota bene</h4>
                    <p>Questa è la password che <strong>usi per accedere</strong>.</p>
                </div>
                <div class="control-group input-prepend">
                    <label class="control-label" for="inputOldPassword"><strong>Vecchia</strong> Password</label>
                    <div class="controls ">
                        <span class="add-on"><i class="icon-key"></i></span>
                        <input type="password" id="inputOldPassword" name="inputOldPassword" required pattern=".{6,15}" />
                    </div>
                </div>
                <div class="control-group input-prepend">
                    <label class="control-label" for="inputPassword"><strong>Nuova</strong> Password</label>
                    <div class="controls ">
                        <span class="add-on"><i class="icon-key"></i></span>
                        <input type="password" id="inputPassword" name="inputPassword" required pattern=".{6,15}" />
                    </div>
                </div>
                <div class="control-group input-prepend">
                    <label class="control-label" for="inputPassword2"><strong>Verifica Nuova</strong> Password</label>
                    <div class="controls ">
                        <span class="add-on"><i class="icon-key"></i></span>
                        <input type="password" id="inputPassword2" name="inputPassword2" required pattern=".{6,15}" />
                    </div>
                </div>
              
            <div class="form-actions">
                <button type="submit" class="btn btn-success btn-large">
                    <i class="icon-save"></i>
                    Cambia password
                </button>
            </div>
          </form>

    </div>

</div>
</div>

