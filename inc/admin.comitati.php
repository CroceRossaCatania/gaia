<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>
<?php if ( isset($_GET['new']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Comitato aggiunto</strong>.
            Il Comitato è stato aggiunto con successo.
        </div>
<?php } elseif ( isset($_GET['del']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Comitato cancellato</h4>
            <p>Il Comitato è stato cancellato con successo.</p>
        </div>
<?php } ?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
    <br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-group muted"></i>
            Elenco Comitati
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Comitato..." type="text">
        </div>
    </div>  
    <br/>  
    <div class="span4 allinea-destra">
        <a class="btn btn-success" href="?p=admin.comitato.nuovo">
                <i class="icon-plus"></i> Aggiungi Comitato
                </a>
    </div> 
</div>
  
<hr />
    
<div class="row-fluid">
   <div class="span12">
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Nome</th>
                <th>Azioni</th>
            </thead>
        <?php
       foreach(Comitato::elenco('nome ASC') as $c){
                ?>
                  <tr>
                    <td><?php echo $c->nome; ?></td>
                    <td class="btn-group">
                        <a class="btn btn-small" href="?p=&id=<?php echo $c->id; ?>" title="Dettagli">
                            <i class="icon-eye-open"></i> Dettagli
                        </a>            
                        <a  onClick="return confirm('Vuoi veramente cancellare questo comitato ?');" href="?p=&id=<?php echo $c->id; ?>" title="Cancella Utente" class="btn btn-small btn-warning">
                            <i class="icon-trash"></i> Cancella
                        </a>
                   </td>
                </tr>
                
               
       
        <?php }
        
        ?>
        </table>

    </div>
    
</div>


