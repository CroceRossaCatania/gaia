<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$c = $_GET['oid'];
$c = GeoPolitica::daOid($c);

paginaApp([APP_PRESIDENTE]);

?>

<form action="?p=presidente.wizard.ok" method="POST">

<input type="hidden" name="oid" value="<?php echo $c->oid(); ?>" />
    
<div class="row-fluid">
    
    <div class="span8">
        <h3><?php echo $c->nomeCompleto(); ?></h3>
    </div>
    
    <div class="span4">
        <button type="submit" class="btn btn-large btn-block btn-success">
            <i class="icon-save"></i>
            Salva le informazioni
        </button>
    </div>
    
</div>

<?php if ( isset($_GET['forzato'] ) ) { ?>
<div class="alert alert-block alert-info">
    <h4><i class="icon-info-sign"></i> Completa la scheda dell'Unità territoriale</h4>
    <p>Al fine di migliorare l'esperienza d'uso di Gaia da parte dei volontari, chiediamo ai presidenti di inserire
        alcune informazioni relative alle loro unità territoriali.</p>
    <p>Per favore, completa immediatamente i dettagli per <strong><?php echo $c->nome; ?></strong>. <strong>Potrai modificarle in seguito.</strong></p>
    <p><i><i class="icon-warning-sign"></i> Non potrai usare altre funzioni di Gaia fino al completamento delle schede delle tue unità territoriali.</i></p>
</div>
<?php } ?>

<hr />

<div class="row-fluid">
    
    <div class="span7">
        
        <h3>Dettagli comitato</h3>
        
        <div class="form-horizontal">
            <div class="control-group">
              <label class="control-label" for="inputNome">Nome unità</label>
              <div class="controls">
                <input type="text" class="input-xlarge" name="inputNome" id="inputNome" readonly value="<?php echo $c->nome; ?>">
                <acronym title="Per modificare, contatta supporto@gaia.cri.it">&nbsp; <i class="icon-lock icon-large"></i></acronym>
              </div>
            </div>
           
            <div class="control-group">
              <label class="control-label" for="inputTelefono">Telefono</label>
              <div class="controls">
                <input type="text" required name="inputTelefono" id="inputTelefono" value="<?php echo $c->telefono; ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputFax">Fax</label>
              <div class="controls">
                <input type="text" name="inputFax" id="inputFax" value="<?php echo $c->fax; ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputEmail">Email istituzionale</label>
              <div class="controls">
                <input type="email" required name="inputEmail" id="inputEmail" value="<?php echo $c->email; ?>" />
              </div>
            </div>
            
        </div>
        
        
    </div>
    
    <div class="span5">
        
        <h3>Località dell'unità</h3>
        <div class="form-horizontal">

            <div class="control-group">
              <label class="control-label" for="inputIndirizzo">Indirizzo</label>
              <div class="controls">
                <input type="text" name="inputIndirizzo" id="inputIndirizzo" required value="<?php echo $c->indirizzo; ?>" />
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="inputCivico">Civico</label>
              <div class="controls">
                <input type="text" class="input-mini" name="inputCivico" id="inputCivico" value="<?php echo $c->civico; ?>" />
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="inputCAP">CAP</label>
              <div class="controls">
                <input type="text" class="input-small" name="inputCAP" id="inputCAP" required value="<?php echo $c->cap; ?>" />
              </div>
            </div>
            
                        
            <div class="control-group">
              <label class="control-label" for="inputComune">Comune</label>
              <div class="controls">
                <input type="text" name="inputComune" id="inputComune" required value="<?php echo $c->comune; ?>" />
              </div>
            </div>
            
                                    
            <div class="control-group">
              <label class="control-label" for="inputProvincia">Provincia</label>
              <div class="controls">
                <input type="text" name="inputProvincia" id="inputProvincia" required value="<?php echo $c->provincia; ?>" />
              </div>
            </div>
        
        </div>
        
    </div>
    
</div>

</form>