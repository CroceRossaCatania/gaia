<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$elenco = $me->comitatiDiCompetenza(true);
foreach ( $elenco as $unit ){
    $t[] = $unit->regionale();
}
$t = array_unique($t);

?>
<div class="row-fluid">
    <form class="form-horizontal" action="?p=admin.report.ok" method="POST">
        <div class="span12">
            <div class="row-fluid">
                <h2><i class="icon-copy muted"></i> Genera report sull'utilizzo di gaia</h2>
                <?php if (isset($_GET['err'])) { ?>
                <div class="alert alert-block alert-error">
                    <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
                    <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
                </div> 
                <?php } ?>
                <div class="alert alert-block alert-info ">
                    <div class="row-fluid">
                        <span class="span12">
                            <p>Con questo modulo si può generare il report sull'utilizzo di Gaia all'interno di un Comitato Regionale.</p>
                        </div>
                    </div>           
                </div>

                <div class="row-fluid">
                    <div class="control-group">
                        <label class="control-label" for="oid">Seleziona Comitato</label>
                        <div class="controls">
                            <select class="input-xxlarge" id="oid" name="oid" required>
                                <?php
                                foreach ( $t as $numero ) { ?>
                                <option value="<?php echo $numero->oid(); ?>"><?php echo $numero->nomeCompleto(); ?></option>
                                <?php } ?>
                            </select>   
                        </div> 
                    </div>
                    
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-large btn-success">
                                <i class="icon-ok"></i>
                                Genera report
                            </button>
                        </div>
                    </div>
                </div>
                <a class="btn btn-large btn-success" href="?p=admin.report.ok&naz">Genera report nazionale</a>
            </div>
        </form>
    </div>
