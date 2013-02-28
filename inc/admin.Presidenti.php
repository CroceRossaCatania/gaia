<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaAdmin();
?>
<script type="text/javascript"><?php require './js/admin.listaUtenti.js'; ?></script>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Presidente dimesso</strong>.
            Il presidente è stato dimesso con successo.
        </div>
<?php } ?>
<?php if ( isset($_GET['new']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Presidente nominato</strong>.
            Il presidente è stato nominato con successo.
        </div>
<?php } ?>
<br/>
    <div class="control-group" align="right">
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-search"></i></span>
                <input data-t="<?php echo $t; ?>" required id="cercaUtente" placeholder="Cerca utente..." class="span4" type="text">
            </div>
        </div>
    </div> 
<hr />
<table class="table table-striped table-bordered" id="tabellaUtenti">
    <thead>
        <th>#</th>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Codice Fiscale</th>
        <th>Data di Nascita</th>
        <th>Luogo di Nascita</th>
        <th>Comitato Presidente</th>
        <th>Azione</th>
    </thead>
<?php
if($me->admin()){
        $t = Appartenenza::filtra([['stato', '4']]);
  foreach ( $t as $_t ) { 
      $c=$_t->comitato();
      $_v = $_t->volontario();   // Una volta per tutte
      if($_t->fine>=time()){?>
    <tr>
        <td><?php echo $_t->id; ?></td>
        <td><?php echo $_v->nome; ?></td>
        <td><?php echo $_v->cognome; ?></td>
        <td><?php echo $_v->codiceFiscale; ?></td>
        <td><?php echo date('d-m-Y', $_v->dataNascita); ?></td> 
        <td><?php echo $_v->comuneNascita; ?></td>
        <td><?php echo $c->nome; ?></td>
        <td>
                <a class="btn btn-danger" onClick="return confirm('Vuoi veramente dimettere questo Presidente ?');" href="?p=admin.dimettiPresidente&id=<?php echo $_t->id; ?>">
                <i class="icon-ban-circle"></i>
                    Dimetti
                </a>
        </td>
       
    </tr>
    <?php }}
    
    
}
?>
 
</table>