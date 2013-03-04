<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();
?>

<script type="text/javascript"><?php require './js/admin.listaUtenti.js'; ?></script>
<br/>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Trasferimento Approvato</strong>.
            Trasferimento approvato con successo.
        </div>
        <?php } ?>
        <?php if ( isset($_GET['no']) ) { ?>
        <div class="alert alert-error">
            <i class="icon-warning-sign"></i> <strong>Trasferimento negato</strong>.
            Trasferimento negato.
        </div>
        <?php } ?>
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
        <th>Comitato</th>
        <th>Azione</th>
    </thead>
<?php
if( $me->presiede() ){
    foreach($me->presidenziante() as $appartenenza){
        $c=$appartenenza->comitato()->id;
        $t = Appartenenza::filtra([['stato', '6'],['comitato',$c]]);
  foreach ( $t as $_t ) {
      $c=$_t->comitato();
      $_v = $_t->volontario();   // Una volta per tutte
 ?>
    <tr>
        <td><?php echo $_t->id; ?></td>
        <td><?php echo $_v->nome; ?></td>
        <td><?php echo $_v->cognome; ?></td>
        <td><?php echo $_v->codiceFiscale; ?></td>
        <td><?php echo date('d-m-Y', $_v->dataNascita); ?></td> 
        <td><?php echo $_v->comuneNascita; ?></td>
        <td><?php echo $c->nome; ?></td>
        <td>
  <a class="btn btn-success" href="?p=admin.trasferimento.ok&id=<?php echo $_v->id; ?>&si">
                <i class="icon-ok"></i>
                    Conferma
            </a>
            <a class="btn btn-danger" onClick="return confirm('Vuoi veramente negare il trasferimento a questo utente ?');" href="?p=admin.trasferimento.ok&id=<?php echo $_v->id; ?>&no">
                <i class="icon-ban-circle"></i>
                    Nega
            </a>
        </td>
       
    </tr>
    <?php }
    }
   
}elseif($me->admin()){
        $t = Appartenenza::filtra([['stato', '6']]);
  foreach ( $t as $_t ) { 
      $c=$_t->comitato();
      $_v = $_t->volontario();   // Una volta per tutte
      ?>
    <tr>
        <td><?php echo $_t->id; ?></td>
        <td><?php echo $_v->nome; ?></td>
        <td><?php echo $_v->cognome; ?></td>
        <td><?php echo $_v->codiceFiscale; ?></td>
        <td><?php echo date('d-m-Y', $_v->dataNascita); ?></td> 
        <td><?php echo $_v->comuneNascita; ?></td>
        <td><?php echo $c->nome; ?></td>
        <td>
  <a class="btn btn-success" href="?p=admin.trasferimento.ok&id=<?php echo $_v->id; ?>&si">
                <i class="icon-ok"></i>
                    Conferma
            </a>
            <a class="btn btn-danger" onClick="return confirm('Vuoi veramente negare appartenenza a questo utente ?');" href="?p=admin.trasferimento.ok&id=<?php echo $_v->id; ?>&no">
                <i class="icon-ban-circle"></i>
                    Nega
            </a>
        </td>
       
    </tr>
    <?php }
    
    
}
?>
 
</table>