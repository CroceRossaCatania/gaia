<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>
<?php if ( isset($_GET['new']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Titolo aggiunto</strong>.
            Il titolo è stato aggiunto con successo.
        </div>
<?php } elseif ( isset($_GET['del']) )  { ?>
        <div class="alert alert-block alert-error">
           <i class="icon-exclamation-sign"></i> <strong>Titolo cancellato</strong>
            Il titolo è stato cancellato con successo.
        </div>
<?php }elseif ( isset($_GET['dup']) ) { ?>
        <div class="alert alert-error">
            <i class="icon-warning-sign"></i> <strong>Titolo presente</strong>.
            Il titolo è già presente in elenco.
        </div>
<?php } ?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
    <br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-certificate muted"></i>
            Elenco Titoli
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Titolo..." type="text">
        </div>
    </div>  
    <br/>  
    <div class="span4 allinea-destra">
        <a class="btn btn-success" href="?p=admin.titolo.nuovo">
                <i class="icon-plus"></i> Aggiungi Titolo
                </a>
    </div> 
</div>
  
<hr />
    
<div class="row-fluid">
   <div class="span12">
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Azioni</th>
            </thead>
        <?php
       foreach(Titolo::elenco('nome ASC') as $c){
                ?>
                  <tr>
                    <td><?php echo $c->nome; ?></td>
                    <td><?php
                    foreach ( $conf['titoli'] as $numero => $denominazione) { if ( $numero == $c->tipo ) { echo $denominazione[0]; } } ?></td>
                    <td class="btn-group">      
                        <a  onClick="return confirm('Vuoi veramente cancellare questo titolo ?');" href="?p=admin.titolo.cancella&id=<?php echo $c->id; ?>" title="Cancella Titolo" class="btn btn-small btn-warning">
                            <i class="icon-trash"></i> Cancella
                        </a>
                   </td>
                </tr>
                
               
       
        <?php }
        
        ?>
        </table>

    </div>
    
</div>


