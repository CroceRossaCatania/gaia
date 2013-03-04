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
        <?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Richiesta inviata</strong>.
            La richiesta è stata inviata con successo.
        </div>
        <?php } ?>
        <?php if ( isset($_GET['e']) ) { ?>
        <div class="alert alert-error">
            <i class="icon-warning-sign"></i>
            <strong>Errore</strong> &mdash; Appartieni già a questo Comitato.
        </div>
        <?php } ?>
        <div class="row-fluid">
            <h2><i class="icon-chevron-right muted"></i> Richiesta trasferimento</h2>
            <div class="alert alert-block alert-info ">
                <div class="row-fluid">
                    <span class="span7">
                        <h4>Vuoi trasferirti ad un altro Comitato ?</h4>
                        <p>Con questo modulo puoi richiedere il trasferimento ad un altro Comitato</p>
                        <p>Seleziona il Comitato a cui vuoi trasferirti e clicca su invia richiesta.</p>
                    </span>
                </div>
            </div>           
        </div>
        
<div class="row-fluid">
    <form class="form-horizontal" action="?p=trasferimento.ok&id=<?php echo $me->id; ?>" method="POST">
     <div class="control-group">
        <label class="control-label" for="comitato">Comitato Attuale </label>
        <div class="controls">
            <input class="span8" type="text" name="comitato" id="comitato" disabled value="<?php foreach ( $me->storico() as $app ) { ?>
                    <?php if ($app->attuale()) { echo $app->comitato()->nome; } }?>">
            </div>
          </div>   
    <div class="control-group">
        <label class="control-label" for="inputComitato">Comitato Destinazione </label>
        <div class="controls">
            <select required name="inputComitato" autofocus class="span8">
                    <?php foreach ( Comitato::elenco('nome ASC') as $c ) { ?>
                        <option value="<?php echo $c->id; ?>"><?php echo $c->nome; ?></option>
                    <?php } ?>
            </select>
            </div>
          </div>
    <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-success">
                  <i class="icon-ok"></i>
                  Invia richiesta
              </button>
            </div>
          </div>
        </div>
    
    </div>
</div>


