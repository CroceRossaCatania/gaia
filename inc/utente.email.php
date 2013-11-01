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
        <h2><i class="icon-envelope muted"></i> Comunicazioni email</h3>
        <hr />
        <?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Indirizzo salvato</strong>.
            Le comunicazioni verranno ora inviate alla nuova email.
        </div>
        <?php } elseif ( isset($_GET['ep']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Email già in uso</h4>
            <p>L'email che hai inserito risulta già in uso.</p>
            <p>Ti preghiamo di inserire il tuo indirizzo email personale.</p>
        </div>
        <?php } elseif ( isset($_GET['link']) )  { ?>
        <div class="alert alert-success">
            <h4><i class="icon-envelope"></i> Hai una nuova email</h4>
            <p>Nella mail che hai ricevuto troverai un link, copialo e incollalo nella barra indirizzo del tuo broswer per terminare la sostituzione della email</p>
        </div>
        <?php } elseif ( isset($_GET['gia']) ) { ?>
          <div class="alert alert-block alert-error">
              <h4><i class="icon-exclamation-sign"></i> Richiesta già effettuata</h4>
              <p>La richiesta di sostituzione della email è stata già effettuata controlla la tua email</p>
          </div>
        <?php }elseif ( isset($_GET['sca']) ) { ?>
          <div class="alert alert-block alert-error">
              <h4><i class="icon-exclamation-sign"></i> Richiesta scaduta o non effettuata</h4>
              <p>La richiesta di sostituzione della email è scaduta o non è mai stata effettuata, compila i campi qui sotto per effettuarne una nuova</p>
          </div>
        <?php } ?>
        <form class="form-horizontal" action="?p=utente.email.ok" method="POST">

            <div class="control-group">
                <div class="alert alert-warning alert-block">
                    <h4><i class="icon-warning-sign"></i> Nota bene</h4>
                    <p>Questa email è quella che <strong>usi per accedere</strong> ed è<br />
                       dove ti invieremo <strong>tutte le comunicazioni importanti</strong>.</p>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Email</label>
                    <div class="controls">
                        <input type="email" autofocus name="inputEmail" id="inputEmail" required value="<?php echo $me->email; ?>">
                    </div>
                </div>
                <?php if ($me->volontario()){ ?>
                <div class="control-group">
                    <label class="control-label" for="inputemailServizio">Email di servizio</label>
                    <div class="controls">
                        <input type="email" autofocus name="inputemailServizio" id="inputemailServizio" value="<?php echo $me->emailServizio; ?>">
                    </div>
                </div>
                <?php } ?>
            <div class="form-actions">
                <button type="submit" class="btn btn-success btn-large">
                    <i class="icon-save"></i>
                    Cambia email
                </button>
            </div>
          </form>

    </div>

</div>
</div>

