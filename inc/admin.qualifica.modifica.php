<?php
/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.qualifica&err');
$t = $_GET['id'];

$f = Qualifiche::id($t);
?>
<div class="row-fluid">
    <h2><i class="icon-chevron-right muted"></i> Modifica Qualifica</h2>
    <div class="alert alert-block alert-info ">
        <div class="row-fluid">
            <span class="span7">
                <p>Con questo modulo si possono modificare i Titoli al DB di GAIA</p>
            </span>
        </div>
    </div>           
</div>
<form class="form-horizontal" action="?p=admin.qualifica.modifica.ok&id=<?php echo $t; ?>" method="POST">
    <div class="control-group">
        <label class="control-label" for="inputArea">Area Qualifica</label>
        <div class="controls">
            <select class="input-large" id="inputArea" name="inputArea"  required>
                <option></option>
                <?php foreach ($conf["nomiobiettivi"] as $valore => $chiave) { ?>
                    <option value="<?php echo $valore; ?>" <?php if ($valore == $f->area) { ?>selected<?php } ?>><?php echo $chiave; ?></option>
                <?php } ?>
            </select>   
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="inputNome">Nome qualifica</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="inputNome" id="inputNome" value="<?php echo $f->nome; ?>">    
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="inputVecchioNome">Nome Vecchio qualifica</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="inputVecchioNome" id="inputVecchioNome" value="<?php echo $f->vecchiaNomenclatura; ?>">    
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="inputAbilita">Attiva</label>
        <div class="controls">
            <?php
            $abilitaQualifica = "";
            if ($f->attiva) {
                $abilitaQualifica = 'checked="checked"';
            }
            ?>
            &nbsp;<input type="checkbox" name="inputAbilita" id="inputAbilita" value="1" <?php print $abilitaQualifica ?> />
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-large btn-success">
                <i class="icon-ok"></i>
                Modifica Qualifica
            </button>
        </div>
    </div>

</div>
