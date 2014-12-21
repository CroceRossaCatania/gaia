<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.donazioni&err');
$t = $_GET['id'];
$f = Donazione::id($t);
?>
<div class="row-fluid">
    <h2><i class="icon-chevron-right muted"></i> Modifica Donazione</h2>
    <div class="alert alert-block alert-info ">
        <div class="row-fluid">
            <span class="span7">
                <p>Con questo modulo si possono modificare le donazioni al DB di GAIA</p>
            </span>
        </div>
    </div>           
</div>
<form class="form-horizontal" action="?p=admin.donazione.modifica.ok&id=<?php echo $t; ?>" method="POST">
    <div class="control-group">
        <label class="control-label" for="inputTipo">Tipologia donazione</label>
        <div class="controls">
            <select class="input-large" id="inputTipo" name="inputTipo"  required>
                <?php
                foreach ( $conf['donazioni'] as $numero => $gruppo ) { ?>
                <option value="<?php echo $numero; ?>" <?php if ( $numero==$f->tipo ) { ?>selected<?php } ?>><?php echo $gruppo[0]; ?></option>
                <?php } ?>
            </select>   
        </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="inputNome">Nome donazione</label>
      <div class="controls">
        <input class="input-xxlarge" type="text" name="inputNome" id="inputNome" value="<?php echo $f->nome; ?>" required>
        
    </div>
</div>

<div class="control-group">
    <div class="controls">
      <button type="submit" class="btn btn-large btn-success">
          <i class="icon-ok"></i>
          Modifica Donazione
      </button>
  </div>
</div>

