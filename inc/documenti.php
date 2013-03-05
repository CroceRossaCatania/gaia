<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

?>
<hr />
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        <div class="row-fluid">
            <h2>
                <i class="icon-folder-open muted"></i>
                Documenti
            </h2>
            <div class="span9 allinea-centro">
                <h3 class="allinea-sinistra"><i class="icon-chevron-right muted"></i> Carta Identità</h3>
        <?php if ( isset($_GET['ciok']) ) { ?>
            <div class="alert alert-success">
                <i class="icon-ok"></i> Carta Identità modificata!
            </div>
        <?php } elseif ( isset($_GET['cierr']) ) { ?>
            <div class="alert alert-error">
                <i class="icon-warning-sign"></i>
                <strong>Errore</strong> &mdash; File troppo grande o non valido.
            </div>
        <?php } else { ?>
        <hr />
        <?php } ?>
        <div class="span6 allinea-sinistra">        
        <img src="<?php echo $me->avatar()->img(20); ?>" class="img-polaroid" />
        </div>
        <div class="span3 allinea-centro">
            <form id="caricaFoto" action="?p=" method="POST" enctype="multipart/form-data" class="allinea-sinistra">
              <p>Per modificare:</p>
              <p>1. <strong>Scegli</strong>: <input type="file" name="avatar" required /></p>
              <p>2. <strong>Clicca</strong>:<br />
                <button type="submit" class="btn btn-block btn-success">
                    <i class="icon-save"></i> Salva modifiche
                </button></p>
            </form>
        </div>
        </div>
              
<div class="span9 allinea-centro"><br/>
        <h3 class="allinea-sinistra"><i class="icon-chevron-right muted"></i> Patente civile</h3>
        <?php if ( isset($_GET['pcok']) ) { ?>
            <div class="alert alert-success">
                <i class="icon-ok"></i> Patente civile modificata!
            </div>
        <?php } elseif ( isset($_GET['pcerr']) ) { ?>
            <div class="alert alert-error">
                <i class="icon-warning-sign"></i>
                <strong>Errore</strong> &mdash; File troppo grande o non valido.
            </div>
        <?php } else { ?>
        <hr />
        <?php } ?>
        <div class="span6 allinea-sinistra">        
        <img src="<?php echo $me->avatar()->img(20); ?>" class="img-polaroid" />
        </div>
        <div class="span3 allinea-centro">
            <form id="caricaFoto" action="?p=" method="POST" enctype="multipart/form-data" class="allinea-sinistra">
              <p>Per modificare:</p>
              <p>1. <strong>Scegli</strong>: <input type="file" name="avatar" required /></p>
              <p>2. <strong>Clicca</strong>:<br />
                <button type="submit" class="btn btn-block btn-success">
                    <i class="icon-save"></i> Salva modifiche
                </button></p>
            </form>
        </div>
        </div>            

<div class="span9 allinea-centro"><br/>
        <h3 class="allinea-sinistra"><i class="icon-chevron-right muted"></i> Quota associativa</h3>
        <?php if ( isset($_GET['qok']) ) { ?>
            <div class="alert alert-success">
                <i class="icon-ok"></i> Quota associativa modificata!
            </div>
        <?php } elseif ( isset($_GET['qcerr']) ) { ?>
            <div class="alert alert-error">
                <i class="icon-warning-sign"></i>
                <strong>Errore</strong> &mdash; File troppo grande o non valido.
            </div>
        <?php } else { ?>
        <hr />
        <?php } ?>
        <div class="span6 allinea-sinistra">        
        <img src="<?php echo $me->avatar()->img(20); ?>" class="img-polaroid" />
        </div>
        <div class="span3 allinea-centro">
            <form id="caricaFoto" action="?p=" method="POST" enctype="multipart/form-data" class="allinea-sinistra">
              <p>Per modificare:</p>
              <p>1. <strong>Scegli</strong>: <input type="file" name="avatar" required /></p>
              <p>2. <strong>Clicca</strong>:<br />
                <button type="submit" class="btn btn-block btn-success">
                    <i class="icon-save"></i> Salva modifiche
                </button></p>
            </form>
        </div>
        </div>            
            
</div>  
</div>
</div>

