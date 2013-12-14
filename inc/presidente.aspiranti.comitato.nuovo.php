<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
$t = $_GET['id'];
?>
<form class="form-horizontal" action="?p=presidente.aspiranti.comitato.nuovo.ok&id=<?php echo $t; ?>" method="POST">

    <div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-arrow-right"></i> Assegna ad un Comitato</h3>
        </div>
    <div class="modal-body">
          <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputData"> Comitato</label>
                </div>
                <div class="span8">
                    <select required name="inputComitato" autofocus class="span12">
                        <?php foreach ( $me->comitatiDiCompetenza() as $c ) { ?>
                            <option value="<?php echo $c->id; ?>"><?php echo $c->nomeCompleto(); ?></option>
                        <?php } ?>
                    </select>  
                </div>
         </div>
        <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="dataingresso">Data esame corso base </label>
                </div>
                <div class="span8">
                    <input class="input-medium" type="text" name="dataingresso" id="dataingresso" required>
                </div>
        </div>
    </div>
        <div class="modal-footer">
          <a href="?p=presidente.aspiranti" class="btn">Annulla</a>
          <button type="submit" class="btn btn-success">
              <i class="icon-ok"></i> Assegna
          </button>
        </div>
</div>
    
</form>