<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

// controllo se ho in giro cambi email tra le validazioni del tizio
$mailSospesa = Validazione::filtra([['volontario', $me], ['stato', VAL_MAIL]]);
$mailServizioSospesa = Validazione::filtra([['volontario', $me], ['stato', VAL_MAILS]]);
if ($mailSospesa) {
    $mailSospesa = $mailSospesa[0];
}
if ($mailServizioSospesa) {
    $mailServizioSospesa = $mailServizioSospesa[0];
} 

?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        <h2><i class="icon-phone muted"></i> Modifica delle informazioni di contatto</h3>
        <hr />
        <?php if( isset($_GET['emailok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Richiesta salvata</strong>.
            Controlla casella di posta specificata e conferma il tuo nuovo indirizzo per completare la procedura.
        </div>
        <?php } elseif( isset($_GET['emailep']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Email già in uso</h4>
            <p>L'email che hai inserito risulta già in uso.</p>
            <p>Ti preghiamo di inserire il tuo indirizzo email personale.</p>
        </div>
        <?php } elseif( isset($_GET['emailpass']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Password errata!</h4>
            <p>La password che hai inserito non risulta corretta</p>
        </div>
        <?php }elseif(isset($_GET['emailgia'])) { ?>
            <div class="alert alert-block alert-error">
                <h4><i class="icon-exclamation-sign"></i> Richiesta già effettuata</h4>
                <p>La richiesta di sostituzione della email è stata già effettuata controlla la tua email</p>
            </div>
        <?php } elseif(isset($_GET['emailserv'])) { ?>
            <div class="alert alert-success">
                <h4><i class="icon-save"></i> Email di servizio cancellata</h4>
                <p>La richiesta di cancellazione dell'email di servizio è andata a buon fine</p>
            </div>
        <?php } elseif ( isset($_GET['cellok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Numeri salvati</strong>.
            Dati memorizzati con successo.
        </div>
        <?php } elseif ( isset($_GET['celle']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Numero già in uso</h4>
            <p>Il numero che hai inserito risulta già in uso.</p>
            <p>Ti preghiamo di inserire il tuo numero personale.</p>
        </div>
        <?php }?>
        <div class="row-fluid">
            <div class="span12 centrato">
                <br />
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_email" data-toggle="tab">Email</a></li>
                        <li><a href="#tab_cellulare" data-toggle="tab">Cellulare</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <!-- TAB EMAIL -->
                    <div class="tab-pane active" id="tab_email">
                        <div class="row-fluid">
                            <?php if($mailSospesa) { ?>
                                <div class="alert alert-block alert-error">
                                    <h4><i class="icon-exclamation-sign"></i> Richiesta variazione email in corso</h4>
                                    <p>La richiesta di sostituzione della email con <?php echo $mailSospesa->note; ?> è stata effettuata. Controlla la tua email per confermare.</p>
                                </div>
                            <?php } if($mailServizioSospesa) { ?>
                                <div class="alert alert-block alert-error">
                                    <h4><i class="icon-exclamation-sign"></i> Richiesta variazione email di servizio in corso</h4>
                                    <p>La richiesta di sostituzione della email con <?php echo $mailServizioSospesa->note; ?> è stata effettuata. Controlla la tua email per confermare.</p>
                                </div>
                            <?php } ?>
                            <form class="form-horizontal" action="?p=utente.email.conferma" method="POST">
                                <div class="alert alert-warning alert-block">
                                    <p><h4><i class="icon-warning-sign"></i> Nota bene</h4></p>
                                    <p>L'<strong>Email Principale</strong> è quella che <strong>usi per accedere</strong> ed è 
                                       dove ti invieremo tutte le comunicazioni importanti.</p>
                                    <?php if ($me->stato == VOLONTARIO) { ?>
                                    <p>L'<strong>Email di Servizio</strong> è quella dalla quale partiranno le comunicazioni che spedisci
                                    nel caso tu abbia qualche incarico in un Comitato CRI.</p>
                                    <p>Se <strong>non sei in possesso</strong> di una email di servizio 
                                    lascia il campo vuoto</p>
                                    <?php } ?>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Email principale</label>
                                    <div class="controls">
                                        <?php if($mailSospesa) { ?>
                                        <input id="inputEmail" class="disabledInput" type="text" placeholder="<?php echo $me->email; ?>" disabled>
                                        <?php } else { ?>
                                        <input type="email" autofocus name="inputEmail" id="inputEmail" required value="<?php echo $me->email; ?>">
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php if ($me->stato == VOLONTARIO){ ?>
                                    <div class="control-group">
                                        <label class="control-label" for="inputemailServizio">Email di servizio</label>
                                        <div class="controls">
                                            <?php if($mailServizioSospesa) { ?>
                                            <input id="inputemailServizio" type="text" placeholder="<?php echo $me->emailServizio; ?>" disabled>
                                            <?php } else { ?>
                                            <input type="email" name="inputemailServizio" id="inputemailServizio" value="<?php echo $me->emailServizio; ?>">
                                            <?php if($me->emailServizio) { ?>
                                                <a class="btn btn-danger" href="?p=utente.emailservizio.cancella.ok">
                                                    <i class="icon-remove"></i>
                                                </a>
                                            <?php }
                                            } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success btn-large">
                                        <i class="icon-save"></i>
                                        Salva
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- TAB CELL -->
                    <div class="tab-pane" id="tab_cellulare">
                        <div class="row-fluid">
                            <form class="form-horizontal" action="?p=utente.cellulare.ok" method="POST">
                                <div class="alert alert-warning alert-block">
                                    <h4><i class="icon-warning-sign"></i> Nota bene</h4>
                                    <p>Questi sono i numeri di telefono dove ti contatteremo per <strong>tutte le comunicazioni importanti</strong>.</p>
                                    <?php if($me->stato == VOLONTARIO) { ?>
                                    <p>Se <strong>non sei in possesso</strong> di un cellulare di servizio lascia il campo vuoto</p>
                                    <?php } ?>
                                </div>
                                <div class="control-group input-prepend">
                                    <label class="control-label" for="inputCellulare">Cellulare</label>
                                    <div class="controls">
                                        <span class="add-on">+39</span>
                                        <input type="text" id="inputCellulare" autofucus name="inputCellulare" required pattern="[0-9]{9,11}" required value="<?php echo $me->cellulare; ?>"/>
                                    </div>
                                </div>
                                <?php if($me->stato == VOLONTARIO) { ?>
                                    <div class="control-group input-prepend">
                                        <label class="control-label" for="inputCellulareServizio">Cell. servizio</label>
                                        <div class="controls">
                                            <span class="add-on">+39</span>
                                            <input type="text" id="inputCellulareServizio" name="inputCellulareServizio" pattern="[0-9]{9,11}" value="<?php echo $me->cellulareServizio; ?>"/>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success btn-large">
                                        <i class="icon-save"></i>
                                        Salva
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
