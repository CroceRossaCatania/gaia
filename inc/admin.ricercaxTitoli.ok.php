<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();
$t = $_POST['idTitolo'];
?>

<br/>
    <div class="control-group" align="right">
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-search"></i></span>
                <input data-t=4 required id="cercaUtente" placeholder="Cerca utente..." class="span4" type="text">
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
        <th>Titolo</th>
    </thead>
<?php
if($me->admin()){
        $t = TitoloPersonale::filtra([['titolo',$t]]);
  foreach ( $t as $_t ) { 
      $_v = $_t->volontario();  // Una volta per tutte ?> 
    <tr>
        <td><?php echo $_t->id; ?></td>
        <td><?php echo $_v->nome; ?></td>
        <td><?php echo $_v->cognome; ?></td>
        <td><?php echo $_v->codiceFiscale; ?></td>
        <td><?php echo date('d-m-Y', $_v->dataNascita); ?></td> 
        <td><?php echo $_v->comuneNascita; ?></td>
        <td><?php echo $_t->titolo()->nome; ?></td>
    </tr>
    <?php }
    
    
}
?>
 
</table>
