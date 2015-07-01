<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.titoliCorsi&err');
$t = $_GET['id'];
$f = TitoloCorso::id($t);
?>
<div class="row-fluid">
    <h2><i class="icon-chevron-right muted"></i> Modifica Titolo Corso</h2>
    <div class="alert alert-block alert-info ">
        <div class="row-fluid">
            <span class="span7">
                <p>Con questo modulo si possono modificare i Titoli Corsi nel DB di GAIA</p>
            </span>
        </div>
    </div>           
</div>
<form class="form-horizontal" action="?p=admin.titoloCorso.modifica.ok&id=<?php echo $t; ?>" method="POST">

    <div class="control-group">
      <label class="control-label" for="inputNome">Nome titolo corso</label>
      <div class="controls">
        <input class="input-xxlarge" type="text" name="inputNome" id="inputNome" value="<?php echo $f->nome; ?>">
        
    </div>
</div>

<div class="control-group">
    <div class="controls">
      <button type="submit" class="btn btn-large btn-success">
          <i class="icon-ok"></i>
          Modifica Titolo Corso
      </button>
  </div>
</div>

