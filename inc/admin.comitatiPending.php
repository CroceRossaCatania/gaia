<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();
?>

<script type="text/javascript"><?php require './js/admin.listaUtenti.js'; ?></script>
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
        <th>Comitato</th>
        <th>Azione</th>
    </thead>
<?php
if( $me->presiede() ){
    foreach($me->presidenziante() as $appartenenza){
        $c=$appartenenza->comitato()->id;
        $t = Appartenenza::filtra([['conferma', '0'],['comitato',$c]]);
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
  <a class="btn btn-success" href="?p=admin.comitati&id=<?php echo $_t->id; ?>&si">
                <i class="icon-ok"></i>
                    Conferma
            </a>
            <a class="btn btn-danger" href="?p=<?php echo $_t->id; ?>&no">
                <i class="icon-ban-circle"></i>
                    Nega
            </a>
        </td>
       
    </tr>
    <?php }
    }
   
}elseif($me->admin()){
        $t = Appartenenza::filtra([['conferma', '0']]);
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
  <a class="btn btn-success" href="?p=admin.comitati&id=<?php echo $_t->id; ?>&si">
                <i class="icon-ok"></i>
                    Conferma
            </a>
            <a class="btn btn-danger" onClick="return confirm('Vuoi veramente negare appartenenza a questo utente ?');" href="?p=admin.comitati&id=<?php echo $_t->id; ?>&no">
                <i class="icon-ban-circle"></i>
                    Nega
            </a>
        </td>
       
    </tr>
    <?php }
    
    
}
?>
 
</table>