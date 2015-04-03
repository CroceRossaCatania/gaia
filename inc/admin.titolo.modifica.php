<?php

/*
 * ©2015 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.titoli&err');
$t = $_GET['id'];
$f = Titolo::id($t);

?>
<div class="row-fluid">
  <h2><i class="icon-chevron-right muted"></i> Modifica Titolo</h2>
    <div class="alert alert-block alert-info ">
      <div class="row-fluid">
        <span class="span7">
          <p>Con questo modulo si possono modificare i Titoli al DB di GAIA</p>
        </span>
      </div>
    </div>           
</div>
<form class="form-horizontal" action="?p=admin.titolo.modifica.ok&id=<?php echo $t; ?>" method="POST">
  <div class="control-group">
    <label class="control-label" for="inputTipo">Tipologia titolo</label>
    <div class="controls">
      <select class="input-large" id="inputTipo" name="inputTipo"  required>
        <?php
        foreach ( $conf['titoli'] as $numero => $gruppo ) { ?>
          <option value="<?php echo $numero; ?>" <?php if ( $numero==$f->tipo ) { ?>selected<?php } ?>><?php echo $gruppo[0]; ?></option>
        <?php } ?>
      </select>   
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputNome">Nome titolo</label>
    <div class="controls">
      <input class="input-xxlarge" type="text" name="inputNome" id="inputNome" value="<?= $f->nome; ?>">  
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputArea">Area</label>
    <div class="controls">
      <select class="input-large" id="inputArea" name="inputArea"  required>
        <?php
        foreach ( $conf['obiettivi'] as $numero => $gruppo ) { ?>
          <option value="<?php echo $numero; ?>" <?php if ( $numero==$f->area ) { ?>selected<?php } ?>><?php echo $gruppo; ?></option>
        <?php } ?>
      </select>   
    </div>
  </div>

  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn btn-large btn-success">
        <i class="icon-ok"></i>
        Modifica Titolo
      </button>
    </div>
  </div>
