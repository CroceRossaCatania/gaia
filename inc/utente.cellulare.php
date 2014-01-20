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
        <h2><i class="icon-phone muted"></i> Comunicazioni telefoniche</h2>
        
        <?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Numeri salvati</strong>.
            Dati memorizzati con successo.
        </div>
        <?php } elseif ( isset($_GET['e']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i>Numero già in uso</h4>
            <p>Il numero che hai inserito risulta già in uso.</p>
            <p>Ti preghiamo di inserire il tuo numero personale.</p>
        </div>
        <?php } else { ?>
            <hr />
        <?php } ?>
        <form class="form-horizontal" action="?p=utente.cellulare.ok" method="POST">

            <div class="control-group">
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
                    Cambia numeri
                </button>
            </div>
            </div>
          </form>
    </div>
</div>
